@if($bottommenu)
<div class="bottom">
	<div class="row column">
		<h3>Có thể bạn quan tâm</h3>
	</div>
	<div class="row small-up-1 medium-up-3 large-up-4">
		@foreach($bottommenu as $key => $value)
		<div class="column">
			<div class="bottom-item">
				<a href="{{ url($value->url) }}" title="{!! $value->name !!}">{!! $value->name !!}</a>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endif
<footer>
	<div class="row column">
		<p class="copy">© MMXVI <a href="/" target="_blank">gameofflinehay.com</a> - <span class="made-with-love">Made with ❤ in Heaven</span> - <a href="/chinh-sach-bao-mat">Privacy & Terms</a></p>
	</div>
</footer>