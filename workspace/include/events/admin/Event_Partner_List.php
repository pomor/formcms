<?php
class Event_Partner_List extends Event_Base
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
		$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('pid',$_REQUEST));

		$saveArray = array(
				'Name'=>$_REQUEST['Name'],
				'Info'=>$_REQUEST['Info'],
				'Updated'=>'now()',
				'Active'=>$_REQUEST['Active']==1?1:0
			);

		if($id) // update
		{
			$this->DB->update("fg_partner",$saveArray,false,"ID=".$id,2,1);
		}
		else //insert
		{
			$saveArray['Created']='now()';

			$id=$this->DB->insert('fg_partner', $saveArray, false, 2,1);
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
			$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('pid',$_REQUEST));
		}


		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();

		$partner = array();
		if($id)
		{
			$partner = $this->DB->getAssoc("select * from fg_partner where ID=".$id);
			$smarty->assign('mySelect', $partner['Active']);
		}


		// option für  selectbox 'Aktiv'
		$smarty->assign('myOptions', array( 1 => 'Ja',  0 => 'Nein') );
		$smarty->assign('save',($_REQUEST['act']=='save'));


		// options für Radiobutton
		$smarty->assign('myRadio', array( 1 => 'Ein',  0 => 'Aus') );			
		
		// daten für permissions
		FgSession::getInstance()->setLastCustomPermissions($id, FgVars::FG_TYPE_PARTNER);
		

		$smarty->assign('partner',$partner);
		$smarty->display(self::RAUM.'Event_Partner_Edit.tpl');


		return false;

	}




	/**
	 * delete partner
	 * @return boolean false für haupttemplate bypass
	 */
	private function actionDelete()
	{

		$delid= FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('pid',$_REQUEST));


		if( $this->actUser->checkPermission('FG_PARTNER_ID',$delid) ){
			print "Man kann nicht eigene Partner deaktivieren!";
		}
		else
		{
			$this->DB->query("update fg_partner set Active=0 where ID=".$delid);

			print "OK";
		}
		return false;
	}

	/**
	 * zeigt partner list
	 */
	private function actionDefault()
	{

		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();
		$smarty->assign('Partners',$this->DB->getAllAssoc("select * from fg_partner order by Active desc, Created desc"));
		$this->showContent = $smarty->fetch(self::RAUM.'Event_Partner_List.tpl');
		return true;

	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::hasAccess()
	 */
	public function hasAccess()
	{

		/* permissions list */
		$perm = array(
			"PERM_RECHTE"=>PERM_ADMIN
		);
		if($this->actUser->isLogin() && $this->actUser->checkPermission($perm))
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
		return 'maintemplates/admin_index.tpl';
	}


}

