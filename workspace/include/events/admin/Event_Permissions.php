<?php
class Event_Permissions extends Event_Base
{

	const ERROR_CLASS = 'Event_Start_Error';
	const RAUM = 'admin/';

	private $temp_arrays = array();

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{		

		list($objectID,$objectType)=FgSession::getInstance()->getLastCustomPermissions();

		if(!$objectID)
			return $this->getErrorEvent();

		switch($this->action)
		{
		/* speichern permissions */
		case 'save':
			return $this->actionSave($objectID, $objectType);
			break;

		/* zeigen objekt permission */
		default:
			return $this->actionShow($objectID, $objectType);
		}

	}

	/**
	 * Update or Insert Partner
	 * @return boolean
	 */
	private function actionSave($objectID, $objectType)
	{
		$rechte = $this->DB
				->getKeyVal(
						"select NAME,ID from fg_perm where OBJECTTYPE=" . $objectType
								. " and OBJECTID=" . $objectID);

		/*    #################   PERM_RECHTE   #####################    */

		$perms = $this->DB
				->getKeyVal(
						"select val,info from fg_wf where wtype=" . FgVars::WV_GROUP_PERMISSIONS
								. " and val<=" . $this->actUser->getPermissionsVal('PERM_RECHTE')
								. " order by val");



		$tmp = FgUtill::checkVar(MSK_INT, FgUtill::getVal('PERM_RECHTE', $_REQUEST));// get and check PERM_RECHTE

		if ($tmp && FgUtill::getVal($tmp, $perms))
		{
			$this
					->setPerm($objectID, $objectType, 'PERM_RECHTE', $tmp,
							FgUtill::getVal('PERM_RECHTE', $rechte));
		}

		/*    #################   LOGIN   #####################    */

		$tmp = FgUtill::checkVar(MSK_INT, FgUtill::getVal('LOGIN', $_REQUEST));// get and check LOGIN
		if ($tmp && $tmp >= -1 && $tmp < 2)
		{
			$this->setPerm($objectID, $objectType, 'LOGIN', $tmp, FgUtill::getVal('LOGIN', $rechte));
		}
		
		
		/*################## MODULE ############################*/
		
		$module=$this->DB->getCol("select name from fg_wf where wtype=".FgVars::WV_GROUP_MODULE);
		foreach($module as $tmp)
		{
			
			$tval=FgUtill::checkVar(MSK_INT, FgUtill::getVal($tmp,$_REQUEST));
						
			$this->setPerm($objectID, $objectType, $tmp, $tval, FgUtill::getVal($tmp, $rechte));

			
		}

		return $this->actionShow($objectID, $objectType, true);
	}

	/**
	 * inserted/updated/deleted eintrag in permissions tabelle fg_perm
	 *
	 * @param int $objectID
	 * @param int $objectType
	 * @param string $name eintrag name
	 * @param int $tmp	value
	 * @param int $eid gespeicherte ID
	 */
	private function setPerm($objectID, $objectType, $name, $tmp, $eid)
	{

		if ($tmp == -1)
		{

			// delete PERM_RECHTE
			if ($eid)
				$this->DB->query("delete from fg_perm where ID=$eid");
		}
		else
		{
			if ($eid)
			{
				// update PERM_RECHTE
				$this->DB->update('fg_perm', array('VAL' => $tmp), false, "ID=$eid", 2, 1);
			}
			else
			{
				// insert PERM_RECHTE
				$this->DB
						->insert('fg_perm',
								array('OBJECTTYPE' => $objectType, 'OBJECTID' => $objectID,
										'NAME' => $name, 'VAL' => $tmp, 'CREATED' => 'now()'),
								false, 2, 1);
			}
		}
	}

	/**
	 * zeigt Partner information für bearbeitung
	 *
	 * @param int $id
	 * @return boolean
	 */
	private function actionShow($objectID, $objectType, $save=false)
	{

		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();
		$smarty->assign('myOptions', array('-1' => 'Irelevant', '1' => 'Ja', '0' => 'Nein'));
		$smarty->assign('oid', $objectID);
		$smarty->assign('otype', $objectType);
		$smarty->assign('save', $save);

		$rechte = $this->DB
				->getKeyVal(
						"select NAME,VAL from fg_perm where OBJECTTYPE=" . $objectType
								. " and OBJECTID=" . $objectID);


		// show PERM_RECHTE
		$perms = $this->DB
				->getKeyVal(
						"select val,info from fg_wf where wtype=" . FgVars::WV_GROUP_PERMISSIONS
								. " and val<=" . $this->actUser->getPermissionsVal('PERM_RECHTE')
								. " order by ord desc");
		

		$smarty->assign('perms', $perms);
		$smarty->assign('selperm', isset($rechte['PERM_RECHTE'])?$rechte['PERM_RECHTE']:-1);


		$module=$this->DB->getAllAssoc("select name,info from fg_wf where wtype=".FgVars::WV_GROUP_MODULE);
		
		$modlist=array();
		foreach($module as $tmp)
		{
			if(isset($rechte[$tmp['name']]))
				$tval=($rechte[$tmp['name']]==1)?1:0;
			else
				$tval=-1;
			$modlist[]=array($tmp['info'],$tmp['name'],$tval);
		}

		$smarty->assign('modulen',$modlist);
		
		

		// show LOGIN
		$smarty->assign('sellogin', isset($rechte['LOGIN']) ? $rechte['LOGIN'] : '-1');

		$smarty->display(self::RAUM . 'Event_Permissions.tpl');
		return false;

	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::hasAccess()
	 */
	public function hasAccess()
	{
		/* permissions list */
		$perm = array("PERM_RECHTE" => PERM_ADMIN);
		if ($this->actUser->isLogin() && $this->actUser->checkPermission($perm))
		{
			return true;
		}

		return false;
	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getMainTemplate()
	 */
	public function getMainTemplate()
	{
		return null;
	}

}
