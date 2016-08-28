<?php 
	// if(isset($data[0]->seri) && $data[0]->seri == ACTIVE) {
	if(isset($data->seri) && $data->seri == ACTIVE) {
		$checkSeri = true;
		$seriClass = ' class=seri';
		$url0 = CommonUrl::getUrl2($type->slug, $data[0]->slug);
	} else {
		$checkSeri = false;
		$seriClass = '';
		$url0 = CommonUrl::getUrl($data[0]->slug);
	}
?>
<div class="row box-large">
	<div class="medium-4 columns">
		<div class="item">
			<a href="{{ $url0 }}" title="{!! $data[0]->name !!}"{{ $seriClass }}>
				@if($checkSeri == true)
				<span><img src="{{ $data[0]->image }}" alt="{!! $data[0]->name !!}" title="{!! $data[0]->name !!}"></span>
				@else
				<img src="{{ $data[0]->image }}" alt="{!! $data[0]->name !!}" title="{!! $data[0]->name !!}">
				@endif
			</a>
		</div>
	</div>
	<div class="medium-8 columns">
		<h2><a href="{{ $url0 }}" title="{!! $data[0]->name !!}">{!! $data[0]->name !!}</a></h2>
		<p>{!! $data[0]->summary !!}</p>
	</div>
</div>
<div class="row small-up-2 medium-up-4 large-up-5">
	@foreach($data as $key => $value)
	<?php 
		// if(isset($value->seri) && $value->seri == ACTIVE) {
		if(isset($data->seri) && $data->seri == ACTIVE) {
			$checkSeri = true;
			$seriClass = ' class=seri';
			$url = CommonUrl::getUrl2($type->slug, $value->slug);
		} else {
			$checkSeri = false;
			$seriClass = '';
			$url = CommonUrl::getUrl($value->slug);
		}
	?>
	@if($key>0)
	<div class="column">
		<div class="callout item">
			<!-- 400x370 -->
			<a href="{{ $url }}" title="{!! $value->name !!}"{{ $seriClass }}>
				@if($checkSeri == true)
				<span><img src="{{ $value->image }}" alt="{!! $value->name !!}" title="{!! $value->name !!}"></span>
				@else
				<img src="{{ $value->image }}" alt="{!! $value->name !!}" title="{!! $value->name !!}">
				@endif
			</a>
			<h2><a href="{{ $url }}" title="{!! $value->name !!}">{!! $value->name !!}</a></h2>
		</div>
	</div>
	@endif
	@endforeach
</div>