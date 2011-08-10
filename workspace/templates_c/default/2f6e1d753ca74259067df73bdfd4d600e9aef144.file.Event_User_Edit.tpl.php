<?php /* Smarty version Smarty-3.0.7, created on 2011-08-07 14:51:50
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_User_Edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3093699194e3e8a666154d7-14092602%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2f6e1d753ca74259067df73bdfd4d600e9aef144' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_User_Edit.tpl',
      1 => 1312135396,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3093699194e3e8a666154d7-14092602',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/include/extralib/smarty/plugins/function.html_options.php';
if (!is_callable('smarty_modifier_date_format')) include '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/include/extralib/smarty/plugins/modifier.date_format.php';
?><div id="partner_edit" style="width:400px" >
<?php if ($_smarty_tpl->getVariable('user')->value['UserID']>0){?>
<div id="perm_parent"><div id="perm_content" style="display: none;"></div>
<div id="perm_button" onclick="getPermissions('perm_content',this);">Show Custom Permissions</div></div>
<?php }?>
<br><p id="errorfeld" class="showError"></p><br>
<form action="/user_list/save" onsubmit="if(saveUser())sendAjaxForm(this,'#ajax_content'); return false;" method="POST">

<?php if ($_smarty_tpl->getVariable('user')->value['UserID']>0){?>
<input type="hidden" name="uid" value="<?php echo $_smarty_tpl->getVariable('user')->value['UserID'];?>
">

<table width="100%"><tr>
<td width="33%" align=left onclick="editUserKontakt('<?php echo $_smarty_tpl->getVariable('user')->value['UserID'];?>
');" valign="middle"  style="cursor: pointer; ">&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
arrow_left_green.png" align="left">Kontakt</td>
<td width="33%" align=center onclick="clearWaitStatusDocument();" valign="middle"  style="cursor: pointer;" ><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
exit.png" ></td>
<td width="33%" align=right onclick="editUserPerson('<?php echo $_smarty_tpl->getVariable('user')->value['UserID'];?>
');" valign="middle"  style="cursor: pointer;">Person<img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
arrow_right_green.png" align="right">&nbsp;&nbsp;</td>
</tr></table>
<?php }?>
<table>
<?php if ($_smarty_tpl->getVariable('user')->value['UserID']>0){?>
<tr><td>ID</td><td><?php echo $_smarty_tpl->getVariable('user')->value['UserID'];?>
</td></tr>
<?php }?>
<tr><td>Login</td><td><input type="text" name="Login" value="<?php echo $_smarty_tpl->getVariable('user')->value['Login'];?>
"></td></tr>
<tr><td>Kennwort</td><td><input type="password" name="Pass" id="Pass" value="" onkeyup="checkPassword()"></td></tr>
<tr><td>Kennwort2</td><td><input type="password" name="Pass2" id="Pass2" value="" onkeyup="checkPassword()"></td></tr>
<tr><td>Active</td><td><?php echo smarty_function_html_options(array('name'=>'Active','options'=>$_smarty_tpl->getVariable('myOptions')->value,'selected'=>$_smarty_tpl->getVariable('mySelect')->value),$_smarty_tpl);?>
</td></tr>

<tr>
	<td colspan=2 align="center"><br><br><input type="submit" value="Änderung Speichern" name="save"></td>
</tr>
<?php if ($_smarty_tpl->getVariable('save')->value==true){?>
<tr>
	<td colspan=2 align="center"><br><br>Änderung ist gespeichert.<br><?php echo smarty_modifier_date_format(time(),"%d-%m-%Y %H:%M:%S");?>
 <br>Das Fenster schlißen und Benutzerliste aktualisieren
	<a href="/user_list"><img src="/stylespace/<?php echo $_smarty_tpl->getVariable('FG_SPACE')->value;?>
/images/exit.png" border=0></a></td>
</tr>
<?php }?>
</table>
</form>

</div>