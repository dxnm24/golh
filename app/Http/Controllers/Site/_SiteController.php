<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use Cache;
use App\Helpers\CommonMethod;

class SiteController extends Controller
{
    public function index()
    {
        //cache name
        $cacheName = 'index';
        //get cache
        if(Cache::has($cacheName)) {
            return Cache::get($cacheName);
        }
        //query
        $data = DB::table('game_types')
            ->select('id', 'name', 'slug', 'type', 'limited', 'sort_by')
            ->where('status', ACTIVE)
            ->where('home', ACTIVE)
            ->whereNull('deleted_at')
            ->orderByRaw(DB::raw("position = '0', position"))
            ->orderBy('name', 'asc')
            ->get();
        if(count($data) > 0) {
            foreach($data as $key => $value) {
                if(!empty($value->limited) && $value->limited > 0) {
                    $typeLimit = $value->limited;
                } else {
                    $typeLimit = PAGINATE_BOX;
                }
                // check parent_id
                $types = $this->getGameTypeByParentIdQuery($value->id)->take($typeLimit)->get();
                $countTypes = count($types);
                if($countTypes > 0) {
                    if($countTypes >= $typeLimit) {
                        $limit = 0;
                    } else {
                        $limit = $typeLimit - $countTypes;
                    }
                    if($value->type == ACTIVE && $limit > 0) {
                        $gametypes = $this->getGameByTypeQuery($value->id)->take($limit)->get();
                        // $gametypes_sortbyview = $this->getGameByTypeQuery($value->id, 'view')->take($limit)->get();
                    } else {
                        $gametypes = $this->getGameByRelationsQuery('type', $value->id, $value->sort_by)->take($limit)->get();
                        // $gametypes_sortbyview = null;
                    }
                    $value->games = collect($types)->merge($gametypes);
                    // $value->games2 = collect($types)->merge($gametypes_sortbyview);
                    $value->games2 = [];
                    //add field seri to check seri ribbon image
                    //check item: check tung item la game hay seri (the loai)
                    // $typesIds = $this->getGameTypeByParentIdQuery($value->id)->take($typeLimit)->pluck('id');
                    // foreach($value->games as $v) {
                    //     if(in_array($v->id, $typesIds)) {
                    //         $v->seri = ACTIVE;
                    //     } else {
                    //         $v->seri = INACTIVE;
                    //     }
                    // }
                    //check box
                    $value->games->seri = ACTIVE;
                } else {
                    if($value->type == ACTIVE) {
                        $value->games = $this->getGameByTypeQuery($value->id)->take($typeLimit)->get();
                        $value->games2 = $this->getGameByTypeQuery($value->id, 'view')->take($typeLimit)->get();
                    } else {
                        $value->games = $this->getGameByRelationsQuery('type', $value->id, $value->sort_by)->take($typeLimit)->get();
                        $value->games2 = [];
                    }
                }
            }
        }
        //seo meta
        $seo = DB::table('configs')->where('status', ACTIVE)->first();
        //put cache
        $html = view('site.index', ['data' => $data, 'seo' => $seo])->render();
        Cache::forever($cacheName, $html);
        //return view
        return view('site.index', ['data' => $data, 'seo' => $seo]);
    }
    public function tag(Request $request, $slug)
    {
        //check page
        $page = ($request->page)?$request->page:1;
        //cache name
        $cacheName = 'tag_'.$slug.'_'.$page;
        //get cache
        if(Cache::has($cacheName)) {
            return Cache::get($cacheName);
        }
        //query
        $tag = DB::table('game_tags')
            ->select('id', 'name', 'slug', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image')
            ->where('slug', $slug)
            ->where('status', ACTIVE)
            ->first();
        // games tags
        if(isset($tag)) {
            $data = $this->getGameByRelationsQuery('tag', $tag->id)->paginate(PAGINATE);
            if($data->total() > 0) {
                //put cache
                $html = view('site.game.tag', ['data' => $data, 'tag' => $tag])->render();
                Cache::forever($cacheName, $html);
                //return view
                return view('site.game.tag', ['data' => $data, 'tag' => $tag]);
            }
        }
        return response()->view('errors.404', [], 404);
    }
    public function page(Request $request, $slug)
    {
        trimRequest($request);
        $device = getDevice();
        //update count view game
        DB::table('games')->where('slug', $slug)->increment('view');
        //check page
        $page = ($request->page)?$request->page:1;
        //cache name
        $cacheName = 'page_'.$slug.'_'.$page;
        if($device == MOBILE && isset($request->play)) {
            $cacheName = $cacheName.'_play';
        }
        if($device == MOBILE) {
            $cacheName = $cacheName.'_mobile';
        }
        //get cache
        if(Cache::has($cacheName)) {
            return Cache::get($cacheName);
        }
        // IF SLUG IS TYPE
        //query
        $type = $this->getGameTypeBySlug($slug);
        // game type
        if(isset($type)) {
            // check parent_id
            $types = $this->getGameTypeByParentIdQuery($type->id)->get();
            $countTypes = count($types);
            if($countTypes > 0) {
                $paginate = null;
                $data = collect($types);
                // $gametypes = $this->getGameByRelationsQuery('type', $type->id)->get();
                // $data = collect($types)->merge($gametypes);
                //add field seri to check seri ribbon image
                //check item
                // $typesIds = $this->getGameTypeByParentIdQuery($type->id)->pluck('id');
                // foreach($data as $v) {
                //     if(in_array($v->id, $typesIds)) {
                //         $v->seri = ACTIVE;
                //     } else {
                //         $v->seri = INACTIVE;
                //     }
                // }
                //check box
                $data->seri = ACTIVE;
            } else {
                $paginate = 1;
                $data = $this->getGameByRelationsQuery('type', $type->id)->paginate(PAGINATE);
            }
            $total = count($data);
            if($total > 0) {
                //auto meta tag for seo
                if(empty($type->meta_title)) {
                    $type->meta_title = 'Play free '.$type->name.' games and feeling | A2ZGame';
                }
                if(empty($type->meta_keyword)) {
                    $type->meta_keyword = $type->name.' game, '.$type->name.' games, play '.$type->name.' games, free '.$type->name.' games';
                }
                if(empty($type->meta_description)) {
                    $type->meta_description = 'Top 1000 free '.$type->name.' games on A2Zgame. What are you wating for, Just click to Play '.$type->name.' games with your friends and became the best';
                }
                //put cache
                $html = view('site.game.type', ['data' => $data, 'type' => $type, 'total' => $total, 'paginate' => $paginate])->render();
                Cache::forever($cacheName, $html);
                //return view
                return view('site.game.type', ['data' => $data, 'type' => $type, 'total' => $total, 'paginate' => $paginate]);
            }
        }
        // IF SLUG EXIST -moi-nhat or -hay-nhat
        // game type with sortby
        $latestSlug = strpos($slug, 'latest-');
        $hotestSlug = strpos($slug, 'best-');
        if($latestSlug !== false || $hotestSlug !== false) {
            $isHotOrNew = null;
            if($latestSlug !== false) {
                $typeSlug = substr($slug, 7);    
            }
            if($hotestSlug !== false) {
                $typeSlug = substr($slug, 5);
            }
            $type = $this->getGameTypeBySlug($typeSlug);
            if(isset($type)) {
                if($latestSlug !== false) {
                    $data = $this->getGameByRelationsQuery('type', $type->id)->paginate(PAGINATE);
                    $type->name = 'Latest '.$type->name;
                    $type->slug = 'latest-'.$type->slug;
                    $isHotOrNew = 1;
                }
                if($hotestSlug !== false) {
                    $data = $this->getGameByRelationsQuery('type', $type->id, 'view', 'desc')->paginate(PAGINATE);
                    $type->name = 'Best '.$type->name;
                    $type->slug = 'best-'.$type->slug;
                    $isHotOrNew = 1;
                }
                $paginate = 1;
                $total = count($data);
                if($total > 0) {
                    //auto meta tag for seo
                    if(empty($type->meta_title)) {
                        $type->meta_title = 'Play free '.$type->name.' games and feeling | A2ZGame';
                    }
                    if(empty($type->meta_keyword)) {
                        $type->meta_keyword = $type->name.' game, '.$type->name.' games, play '.$type->name.' games, free '.$type->name.' games';
                    }
                    if(empty($type->meta_description)) {
                        $type->meta_description = 'Top 1000 free '.$type->name.' games on A2Zgame. What are you wating for, Just click to Play '.$type->name.' games with your friends and became the best';
                    }
                    //put cache
                    $html = view('site.game.type', ['data' => $data, 'type' => $type, 'total' => $total, 'paginate' => $paginate, 'isHotOrNew' => $isHotOrNew])->render();
                    Cache::forever($cacheName, $html);
                    //return view
                    return view('site.game.type', ['data' => $data, 'type' => $type, 'total' => $total, 'paginate' => $paginate, 'isHotOrNew' => $isHotOrNew]);
                }
            }
        }
        // IF SLUG IS A GAME
        // game
        $game = DB::table('games')
            ->where('games.slug', $slug)
            ->where('games.status', ACTIVE)
            ->where('games.start_date', '<=', date('Y-m-d H:i:s'))
            ->whereNull('games.deleted_at')
            ->first();
        if($game) {
            //list tags
            $tags = DB::table('game_tags')
                ->join('game_tag_relations', 'game_tags.id', '=', 'game_tag_relations.tag_id')
                ->select('game_tags.id', 'game_tags.name', 'game_tags.slug')
                ->where('game_tag_relations.game_id', $game->id)
                ->where('game_tags.status', ACTIVE)
                ->orderBy('game_tags.name')
                ->get();
            //list seri
            $gameSeriesQuery = $this->getGameTypeQuery($game->seri, [$game->id]);
            $gameSeries = $gameSeriesQuery->get();
            $gameSeriesIds = $gameSeriesQuery->pluck('id');
            //list type
            $existGameIds = array_prepend($gameSeriesIds, $game->id);
            $gameTypesQuery = $this->getGameTypeQuery($game->type_main_id, $existGameIds);
            $gameTypes = $gameTypesQuery->get();
            $gameTypesIds = $gameTypesQuery->pluck('id');
            //list related
            $existGameIds2 = $existGameIds + $gameTypesIds;
            $gameRelatedQuery = $this->getGameTypeQuery($game->related, $existGameIds2);
            $gameRelated = $gameRelatedQuery->get();
            //FIRST: type, seri, related
            $typeMain = $this->getGameTypeById($game->type_main_id);
            $related = $this->getGameTypeById($game->related);
            $seri = $this->getGameTypeById($game->seri);
            //seri parent
            if($seri) {
                $seriParent = $this->getGameTypeById($seri->parent_id);
            } else {
                $seriParent = null;
            }
            //auto meta tag for seo
            if(empty($game->meta_title)) {
                $game->meta_title = 'Play '.$game->name.' game for free | A2ZGame';
            }
            if(empty($game->meta_keyword)) {
                $game->meta_keyword = $game->name.', '.$game->name.' game, play '.$game->name.' game, '.$game->name.' online, free '.$game->name.' game, play free '.$game->name;
            }
            if(empty($game->meta_description)) {
                $game->meta_description = 'Free online fun with '.$game->name.' game on A2ZGame. We need your skill and ability. Playing '.$game->name.' game now and feeling the great momment';
            }
            //ad preroll
            if($device == PC) {
                $adPosition = 5;
            } else {
                $adPosition = 6;
            }
            $ad = DB::table('ads')
                ->where('position', $adPosition)
                ->where('status', ACTIVE)
                ->first();
            if($ad) {
                $adCode = $ad->code;
            } else {
                $adCode = '';
            }
            if($device == MOBILE && isset($request->play)) {
                //put cache
                $html = view('site.game.play2', ['game' => $game, 'adCode' => $adCode])->render();
                Cache::forever($cacheName, $html);
                //return view
                return view('site.game.play2', ['game' => $game, 'adCode' => $adCode]);
            }
            // link to game play in mobile device
            if($game->play == ACTIVE) {
                $linkToPlayGame = url($game->slug).'?play=true';
            } else {
                $linkToPlayGame = url($game->url);
            }
            //put cache
            $html = view('site.game.play', [
                    'game' => $game, 
                    'tags' => $tags, 
                    'gameTypes' => $gameTypes, 
                    'gameSeries' => $gameSeries, 
                    'gameRelated' => $gameRelated, 
                    'typeMain' => $typeMain, 
                    'related' => $related, 
                    'seri' => $seri, 
                    'seriParent' => $seriParent, 
                    'adCode' => $adCode,
                    'linkToPlayGame' => $linkToPlayGame
                ])->render();
            Cache::forever($cacheName, $html);
            //return view
            return view('site.game.play', [
                    'game' => $game, 
                    'tags' => $tags, 
                    'gameTypes' => $gameTypes, 
                    'gameSeries' => $gameSeries, 
                    'gameRelated' => $gameRelated, 
                    'typeMain' => $typeMain, 
                    'related' => $related, 
                    'seri' => $seri, 
                    'seriParent' => $seriParent, 
                    'adCode' => $adCode,
                    'linkToPlayGame' => $linkToPlayGame
                ]);
        }
        return response()->view('errors.404', [], 404);
    }
    public function page2(Request $request, $slug1, $slug2)
    {
        trimRequest($request);
        $device = getDevice();
        //check page
        $page = ($request->page)?$request->page:1;
        //cache name
        $cacheName = 'page_'.$slug2.'_'.$page;
        //get cache
        if(Cache::has($cacheName)) {
            return Cache::get($cacheName);
        }
        //query
        $type = $this->getGameTypeBySlug($slug2, 1);
        if(isset($type)) {
            $paginate = 1;
            $data = $this->getGameByRelationsQuery('type', $type->id)->paginate(PAGINATE);
            $total = count($data);
            if($total > 0) {
                $seriParent = $this->getGameTypeById($type->parent_id);
                //put cache
                $html = view('site.game.type', ['data' => $data, 'type' => $type, 'total' => $total, 'paginate' => $paginate, 'seriParent' => $seriParent])->render();
                Cache::forever($cacheName, $html);
                //return view
                return view('site.game.type', ['data' => $data, 'type' => $type, 'total' => $total, 'paginate' => $paginate, 'seriParent' => $seriParent]);
            }
        }
        return response()->view('errors.404', [], 404);
    }
    public function search(Request $request)
    {
        trimRequest($request);
        if($request->name == '') {
            return view('site.game.search', ['data' => null, 'request' => $request]);
        }
        //check page
        $page = ($request->page)?$request->page:1;
        //cache name
        $cacheName = 'search_'.$request->name.'_'.$page;
        //get cache
        if(Cache::has($cacheName)) {
            return Cache::get($cacheName);
        }
        //query
        // game
        $slug = CommonMethod::convert_string_vi_to_en($request->name);
        $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/i', '-', $slug));
        $data = DB::table('games')
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->where('slug', 'like', '%'.$slug.'%')
            ->orWhere('name', 'like', '%'.$request->name.'%')
            ->whereNull('deleted_at')
            ->orderBy('start_date', 'desc')
            ->paginate(PAGINATE);
        //put cache
        $html = view('site.game.search', ['data' => $data->appends($request->except('page')), 'request' => $request])->render();
        Cache::forever($cacheName, $html);
        //return view
        return view('site.game.search', ['data' => $data->appends($request->except('page')), 'request' => $request]);
    }
    public function sitemap()
    {
        ///cache name
        $cacheName = 'sitemap';
        //get cache
        if(Cache::has($cacheName)) {
            $content = Cache::get($cacheName);
            return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
        }
        //query
        //put cache
        $html = view('site.sitemap')->render();
        Cache::forever($cacheName, $html);
        //return view
        $content = view('site.sitemap');
        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }
    private function getGameTypeQuery($id, $ids)
    {
        return DB::table('games')
            ->join('game_type_relations', 'games.id', '=', 'game_type_relations.game_id')
            ->select('games.id', 'games.name', 'games.slug', 'games.image')
            ->where('game_type_relations.type_id', $id)
            ->where('games.status', ACTIVE)
            ->where('games.start_date', '<=', date('Y-m-d H:i:s'))
            ->whereNotIn('game_type_relations.game_id', $ids)
            ->whereNull('games.deleted_at')
            ->orderBy('games.start_date', 'desc')
            ->take(PAGINATE_BOX);
    }
    private function getGameTypeByParentIdQuery($id)
    {
        return DB::table('game_types')
            ->select('id', 'name', 'slug', 'image')
            ->where('status', ACTIVE)
            ->where('parent_id', $id)
            ->whereNull('deleted_at')
            ->orderByRaw(DB::raw("position = '0', position"))
            ->orderBy('name', 'asc');
    }
    private function getGameTypeById($id)
    {
        return DB::table('game_types')
            ->select('id', 'name', 'slug', 'parent_id')
            ->where('id', $id)
            ->where('status', ACTIVE)
            ->whereNull('deleted_at')
            ->first();
    }
    private function getGameTypeBySlug($slug, $hasParentId = null)
    {
        $result = DB::table('game_types')
            ->select('id', 'name', 'slug', 'parent_id', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image')
            ->where('slug', $slug)
            ->where('status', ACTIVE);
        if($hasParentId) {
            $result = $result->where('parent_id', '!=', 0);
        } else {
            $result = $result->where('parent_id', 0);
        }
        return $result->whereNull('deleted_at')->first();
    }
    private function getGameByTypeQuery($id, $orderColumn = 'start_date', $orderSort = 'desc')
    {
        return DB::table('games')
            ->select('id', 'name', 'slug', 'image')
            ->where('type_main_id', $id)
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->whereNull('deleted_at')
            ->orderBy($orderColumn, $orderSort);
    }
    private function getGameByRelationsQuery($element, $id, $orderColumn = 'start_date', $orderSort = 'desc')
    {
        return DB::table('games')
            ->join('game_'.$element.'_relations', 'games.id', '=', 'game_'.$element.'_relations.game_id')
            // ->join('game_'.$element.'s', 'game_'.$element.'_relations.'.$element.'_id', '=', 'game_'.$element.'s.id')
            ->select('games.id', 'games.name', 'games.slug', 'games.image')
            ->where('game_'.$element.'_relations.'.$element.'_id', $id)
            ->where('games.status', ACTIVE)
            ->where('games.start_date', '<=', date('Y-m-d H:i:s'))
            ->whereNull('games.deleted_at')
            ->orderBy('games.'.$orderColumn, $orderSort);
    }
}
