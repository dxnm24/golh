<?php 
namespace App\Helpers;

use DB;
use App\Helpers\CommonMethod;

class CommonGame
{
	static function adminSearchGame($request)
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
	static function issetGameType($gameId, $typeId)
	{
		$count = DB::table('game_type_relations')
			->where('game_id', $gameId)
			->where('type_id', $typeId)
			->count();
		if($count > 0) {
			return true;
		}
		return false;
	}
	static function issetGameTypeChecked($gameId, $typeId)
	{
		$check = self::issetGameType($gameId, $typeId);
		if($check == true) {
			return 'checked="checked"';
		}
		return '';
	}
	//check type box
	static function issetMakeDisplay($gameId, $makeId, $typeId, $issetCheck = true)
	{
		if($issetCheck == true) {
			$check = self::issetGameType($gameId, $typeId);
			if($check == true && $makeId != $typeId) {
				return '';
			}
		} else {
			if($makeId != $typeId) {
				return '';
			}
		}
		return 'display: none;';
	}
	static function issetCheckedDisplay($makeId, $typeId)
	{
		if($makeId == $typeId) {
			return '';
		}
		return 'display: none;';
	}
	//
	static function issetGameTag($gameId)
	{
		$data = DB::table('game_tag_relations')
			->where('game_id', $gameId)
			->pluck('tag_id');
		if(count($data) > 0) {
			return $data;
		}
		return [];
	}
	static function getBoxGame($url, $type, $width, $height, $adCode)
	{
		$width = (isset($width) && $width != '')?($width):FRAME_WIDTH;
		$height = (isset($height) && $height != '')?($height):FRAME_HEIGHT;
		if(getDevice() == MOBILE) {
			$width = '100%';
			$height = '100%';
		}
		$data = [
			// 'type' => $type,
			'width' => $width,
			'height' => $height,
			'url' => $url,
			'adCode' => $adCode,
		];
		if($type == GAMEFLASH) {
			return view('site.game.playGameFlash', $data);
		}
		if($type == GAMEHTML5) {
			return view('site.game.playGameHtml5', $data);
		}
		return '';
	}
}