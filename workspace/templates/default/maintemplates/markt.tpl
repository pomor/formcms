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