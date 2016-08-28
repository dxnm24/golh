<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameTag extends Model
{
    protected $fillable = [
        'name', 'slug', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image', 'status', 'lang',
    ];
    public function gametagrelations()
    {
        return $this->hasMany('App\Models\GameTagRelation', 'tag_id', 'id');
    }
    public function games()
    {
        return $this->belongsToMany('App\Models\Game', 'game_tag_relations', 'tag_id', 'game_id');
    }
}
