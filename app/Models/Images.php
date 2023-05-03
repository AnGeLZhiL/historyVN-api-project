<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Images extends Model
{
    use HasFactory;

    public function user() : HasOne{
        return $this->hasOne(User::class, 'image_id', 'id_image');
    }

    public function category() : HasOne{
        return $this->hasOne(User::class, 'image_id', 'id_image');
    }
}
