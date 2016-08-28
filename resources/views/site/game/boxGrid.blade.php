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
	@endforeach
</div>