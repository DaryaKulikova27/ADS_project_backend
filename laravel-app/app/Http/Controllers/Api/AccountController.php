<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'login' => 'required|string|unique:users,login',
            'password' => 'required|string|min:8',
        ]);

        $login = $request->login;

        // Проверяем, существует ли пользователь с таким email
        $existingUser = User::where('login', $login)->first();

        if ($existingUser) {
            return response()->json(['error' => 'Пользователь с таким login уже существует.'], 409);
        }

        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'token' => null,
            'role' => 1
        ]);

        $token = $user->createToken('auth_token');
        $user->token = $token;

        // отправка токена в ответе
        return response()->json([
            'access_token' => $token,
            'successful_register' => true
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('login', 'password');

        if (!User::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = $request->user();

        $token = $user->createToken('auth_token');
        $user->token = $token;

        return response()->json([
            'access_token' => $token
        ]);
    }
}
