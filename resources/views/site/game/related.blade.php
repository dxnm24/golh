@if($data && count($gameData) > 0)
<?php 
	if(isset($dataSeri)) {
		$url = url($dataSeri->slug.'/'.$data->slug); 	
	} else {
		$url = url($data->slug); 
	}
?>
<div class="gametypes">
	<div class="row column box-title box-title-hr">
		<h3><a href="{{ $url }}" title="{!! $data->name !!}">{!! $data->name !!}</a></h3>
	</div>
	<div class="box-inner">
	@include('site.game.box2', array('data' => $gameData))
	</div>
	<div class="row column show-for-small-only box-seemore">
		<a href="{{ $url }}" class="btn-seemore" rel="nofollow">Xem tất cả<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
	</div>
</div>
@endif