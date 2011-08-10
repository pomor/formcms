<?php

class FgConfig implements iSingleton, iStorable
{

	private $actions = array();
	private static $instance;
	private $actevent = null;

	public function __construct()
	{
		if (self::$instance === NULL) {
           self::$instance = $this;
        }

		$this->loadActions(FG_SPACE);
	}


	public function actEvent($evt=null)
	{
		if($evt)
		{
			try
			{
				$this->actevent = $this->getAction($evt);
			}
			catch (Exception_Event_NotFound $ex)
			{
				print $ex;
			}

		}

		return $this->actevent;
	}


	public function detectEvent()
	{
		if( array_key_exists('evt',$_REQUEST) && array_key_exists($_REQUEST['evt'], $this->actions) )
		{
			return $_REQUEST['evt'];
		}

		return FG_EVENT_DEFAULT;
	}


	private function loadActions($space)
	{		
		/* @var $DB DBObject */
		$DB = FgLoader::getInstance()->getObject("DBObject", "class");
		$arActions = $DB->getAllAssoc("select Name,class_name,raum from fg_sys_module where Space in('".$space."','default')",'Name');
		
		foreach($arActions as $k=>$v)
		{
			$this->setAction($k, $v);
		}

	}

	/**
	 * get Event object zur�ck
	 *
	 * @param String $name
	 * @throws Exception_Event_NotFound
	 * @return Event $obj
	 */
	public function getAction($name)
	{
		if(array_key_exists($name, $this->actions))
		{
			return $this->actions[$name];
		}
		else
		{
			throw new Exception_Event_NotFound("Event ist nicht vorhanden", 1);
		}
	}


	/**
	 * set events auswahl
	 *
	 * @param String $name
	 * @param Array $obj
	 */
	protected  function setAction($name, $params)
	{
		if(!array_key_exists($name, $this->actions))
		{
			$obj = new FgEvent();
			foreach($params as $k=>$v)
			{
				$obj->$k=$v;
			}

			$this->actions[$name] = $obj;
		}

	}

	public static function getInstance() {

       if (self::$instance === NULL) {
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
   		return "class";
   	}


}

