<?php
class Event_Cryptodira_Catalog extends Event_Base
{

	/* @var $DB DBObject */

	const ERROR_CLASS = 'Event_Start_Error';
	const ROOM = 'cryptodira/';
	private $step = 12;


	public function __construct()
	{
		parent::__construct();

		$this->mainTemplate=FG_EVENT_DEFAULT_TEMPLATE;

		//language for smarty templates
		$catalog_lang = FgLanguage::getInstance()->getLanguage('crypto_catalog', $this->fgLang->getAct());
		FgSmarty::getInstance()->assign('catalog_lang',$catalog_lang);


		$this->kataloglist=FgUtill::getWfKategory(FgVars::WV_GROUP_KATEGORY, FgLanguage::getInstance()->getAct(),true);
		FgSmarty::getInstance()->assign('kataloglist',$this->kataloglist);
		
		$this->softtype=FgUtill::getWfKategory(FgVars::WV_GROUP_PAYTYPE, FgLanguage::getInstance()->getAct(),true);
		FgSmarty::getInstance()->assign('softtype',$this->softtype);


	}


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{
		//header("Content-type","text/xml");

		switch($this->action)
		{
			case 'show':
				return $this->actionCatalogItemShow();
				break;
			case 'favorite':
				return $this->actionFavoriteList();
				break;
			default:
				return $this->actionCatalogList();
		}


		return false;
	}




	private function actionCatalogItemShow($nid=null)
	{
		if($nid)
		$id=$nid;
		else
		$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));

		if($id)
		{
			
			$this->loader->js(FgVars::JS_LINK,FG_STYLESPACE_DEF.'/js/jquery.lightbox-0.5.min.js',2000);
			$this->loader->css(FgVars::CSS_LINK,FG_STYLESPACE_DEF.'/css/jquery.lightbox-0.5.css',2000);
			
			
			
			$item=$this->DB->getAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_SOFT)." where ID=".$id);

			if(!isset($item['ID']))
			return $this->getErrorEvent();


			$item_lng=$this->DB->getAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_SOFT_LANG)." where LANG='".
			FgLanguage::getInstance()->getAct()."' and PARENT_ID=".$id);

			$sql="select A.ID,A.LNAME,B.INFO,C.UDATE,C.VNAME,C.ID as VID from (".
			FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE)." as A) left join (".
			FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE_LANG)." as B) on (A.ID=B.PARENT_ID and B.LANG='".
			FgLanguage::getInstance()->getAct()."')"." left join (".
			FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_VERSION)." as C) on (A.CRYPTO_VERSION_ID=C.ID)".
				" where A.CRYPTO_CATALOG_ID=".$id." order by A.LNAME";

			$in_favorite=false;
			$mysoft=array();

			if($this->actUser->isLogin())
			{
				$in_favorite = $this->DB->getOne("select 1 from ".FgVars::getTablePerType(FgVars::FG_TYPE_FAVORITE).
				" where FG_USER_ID=".$this->actUser->getUserID()." and OBJECT_TYPE=12300 and OBJECT_ID=".$id);	

				$mysoft = $this->DB->getKeyVal("select distinct(FG_CRYPTO_LINE_ID),1 from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_MYSOFT).
				" where FG_USER_ID=".$this->actUser->getUserID()." and FG_CRYPTO_CATALOG_ID=".$id);
					
			}


			
			$images=$this->DB->getAllAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_GALERY).
				" where FG_CRYPTO_CATALOG_ID=".$id);
			
			$comments = $this->DB->getAllAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_COMMENT).
				" where FG_CRYPTO_CATALOG_ID=".$id." and OK=1 order by CDATE desc limit 5");
	
		
		

			$lines=$this->DB->getAllAssoc($sql);

			$item['lines']=$lines;

			$smarty = FgSmarty::getInstance();
			$smarty->assign('images',$images);
			$smarty->assign('comments',$comments);
			$smarty->assign('infavorite',$in_favorite?true:false);
			$smarty->assign('item',$item);
			$smarty->assign('mysoft',$mysoft);
			$smarty->assign('item_lng',$item_lng);

			$this->showContent = $smarty->fetch(self::ROOM.'Event_Catalog_Item.tpl');
		}
		else
		{
			return $this->getErrorEvent();
		}

		return true;
	}


	private function actionCatalogList()
	{
		$offset=0;
		$id=0;

		if(is_numeric($this->action))
		{
			$id=$this->action;
		}
		else if(!$this->action!='select') 
		{
			
			$id=$this->DB->getOne("select ID from ".FgVars::getTablePerType(FgVars::FG_TYPE_WF).
				" where wtype=".FgVars::WV_GROUP_KATEGORY." and name='".$this->action."'");
		}
	
		$smarty = FgSmarty::getInstance();
		
		if($id)
		{
			$items = $this->DB->getAllAssoc("select A.* from (fg_crypto_catalog A) where WF_KATEGORY=".$id." order by ORD desc, RATING_USER desc limit ".
			$offset.", ".$this->step);
			
			$smarty->assign('catalog_title',$this->kataloglist[$id]);

		}
		else if( $this->action=='select' && FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('type', $_REQUEST)) )
		{
			$items = $this->DB->getAllAssoc("select A.* from (fg_crypto_catalog A) where WF_PAYTYPE=".$_REQUEST['type']." order by ORD desc, RATING_USER desc limit ".
			$offset.", ".$this->step);
			
			$smarty->assign('catalog_title',$this->softtype[$_REQUEST['type']]);
		}
		else
		{
			$items = $this->DB->getAllAssoc("select A.* from (fg_crypto_catalog A) order by A.ORD desc, A.RATING_USER desc limit ".$offset.", ".$this->step);
			$smarty->assign('showstart',true);
		}

		

		$smarty->assign('items',$items);

		$favoritelist=array();
		$mysoft = array();
		
		if($this->actUser->isLogin())
		{
			$favoritelist = $this->DB->getKeyVal("select OBJECT_ID,1 from ".FgVars::getTablePerType(FgVars::FG_TYPE_FAVORITE).
				" where FG_USER_ID=".$this->actUser->getUserID()." and OBJECT_TYPE=12300");
			
			$mysoft = $this->DB->getKeyVal("select distinct(FG_CRYPTO_CATALOG_ID),1 from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_MYSOFT).
				" where FG_USER_ID=".$this->actUser->getUserID());
		}

			
		$smarty->assign('favoritelist',$favoritelist);
		$smarty->assign('mysoft',$mysoft);

		$this->showContent = $smarty->fetch(self::ROOM.'Event_Catalog_List.tpl');

		return true;

	}


	private function actionFavoriteList()
	{
		$items=array();

		if($this->actUser->isLogin())
		{
			$items = $this->DB->getAllAssoc("select A.* from (".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_SOFT).
			" A, ".FgVars::getTablePerType(FgVars::FG_TYPE_FAVORITE). " B) where B.FG_USER_ID=".
			$this->actUser->getUserID()." and B.OBJECT_TYPE=12300 and A.ID=B.OBJECT_ID order by A.ORD desc, A.RATING_USER desc");
		}

			
		$smarty = FgSmarty::getInstance();

		$smarty->assign('items',$items);
		
		$mysoft=array();
		
	    if($this->actUser->isLogin())
		{
			$mysoft = $this->DB->getKeyVal("select distinct(FG_CRYPTO_CATALOG_ID),1 from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_MYSOFT).
				" where FG_USER_ID=".$this->actUser->getUserID());				
		}
		
		$smarty->assign('mysoft',$mysoft);

		$smarty->assign('catalog_title','Favorite');


		$this->showContent = $smarty->fetch(self::ROOM.'Event_Catalog_Favorite_List.tpl');

		return true;

	}

	





	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::hasAccess()
	 */
	public function hasAccess()
	{
		return true;
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
