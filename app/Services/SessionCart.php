<?php

namespace App\Services;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * The cart of the current browser session, stored in the session_carts table.
 *
 * A page sends several requests at once (the cart click, the click analytics, the
 * kiosk heartbeat). Each of them saves the whole session when it finishes, so a cart
 * kept only in the session could be overwritten by a request that started earlier.
 * Here every change locks the cart's row, applies the change to the latest saved cart
 * and writes it back, so no change is lost whatever the server's session settings.
 *
 * session('cart') still holds a copy for the pages that read it: SyncSessionCart fills
 * it at the start of every request, and update() refreshes it after a change.
 * Without the table (migration not run yet) the cart simply stays in the session.
 */
class SessionCart
{
    /** Carts untouched for this many days are removed now and then */
    private const PRUNE_AFTER_DAYS = 7;

    /**
     * The saved cart, or null when this session has none yet (or the table is missing).
     */
    public static function stored(): ?array
    {
        try {
            $items = DB::table('session_carts')->where('session_id', session()->getId())->value('items');
        } catch (QueryException $e) {
            return null;
        }

        return $items === null ? null : self::decode($items);
    }

    public static function items(): array
    {
        return self::stored() ?? session('cart', []);
    }

    /**
     * Apply $change (current items => new items) to the latest cart and save it.
     */
    public static function update(callable $change): array
    {
        $session = session();

        try {
            $items = DB::transaction(function () use ($session, $change) {
                $row = self::lockedRow($session->getId());
                if (!$row) {
                    // First change in this session: start from the cart the session already has
                    DB::table('session_carts')->insertOrIgnore([
                        'session_id' => $session->getId(),
                        'user_id' => auth()->id(),
                        'items' => json_encode(array_values($session->get('cart', []))),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $row = self::lockedRow($session->getId());
                }

                $items = array_values($change(self::decode($row->items)));

                DB::table('session_carts')->where('id', $row->id)->update([
                    'user_id' => auth()->id(),
                    'items' => json_encode($items),
                    'updated_at' => now(),
                ]);

                return $items;
            }, 3);
        } catch (QueryException $e) {
            Log::warning('Cart kept in the session only: ' . $e->getMessage());
            $items = array_values($change($session->get('cart', [])));
        }

        $session->put('cart', $items);
        self::pruneSometimes();

        return $items;
    }

    public static function clear(): void
    {
        self::update(fn () => []);
    }

    public static function count(array $items): int
    {
        return (int) collect($items)->sum('quantity');
    }

    private static function lockedRow(string $sessionId): ?object
    {
        return DB::table('session_carts')->where('session_id', $sessionId)->lockForUpdate()->first();
    }

    private static function decode(?string $items): array
    {
        $decoded = json_decode((string) $items, true);

        return is_array($decoded) ? $decoded : [];
    }

    private static function pruneSometimes(): void
    {
        if (random_int(1, 100) !== 1) {
            return;
        }

        try {
            DB::table('session_carts')->where('updated_at', '<', now()->subDays(self::PRUNE_AFTER_DAYS))->delete();
        } catch (QueryException $e) {
            // Nothing to prune without the table
        }
    }
}
