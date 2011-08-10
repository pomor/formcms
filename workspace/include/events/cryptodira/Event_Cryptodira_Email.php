<?php
class Event_Cryptodira_Email extends Event_Base
{

	/* @var $DB DBObject */

	const ERROR_CLASS = 'Event_Start_Error';
	const ROOM = 'cryptodira/';
	
	
	public function __construct()
	{
		parent::__construct();
		$this->mainTemplate=FG_EVENT_DEFAULT_TEMPLATE;	
	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{
		//header("Content-type","text/xml");

		switch($this->action)
		{
			case 'dv':
				return $this->actionDeviceActive();
			default:
				return $this->getErrorEvent();
		}


		return false;
	}

	
	
	private function actionDeviceActive()
	{
		$code=FgUtill::checkVar(MSK_SAFESTRING, FgUtill::getVal('cd', $_REQUEST));
		$DB=$this->DB;
		if($code)
		{
			if($DB->update(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_DEVICE),array('ACTIVE'=>1,'CODE'=>uniqid('CD',true)),false,"CODE='".$code."'",2,1) > 0)
			{
				//todo: scho ok message
			}
		}
		
		return true;
		
	}


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::hasAccess()
	 */
	public function hasAccess()
	{
		return true;
	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getErrorEvent()
	 */
	public function getErrorEvent()
	{
		return FgLoader::getInstance()->loadObject(self::ERROR_CLASS,FG_EVENTS);
	}
	
}

