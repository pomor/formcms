<?php

class FgSession implements iStorable,iSingleton
{

	private static $instance;
	
	/**
	 *
	 * Create session object
	 */
	private function __construct()
	{
		if( session_id() === '' )
			session_start();

			if(!isset($_SESSION[FG_SESSION_NAME]))
				$_SESSION[FG_SESSION_NAME]=array();

		if(self::$instance==null)
				self::$instance=$this;

	}

	/**
	 *
	 * set session variables
	 * @param $key
	 * @param $val
	 */
	public function __set($key,$val)
	{
		$_SESSION[FG_SESSION_NAME][$key] = $val;
	}

	/**
	 *
	 * get session key value
	 * @param String $key
	 */
	public function __get($key)
	{
		if(array_key_exists($key, $_SESSION[FG_SESSION_NAME]) )
			return $_SESSION[FG_SESSION_NAME][$key];

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
		if(array_key_exists($key, $_SESSION[FG_SESSION_NAME]) )
			return true;

		return false;
	}

	public function __unset($key)
	{
		if(array_key_exists($key, $_SESSION[FG_SESSION_NAME]) )
			unset($_SESSION[FG_SESSION_NAME][$key]);
	}

	public function setLastCustomPermissions($id,$type)
	{
		$this->PERM_LAST_EDIT_ID=$id;
		$this->PERM_LAST_EDIT_TYPE=$type;
	}

	public function getLastCustomPermissions()
	{
		return array($this->PERM_LAST_EDIT_ID, $this->PERM_LAST_EDIT_TYPE);
	}

	/**
	 *
	 * @param FgUser $actuser
	 * @return FgUser
	 */
	public function actUser($actuser=null)
	{
		if(!is_null($actuser))
		{
			$this->actuser=$actuser;
		}
		
		if(is_bool($actuser))
		{
			$this->actuser=null;
		}

			return $this->actuser;
	}


	/**
	 *
	 * Enter description here ...
	 * @param string $actlang
	 * @return string
	 */
	public function actLang($actlang=null)
	{
		if(!is_null($actlang))
			$this->actlang=$actlang;

			
		if(isset($this->actlang))	
			return $this->actlang;
			
		return null;

	}

	
	
	public function setUri()
	{		
		
			if(!isset($this->URIHISTORY))
			{
				$this->URIHISTORY=array();
			}
			
			$uri=str_replace('/index.php', '', $_SERVER['REQUEST_URI']);
			
			if(strpos($uri, '.')>0 || preg_match("/(logout|login)/",$uri) ||  preg_match("/[^a-zA-z0-9\/=_\.\-\?]/",$uri))
			{		
				 return;
			}
			
			
			$tarray=$this->URIHISTORY;
			
			array_unshift($tarray, $_SERVER['REQUEST_URI']);
			
			if(count($tarray)>10)
				array_pop($tarray);
				
			$this->URIHISTORY=$tarray;
			
	}
	
	
	public function getUri($index)
	{
		if(!isset($this->URIHISTORY[$index]))
		{
			$index=0;
		}
		
		if(isset($this->URIHISTORY[$index]))
		{
			return $this->URIHISTORY[$index];
		}
		
		return null;
		
	}
	

	/**
	 * @return FgSession
	 */
	public static function getInstance() {

       if (self::$instance === NULL) {
           self::$instance = new self;
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
