<?php $device = getDevice(); ?>
@if($device == MOBILE)
<header>
	<div class="mobile-topbar">
		<div class="row">
			<div class="small-3 columns">
				<a class="mobile-menuopen" data-toggle="mobile-menubox" aria-controls="mobile-menubox" aria-haspopup="true" tabindex="0"><i class="fa fa-bars" aria-hidden="true"></i></a>
			</div>
			<div class="small-9 columns">
				<div class="logo">
					<a href="/">
						<span class="logo-color-1">GAME</span>
						<span class="logo-color-2">OFFLINE</span>
						<span class="logo-color-3">HAY</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="column">
		<div class="mobile-search">
			<form action="{{ route('site.search') }}" method="GET" class="search-form">
				<input name="name" type="text" value="" class="search-input" placeholder="Tìm kiếm">
				<a class="search-button" onclick="$('.search-form').submit()"><i class="fa fa-search" aria-hidden="true"></i></a>
			</form>
		</div>
	</div>
</div>
<div class="full reveal mobile-menubox" id="mobile-menubox" data-reveal>
	<div class="mobile-menubox-head">
		<strong class="mobile-title mmh-left">Danh mục</strong>
		<a class="mmh-right" data-close aria-label="Close modal"><i class="fa fa-times" aria-hidden="true"></i> Đóng Menu</a>
		<div class="clearfix"></div>
	</div>
	<ul class="mobile-menu">
		@if($mobilemenu)
      		@foreach($mobilemenu as $key => $value)
				<li {{ checkCurrent(url($value->url)) }}><a href="{{ $value->url }}">{!! $value->name !!}</a></li>
			@endforeach
		@endif
		<li class="mobile-li-close"><a class="mobile-menuclose" data-close aria-label="Close modal"><i class="fa fa-times" aria-hidden="true"></i> Đóng Menu</a></li>
  	</ul>
</div>
@else
<header class="show-for-medium">
	<div class="row column">
		<a href="/" class="logo"><img src="/img/logo.png" alt="" /></a>
		{!! $topmenu !!}
	</div>
</header>
<div class="search">
	<div class="row column">
		<form action="{{ route('site.search') }}" method="GET" class="search-form">
			<div class="input-group">
				<input name="name" type="text" value="" class="input-group-field" id="searchtext" placeholder="Tìm kiếm">
				<div class="input-group-button">
					<a class="button" onclick="$('.search-form').submit()"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</a>
				</div>
			</div>
			<p>Hãy nhập tên game, hoặc 1 phần tên game bạn muốn tìm kiếm. Ví dụ: <a title="tai game skyrim" href="/tim-kiem?name=skyrim">skyrim</a>, <a title="tai game cod" href="/tim-kiem?name=call+of+duty">call of duty</a>, <a title="tai game ban ga" href="/tim-kiem?name=ban+ga">ban ga</a> ...</p>
        </form>
	</div>
</div>
@endif