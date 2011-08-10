<?php

class Event_Items extends Event_Base
{

	/* @var $this->DB DBObject */
	const ERROR_CLASS = 'Event_Start_Error';
	const RAUM = 'items/';


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run($id=null)
	{

		if(is_null($id))
		{
			$id = FgUtill::checkVar(MSK_SAFESTRING, FgUtill::getVal('id', $_REQUEST));
		}
		

		if($id)
		{
			$actLang = $this->fgLang->getAct();
			
			if(is_numeric($id))
			{
				$sql="select * from fg_items_lang where PARENT_ID=$id and LANG='$actLang'";
			}
			else
			{
				$sql="select B.* from fg_items_lang A, fg_items B where A.PARENT_ID=B.ID and B.SYSNAME='$id' and A.LANG='$actLang'";
			}

			$item = $this->DB->getAssoc($sql);
			
			
			
			

			if(!isset($item['PARENT_ID']) || !$item['ACTIVE'] )
			{
				return $this->getErrorEvent();
			}


			$this->loader->meta('keywords',$item['META']);
			
			$smarty = FgSmarty::getInstance();
			$smarty->assign('item',$item);
			
			$this->showContent = $smarty->fetch(self::RAUM.'Event_Items.tpl');

		}

		return true;
	}



	public function hasAccess()
	{
		return true;
	}


	public function getErrorEvent()
	{
		return FgLoader::getInstance()->loadObject(self::ERROR_CLASS,FG_EVENTS);
	}

	public function isStream()
	{
		return false;
	}

    public function getMainTemplate()
	{
		return FG_EVENT_DEFAULT_TEMPLATE;
	}

}
