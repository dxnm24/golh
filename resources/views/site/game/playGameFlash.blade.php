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
	<object
		classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
		codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" 
		width="{{ $width }}" height="{{ $height }}" 
		id="preloader" 
		align="middle">
		<param name="allowScriptAccess" value="always" />
		<param name="allowFullScreen" value="false" />
		<param name="movie" value="{{ $url }}" type="application/x-shockwave-flash"></param>
		<param name="quality" value="high" />
		<param name="bgcolor" value="#ffffff" />
		<!-- <param name="wmode" value="transparent"></param> -->
		<param name="wmode" value="direct">
		<param name="flashvars" value="{{ $adCode }}" />
		<embed src="{{ $url }}" 
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
<script type="text/javascript">
	function removeAdSwf() {
		console.log(1);
		document.getElementById("game-ad").innerHTML = "";
		// document.getElementById("preloader").style.visibility = "hidden";
		document.getElementById("game-container").style.display="block";
	}
	function noAdsReturned() {
		console.log(2);
		document.getElementById("game-ad").innerHTML = "";
		// document.getElementById("preloader").style.visibility = "hidden";
		document.getElementById("game-container").style.display="block";
	}
</script>
@else
<div id="game-container" style="margin: 0 auto; width: {{ $widthBox }}; height: {{ $heightBox }};">
	<object
		classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
		codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" 
		width="100%" height="100%" 
		id="preloader" 
		align="middle">
		<param name="allowScriptAccess" value="always" />
		<param name="allowFullScreen" value="false" />
		<param name="movie" value="{{ $url }}" type="application/x-shockwave-flash"></param>
		<param name="quality" value="high" />
		<param name="bgcolor" value="#ffffff" />
		<!-- <param name="wmode" value="transparent"></param> -->
		<param name="wmode" value="direct">
		<param name="flashvars" value="{{ $adCode }}" />
		<embed src="{{ $url }}" 
			type="application/x-shockwave-flash" 
			quality="high" bgcolor="#000000" 
			width="100%" height="100%" 
			name="preloader" 
			align="middle" allowScriptAccess="always" 
			allowFullScreen="false" 
			flashVars="{{ $adCode }}" 
			pluginspage="http://www.adobe.com/go/getflashplayer" 
			wmode="direct">
		</embed>
	</object>
</div>
@endif