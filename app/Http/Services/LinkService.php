<?php

namespace App\Http\Services;

use App\Models\TemporaryLink;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class LinkService
{
    private const CACHE_PREFIX = 'temporary_link:';
    private const LINK_EXPIRY_DAYS = 7;
    private const CACHE_DURATION = 604800; // 7 days in seconds

    /**
     * Create a new temporary link for a user
     */
    public function createLink(int $userId): string
    {
        $token = $this->generateToken();
        $link = $this->storeLink($userId, $token);

        return $this->generateUrl($token);
    }

    /**
     * Get temporary link by token
     */
    public function getLink(string $token): ?TemporaryLink
    {
        return Cache::remember(
            $this->getCacheKey($token),
            self::CACHE_DURATION,
            fn () => $this->findLinkByToken($token)
        );
    }

    /**
     * Deactivate a temporary link
     */
    public function deactivateLink(string $token): bool
    {
        try {
            Cache::forget($this->getCacheKey($token));

            $link = $this->findLinkByToken($token);
            if (!$link) {
                return false;
            }

            $link->active = false;
            $link->save();

            return true;
        } catch (\Exception $e) {
            \Log::error('Error deactivating link', [
                'token' => $token,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Generate a secure random token
     */
    private function generateToken(): string
    {
        return Str::random(64);
    }

    /**
     * Store new temporary link in database
     */
    private function storeLink(int $userId, string $token): TemporaryLink
    {
        return TemporaryLink::create([
            'user_id' => $userId,
            'token' => $token,
            'expires_at' => Carbon::now()->addDays(self::LINK_EXPIRY_DAYS),
            'active' => true
        ]);
    }

    /**
     * Find link by token
     */
    private function findLinkByToken(string $token): ?TemporaryLink
    {
        return TemporaryLink::where('token', $token)->first();
    }

    /**
     * Generate cache key for token
     */
    private function getCacheKey(string $token): string
    {
        return self::CACHE_PREFIX . $token;
    }

    /**
     * Generate URL for token
     */
    private function generateUrl(string $token): string
    {
        return route('temporary.page', ['token' => $token]);
    }
}
