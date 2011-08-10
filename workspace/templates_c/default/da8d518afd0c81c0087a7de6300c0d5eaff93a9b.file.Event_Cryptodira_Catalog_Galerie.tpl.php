<?php /* Smarty version Smarty-3.0.7, created on 2011-08-08 22:08:33
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Cryptodira_Catalog_Galerie.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13498090234e40424120e3b2-08709855%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da8d518afd0c81c0087a7de6300c0d5eaff93a9b' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Cryptodira_Catalog_Galerie.tpl',
      1 => 1312783656,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13498090234e40424120e3b2-08709855',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
Galerie
<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('images')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
?>
<a href="/content/images/galerie/<?php echo $_smarty_tpl->tpl_vars['image']->value['FG_CRYPTO_CATALOG_ID'];?>
/<?php echo $_smarty_tpl->tpl_vars['image']->value['PATH'];?>
" class="galery">
<img  src="/content/images/galerie/<?php echo $_smarty_tpl->tpl_vars['image']->value['FG_CRYPTO_CATALOG_ID'];?>
/thumbs/<?php echo $_smarty_tpl->tpl_vars['image']->value['PATH'];?>
"/>
</a>
<?php }} ?>