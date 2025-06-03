<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Review;

class Game extends Model
{
    protected $fillable = ['title', 'description', 'genre_id'];


    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
