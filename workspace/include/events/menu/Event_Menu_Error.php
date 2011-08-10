<?php
class Event_Menu_Error extends Event_Base
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
		$smarty->display('error.tpl');

		return false;
	}


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getMainTemplate()
	 */
	public function getMainTemplate()
	{
		return 'maintemplates/index.tpl';
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
