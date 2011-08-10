{literal}
<style>
<!--
#dropbox {
		border: 5px solid #ddd;
		background-color: #ddd;	
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		display: block;
	}
	
		
 
	#file_containor:hover {
		border: 5px outset #ccc;
	}
 
	#file_containor:active {
		border: 5px inset #ccc;
	}
 
	
	iframe {float: right}
	
	#dropbox a{
		float:left;			
	}
	
	#dropbox img{
		display: block;	
		padding:5px;	
	}
	
-->
</style>
<script type="text/javascript"> 
 
	//Log function to be called with html5-fileupload plugin.
	window.log = function (s) {
		try {
			console.log.apply(this, arguments);
		} catch (e) {
			try {
				// .apply() won't work in Chrome
				console.log(s);
			} catch (e) {
			}
		}
	};
 
	
	

$(function(){
 
	// Detector demo
	if (!$.fileUploadSupported) {
		$(document.body).addClass('not_supported');
		$('#detector').text('This browser is NOT supported.');
	} else {
		$('#detector').text('This browser is supported.');
	}
	
	
	// Enable plug-in
	$('#dropbox').fileUpload(
		{
			url: '/crypt_screen/add',
			type: 'POST',
			dataType: 'json',
			beforeSend: function () {
				$(document.body).addClass('uploading');
				
			},
			complete: function () {
				$(document.body).removeClass('uploading');
			},
			success: function (result, status, xhr) {				
				
				if (!result) {
					window.alert('Server error.');
					return;
				}
				if (result.STATUS != 'OK') {
					window.alert(result.STATUS);
					return;
				}

				$('<a href="'+result.DATA.IMAGE+'" class="galery"><img  src="'+
						result.DATA.THUMB+'"/></a>').appendTo($('#imagelist'));
			}
		}
	);

	
	// Provide page-wide dragover interaction
	$(document.body).bind(
		'dragenter',
		function () {
			$(this).addClass('dragging');
		}
	).bind(
		'dragleave',
		function () {
			$(this).removeClass('dragging');
		}
	);
	});	
</script> 
{/literal}

<div id="dropbox" style="min-height: 100px;">
<div id="imagelist">
{foreach $images as $image}
<a href="/content/images/galery/{$image.FG_CRYPTO_CATALOG_ID}/{$image.PATH}" class="galery">
<img  src="/content/images/galery/{$image.FG_CRYPTO_CATALOG_ID}/thumbs/{$image.PATH}"/>
</a>
{/foreach}
</div>
<br clear="all"/>
</div>

<p id="detector">&nbsp;</p> 
