<?php /* Smarty version Smarty-3.0.7, created on 2011-08-10 08:15:10
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Catalog_Mysoft_List.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4913014794e4221ee93e4a7-01424434%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a79e7c2a3496f8fc11751b365cf369c27b2818fd' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Catalog_Mysoft_List.tpl',
      1 => 1312956905,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4913014794e4221ee93e4a7-01424434',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="padding10px">
<div class="titelblau1 borderblau2px"><?php echo (($tmp = @$_smarty_tpl->getVariable('catalog_title')->value)===null||$tmp==='' ? $_smarty_tpl->getVariable('catalog_lang')->value['Top_Rated_Programm'] : $tmp);?>
</div>
<br>
<?php  $_smarty_tpl->tpl_vars['soft'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['soft']->key => $_smarty_tpl->tpl_vars['soft']->value){
?>
<?php echo $_smarty_tpl->tpl_vars['soft']->value['ID'];?>
 / <?php echo $_smarty_tpl->tpl_vars['soft']->value['NAME'];?>
 <?php echo $_smarty_tpl->tpl_vars['soft']->value['LNAME'];?>
 <?php echo $_smarty_tpl->tpl_vars['soft']->value['VNAME'];?>
  inserted: <?php echo $_smarty_tpl->tpl_vars['soft']->value['CDATE'];?>
 

	<div class="prbutton">
	<div class="<?php if ($_smarty_tpl->tpl_vars['soft']->value['STATUS']==0){?>waitfull<?php }else{ ?>activefull<?php }?>"><a href="#" class="button"
		title="<?php echo $_smarty_tpl->getVariable('catalog_lang')->value['installed'];?>
" ><?php if ($_smarty_tpl->tpl_vars['soft']->value['STATUS']==0){?><?php echo $_smarty_tpl->getVariable('catalog_lang')->value['status_wait'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('catalog_lang')->value['installed'];?>
<?php }?></a></div>	
	</div> <?php if ($_smarty_tpl->tpl_vars['soft']->value['STATUS']==0){?>delete<?php }?>
	<!-- Iwill-Button ende -->
	<div class="clear"></div>
	
<br> 
<?php }} ?>

<div class="clear"></div>
</div>


