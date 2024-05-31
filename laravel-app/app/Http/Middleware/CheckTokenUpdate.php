<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\BaseController;
use App\Models\User;

class CheckTokenUpdate
{
    public function handle($request, Closure $next)
    {
        // if (Auth::check()) {
        //     echo("i am here");
        //     $user = Auth::user();
        //     $lastUpdate = $user->last_update_token;

        //     if ($lastUpdate) {
        //         $currentTime = Carbon::now();
        //         $lastUpdateTime = Carbon::parse($lastUpdate);

        //         if ($currentTime->diffInHours($lastUpdateTime) > 24) {
        //             // Токен должен быть обновлен
        //             // Здесь вы можете добавить логику обновления токена или перенаправить пользователя
        //             return BaseController::sendError('Token expired. Please login again.', 301);
        //         }
        //     }
        // }

        $token_last_update = User::where('token',  $request->token)->first()->last_update_token;

        if ($token_last_update) {
            $currentTime = Carbon::now();
            $lastUpdateTime = Carbon::parse($token_last_update);

            if ($currentTime->diffInHours($lastUpdateTime) > 24) {
                // Токен должен быть обновлен
                // Здесь вы можете добавить логику обновления токена или перенаправить пользователя
                return BaseController::sendError('Token expired. Please login again.', 301);
            }
        }

        return $next($request);
        //return BaseController::sendError('Unauthorized user', 300);
    }
}