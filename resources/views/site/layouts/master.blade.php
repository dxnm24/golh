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

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
