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