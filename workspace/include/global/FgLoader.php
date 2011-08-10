<?php

class FgLoader implements iSingleton
{
	private static $instance;
	private $storedObjects = array();
	private $storedMixed = array();


	private function __construct()
	{

		if(!self::$instance) self::$instance=$this;

		$this->storedMixed[FgVars::CSS_LINK] = array();
		$this->storedMixed[FgVars::CSS_INLINE] = array();

		$this->storedMixed[FgVars::JS_LINK] = array();
		$this->storedMixed[FgVars::JS_INLINE] = array();
		
		$this->storedMixed[FgVars::METATAG] = array();
	}

	public function setObject($obj,$cust_name=null,$cust_namespace=null)
	{

		if($cust_name == null)
		{
			$cust_name = $obj->getName();
		}

		if($cust_namespace == null)
		{
			$cust_namespace = $obj->getNamespace();
		}

		if(isset($this->storedObjects[$cust_namespace][$cust_name]))
		{
			return false;
		}
		else
		{
			$this->storedObjects[$cust_namespace][$cust_name]=$obj;
			return true;
		}
	}

	public function getObject($key,$space='class')
	{
		if(isset($this->storedObjects[$space][$key]))
		{
			return $this->storedObjects[$space][$key];
		}
		else
		{
			return null;
		}
	}


	public function  removeObject($key,$space='class')
	{
		$retobj = null;

		if(isset($this->storedObjects[$space][$key]))
		{
			$retobj = $this->storedObjects[$space][$key];
			unset($this->storedObjects[$space][$key]);

		}

		return $retobj;
	}

	public static function loadClass($className,$path='.')
	{
		try
		{
			if(!class_exists($className))
			{

				try
				{
					require_once $path."/".$className.".php";
				}
				catch ( Exception $ex2	)
				{
					print $ex2->getMessage();
				}



				if(!class_exists($className))
					return null;
				else
					return $className;
			}

		}
		catch(Exception $ex)
		{
			error_log("ERROR; ".__FILE__."; ".__FUNCTION__ ."; ".__LINE__."; ".$className.": konnte nicht finden");
		}
	}


	/**
	 * includet class und generiert eine instance
	 *
	 * @param $className
	 * @param $path
	 */
	public static function loadObject($className,$path='.')
	{

		try
		{
			if(!class_exists($className))
			{
				try
				{
					require_once $path."/".$className.".php";
				}
				catch ( Exception $ex2	)
				{
					print $ex2->getMessage();
				}

				if(!class_exists($className))
					return null;
			}



			try
			{
				if( FgUtill::class_has_interface($className, 'iSingleton')  )
				{
					// if iSingleton
					return $className::getInstance();
				}
				else
				{
					return new $className();
				}


			}
			catch(Exception $mt)
			{
				print $mt->getMessage();
			}

		}
		catch(Exception $ex)
		{
			error_log("ERROR; ".__FILE__."; ".__FUNCTION__ ."; ".__LINE__."; ".$className.": konnte nicht finden");
		}


	}



	/**
	 * load all style and scripts
	 *
	 * @param $space
	 */
	public function autoLoad($space,$show=false)
	{	
		if(substr($space, 0,1)!= '/')$space='/'.$space;
		$retString='';

		$temp_list = FgUtill::getFileList(FG_ROOT_DIR.FG_STYLESPACE.$space.'/css','.css');

		
		 sort($temp_list,SORT_STRING);

		 for($i=0; $i<count($temp_list); $i++)
		 {
		 	if($show)
		 		$retString.='<link rel="stylesheet" type="text/css" href="'.FG_STYLESPACE.$space.'/css/'.$temp_list[$i].'" />'."\n";
		 	else
		 		$this->css(FgVars::CSS_LINK,FG_STYLESPACE.$space.'/css/'.$temp_list[$i],$i+300);		 	
		 }
			

		$temp_list = FgUtill::getFileList(FG_ROOT_DIR.FG_STYLESPACE.$space.'/js','.js');
		 sort($temp_list,SORT_STRING);

		 for($i=0; $i<count($temp_list); $i++)
		 {
		 	if($show)
		 		$retString.="\n".'<script type="text/javascript" src="'.FG_STYLESPACE.$space.'/js/'.$temp_list[$i].'"></script>'."\n";
		 	else
		 		$this->js(FgVars::JS_LINK,FG_STYLESPACE.$space.'/js/'.$temp_list[$i],$i+300);
		 }


		 
		 return $retString;
	}


	/**
	 * bereitet style vor
	 *
	 * @param unknown_type $type
	 * @param unknown_type $ins
	 * @param unknown_type $prio
	 */
	public function css($type, $ins=null, $prio=0)
	{
		if($ins != null)
		{
			if($type == FgVars::CSS_LINK)
			{
				if(!array_key_exists(FgVars::CSS_LINK, $this->storedMixed))
							$this->storedMixed[FgVars::CSS_LINK] = array();

				$this->storedMixed[FgVars::CSS_LINK][$ins]=$prio;
			}
			else
			{
				if(!array_key_exists(FgVars::CSS_INLINE, $this->storedMixed))
							$this->storedMixed[FgVars::CSS_INLINE] = array();

				$this->storedMixed[FgVars::CSS_INLINE][]=$ins;
			}
		}
		else
		{
			$retString = '';
			if($type == FgVars::CSS_LINK)
			{
				FgUtill::sortVal($this->storedMixed[FgVars::CSS_LINK]);

				foreach($this->storedMixed[FgVars::CSS_LINK] as $key=>$val)
				{
					$retString.='<link rel="stylesheet" type="text/css" href="'.$key.'" />'."\n";
				}
			}
			else
			{
				foreach($this->storedMixed[FgVars::CSS_INLINE] as $key)
				{
					$retString.="\n".'<style type="text/css">'."\n".$key."\n".'</style>'."\n";
				}
			}

			return $retString;

		}
	}

/**
 * bereitet javascripts vor
 *
 * @param FgUtill::JS_LINK $type
 * @param string $ins content
 * @param int $prio reinfolge
 */
public function js($type, $ins=null, $prio=100)
	{
		if($ins != null)
		{
			if($type == FgVars::JS_LINK)
			{
				if(!array_key_exists(FgVars::JS_LINK, $this->storedMixed))
							$this->storedMixed[FgVars::JS_LINK] = array();

				$this->storedMixed[FgVars::JS_LINK][$ins]=$prio;
			}
			else
			{
				if(!array_key_exists(FgVars::JS_INLINE, $this->storedMixed))
							$this->storedMixed[FgVars::JS_INLINE] = array();

				$this->storedMixed[FgVars::JS_INLINE][]=$ins;
			}
		}
		else
		{
			$retString = '';
			if($type == FgVars::JS_LINK)
			{
				FgUtill::sortVal($this->storedMixed[FgVars::JS_LINK]);

				foreach($this->storedMixed[FgVars::JS_LINK] as $key=>$val)
				{
					$retString.="\n".'<script type="text/javascript" src="'.$key.'"></script>'."\n";
				}
			}
			else
			{
				foreach($this->storedMixed[FgVars::JS_INLINE] as $key=>$val)
				{
					$retString.="\n".'<script type="text/javascript">'."\n".$key."\n".'</script> '."\n";
				}
			}

			return $retString;

		}
	}
	
	
	
/**
	 * bereitet meta name=>content vor
	 *
	 * @param unknown_type $type
	 * @param unknown_type $ins
	 * @param unknown_type $prio
	 */
	public function meta($name=null, $ins=null, $prio=0)
	{
		if($name != null)
		{
			
				if(!array_key_exists(FgVars::METATAG, $this->storedMixed))
							$this->storedMixed[FgVars::METATAG] = array();

				$this->storedMixed[FgVars::METATAG][$name]=$ins;
			
		}
		else
		{
			$retString = '';
			
			foreach($this->storedMixed[FgVars::METATAG] as $key=>$val)
			{
				$retString.="\n".'<meta name="'.$key.'" content="'.$val.'" />'."\n";
			}
		

			return $retString;

		}
	}


	/**
	 * @return FgLoader
	 */
	public static function getInstance() {

       if (self::$instance === NULL) {
           self::$instance = new self;
       }
       return self::$instance;
   	}
}

