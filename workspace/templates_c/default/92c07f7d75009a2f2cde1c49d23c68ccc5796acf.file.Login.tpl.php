<?php /* Smarty version Smarty-3.0.7, created on 2011-08-08 09:46:47
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/Login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15427600554e3c3fea733089-77006786%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '92c07f7d75009a2f2cde1c49d23c68ccc5796acf' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/Login.tpl',
      1 => 1312783588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15427600554e3c3fea733089-77006786',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="anm_form">
<span style="color: #FF0000"><?php echo $_smarty_tpl->getVariable('error')->value;?>
</span>
<?php if (!$_smarty_tpl->getVariable('actUser')->value->isLogin()){?>

<form onsubmit="fg_AjaxLoad('#anm_form','/login',$(this).serialize()); return false;">


Login:<br />
<input type="text" name="login" tabindex="101" class="logform"><br /><br />
Password:<br />
<input type="password" name="pass" tabindex="102" class="logform"><br /><br />
<input type="submit" value="Login"  tabindex="103" class="logbutton">

</form>
<?php }else{ ?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['menu'][0][0]->function_getMenu(array('id'=>5,'template'=>'cd_top_menu','path'=>'menustyles/'),$_smarty_tpl);?>

<?php }?>
</div>