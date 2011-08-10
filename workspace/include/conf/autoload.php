<?php

date_default_timezone_set('Europe/Berlin');
setlocale (LC_ALL, 'de_DE');
mb_internal_encoding('utf-8');

define('FG_DEBUG',true);
define('FG_ROOT_DIR',preg_replace('/\\\/', '/', realpath($_SERVER['DOCUMENT_ROOT'])));

define('FG_WORKSPACE','/workspace');
define('FG_CONTENT','/content'); // daten ordner files(zip,pdf ...) images(galerie,user images) media(video)
define('FG_EVENTS','events'); // events path

define('FG_STYLESPACE_DEF','/stylespace/default');// css,js,images
define('FG_IMAGE_DIR_DEF', FG_STYLESPACE_DEF.'/images/'); // style images path

require_once 'interfaces/iSingleton.php';
require_once 'interfaces/iStorable.php';
require_once 'interfaces/iEvent.php';


require_once 'global/FgExceptions.php';
require_once 'global/FgVars.php';

require_once 'DB/DBObject.php';

require_once 'global/FgLoader.php';
require_once 'global/FgEvent.php';
require_once 'global/FgConfig.php';

require_once 'global/FgLanguage.php';

require_once 'global/FgUtill.php';
require_once 'global/FgSession.php';
require_once 'global/FgSmarty.php';
require_once 'global/FgUser.php';

require_once 'global/Event_Base.php';

// parse /index.php/evt/act/id/12/step/10
FgUtill::parseRewriteUrl();

?>