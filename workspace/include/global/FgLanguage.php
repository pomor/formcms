<?php

class FgLanguage implements iStorable,iSingleton
{

	private static $instance;
	private $arLang=array();
	private $actLang;
	private $allowLanguage;


	/**
	 *
	 * Create session object
	 */
	public function __construct($Lang=null)
	{
		if(self::$instance==null)
				self::$instance=$this;
		else
			return;

		if(is_null($Lang))
			$Lang = FG_LANG_DEFAULT;

			
			
		$this->actLang=$Lang;
		$this->arLang = $this->getLanguage('system', $Lang);			
		$this->setAllowLanguage();	
			

	}

	public function setAllowLanguage()
	{
		$this->allowLanguage=FgUtill::getWfKategory(FgVars::WV_GROUP_LANGUAGES,$this->actLang,true,true);		
	}
	
	public function getAllowLanguage()
	{
		return $this->allowLanguage;
	}
	

	public function getLanguage($GType, $Lang)
	{
		$DB = FgLoader::getInstance()->getObject('DBObject','class');
		return $DB->getKeyVal("select A.NAME,B.Content from fg_sys_lang A, fg_sys_lang_inf B where A.GTYPE='".$GType."' and A.ID=B.SYS_LANG_ID and B.LANG='".$Lang."'");
	}
	
	public function getLanguageItem($GType, $Lang, $Name)
	{
		$DB = FgLoader::getInstance()->getObject('DBObject','class');
		return $DB->getOne("select B.Content from fg_sys_lang A, fg_sys_lang_inf B where A.GTYPE='".$GType."' and A.ID=B.SYS_LANG_ID and B.LANG='".$Lang."' and A.NAME='".$Name."'");
	}

	/**
	 *
	 * set session variables
	 * @param $key
	 * @param $val
	 */
	public function __set($key,$val)
	{
		$arLang[$key] = $val;
	}

	/**
	 *
	 * get session key value
	 * @param String $key
	 */
	public function __get($key)
	{
		if(array_key_exists($key, $arLang) )
			return $arLang[$key];

		return null;
	}

	/**
	 * isset(fgSession->key)
	 *
	 * @param $key
	 * @return boolean
	 */
	public function __isset($key)
	{
		if(array_key_exists($key, $arLang) )
			return true;

		return false;
	}

	public function __unset($key)
	{
		if(array_key_exists($key, $arLang) )
			unset($arLang[$key]);
	}

	public function getAct()
	{
		return $this->actLang;
	}
	
	public function setAct($lang)
	{
		if(isset($this->allowLanguage[$lang]))
		{		
			$this->actLang=$lang;
			$this->arLang = $this->getLanguage('system', $lang);			
			$this->setAllowLanguage();
		}
	}


	/**
	 * @return FgLanguage
	 */
	public static function getInstance() {

       if (self::$instance === NULL) {
       		self::$instance =  FgSession::getInstance()->actLang();          
       }
       return self::$instance;
   	}


	/**
	 * @see workspace/include/interfaces/iStorable::getName()
	 */
	public function getName()
	{
		return __CLASS__;
	}

	/**
	 * @see workspace/include/interfaces/iStorable::getNamespace()
	 */
	public function getNamespace()
	{
		return 'class';
	}



}
