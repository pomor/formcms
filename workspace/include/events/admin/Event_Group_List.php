<?php
class Event_Group_List extends Event_Base
{

	const ERROR_CLASS = 'Event_Start_Error';
	const RAUM = 'admin/';

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{

		switch($this->action)
		{
			case 'show':
				return $this->actionShow();
				break;

			case 'save':
				return $this->actionSave();
				break;

			case 'del':
				return $this->actionDelete();
				break;

			default:
				return $this->actionDefault();
		}

	}


	/**
	 * Update or Insert Partner
	 * @return boolean
	 */
	private function actionSave()
	{
		$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('gid',$_REQUEST));
		
		$perms = FgUtill::getFgPerms($id, FgVars::FG_TYPE_GROUP);		
		if(!$this->actUser->checkPermission($perms))
		{
			print "<h2 style='color:#ffffff'>No pemissions for this action!</h2>";
			return false;
		}

		$saveArray = array(
				'Name'=>$_REQUEST['Name'],
				'Info'=>$_REQUEST['Info'],
				'Updated'=>'now()',
				'Active'=>($_REQUEST['Active']==1 || $this->actUser->checkPermission('FG_GROUP_ID',$id,true) )?1:0
			);

		if($id) // update
		{
				$this->DB->update("fg_group",$saveArray,false,"ID=".$id,2,1);

		}
		else //insert
		{
			$saveArray['Created']='now()';

			// insert neue eintrag
			$id=$this->DB->insert('fg_group', $saveArray, false, 2,1);
			
			// bind partner and gruppe
			FgUtill::addFgLinks(
				FgSession::getInstance()->LAST_PARTNER, 
				FgVars::FG_TYPE_PARTNER, 
				$id, FgVars::FG_TYPE_GROUP);			
			
		}	

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
			$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id',$_REQUEST));
		}
		
		$perms = FgUtill::getFgPerms($id, FgVars::FG_TYPE_GROUP);		
		if(!$this->actUser->checkPermission($perms))
		{
			print "<h2 style='color:#ffffff'>No pemissions for this action!</h2>";
			return false;
		}


		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();

		$group = array('ID'=>0,'Active'=>1,'Name'=>'','Info'=>'');
		if($id)
		{
			$group = $this->DB->getAssoc("select * from fg_group where ID=".$id);
			$smarty->assign('mySelect', $group['Active']);
		}


		$smarty->assign('mySelect', $group['Active']);

		// option für  selectbox 'Aktiv'
		$smarty->assign('myOptions', array( 1 => 'Ja',  0 => 'Nein') );
		$smarty->assign('save',(FgUtill::getVal('act',$_REQUEST)=='save'));

		
		$smarty->assign('group',$group);


		// daten für permissions
		FgSession::getInstance()->setLastCustomPermissions($id, FgVars::FG_TYPE_GROUP);

		$smarty->display(self::RAUM.'Event_Group_Edit.tpl');

		return false;

	}




	/**
	 * delete partner
	 * @return boolean false für haupttemplate bypass
	 */
	private function actionDelete()
	{

		$delid= FgUtill::checkVar(MSK_ZAHL, $_REQUEST['id']);
		
		$perms = FgUtill::getFgPerms($delid, FgVars::FG_TYPE_GROUP);
		
		if(!$this->actUser->checkPermission($perms))
		{
			print "No pemissions for this action!";
		}
		else if($this->actUser->checkPermission('FG_GROUP_ID',$delid,true) ){
			print "Man kann nicht eigene Gruppe deaktivieren!";
		}
		else
		{
			$this->DB->query("update fg_group set Active=0 where ID=".$delid);

			print "OK";
		}
		return false;
	}

	/**
	 * zeigt partner list
	 */
	private function actionDefault()
	{

		$pid=0;

		if($this->actUser->checkPermission("PERM_RECHTE",PERM_ADMIN))
		{
			$pid=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('pid', $_REQUEST));
			if(is_null($pid))
			{
				$pid=$this->actUser->getPermissionsVal('FG_PARTNER_ID');
			}
		}
		else
		{
			$pid=$this->actUser->getPermissionsVal('FG_PARTNER_ID');
		}

		FgSession::getInstance()->LAST_PARTNER = $pid;

		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();
		$smarty->assign('itemlist',$this->DB->getAllAssoc("select A.* from fg_group A, fg_links B where B.PARENTID='".$pid."' and B.PARENTTYPE='".
							FgVars::FG_TYPE_PARTNER."' and B.KINDTYPE=".FgVars::FG_TYPE_GROUP." and A.ID=B.KINDID order by A.Active desc, A.Created desc"));




		$this->showContent = $smarty->fetch(self::RAUM.'Event_Group_List.tpl');
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
			$res = $this->DB->getOne("select 1 from fg_links where PARENTID='".$pid."' and PARENTID='".
							FgVars::FG_TYPE_PARTNER."' and KINDTYPE=".FgVars::FG_TYPE_GROUP." and KINDID=".$gid);

		if($res==1)return true;

		return false;
	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::hasAccess()
	 */
	public function hasAccess()
	{

		if($this->actUser->isLogin())
		{
			if($this->actUser->checkPermission("PERM_RECHTE",PERM_ADMIN))
			{
				return true;
			}
			elseif ($this->actUser->checkPermission("PERM_RECHTE",PERM_PARTNER_ADMIN,true))
			{
				if(FgUtill::getVal('gid', $_REQUEST))
				{
					if($this->isGroupFromPartner($this->actUser->getPermissionsVal('FG_PARTNER_ID'), $_REQUEST['gid']))
					{
						return true;
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

	public function isStream()
	{
		return false;
	}

}
