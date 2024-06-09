<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
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
            return BaseController::sendError();
        }

        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'token' => null,
            'role' => 1, 
            'executor_id' => null,
            'last_update_token' => NOW(),
            'name' => $request->name,
            'address' => $request->address
        ]);

        $token = $user->createToken('auth_token');
        $user->token = $token;

        // отправка токена в ответе
        return BaseController::sendResponse(["access_token" => $token], 'Successful create account!');
        
    }

    public function signIn(Request $request)
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
            return BaseController::sendResponse(["user" => $user, "access_token" => $token], 'Successful login!');
        } else {
            return BaseController::sendError('Неверные учетные данные');
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
