<?php /* Smarty version Smarty-3.0.7, created on 2011-08-08 22:00:39
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/menustyles/hauptmenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5513711324e3c484b772450-27817950%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '91f0cb36cd39bef80a11e918dc0d3bb1464de064' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/menustyles/hauptmenu.tpl',
      1 => 1312783693,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5513711324e3c484b772450-27817950',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="hauptmenu" class="menue" >
<ul>
<?php $_smarty_tpl->tpl_vars['last_level'] = new Smarty_variable(0, null, null);?>
<?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('menuar')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value){
?>
<?php if ($_smarty_tpl->getVariable('last_level')->value>0&&$_smarty_tpl->tpl_vars['menu']->value['lvl']<$_smarty_tpl->getVariable('last_level')->value){?>
<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['test']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['test']['name'] = 'test';
$_smarty_tpl->tpl_vars['smarty']->value['section']['test']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('last_level')->value-$_smarty_tpl->tpl_vars['menu']->value['lvl']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['test']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['test']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['test']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['test']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['test']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['test']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['test']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['test']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['test']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['test']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['test']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['test']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['test']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['test']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['test']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['test']['total']);
?>
</ul></li>
<?php endfor; endif; ?>
<?php }?>

<?php $_smarty_tpl->tpl_vars['last_level'] = new Smarty_variable($_smarty_tpl->tpl_vars['menu']->value['lvl'], null, null);?>

<li ><a href="<?php echo $_smarty_tpl->tpl_vars['menu']->value['url'];?>
" target="<?php echo $_smarty_tpl->tpl_vars['menu']->value['target'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['menu']->value['active']==true){?>active<?php }?>"><?php echo $_smarty_tpl->tpl_vars['menu']->value['text'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['menu']->value['parent']==true){?>
<ul>
<?php }else{ ?>
</li>
<?php }?>
<?php }} ?>
<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['test2']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['name'] = 'test2';
$_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('last_level')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['test2']['total']);
?>
</ul></li>
<?php endfor; endif; ?>
<br style="clear: left" />
</ul>
<br style="clear: left" />
</div>
