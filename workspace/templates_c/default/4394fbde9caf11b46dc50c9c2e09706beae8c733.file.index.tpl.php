<?php /* Smarty version Smarty-3.0.7, created on 2011-08-08 09:46:47
         compiled from "/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/maintemplates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13585615794e3c3fea41f438-55782425%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4394fbde9caf11b46dc50c9c2e09706beae8c733' => 
    array (
      0 => '/www/htdocs/w00b0aad/subdomains/beta.cryptodira.com/workspace/templates/default/maintemplates/index.tpl',
      1 => 1312783675,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13585615794e3c3fea41f438-55782425',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> cryptoDira </title>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('FG_STYLESPACE')->value;?>
/css/main.css" />
<link  href="http://fonts.googleapis.com/css?family=Droid+Serif:regular,italic,bold,bolditalic" rel="stylesheet" type="text/css" >
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('FG_STYLESPACE')->value;?>
/js/_jquery.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('FG_STYLESPACE')->value;?>
/js/main.js"></script>
<script src="http://cdn.jquerytools.org/1.2.5/jquery.tools.min.js"></script> 
<?php echo $_smarty_tpl->getVariable('metatag')->value;?>
<?php echo $_smarty_tpl->getVariable('css_link')->value;?>
<?php echo $_smarty_tpl->getVariable('css_inline')->value;?>
<?php echo $_smarty_tpl->getVariable('js_link')->value;?>
<?php echo $_smarty_tpl->getVariable('js_inline')->value;?>

</head>
<body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">

<div class="mainwrap">
    <!-- header anfang -->
    <div class="header">
    <div class="logo"><a href="#index.php"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
logo.png" width="273" height="93" alt="" border="0"></a></div>
    <div class="wrapmenues">
      <!-- Sprachenmenü anfang  -->
      <div class="sprachen" >
        <ul style="display: none;" id="sprache">
        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['wv'][0][0]->function_getWv(array('id'=>24,'template'=>'language.tpl','name'=>true,'assoc'=>true),$_smarty_tpl);?>

         </ul>
        <div class="spracheaktiv" onclick="$('#sprache').slideToggle();"><div class="sprachicon"><a href="#"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
flagge_<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['actLang'][0][0]->function_actLang(array(),$_smarty_tpl);?>
.png" width="16" height="16" alt="" border="0"></a></div><a href="#" class="button"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['actLang'][0][0]->function_actLang(array('name'=>true),$_smarty_tpl);?>
</a></div>
      </div>
      <!-- Sprachenmenü ende -->
      <!-- usermenü anfang -->
      <div class="usermenue" >
      <span id="usermenu" style="display: none;">
      <?php $_template = new Smarty_Internal_Template('Login.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>       
        </span>
        <div class="useraktiv" onclick="$('#usermenu').slideToggle();"><a href="#" class="button">Usermenü</a></div>
      </div>
      <!-- Usermenü ende -->
    </div>
    <!-- Suche anfang -->
    <div class="suche"><div class="suchetext">Suche:</div><div class="inputbg"><input name="suche" value="suche" class="suchfeld"></div><div class="suchebutton"><a href="#"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
suche_button.png" width="37" height="37" alt="" border="0"></a></div></div>
    <!-- Suche ende -->
    <div class="clear"></div>
    </div>
    <!-- header ende -->
    <!-- Menü oben anfang -->
    <div class="menue">
        <div class="menuelinks"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
menue_bg_li.png" width="21" height="58" alt=""></div>
        <div class="menuemitte">
        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['menu'][0][0]->function_getMenu(array('id'=>4,'template'=>'cd_top_menu','path'=>'menustyles/'),$_smarty_tpl);?>
           
        </div>
        <div class="menuerechts"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
menue_bg_re.png" width="21" height="58" alt=""></div>
        <div class="clear"></div>
    </div>
    <!-- Menü oben ende  -->
    <?php if (isset($_smarty_tpl->getVariable('showstart',null,true,false)->value)){?>
    <!-- Bilderblock mit trigger anfang -->
    <div class="illuwrap" >
        <div class="illu"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
bbild.jpg" width="630" height="300" alt=""></div>
        <div class="triggerwrap">
            <div class="triggeraktiv">
                <a href="#" class="button"><span class="titel1">1. be mobile...</span><br>
                erfahren Sie mehr</a>
            </div>
            <div class="trigger">
                <a href="#" class="button"><span class="titel1">2. be cryptet...</span><br>
                erfahren Sie mehr</a>
            </div>
            <div class="trigger">
                <a href="#" class="button"><span class="titel1">3. be free!</span><br>
                erfahren Sie mehr</a>
            </div>
        </div>
    </div>
    <!-- Bilderblock mit trigger ende  -->
    <!-- Additional block anfang -->
    <div class="additional" >
        <div class="grauborder1">
            <div class="graubg">
                <div class="downloadwrap">
                    <span class="text18">Jetzt aktuelle Version runterladen</span><br><br>
                    <a href="/item/s/id/3"><img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
download_button.png" width="210" height="46" alt="" border="0"></a><br><br>
                    <a href="/item/s/id/3">Ich will noch mehr erfahren <img src="<?php echo $_smarty_tpl->getVariable('IMAGES_PATH')->value;?>
pfeil_blau.png" width="12" height="11" alt="" border="0"></a>
                </div>
                <div class="addtextwrap">
                <span class="titelblau1">Hier noch ein Text wie cool cryptoDira ist!</span><br>
                <span class="titelbraun1">und wieso man die jetzt sofort runterladen sollte</span><br><br>
                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clit</div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <!-- Additional Block ende -->
    <?php }?>
    <!-- Main anfang: 4x -->
    <div class="main">
        <div class="wrap1x">
            <!-- Categiry block anfang: 1x -->
            <div class="category">
                <ul>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['wv'][0][0]->function_getWv(array('id'=>28,'template'=>'kategory.tpl','name'=>true,'assoc'=>false),$_smarty_tpl);?>

                </ul>
            </div>
            <!-- Category block ende: 1x -->
        </div>
        <!-- Programmblock anfang: 3x -->
        <div class="wrap3x">
        <?php echo $_smarty_tpl->getVariable('template_action')->value;?>

         <div class="clear"></div>                
        </div>
        <!-- programmblock ende:3x -->
        <div class="clear"></div>
    </div>
    <!-- Main ende -->
    <!-- Bottom anfang -->
    <div class="bottom">
        <div class="bottombg">
        &nbsp;
        </div>
    </div>
    <!-- Bottom ende -->

</div>




</body>
</html>