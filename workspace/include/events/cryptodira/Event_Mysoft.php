<?php
class Event_Mysoft extends Event_Base
{

	const ERROR_CLASS = 'Event_Start_Error';
	const ROOM = 'cryptodira/';
	private $step = 12;

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{
		
		if($this->actUser->isLogin())
		{
			$catalog_lang = FgLanguage::getInstance()->getLanguage('crypto_catalog', $this->fgLang->getAct());
			FgSmarty::getInstance()->assign('catalog_lang',$catalog_lang);
			
			switch($this->action)
			{
				case 'add':
					$this->actionAdd();
					break;
				default:
					return $this->actionMysoftList();
			}
		}
		else
		{
			print "Logen sie sich bitte erst ein";
		}
		return false;
	}
	
	
	
	/**
	 * show selected files for install and his status
	 * 
	 */
	private function actionMysoftList()
	{
		$items=array();

		
				
			$items = $this->DB->getAllAssoc("SELECT A.*,B.NAME,C.LNAME,D.VNAME
				FROM (".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_MYSOFT)." A) 
				left join (".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_SOFT)." B) on (B.ID=A.`FG_CRYPTO_CATALOG_ID`)
				left join (".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE)." C) on (C.ID=A.`FG_CRYPTO_LINE_ID`)
				left join (".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_VERSION)." D) on (D.ID=A.`FG_CRYPTO_VERSION_ID`)
				where A.FG_USER_ID=".$this->actUser->getUserID());		

		

			
		$smarty = FgSmarty::getInstance();

		$smarty->assign('items',$items);


		$smarty->assign('catalog_title','MySoft');


		$this->showContent = $smarty->fetch(self::ROOM.'Event_Catalog_Mysoft_List.tpl');

		return true;

	}
	


	private function actionAdd()
	{
		$lineId=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('lid', $_REQUEST));

		if($lineId)
		{
				
			$lineInfo = $this->DB->getAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE).
			" where ID=".$lineId." and CRYPTO_VERSION_ID>0");
				
			if(isset($lineInfo['ID']))
			{

				//isset mysoft
				$mySoftInfo = $this->DB->getAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_MYSOFT).
			" where FG_USER_ID=".$this->actUser->getUserID()." and FG_CRYPTO_CATALOG_ID=".$lineInfo['CRYPTO_CATALOG_ID'].
			" and FG_CRYPTO_LINE_ID=".$lineInfo['ID']);

					


				if(!isset($mySoftInfo['ID']))
				{
					$save_array = array(
					'FG_CRYPTO_CATALOG_ID'=>$lineInfo['CRYPTO_CATALOG_ID'],
					'FG_CRYPTO_LINE_ID'=>$lineInfo['ID'],
					'FG_CRYPTO_VERSION_ID'=>$lineInfo['CRYPTO_VERSION_ID'],
					'STATUS'=>FgVars::FG_MYSOFT_STATUS_INSTALL,
					'CDATE'=>'now()',
					'UDATE'=>'now()',
					'FG_USER_ID'=>$this->actUser->getUserID()				
					);

					$tmpid=$this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_MYSOFT),$save_array,false,2,1);
					$this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_HISTORY),$save_array,false,2,1);
					
					print "OK";
				}
				else 
				{
					print "This file is already selected";
				}

					
					
			}
				
		}
		else
		{
			print "File not found";
		}


	}

	private function actionDelete()
	{
		$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));

		
		
			if($id){
					
				$stat = $this->DB->update(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_MYSOFT),
				array('STATUS'=>FgVars::FG_MYSOFT_STATUS_DELETED),false,"FG_USER_ID=".
				$this->actUser->getUserID()." and ID=".$id,2,1);
	
				if($stat)
				print "OK";
				else
				print "File not found";
	
			}
			else
			{
				print "File not found";
			}
		

	}


	public function hasAccess()
	{
		return true;
	}

	public function isStream()
	{
		return false;
	}

}
