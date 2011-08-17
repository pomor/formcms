<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> cryptoDira </title>
<link rel="stylesheet" type="text/css" href="{$FG_STYLESPACE}/css/main.css" />
<link  href="http://fonts.googleapis.com/css?family=Droid+Serif:regular,italic,bold,bolditalic" rel="stylesheet" type="text/css" >
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="{$FG_STYLESPACE}/js/_jquery.js"></script>
<script type="text/javascript" src="{$FG_STYLESPACE}/js/main.js"></script>
<script src="http://cdn.jquerytools.org/1.2.5/jquery.tools.min.js"></script> 
{$metatag}{$css_link}{$css_inline}{$js_link}{$js_inline}
</head>
<body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">

<div class="mainwrap">
    <!-- header anfang -->
    <div class="header">
    <div class="logo"><a href="#index.php"><img src="{$IMAGES_PATH}logo.png" width="273" height="93" alt="" border="0"></a></div>
    <div class="wrapmenues">
      <!-- Sprachenmenü anfang  -->
      <div class="sprachen" >
        <ul style="display: none;" id="sprache">
        {wv id=24 template='language.tpl' name=true assoc=true}
         </ul>
        <div class="spracheaktiv" onclick="$('#sprache').slideToggle();"><div class="sprachicon"><a href="#"><img src="{$IMAGES_PATH}flagge_{actLang}.png" width="16" height="16" alt="" border="0"></a></div><a href="#" class="button">{actLang name=true}</a></div>
      </div>
      <!-- Sprachenmenü ende -->
      <!-- usermenü anfang -->
      <div class="usermenue" >
      <span id="usermenu" style="display: none;">
      {include file='Login.tpl'}       
        </span>
        <div class="useraktiv" onclick="$('#usermenu').slideToggle();"><a href="#" class="button">Usermenü</a></div>
      </div>
      <!-- Usermenü ende -->
    </div>
    <!-- Suche anfang -->
    <div class="suche"><div class="suchetext">Suche:</div><div class="inputbg"><input name="suche" value="suche" class="suchfeld"></div><div class="suchebutton"><a href="#"><img src="{$IMAGES_PATH}suche_button.png" width="37" height="37" alt="" border="0"></a></div></div>
    <!-- Suche ende -->
    <div class="clear"></div>
    </div>
    <!-- header ende -->
    <!-- Menü oben anfang -->
    <div class="menue">
        <div class="menuelinks"><img src="{$IMAGES_PATH}menue_bg_li.png" width="21" height="58" alt=""></div>
        <div class="menuemitte">
        {menu id=4 template='cd_top_menu' path='menustyles/'}           
        </div>
        <div class="menuerechts"><img src="{$IMAGES_PATH}menue_bg_re.png" width="21" height="58" alt=""></div>
        <div class="clear"></div>
    </div>
    <!-- Menü oben ende  -->
    {if isset($showstart)}
    <!-- Bilderblock mit trigger anfang -->
    <div class="illuwrap" >
        <div class="illu"><img src="{$IMAGES_PATH}bbild.jpg" width="630" height="300" alt=""></div>
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
                    <a href="/item/s/id/3"><img src="{$IMAGES_PATH}download_button.png" width="210" height="46" alt="" border="0"></a><br><br>
                    <a href="/item/s/id/3">Ich will noch mehr erfahren <img src="{$IMAGES_PATH}pfeil_blau.png" width="12" height="11" alt="" border="0"></a>
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
    {/if}
    <!-- Main anfang: 4x -->
    <div class="main">
        <div class="wrap1x">
            <!-- Categiry block anfang: 1x -->
            <div class="category">
                <ul>
                {wv id=28 template='kategory.tpl' name=true assoc=false}
                </ul>
            </div>
            <!-- Category block ende: 1x -->
        </div>
        <!-- Programmblock anfang: 3x -->
        <div class="wrap3x">
        {$template_action}
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