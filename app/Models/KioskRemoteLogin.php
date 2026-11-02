<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * A main administrator's request to sign a store's kiosk user in on a kiosk,
 * kept as the audit record. The kiosk receives a one-time token through its
 * logged-out heartbeat and exchanges it for a login (KioskRemoteLoginController).
 */
class KioskRemoteLogin extends Model
{
    public const STATUS_PENDING = 'pending';     // approved, waiting for the kiosk
    public const STATUS_DELIVERED = 'delivered'; // the kiosk received the one-time token
    public const STATUS_COMPLETED = 'completed'; // the kiosk signed in
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled'; // replaced by a newer request for the same kiosk
    public const STATUS_REJECTED = 'rejected';   // refused before a request was created

    /**
     * Minutes a request stays usable. The kiosk heartbeat runs every minute.
     */
    public const EXPIRY_MINUTES = 3;

    /**
     * The only role a remote login may ever sign in.
     */
    public const ALLOWED_ROLE = 'user';

    protected $fillable = [
        'kiosk_status_id',
        'kiosk_id',
        'store_id',
        'target_user_id',
        'approved_username',
        'verified_role',
        'requested_by',
        'status',
        'failure_reason',
        'token_hash',
        'kiosk_ip',
        'expires_at',
        'delivered_at',
        'completed_at',
    ];

    protected $hidden = [
        'token_hash',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function kiosk(): BelongsTo
    {
        return $this->belongsTo(KioskStatus::class, 'kiosk_status_id');
    }

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function isOpen(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_DELIVERED], true);
    }

    /**
     * Mark an open request expired once its time is up. Returns true when it changed.
     */
    public function expireIfDue(): bool
    {
        if ($this->isOpen() && $this->expires_at && $this->expires_at->isPast()) {
            $this->forceFill([
                'status' => self::STATUS_EXPIRED,
                'failure_reason' => 'The kiosk did not complete the login in time.',
                'token_hash' => null,
            ])->save();

            return true;
        }

        return false;
    }

    public function fail(string $reason): void
    {
        $this->forceFill([
            'status' => self::STATUS_FAILED,
            'failure_reason' => $reason,
            'token_hash' => null,
            'completed_at' => now(),
        ])->save();
    }

    /**
     * Hand the kiosk a fresh one-time token for its open request, if it has one.
     * Called only from a logged-out heartbeat whose device key matched the kiosk.
     * A new token replaces any earlier one, so a kiosk that lost the previous
     * response (network drop) can still finish, while the old token stops working.
     *
     * @return array{id: int, token: string}|null
     */
    public static function deliverTo(KioskStatus $kiosk, ?string $ip): ?array
    {
        $request = self::where('kiosk_status_id', $kiosk->id)
            ->whereIn('status', [self::STATUS_PENDING, self::STATUS_DELIVERED])
            ->latest('id')
            ->first();

        if (!$request || $request->expireIfDue()) {
            return null;
        }

        if ($request->kiosk_id !== $kiosk->kiosk_id || (int) $request->store_id !== (int) $kiosk->store_id) {
            $request->fail('The kiosk no longer matches the request.');

            return null;
        }

        $token = Str::random(64);

        $request->forceFill([
            'status' => self::STATUS_DELIVERED,
            'token_hash' => hash('sha256', $token),
            'delivered_at' => now(),
            'kiosk_ip' => $ip,
        ])->save();

        return ['id' => $request->id, 'token' => $token];
    }
}
