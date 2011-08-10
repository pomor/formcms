<?php
mb_internal_encoding('utf-8');


define('FG_STYLESPACE','/stylespace/'.FG_SPACE);// css,js,images
define('FG_IMAGE_DIR', FG_STYLESPACE.'/images/'); // style images path

define('FG_USER_CONCURRENT',true); //mehrere oder 1 session fÃ¼r ein login

define('CRYPTO_SERVER_KEY','SKJDFVKSLQPWHFJASDFJASLKDFJIPUEHRNCVJHKIUQZRVNNVHREHMYBNCVJHSDGOUQZTUREZSHDGVMYNCVQFEI');
define('FG_LANG_DEFAULT','de');

define('FG_EVENT_DEFAULT','crypt_catalog');




/* load and connection to SQL database  DB/DBObject */
define('FG_DB_ENGINE','mysqli');
define('FG_MYSQL_PREFIX','fg_');


/* load Smarty */
define('FG_SMARTY_TEMPLATE_DIR', FG_ROOT_DIR.FG_WORKSPACE.'/templates/'.FG_SPACE);
define('FG_SMARTY_COMPILE_DIR', FG_ROOT_DIR.FG_WORKSPACE.'/templates_c/'.FG_SPACE);



/*  load session class */
define('FG_SESSION_NAME', 'FGSYSSESS');


/* @var $fgSession FgSession */
$fgSession = FgSession::getInstance();

if(isset($_REQUEST['set_tmpl']))
	define('FG_EVENT_DEFAULT_TEMPLATE','maintemplates/markt.tpl');
else if(isset($fgSession->EVENT_DEFAULT_TEMPLATE))
	define('FG_EVENT_DEFAULT_TEMPLATE',$fgSession->EVENT_DEFAULT_TEMPLATE);
else 
	define('FG_EVENT_DEFAULT_TEMPLATE','maintemplates/index.tpl');
		
	
$fgSession->EVENT_DEFAULT_TEMPLATE=FG_EVENT_DEFAULT_TEMPLATE;

/* load and connection to SQL database  DB/DBObject */
$className = FgLoader::loadClass('DBObject'.'_'.FG_DB_ENGINE,'DB');
$db = new $className();
$db->connection('localhost','d010dfb1','UPcYH3sZET6MSfxV','d010dfb1');
