<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $table = 'platforms'; // ou o nome correto da tabela no banco
    protected $fillable = ['name'];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_platform');
    }
}
