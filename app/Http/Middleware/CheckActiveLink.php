<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Services\LinkService;

class CheckActiveLink
{
    public function __construct(
        private readonly LinkService $linkService
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->get('token');
        $temporaryLink = $this->linkService->getLink($token);
        if (!$temporaryLink || !$temporaryLink->active) {
            return response()->json(['message' => 'link not active.'], 403);
        }
        return $next($request);
    }
}
