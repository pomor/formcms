<?php
class Event_Base implements iEvent
{
	
	protected $actUser;/* @var $actUser FgUser */
	
	protected $DB;/* @var $DB DBObject */
	
	protected $loader;/* @var $loader FgLoader */
	
	protected $session;/* @var $session FgSession */
	
	protected $fgLang;/* @var $fgLang FgLanguage */
	/**
	 * Controller Action from $_REQUEST['act']
	 * 
	 * @var String
	 */
	protected $action;
	
	
	// default vars
	protected $bStream=false;
	protected $mainTemplate=null;
	

	public $showContent=''; // wird in template angezeigt

	public function __construct()
	{
		$this->loader = FgLoader::getInstance();
		$this->session = FgSession::getInstance();
		$this->actUser = $this->session->actUser();
		$this->fgLang = $this->session->actLang();
		$this->DB = $this->loader->getObject('DBObject');
		$this->action = FgUtill::checkVar(MSK_SAFESTRING, FgUtill::getVal('act', $_REQUEST));
	}

	public function run()
	{

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
		return FgLoader::getInstance()->loadObject('Event_Start_Error',FG_EVENTS);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getMainTemplate()
	 */
	public function getMainTemplate()
	{		
		return $this->mainTemplate;
	}	
	

	public function isStream()
	{
		return $this->bStream;
	}

}