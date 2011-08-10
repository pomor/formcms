<?php

if(!isset($fgSession))
	$fgSession = FgSession::getInstance();

$myLoader = FgLoader::getInstance();


$myLoader->setObject($db);

/* @var $fgSession FgSession */
$myLoader->setObject($fgSession);
$fgSession->setUri();

/* @var $conf FgConfig */
$conf =  FgLoader::loadObject('FgConfig','global');

$fgSession->actEventName = $conf->detectEvent();
$actEvent = $conf->actEvent($fgSession->actEventName);


if(is_null($fgSession->actLang()))
{
	
	$fgSession->actLang(new FgLanguage(FG_LANG_DEFAULT));
}

if(isset($_REQUEST['setlang']))
{
	$fgSession->actLang()->setAct($_REQUEST['setlang']);
}


/* aktivieren user object */


if($fgSession->actUser())
{
	$actUser = $fgSession->actUser();
	if(FG_USER_CONCURRENT)
	{
		if($actUser->isLogin() && !$actUser->checkSession())
		{
			$actUser->clearSession();
		}
	}
}
else
{
	$actUser = new FgUser();
	$fgSession->actUser($actUser);
}
/* @var $actUser FgUser */

/* save act user object */
$myLoader->setObject($actUser);


/* @var $evt_obj iEvent */
$evt_obj = $myLoader->loadObject($actEvent->class_name,FG_EVENTS.(isset($actEvent->raum)?'/'.$actEvent->raum:''));


/* check user modul access */
if(!$evt_obj->hasAccess())
{
	$evt_obj = $evt_obj->getErrorEvent();
}


/* run event */
$sPhpin='';
$buf_start=false;

if(!$evt_obj->isStream())$buf_start=ob_start();

$show_header = null;
$stop=0;
do
{
	if(is_object($show_header) && FgUtill::class_has_interface($show_header, 'iEvent') )
	{
		$evt_obj = $show_header;
	}

	$show_header = $evt_obj->run();
}
while($stop++<5 && !is_bool($show_header) );


if($buf_start)
{
	 $sPhpin=ob_get_contents();
     ob_end_clean();
}




if($show_header)
{

	/* @var $smarty FgSmarty */
	$smarty = FgSmarty::getInstance();

	$smarty->assign('template_action',$evt_obj->showContent);

	$smarty->assign('actUser', $actUser);

	$smarty->assign('css_link', FgLoader::getInstance()->css(FgVars::CSS_LINK));
	$smarty->assign('css_inline', FgLoader::getInstance()->css(FgVars::CSS_INLINE));

	$smarty->assign('js_link', FgLoader::getInstance()->js(FgVars::JS_LINK));
	$smarty->assign('js_inline', FgLoader::getInstance()->js(FgVars::JS_INLINE));

	$smarty->assign('metatag', FgLoader::getInstance()->meta());


	$smarty->assign('actevt', $fgSession->actEventName);


	if($sPhpin)
		$smarty->assign('template_action', $sPhpin);


	if($evt_obj->getMainTemplate() != NULL)
			$smarty->display($evt_obj->getMainTemplate());
	else
			$smarty->display(FG_EVENT_DEFAULT_TEMPLATE);
}
else
{
	if($sPhpin)print $sPhpin;
}


