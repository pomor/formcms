<?php /* Smarty version Smarty-3.0.7, created on 2011-08-10 08:09:27
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Catalog_Item.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17233278624e42209787ba81-35419416%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f246c40abe1d5bd0b12094be3020c14345cf259a' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/cryptodira/Event_Catalog_Item.tpl',
      1 => 1312956565,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17233278624e42209787ba81-35419416',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="padding10px">
<!-- the tabs angang -->
	<ul class="tabs">
		<li><a href="#">Information</a></li>
		<li><a href="#">Screenshots</a></li>
		<li><a href="#">Komentare</a></li>
	</ul>
	<!-- the tabs ende --> 
	<!-- tab "panes" anfang -->
	<div class="panes"><!-- Beshcreibung Anfang -->
	<div class="pan">

	<div class="titelblau1 borderblau2px"><?php echo $_smarty_tpl->getVariable('item')->value['NAME'];?>
<div class="plus"><a href="#" onclick="addToFavorite(<?php echo $_smarty_tpl->getVariable('item')->value['ID'];?>
,12300,this,true); return false;" class="button" title="<?php echo $_smarty_tpl->getVariable('catalog_lang')->value['favorit_insert'];?>
"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
_neue-buttons/<?php if ($_smarty_tpl->getVariable('infavorite')->value){?>plus_full_gruen<?php }else{ ?>plus_full_grau<?php }?>.png" width="20" height="20" alt="" border="0"></a></div>
                </div>
	<!-- Lines "accordeon" Anfang -->
	<div id="accordion">
	
	<?php  $_smarty_tpl->tpl_vars['line'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('item')->value['lines']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['line']->key => $_smarty_tpl->tpl_vars['line']->value){
?>
	<?php if (!$_smarty_tpl->tpl_vars['line']->value['VID']){?><?php continue 1?><?php }?>
	<?php $_smarty_tpl->tpl_vars['tid'] = new Smarty_variable($_smarty_tpl->tpl_vars['line']->value['ID'], null, null);?>
	<!-- Version Tab Anfang -->
	<div class="lines">
	<div class="prtitel"
		title="<?php echo $_smarty_tpl->tpl_vars['line']->value['LNAME'];?>
"><?php echo $_smarty_tpl->tpl_vars['line']->value['LNAME'];?>
 &nbsp;-&nbsp; <?php echo $_smarty_tpl->tpl_vars['line']->value['VNAME'];?>
 </div>
	<div class="prdate">Aktualisiert: <?php echo $_smarty_tpl->tpl_vars['line']->value['UDATE'];?>
</div>
	<!-- Iwill-Button Anfang -->
	<div class="prbutton">
	<div class="<?php if (isset($_smarty_tpl->getVariable('mysoft',null,true,false)->value[$_smarty_tpl->getVariable('tid',null,true,false)->value])){?>activefull<?php }else{ ?>iwillfull<?php }?>"><a href="#" class="button"
		title="<?php echo $_smarty_tpl->getVariable('catalog_lang')->value['Programm_installieren'];?>
" onclick="addToMysoft(<?php echo $_smarty_tpl->tpl_vars['line']->value['ID'];?>
,this,true);return false;"><?php if (isset($_smarty_tpl->getVariable('mysoft',null,true,false)->value[$_smarty_tpl->getVariable('tid',null,true,false)->value])){?><?php echo $_smarty_tpl->getVariable('catalog_lang')->value['installed'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('catalog_lang')->value['Install'];?>
<?php }?></a></div>
	
	</div>
	<!-- Iwill-Button ende -->
	<div class="clear"></div>
	</div>
	<!-- Version Tab ende --> 
	
	<!-- Version Beschreibung Anfang -->
	<div class="pane"><?php echo $_smarty_tpl->tpl_vars['line']->value['INFO'];?>
</div>
	<!-- Version Beschreibung ende -->
	<?php }} ?>

	</div>
	<!-- Lines "accordeon" ende --> 
	<br>
	<br>
	<div class="prabout">
	<div class="titelgruen1 borderdashedgrau">Beschreibung</div>
	<br>
	<?php echo $_smarty_tpl->getVariable('item_lng')->value['INFO'];?>
</div>
	<div class="wrap1x">
	<div class="padright52"><!-- Iwill-Button Anfang -->
	

	<!-- Iwill-Button ende --> <br>
	<br>
	<!-- Detailsbox anfang -->
	<div class="details">
	<ul>
		<?php $_smarty_tpl->tpl_vars['katname'] = new Smarty_variable($_smarty_tpl->getVariable('item')->value['WF_KATEGORY'], null, null);?>
		<li><span class="textgrau1 caps">Kategorie:</span><br>
		<a href="/crypt_catalog/<?php echo $_smarty_tpl->getVariable('item')->value['WF_KATEGORY'];?>
"><?php echo $_smarty_tpl->getVariable('kataloglist')->value[$_smarty_tpl->getVariable('katname')->value];?>
</a></li>
	<!--  	<li><span class="textgrau1 caps">Creator:</span><br>
		<a href="#"><?php echo $_smarty_tpl->getVariable('item')->value['FG_PERSON_ID'];?>
</a></li> -->
		<?php $_smarty_tpl->tpl_vars['typename'] = new Smarty_variable($_smarty_tpl->getVariable('item')->value['WF_PAYTYPE'], null, null);?>
		<li><span class="textgrau1 caps">Typ:</span><br>
		<a href="/crypt_catalog/select/type/<?php echo $_smarty_tpl->getVariable('typename')->value;?>
"><?php echo $_smarty_tpl->getVariable('softtype')->value[$_smarty_tpl->getVariable('typename')->value];?>
</a></li>		
		<li><span class="textgrau1 caps">Online seit:</span><br>
		<?php echo $_smarty_tpl->getVariable('item')->value['CDATE'];?>
</li>
		<li><span class="textgrau1 caps">Aktualisiert:</span><br>
		<?php echo $_smarty_tpl->getVariable('item')->value['UDATE'];?>
</li>
		<li><span class="textgrau1 caps">User Bewertung:</span><br>
		<img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
sterne<?php echo $_smarty_tpl->getVariable('item')->value['RATING_USER'];?>
.png" width="83"
			height="15" alt=""> [<?php echo $_smarty_tpl->getVariable('item')->value['RATING_USER_COUNT'];?>
]</li>
		<li><span class="textgrau1 caps">Expert Bewertung:</span><br>
		<img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
sterne<?php echo $_smarty_tpl->getVariable('item')->value['RATING_PRO'];?>
.png" width="83"
			height="15" alt=""> [<?php echo $_smarty_tpl->getVariable('item')->value['RATING_PRO_COUNT'];?>
]</li>
	
		<li><span class="textgrau1 caps">Publisher:</span><br>
		<?php echo $_smarty_tpl->getVariable('item')->value['FG_USER_ID'];?>
</li>
		<!-- <li><span class="textgrau1 caps">Tags:</span><br>
		<a href="#">Internet</a>, <a href="#">Foto</a>, <a href="#">Video</a>,
		<a href="#">Tasks</a>, <a href="#">Kalender</a>, <a href="#">Fignja</a></li>  -->
	</ul>
	</div>
	<!-- Deteilsbox ende --> <br>
	<br>
	<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox addthis_default_style "><a
		href="http://www.addthis.com/bookmark.php?v=250&amp;pubid=xa-4e07577333281a4f"
		class="addthis_button_compact">Share</a> <span
		class="addthis_separator">|</span> <a
		class="addthis_button_preferred_1"></a> <a
		class="addthis_button_preferred_2"></a> <a
		class="addthis_button_preferred_3"></a> <a
		class="addthis_button_preferred_7"></a> <a
		class="addthis_button_preferred_9"></a></div>
	<script type="text/javascript"
		src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e07577333281a4f"></script>
	<!-- AddThis Button END --> <br>
	<br>
	</div>
	</div>
	</div>
	<!-- Beshcreibung ende --> <!-- Screenshots Anfang -->
	<div class="pan" align="center">
	<div class="titelblau1 borderblau2px" align="left"><?php echo $_smarty_tpl->getVariable('item')->value['NAME'];?>
</div>
	<br>
	<div id="dropbox" style="min-height: 100px;">
		<div id="imagelist">
		<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('images')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
?>
		<a href="/content/images/galery/<?php echo $_smarty_tpl->getVariable('item')->value['ID'];?>
/<?php echo $_smarty_tpl->tpl_vars['image']->value['PATH'];?>
" class="galery">
		<img  src="/content/images/galery/<?php echo $_smarty_tpl->getVariable('item')->value['ID'];?>
/thumbs/<?php echo $_smarty_tpl->tpl_vars['image']->value['PATH'];?>
"/>
		</a>
		<?php }} ?>
		</div>
		<br clear="all"/>
		</div>
	</div>
	<!-- Screenshots ende --> <!-- Komentare Anfang -->
	<div class="pan">
	<div class="titelblau1 borderblau2px"><?php echo $_smarty_tpl->getVariable('item')->value['NAME'];?>
</div>
	pane 3 content
	</div>
	<!-- komentare ende -->
	</div>
	<!-- tab "panes" ende -->
</div>
<script>

document.title="<?php echo $_smarty_tpl->getVariable('item')->value['NAME'];?>
";

//

// perform JavaScript after the document is scriptable.
$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.tabs").tabs("div.panes > div");
	$("#accordion").tabs("#accordion div.pane", {tabs: 'div.lines', effect: 'slide', initialIndex: null});
	$(".iwill").click(function(){			
		document.location.href=$(this).children('a').attr('href');
		return false;
		}
	);
	
});


//
</script>
