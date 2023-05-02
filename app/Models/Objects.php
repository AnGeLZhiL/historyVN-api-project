<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Objects extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_object';

    public function tests() : BelongsToMany
    {
        return $this->belongsToMany(
            Tests::class,
            'object_test',
            'object_id',
            'test_id'
        );
    }
}
