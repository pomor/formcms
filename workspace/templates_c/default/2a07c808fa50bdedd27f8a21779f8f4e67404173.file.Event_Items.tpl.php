<?php /* Smarty version Smarty-3.0.7, created on 2011-08-09 10:22:57
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/items/Event_Items.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4584639604e3c483fbb4fe6-16155487%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a07c808fa50bdedd27f8a21779f8f4e67404173' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/items/Event_Items.tpl',
      1 => 1312783662,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4584639604e3c483fbb4fe6-16155487',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="padding10px">
<div class="titelblau1 borderblau2px"><?php echo (($tmp = @$_smarty_tpl->getVariable('item')->value['TITLE'])===null||$tmp==='' ? 'Eintrag ist nicht erreichbar' : $tmp);?>
</div>
<div class="text"><?php echo (($tmp = @$_smarty_tpl->getVariable('item')->value['INFO'])===null||$tmp==='' ? '&nbsp;' : $tmp);?>
</div>
</div>