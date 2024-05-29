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
            'login' => 'required|string',
            'password' => 'required|string|min:8',
            'name' => 'required|string'
        ]);

        $login = $request->login;
        $existingUser = User::where('login', $login)->first();

        if ($existingUser) {
            return response()->json([
                'error_message' => 'User with this login already exists',
                'successful_register' => false            
            ]);
        }

        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'token' => null,
            'role' => 1, 
            'token_last_used_at' => NOW(),
            'name' => $request->name,
            'address' => $request->address
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
        $user = Auth::attempt($credentials);

        if (Auth::attempt($credentials)) {
            $user = Auth::user()->makeHidden(['id']);
            $token = $user->createToken('auth_token');
            $user->token = $token;
            return response()->json([
                'message' => 'Успешный вход', 
                'user' => $user,
                'access_token' => $token,
                'successful_login' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Неверные учетные данные',
                'successful_login' => false
        ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'User logged out successfully',
            'access_token' => $token
        ]);
    }
}
