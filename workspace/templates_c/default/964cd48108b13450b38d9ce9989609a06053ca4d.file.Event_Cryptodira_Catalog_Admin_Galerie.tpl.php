<?php /* Smarty version Smarty-3.0.7, created on 2011-08-09 17:19:52
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Cryptodira_Catalog_Admin_Galerie.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5774304414e415018ab0ae7-03237178%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '964cd48108b13450b38d9ce9989609a06053ca4d' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Cryptodira_Catalog_Admin_Galerie.tpl',
      1 => 1312903191,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5774304414e415018ab0ae7-03237178',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

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


<div id="dropbox" style="min-height: 100px;">
<div id="imagelist">
<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('images')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
?>
<a href="/content/images/galery/<?php echo $_smarty_tpl->tpl_vars['image']->value['FG_CRYPTO_CATALOG_ID'];?>
/<?php echo $_smarty_tpl->tpl_vars['image']->value['PATH'];?>
" class="galery">
<img  src="/content/images/galery/<?php echo $_smarty_tpl->tpl_vars['image']->value['FG_CRYPTO_CATALOG_ID'];?>
/thumbs/<?php echo $_smarty_tpl->tpl_vars['image']->value['PATH'];?>
"/>
</a>
<?php }} ?>
</div>
<br clear="all"/>
</div>

<p id="detector">&nbsp;</p> 
