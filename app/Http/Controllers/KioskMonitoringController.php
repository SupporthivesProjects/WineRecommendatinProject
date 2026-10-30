<?php

namespace App\Http\Controllers;

use App\Models\KioskStatus;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Store;



class KioskMonitoringController extends Controller
{
    /**
     * A kiosk is online when a heartbeat arrived within this many minutes.
     */
    public const ONLINE_MINUTES = 5;

    /**
     * An offline kiosk not seen for this many days counts as stale and may be removed.
     */
    public const STALE_DAYS = 7;

    /**
     * Create or update the kiosk row for a logged-in user's heartbeat.
     * Returns null when the device key already belongs to another store.
     */
    private function recordAuthenticatedHeartbeat(string $kioskId, int $storeId, int $userId, ?string $ip): ?KioskStatus
    {
        $kiosk = KioskStatus::firstOrNew([
            'kiosk_id' => $kioskId,
        ]);

        if ($kiosk->exists && (int) $kiosk->store_id !== $storeId) {
            return null;
        }

        $previousUserId = $kiosk->user_id;

        $kiosk->store_id = $storeId;
        $kiosk->user_id = $userId;
        $kiosk->ip_address = $ip;
        $kiosk->last_seen_at = now();

        if (
            !$kiosk->exists ||
            (int) $previousUserId !== $userId
        ) {
            $kiosk->logged_in_at = now();
        }

        $kiosk->logged_out_at = null;
        $kiosk->save();

        return $kiosk;
    }

    /**
     * Current CSRF token, so the heartbeat can recover after its session expired.
     */
    public function token(): JsonResponse
    {
        return response()->json(['token' => csrf_token()]);
    }

    /**
     * Record a heartbeat from an authenticated kiosk session.
     */
    
    public function heartbeat(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'device_key' => ['required', 'string', 'regex:/^[a-f0-9-]{36}$/i'],
            'kiosk_id' => ['nullable', 'string', 'max:100'],
        ]);

        $user = $request->user();
        $deviceKey = strtolower($request->input('device_key'));

        /*
        |--------------------------------------------------------------------------
        | Authenticated heartbeat
        |--------------------------------------------------------------------------
        */
        if ($user && $user->store_id) {
            $storeId = $user->store_id;
            $kioskId = $storeId . '-K-' . $deviceKey;

            try {
                $kiosk = $this->recordAuthenticatedHeartbeat($kioskId, (int) $storeId, (int) $user->id, $request->ip());
            } catch (UniqueConstraintViolationException $e) {
                // Two tabs registered this device at the same moment; the row exists now, so update it
                $kiosk = $this->recordAuthenticatedHeartbeat($kioskId, (int) $storeId, (int) $user->id, $request->ip());
            }

            if ($kiosk === null) {
                return response()->json([
                    'status' => 'invalid_device',
                ], 403);
            }

            return response()->json([
                'status' => 'active',
                'kiosk_id' => $kiosk->kiosk_id,
                'store_id' => $kiosk->store_id,
                'logged_in' => true,
                'last_seen_at' => $kiosk->last_seen_at->toIso8601String(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Guest heartbeat: update existing kiosk only
        |--------------------------------------------------------------------------
        */
        $kioskId = $request->input('kiosk_id');

        if (!$kioskId) {
            return response()->json([
                'status' => 'unregistered_guest',
            ]);
        }

        $kiosk = \App\Models\KioskStatus::where('kiosk_id', $kioskId)
            ->where('kiosk_id', 'like', '%-K-' . $deviceKey)
            ->first();

        if (!$kiosk) {
            return response()->json([
                'status' => 'unregistered_guest',
            ]);
        }

        if ($kiosk->user_id !== null) {
            $kiosk->logged_out_at = now();
        }

        $kiosk->user_id = null;
        $kiosk->ip_address = $request->ip();
        $kiosk->last_seen_at = now();
        $kiosk->save();

        return response()->json([
            'status' => 'active',
            'kiosk_id' => $kiosk->kiosk_id,
            'store_id' => $kiosk->store_id,
            'logged_in' => false,
            'last_seen_at' => $kiosk->last_seen_at->toIso8601String(),
        ]);
    }


    // public function heartbeat(Request $request): \Illuminate\Http\JsonResponse
    // {
    //     $request->validate([
    //         'device_key' => ['required', 'string', 'regex:/^[a-f0-9-]{36}$/i'],
    //         'kiosk_id' => ['nullable', 'string', 'max:100'],
    //     ]);

    //     $user = $request->user();

    //     $deviceKey = strtolower($request->input('device_key'));
    //     $kiosk = null;

    //     if ($user && $user->store_id) {
    //         // The authenticated account determines the store.
    //         $storeId = $user->store_id;

    //         $kioskId = $storeId . '-K-' . $deviceKey;

    //         $kiosk = \App\Models\KioskStatus::firstOrNew([
    //             'kiosk_id' => $kioskId,
    //         ]);

    //         if ($kiosk->exists && (int) $kiosk->store_id !== (int) $storeId) {
    //             return response()->json(['status' => 'invalid_device'], 403);
    //         }

    //         $previousUserId = $kiosk->user_id;

    //         $kiosk->store_id = $storeId;
    //         $kiosk->user_id = $user->id;
    //         $kiosk->ip_address = $request->ip();
    //         $kiosk->last_seen_at = now();

    //         if (!$kiosk->exists || $previousUserId !== $user->id) {
    //             $kiosk->logged_in_at = now();
    //         }

    //         $kiosk->save();

    //         return response()->json([
    //             'status' => 'active',
    //             'kiosk_id' => $kiosk->kiosk_id,
    //             'store_id' => $kiosk->store_id,
    //             'logged_in' => true,
    //             'last_seen_at' => $kiosk->last_seen_at->toIso8601String(),
    //         ]);
    //     }

    //     // A guest heartbeat can update an existing device only.
    //     // It cannot register a new kiosk or choose another store.
    //     $kioskId = $request->input('kiosk_id');

    //     if (!$kioskId) {
    //         return response()->json(['status' => 'unregistered_guest'], 200);
    //     }

    //     $kiosk = \App\Models\KioskStatus::where('kiosk_id', $kioskId)
    //         ->where('kiosk_id', 'like', '%-K-' . $deviceKey)
    //         ->first();

    //     if (!$kiosk) {
    //         return response()->json(['status' => 'unregistered_guest'], 200);
    //     }

    //     if ($kiosk->user_id !== null) {
    //         $kiosk->logged_out_at = now();
    //     }

    //     $kiosk->user_id = null;
    //     $kiosk->ip_address = $request->ip();
    //     $kiosk->last_seen_at = now();
    //     $kiosk->save();

    //     return response()->json([
    //         'status' => 'active',
    //         'kiosk_id' => $kiosk->kiosk_id,
    //         'store_id' => $kiosk->store_id,
    //         'logged_in' => false,
    //         'last_seen_at' => $kiosk->last_seen_at->toIso8601String(),
    //     ]);
    // }


    
    public function admindashboarddetails(Request $request)
    {
        // A kiosk is considered online if it sent a heartbeat
        // within the last 5 minutes.
        $cutoff = now()->subMinutes(self::ONLINE_MINUTES);

        // Offline kiosks not seen for a week can be removed from the list
        $staleCutoff = now()->subDays(self::STALE_DAYS);

        // Summary cards
        $totalStores = Store::count();

        $totalKiosks = KioskStatus::count();

        $onlineKiosks = KioskStatus::where(
            'last_seen_at',
            '>=',
            $cutoff
        )->count();

        $offlineKiosks = KioskStatus::where(function ($query) use ($cutoff) {
            $query->whereNull('last_seen_at')
                ->orWhere('last_seen_at', '<', $cutoff);
        })->count();

        // Fetch all registered kiosks with their related store and user.
        $kiosks = KioskStatus::with(['store', 'user'])
            ->orderByRaw('last_seen_at IS NULL DESC')
            ->orderBy('last_seen_at', 'desc')
            ->get();

        return view('admin.kiosk.kioskdashboard', compact(
            'totalStores',
            'totalKiosks',
            'onlineKiosks',
            'offlineKiosks',
            'kiosks',
            'cutoff',
            'staleCutoff'
        ));
    }

    /**
     * Give a kiosk a readable name (e.g. "Entrance tablet"). Empty clears it.
     */
    public function updateLabel(Request $request, KioskStatus $kiosk): JsonResponse
    {
        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:100'],
        ]);

        $kiosk->label = isset($validated['label']) && trim($validated['label']) !== ''
            ? trim($validated['label'])
            : null;
        $kiosk->save();

        return response()->json([
            'success' => true,
            'label' => $kiosk->label,
        ]);
    }

    /**
     * Remove a stale kiosk record. Kiosks seen within the last week are kept;
     * a removed kiosk is registered again automatically when a user logs in on it.
     */
    public function destroy(KioskStatus $kiosk): JsonResponse
    {
        $isStale = $kiosk->last_seen_at === null
            || $kiosk->last_seen_at->lt(now()->subDays(self::STALE_DAYS));

        if (!$isStale) {
            return response()->json([
                'success' => false,
                'message' => 'Only kiosks not seen for ' . self::STALE_DAYS . ' days can be removed.',
            ], 422);
        }

        $kiosk->delete();

        return response()->json(['success' => true]);
    }
}
