<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment',
    ];

    public function photo()
    {
        return $this->belongsTo(DogPhoto::class);
    }
}
