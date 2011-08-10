<?php
class Event_XML_List extends Event_Base
{

	const ERROR_CLASS = 'Event_Start_Error';
		const RAUM = 'banchmarcking/';

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{

		$list= $this->DB->getAllAssoc("select ID from fg_tabl01_val order by ID");

		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();

		$smarty->assign('formitems',$list);
		$this->showContent = $smarty->fetch(self::RAUM.'event_xml_list.tpl');


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
			"MODULE_BENCHMARKING"=>1,
			"PERM_RECHTE"=>PERM_MONITOR
		);
		if($this->actUser->isLogin() && $this->actUser->checkPermission($perm))
				return true;

		return false;
	}


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getMainTemplate()
	 */
	public function getMainTemplate()
	{
		return 'index.tpl';
	}

}
