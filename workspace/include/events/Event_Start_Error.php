<?php
class Event_Start_Error extends Event_Base
{

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{
		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();
		$smarty->assign('Name', FgSession::getInstance()->actUser()->name);
		$this->showContent = $smarty->fetch('error.tpl');

		return true;
	}


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getMainTemplate()
	 */
	public function getMainTemplate()
	{
		return FG_EVENT_DEFAULT_TEMPLATE;
	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getErrorEvent()
	 */
	public function getErrorEvent()
	{
		return null;
	}




}
