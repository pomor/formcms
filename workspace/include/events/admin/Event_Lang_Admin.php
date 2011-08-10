<?php

class Event_Lang_Admin extends Event_Base
{

	/* @var $this->DB DBObject */
	const ERROR_CLASS = 'Event_Start_Error';
	const RAUM = 'admin/';


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
				case 'list':
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
			$this->DB->query("delete from fg_sys_lang where ID=".$id);
			$this->DB->query("delete from fg_sys_lang_inf where SYS_LANG_ID=".$id);
		}

		return $this->actionGetList();

	}


	private function actionSave()
	{

		$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id',$_REQUEST));
		$langs=$this->DB->getCol("select name from fg_wf where wtype=".FgVars::WV_GROUP_LANGUAGES);

		if($id) // update
		{
			$this->DB->update("fg_sys_lang",array(
				'NAME'=>FgUtill::getVal('NAME',$_REQUEST),
				'GTYPE'=>FgUtill::getVal('GTYPE',$_REQUEST),
				'INFO'=>FgUtill::getVal('INFO',$_REQUEST)
			),false,"ID=".$id,2,1);

			foreach($langs as $lang)
			{
				$this->DB->replace("fg_sys_lang_inf",array(
					'CONTENT'=>FgUtill::getVal($lang.'_CONTENT',$_REQUEST),
					'SYS_LANG_ID'=>$id,
					'LANG'=>$lang
				),false,2,1);
			}
		}
		else //insert
		{
			$id=$this->DB->insert("fg_sys_lang",array(
				'NAME'=>FgUtill::getVal('NAME',$_REQUEST),
				'GTYPE'=>FgUtill::getVal('GTYPE',$_REQUEST),
				'INFO'=>FgUtill::getVal('INFO',$_REQUEST)
			),false,2,1);

			foreach($langs as $lang)
			{
				$this->DB->insert("fg_sys_lang_inf",array(
					'CONTENT'=>FgUtill::getVal($lang.'_CONTENT',$_REQUEST),
					'SYS_LANG_ID'=>$id,
					'LANG'=>$lang
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
		$item_idx =$this->DB->getAssoc("select * from fg_sys_lang where ID=".$id);
		$item_lang=$this->DB->getAllAssoc("select * from fg_sys_lang_inf where SYS_LANG_ID=".$id,'LANG');
	}


	$langs=$this->DB->getAllAssoc("select name,val from fg_wf where wtype=".FgVars::WV_GROUP_LANGUAGES);

	$groups = $this->DB->getCol("select distinct(GTYPE) from fg_sys_lang order by GTYPE");
	$groups[]='add new';

	$smarty=FgSmarty::getInstance();

	$smarty->assign('item_idx',$item_idx);
	$smarty->assign('item_lang',$item_lang);
	$smarty->assign('langs', $langs);
	$smarty->assign('groups', $groups);
	$smarty->assign('save',($_REQUEST['act']=='save'));

	$smarty->display(self::RAUM.'Event_Lang_Admin_Edit.tpl');


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
		$allitems = $this->DB->getAllAssoc("select A.ID,A.GTYPE,A.NAME from (fg_sys_lang A) order by A.NAME");

		$smatry=FgSmarty::getInstance();
		$smatry->assign('items',$allitems);

		$this->loader->css(FgVars::CSS_LINK,FG_STYLESPACE.'/css/jquery-ui.css',1);
		$this->loader->js(FgVars::JS_LINK,FG_STYLESPACE.'/js/_jquery-ui.js',100);
		$this->loader->js(FgVars::JS_LINK,'/extmodule/ckeditor/ckeditor.js',200);

		$this->showContent = $smatry->fetch(self::RAUM.'Event_Lang_Admin_List.tpl');

		return true;
	}




	public function hasAccess()
	{
			/* permissions list */
		$perm = array ("PERM_RECHTE" => PERM_ADMIN );
		if ($this->actUser->isLogin () && $this->actUser->checkPermission ( $perm )) {
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
