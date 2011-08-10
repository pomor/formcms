<?php /* Smarty version Smarty-3.0.7, created on 2011-08-07 00:39:48
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_Permissions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19171633524e3dc2b48ceee0-03943421%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3d02f0c3d882e8cfde7c6e6862875697f86d36b' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_Permissions.tpl',
      1 => 1312135396,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19171633524e3dc2b48ceee0-03943421',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/include/extralib/smarty/plugins/function.html_options.php';
if (!is_callable('smarty_modifier_date_format')) include '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/include/extralib/smarty/plugins/modifier.date_format.php';
?><div id="div_permissions" >
<br>
<b>Custom Permissions</b>
<br><br>
<form action="/perm/save" onsubmit="sendAjaxForm(this,$('#div_permissions').parent()); return false;" method="POST">

<input type="hidden" name="oid" value="<?php echo $_smarty_tpl->getVariable('oid')->value;?>
">
<input type="hidden" name="otype" value="<?php echo $_smarty_tpl->getVariable('otype')->value;?>
">

<table>

<tr><td>Benutzer Rechte</td><td><?php echo smarty_function_html_options(array('name'=>'PERM_RECHTE','options'=>$_smarty_tpl->getVariable('perms')->value,'selected'=>$_smarty_tpl->getVariable('selperm')->value),$_smarty_tpl);?>
</td></tr>
<tr><td>Eingelogt</td><td><?php echo smarty_function_html_options(array('name'=>'LOGIN','options'=>$_smarty_tpl->getVariable('myOptions')->value,'selected'=>$_smarty_tpl->getVariable('sellogin')->value),$_smarty_tpl);?>
</td></tr>
<tr><td colspan=2>
<?php  $_smarty_tpl->tpl_vars['tmp'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('modulen')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['tmp']->key => $_smarty_tpl->tpl_vars['tmp']->value){
?>
<tr><td><?php echo $_smarty_tpl->tpl_vars['tmp']->value[0];?>
</td><td><?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['tmp']->value[1],'options'=>$_smarty_tpl->getVariable('myOptions')->value,'selected'=>$_smarty_tpl->tpl_vars['tmp']->value[2]),$_smarty_tpl);?>
</td></tr>
<?php }} ?>
</td>
</tr>
<tr>
	<td colspan=2 align="center"><input type="submit" value="Änderung Speichern" name="save"></td>
</tr>
<?php if ($_smarty_tpl->getVariable('save')->value==true){?>
<tr><td colspan=2 align="center"><br><br>Eintrag ist gespeichert.<br><?php echo smarty_modifier_date_format(time(),"%d-%m-%Y %H:%M:%S");?>
</td></tr>
<?php }?>

</table>
</form>

</div>