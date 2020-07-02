<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'cover',
    ];


    public function getCoverUrlAttribute()
    {
        return Storage::url($this->cover);
    }
}
