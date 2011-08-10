<?php /* Smarty version Smarty-3.0.7, created on 2011-08-07 14:53:58
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_Group_Edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16629452154e3e8ae696f0f0-36254830%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d8c25895f8ff570a6501f071b9954d75b88c484' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_Group_Edit.tpl',
      1 => 1312135396,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16629452154e3e8ae696f0f0-36254830',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/include/extralib/smarty/plugins/function.html_options.php';
if (!is_callable('smarty_modifier_date_format')) include '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/include/extralib/smarty/plugins/modifier.date_format.php';
?><div id="partner_edit" >
<?php if ($_smarty_tpl->getVariable('group')->value['ID']>0){?>
<div id="perm_parent"><div id="perm_content" style="display: none;"></div>
<div id="perm_button" onclick="getPermissions('perm_content',this);">Show Custom Permissions</div></div>
<?php }?>
<br><br>
<form action="/group_list/save" onsubmit="sendAjaxForm(this,'#ajax_content'); return false;" method="POST">

<?php if ($_smarty_tpl->getVariable('group')->value['ID']>0){?>
<input type="hidden" name="gid" value="<?php echo $_smarty_tpl->getVariable('group')->value['ID'];?>
">
<?php }?>
<table>
<?php if ($_smarty_tpl->getVariable('group')->value['ID']>0){?>
<tr><td>ID</td><td><?php echo $_smarty_tpl->getVariable('group')->value['ID'];?>
</td></tr>
<?php }?>
<tr><td>Name</td><td><input type="text" name="Name" value="<?php echo $_smarty_tpl->getVariable('group')->value['Name'];?>
"></td></tr>
<tr><td>Info</td><td><textarea name="Info" ><?php echo $_smarty_tpl->getVariable('group')->value['Info'];?>
</textarea></td></tr>
<tr><td>Active</td><td><?php echo smarty_function_html_options(array('name'=>'Active','options'=>$_smarty_tpl->getVariable('myOptions')->value,'selected'=>$_smarty_tpl->getVariable('mySelect')->value),$_smarty_tpl);?>
</td></tr>

<tr>
	<td colspan=2 align="center"><br><br><input type="submit" value="Änderung Speichern" name="save"></td>
</tr>
<?php if ($_smarty_tpl->getVariable('save')->value==true){?>
<tr>
	<td colspan=2 align="center"><br><br>Änderung ist gespeichert.<br><?php echo smarty_modifier_date_format(time(),"%d-%m-%Y %H:%M:%S");?>
 <br>Das Fenster schlißen und Gruppenliste aktualisieren
	<a href="/group_list"><img src="/stylespace/<?php echo $_smarty_tpl->getVariable('FG_SPACE')->value;?>
/images/exit.png" border=0></a></td>
</tr>
<?php }?>
</table>
</form>

</div>