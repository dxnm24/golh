<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-language" content="vi">
	<meta name="format-detection" content="telephone=no">
	<meta name="revisit-after" content="1 days" />
	<meta name="robots" content="noindex,nofollow" />
	<meta name="language" content="vietnamese" />
	<meta name="title" content="{!! $game->meta_title !!}">
	<meta name="keywords" content="{!! $game->meta_keyword !!}">
	<meta name="description" content="{!! $game->meta_description !!}">
	<meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi" name="viewport">
	<link rel="icon" href="{{ url('img/favicon.png') }}" type="image/x-icon">
	<title>{!! $game->meta_title !!}</title>
	@if($scriptcode)
	{!! $scriptcode !!}
	@endif
	<link rel="stylesheet" type="text/css" href="{{ url('css/play.css') }}">
	<script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/play.js') }}"></script>
</head>
<body>
<div id="menushow"><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAqElEQVRYR+2W3Q2DMAyEP3agha2qskN3gm5RsVR/lqiMiJRETd+c8HB+TCTf+Wyf3NE4usb4iIAUiBW4AjNwdh7MD3ADHoYTE3hVAA+1vYEhJ/AMj84KWHordswJXPYWbB+OYeDWgjUn4IhZTq01PJQC8gEzh1OlVSj6wL2CG8oHki4fag0rzV8KEyswAQvQOzMp3gP24Q3+9x6QDzi3/nd6raEUaK7AF4DTHiGLgCMZAAAAAElFTkSuQmCC'></div>
{!! CommonGame::getBoxGame($game->url, $game->type, $game->width, $game->height, $adCode) !!}
<div id="menubox" style="display: none;">
	<ul>
		<li><a class="menubox-home" href="/">Trang chủ</a></li>
		<li><a class="menubox-reload" href="{{ url($game->slug).'?play=true' }}">Tải lại Game</a></li>
		<li><a class="menubox-back" onclick="window.history.go(-1);return false;">Quay lại</a></li>
		<li><a class="menubox-close" id="menuhide">Đóng menu</a></li>
	</ul>
</div>
</body>
</html>