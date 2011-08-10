<?php
class Event_User_List extends Event_Base
{

	const ERROR_CLASS = 'Event_Start_Error';
	const RAUM = 'admin/';


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{

		FgSmarty::getInstance()->assign('save',false);

		switch($this->action)
		{
			// show user login information
			case 'show':
				return $this->actionShow();
				break;

			// save user login information
			case 'save':
				return $this->actionSave();
				break;

			// show person informarion
			case 'showPerson':
				return $this->actionShowPerson();
				break;

			// save person information
			case 'savePerson':
				return $this->actionSavePerson();
				break;

			// show kontakt information
			case 'showKontakt':
				return $this->actionShowKontakt();
				break;

			// save kontakt information
			case 'saveKontakt':
				return $this->actionSaveKontakt();
				break;

			case 'del':
				return $this->actionDelete();
				break;

			default:
				return $this->actionDefault();
		}

	}


	/**
	 * show Person information
	 *
	 * @param int $id UserID
	 */
	private function actionShowPerson($id=null)
	{
		if($id==null)
		{
			$id = FgUtill::checkVar(MSK_ZAHL, $_REQUEST['id']);
		}

		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();

		$user=$this->DB->getAssoc("select A.* from (fg_person A, fg_links B) where A.Deleted=0 and A.ID=B.KINDID and B.PARENTID=".
				$id." and B.PARENTTYPE=".FgVars::FG_TYPE_USER." and B.KINDTYPE=".FgVars::FG_TYPE_PERSON." limit 1");

		$smarty->assign('UserID',$id);
		$smarty->assign('user',$user);
		$smarty->assign('myOptions', array( '0' => 'Unbekannt', '1' => 'Mann',  '2' => 'Frau') );

		$smarty->display(self::RAUM.'Event_User_Person.tpl');

		return false;
	}

	/**
	 * save person information
	 */
	private function actionSavePerson()
	{

		$uid = FgUtill::checkVar(MSK_ZAHL, $_REQUEST['uid']);
		$id = FgUtill::checkVar(MSK_ZAHL, $_REQUEST['id']);


		$_REQUEST['Updated']='now()';

		if($id) // update
		{

				$this->DB->update("fg_person",$_REQUEST,false,"ID=".$id,2,1);

		}
		else //insert
		{
			$_REQUEST['Created']='now()';

			// insert neue eintrag
			$id=$this->DB->insert('fg_person', $_REQUEST, false, 2,1);

			// bind partner and gruppe
			$this->DB->insert('fg_links',array(
				'PARENTID'=>$uid,
				'PARENTTYPE'=>FgVars::FG_TYPE_USER,
				'KINDID'=>$id,
				'KINDTYPE'=>FgVars::FG_TYPE_PERSON,
				'CREATED'=>'now()'
			),false,2,1);
		}

		FgSmarty::getInstance()->assign('save',true);
		
		return $this->actionShowPerson($uid);
	}


	/**
	 * show kontakt information
	 *
	 * @param int $id UserID
	 */
	private function actionShowKontakt($id=null)
	{
		if($id==null)
		{
			$id = FgUtill::checkVar(MSK_ZAHL, $_REQUEST['id']);
		}

		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();

		$user=$this->DB->getAssoc("select A.* from (fg_kontakt A, fg_links B) where A.ID=B.KINDID and B.PARENTID=".
				$id." and B.PARENTTYPE=".FgVars::FG_TYPE_USER." and B.KINDTYPE=".FgVars::FG_TYPE_KONTAKT." limit 1");


		$smarty->assign('UserID',$id);
		$smarty->assign('user',$user);
		$smarty->display(self::RAUM.'Event_User_Kontakt.tpl');
		return false;
	}

	/**
	 * save kontakt  information
	 */
	private function actionSaveKontakt()
	{

		$uid = FgUtill::checkVar(MSK_ZAHL, $_REQUEST['uid']);
		$id = FgUtill::checkVar(MSK_ZAHL, $_REQUEST['id']);


		$_REQUEST['Updated']='now()';

		if($id) // update
		{

				$this->DB->update("fg_kontakt",$_REQUEST,false,"ID=".$id,2,1);

		}
		else //insert
		{
			$_REQUEST['Created']='now()';

			// insert neue eintrag
			$id=$this->DB->insert('fg_kontakt', $_REQUEST, false, 2,1);

			// bind partner and gruppe
			$this->DB->insert('fg_links',array(
				'PARENTID'=>$uid,
				'PARENTTYPE'=>FgVars::FG_TYPE_USER,
				'KINDID'=>$id,
				'KINDTYPE'=>FgVars::FG_TYPE_KONTAKT,
				'CREATED'=>'now()'
			),false,2,1);
		}

		FgSmarty::getInstance()->assign('save',true);

		return $this->actionShowKontakt($uid);
	}


	/**
	 * Update or Insert Partner
	 * @return boolean
	 */
	private function actionSave()
	{
		$id = FgUtill::checkVar(MSK_ZAHL, $_REQUEST['uid']);



		$saveArray = array(
				'Login'=>FgUtill::getVal('Login',$_POST),
				'Updated'=>'now()',
				'Active'=>( FgUtill::getVal('Active',$_POST) )?1:0
			);

		$pass = FgUtill::getVal('Pass', $_POST);
		$pass2=	FgUtill::getVal('Pass2', $_POST);

		if($pass && FgUtill::checkVar(MSK_PASSWORD, $pass) && strlen($pass)>4 && $pass==$pass2)
		{
			$saveArray['Pass']=md5($pass);
		}


		if($id) // update
		{
				$this->DB->update("fg_user",$saveArray,false,"UserID=".$id,2,1);

		}
		else //insert
		{
			$saveArray['Created']='now()';

			// insert neue eintrag
			$id=$this->DB->insert('fg_user', $saveArray, false, 2,1);

			// bind partner and gruppe
			$this->DB->insert('fg_links',array(
				'PARENTID'=>FgSession::getInstance()->LAST_GROUP,
				'PARENTTYPE'=>FgVars::FG_TYPE_GROUP,
				'KINDID'=>$id,
				'KINDTYPE'=>FgVars::FG_TYPE_USER,
				'CREATED'=>'now()'
			),false,2,1);
		}

		/* module ein/aus */

		// get module list
		$module=$this->DB->getCol("select name from fg_wf where wtype=20");

		// find Partner id from  Group parent id
		$partnerid=$this->DB->getOne("select PARENTID from fg_links where PARENTTYPE=".FgVars::FG_TYPE_PARTNER." and KINDID=".
			FgSession::getInstance()->LAST_GROUP." and KINDTYPE=".FgVars::FG_TYPE_GROUP." limit 1");

		// get permission for Partner
		$partner_rechte=$this->DB->getKeyVal("select NAME,VAL from fg_perm where OBJECTTYPE=".
			FgVars::FG_TYPE_PARTNER." and OBJECTID=".$partnerid);

		// get permissions for Grop
		$group_rechte=$this->DB->getKeyVal("select NAME,ID from fg_perm where OBJECTTYPE=".FgVars::FG_TYPE_GROUP." and OBJECTID=".FgSession::getInstance()->LAST_GROUP);

		// get User Permissions
		$user_rechte=$this->DB->getKeyVal("select NAME,ID from fg_perm where OBJECTTYPE=".FgVars::FG_TYPE_USER." and OBJECTID=".$id);


		foreach($module as $tmp)
		{

			//check rechte parameter
			$tval=FgUtill::checkVar(MSK_ZAHL, $_REQUEST[$tmp]);
			if( $tval != 1 ){	$tval=0;	}

			if(array_key_exists($tmp,$partner_rechte) && $partner_rechte[$tmp]<$tval)
			{
				$tval=$partner_rechte[$tmp];
			}

			if(array_key_exists($tmp,$group_rechte) && $group_rechte[$tmp]<$tval)
			{
				$tval=$group_rechte[$tmp];
			}
			
			

			if(array_key_exists($tmp, $user_rechte))
			{
				$this->DB->update('fg_perm',
						array('VAL'=>$tval),false,'ID='.$user_rechte[$tmp],2,1);

			}
			else
			{
				FgUtill::addFgPerms($id, FgVars::FG_TYPE_USER, $tmp, $tval);
			}
		}


		FgSmarty::getInstance()->assign('save',true);

		return $this->actionShow($id);
	}





	/**
	 * zeigt Partner information für bearbeitung
	 *
	 * @param int $id
	 * @return boolean
	 */
	private function actionShow($id=null)
	{
		if($id==null)
		{
			$id = FgUtill::checkVar(MSK_ZAHL, $_REQUEST['id']);
		}


		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();

		$user = array();
		if($id)
		{
			$user = $this->DB->getAssoc("select * from fg_user where UserID=".$id);
			$smarty->assign('mySelect', $user['Active']);
		}


		// option für  selectbox 'Aktiv'
		$smarty->assign('myOptions', array( 1 => 'Ja',  0 => 'Nein') );


		// daten für permissions edit
		FgSession::getInstance()->setLastCustomPermissions($id, FgVars::FG_TYPE_USER);


		$smarty->assign('user',$user);
		$smarty->display(self::RAUM.'Event_User_Edit.tpl');


		return false;

	}




	/**
	 * delete partner
	 * @return boolean false für haupttemplate bypass
	 */
	private function actionDelete()
	{
		$delid= FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id',$_REQUEST));
		$this->DB->query("update fg_user set Active=0 where ID=".$delid);
		return false;
	}

	/**
	 * zeigt partner list
	 */
	private function actionDefault()
	{

		$gid=0;

		if($this->actUser->checkPermission("PERM_RECHTE",PERM_ADMIN))
		{
			$gid=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('gid',$_REQUEST));
			if(is_null($gid))
			{
				$gid=$this->actUser->getPermissionsVal('FG_GROUP_ID');
			}
		}
		else
		{
			$gid=$this->actUser->getPermissionsVal('FG_GROUP_ID');
		}

		$this->session->LAST_GROUP = $gid;

		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();



		$smarty->assign('itemlist',$this->DB->getAllAssoc("select A.* from fg_user A, fg_links B where B.PARENTID='".$gid."' and B.PARENTTYPE='".
							FgVars::FG_TYPE_GROUP."' and B.KINDTYPE=".FgVars::FG_TYPE_USER." and A.UserID=B.KINDID order by A.Active desc, A.Created desc"));



		$this->showContent = $smarty->fetch(self::RAUM.'Event_User_List.tpl');
		return true;

	}

	/**
	 * prüft ob gruppe gehört zu partner
	 *
	 * @param int $pid PartnerID
	 * @param int $gid GroupID
	 * @return boolean
	 */
	private function isGroupFromPartner($pid,$gid)
	{
		$res=0;

		$pid= FgUtill::checkVar(MSK_ZAHL, $pid);
		$gid= FgUtill::checkVar(MSK_ZAHL, $gid);

		if($pid != null && $gid != null)
			$res = $this->DB->getOne("select 1 from fg_links where PARENTID='".$pid."' and PARENTTYPE='".
							FgVars::FG_TYPE_PARTNER."' and KINDTYPE=".FgVars::FG_TYPE_GROUP." and KINDID=".$gid);

		if($res==1)return true;

		return false;
	}


	private function isUserFromPartner($pid,$uid)
	{
		$res=0;

		$pid= FgUtill::checkVar(MSK_ZAHL, $pid);
		$uid= FgUtill::checkVar(MSK_ZAHL, $uid);


		if($pid != null && $uid != null)
			$gid = $this->DB->getOne("select PARENTID from fg_links where PARENTTYPE='".
							FgVars::FG_TYPE_PARTNER."' and KINDTYPE=".FgVars::FG_TYPE_GROUP." and KINDID=".$uid);

		if($this->isGroupFromPartner($pid,$gid))return true;

		return false;
	}


	private function isUserFromGroup($gid,$uid)
	{
		$res=0;

		$gid= FgUtill::checkVar(MSK_ZAHL, $gid);
		$uid= FgUtill::checkVar(MSK_ZAHL, $uid);


		if($gid != null && $uid != null)
			$res = $this->DB->getOne("select 1 from fg_links where PARENTID=".$gid." PARENTTYPE='".
							FgVars::FG_TYPE_GROUP."' and KINDTYPE=".FgVars::FG_TYPE_USER." and KINDID=".$uid);

		if($res>0)return true;

		return false;
	}


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::hasAccess()
	 */
	public function hasAccess()
	{

		$act=(isset($_REQUEST['act']))?FgUtill::checkVar(MSK_SAFESTRING, FgUtill::getVal('act',$_REQUEST), 10) :'';

		if($this->actUser->isLogin())
		{
			if($this->actUser->checkPermission("PERM_RECHTE",PERM_ADMIN))
			{
				return true;
			}
			// check partner admin permissions
			elseif ($this->actUser->checkPermission("PERM_RECHTE",PERM_PARTNER_ADMIN,true))
			{
				if($act)
				{
					if($this->isUserFromPartner($this->actUser->getPermissionsVal('FG_PARTNER_ID'), FgUtill::getVal('uid',$_REQUEST)))
					{
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					$gid=FgUtill::getVal('gid', $_REQUEST);

					if($gid>0)
					{
						if($this->isGroupFromPartner($this->actUser->getPermissionsVal('FG_PARTNER_ID'),$gid))
						{
							return true;
						}
						else
						{
							return false;
						}
					}
					else
					{
						return true;
					}

				}

			}
			// check group admin permission
			elseif ($this->actUser->checkPermission("PERM_RECHTE",PERM_GROUP_ADMIN,true))
			{
				if($act)
				{
					if($this->isUserFromGroup($this->actUser->getPermissionsVal('FG_GROUP_ID'), FgUtill::getVal('uid',$_REQUEST)))
					{
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return true;
				}
			}
		}


		return false;
	}


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getMainTemplate()
	 */
	public function getMainTemplate()
	{
		return 'maintemplates/admin_index.tpl';
	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getErrorEvent()
	 */
	public function getErrorEvent()
	{
		return $this->loader->loadObject(self::ERROR_CLASS,FG_EVENTS);
	}


}
