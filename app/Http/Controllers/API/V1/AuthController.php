<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Route;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{
    public function getTokenUrl()
    {
        $baseUrl = env("APP_URL") . "/oauth/token";
        $baseUrl = "/oauth/token";
        return $baseUrl;
    }
    public function token(Request $request)
    {
        $responseResult = [
            'message' => 'Fail'
        ];
        request()->request->add([
            'grant_type'    => 'password',
            'client_id'     => env('OAUTH_PASSWORD_GRANT_CLIENT_ID'),
            'client_secret' => env('OAUTH_PASSWORD_GRANT_CLIENT_SECRET'),
            'username' => request()->email,
            'password' => request()->password,
            'scope'         => '*'
        ]);

        $oauth2 = Request::create('/oauth/token', 'post');
        $response = Route::dispatch($oauth2);

        $res = json_decode($response->getContent(), true);
        if ($response->status() !== 200) {
            return response($responseResult, 400);
        }
        $responseResult['message'] = 'Success';
        $responseResult['token_type'] = $res['token_type'];
        $responseResult['access_token'] = $res['access_token'];
        $responseResult['expires_in'] = $res['expires_in'];
        $responseResult['refresh_token'] = $res['refresh_token'];
        $responseResult['user'] = User::where('email',request()->username)->first();
        return response($responseResult, 200);

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
        $responseResult = [
            'message' => 'Fail'
        ];
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
        if ($response->status() !== 200) {
            return response($responseResult, 400);
        }
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
    public function register(Request $request)
    {
        $data = $request->validate([
            'avatar'   => ['image'],
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);
        try {

            $user = User::create($data);
        } catch (\Throwable $th) {
            info($th->getMessage());
            return response(['message' => 'Fail'], Response::HTTP_BAD_REQUEST);
        }
        if ($request->hasFile('avatar')) {
            $user
                ->addMedia($request->file('avatar'))
                ->toMediaCollection('avatar');
        }

        return response($user->load('media'), Response::HTTP_CREATED);
    }
}
