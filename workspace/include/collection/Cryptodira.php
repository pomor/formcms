<?php

class Cryptodira implements iSingleton {
	
	private static $instance;
	private $DB = null; /* @var $DB DBObject */
	
	protected function __construct() {
		$this->DB = FgLoader::getInstance ()->getObject ( 'DBObject' );
	}
	
	public function getInfoPerUID($uid) {
		$uid = FgUtill::checkVar ( MSK_SAFESTRING, $uid );
		
		if ($uid) {
			
			$info = $this->DB->getAllAssoc ( "SELECT A.*,B.NAME,C.LNAME,D.VNAME
				FROM (" . FgVars::getTablePerType ( FgVars::FG_TYPE_CRYPTODIRA_MYSOFT ) . " A) 
				left join (" . FgVars::getTablePerType ( FgVars::FG_TYPE_CRYPTODIRA_SOFT ) . " B) on (B.ID=A.`FG_CRYPTO_CATALOG_ID`)
				left join (" . FgVars::getTablePerType ( FgVars::FG_TYPE_CRYPTODIRA_LINE ) . " C) on (C.ID=A.`FG_CRYPTO_LINE_ID`)
				left join (" . FgVars::getTablePerType ( FgVars::FG_TYPE_CRYPTODIRA_VERSION ) . " D) on (D.ID=A.`FG_CRYPTO_VERSION_ID`)
				where A.FG_USER_ID=" . FgSession::getInstance ()->actUser ()->getUserID () );
			
			$version_info = $this->DB->getAssoc ( "select * from " . FgVars::getTablePerType ( FgVars::FG_TYPE_CRYPTODIRA_VERSION ) . " A, " . FgVars::getTablePerType ( FgVars::FG_TYPE_CRYPTODIRA_LINE ) . "  where UID=" . $uid );
		
		}
	}
	
	/**
	 *
	 * 
	 * @param string $pk
	 * @param string $sn
	 * @param int $pin
	 * @return string $cryptokey
	 */
	public function createCryptoKey($pk, $sn, $pin) {
		return sha1 ( CRYPTO_SERVER_KEY . $pk . $sn . $pin );
	}
	
	public function createPersonalKey($email) {
		return sha1 ( CRYPTO_SERVER_KEY . $email );
	}
	
	public function checkEmail($email) {
		
		if (FgUtill::checkVar ( MSK_EMAIL, $email ) != null) {
			
			if ($this->DB->getOne ( "select 1 from " . FgVars::getTablePerType ( FgVars::FG_TYPE_USER ) . " where Login='" . $email . "'", 0 ) > 0) {
				return false;
			} else {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * @return Cryptodira
	 */
	public static function getInstance() {
		
		if (self::$instance === NULL) {
			self::$instance = new self ();
		}
		return self::$instance;
	}

}

