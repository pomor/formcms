<?php
class Event_Cryptodira_Catalog_Download extends Event_Base
{

	/* @var $DB DBObject */

	const ERROR_CLASS = 'Event_Start_Error';
	const ROOM = 'cryptodira/';
	private $step = 12;


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{
		//header("Content-type","text/xml");

		switch($this->action)
		{		
			default:
				return $this->actionDownloadSoft();
		}


		return false;
	}



	private function actionDownloadSoft()
	{
		$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));
		
		
		if($id)
		{
			
			$info=$this->DB->getAssoc("select ID,URL,CRYPTO_CATALOG_ID,CRYPTO_LINE_ID from ".
			FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_VERSION)." where ID=".$id);

				
			
			if(isset($info['ID']))
			{
				$allowID=$this->actUser->checkPermission(FgUtill::getFgPerms($info['ID'], FgVars::FG_TYPE_CRYPTODIRA_VERSION));
				$allowCRYPTO_CATALOG_ID=$this->actUser->checkPermission(FgUtill::getFgPerms($info['CRYPTO_CATALOG_ID'], FgVars::FG_TYPE_CRYPTODIRA_SOFT));
				$allowCRYPTO_LINE_ID=$this->actUser->checkPermission(FgUtill::getFgPerms($info['CRYPTO_LINE_ID'], FgVars::FG_TYPE_CRYPTODIRA_LINE));

				if($allowID && $allowCRYPTO_LINE_ID && $allowCRYPTO_CATALOG_ID)
				{
					header("Location: ".$info['URL']);					
				}
				else
				{
					return $this->getErrorEvent();
				}
			}
		}

		return false;
	}



	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::hasAccess()
	 */
	public function hasAccess()
	{
		return $this->actUser->isLogin();
	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getErrorEvent()
	 */
	public function getErrorEvent()
	{
		return FgLoader::getInstance()->loadObject(self::ERROR_CLASS,FG_EVENTS);
	}

	public function isStream()
	{
		return true;
	}

}
