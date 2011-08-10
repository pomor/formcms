<?php /* Smarty version Smarty-3.0.7, created on 2011-08-07 14:15:19
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/menu/Event_Menu_Admin_Group_Show.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8003496574e3e81d72c8563-04419021%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00d086f794ba8b57bc91ab9c4891d225b25208e1' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/menu/Event_Menu_Admin_Group_Show.tpl',
      1 => 1312135396,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8003496574e3e81d72c8563-04419021',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/include/extralib/smarty/plugins/modifier.date_format.php';
?><div id="partner_edit" style="width:400px; height:500px" >
<?php if (isset($_smarty_tpl->getVariable('item',null,true,false)->value['ID'])){?>
<div id="perm_parent"><div id="perm_content" style="display: none;"></div>
<div id="perm_button" onclick="getPermissions('perm_content',this);">Show Custom Permissions</div></div>
<?php }?>
<br><br>
<form action="/menu_admin/groupsave" onsubmit="sendAjaxForm(this,'#ajax_content'); return false;" method="POST">

<?php if (isset($_smarty_tpl->getVariable('item',null,true,false)->value['ID'])){?>
<input type="hidden" name="gid" value="<?php echo $_smarty_tpl->getVariable('item')->value['ID'];?>
">
<?php }?>


<table width="300">
<tr><td>Name:<br><input type="text" name="NAME" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('item')->value['NAME'])===null||$tmp==='' ? '' : $tmp);?>
" style="width:100%" maxlength=255></td></tr>
<tr><td>Info:<br><input type="text" name="INFO" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('item')->value['INFO'])===null||$tmp==='' ? '' : $tmp);?>
" style="width:100%" maxlength=255></td></tr>
<tr><td align="center"><br><br><input type="submit" value="Gruppe Speichern" name="save"></td></tr>
</table>

<table width="300">
<?php if (isset($_smarty_tpl->getVariable('save',null,true,false)->value)&&$_smarty_tpl->getVariable('save')->value==true){?>
<tr>
	<td colspan=2 align="center"><br><br>Eintrag ist gespeichert.<br><?php echo smarty_modifier_date_format(time(),"%d-%m-%Y %H:%M:%S");?>

</td>
</tr>
<?php }?>
<tr><td align=center><br>Das Fenster schlißen und Itemliste aktualisieren
	<a href="/menu_admin"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
exit.png" border=0></a></td></tr>
</table>

</form>

</div>