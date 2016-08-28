<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
	use SoftDeletes;
	//type: game flash or html5...
	//url: link direct to game (play or download)
    protected $fillable = [
        'name', 'slug', 'type_main_id', 'seri', 'related', 'type', 'url', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image', 'width', 'height', 'screen', 'play', 'position', 'start_date', 'view', 'status', 'lang',
    ];
    public function gametyperelations()
    {
        return $this->hasMany('App\Models\GameTypeRelation', 'game_id', 'id');
    }
    public function gametypes()
    {
        return $this->belongsToMany('App\Models\GameType', 'game_type_relations', 'game_id', 'type_id');
    }
    public function gametagrelations()
    {
        return $this->hasMany('App\Models\GameTagRelation', 'game_id', 'id');
    }
    public function gametags()
    {
        return $this->belongsToMany('App\Models\GameTag', 'game_tag_relations', 'game_id', 'tag_id');
    }
}
