<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Services\LinkService;

class CheckTemporaryLink
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
        $token = $request->route('token');
        $temporaryLink = $this->linkService->getLink($token);
        if (!$temporaryLink || !$temporaryLink->isValid()) {
            return response()->json(['message' => 'Page not exist.'], 403);
        }
        return $next($request);
    }
}
