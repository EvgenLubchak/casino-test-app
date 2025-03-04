<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinkRequest;
use App\Http\Services\LinkService;
use Illuminate\Http\Request;
use App\Http\Requests\DeactivateRequest;

class TemporaryPageController extends Controller
{
    /**
     * @param LinkService $linkService
     */
    public function __construct(
        private readonly LinkService $linkService
    ) {}

    /**
     * Display the temporary page associated with the given token.
     *
     * @param string $token
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $token)
    {
        $temporaryLink = $this->linkService->getLink($token);

        return view('temporary-page', [
            'user' => $temporaryLink->user,
            'link' => $temporaryLink,
        ]);
    }

    /**
     * Handles the creation of a link.
     *
     * @param CreateLinkRequest $request The request containing data necessary to create a link.
     * @return \Illuminate\Http\RedirectResponse Redirects back with a success message containing the created link.
     */
    public function createLink(CreateLinkRequest $request)
    {
        $validated = $request->validated();
        $url = $this->linkService->createLink($validated['user_id']);

        return redirect()->back()->with('successCreateLink', $url);
    }

    /**
     * Handles the deactivation of a link.
     *
     * @param Request $request The HTTP request containing the deactivation token.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivate(DeactivateRequest $request)
    {
        $success = $this->linkService->deactivateLink($request->get('token'));

        if (!$success) {
            return redirect()->back()->with('error', 'Failed to deactivate link');
        }

        return redirect()->back()->with('successDeactivateLink', true);
    }
}
