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

        $user = User::where('token',  $request->token)->first();

        if (isset($user->last_update_token) && $user->last_update_token !== null) {
            $currentTime = Carbon::now();
            $lastUpdateTime = Carbon::parse($user->last_update_token);

            if ($currentTime->diffInHours($lastUpdateTime) > 24) {
                return BaseController::sendError('Token expired. Please login again.', 301);
            }
        } else {
            return BaseController::sendError('Unauthorized user', 300);
        }

        return $next($request);
    }
}