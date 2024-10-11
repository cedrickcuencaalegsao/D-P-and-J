<?php

namespace App\Infrastructure\Persistence\Eloquent\User;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $fillable = ['id', 'roleID', 'name', 'email', 'password'];
}
