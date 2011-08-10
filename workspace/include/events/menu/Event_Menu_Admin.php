<?php

class Event_Menu_Admin extends Event_Base
{

	/* @var $this->DB DBObject */
	const ERROR_CLASS = 'Event_Start_Error';
	const RAUM = 'menu/';


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run($id=null)
	{
			switch($this->action)
			{

				case 'menushow':
					return $this->actionMenuShow();
					break;
				case 'menusave':
					return $this->actionMenuSave();
					break;
				case 'menudel':
					return $this->actionMenuDelete();
					break;
				case 'menulist':
					return $this->actonMenuList();
					break;
				case 'menuord':
					return $this->actonMenuOrd();
					break;



				case 'groupsave':
					return $this->actionGroupSave();
				case 'groupshow':
					return $this->actionGroupShow();
				case 'groupdel':
					return $this->actionGroupDelete();
				default:
					return $this->actionGroupList();

			}



		return true;
	}
	/*############################## Item  actions #####################################*/
	private function actionMenuSave()
	{
		$gid = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('gid',$_REQUEST));
		$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id',$_REQUEST));
		
		if(!is_null($gid))
		{
			
			$menu = array(
				'Name'=>FgUtill::getVal('Name', $_REQUEST),
				'Url'=>FgUtill::getVal('Url', $_REQUEST),
				'Event'=>FgUtill::getVal('Event', $_REQUEST)
			);
			
			if($id)
			{
				//update old menu
				$this->DB->update(FgVars::getTablePerType(FgVars::FG_TYPE_MENU_ITEM),$menu,false,"ID=".$id,2,1);
				
			}
			else 
			{
				//save new menu	
				$id=$this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_MENU_ITEM),$menu,false,2,1);
				FgUtill::addFgLinks($gid, FgVars::FG_TYPE_MENU_GROUP, $id, FgVars::FG_TYPE_MENU_ITEM);
			}
			
			
			if($id)
			{
				$langs=array_keys(FgLanguage::getInstance()->getAllowLanguage());	
				foreach($langs as $lng)
				{
					$lid=$this->DB->getOne(sprintf("select ID from fg_menu_lang where PARENT_ID=%d and LANG='%s'",$id,$lng));
					
					if($lid)
					{
						$this->DB->update('fg_menu_lang',array(
									'NAME'=>FgUtill::getVal($lng.'_NAME', $_REQUEST),
									'INFO'=>FgUtill::getVal($lng.'_INFO', $_REQUEST)
						),false,'ID='.$lid,2,1);
					}
					else 
					{
						$this->DB->insert('fg_menu_lang',array(
									'NAME'=>FgUtill::getVal($lng.'_NAME', $_REQUEST),
									'INFO'=>FgUtill::getVal($lng.'_INFO', $_REQUEST),
									'PARENT_ID'=>$id,
									'LANG'=>$lng
						),false,2,1);
						
					}
					
				}
				
			}
			
			
			FgSmarty::getInstance()->assign('save',true);
			
		}
		else 
		{
			return $this->getErrorEvent();
		}
		
		
		
		return $this->actionMenuShow($id);
	}
	
	private function actionMenuShow($menuid=null)
	{
		$gid = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('gid',$_REQUEST));
		if(is_null($menuid))
			$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id',$_REQUEST));
		else 
			$id=$menuid;
		
		if($gid && !is_null($id))
		{
			
			$menu=array();
			$menu_lang=array();
			
			if($id)
			{				
				$menu = $this->DB->getAssoc("select * from fg_menu where ID=".$id);
				$menu_lang=$this->DB->getAllAssoc("select * from fg_menu_lang where PARENT_ID=".$id,'LANG');
				
				FgSession::getInstance()->setLastCustomPermissions($id, FgVars::FG_TYPE_MENU_ITEM);
			}				
			
			
			
			$smarty = FgSmarty::getInstance();			
			$smarty->assign('item',$menu);
			$smarty->assign('item_lang',$menu_lang);
			$smarty->assign('gid',$gid);
			
			$langs=FgLanguage::getInstance()->getAllowLanguage();	
			$smarty->assign('langs',$langs);
			
			$module=$this->DB->getCol("select Name from fg_sys_module where Space in ('".FG_SPACE."','default')");
			$smarty->assign('module',$module);

			$links=$this->DB->getAssoc("select * from fg_links where PARENTID=".$id." and PARETTYPE=".FgVars::FG_TYPE_MENU_ITEM);
			
			
			$smarty->display(self::RAUM.'Event_Menu_Admin_Item_Show.tpl');
			
		}	
		else 
		{
			return $this->getAjaxError();			
		}

		return false;
		
	}
	
	
	private function actonMenuOrd()
	{
		$gid = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('gid',$_REQUEST));
		if(!is_null($gid))
		{
			
			if(isset($_REQUEST['items']))
			{
				$cnt=0;
				foreach($_REQUEST['items'] as $tmp)
				{
					$tmp = FgUtill::checkVar(MSK_ZAHL,$tmp);
					if(!is_null($tmp))
					{
						$this->DB->update(FgVars::getTablePerType(FgVars::FG_TYPE_MENU_ITEM),array('Ord'=>$cnt,'Lvl'=>$_REQUEST['lvls'][$cnt]),false,"ID=".$tmp,2,1);
					}
	
					++$cnt;
				}
			}
		}
		else
		{
			return $this->getErrorEvent();
		}

		return $this->actonMenuList();

	}


	private function actonMenuList()
	{
		$gid = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('gid',$_REQUEST));


		if(!is_null($gid))
		{

		$this->loader->css(FgVars::CSS_LINK,FG_STYLESPACE.'/css/jquery-ui_sort.css',1);
		$this->loader->js(FgVars::JS_LINK,FG_STYLESPACE.'/js/jquery-ui_sort.js',100);

		$items = $this->DB->getAllAssoc("select B.* from (fg_links A, fg_menu B) where A.PARENTID=".$gid
			." and A.PARENTTYPE=".FgVars::FG_TYPE_MENU_GROUP." and A.KINDTYPE=".FgVars::FG_TYPE_MENU_ITEM." and A.KINDID=B.ID order by B.Ord");


		$smarty=FgSmarty::getInstance();
		$smarty->assign('gid',$gid);
		$smarty->assign('items',$items);


		$this->showContent = $smarty->fetch(self::RAUM.'Event_Menu_Admin_Item_List.tpl');
		}
		else
		{
			return $this->getErrorEvent();
		}

		return true;

	}



	/**
	 * delete menu with permissions and links
	 *
	 * @param int $menuid
	 */
	private function actionMenuDelete($menuid=null)
	{
		if(!is_null($menuid))
			$id=$menuid;
		else
		{
			$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id',$_REQUEST));
			print 'OK';
		}
			
			
		if(!is_null($id))
		{
			// delete menu
			$this->DB->query("delete from fg_menu where ID=".$id);
			$this->DB->query("delete from fg_menu_lang where PARENT_ID=".$id);
			
			FgUtill::deleteItem($id, FgVars::FG_TYPE_MENU_ITEM);
			
		}

		return false;
	}


	/*############################## Group actions #####################################*/

	private function actionGroupSave()
	{
		$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('gid',$_REQUEST));

		$saveArray = array(
				'NAME'=>$_REQUEST['NAME'],
				'INFO'=>$_REQUEST['INFO']
			);

		if($id) // update
		{
			$this->DB->update(FgVars::getTablePerType(FgVars::FG_TYPE_MENU_GROUP),$saveArray,false,"ID=".$id,2,1);
		}
		else //insert
		{
			$saveArray['CREATED']='now()';

			$id=$this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_MENU_GROUP), $saveArray, false, 2,1);
		}

		FgSmarty::getInstance()->assign('save',true);

		return $this->actionGroupShow($id);
	}

	/**
	 *
	 *
	 * @param int $groupid
	 */
	private function actionGroupShow($groupid=null)
	{

		if(is_null($groupid))
			$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('gid',$_REQUEST));
		else
			$id=$groupid;


		if(!is_null($id))
		{
			$item = $this->DB->getAssoc("select * from fg_menu_group where ID=".$id);
			$smarty = FgSmarty::getInstance();

			$smarty->assign('item',$item);
			$smarty->display(self::RAUM.'Event_Menu_Admin_Group_Show.tpl');

			FgSession::getInstance()->setLastCustomPermissions($id, FgVars::FG_TYPE_MENU_GROUP);
		}

		return false;
	}

	/**
	 * show menu groups list
	 */
	private function actionGroupList()
	{
		$groups= $this->DB->getAllAssoc("select * from fg_menu_group order by NAME");
		$smarty = FgSmarty::getInstance();

		$smarty->assign('items',$groups);
		$this->showContent = $smarty->fetch(self::RAUM.'Event_Menu_Admin_Group_List.tpl');

		return true;
	}


	/**
	 * delete menu group per id and all child menu
	 */
	private function actionGroupDelete()
	{
		$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('gid',$_REQUEST));
		if(!is_null($id))
		{
			$this->DB->query("delete from fg_menu_group where ID=".$id);
			$items=$this->DB->getCol("select KINDID from fg_links where PARENTID=".$id
				." and PARENTTYPE=".FgVars::FG_TYPE_MENU_GROUP." and KINDTYPE=".FgVars::FG_TYPE_MENU_ITEM);

			foreach($items as $menuid)
			{
				$this->actionMenuDelete($menuid);
			}
			
			FgUtill::deleteItem($id, FgVars::FG_TYPE_MENU_GROUP);

		}

		print "OK";

		return false;
	}


	private function getAjaxError()
	{
		return FgLoader::getInstance()->loadObject('Event_Menu_Error',FG_EVENTS.'/'.self::RAUM);
	}
	/*######################### iEvent ####################################*/

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
