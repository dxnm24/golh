<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameTypeRelation extends Model
{
    protected $fillable = [
        'game_id', 'type_id',
    ];
    public function game() 
    {
        return $this->belongsTo('App\Models\Game', 'game_id', 'id');
    }
    public function gametype() 
    {
        return $this->belongsTo('App\Models\GameType', 'type_id', 'id');
    }
}
