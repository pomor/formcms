<?php
set_include_path(get_include_path().":".realpath(__DIR__)."/workspace/include/");
require_once 'conf/autoload.php';

session_start();

if(isset($_REQUEST['space']) && preg_match("/^[a-z0-9]+$/",$_REQUEST['space']) && file_exists(FG_ROOT_DIR.FG_WORKSPACE.'/include/conf/'.$_REQUEST['space'].'/param.php'))
{
   $_SESSION['FG_SPACE'] = $_REQUEST['space'];
}

if(isset($_SESSION['FG_SPACE']))
{
    define('FG_SPACE',$_SESSION['FG_SPACE']);
}
else
{
    define('FG_SPACE','default');
}


require_once 'conf/'.FG_SPACE.'/param.php';
require_once 'conf/'.FG_SPACE.'/autoload.php';

