<?php /* Smarty version Smarty-3.0.7, created on 2011-08-08 09:46:47
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/kategory.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11342324224e3c3fea8f1856-94624383%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21a184afc64b7aca858a5d28b08dc2c51db26573' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/kategory.tpl',
      1 => 1312783667,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11342324224e3c3fea8f1856-94624383',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php  $_smarty_tpl->tpl_vars['tmp'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('wvkontent')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['tmp']->key => $_smarty_tpl->tpl_vars['tmp']->value){
?>
<li><a href="/crypt_catalog/<?php echo $_smarty_tpl->tpl_vars['tmp']->value['name'];?>
" class="button"><?php echo $_smarty_tpl->tpl_vars['tmp']->value['LNG'];?>
</a></li>
<?php }} ?>            