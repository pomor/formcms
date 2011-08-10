<?php
require_once 'extralib/wideimage/WideImage.php';

class Event_Cryptodira_Galerie_Admin extends Event_Base
{

	/* @var $DB DBObject */

	const ERROR_CLASS = 'Event_Start_Error';
	const ROOM = 'cryptodira/';
	const GALERY_PATH='/content/images/galery/';
	private $screen_path='';
	
	
	public function __construct()
	{
		parent::__construct();
		$this->screen_path=self::GALERY_PATH.$this->session->CRYPTO_CATALOG_SOFT_ID.'/';
	}	
	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{		
		
		
		switch ($this->action)
		{
			case 'list':
				return $this->actionGalerieList();
			case 'add':
				return $this->actionAdd();
			case 'del':
				return $this->actionDelete();
				
		}
		return false;
	}
	
	
	private function actionDelete()
	{
		$result=array(
		'STATUS'=>'OK',
		'DATA'=>array()
		);
		
		$id=FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));
		
		if($id)
		{
			$info = $this->DB->getAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_GALERY)." where ID=".$id);
			if(isset($info['ID']))
			{
				$this->DB->query("delete from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_GALERY)." where ID=".$id);
				
	      		$thumbs_path=$_SERVER['DOCUMENT_ROOT'].$this->screen_path.'thumbs/'.$info['PATH'];
	      		unlink($thumbs_path);
	      		
	      		$image_path=$_SERVER['DOCUMENT_ROOT'].$this->screen_path.$info['PATH'];
	      		unlink($image_path);
			}
			else 
			{
				$result['STATUS']='ERROR: file not found';
			}
		}
		else 
		{			
			$result['STATUS']='ERROR';
		}
		
		print json_encode($result);
		
		return false;
	
	}
	
	private function actionAdd(){	
		
	$result=array(
		'STATUS'=>'OK',
		'DATA'=>array()
	);	
	
	
	if(!is_dir($_SERVER['DOCUMENT_ROOT'].$this->screen_path))
	{		
		mkdir($_SERVER['DOCUMENT_ROOT'].$this->screen_path.'thumbs/',0777,true);
	}
	
		
	    if($_FILES['Filedata']['error'] == UPLOAD_ERR_OK){
	
	      $file_name=basename($_FILES['Filedata']['name']);	    
	
	      $file_name=preg_replace("/[^a-zA-Z0-9_\-.]/","",$file_name);
	
	      $thumbs_path=$_SERVER['DOCUMENT_ROOT'].$this->screen_path.'thumbs/'.$file_name;
	      $image_path=$_SERVER['DOCUMENT_ROOT'].$this->screen_path.$file_name;
	
	      move_uploaded_file( $_FILES["Filedata"]["tmp_name"], $image_path ) or die("Problems with upload");
	
	      $images_web= WideImage::load($image_path);
	      
	      $h=$images_web->getHeight();
	      $w=$images_web->getWidth();
	      
	      $maxsize=0;
	      if($h>$w)
	      {
	      	$maxsize=$w;	
	      }
	      else 
	      {
	      	$maxsize=$h;
	      } 

	      $images_web->crop('center','center',$maxsize,$maxsize)->resize(200,200)->saveToFile($thumbs_path);
	      
	      
	      $this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_GALERY),array(
	      	'FG_CRYPTO_CATALOG_ID'=>$this->session->CRYPTO_CATALOG_SOFT_ID,
	      	'FG_USER'=>$this->actUser->getUserID(),
	      	'PATH'=>$file_name
	      ),false,2,1); 

	      $result['DATA']=array(
	      	'IMAGE'=>$this->screen_path.$file_name,
	      	'THUMB'=>$this->screen_path.'thumbs/'.$file_name
	      );
	
	    }
	 
	  
	  print json_encode($result);
	  
	  return false;
	
	}

	
	public function actionGalerieList()
	{		
		$this->loader->js(FgVars::JS_LINK,FG_STYLESPACE_DEF.'/js/jquery.html5-fileupload.js',1000);
		$images = array();
		$smarty=FgSmarty::getInstance();
		if($this->session->CRYPTO_CATALOG_SOFT_ID)
		{
			$images=$this->DB->getAllAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_GALERY).
				" where FG_CRYPTO_CATALOG_ID=".$this->session->CRYPTO_CATALOG_SOFT_ID);
		}
		
		$smarty->assign('images',$images);
		
		print $smarty->fetch(self::ROOM.'Event_Cryptodira_Catalog_Admin_Galerie.tpl');	
		
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
			if($this->session->CRYPTO_CATALOG_SOFT_ID)
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getErrorEvent()
	 */
	public function getErrorEvent()
	{
		return FgLoader::getInstance()->loadObject(self::ERROR_CLASS,FG_EVENTS);
	}
	
}

