<?php

namespace App\Services;

use App\Models\BalanceHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class BalanceHistoryService
{
    /**
     * Record multiple balance snapshots for a user.
     */
    public function recordSnapshots(User $user, array $snapshots, string $reason = 'auto_snapshot', array $metadata = []): void
    {
        foreach ($snapshots as $type => $amount) {
            $this->record($user, $type, (float) $amount, $reason, $metadata);
        }
    }

    /**
     * Record a single balance change for the user.
     */
    public function record(User $user, string $type, float $newAmount, string $reason = 'auto_snapshot', array $metadata = []): ?BalanceHistory
    {
        $type = strtolower($type);
        $newAmount = round($newAmount, 2);
        $latest = $user->balanceHistories()
            ->where('type', $type)
            ->latest('created_at')
            ->first();

        if ($latest && round($latest->new_amount, 2) === $newAmount) {
            return null;
        }

        $previousAmount = $latest?->new_amount ?? $newAmount;
        $delta = round($newAmount - $previousAmount, 2);

        return BalanceHistory::create([
            'user_id' => $user->id,
            'type' => $type,
            'previous_amount' => $previousAmount,
            'new_amount' => $newAmount,
            'delta' => $delta,
            'reason' => $reason,
            'metadata' => Arr::wrap($metadata),
        ]);
    }

    /**
     * Fetch a condensed dataset for charting.
     */
    public function getHistorySeries(User $user, string $type, \DateTimeInterface $start): array
    {
        $type = strtolower($type);
        $start = Carbon::instance($start);

        $entries = $user->balanceHistories()
            ->where('type', $type)
            ->where('created_at', '>=', $start)
            ->orderBy('created_at')
            ->get();

        $series = collect();

        $preceding = $user->balanceHistories()
            ->where('type', $type)
            ->where('created_at', '<', $start)
            ->orderByDesc('created_at')
            ->first();

        if ($preceding) {
            $series->push([
                'timestamp' => $start->copy(),
                'value' => (float) $preceding->new_amount,
                'previous_value' => (float) $preceding->new_amount,
            ]);
        }

        foreach ($entries as $history) {
            $series->push([
                'timestamp' => $history->created_at,
                'value' => (float) $history->new_amount,
                'previous_value' => (float) ($history->previous_amount ?? $history->new_amount),
            ]);
        }

        return $series->toArray();
    }

    /**
     * Get the latest snapshots for quick comparisons.
     */
    public function getLatestSnapshots(User $user, string $type, int $limit = 2)
    {
        return $user->balanceHistories()
            ->where('type', strtolower($type))
            ->latest('created_at')
            ->take($limit)
            ->get();
    }

    /**
     * Get change over a time range (e.g., last 24h).
     */
    public function getRangeChange(User $user, string $type, \DateTimeInterface $start): array
    {
        $type = strtolower($type);
        $latest = $user->balanceHistories()
            ->where('type', $type)
            ->latest('created_at')
            ->first();

        if (!$latest) {
            return [
                'start' => 0,
                'end' => 0,
                'delta' => 0,
            ];
        }

        $startEntry = $user->balanceHistories()
            ->where('type', $type)
            ->where('created_at', '>=', $start)
            ->oldest('created_at')
            ->first();

        if (!$startEntry) {
            $startEntry = $user->balanceHistories()
                ->where('type', $type)
                ->where('created_at', '<', $start)
                ->latest('created_at')
                ->first();
        }

        $startValue = $startEntry?->previous_amount ?? $latest->previous_amount ?? $latest->new_amount;

        return [
            'start' => (float) $startValue,
            'end' => (float) $latest->new_amount,
            'delta' => (float) $latest->new_amount - (float) $startValue,
        ];
    }
}
