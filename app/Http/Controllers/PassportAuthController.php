<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;

class PassportAuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' =>  ['required', 'confirmed','regex:/([a-zA-Z0-9]*)([$%&!:]{1,})([a-zA-Z0-9]*)/u', Password::min(6)->mixedCase()],
            'phone' => 'required|unique:users|regex:/^[\+]7{1}?[-\s\.]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{2}[-\s\.]?[0-9]{2}$/u',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Login
     * Авторизация: email или телефон (одно поле), пароль
     */
    public function login(Request $request)
    {
        if (auth()->attempt(['email' => $request->email,'password' => $request->password]) ||
            auth()->attempt(['phone' => $request->email,'password' => $request->password])
        ) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
