<?php

class Event_Items_Admin extends Event_Base
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


			switch($this->action)
			{
				case 'show':
					return $this->actionShow();
					break;
				case 'save':
					return $this->actionSave();
					break;
				case 'del':
					return $this->actionDelete();
					break;
				default:
					return $this->actionGetList();

			}



		return true;
	}


	private function actionDelete()
	{
		$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id',$_REQUEST));

		if($id)
		{
			$this->DB->query("delete from fg_items where ID=".$id);
			$this->DB->query("delete from fg_items_lang where PARENT_ID=".$id);
			FgUtill::deleteItem($id, FgVars::FG_TYPE_ITEMS);
		}

		print "OK";

		return false;

	}


	private function actionSave()
	{

		$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id',$_REQUEST));
		$langs=array_keys(FgLanguage::getInstance()->getAllowLanguage());

		if($id) // update
		{
			$this->DB->update("fg_items",array(
				'SYSNAME'=>FgUtill::getVal('SYSNAME',$_REQUEST),
				'KATEGORY'=>FgUtill::getVal('KATEGORY',$_REQUEST)
			),false,"ID=".$id,2,1);

			foreach($langs as $lang)
			{
				$this->DB->update("fg_items_lang",array(
					'TITLE'=>FgUtill::getVal($lang.'_TITLE',$_REQUEST),
					'INFO'=>FgUtill::getVal($lang.'_INFO',$_REQUEST),
					'TAGS'=>FgUtill::getVal($lang.'_TAGS',$_REQUEST),
					'META'=>FgUtill::getVal($lang.'_META',$_REQUEST),
					'ACTIVE'=>FgUtill::getVal($lang.'_ACTIVE',$_REQUEST)
				),false,"PARENT_ID=".$id." and LANG='".$lang."'",2,1);
			}		
			
		}
		else //insert
		{
			$id=$this->DB->insert("fg_items",array(
				'SYSNAME'=>FgUtill::getVal('SYSNAME',$_REQUEST),
				'KATEGORY'=>FgUtill::getVal('KATEGORY',$_REQUEST),
				'CREATED'=>'now()'
			),false,2,1);

			foreach($langs as $lang)
			{
				$this->DB->insert("fg_items_lang",array(
					'TITLE'=>FgUtill::getVal($lang.'_TITLE',$_REQUEST),
					'INFO'=>FgUtill::getVal($lang.'_INFO',$_REQUEST),
					'TAGS'=>FgUtill::getVal($lang.'_TAGS',$_REQUEST),
					'META'=>FgUtill::getVal($lang.'_META',$_REQUEST),
					'ACTIVE'=>FgUtill::getVal($lang.'_ACTIVE',$_REQUEST),
					'LANG'=>$lang,
					'PARENT_ID'=>$id,
					'CREATED'=>'now()'

				),false,2,1);
			}
		}

		return $this->actionShow($id);
	}


private function actionShow($id=null)
{
	if(!$id)
	{
		$id = FgUtill::checkVar(MSK_INT, FgUtill::getVal('id', $_REQUEST));
	}
	$item_idx=array();
	$item_lang=array();


	if($id>0)
	{
		$item_idx =$this->DB->getAssoc("select * from fg_items where ID=".$id);
		$item_lang=$this->DB->getAllAssoc("select * from fg_items_lang where PARENT_ID=".$id,'LANG');
	}


	$langs=FgLanguage::getInstance()->getAllowLanguage();

	$smarty=FgSmarty::getInstance();

	$smarty->assign('item_idx',$item_idx);
	$smarty->assign('item_lang',$item_lang);
	$smarty->assign('langs', $langs);
	$smarty->assign('myOptions', array( 1 => 'Ja',  0 => 'Nein') );
	$smarty->assign('save',($_REQUEST['act']=='save'));


	FgSession::getInstance()->setLastCustomPermissions($id, FgVars::FG_TYPE_ITEMS);

	$smarty->display(self::RAUM.'Event_Items_Admin_Edit.tpl');


	return false;

}


/**
 * zeigt verfügbare items
 *
 * @return boolean
 */
	private function actionGetList()
	{
		$actLang = FgLanguage::getInstance()->getAct();
		$allitems = $this->DB->getAllAssoc("select A.ID,A.SYSNAME,A.CREATED,B.TITLE from (fg_items A) LEFT JOIN (fg_items_lang B) ON (A.ID=B.PARENT_ID and B.LANG='".$actLang."') order by A.CREATED desc");

		$smatry=FgSmarty::getInstance();
		$smatry->assign('items',$allitems);

		$this->loader->css(FgVars::CSS_LINK,FG_STYLESPACE.'/css/jquery-ui.css',1);
		$this->loader->js(FgVars::JS_LINK,FG_STYLESPACE.'/js/_jquery-ui.js',100);
		$this->loader->js(FgVars::JS_LINK,'/extmodule/ckeditor/ckeditor.js',200);

		$this->showContent = $smatry->fetch(self::RAUM.'Event_Items_Admin_List.tpl');

		return true;
	}




	public function hasAccess()
	{
			/* permissions list */
		$perm = array(
			"PERM_RECHTE"=>PERM_ADMIN
		);
		if($this->actUser->isLogin() && $this->actUser->checkPermission($perm))
		{
			return true;
		}

		return false;
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
		return 'maintemplates/admin_index.tpl';
	}

}
