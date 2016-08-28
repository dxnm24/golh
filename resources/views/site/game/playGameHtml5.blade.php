<?php 
	$widthBox = ($width == '100%')?$width:$width.'px';
	$heightBox = ($height == '100%')?$height:$height.'px';
?>
@if($adCode != '')
<div id="game-ad">
	<object
		classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
		codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" 
		width="{{ $width }}" height="{{ $height }}" 
		id="preloader" 
		align="middle">
		<param name="allowScriptAccess" value="always" />
		<param name="allowFullScreen" value="false" />
		<param name="movie" value="{{ url('img/ima3_preloader_1.5.swf') }}" type="application/x-shockwave-flash"></param>
		<param name="quality" value="high" />
		<param name="bgcolor" value="#ffffff" />
		<param name="wmode" value="transparent"></param>
		<param name="flashvars" value="{{ $adCode }}" />
		<embed src="{{ url('img/ima3_preloader_1.5.swf') }}" 
			type="application/x-shockwave-flash" 
			quality="high" bgcolor="#000000" 
			width="{{ $width }}" height="{{ $height }}" 
			name="preloader" 
			align="middle" allowScriptAccess="always" 
			allowFullScreen="false" 
			flashVars="{{ $adCode }}" 
			pluginspage="http://www.adobe.com/go/getflashplayer" 
			wmode="direct">
		</embed>
	</object>
</div>
<div id="game-container" style="display:none; margin: 0 auto; width: {{ $widthBox }}; height: {{ $heightBox }};">
	<iframe name="my-iframe" id="my-iframe" width="100%" height="100%" src="{{ $url }}" scrolling="no" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" webkit-playsinline="true" seamless="seamless" style="-webkit-transform: scale(1, 1);
	-o-transform: scale(1, 1);
	-ms-transform: scale(1, 1);
	transform: scale(1, 1);
	-moz-transform-origin: top left;
	-webkit-transform-origin: top left;
	-o-transform-origin: top left;
	-ms-transform-origin: top left;
	transform-origin: top left;
	frameborder: 0px;">
	</iframe>
</div>
<script type="text/javascript">
	function removeAdSwf() {
		console.log(1);
		document.getElementById("game-ad").innerHTML = "";
		// document.getElementById("preloader").style.visibility = "hidden";
		document.getElementById("game-container").style.display="block";
		document.getElementById("my-iframe").contentWindow.location.reload();
	}
	function noAdsReturned() {
		console.log(2);
		document.getElementById("game-ad").innerHTML = "";
		// document.getElementById("preloader").style.visibility = "hidden";
		document.getElementById("game-container").style.display="block";
		document.getElementById("my-iframe").contentWindow.location.reload();
	}
</script>
@else
<div id="game-container" style="margin: 0 auto; width: {{ $widthBox }}; height: {{ $heightBox }};">
	<iframe name="my-iframe" id="my-iframe" width="100%" height="100%" src="{{ $url }}" scrolling="no" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" webkit-playsinline="true" seamless="seamless" style="-webkit-transform: scale(1, 1);
	-o-transform: scale(1, 1);
	-ms-transform: scale(1, 1);
	transform: scale(1, 1);
	-moz-transform-origin: top left;
	-webkit-transform-origin: top left;
	-o-transform-origin: top left;
	-ms-transform-origin: top left;
	transform-origin: top left;
	frameborder: 0px;">
	</iframe>
</div>
@endif