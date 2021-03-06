<?php 
	if(isset($seo)) {
		$title = ($seo->meta_title)?$seo->meta_title:'Trang chủ';
		$meta_title = $seo->meta_title;
		$meta_keyword = $seo->meta_keyword;
		$meta_description = $seo->meta_description;
		$meta_image = $seo->meta_image;
	} else {
		$title = 'Trang chủ';
		$meta_title = '';
		$meta_keyword = '';
		$meta_description = '';
		$meta_image = '';
	}
	$extendData = array(
			'meta_title' => $meta_title,
			'meta_keyword' => $meta_keyword,
			'meta_description' => $meta_description,
			'meta_image' => $meta_image,
		);
?>
@extends('site.layouts.master', $extendData)

@section('title', $title)

@section('content')
@if(count($data) > 0)
	@foreach($data as $key => $value)
		@if(count($value->games) > 0)
			<?php $url = url($value->slug); ?>
			@if(count($value->games2) == 0)
			<div class="box">
				<div class="row column box-title box-title-hr">
					<h3><a href="{{ $url }}" title="{!! $value->name !!}">{!! $value->name !!}</a></h3>
				</div>
				<div class="box-inner">
				@if($key == 0)
				@include('site.game.box', array('data' => $value->games, 'type' => $value))
				@else 
				@include('site.game.box1', array('data' => $value->games, 'type' => $value))
				@endif
				</div>
				<div class="row column show-for-small-only box-seemore">
					<a href="{{ $url }}" class="btn-seemore" rel="nofollow">Xem tất cả<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
				</div>
			</div>
			@else
			<?php 
				$urlBest = url($value->slug.'-offline-hay-nhat');
				$urlLatest = url($value->slug.'-offline-moi-nhat');
			?>
			<div class="box">
				<ul class="box-tabs clearfix" data-tabs id="box-tabs-{{ $value->id }}">
					<li class="tabs-title is-active">
						<h3><a href="#{{ $value->slug.'-offline-hay-nhat' }}" aria-selected="true" rel="nofollow">{!! $value->name !!} offline hay nhất</a></h3>
					</li>
					<li class="tabs-title">
						<h3><a href="#{{ $value->slug.'-offline-moi-nhat' }}" rel="nofollow">{!! $value->name !!} offline mới nhất</a></h3>
					</li>
				</ul>
				<div class="box-inner" data-tabs-content="box-tabs-{{ $value->id }}">
					<div class="tabs-panel is-active" id="{{ $value->slug.'-offline-hay-nhat' }}">
						<a href="{{ $urlBest }}" class="btn-seemore float-right hide-for-small-only" rel="nofollow"><span>Xem tất cả</span></a>
						<div class="clearfix"></div>
						@if($key == 0)
						@include('site.game.box', array('data' => $value->games2, 'type' => $value))
						@else 
						@include('site.game.box1', array('data' => $value->games2, 'type' => $value))
						@endif
					</div>
					<div class="tabs-panel" id="{{ $value->slug.'-offline-moi-nhat' }}">
						<a href="{{ $urlLatest }}" class="btn-seemore float-right hide-for-small-only" rel="nofollow"><span>Xem tất cả</span></a>
						<div class="clearfix"></div>
						@if($key == 0)
						@include('site.game.box', array('data' => $value->games, 'type' => $value))
						@else 
						@include('site.game.box1', array('data' => $value->games, 'type' => $value))
						@endif
					</div>
				</div>
				<div class="row column show-for-small-only box-seemore">
					<a href="{{ $urlBest }}" class="btn-seemore">Xem {!! $value->name !!} offline hay nhất<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
					<a href="{{ $urlLatest }}" class="btn-seemore">Xem {!! $value->name !!} offline mới nhất<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
					<a href="{{ $url }}" class="btn-seemore">Xem tất cả<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
				</div>
			</div>
			@endif
		@endif
	@endforeach
@endif
@endsection