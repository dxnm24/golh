<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Game;
use DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CommonMethod;
use Cache;

class GameController extends Controller
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
            $data = self::searchGame($request);
        } else {
            $data = Game::orderBy('start_date', 'desc')->orderBy('id', 'desc')->paginate(PAGINATION);
        }
        return view('admin.game.index', ['data' => $data, 'request' => $request]);
    }

    private function searchGame($request)
    {
        $data = DB::table('games')->where(function ($query) use ($request) {
            if ($request->name != '') {
                $slug = CommonMethod::convert_string_vi_to_en($request->name);
                $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/i', '-', $slug));
                $query = $query->where('slug', 'like', '%'.$slug.'%');
            }
            if($request->type != '') {
                $query = $query->where('type', $request->type);
            }
            if($request->type_id != '') {
                $listGameId = DB::table('game_type_relations')
                    ->where('type_id', $request->type_id)
                    ->pluck('game_id');
                $query = $query->whereIn('id', $listGameId);
            }
            if($request->seri != '') {
                $query = $query->where('seri', $request->seri);
            }
            if($request->status != '') {
                $query = $query->where('status', $request->status);
            }
            if($request->start_date != ''){
                $query = $query->where('start_date', '>=', CommonMethod::datetimeConvert($request->start_date, '00:00:00', 1));
            }
            if($request->end_date != ''){
                $query = $query->where('start_date', '<=', CommonMethod::datetimeConvert($request->end_date, '23:59:59', 1));
            }
        })
        ->whereNull('deleted_at')
        ->orderBy('start_date', 'desc')
        ->orderBy('id', 'desc')
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
        return view('admin.game.create');
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
            'name' => 'bail|required|max:255',
            'slug' => 'required|max:255|unique:games|unique:game_types',
            'type_main_id' => 'required',
            'type' => 'required',
            'url' => 'max:255',
            'summary' => 'max:1000',
            'image' => 'max:255',
            'meta_title' => 'max:255',
            'meta_keyword' => 'max:255',
            'meta_description' => 'max:255',
            'meta_image' => 'max:255',
            'width' => 'max:255',
            'height' => 'max:255',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = Game::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'type_main_id' => $request->type_main_id,
                'seri' => $request->seri,
                'related' => $request->related,
                'type' => $request->type,
                'url' => $request->url,
                'summary' => $request->summary,
                'description' => $request->description,
                'image' => CommonMethod::removeDomainUrl($request->image),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
                'download' => $request->download,
                'width' => $request->width,
                'height' => $request->height,
                'screen' => $request->screen,
                'play' => $request->play,
                'position' => 1,
                'start_date' => CommonMethod::datetimeConvert($request->start_date, $request->start_time),
                'view' => 0,
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        if($data) {
            // insert game type relation
            $data->gametypes()->attach($request->type_id);
            // insert game tag relation
            $data->gametags()->attach($request->tag_id);
        }
        Cache::flush();
        return redirect()->route('admin.game.index')->with('success', 'Thêm thành công');
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
        $data = Game::find($id);
        return view('admin.game.edit', ['data' => $data]);
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
        $data = Game::find($id);
        $rules = [
            'name' => 'required|max:255',
            'type_main_id' => 'required',
            'type' => 'required',
            'url' => 'max:255',
            'summary' => 'max:1000',
            'image' => 'max:255',
            'meta_title' => 'max:255',
            'meta_keyword' => 'max:255',
            'meta_description' => 'max:255',
            'meta_image' => 'max:255',
            'width' => 'max:255',
            'height' => 'max:255',
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
                'type_main_id' => $request->type_main_id,
                'seri' => $request->seri,
                'related' => $request->related,
                'type' => $request->type,
                'url' => $request->url,
                'summary' => $request->summary,
                'description' => $request->description,
                'image' => CommonMethod::removeDomainUrl($request->image),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
                'download' => $request->download,
                'width' => $request->width,
                'height' => $request->height,
                'screen' => $request->screen,
                'play' => $request->play,
                'start_date' => CommonMethod::datetimeConvert($request->start_date, $request->start_time),
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        // update game type relation
        if($request->type_id) {
            $data->gametypes()->sync($request->type_id);
        } else {
            $data->gametypes()->detach();
        }
        // update game tag relation
        if($request->tag_id) {
            $data->gametags()->sync($request->tag_id);
        } else {
            $data->gametags()->detach();
        }
        Cache::flush();
        return redirect()->route('admin.game.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Game::find($id);
        $data->gametypes()->detach();
        $data->gametags()->detach();
        $data->delete();
        Cache::flush();
        return redirect()->route('admin.game.index')->with('success', 'Xóa thành công');   
    }

    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $field = $request->field;
        if($id) {
            $data = Game::find($id);    
            if(count($data) > 0) {
                $status = ($data->$field == ACTIVE)?INACTIVE:ACTIVE;
                $data->update([$field=>$status]);
                Cache::flush();
                return 1;
            }
        }
        return 0;
    }

}
