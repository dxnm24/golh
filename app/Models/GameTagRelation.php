<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameTagRelation extends Model
{
    protected $fillable = [
        'game_id', 'tag_id',
    ];
    public function game() 
    {
        return $this->belongsTo('App\Models\Game', 'game_id', 'id');
    }
    public function gametag() 
    {
        return $this->belongsTo('App\Models\GameTag', 'tag_id', 'id');
    }
}
