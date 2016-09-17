<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\GameType;
use App\Models\Game;
use DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CommonMethod;
use App\Helpers\CommonQuery;
use Cache;

class GameTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        trimRequest($request);
        if($request->except('page')) {
            $data = self::searchGameType($request);
        } else {
            $data = GameType::orderByRaw(DB::raw("position = '0', position"))
                        ->orderBy('name', 'asc')
                        ->paginate(PAGINATION);
        }
        return view('admin.gametype.index', ['data' => $data, 'request' => $request]);
    }

    private function searchGameType($request)
    {
        $data = DB::table('game_types')->where(function ($query) use ($request) {
            if ($request->name != '') {
                $slug = CommonMethod::convert_string_vi_to_en($request->name);
                $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/i', '-', $slug));
                $query = $query->where('slug', 'like', '%'.$slug.'%');
            }
            if($request->status != '') {
                $query = $query->where('status', $request->status);
            }
        })
        ->whereNull('deleted_at')
        ->orderBy('name', 'asc')
        ->paginate(PAGINATION);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gameTypes = CommonQuery::getArrayParentZero('game_types');
        return view('admin.gametype.create', ['gameTypes' => $gameTypes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        trimRequest($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:games|unique:game_types',
            'summary' => 'max:1000',
            'image' => 'max:255',
            'meta_title' => 'max:255',
            'meta_keyword' => 'max:255',
            'meta_description' => 'max:255',
            'meta_image' => 'max:255',
            'limited' => 'max:255',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        GameType::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->parent_id,
                'summary' => $request->summary,
                'description' => $request->description,
                'image' => CommonMethod::removeDomainUrl($request->image),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
                'limited' => $request->limited,
                'sort_by' => $request->sort_by,
                'home' => $request->home,
                'type' => $request->type,
                'grid' => $request->grid,
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        Cache::flush();
        return redirect()->route('admin.gametype.index')->with('success', 'Thêm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = GameType::find($id);
        $gameTypes = CommonQuery::getArrayParentZero('game_types', $data->id);
        return view('admin.gametype.edit', ['data' => $data, 'gameTypes' => $gameTypes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        trimRequest($request);
        $data = GameType::find($id);
        $rules = [
            'name' => 'required|max:255',
            'summary' => 'max:1000',
            'image' => 'max:255',
            'meta_title' => 'max:255',
            'meta_keyword' => 'max:255',
            'meta_description' => 'max:255',
            'meta_image' => 'max:255',
            'limited' => 'max:255',
        ];
        if($request->slug != $data->slug) {
            $rules['slug'] = 'required|max:255|unique:games|unique:game_types';
        }
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->parent_id,
                'summary' => $request->summary,
                'description' => $request->description,
                'image' => CommonMethod::removeDomainUrl($request->image),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
                'limited' => $request->limited,
                'sort_by' => $request->sort_by,
                'home' => $request->home,
                'type' => $request->type,
                'grid' => $request->grid,
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        Cache::flush();
        return redirect()->route('admin.gametype.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $games = Game::where('type_main_id', $id)
            ->orWhere('seri', $id)
            ->whereNull('deleted_at')
            ->first();
        if(isset($games)) {
            return redirect()->route('admin.gametype.index')->with('warning', 'Không thể xóa vì có game trong thể loại này!'); 
        }
        $data = GameType::find($id);
        $data->delete();
        Cache::flush();
        return redirect()->route('admin.gametype.index')->with('success', 'Xóa thành công');   
    }

    public function callupdate(Request $request)
    {
        $id = $request->id;
        $position = $request->position;
        foreach($id as $key => $value) {
            GameType::find($value)->update([
                    'position' => $position[$key]
                ]);
        }
        Cache::flush();
        return 1;
    }

}
