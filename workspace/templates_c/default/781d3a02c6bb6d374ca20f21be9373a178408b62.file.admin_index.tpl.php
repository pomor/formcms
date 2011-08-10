<?php /* Smarty version Smarty-3.0.7, created on 2011-08-08 22:00:39
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/maintemplates/admin_index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5288637504e3c484b730ad4-39412987%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '781d3a02c6bb6d374ca20f21be9373a178408b62' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/maintemplates/admin_index.tpl',
      1 => 1312783672,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5288637504e3c484b730ad4-39412987',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
<head>

<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('FG_STYLESPACE')->value;?>
/css/sysmain.css" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('FG_STYLESPACE')->value;?>
/js/_jquery.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('FG_STYLESPACE')->value;?>
/js/main.js"></script>

<?php echo $_smarty_tpl->getVariable('css_link')->value;?>
<?php echo $_smarty_tpl->getVariable('css_inline')->value;?>
<?php echo $_smarty_tpl->getVariable('js_link')->value;?>
<?php echo $_smarty_tpl->getVariable('js_inline')->value;?>

</head>
<body>
<div align=center>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['menu'][0][0]->function_getMenu(array('id'=>1,'template'=>'hauptmenu','path'=>'menustyles/'),$_smarty_tpl);?>

</div>

<div class="main" >
<?php echo $_smarty_tpl->getVariable('template_action')->value;?>

<hr>
</div>
</body>
</html>