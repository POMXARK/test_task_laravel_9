<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{
    /**
     * Registration
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token], 201);
    }

    /**
     * Login
     * Авторизация: email или телефон (одно поле), пароль
     */
    public function login(Request $request): JsonResponse
    {
        if (auth()->attempt(['email' => $request->login,'password' => $request->password]) ||
            auth()->attempt(['phone' => $request->login,'password' => $request->password])
        ) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
