<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_user_test';
    protected $fillable = [
        'test_id',
        'user_id',
        'passed',
        'mark'
    ];
}
