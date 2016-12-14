<?php $device = getDevice2(); ?>
@if($device != MOBILE)
<div class="search">
	<div class="row column">
		<form action="{{ route('site.search') }}" method="GET" class="search-form">
			<div class="input-group">
				<input name="name" type="text" value="" class="input-group-field" id="searchtext" placeholder="Tìm kiếm">
				<div class="input-group-button">
					<a class="search-button" onclick="$('.search-form').submit()"><i class="fa fa-search" aria-hidden="true"></i></a>
				</div>
			</div>
			<p>Hãy nhập tên game, hoặc 1 phần tên game bạn muốn tìm kiếm. Ví dụ: <a title="game Age of Empires" href="/tim-kiem?name=age+of+empires">đế chế</a>, <a title="game Assassin's Creed" href="/tim-kiem?name=assassins+creed">Assassin's Creed</a>, <a title="game ban ga" href="/tim-kiem?name=chicken+invaders">ban ga</a> ...</p>
        </form>
	</div>
</div>
@endif
@if($topgamemenu)
<div class="side">
	<h3>Bảng xếp hạng game hay nhất năm</h3>
	<ul class="topgame">
		@foreach($topgamemenu as $key => $value)
		<li style="background-image: url('{!! $value->image !!}');">
			<div class="topgame-item">
				<a href="{{ url($value->url) }}">{!! $value->name !!}</a>
			</div>
		</li>
		@endforeach
	</ul>
</div>
@endif
@if($sidemenu)
<div class="side">
	<h3>Top game hay nhất năm</h3>
	<ul class="menu vertical sidemenu">
		@foreach($sidemenu as $key => $value)
		<li {{ checkCurrent(url($value->url)) }}><a href="{{ url($value->url) }}" class="hvr-icon-float-away">{!! $value->name !!}</a></li>
		@endforeach
	</ul>
	<div class="see-all">
		<a href="#"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Xem tất cả</a>
	</div>
</div>
@endif
@if($serimenu)
<div class="side">
	<h3>Dòng game hay</h3>
	<ul class="serimenu">
		@foreach($serimenu as $key => $value)
		<li>
			<div class="serimenu-item">
				<a href="{{ url($value->url) }}">
					<img src="{{ $value->image }}" alt="{!! $value->name !!}" title="{!! $value->name !!}">
					<span>{!! $value->name !!}</span>
				</a>
			</div>
		</li>
		@endforeach
	</ul>
	<div class="see-all">
		<a href="#"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Xem tất cả</a>
	</div>
</div>
@endif
@if($tagmenu)
<div class="side">
	<h3>Thể loại</h3>
	<ul class="tagmenu">
		@foreach($tagmenu as $key => $value)
		<li><h2><a href="{{ url($value->url) }}" title="{!! $value->name !!}">{!! $value->name !!}</a></h2></li>
		@endforeach
	</ul>
</div>
@endif