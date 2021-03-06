<script type="text/javascript" src="/adminlte/plugins/tinymce/tinymce.min.js"></script>
<link rel="stylesheet" type="text/css" href="/adminlte/plugins/fancybox/source/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="/adminlte/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<style type=text/css>.fancybox-inner {height:500px !important;}</style>
<script type="text/javascript">
	$(function () {
		$(".iframe-btn").fancybox({"width":900,"height":500,"type":"iframe","autoScale":false});
		tiny_mce();
		tinyMCE.get('textarea.elm1').setContent(tinyMCE.get('textarea.elm1').getContent()+_newdata);
		tinyMCE.triggerSave();
	});
	function tiny_mce()
	{
	    tinymce.init({
	    	entity_encoding : "raw", // TinyMCE UTF-8 saving to MySQL Database
	        selector: "textarea.elm1",
	        theme: "modern",
	        width: 700,
	        height: 400,
	        // width: 800,
	        // height: 300,
	//        language: 'vi',
	        plugins: [
	             "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
	             "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
	             "save table contextmenu directionality emoticons template paste textcolor"
	       ],
   			content_css: "/adminlte/plugins/tinymce/skins/lightgray/content.min.css",
			toolbar: "undo redo | bold italic | formatselect fontselect fontsizeselect | forecolor backcolor | removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image media | link unlink | mybutton mybutton2 mybutton3",

   			//add more button
			setup: function (editor) {
				editor.addButton('mybutton', {
				  type: 'listbox',
				  text: 'Chèn',
				  icon: false,
				  onselect: function (e) {
				    editor.insertContent(this.value());
				  },
				  values: [
				    { text: 'Torrent', value: '<p><img alt="Torrent Download" src="/img/torrent.png" /></p>' },
				    { text: 'Mediafire', value: '<p><img alt="Mediafire Download" src="/img/mediafire.png" /></p>' },
				    { text: 'Mega', value: '<p><img alt="Mega Download" src="/img/mega.png" /></p>' },
				    { text: 'Drive', value: '<p><img alt="Google Drive Download" src="/img/gdrive.png" /></p>' },
				    { text: 'Fshare', value: '<p><img alt="Fshare Download" src="/img/fshare.png" /></p>' }
				  ],
				  onPostRender: function () {
				    // Select the second item by default
				    this.value('&nbsp;<em>Some italic text!</em>');
				  }
				});

				editor.addButton('mybutton2', {
					text: 'Download',
					onclick : function() {
						editor.insertContent('<p class="clearfix"><a href="#" class="a-btn" rel="nofollow"><span class="a-btn-symbol">Z</span><span class="a-btn-text">Download Now</span><span class="a-btn-slide-text">Tải game hay cho PC</span><span class="a-btn-slide-icon">&nbsp;</span></a></p>');
						// editor.windowManager.alert('Hello world!! Selection: ' + editor.selection.getContent({format : 'text'}));
					}
				});

				editor.addButton('mybutton3', {
					text: 'Help',
					onclick : function() {
						editor.insertContent('<p class="clearfix"><a href="/huong-dan-tai-game-bang-torrent" title="Hướng dẫn tải game bằng torrent">Tham khảo hướng dẫn cách tải game bằng link torrent</a></p>');
					}
				});

			},
		  	//end add more button
	       
	       style_formats: [
	            {title: 'Bold text', inline: 'b'},
	            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
	            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
	            {title: 'Example 1', inline: 'span', classes: 'example1'},
	            {title: 'Example 2', inline: 'span', classes: 'example2'},
	            {title: 'Table styles'},
	            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
	        ],
	        relative_urls: false,
	        remove_script_host: false,
	        invalid_elements : "div,script,abbr,acronym,address,applet,area,bdo,big,blockquote,button,caption,cite,code,col,colgroup,dd,del,dfn,input,ins,isindex,kbd,label,legend,map,menu,noscript,optgroup,option,param,textarea,var,ruby,samp,select,rtc,hr",
	        extended_valid_elements : "iframe[src|width|height|name|align]",
	//        paste_as_text: true,
	//        paste_word_valid_elements: "b,strong,i,em,h1,h2",
	//        paste_webkit_styles: "color font-size",
	//        paste_retain_style_properties: "color font-size",
	//        paste_merge_formats: false,
	//        paste_convert_word_fake_lists: false,
	        external_filemanager_path:"/adminlte/plugins/tinymce/plugins/filemanager/",
	        filemanager_title:"Quản lý tập tin" ,
	        filemanager_access_key:"{{ AKEY }}",
	        external_plugins: { "filemanager" : "plugins/filemanager/plugin.min.js"}
	     });
	}
	//anh thumb
	function GetFilenameFromPath()
	{
	    var filePath = $('#url_abs').val();
	    var first_url = filePath.substring(0,filePath.lastIndexOf("/")+1);
	    var last_url = filePath.substring(filePath.lastIndexOf("/")+1);
	    $('#url_abs').val(first_url + 'thumb/' + last_url);
	}
	function GetFilenameFromPath2(id, thumb='')
	{
	    var filePath = $('#'+id).val();
	    var first_url = filePath.substring(0,filePath.lastIndexOf("/")+1);
	    var last_url = filePath.substring(filePath.lastIndexOf("/")+1);
	    if(thumb=='') {
	    	$('#'+id).val(first_url + last_url);
	    } else {
	    	$('#'+id).val(first_url + 'thumb/' + last_url);
	    }
	}
</script>