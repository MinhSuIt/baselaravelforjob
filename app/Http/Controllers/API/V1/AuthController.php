<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Route;
use Illuminate\Support\Facades\Http;

class AuthController
{
    public function getTokenUrl()
    {
        $baseUrl = env("APP_URL") . "/oauth/token";
        $baseUrl = "/oauth/token";
        return $baseUrl;
    }
    public function token()
    {
        request()->request->add([
            'grant_type'    => 'password',
            'client_id'     => env('OAUTH_PASSWORD_GRANT_CLIENT_ID'),
            'client_secret' => env('OAUTH_PASSWORD_GRANT_CLIENT_SECRET'),
            'username' => request()->username,
            'password' => request()->password,
            'scope'         => '*'
        ]);
        $oauth2 = Request::create('/oauth/token', 'post');
        $response = Route::dispatch($oauth2);
        $res = json_decode($response->getContent(), true);
        return response(Arr::only($res, ['token_type', 'expires_in', 'access_token', 'refresh_token']));
        // $response = Http::asForm()->post($this->getTokenUrl(), [
        //     'grant_type' => 'password',
        //     'client_id'     => env('OAUTH_PASSWORD_GRANT_CLIENT_ID'),
        //     'client_secret' => env('OAUTH_PASSWORD_GRANT_CLIENT_SECRET'),
        //     'username' => request()->username,
        //     'password' => request()->password,
        //     'scope' => '*',
        // ]);
        // return $response->json();
    }
    public function refreshToken()
    {
        request()->request->add([
            'grant_type'    => 'refresh_token',
            'client_id'     => env('OAUTH_PASSWORD_GRANT_CLIENT_ID'),
            'client_secret' => env('OAUTH_PASSWORD_GRANT_CLIENT_SECRET'),
            'refresh_token' => request()->refreshToken,
            'scope'         => '*'
        ]);
        $oauth2 = Request::create('/oauth/token', 'post');
        $response = Route::dispatch($oauth2);
        $res = json_decode($response->getContent(), true);
        return response(Arr::only($res, ['token_type', 'expires_in', 'access_token', 'refresh_token']));

        // $response = Http::asForm()->post($this->getTokenUrl(), [
        //     'grant_type' => 'refresh_token',
        //     'client_id' => env("PASSPORT_CLIENT_ID"),
        //     'client_secret' => 'PASSPORT_CLIENT_SECRET',
        //     // 'username' => 'minhsudoit@gmail.com',
        //     // 'password' => 'minhsudoit@gmail.com',
        //     'scope' => '*',
        // ]);
        // return $response->json();
    }
    public function register()
    {
        return "register";
    }
}
