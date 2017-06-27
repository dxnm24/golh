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
<div class="row column">
	<div class="row column box-title">
		<h1>{!! $title !!}</h1>
	</div>
	
	@include('site.game.boxList', array('data' => $data))

	<div class="row column">
		@include('site.common.paginate', ['paginator' => $data])
	</div>
</div>
@endif
@endsection