<?php
class Mod_Base implements iMod
{
	/*@var $actUser FgUser*/
	protected $actUser;
	/*@var $DB DBObject*/
	protected $DB;
	/*@var $loader FgLoader*/
	protected $loader;
	/*@var $session FgSession*/
	protected $session;	
	/*@var $fgLang FgLanguage*/
	protected $fgLang;
	
	public function __construct()
	{		
		$this->loader = FgLoader::getInstance();		
		$this->session = FgSession::getInstance();
		$this->actUser = $this->session->actUser;
		$this->fgLang = $this->session->fgLang;
		$this->DB = $this->loader->getObject('DBObject');
	}

	public function run()
	{
		
	}
	
}