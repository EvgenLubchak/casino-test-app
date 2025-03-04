<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Services\LinkService;
use App\Http\Services\UserService;

class RegistrationController extends Controller
{

    /**
     * @param UserService $userService
     * @param LinkService $linkService
     */
    public function __construct(
        private readonly UserService $userService,
        private readonly LinkService $linkService
    ){}

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('register');
    }

    /**
     * Handles the user registration process.
     *
     * @param RegisterRequest $request The request containing registration data.
     * @return \Illuminate\Http\RedirectResponse Redirects to the generated URL with a success message.
     */
    public function register(RegisterRequest $request)
    {
        $validate = $request->validated();
        $user = $this->userService->create($validate['username'], $validate['phone']);
        $url = $this->linkService->createLink($user->id);
        return redirect($url)
            ->with('success', 'You are registered successfully!');
    }
}
