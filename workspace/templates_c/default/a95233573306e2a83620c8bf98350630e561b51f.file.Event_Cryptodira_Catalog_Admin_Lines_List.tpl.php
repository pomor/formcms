<?php /* Smarty version Smarty-3.0.7, created on 2011-08-08 22:04:22
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Cryptodira_Catalog_Admin_Lines_List.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7060467894e3d1e0b880d31-31618674%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a95233573306e2a83620c8bf98350630e561b51f' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Cryptodira_Catalog_Admin_Lines_List.tpl',
      1 => 1312783646,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7060467894e3d1e0b880d31-31618674',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="lines_list">
<ul>
<?php  $_smarty_tpl->tpl_vars['line'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('soft')->value['lines']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['line']->key => $_smarty_tpl->tpl_vars['line']->value){
?>
<li><a href="#" class="soft_line" onclick="showLine(<?php echo $_smarty_tpl->tpl_vars['line']->value['ID'];?>
); return false;"><?php echo $_smarty_tpl->tpl_vars['line']->value['LNAME'];?>
</a>&nbsp;&nbsp;(<a href="#" onclick="showVersion(0,<?php echo $_smarty_tpl->tpl_vars['line']->value['ID'];?>
); return false;">+</a>)
<ul>
<?php  $_smarty_tpl->tpl_vars['versions'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['line']->value['versions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['versions']->key => $_smarty_tpl->tpl_vars['versions']->value){
?>
<li><a href="#" class="soft_version" onclick="showVersion(<?php echo $_smarty_tpl->tpl_vars['versions']->value['ID'];?>
,<?php echo $_smarty_tpl->tpl_vars['line']->value['ID'];?>
); return false;"><?php echo $_smarty_tpl->tpl_vars['versions']->value['VNAME'];?>
</a></li>
<?php }} ?>
</ul>
</li>
<?php }} ?>
</ul>
</div>