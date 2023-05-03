<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collection extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_collection';

    public function images() : BelongsTo{
        return $this->belongsTo(Images::class, 'image_id', 'id_image');
    }
}
