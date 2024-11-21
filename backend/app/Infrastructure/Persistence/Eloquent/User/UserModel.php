<?php

namespace App\Infrastructure\Persistence\Eloquent\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable implements JWTSubject
{
    use Notifiable, HasApiTokens;
    protected $table = 'users';

    protected $fillable = [
        'roleID',
        'first_name',
        'last_name',
        'email',
        'api_token',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // This method returns the unique identifier for the JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // This method returns any custom claims you want to include in the JWT
    public function getJWTCustomClaims()
    {
        return [];
    }

    // You may want to hash the password before saving to the database
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (isset($user->password)) {
                $user->password = bcrypt($user->password);
            }
        });
    }
}
