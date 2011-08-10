<?php /* Smarty version Smarty-3.0.7, created on 2011-08-09 07:35:21
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Cryptodira_Catalog_Admin_Soft.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16666053404e40c719bf8234-48648843%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9771968607c8ebde80dd27d51aae8b01b25b8fa1' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Cryptodira_Catalog_Admin_Soft.tpl',
      1 => 1312836640,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16666053404e40c719bf8234-48648843',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/include/extralib/smarty/plugins/function.html_options.php';
if (!is_callable('smarty_modifier_date_format')) include '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/include/extralib/smarty/plugins/modifier.date_format.php';
?>
<script>



$(document).ready(function(){
	var $tabs = $("#tabs").tabs();
	$tabs.tabs("select",0);

	var $tabs1 = $("#tabs1").tabs();
	$tabs1.tabs("select",0);

	setScEditor();
});



	var manager = new ImageManager('/extmodule/ImageManager','en');

    ImageSelector =
	{
		update : function(params)
		{

			if(this.field && this.field.value != null)
			{
				this.field.value = params.f_file; //params.f_url
				this.imageDIV.attr('src',params.f_file);

			}
		},
		select: function(textfieldID,imageDIV,bw,bh)
		{
			this.field = document.getElementById(textfieldID);
            this.imageDIV=$(imageDIV).children('img');
            this.bw=bw;
            this.bh=bh;

			manager.popManager(this);
		}
	};



    function showKategory()
    {
    	setWaitStatusDocument(document);

    	$.get("/crypt_admin/kategory_show",{id:0},
    		function(data){
    			$("#ajax_content").html(data);
    		});
    }


    function addKategory(id,name)
    {
        $('#WF_KATEGORY').append(new Option(name,id,true,true));
        clearWaitStatusDocument();
    }

    function showLine($id)
    {
    	$('#edit_content').hide();
    	$.get("/crypt_admin/line_show/id/"+$id,
    			function(data){
    				$("#edit_content").html(data);
    				setScEditor(".visualEditor1");
    				var $tabs1 = $("#tabs2").tabs();
    				$tabs1.tabs("select",0);
    				$('#edit_content').slideDown();
    			});

    }

    function showVersion($id,$lid)
    {
        $('#edit_content').hide();
        $.get("/crypt_admin/version_show/id/"+$id+"/lid/"+$lid,
    			function(data){
    				$("#edit_content").html(data);
    				$('#edit_content').slideDown();

    			});

    }


    function getLines()
    {
        $('#lines_list').hide();
        $.get("/crypt_admin/line_list",
    			function(data){
    				$("#lines_list").html(data);
    				$('#lines_list').slideDown();

    			});

    }
    
    
    function sendAjaxFormLine(formobj,showobject)
    {
    	updateScEditor(".visualEditor1");
    	var content = $(formobj).serialize();

    	var act=$(formobj).attr('action')||'/index.php';

    	$.ajax({
    		url: act,
    		type: 'POST',
    		data: content,
    		dataType: "html",
    		success: function(data){
    			$(showobject).html(data);
    			setScEditor(".visualEditor1");
    			var $tabs1 = $("#tabs2").tabs();
    			$tabs1.tabs("select",0);
    		},
    		beforeSend: function(){
    			setWaitStatusKind(showobject);
    		}

    	});

    }


</script>


<div id="tabs1">

<ul>
<li><a href="#tabs1_soft">Soft</a></li>
<?php if (isset($_smarty_tpl->getVariable('soft',null,true,false)->value['ID'])){?>
<li><a href="#tabs1_line">Lines and Versions</a></li>
<li><a href="#tabs1_screens">Screenshots</a></li>

<?php }?>
</ul>


<div id="tabs1_soft">

<form action="/crypt_admin/soft_save"  method="POST">

<?php if (isset($_smarty_tpl->getVariable('soft',null,true,false)->value['ID'])){?>
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->getVariable('soft')->value['ID'];?>
">
<?php }?>
<input type="hidden" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('soft')->value['ICON'])===null||$tmp==='' ? '' : $tmp);?>
" name="ICON" id="ICON" />
<table >
<tr><td>ID</td><td><?php echo (($tmp = @$_smarty_tpl->getVariable('soft')->value['ID'])===null||$tmp==='' ? 'New' : $tmp);?>
</td></tr>
<tr><td>Icon</td><td style="cursor:pointer" onclick="ImageSelector.select('ICON',this,48,48);"><img src="<?php echo (($tmp = @$_smarty_tpl->getVariable('soft')->value['ICON'])===null||$tmp==='' ? ($_smarty_tpl->getVariable('IMAGES_PATH')->value)."/bicon.png" : $tmp);?>
"></td></tr>
<tr><td>Name</td><td><input type="text" name="NAME" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('soft')->value['NAME'])===null||$tmp==='' ? '' : $tmp);?>
" style="width:300px" maxlength=255"></td></tr>

<tr><td>Kategory</td><td>
<select name="WF_KATEGORY" id="WF_KATEGORY" style="width:300px">
<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('kategory')->value,'selected'=>(($tmp = @$_smarty_tpl->getVariable('soft')->value['WF_KATEGORY'])===null||$tmp==='' ? 0 : $tmp)),$_smarty_tpl);?>

</select>&nbsp;<a href="#" onclick="showKategory();return false;">add</a>
</td></tr>

<tr><td>Type</td><td>
<select name="WF_PAYTYPE" id="WF_PAYTYPE" style="width:300px">
<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('paytype')->value,'selected'=>(($tmp = @$_smarty_tpl->getVariable('soft')->value['WF_PAYTYPE'])===null||$tmp==='' ? 0 : $tmp)),$_smarty_tpl);?>

</select>
</td></tr>

<tr><td>Tags</td>
<td>
<textarea name="TAGS" style="width:300px" ><?php echo (($tmp = @$_smarty_tpl->getVariable('soft')->value['TAGS'])===null||$tmp==='' ? '' : $tmp);?>
</textarea></td>
</tr>

</table>

<br>

<div id="tabs">
<ul>
<?php  $_smarty_tpl->tpl_vars['vlang'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['nlang'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('langs')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vlang']->key => $_smarty_tpl->tpl_vars['vlang']->value){
 $_smarty_tpl->tpl_vars['nlang']->value = $_smarty_tpl->tpl_vars['vlang']->key;
?>
<li><a href="#tabs_<?php echo $_smarty_tpl->tpl_vars['nlang']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['vlang']->value;?>
</a></li>
<?php }} ?>
</ul>

<?php  $_smarty_tpl->tpl_vars['vlang'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['nlang'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('langs')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vlang']->key => $_smarty_tpl->tpl_vars['vlang']->value){
 $_smarty_tpl->tpl_vars['nlang']->value = $_smarty_tpl->tpl_vars['vlang']->key;
?>
<?php $_smarty_tpl->tpl_vars['item'] = new Smarty_variable((($tmp = @$_smarty_tpl->getVariable('item_lang')->value[$_smarty_tpl->getVariable('nlang')->value])===null||$tmp==='' ? '' : $tmp), null, null);?>
<div id="tabs_<?php echo $_smarty_tpl->tpl_vars['nlang']->value;?>
">
<table width="450">

<tr><td>Info:<br><textarea id="<?php echo $_smarty_tpl->tpl_vars['nlang']->value;?>
_INFO" name="<?php echo $_smarty_tpl->tpl_vars['nlang']->value;?>
_INFO" style="width:450px" rows=20 class="visualEditor"><?php echo (($tmp = @$_smarty_tpl->getVariable('item')->value['INFO'])===null||$tmp==='' ? '' : $tmp);?>
</textarea></td></tr>
<tr><td>AGB:<br><textarea id="<?php echo $_smarty_tpl->tpl_vars['nlang']->value;?>
_AGB" name="<?php echo $_smarty_tpl->tpl_vars['nlang']->value;?>
_AGB" style="width:450px"  rows=20 class="visualEditor"><?php echo (($tmp = @$_smarty_tpl->getVariable('item')->value['AGB'])===null||$tmp==='' ? '' : $tmp);?>
</textarea></td></tr>
</table>
</div>
<?php }} ?>
</div>

<table width="450">
<tr>
	<td colspan=2 align="center"><br><br><input type="submit" value="Eintrag Speichern" name="save"></td>
</tr>
<?php if (isset($_smarty_tpl->getVariable('save',null,true,false)->value)&&$_smarty_tpl->getVariable('save')->value==true){?>
<tr>
	<td colspan=2 align="center"><br><br>Eintrag ist gespeichert.<br><?php echo smarty_modifier_date_format(time(),"%d-%m-%Y %H:%M:%S");?>
 <br>Das Fenster schlißen und Softlist aktualisieren
	<a href="/crypt_admin"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
exit.png" border=0></a></td>
</tr>
<?php }?>
</table>

</form>
</div>
<?php if (isset($_smarty_tpl->getVariable('soft',null,true,false)->value['ID'])){?>
<div id="tabs1_line">
<a href="#" onclick="showLine(0); return false;">Add New Line</a>
<div id="edit_content" style="display: none;">&nbsp;</div>
<div id="lines_list">
<?php $_template = new Smarty_Internal_Template('cryptodira/Event_Cryptodira_Catalog_Admin_Lines_List.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
</div>
</div>

<div id="tabs1_screens">
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['event'][0][0]->function_getEvent(array('room'=>'cryptodira','class'=>'Event_Cryptodira_Galerie_Admin','method'=>'actionGalerieList'),$_smarty_tpl);?>

</div>
<?php }?>

</div>

