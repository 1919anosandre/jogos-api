<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['game_id', 'author', 'content', 'rating'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
