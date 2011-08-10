<?php /* Smarty version Smarty-3.0.7, created on 2011-08-07 15:26:02
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_Partner_Edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1080573894e3e926a5a0377-21888654%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f59ade8939c8b8fc4ebf680fdb3072db60e3235' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_Partner_Edit.tpl',
      1 => 1312135396,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1080573894e3e926a5a0377-21888654',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/include/extralib/smarty/plugins/function.html_options.php';
?><div id="partner_edit" >
<?php if ($_smarty_tpl->getVariable('partner')->value['ID']>0){?>
<div id="perm_parent"><div id="perm_content" style="display: none;"></div>
<div id="perm_button" onclick="getPermissions('perm_content',this);">Show Custom Permissions</div></div>
<?php }?>
<br><br>
<form action="/partner_list/save" onsubmit="sendAjaxForm(this,'#ajax_content'); return false;" method="POST">

<?php if ($_smarty_tpl->getVariable('partner')->value['ID']>0){?>
<input type="hidden" name="pid" value="<?php echo $_smarty_tpl->getVariable('partner')->value['ID'];?>
">
<?php }?>
<table>
<?php if ($_smarty_tpl->getVariable('partner')->value['ID']>0){?>
<tr><td>ID</td><td><?php echo $_smarty_tpl->getVariable('partner')->value['ID'];?>
</td></tr>
<?php }?>
<tr><td>Name</td><td><input type="text" name="Name" value="<?php echo $_smarty_tpl->getVariable('partner')->value['Name'];?>
"></td></tr>
<tr><td>Info</td><td><textarea name="Info" ><?php echo $_smarty_tpl->getVariable('partner')->value['Info'];?>
</textarea></td></tr>
<tr><td>Active</td><td><?php echo smarty_function_html_options(array('name'=>'Active','options'=>$_smarty_tpl->getVariable('myOptions')->value,'selected'=>$_smarty_tpl->getVariable('mySelect')->value),$_smarty_tpl);?>
</td></tr>

<tr>
	<td colspan=2 align="center"><input type="submit" value="Änderung Speichern" name="save"></td>
</tr>
<?php if ($_smarty_tpl->getVariable('save')->value==true){?>
<tr>
	<td colspan=2 align="center"><br><br>Änderung ist gespeichert. <br>Das Fenster schlißen und Partnerliste aktualisieren
	<a href="/partner_list"><img src="/stylespace/<?php echo $_smarty_tpl->getVariable('FG_SPACE')->value;?>
/images/exit.png" border=0></a></td>
</tr>
<?php }?>
</table>
</form>

</div>