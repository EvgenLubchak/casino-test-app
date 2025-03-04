<?php

namespace App\Http\Services;

use App\Models\LuckyDrawResult;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class LuckyService
{
    private const MIN_NUMBER = 1;
    private const MAX_NUMBER = 1000;

    private const PRIZE_TIERS = [
        900 => 0.7, // 70% of number for highest tier
        600 => 0.5, // 50% of number for high tier
        300 => 0.3, // 30% of number for medium tier
        0 => 0.1,   // 10% of number for base tier
    ];

    /**
     * Execute a lucky draw play for a user
     */
    public function play(int $linkId): array
    {
        try {
            $drawResult = $this->generateLuckyDraw();
            $this->saveResult($linkId, $drawResult);

            if ($drawResult['isWin']) {
                $this->logWin($linkId, $drawResult['prize']);
            }
            return $drawResult;
        } catch (\Exception $e) {
            Log::error('Lucky draw error: ' . $e->getMessage(), [
                'user_id' => $linkId,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Generate the lucky draw result
     */
    private function generateLuckyDraw(): array
    {
        $number = $this->generateRandomNumber();
        $isWin = $this->isWinningNumber($number);
        $prize = $this->calculatePrize($number, $isWin);

        return [
            'number' => $number,
            'isWin' => $isWin,
            'prize' => $prize
        ];
    }

    /**
     * Generate a biased random number
     */
    private function generateRandomNumber(): int
    {
        $winBias = Config::get('lucky-draw.win_bias', 49);
        $biasCheck = rand(1, 100);
        $number = rand(self::MIN_NUMBER, self::MAX_NUMBER);
        if ($biasCheck <= $winBias) {
            // Ensure even number (win)
            $number += ($number % 2);
        } else {
            // Ensure odd number (lose)
            $number += ($number % 2 ? 0 : 1);
        }
        return min(max($number, self::MIN_NUMBER), self::MAX_NUMBER);
    }

    /**
     * Determine if the number is a winning number
     */
    private function isWinningNumber(int $number): bool
    {
        return $number % 2 === 0;
    }

    /**
     * Calculate prize based on the number and win status
     */
    private function calculatePrize(int $number, bool $isWin): float
    {
        if (!$isWin) {
            return 0.0;
        }
        foreach (self::PRIZE_TIERS as $threshold => $multiplier) {
            if ($number > $threshold) {
                return round($number * $multiplier, 2);
            }
        }

        return 0.0;
    }

    /**
     * Save the draw result to database
     */
    private function saveResult(int $linkId, array $drawResult): void
    {
        LuckyDrawResult::create([
            'link_id' => $linkId,
            'number' => $drawResult['number'],
            'result' => $drawResult['isWin'] ? 'Win' : 'Lose',
            'prize' => $drawResult['prize'],
        ]);
    }

    /**
     * Log winning information
     */
    private function logWin(int $linkId, float $prize): void
    {
        Log::info('Lucky Draw Win', [
            'link_id' => $linkId,
            'prize' => $prize,
            'timestamp' => now()
        ]);
    }

    /**
     * Get last results for a user
     */
    public function getLastResults(int $linkId, int $limit = 3): array
    {
        return LuckyDrawResult::where('link_id', $linkId)
            ->latest()
            ->take($limit)
            ->get()
            ->toArray();
    }
}
