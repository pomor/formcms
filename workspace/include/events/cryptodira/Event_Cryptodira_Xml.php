<?php
class Event_Cryptodira_Xml extends Event_Base
{

	/*@var $DB DBObject */
	const ERROR_CLASS = 'Event_Start_Error';
	private $cryptoFunction = null;/* @var $cryptoFunction Cryptodira */

	
	public function __construct()
	{
		parent::__construct();
		$this->bStream=true;
		
		$this->cryptoFunction = FgLoader::loadObject('Cryptodira','collection');	
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
			case 'reg':
				$this->actionRegistration();
				break;
			case 'auth':
				$this->actionAuthorisation();
				break;
			case 'addDevice':
				$this->actionAddDevice();
				break;
			case 'code':
				$this->actionCode();
				break;
			case 'close':
				$this->actionClose();
				break;
			case 'check':
				$this->actionCheck();
				break;
			case 'checkApp':
				$this->actionCheckApp();
				break;
			case 'updateApp':
				 $this->actionUpdateApp();
				break;
			default:
				return $this->getErrorEvent();
		}


		return false;
	}
	
	
	
	private function actionUpdateApp()
	{
		if($this->actUser->isLogin()) 
		{			
						
			$xml = FgUtill::getVal('xml', $_REQUEST);
			
		}
		
	}
	

	/**
	 * synchronise cryptodira user software list
	 * <code>
	 * Request:
	 * <xml>
	 * 	<version uid="A4DC4217DC739C0AF73ADD30820F9CB14373AC377"/>
	 * </xml>
	 * 
	 * Response:
	 * <xml>
	 * 		<version uid="A4DC4217DC739C0AF73ADD30820F9CB14373AC377" type="update">
	 * 			<item uid="A4DC4217DC739C0AF73ADD30820F9CB14373AC3F2" url="http://google.de" softname="Total Commander" linename="Version 64" versionname="3.6"/>
	 * 		</version>
	 * 		<version type="install">
	 * 			<item uid="A66266B2A010ADE74F4C6BC971E1F3F63F8B02977" url="http://google.de" softname="Total Commander" linename="Version 32" versionname="3.55"/>
	 * 		</version> 		
	 *</xml>
	 * </code>
	 * @param xml  
	 * @return xml 
	 */
	private function actionCheckApp()
	{
		
		if($this->actUser->isLogin()) 
		{			
						
			$xml = FgUtill::getVal('xml', $_REQUEST);
			
			if(!$xml)return false;		
			
			
			
			$inparam = simplexml_load_string($xml);		
			$out = new SimpleXMLElement('<xml/>');

						
			$uids = array();			
			
            foreach($inparam->version as $version)
            {
            	$uid = FgUtill::checkVar(MSK_SAFESTRING, (string)$version->attributes()->uid);
            	if($uid)
            		$uids[$uid]=array();
            }
            
           
            
            $extern = $this->DB->getAllAssoc(
            	"SELECT A.ID,A.UNID as OLDUNID,B.NAME,C.LNAME,D.VNAME,D.UNID,C.ID as LID, D.ID as VID, D.URL".
            	" from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_VERSION)." A".
            	" left join (".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE)." C) on (C.ID=A.`CRYPTO_LINE_ID`)".
            	" left join (".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_SOFT)." B) on (B.ID=A.`CRYPTO_CATALOG_ID`)".				
				" left join (".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_VERSION)." D) on (D.ID=C.`CRYPTO_VERSION_ID`)".
            	" where A.UNID in (".implode(',',array_map(function($val){return "'".$val."'";}, array_keys($uids))).")",'LID');  
         
            
            $inserted_lid=array();
            
            foreach($extern as $k=>$v)
            {
            	$inserted_lid[$k]=1;
            	
            	if($v['ID']!=$v['VID'])
            	{
            		   $new_version = $out->addChild('version');
			            $new_version->addAttribute('type','update');   
			            $new_version->addAttribute('uid',$v['OLDUNID']);            
			            $item = $new_version->addChild('item');				
						$item->addAttribute('uid',$v['UNID']);
						$item->addAttribute('url',$v['URL']);
						$item->addAttribute('softname',$v['NAME']);
						$item->addAttribute('linename',$v['LNAME']);
						$item->addAttribute('versionname',$v['VNAME']);
            	}
            }
            
            $mysoft = $this->DB->getAllAssoc("SELECT B.NAME,C.LNAME,D.VNAME,D.UNID,C.ID as LID, D.ID as VID, D.URL".
				" FROM (".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_MYSOFT)." A)". 
				" left join (".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_SOFT)." B) on (B.ID=A.`FG_CRYPTO_CATALOG_ID`)".
				" left join (".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_LINE)." C) on (C.ID=A.`FG_CRYPTO_LINE_ID`)".
				" left join (".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_VERSION)." D) on (D.ID=A.`FG_CRYPTO_VERSION_ID`)".				
				" where A.FG_USER_ID=".$this->actUser->getUserID(),'LID');		
            
            foreach($mysoft as $k=>$v)
            {
            	if(!isset($inserted_lid[$k]))
            	{
            		$new_version = $out->addChild('version');
			            $new_version->addAttribute('type','install');			                   
			            $item = $new_version->addChild('item');				
						$item->addAttribute('uid',$v['UNID']);
						$item->addAttribute('url',$v['URL']);
						$item->addAttribute('softname',$v['NAME']);
						$item->addAttribute('linename',$v['LNAME']);
						$item->addAttribute('versionname',$v['VNAME']);
            	}
            	else 
            	{
            		//TODO: delete from mysoft if soft is not available?
            	}
            }            
               
            
            print $out->asXML();
           
					
		}
		else {
			$this->printMessage(-3,'error',"ERROR");

		}
		
		return true;
	}
	
	
	/**
	 *
	 * check session for act user
	 */
	private function actionCheck()
	{
			$this->printMessage(1,'success',"OK");

	}


	private function actionClose()
	{

		if($this->actUser->isLogin()){
			$this->session->actUser(false);
			$this->actUser->clearSession();
			$this->printMessage(1,'success',"OK");

		}
		else {
			$this->printMessage(-3,'error',"ERROR");

		}

	}


	private function actionCode()
	{
		if($this->actUser->isLogin())
		{
				$this->printMessage(1,'success',"OK");

		}
		else
		{
			$this->printMessage(-3,'error',"ERROR");
		}

	}


	/**
	 * user autorisation
	 * <code>
	 * $pin = FgUtill::checkVar(MSK_ZAHL,FgUtill::getVal('pin', $_REQUEST),5);
	 * $sn = FgUtill::checkVar(MSK_SAFESTRING,FgUtill::getVal('sn', $_REQUEST));
	 * $personalKey=FgUtill::checkVar(MSK_SAFESTRING,FgUtill::getVal('pk', $_REQUEST));
	 * $dk = FgUtill::checkVar(MSK_SAFESTRING, FgUtill::getVal('dk', $_REQUEST));
	 * </code>
	 */
	private function actionAuthorisation()
	{
		$pin = FgUtill::checkVar(MSK_ZAHL,FgUtill::getVal('pin', $_REQUEST),5);
		$sn = FgUtill::checkVar(MSK_SAFESTRING,FgUtill::getVal('sn', $_REQUEST));
		$personalKey=FgUtill::checkVar(MSK_SAFESTRING,FgUtill::getVal('pk', $_REQUEST));
		$dk = FgUtill::checkVar(MSK_SAFESTRING, FgUtill::getVal('dk', $_REQUEST));


		if( !is_null($pin) && !is_null($sn) && !is_null($personalKey) && !is_null($dk))
		{

			$cryptoKey=crypt(CRYPTO_SERVER_KEY.$personalKey.$sn,$pin);

			// get device id
			list($did,$chkey,$valid)=$this->DB->getArray("select ID,IDENT,VALID from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_DEVICE)." where DK='".$dk."'");


			// get crypto id
			$cid=$this->DB->getOne("select ID from ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_USER)." where USERKEY='".$this->DB->safe($personalKey)."'");


			$userIDd = FgUtill::getFgLinksParentId($did, FgVars::FG_TYPE_CRYPTODIRA_DEVICE, FgVars::FG_TYPE_USER);
			$userID = FgUtill::getFgLinksParentId($cid, FgVars::FG_TYPE_CRYPTODIRA_USER, FgVars::FG_TYPE_USER);



			if($valid <3 && $userID>0 && $userIDd==$userID && $cryptoKey==$chkey)
			{
				$this->actUser->authUser($userIDd);
				FgSession::getInstance()->CRYPTO_HAUPT_TEMPLATE='cryptodira/index.tpl';

				$this->DB->update(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_DEVICE),array('VALID'=>0),false,'ID='.$did);

				$this->session->FG_CRYPTO_USER_PIN=$pin;
				$this->session->FG_CRYPTO_USER_PK=$personalKey;

				$this->printMessage(1,'success',session_id());
			}
			else
			{

				if($did)
				{
					$this->DB->query("update ".FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_DEVICE)." set VALID=VALID+1 where ID=".$did);
				}

				if($valid>2)
				{
					$this->printMessage(-4,'error',"Device is blocked");
				}
				else
				{
					$this->printMessage(-3,'error',"User not found");
				}


			}


		}
		else
		{
			$this->printMessage(-3,'error',"Input Error");
		}


	}


	private function actionRegistration()
	{
		$email=FgUtill::getVal('email', $_REQUEST);
		$sn = FgUtill::getVal('sn', $_REQUEST);
		$dk = FgUtill::checkVar(MSK_SAFESTRING, FgUtill::getVal('dk', $_REQUEST));


		if(is_null($dk))
		{
			$this->printMessage(-10,'error',"DiskID error");
			return;
		}


		// check email
		if(!$this->checkEmail($email))
		{
			$this->printMessage(-1,'error',"Email error! Please take another Email.".$email);
			return;
		}

		//check Device SN
		if(!FgUtill::checkVar(MSK_CUSTOM, $sn,null,"/^[a-zA-z0-9_\/]+/"))
		{
			$this->printMessage(-2,'error',"SN error! Serial number format error.");
			return;
		}

		$pin = rand(1000, 9999);
		$personalKey=sha1(CRYPTO_SERVER_KEY.$email);
		$cryptoKey=$this->cryptoFunction->createCryptoKey($personalKey, $sn, $pin);

		// get language element for cryptomodul
		$sendMail = $this->fgLang->getLanguageItem('cryptodira',FG_LANG_DEFAULT,'pinMail');

		FgUtill::sendMail("noreplay@cryptodira.com", $email, FgUtill::parseTemplate($sendMail, array('PIN'=>$pin)));


		$pass= rand(1000000,10000000);
		// create user and add to group
		$userID=$this->actUser->createUser($email,$pass);

		$this->actUser->addUserToGroup($userID,2);


		// add device to device list
		$this->addDevice($userID, $cryptoKey, $dk);

		// add crypto user
		$this->addCryptoUser($userID, $personalKey);

		//save tempor user pin and keyword
		$this->addTempPin($userID,$pin,$pass);


		$this->printMessage(1,'success',$personalKey);

	}



	//dobavlenie novogo ustrojstva
	private function actionAddDevice()
	{



		$sn = FgUtill::getVal('sn', $_REQUEST);
		$pin = FgUtill::getVal('pin', $_REQUEST);
		$dk = FgUtill::checkVar(MSK_SAFESTRING, FgUtill::getVal('dk', $_REQUEST));

		if($this->actUser->isLogin())
		{

			if($this->session->FG_CRYPTO_USER_PK && $pin==$this->session->FG_CRYPTO_USER_PIN)
			{
				$userID=$this->actUser->getUserID();
				
				$cryptoKey=$this->cryptoFunction->createCryptoKey($this->session->FG_CRYPTO_USER_PK, $sn, $pin);
				$freeCode=$this->addDevice($userID, $cryptoKey, $dk, 0);
				$this->printMessage(1,'success',$this->session->FG_CRYPTO_USER_PK);
				
				$userinfo=$this->actUser->getUserInfo($userID);

				// get language elements for cryptomodul
				$sendMail = $this->fgLang->getLanguageItem('cryptodira',FG_LANG_DEFAULT,'CryptoActiveDevice');
				
				FgUtill::sendMail("noreplay@cryptodira.com", $userinfo['Login'],
					FgUtill::parseTemplate($sendMail, array('CODE'=>$freeCode)));
			}
			else
			{
				$this->printMessage(-11,'error',"Isn't Crypto User");
			}

		}
		else
		{

			$email=FgUtill::checkVar(MSK_EMAIL, FgUtill::getVal('email', $_REQUEST));

			if(is_null($email))
			{
				#$userID=
			}

			$personalKey=$this->cryptoFunction->createPersonalKey($email);
			$cryptoKey = $this->cryptoFunction->createCryptoKey($personalKey, $sn, $pin);


			// get language elements for cryptomodul
			$sendMail = $this->fgLang->getLanguageItem('cryptodira',FG_LANG_DEFAULT,'CryptoActiveDevice');
				
			FgUtill::sendMail("noreplay@cryptodira.com", $email,
					FgUtill::parseTemplate($sendMail, array('CODE'=>$freeCode)));
					
			$this->printMessage(1,'success',$personalKey);

		}



		//pin, email, sn

		// todo

	}




	private function addCryptoUser($userID,$userkey)
	{
		$objid=$this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_USER),array(
			'USERKEY'=>$userkey,
			'CREATED'=>'now()'
			),false,2,1);

			FgUtill::addFgLinks($userID, FgVars::FG_TYPE_USER, $objid, FgVars::FG_TYPE_CRYPTODIRA_USER);
	}


/**
 * insert crypto device
 *
 * @param int $userID
 * @param string $cryptokey
 * @param string $dk
 * @param boolean $active
 * @return string code for device activate link
 */
	private function addDevice($userID,$cryptokey,$dk,$active=true)
	{
		$freecode=uniqid('UID',true);

		$objid=$this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_DEVICE),array(
			'IDENT'=>$cryptokey,
			'DK'=>$dk,
			'ACTIVE'=>$active?1:0,
			'CREATED'=>'now()',
			'CODE'=>$freecode
			),false,2,1);

			FgUtill::addFgLinks($userID, FgVars::FG_TYPE_USER, $objid, FgVars::FG_TYPE_CRYPTODIRA_DEVICE);

			return $freecode;
	}


	private function addTempPin($userID,$pin,$kwd)
	{
		$objid=$this->DB->insert(FgVars::getTablePerType(FgVars::FG_TYPE_CRYPTODIRA_PIN),array(
			'PIN'=>$pin,
			'KEYW'=>$kwd
			),false,2,1);

			FgUtill::addFgLinks($userID, FgVars::FG_TYPE_USER, $objid, FgVars::FG_TYPE_CRYPTODIRA_PIN);
	}


	private function printMessage($mid,$type,$message)
	{

print <<<XML
<xml>
<message type="{$type}" mid="{$mid}"><![CDATA[{$message}]]></message>
</xml>
XML;
	}

// message,user,
	private function printMessageBlock($block)
	{

		print "<xml>\n";

		foreach($block as $tmp)
		{

			printf('<%s type="%s" mid="%s"><![CDATA[%s]]></%s>\n',$tmp['mtype'],$tmp['type'],$tmp['mid'],$tmp['msg'],$tmp['mtype']);

		}

		print "</xml>\n";
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

	

}
