<?php /* Smarty version Smarty-3.0.7, created on 2011-08-07 00:22:27
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/menu/Event_Menu_Admin_Item_Show.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6809433434e3dbea392c081-51784374%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '545ebc2cb92ea892cb195006fe138f332aa48a68' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/menu/Event_Menu_Admin_Item_Show.tpl',
      1 => 1312135396,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6809433434e3dbea392c081-51784374',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/include/extralib/smarty/plugins/modifier.date_format.php';
?><div id="partner_edit" style="width:600px; height:500px" >
<?php if (isset($_smarty_tpl->getVariable('item',null,true,false)->value['ID'])){?>
<div id="perm_parent"><div id="perm_content" style="display: none;"></div>
<div id="perm_button" onclick="getPermissions('perm_content',this);">Show Custom Permissions</div></div>
<?php }?>
<br><br>
<form action="/menu_admin/menusave/gid/<?php echo $_smarty_tpl->getVariable('gid')->value;?>
" onsubmit="sendAjaxForm(this,'#ajax_content'); return false;" method="POST">

<?php if (isset($_smarty_tpl->getVariable('item',null,true,false)->value['ID'])){?>
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->getVariable('item')->value['ID'];?>
">
<?php }?>

<div>ID: &nbsp; <?php echo (($tmp = @$_smarty_tpl->getVariable('item')->value['ID'])===null||$tmp==='' ? 'New' : $tmp);?>
</div>

<table width="550">
<tr><td>Sysname:<br><input type="text" name="Name" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('item')->value['Name'])===null||$tmp==='' ? '' : $tmp);?>
" style="width:100%" maxlength=255></td></tr>
<tr><td>URL:<br><input type="text" name="Url" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('item')->value['Url'])===null||$tmp==='' ? '' : $tmp);?>
" style="width:100%" maxlength=255></td></tr>
<tr><td>Menu Event:<br><input type="text" name="Event" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('item')->value['Event'])===null||$tmp==='' ? '' : $tmp);?>
" style="width:100%" maxlength=255></td></tr>
<?php  $_smarty_tpl->tpl_vars['vlang'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['nlang'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('langs')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vlang']->key => $_smarty_tpl->tpl_vars['vlang']->value){
 $_smarty_tpl->tpl_vars['nlang']->value = $_smarty_tpl->tpl_vars['vlang']->key;
?>
<?php $_smarty_tpl->tpl_vars['litem'] = new Smarty_variable((($tmp = @$_smarty_tpl->getVariable('item_lang')->value[$_smarty_tpl->getVariable('nlang')->value])===null||$tmp==='' ? '' : $tmp), null, null);?>
<tr><td>Language <?php echo ((mb_detect_encoding($_smarty_tpl->tpl_vars['nlang']->value, 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtoupper($_smarty_tpl->tpl_vars['nlang']->value,SMARTY_RESOURCE_CHAR_SET) : strtoupper($_smarty_tpl->tpl_vars['nlang']->value));?>
:<br>
<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['nlang']->value;?>
_NAME" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('litem')->value['NAME'])===null||$tmp==='' ? '' : $tmp);?>
" style="width:100%" maxlength=255 ondblclick="$('#<?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
_INFO').toggle();">
<br><span><textarea id="<?php echo $_smarty_tpl->tpl_vars['nlang']->value;?>
_INFO" name="<?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
_INFO" cols=60 rows=10 style="width:100%; display: none;" ><?php echo (($tmp = @$_smarty_tpl->getVariable('litem')->value['INFO'])===null||$tmp==='' ? '' : $tmp);?>
</textarea></span>
</td></tr>



<?php }} ?>
</table>

<table width="550">
<tr>
	<td colspan=2 align="center"><br><br><input type="submit" value="Eintrag Speichern" name="save"></td>
</tr>
<?php if (isset($_smarty_tpl->getVariable('save',null,true,false)->value)&&$_smarty_tpl->getVariable('save')->value==true){?>
<tr>
	<td colspan=2 align="center"><br><br>Eintrag ist gespeichert.<br><?php echo smarty_modifier_date_format(time(),"%d-%m-%Y %H:%M:%S");?>
 <br>Das Fenster schlißen und Menuliste aktualisieren
	<a href="#" onclick="$('#form_menu_ord').submit(); return false;"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
exit.png" border=0></a></td>
</tr>
<?php }?>
</table>

</form>

</div>