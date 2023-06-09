<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answers extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_answer';
    protected $fillable = [
        'text_answer',
        'question_id',
        'correctness'
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(
            Questions::class,
            'question_id',
            'id_question'
        );
    }
}
