<div class="box-large">
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
	<div class="box-large-item">
		<div class="row">
			<div class="medium-4 columns">
				<div class="item">
					<a href="{{ $url }}" title="{!! $value->name !!}"{{ $seriClass }}>
						@if($checkSeri == true)
						<span><img src="{{ $value->image }}" alt="{!! $value->name !!}" title="{!! $value->name !!}"></span>
						@else
						<img src="{{ $value->image }}" alt="{!! $value->name !!}" title="{!! $value->name !!}">
						@endif
					</a>
				</div>
			</div>
			<div class="medium-8 columns">
				<h2><a href="{{ $url }}" title="{!! $value->name !!}">{!! $value->name !!}</a></h2>
				<p>{!! $value->summary !!}</p>
			</div>
		</div>
	</div>
	@endforeach
</div>