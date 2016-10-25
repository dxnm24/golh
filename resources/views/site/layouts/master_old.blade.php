@include('site.common.head')
<body>

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

@if(isset($isPlay) && $isPlay == true)
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{{ FACEBOOK_APPID }}',
      xfbml      : true,
      version    : 'v2.7'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
@endif

<div class="off-canvas-wrapper">
	<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
		<div class="off-canvas position-left offcanvas" id="offCanvasLeft" data-off-canvas data-position="left" aria-hidden="true">
			<button class="close-button" aria-label="Close menu" type="button" data-close="">
	        	<span aria-hidden="true">×</span>
	      	</button>
	      	<ul class="mobile-ofc vertical menu menu-mobile">
	      		<li class="title">Menu</li>
	      		@if($mobilemenu)
		      		@foreach($mobilemenu as $key => $value)
						<li {{ checkCurrent(url($value->url)) }}><a href="{{ $value->url }}">{!! $value->name !!}</a></li>
					@endforeach
				@endif
	      	</ul>
		</div>
		<div class="off-canvas-content" data-off-canvas-content>
			<div class="title-bar hide-for-medium">
				<div class="title-bar-left">
					<button class="menu-icon" type="button" data-open="offCanvasLeft" aria-expanded="false" aria-controls="offCanvasLeft"><span class="menu-button-text">&nbsp;</span></button>
      				<span class="title-bar-title">gameoffline</span>
				</div>
				<div class="title-bar-right">
					<button onclick="searchhide()" class="search-icon"></button>
				</div>
			</div>
			<div class="main">
				@include('site.common.top')
				@include('site.common.ad', ['posPc' => 1, 'posMobile' => 2])
				<div class="row">
					<div class="medium-8 columns">
						<div class="content">
							@yield('content')
						</div>
					</div>
					<div class="medium-4 columns">
						@include('site.common.side')
					</div>
				</div>
				@include('site.common.ad', ['posPc' => 3, 'posMobile' => 4])
				@include('site.common.bottom')
			</div>
		</div>
	</div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
