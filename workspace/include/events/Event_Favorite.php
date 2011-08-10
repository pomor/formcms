<?php
class Event_Favorite extends Event_Base
{

	const ERROR_CLASS = 'Event_Start_Error';

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{
		switch($this->action)
		{
			case 'add':
				$this->actionAdd();
				break;
			case 'del':
				$this->actionDelete();
				break;
			default:
				print "Logen sie sich bitte erst ein";
		}
		return false;
	}


	private function actionAdd()
	{
		$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));
		$otype=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('otype', $_REQUEST));


		if($this->actUser->isLogin() && $id && $otype)
		{
			$tmpid=$this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_FAVORITE),array(
				'FG_USER_ID'=>$this->actUser->getUserID(),
				'OBJECT_ID'=>$id,
				'OBJECT_TYPE'=>$otype
			),false,2,1);

			if($tmpid)
				print "OK";
			else
				$this->actionDelete();

		}
		else
		{
			print "Logen sie sich bitte erst ein";
		}


	}
	
	private function actionDelete()
	{
		$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));
		$otype=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('otype', $_REQUEST));


		if($this->actUser->isLogin() && $id && $otype)
		{
			
			$this->DB->query("delete from ".FgVars::getTablePerType(FgVars::FG_TYPE_FAVORITE).
				" where FG_USER_ID=".$this->actUser->getUserID()." and OBJECT_ID=".$id." and OBJECT_TYPE=".$otype);
				
				print "DEL";
		}
		else
		{
			print "Logen sie sich bitte erst ein";
		}


	}


	public function isStream()
	{
		return true;
	}

}
