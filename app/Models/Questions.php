<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Questions extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_question';
    protected $fillable = [
        'text_question',
        'test_id'
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(
            Answers::class,
            'question_id',
            'id_question');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(
            Tests::class,
            'test_id',
            'id_test');
    }
}
