<?php
require_once 'extralib/smarty/Smarty.class.php';

  function __default_template_handler($resource_type, $resource_name, &$template_source, &$template_timestamp)
  {

      if ($resource_type == 'file') {
          if (!is_readable($resource_name)) {
              $defaultPath = FG_ROOT_DIR.FG_WORKSPACE.'/templates/default/'.$resource_name;
              if (file_exists($defaultPath)) {
                  return $defaultPath;
              }
          }
      }
      return false;
  }

class FgSmarty extends Smarty implements iSingleton, iStorable
{
	private static $instance = null;

	public function __construct()
	{
		parent::__construct();
		if(self::$instance == null )
		self::$instance = $this;

        $this->default_template_handler_func = '__default_template_handler';

		$this->assign('error', '');


		$this->assign('FG_SPACE', FG_SPACE);
		$this->assign('IMAGES_PATH', FG_IMAGE_DIR);
		$this->assign('FG_STYLESPACE', FG_STYLESPACE);
		$this->assign('FG_CONTENT', FG_CONTENT);

		$this->template_dir = FG_SMARTY_TEMPLATE_DIR;
		$this->compile_dir = FG_SMARTY_COMPILE_DIR;

		$this->registerPlugin("block","substrp", array($this,'block_substrp'));
		$this->registerPlugin("function","menu", array($this,'function_getMenu'));
		$this->registerPlugin("function","wv", array($this,'function_getWv'));
		$this->registerPlugin("function","actLang", array($this,'function_actLang'));
		$this->registerPlugin("function","getUri", array($this,'function_getUri'));
		$this->registerPlugin("function","event", array($this,'function_getEvent'));
	}




	public function function_getEvent($params,$smarty)
	{

		$room=FgUtill::getVal('room', $params);
		$event = FgLoader::loadObject(FgUtill::getVal('class', $params), FG_EVENTS.($room?'/'.$room:''));
		$method=FgUtill::getVal('method', $params);
		
		$args=array();
		if(($argn=FgUtill::getVal('args', $params))!==false)
			$args = explode('::', FgUtill::getVal('args', $params));

		if($event && method_exists($event, $method) )
		{
			ob_start();
			
			call_user_func_array(array($event,$method),$args);
			$sPhpin=ob_get_contents();
			ob_end_clean();

			return $sPhpin;
		}


		return '';
	}


	public function function_getUri($params,$smarty)
	{
			
		$uri = FgSession::getInstance()->getUri(0);
		$uri = preg_replace("/\??setlang=[a-z]+/",'',$uri);

		return $uri;
	}


	public function function_actLang($params,$smarty)
	{
		$actLang = FgLanguage::getInstance()->getAct();
		$allowLanguage = FgLanguage::getInstance()->getAllowLanguage();

		if(FgUtill::getVal('name', $params))
		return $allowLanguage[$actLang];
		else
		return $actLang;
	}

	public function function_getWv($params,$smarty)
	{

		$kategory=FgUtill::getWfKategory($params['id'],FgLanguage::getInstance()->getAct(),$params['assoc'],$params['name']);
			
		$smarty->assign('wvkontent',$kategory);

		return $smarty->fetch($params['template']);

	}


	public function block_substrp($param, $content)
	{
		if (isset($content)) {
			$maxlen=$param['maxlen'];
			if(strlen($content)>$maxlen)
			{
				$content = substr($content, 0, $maxlen-3).'...';
			}
		}

		return $content;

	}


	/**
	 * make and show menu
	 *
	 * {getmenu menu=1 template='hauptmenu.tpl'}
	 *
	 * @param mixed $params
	 * @param Smarty $smarty
	 */
	public function function_getMenu($params,$smarty)
	{
		$menuid=$params['id'];
		$menu_template=$params['template'];
		$menu_path=$params['path'];

		$menu=FgUtill::getMenu($menuid);

		$smarty->assign('menuar',$menu);

		// load all style and JS files from stylespace for menu template
		$style=FgLoader::getInstance()->autoLoad('menu/'.$menu_template,true);

		return $style.$smarty->fetch($menu_path.$menu_template.'.tpl');
	}



	/**
	 * @return FgSmarty
	 */
	public static function getInstance() {

		if (self::$instance == NULL) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function getName()
	{
		return __CLASS__;
	}

	public function getNamespace()
	{
		return 'class';
	}

}
