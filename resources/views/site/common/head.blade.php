<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-language" content="en">
	<meta name="format-detection" content="telephone=no">
	<meta name="revisit-after" content="1 days" />
	<meta name="robots" content="noodp,noindex,nofollow" />
	<meta name="language" content="english" />
	<meta name="distribution" content="global">
	<meta name="title" content="{!! $meta_title !!}">
	<meta name="keywords" content="{!! $meta_keyword !!}">
	<meta name="description" content="{!! $meta_description !!}">
	
	<meta property="og:url" content="{!! url()->current() !!}" />
	<meta property="og:title" content="{!! $meta_title !!}" />
	<meta property="og:description" content="{!! $meta_description !!}" />
	@if($meta_image)
	<meta property="og:image" content="{!! url($meta_image) !!}" />
	@endif
	{!! getImageDimensionsOg($meta_image) !!}
	@if(isset($isPlay))
	<meta property="og:type" content="article" />
	@endif

	<meta property="fb:app_id" content="{!! FACEBOOK_APPID !!}" />
	<link rel="icon" href="{!! url('img/favicon.png') !!}" type="image/x-icon">
	<title>@yield('title')</title>
	{!! GA !!}
</head>