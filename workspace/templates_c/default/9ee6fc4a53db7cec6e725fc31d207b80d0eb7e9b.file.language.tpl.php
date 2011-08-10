<?php /* Smarty version Smarty-3.0.7, created on 2011-08-08 09:46:47
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/language.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2609146504e3c3fea6c1c24-07358126%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9ee6fc4a53db7cec6e725fc31d207b80d0eb7e9b' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/language.tpl',
      1 => 1312783670,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2609146504e3c3fea6c1c24-07358126',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('wvkontent')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
<li><div class="sprachicon"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getUri'][0][0]->function_getUri(array(),$_smarty_tpl);?>
?setlang=<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
flagge_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
.png" width="16" height="16" alt="" border="0"></a></div><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getUri'][0][0]->function_getUri(array(),$_smarty_tpl);?>
?setlang=<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a></li>
<?php }} ?>            