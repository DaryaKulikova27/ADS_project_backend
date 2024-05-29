<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'login',
        'password',
        'token',
        'role',
        'token_last_used_at',
        'name',
        'address'
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    function createUuidToken() {
        $uuid = \Illuminate\Support\Str::uuid();
        $token = hash('sha256', $uuid->toString());

        return $token;
    }

    public function createToken() {
        $this->token = $this->createUuidToken();
        $this->token_last_used_at = now();
        $this->save();
        return $this->token;
    }

    
}
