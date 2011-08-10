<?php
class Event_Cryptodira_Catalog_Admin extends Event_Base
{

	/* @var $DB DBObject */

	const ERROR_CLASS = 'Event_Start_Error';
	const RAUM = 'cryptodira/';
	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{

		FgSmarty::getInstance()->assign('paytype',FgUtill::getWfKategory(FgVars::WV_GROUP_PAYTYPE,FgLanguage::getInstance()->getAct(),true));

		switch($this->action)
		{
			//show block
			case 'soft_show':
				return $this->actionSoftShow();
				break;
			case 'line_show':
				return $this->actionLineShow();
				break;
			case 'version_show':
				return $this->actionVersionShow();
				break;


			//save block
			case 'soft_save':
				return $this->actionSoftSave();
				break;
			case 'line_save':
				return $this->actionLineSave();
				break;
			case 'version_save':
				return $this->actionVersionSave();
				break;


			/* delete block */
			case 'soft_delete':
				return $this->actionSoftDelete();				
				break;
			case 'line_delete':
				$this->actionLineDelete();
				return $this->actionCatalogList();
				break;
			case 'version_delete':
				$this->actionVersionDelete();
				return $this->actionCatalogList();
				break;

			case 'kategory_show':
				return $this->actionKategoryShow();
			case 'kategory_save':
				return $this->actionKategorySave();
				
				
			case 'line_list':
				return $this->actionLineList();	

			default:
				return $this->actionSoftList();
		}

		return false;
	}
	
	/*##############################################################*/
	private function actionLineList()
	{
		
		if($this->session->CRYPTO_CATALOG_SOFT_ID)
		{
			$soft=$this->DB->getAssoc("select * from fg_crypto_catalog where ID=".$this->session->CRYPTO_CATALOG_SOFT_ID);
			
			$lines=$this->DB->getAllAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE).
				" where CRYPTO_CATALOG_ID=".$this->session->CRYPTO_CATALOG_SOFT_ID." order by ID desc");
			$i=0;
			foreach($lines as &$tmp)
			{
				$versions=$this->DB->getAllAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_VERSION).
				" where CRYPTO_LINE_ID=".$tmp['ID']." order by ID desc");
				$tmp['versions']=$versions;
				$i++;
			}

			$soft['lines']=$lines;
			
			
			$smarty = FgSmarty::getInstance();
			$smarty->assign('soft',$soft);
			
			$smarty->display(self::RAUM.'Event_Cryptodira_Catalog_Admin_Lines_List.tpl');
		}
		
		return false;
	}	
	
	/*######################### block save #####################################*/
	private function actionSoftSave($nid=null)
	{
		if(!is_null($nid))
			$id=$nid;
		else
			$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));


		if($id)
		{
			$this->DB->update(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_SOFT), $_REQUEST, false, 'ID='.$id, 2,1);
		}
		else
		{
			$_REQUEST['CDATE']='now()';
			$_REQUEST['FG_USER_ID']=$this->actUser->getUserID();
			$id=$this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_SOFT), $_REQUEST, false, 2,1);
		}


		$langs=array_keys(FgLanguage::getInstance()->getAllowLanguage());

		foreach ($langs as $lang)
		{
			$softar = array(
				'PARENT_ID'=>$id,
				'LANG'=>$lang,
				'INFO'=>FgUtill::getVal($lang.'_INFO', $_REQUEST),
				'AGB'=>FgUtill::getVal($lang.'_AGB', $_REQUEST)
			);
			$this->DB->replace(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_SOFT_LANG), $softar, false, 2,1);


		}


		return $this->actionSoftShow($id);
	}

	/**
	 * save line information
	 * Enter description here ...
	 * @param unknown_type $nid
	 */
	private function actionLineSave($nid=null)
	{
		if(!is_null($nid))
			$id=$nid;
		else
			$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));

		$sid=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('sid', $_REQUEST));
			
		
		if($sid && $this->session->CRYPTO_CATALOG_SOFT_ID==$sid)
		{

			$savear=array(
				'CRYPTO_CATALOG_ID'=>$this->session->CRYPTO_CATALOG_SOFT_ID,
				'LNAME'=>FgUtill::getVal('LNAME', $_REQUEST),
				'CRYPTO_VERSION_ID'=>FgUtill::getVal('CRYPTO_VERSION_ID', $_REQUEST),
				'UDATE'=>'now()',
				'COUNTER'=>FgUtill::getVal('COUNTER', $_REQUEST),
				'WF_PAYTYPE'=>FgUtill::getVal('WF_PAYTYPE', $_REQUEST)

			);

			if($id)
			{
				$this->DB->update(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE), $savear, false, 'ID='.$id,2,1 );
				
			}
			else
			{
				$savear['FG_USER_ID']=$this->actUser->getUserID();
				$savear['CDATE']='now()';
				$id=$this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE), $savear, false,2,1 );	
				$this->DB->update(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_SOFT),
							'LINECOUNTER = LINECOUNTER+1',false,array(array('ID','=',$sid)),2,1);
				
			}

			FgSmarty::getInstance()->assign('save',true);
			
			if($id)
			{
				$langs=array_keys(FgLanguage::getInstance()->getAllowLanguage());

				foreach($langs as $lang)
				{
					$this->DB->replace(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE_LANG),
					array(
						'INFO'=>FgUtill::getVal('line_'.$lang.'_INFO',$_REQUEST),
						'PARENT_ID'=>$id,
						'LANG'=>$lang
					),false,2,1);
				}
			}


		}



		return $this->actionLineShow($id);
	}

	/**
	 * save dowload version
	 *
	 * @param unknown_type $nid
	 */
	private function actionVersionSave($nid=null)
	{
		if(!is_null($nid))
			$id=$nid;
		else
			$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));


		$sid=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('sid', $_REQUEST));
		$lid=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('lid', $_REQUEST));

		if($sid && $lid && $this->session->CRYPTO_CATALOG_SOFT_ID==$sid)
		{
			$savear=array(
				'CRYPTO_CATALOG_ID'=>$sid,
				'CRYPTO_LINE_ID'=>$lid,
				'VNAME'=>FgUtill::getVal('VNAME', $_REQUEST),
				'URL'=>FgUtill::getVal('URL', $_REQUEST),
				'VERSID'=>FgUtill::getVal('VERSID', $_REQUEST),
			    'UNID'=>FgUtill::getVal('UNID', $_REQUEST),
				'UDATE'=>'now()'
			);

			if($id)
			{
				if(!$savear['UNID'])
					$savear['UNID']='A'.strtoupper( sha1(uniqid('',true)) );
					
				$this->DB->update(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_VERSION), $savear, false, 'ID='.$id,2,1 );
			}
			else
			{
				$savear['UNID']='A'.strtoupper( sha1(uniqid('',true)) );
				$savear['FG_USER_ID']=$this->actUser->getUserID();
				$savear['CDATE']='now()';
				$id=$this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_VERSION), $savear, false,2,1 );		
			}
			
			FgSmarty::getInstance()->assign('save',true);
			
		}


		return $this->actionVersionShow($id);
	}

	/*#################### Block Show ##########################################*/

	private function actionSoftShow($nid=null)
	{
		if(!is_null($nid))
			$id=$nid;
		else
			$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));

		$soft=array();

		if(!is_null($id))
		{
			$soft=$this->DB->getAssoc("select * from fg_crypto_catalog where ID=".$id);
			$item_lang=$this->DB->getAllAssoc('select * from fg_crypto_catalog_lang where PARENT_ID='.$id,'LANG');

			$lines=$this->DB->getAllAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE).
				" where CRYPTO_CATALOG_ID=".$id." order by ID desc");
			$i=0;
			foreach($lines as &$tmp)
			{
				$versions=$this->DB->getAllAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_VERSION).
				" where CRYPTO_LINE_ID=".$tmp['ID']." order by ID desc");
				$tmp['versions']=$versions;
				$i++;
			}

			$soft['lines']=$lines;


			$this->session->CRYPTO_CATALOG_SOFT_ID = $id;

		}

		$langs=FgLanguage::getInstance()->getAllowLanguage();

		$kategory = FgUtill::getWfKategory(FgVars::WV_GROUP_KATEGORY, $this->fgLang->getAct(), true);


		$smarty = FgSmarty::getInstance();

		$smarty->assign('soft',$soft);
		$smarty->assign('item_lang',$item_lang);
		$smarty->assign('langs',$langs);
		$smarty->assign('kategory',$kategory);



		$this->loader->css(FgVars::CSS_LINK,FG_STYLESPACE.'/css/jquery-ui.css',1);
		$this->loader->js(FgVars::JS_LINK,FG_STYLESPACE.'/js/_jquery-ui.js',100);
		$this->loader->js(FgVars::JS_LINK,'/extmodule/ckeditor/ckeditor.js',200);
		$this->loader->js(FgVars::JS_LINK,'/extmodule/ImageManager/dialog.js',300);
		$this->loader->js(FgVars::JS_LINK,'/extmodule/ImageManager/IMEStandalone.js',400);

		$this->showContent = $smarty->fetch(self::RAUM.'Event_Cryptodira_Catalog_Admin_Soft.tpl');
		return true;

	}

	private function actionLineShow($nid=null)
	{
		if(!is_null($nid))
			$id=$nid;
		else
			$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));

		if($id && $this->session->CRYPTO_CATALOG_SOFT_ID)
		{
			$item=$this->DB->getAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE)." where ID=".$id." and CRYPTO_CATALOG_ID=".$this->session->CRYPTO_CATALOG_SOFT_ID);
			$item_lang=$this->DB->getAllAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE_LANG)." where PARENT_ID=".$id,'LANG');
			$langs=FgLanguage::getInstance()->getAllowLanguage();

			
			$versions=$this->DB->getKeyVal("select ID,VNAME from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_VERSION).
				" where CRYPTO_LINE_ID=".$id." order by ID desc");

			$smarty = FgSmarty::getInstance();
			$smarty->assign('item',$item);
			$smarty->assign('item_lang',$item_lang);
			$smarty->assign('langs',$langs);
			$smarty->assign('versions',$versions);
			$smarty->assign('sid',$this->session->CRYPTO_CATALOG_SOFT_ID);
			
			

			$smarty->display(self::RAUM.'Event_Cryptodira_Catalog_Admin_Line.tpl');
		}
		else if(!$id && $this->session->CRYPTO_CATALOG_SOFT_ID)
		{
			
			
			$item=array();
			$item_lang=array();
			$langs=FgLanguage::getInstance()->getAllowLanguage();


			$smarty = FgSmarty::getInstance();
			$smarty->assign('item',$item);
			$smarty->assign('item_lang',$item_lang);
			$smarty->assign('langs',$langs);
			$smarty->assign('sid',$this->session->CRYPTO_CATALOG_SOFT_ID);

			$smarty->display(self::RAUM.'Event_Cryptodira_Catalog_Admin_Line.tpl');
			
			
			
		}
		else
		{
			print "Item not found";
		}
		return false;
	}


	private function actionVersionShow($nid=null)
	{
		if(!is_null($nid))
			$id=$nid;
		else
			$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));

		if($this->session->CRYPTO_CATALOG_SOFT_ID)
		{
			if(!$id){
				$item=array(
					'CRYPTO_LINE_ID'=>FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('lid', $_REQUEST)),
					'CRYPTO_CATALOG_ID'=>$this->session->CRYPTO_CATALOG_SOFT_ID
				);
			}
			else 
				$item=$this->DB->getAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_VERSION).
					" where ID=".$id." and CRYPTO_CATALOG_ID=".$this->session->CRYPTO_CATALOG_SOFT_ID);

			$smarty = FgSmarty::getInstance();
			$smarty->assign('item',$item);

			$smarty->display(self::RAUM.'Event_Cryptodira_Catalog_Admin_Version.tpl');
		}		

		return false;
	}

	/**
	 * get software list
	 *
	 */
	private function actionSoftList()
	{

		$items = $this->DB->getAllAssoc("select A.* from (fg_crypto_catalog A) order by A.ORD,A.ID desc");

		$smarty = FgSmarty::getInstance();
		$smarty->assign('items',$items);

		$this->showContent = $smarty->fetch(self::RAUM.'Event_Cryptodira_Catalog_Admin_List.tpl');

		return true;

	}



	/**
	 * delete software
	 *
	 * @param int $id
	 */
	private function actionSoftDelete($id=null)
	{
		if(is_null($id))
			$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));


		if(!is_null($id))
		{
			$this->DB->query("delete from fg_crypto_catalog where ID=".$id);
			$this->DB->query("delete from fg_crypto_catalog_lang where PARENT_ID=".$id);

			$items = $this->DB->getCol("select ID from fg_crypto_line where CRYPTO_CATALOG_ID=".$id);

			foreach($items as $tmp)
			{
				$this->actionLineDelete($tmp);
			}

		}
		else
		{
			return $this->getErrorEvent();
		}

		
		print 'OK';
		
		return false;

	}

	/**
	 * delete software line
	 *
	 * @param int $id
	 */
	private function actionLineDelete($id=null)
	{
		if(is_null($id))
			$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));


		if(!is_null($id))
		{
			$this->DB->query("delete from fg_crypto_line where ID=".$id);
			$this->DB->query("delete from fg_crypto_line_lang where PARENT_ID=".$id);

			$items = $this->DB->getCol("select ID from fg_crypto_version where CRYPTO_LINE_ID=".$id);

			foreach($items as $tmp)
			{
				$this->actionVersionDelete($tmp);
			}
		}
		else
		{
			return $this->getErrorEvent();
		}

		return true;

	}


	/**
	 * delete version
	 *
	 * @param int $id
	 */
	private function actionVersionDelete($id=null)
	{
		if(is_null($id))
			$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));


		if(!is_null($id))
		{
			$this->DB->query("delete from fg_crypto_version where ID=".$id);
			$this->DB->query("delete from fg_crypto_veresion_lang where FG_CRYPTO_VERSION_ID=".$id);

		}
		else
		{
			return $this->getErrorEvent();
		}

		return true;

	}


	private function actionKategoryShow($nid=null)
	{
		if(!is_null($nid))
			$id=$nid;
		else
			$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));

		$wf=array();
		$wf_lang=array();

		if($id)
		{
			$wf=$this->DB->getAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_WF)." where id=".$id);
			$wf_lang = $this->DB->getAllAssoc("select LANG,LNG from ".FgVars::getTablePerType(FgVars::FG_TYPE_WF_LANG)." where PARENT_ID=".$id,'LANG');
		}

		$langs=FgLanguage::getInstance()->getAllowLanguage();

		$smarty=FgSmarty::getInstance();

		$smarty->assign('langs',$langs);
		$smarty->assign('item',$wf);
		$smarty->assign('item_lang',$wf_lang);

		$smarty->display(self::RAUM.'Event_Cryptodira_Catalog_Admin_Kategory_Show.tpl');

		return false;
	}

	private function actionKategorySave()
	{
		$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));

		$ar=array(
			'wtype'=>FgVars::WV_GROUP_KATEGORY,
			'ord'=>FgUtill::getVal('ord', $_REQUEST),
			'name'=>FgUtill::getVal('name', $_REQUEST),
			'val'=>FgUtill::getVal('val', $_REQUEST),
			'info'=>FgUtill::getVal('info', $_REQUEST),
		);

		if($id)
		{
			$this->DB->update(FgVars::getTablePerType(FgVars::FG_TYPE_WF), $ar, false, 'id='.$id, 2,1);
		}
		else
		{
			$id=$this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_WF), $ar, false, 2,1);
		}


		$langs=array_keys(FgLanguage::getInstance()->getAllowLanguage());


		foreach ($langs as $lang)
		{
			$ar = array(
				'PARENT_ID'=>$id,
				'LANG'=>$lang,
				'LNG'=>FgUtill::getVal($lang.'_LNG', $_REQUEST)
			);
			$this->DB->replace(FgVars::getTablePerType(FgVars::FG_TYPE_WF_LANG), $ar, false, 2,1);
		}

		FgSmarty::getInstance()->assign('save',true);

		return $this->actionKategoryShow($id);
	}


	
	public function showText($as,$bt)
	{
		echo $as.'  -  '.$bt;
	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::hasAccess()
	 */
	public function hasAccess()
	{
		/* permissions list */
		$perm = array("PERM_RECHTE" => PERM_ADMIN);
		if ($this->actUser->isLogin() && $this->actUser->checkPermission($perm))
		{
			return true;
		}

		return false;
	}

	public function getMainTemplate()
	{
		return 'maintemplates/admin_index.tpl';
	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getErrorEvent()
	 */
	public function getErrorEvent()
	{
		return FgLoader::getInstance()->loadObject(self::ERROR_CLASS,FG_EVENTS);
	}

	public function isStream()
	{
		return false;
	}

}
