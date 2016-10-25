@if($data && count($gameData) > 0)
<?php 
	if(isset($dataSeri)) {
		$url = url($dataSeri->slug.'/'.$data->slug); 	
	} else {
		$url = url($data->slug); 
	}
?>
<div class="gametypes">
	<div class="row column box-title">
		<h3>{!! $data->name !!}</h3>
		<a href="{{ $url }}" class="btn-seemore float-right hide-for-small-only"><span>Xem tất cả</span></a>
	</div>
	<div class="box-inner">
	@include('site.game.box', array('data' => $gameData))
	</div>
	<div class="row column show-for-small-only box-seemore">
		<a href="{{ $url }}" class="btn-seemore">Xem tất cả<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
	</div>
</div>
@endif