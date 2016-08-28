<div class="fullscreen"><a id="fsbutton"><i class="fa fa-television" aria-hidden="true"></i> Chơi ở chế độ toàn hình</a></div>
<span id="fsstatus"></span>
<style>
	#specialstuff {
		background: #33e;
		padding: 20px;
		margin: 20px;
		color: #fff;
	}
	#specialstuff a {
		color: #eee;
	}
	#fsstatus {
		background: #e33;
		color: #111;
		display: none;
	}
	#fsstatus.fullScreenSupported {
		background: #3e3;
	}
</style>
<script>
/*
Native FullScreen JavaScript API
-------------
Assumes Mozilla naming conventions instead of W3C for now
*/
(function() {
	var
		fullScreenApi = {
			supportsFullScreen: false,
			isFullScreen: function() { return false; },
			requestFullScreen: function() {},
			cancelFullScreen: function() {},
			fullScreenEventName: '',
			prefix: ''
		},
		browserPrefixes = 'webkit moz o ms khtml'.split(' ');
	// check for native support
	if (typeof document.cancelFullScreen != 'undefined') {
		fullScreenApi.supportsFullScreen = true;
	} else {
		// check for fullscreen support by vendor prefix
		for (var i = 0, il = browserPrefixes.length; i < il; i++ ) {
			fullScreenApi.prefix = browserPrefixes[i];

			if (typeof document[fullScreenApi.prefix + 'CancelFullScreen' ] != 'undefined' ) {
				fullScreenApi.supportsFullScreen = true;

				break;
			}
		}
	}
	// update methods to do something useful
	if (fullScreenApi.supportsFullScreen) {
		fullScreenApi.fullScreenEventName = fullScreenApi.prefix + 'fullscreenchange';

		fullScreenApi.isFullScreen = function() {
			switch (this.prefix) {
				case '':
					return document.fullScreen;
				case 'webkit':
					return document.webkitIsFullScreen;
				default:
					return document[this.prefix + 'FullScreen'];
			}
		}
		fullScreenApi.requestFullScreen = function(el) {
			return (this.prefix === '') ? el.requestFullScreen() : el[this.prefix + 'RequestFullScreen']();
		}
		fullScreenApi.cancelFullScreen = function(el) {
			return (this.prefix === '') ? document.cancelFullScreen() : document[this.prefix + 'CancelFullScreen']();
		}
	}
	// jQuery plugin
	if (typeof jQuery != 'undefined') {
		jQuery.fn.requestFullScreen = function() {

			return this.each(function() {
				var el = jQuery(this);
				if (fullScreenApi.supportsFullScreen) {
					fullScreenApi.requestFullScreen(el);
				}
			});
		};
	}
	// export api
	window.fullScreenApi = fullScreenApi;
})();
</script>
<script>
// do something interesting with fullscreen support
var fsButton = document.getElementById('fsbutton'),
	fsElement = document.getElementById('my-iframe'),
	fsStatus = document.getElementById('fsstatus');
if (window.fullScreenApi.supportsFullScreen) {
	fsStatus.innerHTML = 'YES: Your browser supports FullScreen';
	fsStatus.className = 'fullScreenSupported';
	// handle button click
	fsButton.addEventListener('click', function() {
		window.fullScreenApi.requestFullScreen(fsElement);
	}, true);
	fsElement.addEventListener(fullScreenApi.fullScreenEventName, function() {
		if (fullScreenApi.isFullScreen()) {
			fsStatus.innerHTML = 'Whoa, you went fullscreen';
		} else {
			fsStatus.innerHTML = 'Back to normal';
		}
	}, true);
} else {
	fsStatus.innerHTML = 'SORRY: Your browser does not support FullScreen';
}
</script>