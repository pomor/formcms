<?php
class Event_Logout extends Event_Base
{

	const ERROR_CLASS = 'Event_Start_Error';

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{
		session_destroy();

		/* @var $actUser FgUser */

		$this->session->actUser(false);
		$this->actUser->clearSession();
		$this->actUser= new FgUser();
		$this->session->actUser($this->actUser);
		
		return FgLoader::getInstance()->loadObject('Event_Cryptodira_Catalog',FG_EVENTS.'/cryptodira');
	
	}



	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getMainTemplate()
	 */
	public function getMainTemplate()
	{
		return FG_EVENT_DEFAULT_TEMPLATE;
	}


}
