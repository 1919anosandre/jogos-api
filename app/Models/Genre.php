<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Game;

class Genre extends Model
{
    protected $fillable = ['name'];

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }
}
