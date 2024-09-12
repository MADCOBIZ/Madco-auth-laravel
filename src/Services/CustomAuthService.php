<?php

namespace Madco\AuthLogin\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CustomAuthService
{
    protected $authUrl;
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;

    public function __construct()
    {
        $this->authUrl = config('authlogin.auth_url');
        $this->clientId = config('authlogin.client_id');
        $this->clientSecret = config('authlogin.client_secret');
        $this->redirectUri = config('authlogin.redirect_uri');
    }

    public function redirectToAuthProvider()
    {
        // Generate the URL to redirect the user to the external auth provider
        $queryParams = http_build_query([
            'client_id' => $this->clientId,
            'client_Secret' => $this->clientSecret,
        ]);

        return redirect("{$this->authUrl}?{$queryParams}");
    }

    public function handleProviderCallback($code)
    {
        // Exchange the authorization code for an access token
        $response = Http::asForm()->post($this->authUrl . '/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'code' => $code,
        ]);

        if ($response->successful()) {
            // Return the token data or handle user login with this token
            return $response->json();
        }

        return null;
    }
}