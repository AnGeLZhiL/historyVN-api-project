<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_category';

    public function images() : BelongsTo{
        return $this->belongsTo(Images::class, 'image_id', 'id_image');
    }
}
