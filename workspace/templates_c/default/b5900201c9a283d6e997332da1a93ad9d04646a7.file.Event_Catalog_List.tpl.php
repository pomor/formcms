<?php /* Smarty version Smarty-3.0.7, created on 2011-08-08 09:46:47
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Catalog_List.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1368094384e3c3fea0be3e9-04946031%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5900201c9a283d6e997332da1a93ad9d04646a7' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Catalog_List.tpl',
      1 => 1312783636,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1368094384e3c3fea0be3e9-04946031',
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
<?php $_smarty_tpl->tpl_vars['tid'] = new Smarty_variable($_smarty_tpl->tpl_vars['soft']->value['ID'], null, null);?>
      <!-- Programmblock klein anfang: 1x -->
            <div class="progklein">
                <div class="prtitel"><a href="/crypt_catalog/show/id/<?php echo $_smarty_tpl->tpl_vars['soft']->value['ID'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['soft']->value['NAME'];?>
" class="button"><?php $_smarty_tpl->smarty->_tag_stack[] = array('substrp', array('maxlen'=>20)); $_block_repeat=true; $_smarty_tpl->smarty->registered_plugins['block']['substrp'][0][0]->block_substrp(array('maxlen'=>20), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo $_smarty_tpl->tpl_vars['soft']->value['NAME'];?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['substrp'][0][0]->block_substrp(array('maxlen'=>20), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
                <!-- Plus V: wenn ein programm Versionen hat anfang -->
                <?php if ($_smarty_tpl->tpl_vars['soft']->value['LINECOUNTER']>1){?>
                <div class="plusv">
                	<a href="/crypt_catalog/show/id/<?php echo $_smarty_tpl->tpl_vars['soft']->value['ID'];?>
" title="<?php echo $_smarty_tpl->getVariable('catalog_lang')->value['more_versions'];?>
">
                	<img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
plusv_button.png" width="19" height="19" alt="" border="0">
                	</a>
                </div>
                <?php }?>
                <!-- Plus V ende -->
                </div>
                <div class="prbild"><a href="/crypt_catalog/show/id/<?php echo $_smarty_tpl->tpl_vars['soft']->value['ID'];?>
" class="button" title="<?php echo $_smarty_tpl->tpl_vars['soft']->value['NAME'];?>
"><img src="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['soft']->value['ICON'])===null||$tmp==='' ? ($_smarty_tpl->getVariable('IMAGES_PATH')->value)."/bicon.png" : $tmp);?>
" width="48" height="48" alt="" border="0"></a></div>
                <?php $_smarty_tpl->tpl_vars['katname'] = new Smarty_variable($_smarty_tpl->tpl_vars['soft']->value['WF_KATEGORY'], null, null);?>
                <div class="prcategory"><a href="/crypt_catalog/show/id/<?php echo $_smarty_tpl->tpl_vars['soft']->value['ID'];?>
" class="button"><?php echo $_smarty_tpl->getVariable('kataloglist')->value[$_smarty_tpl->getVariable('katname')->value];?>
</a></div>
                <div class="prbewertung"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
sterne4.png" width="83" height="15" alt=""> [33]</div>
                <div class="prbutton">
                    <div class="<?php if (isset($_smarty_tpl->getVariable('mysoft',null,true,false)->value[$_smarty_tpl->getVariable('tid',null,true,false)->value])){?>active<?php }else{ ?>iwill<?php }?>"><a href="/crypt_catalog/show/id/<?php echo $_smarty_tpl->tpl_vars['soft']->value['ID'];?>
" class="button" title="<?php echo $_smarty_tpl->getVariable('catalog_lang')->value['Programm_installieren'];?>
"><?php if (isset($_smarty_tpl->getVariable('mysoft',null,true,false)->value[$_smarty_tpl->getVariable('tid',null,true,false)->value])){?><?php echo $_smarty_tpl->getVariable('catalog_lang')->value['installed'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('catalog_lang')->value['i_wish'];?>
<?php }?></a></div>
                    <div class="plus"><a href="#" onclick="addToFavorite(<?php echo $_smarty_tpl->tpl_vars['soft']->value['ID'];?>
,12300,this,false); return false;" class="button" title="<?php echo $_smarty_tpl->getVariable('catalog_lang')->value['favorit_insert'];?>
"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
_neue-buttons/<?php if (isset($_smarty_tpl->getVariable('favoritelist',null,true,false)->value[$_smarty_tpl->getVariable('tid',null,true,false)->value])){?>plus_klein_gruen<?php }else{ ?>plus_klein_grau<?php }?>.png" width="20" height="20" alt="" border="0"></a></div>
                </div>
            </div>
      <!-- programmblock klein ende: 1x  -->
<?php }} ?>

<div class="clear"></div>
</div>


