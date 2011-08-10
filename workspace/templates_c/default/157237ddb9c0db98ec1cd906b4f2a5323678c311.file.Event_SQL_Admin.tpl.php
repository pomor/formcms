<?php /* Smarty version Smarty-3.0.7, created on 2011-08-08 22:01:46
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_SQL_Admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13061986614e3e82b544b4b6-58301866%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '157237ddb9c0db98ec1cd906b4f2a5323678c311' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/admin/Event_SQL_Admin.tpl',
      1 => 1312783607,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13061986614e3e82b544b4b6-58301866',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<form action="/sql_admin" method="POST">
<textarea rows="10" cols="50" name="sql"></textarea><br>
<input type="submit" value="Send SQL request">
</form>
<?php  $_smarty_tpl->tpl_vars['elem'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('result')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['elem']->key => $_smarty_tpl->tpl_vars['elem']->value){
?>
<hr>

SQL:<?php echo $_smarty_tpl->tpl_vars['elem']->value['sql'];?>
<br>

<?php $_smarty_tpl->tpl_vars['items'] = new Smarty_variable($_smarty_tpl->tpl_vars['elem']->value['data'], null, null);?>
<table style="border:#cccccc 1px solid; border-collapse:collapse; " border=1 cellpadding=5>
<tr>
<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value[0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
<td style="font-weight:bold;"><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</td>
<?php }} ?>
</tr>

<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<tr >
<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
<td><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</td>
<?php }} ?>
</tr>
<?php }} ?>
</table>

<?php }} ?>