<?php

class FgUser implements  iStorable
{

/* @var $DB DBObject */

	public $name = '';

	private $userID = 0;
	private $eingelogt = false;
	private $permission=array();


	public function __construct()
	{
		$this->permission['LOGIN']=0;
		$this->permission['PERM_RECHTE']=PERM_EMPTY;

	}



	public function getPermissionsVal($name)
	{
		if(array_key_exists($name, $this->permission))
		{
			return $this->permission[$name];
		}

		return null;
	}


	/**
	 * Prüft logindaten
	 *
	 * @param String $login
	 * @param String $pass
	 * @throws Exception_Login
	 * @return Boolean
	 */
	public function checkLogin($login,$pass)
	{
		$DB = FgLoader::getInstance()->getObject('DBObject', 'class');

		if(is_null(FgUtill::checkVar(MSK_LOGIN, $login)))
		throw new Exception_Login('Falsche login format',1);

		if(is_null(FgUtill::checkVar(MSK_PASSWORD, $pass)))
		throw new Exception_Login('Falsche password format',2);


		$query=sprintf("select UserID from ".FgVars::getTablePerType(FgVars::FG_TYPE_USER)." where Login='%s' and Pass=MD5('%s') and Active=1 limit 1",$login,$pass);
		$userID = $DB->getOne($query);


		if($this->authUser($userID,$login))
			return true;
		else
			throw new Exception_Login('Login daten sind nicht gefunden',3);


	}


	public function authUser($userID,$login='')
	{

		$DB = FgLoader::getInstance()->getObject('DBObject', 'class');

		if($userID > 0)
		{
			$this->name=$login;
			$this->userID = $userID;
			$this->eingelogt=true;

			if(FG_USER_CONCURRENT){
				$DB->query("delete from fg_session where UserID=".$userID);
			}

			$DB->insert('fg_session',array(
					'UserID'=>$userID,
					'PHPSESSION'=>session_id(),
					'Created'=>'now()',
					'Updated'=>'now()'
					),false,2,1);


					$this->permission = $this->getPermissions($userID);
					$this->permission['LOGIN']=1;

					return true;
		}
		else
		{
			return false;
		}
	}



	/**
	 * Prüft zugrifsrechte
	 *
	 * @param String/Array $key
	 * @param Int/null $val
	 * @param boolean $full prüft genauer wert
	 * @return Boolean
	 * True - bestanden
	 * False - nicht
	 */
	public function checkPermission($key,$val=null,$full=false)
	{
		$retval = true;
		if(is_array($key))
		{
			foreach($key as $k=>$v)
			{
				if(!$this->checkPermission($k,$v,$full))
				{
					$retval = false;
					break;
				}

			}
		}
		else
		{

			if(array_key_exists($key, $this->permission) )
			{

				if($full)
				{
					if($this->permission[$key] != $val)
					{

						$retval = false;
					}
				}
				else
				{
					if($this->permission[$key] < $val)
					{
						$retval = false;
					}
				}
			}
			else
			{
				$retval = false;
			}
		}


		return $retval;
	}

	/**
	 * Gibt Benutzersrechte zurück
	 *
	 * @param Int $userID
	 * @return Array $checkPermissions
	 */
	public function getPermissions($userID)
	{
		$checkPermissions=array();

		$checkPermissions = $this->getUserRechte($userID);

		return $checkPermissions;

	}



	/**
	 * Create user und gibt ID zurück
	 *
	 * @param String $login
	 * @param String $pass
	 * @throws Exception_Login
	 * @return Int $UserID
	 */
	public function createUser($login,$pass)
	{
		$userID=0;
		$DB = FgLoader::getInstance()->getObject('DBObject', 'class');

		if(is_null(FgUtill::checkVar(MSK_LOGIN, $login)))
		throw new Exception_Login('Falsche login format',1);

		if(is_null(FgUtill::checkVar(MSK_PASSWORD, $pass)))
		throw new Exception_Login('Falsche password format',2);

		$userID = $DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_USER),array(
			'Login'=>$login,
			'Pass'=>$pass,
			'Created'=>'now()',
			'Updated'=>'now()',
			'Active'=>'1'
		),false,2,1);

		return $userID;

	}


	/**
	 * prüft ob session aktiv ist
	 *
	 * @return Boolean
	 */
	public function checkSession()
	{
		$DB = FgLoader::getInstance()->getObject('DBObject', 'class');

		$query=sprintf("select UserID from fg_session where PHPSESSION='%s' and UserID='%d' limit 1",session_id(), $this->userID);
		if($DB->getOne($query) >0 )
		{
			$DB->update('fg_session',
				array('Updated'=>'now()'), false,
				sprintf("PHPSESSION='%s' and UserID='%d'",session_id(), $this->userID),0,0);

				return true;
		}


		return false;
	}


	/**
	 * gibt aktive gruppen rechte zurück
	 *
	 * @param int $id
	 * @return array $resarr
	 */
	public function getGruppenRechte($id=null)
	{
		if(is_null($id))
		{
			$id = $this->getPermissionsVal('FG_GROUP_ID');
			if(is_null($id))
			{
				return null;
			}
		}

		$DB = FgLoader::getInstance()->getObject('DBObject', 'class');


		$group_rechte=$DB->getKeyVal("select NAME,VAL from fg_perm where OBJECTID=".$id." and OBJECTTYPE=".FgVars::FG_TYPE_GROUP);
		$partner_rechte=$DB->getKeyVal("select A.NAME,A.VAL from fg_perm A, fg_links B where A.OBJECTID=B.PARENTID and A.OBJECTTYPE=".
			FgVars::FG_TYPE_PARTNER." and B.KINDID=".$id." and B.PARENTTYPE=".FgVars::FG_TYPE_PARTNER);


		// arrays zusammen
		$resarr=array_replace($partner_rechte,$group_rechte);

		// check rechte
		foreach($resarr as $k=>$v)
		{
			if(isset($partner_rechte[$k]) && $v > $partner_rechte[$k])
			{
				$resarr[$k]=$partner_rechte[$k];
			}
		}

		return $resarr;

	}

	public function addUserToGroup($userID,$groupID)
	{
		FgUtill::addFgLinks($groupID, FgVars::FG_TYPE_GROUP, $userID, FgVars::FG_TYPE_USER);
	}

	/**
	 * gibt aktive user rechte zurück
	 *
	 * @param int $id
	 * @return array $resarr
	 */
	public function getUserRechte($id=null)
	{

		if(is_null($id))
		{
			if($this->userID>0)
			{
				$id=$this->userID;
			}

		}


		$DB = FgLoader::getInstance()->getObject('DBObject', 'class');

		// get group id
		$groupID=$DB->getOne("select PARENTID from fg_links where KINDID=".$id." and KINDTYPE=".FgVars::FG_TYPE_USER." and PARENTTYPE=".FgVars::FG_TYPE_GROUP);

		// get partner id
		$partnerID=$DB->getOne("select PARENTID from fg_links where KINDID=".$groupID." and KINDTYPE=".FgVars::FG_TYPE_GROUP." and PARENTTYPE=".FgVars::FG_TYPE_PARTNER);


		// get permissions
		$user_rechte=$DB->getKeyVal("select NAME,VAL from fg_perm where OBJECTTYPE=".FgVars::FG_TYPE_USER." and OBJECTID=".$id);
		$group_rechte=$DB->getKeyVal("select NAME,VAL from fg_perm where OBJECTTYPE=".FgVars::FG_TYPE_GROUP." and OBJECTID=".$groupID);
		$partner_rechte=$DB->getKeyVal("select NAME,VAL from fg_perm where OBJECTTYPE=".FgVars::FG_TYPE_PARTNER." and OBJECTID=".$partnerID);

		// arrays zusammen
		$resarr=array_replace($partner_rechte,$group_rechte,$user_rechte);

		// check rechte
		foreach($resarr as $k=>$v)
		{

			if(isset($group_rechte[$k]) && $v > $group_rechte[$k])
			{
				$resarr[$k]=$group_rechte[$k];
			}

			if(isset($partner_rechte[$k]) && $v > $partner_rechte[$k])
			{
				$resarr[$k]=$partner_rechte[$k];
			}
		}


		$resarr['FG_GROUP_ID']=$groupID;
		$resarr['FG_PARTNER_ID']=$partnerID;

		return $resarr;

	}



	/**
	 * löscht session
	 */
	public function clearSession()
	{

		$DB = FgLoader::getInstance()->getObject('DBObject', 'class');

		$query=sprintf("delete from fg_session where UserID='%d' limit 1",$this->userID);
		$DB->query($query);

		$this->eingelogt=false;
		$this->name='';
		$this->userID=0;

	}


	public function getUserInfo($user=null)
	{

		$result=array();
		
		if(is_numeric($user))
		{
			$DB = FgLoader::getInstance()->getObject('DBObject', 'class');/* @var $DB DBObject */
			
			
			$result = $DB->getAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_USER)." where ID=".$user);
			
		}	
		
		return $result;
	}



	/**
	 * gibt UserID zurück
	 *
	 * @return Int
	 */
	public function getUserID()
	{
		return $this->userID;
	}

	/**
	 * benutzer ist eingelogt
	 *
	 * @return Boolean
	 */
	public function isLogin()
	{
		return $this->eingelogt;
	}


	/**
	 * (non-PHPdoc)
	 * @see iStorable::getName()
	 */
	public function getName()
	{
		return 'actUser';
	}


	/**
	 * (non-PHPdoc)
	 * @see iStorable::getNamespace()
	 */
	public function getNamespace()
	{
		return 'class';
	}
}
