<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnforceLoginExpiry;
use App\Models\KioskRemoteLogin;
use App\Models\KioskStatus;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Remote login for kiosks, for the main administrator only.
 *
 * 1. The admin opens a kiosk and sees its store's eligible accounts (role exactly "user").
 * 2. The admin types the username to confirm; the server re-checks everything and
 *    stores a short-lived request (no token yet, nothing sent to any device).
 * 3. The kiosk's next logged-out heartbeat (which must carry the kiosk's own device key)
 *    receives a one-time token (KioskRemoteLogin::deliverTo).
 * 4. The kiosk posts the token back here; after every check passes again, that browser
 *    is signed in exactly like a normal login and the request is used up.
 *
 * No passwords are read, shown or sent. Every attempt is recorded in kiosk_remote_logins.
 */
class KioskRemoteLoginController extends Controller
{
    /**
     * Only the main administrator (role exactly "admin") may use remote login.
     * Sub-admins pass the admin middleware, so this is checked here as well.
     */
    private function ensureMainAdmin(Request $request): void
    {
        $user = $request->user();

        if (!$user || $user->role !== 'admin') {
            Log::warning('Kiosk remote login refused: not the main administrator', [
                'user_id' => $user?->id,
                'role' => $user?->role,
                'path' => $request->path(),
            ]);

            abort(403, 'Only the main administrator can use remote login.');
        }
    }

    private function isOnline(KioskStatus $kiosk): bool
    {
        return $kiosk->last_seen_at !== null
            && $kiosk->last_seen_at->gte(now()->subMinutes(KioskMonitoringController::ONLINE_MINUTES));
    }

    /**
     * Accounts that may be signed in on this kiosk: same store, role exactly "user", active.
     * Never falls back to any other account.
     */
    private function eligibleUsers(KioskStatus $kiosk)
    {
        return User::where('store_id', $kiosk->store_id)
            ->where('role', KioskRemoteLogin::ALLOWED_ROLE)
            ->where('status', 'active')
            ->orderBy('email')
            ->get()
            // Exact comparison in PHP too, so a database collation can never widen the match
            ->filter(fn (User $user) => $user->role === KioskRemoteLogin::ALLOWED_ROLE
                && (int) $user->store_id === (int) $kiosk->store_id)
            ->values();
    }

    private function userSummary(User $user): array
    {
        return [
            'id' => $user->id,
            'username' => $user->email,
            'name' => trim($user->first_name . ' ' . $user->last_name),
            'role' => $user->role,
        ];
    }

    private function requestSummary(KioskRemoteLogin $remoteLogin): array
    {
        return [
            'id' => $remoteLogin->id,
            'status' => $remoteLogin->status,
            'failure_reason' => $remoteLogin->failure_reason,
            'approved_username' => $remoteLogin->approved_username,
            'expires_at' => $remoteLogin->expires_at?->toIso8601String(),
            'delivered_at' => $remoteLogin->delivered_at?->toIso8601String(),
            'completed_at' => $remoteLogin->completed_at?->toIso8601String(),
        ];
    }

    /**
     * Stage A: what the confirmation screen shows for a kiosk.
     */
    public function show(Request $request, KioskStatus $kiosk): JsonResponse
    {
        $this->ensureMainAdmin($request);

        $kiosk->loadMissing(['store', 'user']);

        return response()->json([
            'kiosk' => [
                'id' => $kiosk->id,
                'kiosk_id' => $kiosk->kiosk_id,
                'label' => $kiosk->label,
                'store_id' => $kiosk->store_id,
                'store_name' => $kiosk->store->store_name ?? null,
                'online' => $this->isOnline($kiosk),
                'logged_in_username' => $kiosk->user?->email,
            ],
            'eligible_users' => $this->eligibleUsers($kiosk)->map(fn (User $user) => $this->userSummary($user)),
            'expiry_minutes' => KioskRemoteLogin::EXPIRY_MINUTES,
        ]);
    }

    /**
     * Stage B: the admin approved a username. Re-check everything, then create the request.
     */
    public function store(Request $request, KioskStatus $kiosk): JsonResponse
    {
        $this->ensureMainAdmin($request);

        $validated = $request->validate([
            'user_id' => ['required', 'integer'],
            'approved_username' => ['required', 'string', 'max:255'],
            'confirm_username' => ['required', 'string', 'max:255'],
            'approved_role' => ['required', 'string', 'max:50'],
        ]);

        $kiosk->loadMissing('store');
        $target = User::find($validated['user_id']);

        $reject = function (string $reason, int $status = 422) use ($kiosk, $target, $validated, $request): JsonResponse {
            KioskRemoteLogin::create([
                'kiosk_status_id' => $kiosk->id,
                'kiosk_id' => $kiosk->kiosk_id,
                'store_id' => $kiosk->store_id,
                'target_user_id' => $target?->id,
                'approved_username' => $validated['approved_username'],
                'verified_role' => $target?->role,
                'requested_by' => $request->user()->id,
                'status' => KioskRemoteLogin::STATUS_REJECTED,
                'failure_reason' => $reason,
                'completed_at' => now(),
            ]);

            return response()->json(['success' => false, 'message' => $reason], $status);
        };

        // The typed confirmation must match the username shown on the confirmation screen
        if (trim($validated['confirm_username']) !== $validated['approved_username']) {
            return $reject('The typed username does not match the username shown.');
        }

        if (!$target) {
            return $reject('The selected account no longer exists.');
        }

        if ($target->role !== KioskRemoteLogin::ALLOWED_ROLE || $validated['approved_role'] !== KioskRemoteLogin::ALLOWED_ROLE) {
            return $reject('Only accounts with the role "user" can be signed in remotely.', 403);
        }

        if ((int) $target->store_id !== (int) $kiosk->store_id) {
            return $reject('The selected account does not belong to this kiosk\'s store.', 403);
        }

        if ($target->status !== 'active') {
            return $reject('The selected account is not active.');
        }

        if ($target->email !== $validated['approved_username']) {
            return $reject('The account\'s username changed after it was shown. Open remote login again.');
        }

        if (!$this->isOnline($kiosk)) {
            return $reject('Kiosk offline: it has not reported in the last ' . KioskMonitoringController::ONLINE_MINUTES . ' minutes.');
        }

        if ($kiosk->user_id !== null) {
            return $reject((int) $kiosk->user_id === (int) $target->id
                ? 'This user is already signed in on the kiosk.'
                : 'Another user is signed in on this kiosk. Sign them out on the kiosk first.');
        }

        $remoteLogin = DB::transaction(function () use ($kiosk, $target, $request) {
            // Only one open request per kiosk: a new approval replaces the old one
            KioskRemoteLogin::where('kiosk_status_id', $kiosk->id)
                ->whereIn('status', [KioskRemoteLogin::STATUS_PENDING, KioskRemoteLogin::STATUS_DELIVERED])
                ->update([
                    'status' => KioskRemoteLogin::STATUS_CANCELLED,
                    'failure_reason' => 'Replaced by a newer request.',
                    'token_hash' => null,
                    'completed_at' => now(),
                    'updated_at' => now(),
                ]);

            return KioskRemoteLogin::create([
                'kiosk_status_id' => $kiosk->id,
                'kiosk_id' => $kiosk->kiosk_id,
                'store_id' => $kiosk->store_id,
                'target_user_id' => $target->id,
                'approved_username' => $target->email,
                'verified_role' => $target->role,
                'requested_by' => $request->user()->id,
                'status' => KioskRemoteLogin::STATUS_PENDING,
                'expires_at' => now()->addMinutes(KioskRemoteLogin::EXPIRY_MINUTES),
            ]);
        });

        return response()->json([
            'success' => true,
            'request' => $this->requestSummary($remoteLogin),
        ], 201);
    }

    /**
     * Current state of a request, for the admin's status dialog.
     */
    public function status(Request $request, KioskRemoteLogin $remoteLogin): JsonResponse
    {
        $this->ensureMainAdmin($request);

        $remoteLogin->expireIfDue();

        return response()->json(['request' => $this->requestSummary($remoteLogin->fresh())]);
    }

    /**
     * Stage C: the kiosk exchanges its one-time token for a login.
     */
    public function complete(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'request_id' => ['required', 'integer'],
            'token' => ['required', 'string', 'size:64'],
            'device_key' => ['required', 'string', 'regex:/^[a-f0-9-]{36}$/i'],
            'kiosk_id' => ['required', 'string', 'max:100'],
        ]);

        $deviceKey = strtolower($validated['device_key']);
        $refused = fn (string $message, int $status = 403) => response()->json(['success' => false, 'message' => $message], $status);

        $result = DB::transaction(function () use ($validated, $deviceKey, $request, $refused) {
            $remoteLogin = KioskRemoteLogin::whereKey($validated['request_id'])->lockForUpdate()->first();

            // Unknown, used or replaced requests: refuse without changing anything
            if (!$remoteLogin || $remoteLogin->status !== KioskRemoteLogin::STATUS_DELIVERED || !$remoteLogin->token_hash) {
                return $refused('This login request is no longer valid.', 410);
            }

            if ($remoteLogin->expireIfDue()) {
                return $refused('This login request has expired.', 410);
            }

            // A wrong token does not use up the request, so guessing cannot cancel a real one
            if (!hash_equals($remoteLogin->token_hash, hash('sha256', $validated['token']))) {
                Log::warning('Kiosk remote login: wrong token', ['request_id' => $remoteLogin->id, 'ip' => $request->ip()]);

                return $refused('This login request is no longer valid.');
            }

            // The token is valid from here on; any failed check uses it up
            $kiosk = KioskStatus::find($remoteLogin->kiosk_status_id);

            if (
                !$kiosk
                || $kiosk->kiosk_id !== $remoteLogin->kiosk_id
                || $validated['kiosk_id'] !== $remoteLogin->kiosk_id
                || !str_ends_with($kiosk->kiosk_id, '-K-' . $deviceKey)
                || (int) $kiosk->store_id !== (int) $remoteLogin->store_id
            ) {
                $remoteLogin->fail('Kiosk identity mismatch.');

                return $refused('This device is not the kiosk the request was made for.');
            }

            if (Auth::check()) {
                $remoteLogin->fail('A user was already signed in on the kiosk.');

                return $refused('A user is already signed in on this kiosk.', 409);
            }

            $requester = User::find($remoteLogin->requested_by);
            if (!$requester || $requester->role !== 'admin') {
                $remoteLogin->fail('The approving administrator is no longer a main administrator.');

                return $refused('This login request is no longer approved.');
            }

            // Re-read the account: it must still be the same active "user" of the same store
            $user = User::find($remoteLogin->target_user_id);

            if (!$user) {
                $remoteLogin->fail('The account no longer exists.');

                return $refused('The account is no longer available.');
            }

            if ($user->role !== KioskRemoteLogin::ALLOWED_ROLE) {
                $remoteLogin->fail('The account\'s role is no longer "user" (now "' . $user->role . '").');

                return $refused('The account is no longer allowed on this kiosk.');
            }

            if ((int) $user->store_id !== (int) $remoteLogin->store_id) {
                $remoteLogin->fail('The account no longer belongs to the kiosk\'s store.');

                return $refused('The account is no longer allowed on this kiosk.');
            }

            if ($user->email !== $remoteLogin->approved_username) {
                $remoteLogin->fail('The account\'s username changed after approval.');

                return $refused('The account changed after approval.');
            }

            if ($user->status !== 'active') {
                $remoteLogin->fail('The account is not active.');

                return $refused('The account is not active.');
            }

            // Same as a normal login: remembered for the 15-day window
            Auth::login($user, true);
            $request->session()->regenerate();
            EnforceLoginExpiry::start($request);

            $user->update([
                'previous_login_at' => $user->last_login_at,
                'last_login_at' => now(),
            ]);

            $remoteLogin->forceFill([
                'status' => KioskRemoteLogin::STATUS_COMPLETED,
                'token_hash' => null,
                'completed_at' => now(),
                'kiosk_ip' => $request->ip(),
            ])->save();

            return response()->json([
                'success' => true,
                'redirect' => route('user.dashboard'),
            ]);
        });

        return $result;
    }
}
