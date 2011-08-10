<?php


class Kontakt implements iSingleton {
	
	private static $instance;
	
	
	protected function __construct() { 
		
	}	

	
	public function getKontaktPerParent($parent_id,$parent_type)
	{			
			$DB=FgLoader::getInstance()->getObject('DBObject','class');/* @var $DB DBObject */
			
			$where = array(
				array('B.PARENTID','=',$parent_id,MSK_ZAHL),
				array('B.PARENTTYPE','=',$parent_type,MSK_ZAHL),
				array('B.KINDTYPE','=',FgVars::FG_TYPE_KONTAKT,MSK_ZAHL),
			);
			
			$kontakt = $DB->getAssoc("select A.* from ".FgVars::getTablePerType(FgVars::FG_TYPE_KONTAKT)." A, ".
				FgVars::getTablePerType(FgVars::FG_TYPE_LINKS)." B where A.ID=B.KINDID and ".$DB->makeWhereFromArray($where));
			
			return $kontakt;
		
	}
	
	public function getKontaktPerID($id)
	{		

		$kontakt=array();
		
			if(FgUtill::checkVar(MSK_ZAHL, $id)){
				$DB=FgLoader::getInstance()->getObject('DBObject','class');/* @var $DB DBObject */	
			
				$kontakt = $DB->getAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_KONTAKT)." where ID=".$id);
			}
			
			return $kontakt;
		
	}

	/**
	 * @return Cryptodira
	 */
	public static function getInstance() {

       if (self::$instance === NULL) {
       		self::$instance =  new self;          
       }
       return self::$instance;
   	}

}

