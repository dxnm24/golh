<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use Cache;
use App\Helpers\CommonMethod;
use Validator;
use App\Models\Contact;

class SiteController extends Controller
{
    public function index()
    {
        //cache name
        $cacheName = 'index';
        $device = getDevice();
        if($device == MOBILE) {
            $cacheName = $cacheName.'_mobile';
        }
        //get cache
        if(Cache::has($cacheName)) {
            return Cache::get($cacheName);
        }
        //query
        $data = DB::table('game_types')
            ->select('id', 'name', 'slug', 'summary', 'type', 'limited', 'sort_by')
            ->where('status', ACTIVE)
            ->where('home', ACTIVE)
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
                    //add field seri to check seri ribbon image (doan code duoi day cho phep check item trong trang seri la type hay game de su dung 1 image ribbon)
                    //2.1. check item (mo doan code nay khi khong su dung muc so 1.1. o duoi va dong vao khi su dung muc so 1.1. o duoi)
                    $typesIds = $this->getGameTypeByParentIdQuery($value->id)->take($typeLimit)->pluck('id');
                    foreach($value->games as $v) {
                        if(in_array($v->id, $typesIds)) {
                            $v->seri = ACTIVE;
                        } else {
                            $v->seri = INACTIVE;
                        }
                    }
                    //1.1 check box (mo ra neu khong su dung muc so 2.1. va dong vao khi su dung muc so 2.1. o tren)
                    // $value->games->seri = ACTIVE;
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
        $device = getDevice();
        if($device == MOBILE) {
            $cacheName = $cacheName.'_mobile';
        }
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
                //auto meta tag for seo
                if(empty($tag->meta_title)) {
                    $tag->meta_title = $tag->name.' offline | Tổng hợp gameoffline cũ mới kinh điển tại gameofflinehay.com';
                }
                if(empty($tag->meta_keyword)) {
                    $tagNameNoLatin = CommonMethod::convert_string_vi_to_en($tag->name);
                    $tag->meta_keyword = $tagNameNoLatin.', '.$tag->name.', '.$tagNameNoLatin.' offline, '.$tag->name.' offline, '.$tagNameNoLatin.' offline hay, '.$tag->name.' offline hay'.', Tim '.$tagNameNoLatin.' offline, tìm '.$tag->name.' offline, Chơi '.$tagNameNoLatin.' offline, Chơi '.$tag->name.' offline';
                }
                if(empty($tag->meta_description)) {
                    $tagNameNoLatin = CommonMethod::convert_string_vi_to_en($tag->name);
                    $tag->meta_description = 'Tim '.$tagNameNoLatin.' offline cho pc, laptop. Chơi '.$tagNameNoLatin.' offline hay nhất từ danh sách '.$tag->name.' tại gameofflinehay.com';
                }
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
        self::forgetCache('lien-he');
        //
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
        // IF SLUG IS PAGE
        //query
        $singlePage = DB::table('pages')->where('slug', $slug)->where('status', ACTIVE)->first();
        // page
        if(isset($singlePage)) {
            $singlePage->summary = CommonMethod::replaceText($singlePage->summary);
            //put cache
            $html = view('site.page', ['data' => $singlePage])->render();
            Cache::forever($cacheName, $html);
            //return view
            return view('site.page', ['data' => $singlePage]);
        }        
        // IF SLUG IS TYPE
        //query
        $type = $this->getGameTypeBySlug($slug);
        // game type
        if(isset($type)) {
            if($type->grid == ACTIVE) {
                $paginateNumber = PAGINATE;
            } else {
                $paginateNumber = PAGINATE_GRID;
            }
            // check parent_id
            $types = $this->getGameTypeByParentIdQuery($type->id)->get();
            $countTypes = count($types);
            if($countTypes > 0) {
                $paginate = null;
                //1. hien thi toan bo type duoc danh dau la con cua type (seri) nao do (luon mo code duoi)
                $data = collect($types);
                //2. hien thi them game duoc danh dau the loai la type (seri). Co nghia la hien thi type (theo muc so 1. va ca game duoc danh dau type (seri)). Neu chi hien thi type trong trang seri thi dong 2 dong code duoi day va nguoc lai mo ra de hien thi ca type va game thuoc seri do.
                $gametypes = $this->getGameByRelationsQuery('type', $type->id)->get();
                $data = collect($types)->merge($gametypes);
                //add field seri to check seri ribbon image (doan code duoi day cho phep check item trong trang seri la type hay game de su dung 1 image ribbon)
                //2.1 check item (mo doan code nay khi su dung muc so 2. o tren va dong vao khi khong su dung muc so 2. o tren)
                $typesIds = $this->getGameTypeByParentIdQuery($type->id)->pluck('id');
                foreach($data as $v) {
                    if(in_array($v->id, $typesIds)) {
                        $v->seri = ACTIVE;
                    } else {
                        $v->seri = INACTIVE;
                    }
                }
                //1.1 check box (mo ra neu khong su dung muc so 2. va dong vao khi su dung muc so 2. o tren)
                // $data->seri = ACTIVE;
            } else {
                $paginate = 1;
                $data = $this->getGameByRelationsQuery('type', $type->id)->paginate($paginateNumber);
            }
            $total = count($data);
            if($total > 0) {
                //auto meta tag for seo
                if(empty($type->meta_title)) {
                    $type->meta_title = $type->name.' offline | Tổng hợp gameoffline cũ mới kinh điển tại gameofflinehay.com';
                }
                if(empty($type->meta_keyword)) {
                    $typeNameNoLatin = CommonMethod::convert_string_vi_to_en($type->name);
                    $type->meta_keyword = $typeNameNoLatin.', '.$type->name.', '.$typeNameNoLatin.' offline, '.$type->name.' offline, '.$typeNameNoLatin.' offline hay, '.$type->name.' offline hay'.', Tim '.$typeNameNoLatin.' offline, tìm '.$type->name.' offline, Chơi '.$typeNameNoLatin.' offline, Chơi '.$type->name.' offline';
                }
                if(empty($type->meta_description)) {
                    $typeNameNoLatin = CommonMethod::convert_string_vi_to_en($type->name);
                    $type->meta_description = 'Tim '.$typeNameNoLatin.' offline cho pc, laptop. Chơi '.$typeNameNoLatin.' offline hay nhất từ danh sách '.$type->name.' tại gameofflinehay.com';
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
        $latestSlug = strpos($slug, '-offline-moi-nhat');
        $hotestSlug = strpos($slug, '-offline-hay-nhat');
        if($latestSlug !== false || $hotestSlug !== false) {
            $isHotOrNew = null;
            $typeSlug = substr($slug, 0, -17);
            $type = $this->getGameTypeBySlug($typeSlug);
            if(isset($type)) {
                if($type->grid == ACTIVE) {
                    $paginateNumber = PAGINATE;
                } else {
                    $paginateNumber = PAGINATE_GRID;
                }
                if($latestSlug !== false) {
                    $data = $this->getGameByRelationsQuery('type', $type->id)->paginate($paginateNumber);
                    $type->name = $type->name.' offline mới nhất';
                    $type->slug = $type->slug.'-offline-moi-nhat';
                    $isHotOrNew = 1;
                }
                if($hotestSlug !== false) {
                    $data = $this->getGameByRelationsQuery('type', $type->id, 'view', 'desc')->paginate($paginateNumber);
                    $type->name = $type->name.' offline hay nhất';
                    $type->slug = $type->slug.'-offline-hay-nhat';
                    $isHotOrNew = 1;
                }
                $paginate = 1;
                $total = count($data);
                if($total > 0) {
                    //auto meta tag for seo
                    if(empty($type->meta_title)) {
                        $type->meta_title = $type->name.' | Tổng hợp gameoffline cũ và mới kinh điển tại gameofflinehay.com';
                    }
                    if(empty($type->meta_keyword)) {
                        $typeNameNoLatin = CommonMethod::convert_string_vi_to_en($type->name);
                        $type->meta_keyword = $typeNameNoLatin.', '.$type->name.', Tim '.$typeNameNoLatin.', tìm '.$type->name.', Chơi '.$typeNameNoLatin.', Chơi '.$type->name;
                    }
                    if(empty($type->meta_description)) {
                        $typeNameNoLatin = CommonMethod::convert_string_vi_to_en($type->name);
                        $type->meta_description = 'Tim '.$typeNameNoLatin.' cho pc, laptop, máy cấu hình yếu. Chơi '.$typeNameNoLatin.' từ danh sách '.$type->name.' tổng hợp tại gameofflinehay.com';
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
                $game->meta_title = $game->name.' | Tìm game '.$game->name.' tại gameofflinehay.com';
            }
            if(empty($game->meta_keyword)) {
                $game->meta_keyword = $game->name.', game '.$game->name.', Tim game '.$game->name.', Tim game offline '.$game->name.', game '.$game->name.' offline';
            }
            if(empty($game->meta_description)) {
                $game->meta_description = 'Game '.$game->name.' cực hay. Tim game '.$game->name.'. Chơi '.$typeMain->name.' '.$game->name.' để tận hưởng những giây phút tuyệt vời mà game offline mang lại';
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
        $cacheName = 'page_'.$slug1.'_'.$slug2.'_'.$page;
        if($device == MOBILE) {
            $cacheName = $cacheName.'_mobile';
        }
        //get cache
        if(Cache::has($cacheName)) {
            return Cache::get($cacheName);
        }
        //query
        $type = $this->getGameTypeBySlug($slug2, 1);
        $typeParent = $this->getGameTypeBySlug($slug1);
        if(isset($type) && isset($typeParent) && ($typeParent->id == $type->parent_id)) {
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
        $device = getDevice();
        if($device == MOBILE) {
            $cacheName = $cacheName.'_mobile';
        }
        //get cache
        if(Cache::has($cacheName)) {
            return Cache::get($cacheName);
        }
        //query
        // game
        $slug = CommonMethod::convert_string_vi_to_en($request->name);
        $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/i', '-', $slug));
        $data = DB::table('games')->where('status', ACTIVE);
        if($device == MOBILE) {
            $data = $data->where('type', '!=', GAMEFLASH);
        }
        $data = $data->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->where('slug', 'like', '%'.$slug.'%')
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
        $data = DB::table('games')
            ->join('game_type_relations', 'games.id', '=', 'game_type_relations.game_id')
            ->select('games.id', 'games.name', 'games.slug', 'games.image', 'games.summary', 'games.type')
            ->where('game_type_relations.type_id', $id)
            ->where('games.status', ACTIVE);
        $device = getDevice();
        if($device == MOBILE) {
            $data = $data->where('games.type', '!=', GAMEFLASH);
        }
        $data = $data->where('games.start_date', '<=', date('Y-m-d H:i:s'))
            ->whereNotIn('game_type_relations.game_id', $ids)
            ->orderBy('games.start_date', 'desc')
            ->take(PAGINATE_BOX);
        return $data;
    }
    private function getGameTypeByParentIdQuery($id)
    {
        return DB::table('game_types')
            ->select('id', 'name', 'slug', 'summary', 'image', 'type', 'grid')
            ->where('status', ACTIVE)
            ->where('parent_id', $id)
            ->orderByRaw(DB::raw("position = '0', position"))
            ->orderBy('name', 'asc');
    }
    private function getGameTypeById($id)
    {
        return DB::table('game_types')
            ->select('id', 'name', 'slug', 'summary', 'parent_id', 'type', 'grid')
            ->where('id', $id)
            ->where('status', ACTIVE)
            ->first();
    }
    private function getGameTypeBySlug($slug, $hasParentId = null)
    {
        $result = DB::table('game_types')
            ->select('id', 'name', 'slug', 'parent_id', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image', 'type', 'grid')
            ->where('slug', $slug)
            ->where('status', ACTIVE);
        if($hasParentId) {
            $result = $result->where('parent_id', '!=', 0);
        } else {
            $result = $result->where('parent_id', 0);
        }
        return $result->first();
    }
    private function getGameByTypeQuery($id, $orderColumn = 'start_date', $orderSort = 'desc')
    {
        $data = DB::table('games')
            ->select('id', 'name', 'slug', 'image', 'summary', 'type')
            ->where('type_main_id', $id)
            ->where('status', ACTIVE);
        $device = getDevice();
        if($device == MOBILE) {
            $data = $data->where('type', '!=', GAMEFLASH);
        }
        $data = $data->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->orderBy($orderColumn, $orderSort);
        return $data;
    }
    private function getGameByRelationsQuery($element, $id, $orderColumn = 'start_date', $orderSort = 'desc')
    {
        $data = DB::table('games')
            ->join('game_'.$element.'_relations', 'games.id', '=', 'game_'.$element.'_relations.game_id')
            // ->join('game_'.$element.'s', 'game_'.$element.'_relations.'.$element.'_id', '=', 'game_'.$element.'s.id')
            ->select('games.id', 'games.name', 'games.slug', 'games.image', 'games.summary', 'games.type')
            ->where('game_'.$element.'_relations.'.$element.'_id', $id)
            ->where('games.status', ACTIVE);
        $device = getDevice();
        if($device == MOBILE) {
            $data = $data->where('games.type', '!=', GAMEFLASH);
        }
        $data = $data->where('games.start_date', '<=', date('Y-m-d H:i:s'))
            ->orderBy('games.'.$orderColumn, $orderSort);
        return $data;
    }
    /* 
    * contact
    */
    public function contact(Request $request)
    {
        self::forgetCache('lien-he');
        //
        trimRequest($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'tel' => 'max:255',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'tel' => $request->tel,
                'msg' => $request->msg,
            ]);
        return redirect()->back()->with('success', 'Cảm ơn bạn đã gửi thông tin liên hệ cho chúng tôi.');
    }
    // remove cache page if exist message validator
    private function forgetCache($slug) {
        //delete cache for contact page before redirect to remove message validator
        $cacheName = 'page_'.$slug.'_1';
        $cacheNameMobile = 'page_'.$slug.'_1_mobile';
        Cache::forget($cacheName);
        Cache::forget($cacheNameMobile);
    }
}
