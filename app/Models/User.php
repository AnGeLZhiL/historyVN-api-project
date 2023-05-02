<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'last_name',
        'first_name',
        'midlle_name',
        'login',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function tests() : BelongsToMany {
        return $this->belongsToMany(
            Tests::class,
            'user_test',
            'user_id',
            'test_id'
        );
    }
}
