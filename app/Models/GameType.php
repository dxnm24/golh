<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameType extends Model
{
	use SoftDeletes;
    protected $fillable = [
        'name', 'slug', 'parent_id', 'level', 'position', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image', 'limited', 'sort_by', 'home', 'type', 'grid', 'status', 'lang',
    ];
    public function gametyperelations()
    {
        return $this->hasMany('App\Models\GameTypeRelation', 'type_id', 'id');
    }
    public function games()
    {
        return $this->belongsToMany('App\Models\Game', 'game_type_relations', 'type_id', 'game_id');
    }
}
