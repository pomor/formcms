<?php
class Event_Start extends Event_Base
{

	const ERROR_CLASS = 'Event_Start_Error';


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{
		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();

		$this->showContent = $smarty->fetch('start.tpl');

		return true;
	}

	public function getMainTemplate()
	{
		return 'index.tpl';
	}

}
