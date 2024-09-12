<?php

namespace Madco\AuthLogin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Madco\AuthLogin\Services\CustomAuthService;

class AuthLoginController extends Controller
{
    protected $authService;

    public function __construct(CustomAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function redirectToProvider()
    {
        return $this->authService->redirectToAuthProvider();
    }

    public function handleProviderCallback(Request $request)
    {
        $code = $request->input('code');
        if (!$code) {
            return redirect('/login')->withErrors(['error' => 'Authorization code not provided.']);
        }

        $tokenData = $this->authService->handleProviderCallback($code);

        if ($tokenData) {
            // Handle user login or store the token as needed
            // For example, you might log the user in or create a new user

            return redirect('/home')->with('status', 'Login successful!');
        }

        return redirect('/login')->withErrors(['error' => 'Failed to authenticate.']);
    }
}