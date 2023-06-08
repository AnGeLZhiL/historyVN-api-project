<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tests extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_test';
    protected $fillable = [
        'name',
        'category_id'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(
            Questions::class,
            'test_id',
            'id_test'
        );
    }
}
