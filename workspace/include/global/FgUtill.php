<?php

class FgUtill
{


	/**
	 * get value, if $key not existed, empty string
	 *
	 * @param string $key
	 * @param array,object $ar
	 */
	public static function getVal($key,$ar)
	{
		if(is_array($ar) && array_key_exists($key, $ar))
		{
			return $ar[$key];
		}
		elseif(is_object($ar) && isset($ar->$key))
		{
			return $ar->$key;
		}

		return '';
	}

	/**
	 * check format variable
	 *
	 * @param array name=>check_type $in_arr
	 * @return array errors
	 */
	public static function checkVars($in_arr)
	{
		$res=array();
		foreach($in_arr as $k=>$v)
		{
			if(is_null(self::checkVar($v, $k)))
						$res[$k]=true;
		}

		return (count($res)>0?$res:null);
	}


	/**
	 * check format and crop the variable
	 *
	 * @param $check_type int
	 * @param $vname
	 * @param $length int
	 * @param $maske string or null
	 * @return mixed or null
	 */
	public static function checkVar($check_type,$vname,$length=0,$maske=null)
	{
		$vname = trim($vname);

		if($length>0 && strlen($vname)>$length)
				$vname = substr($vname,0,$length);

		$check_status = false;
		switch ($check_type)
		{
			case MSK_ZAHL:
				$check_status = ctype_digit($vname);
				break;

			case MSK_FLOAT:
				if(($check_status = is_numeric($vname))!=false)
				{
					$vname = floatval($vname);
				}
				break;

			case MSK_INT:
				if(($check_status = preg_match("/^[+-]?[0-9]+$/", $vname))!=false)
				{
					$vname = intval($vname);
				}
				break;

			case MSK_EMAIL:
				$check_status = filter_var($vname,FILTER_VALIDATE_EMAIL);
				break;

			case MSK_LOGIN:
				$check_status = preg_match("/^[^'\"]+$/",$vname);
				break;

			case MSK_PASSWORD:
				$check_status = preg_match("/^[^'\"]+$/",$vname);
				break;


			case MSK_DATE:
				if(preg_match("/^([0-9]{1,4})[^0-9]+([0-9]{1,2})[^0-9]+([0-9]{1,4})$/",$vname,$found))
				{
					if(strlen($found[1])==4)
					{
						$vname = sprintf("%02d.%02d.%04d",$found[3],$found[2],$found[1]);
					}
					else
					{
						$vname = sprintf("%02d.%02d.%04d",$found[1],$found[2],$found[3]);
					}
					$check_status=true;
				}

				break;

			case MSK_SAFESTRING:
				$check_status = preg_match("/^[a-zA-Z0-9-_.]*$/",$vname);
				break;

			case MSK_CUSTOM:
				if($maske != null)
					$check_status = preg_match($maske,$vname);
				else
					$check_status = true;
				break;
		}


		return ($check_status?$vname:null);
	}

	/**
	 * Get file list
	 *
	 * @param $path	Directory path
	 * @param $ext	extention file filter
	 *
	 * @return array file list
	 */
	public static function getFileList($path,$ext='.*')
	{
		$arRet=array();

		if(is_dir($path))
		{
			$dir=opendir($path);
			while(($file=readdir($dir))!=false){
				if(preg_match("/".$ext."$/",$file)){
					$arRet[]=$file;
				}
			}
			closedir($dir);
		}

		return $arRet;
	}

	/**
	 * sort hash array per value
	 *
	 * @param array $ar
	 */
	public static function sortVal(&$ar)
	{
		uasort($ar,function ($a,$b){
			if ($a == $b)  return 0;

		    return ($a < $b) ? -1 : 1;

		});
	}


	public static function class_has_interface($obj,$iname)
	{
		$interfaces = class_implements($obj);
		return array_key_exists($iname,$interfaces);
	}

	/**
	 * objects links
	 *
	 * @param int $parent
	 * @param int $parentType
	 * @param int $kind
	 * @param int $kindType
	 */
	public static function addFgLinks($parent,$parentType,$kind,$kindType)
	{
		/* @var $DB DBObject */
		$DB = FgLoader::getInstance()->getObject('DBObject', 'class');

		$arIns=array(
			'PARENTID'=>$parent,
			'PARENTTYPE'=>$parentType,
			'KINDID'=>$kind,
			'KINDTYPE'=>$kindType,
			'CREATED'=>'now()',
			'UPDATED'=>'now()'
		);

		return $DB->insert('fg_links',$arIns,false,2,true);
	}

	/**
	 * make permissions
	 *
	 * @param int $object
	 * @param int $objectType
	 * @param string $name
	 * @param int $value
	 */
	public static function addFgPerms($object,$objectType,$name,$value)
	{
		/* @var $DB DBObject */
		$DB = FgLoader::getInstance()->getObject('DBObject', 'class');

		$arIns=array(
			'OBJECTID'=>$object,
			'OBJECTTYPE'=>$objectType,
			'NAME'=>$name,
			'VAL'=>$value,
			'CREATED'=>'now()',
			'UPDATED'=>'now()'
		);

		return $DB->insert('fg_perm',$arIns,false,2,true);
	}


	public static function getFgPerms($id,$objectType)
	{
		$DB = FgLoader::getInstance()->getObject('DBObject', 'class');
		$arPerm=$DB->getKeyVal("select NAME,VAL from ".FgVars::getTablePerType(FgVars::FG_TYPE_PERMISSIONS).
			' where OBJECTID='.$id.' and OBJECTTYPE='.$objectType);

		return $arPerm;
	}

	public static function getFgLinksParentId($kindid,$kindtype,$parenttype)
	{
		/* @var $DB DBObject */
		$DB = FgLoader::getInstance()->getObject('DBObject', 'class');
		return $DB->getOne("select PARENTID from fg_links where KINDID=".$kindid." and KINDTYPE=".$kindtype." and PARENTTYPE=".$parenttype);
	}


	public static function deleteItem($id,$fgtype)
	{
		$DB = FgLoader::getInstance()->getObject('DBObject', 'class');

		// delete links to content
			$DB->query("delete from fg_links where PARENTID=".$id
				." and PARENTTYPE=".$fgtype);

			// delete links to parent objects
			$DB->query("delete from fg_links where KINDID=".$id
				." and KINDTYPE=".$fgtype);

			// delete permissions
			$DB->query("delete from fg_perm where OBJECTID=".$id
				." and OBJECTTYPE=".$fgtype);

	}


	public static function getMenu($id=1)
	{

		//check input
		if(is_null(FgUtill::checkVar(MSK_SAFESTRING, $id)))
		{
			$id=1;
		}

		$actEvent = FgConfig::getInstance()->detectEvent();

		/* @var $actUser FgUser */
		$actUser = FgSession::getInstance()->actUser();

		if(is_null($actUser))
		{
			$actUser = new FgUser();
			FgSession::getInstance()->actUser($actUser);
		}

		$menuList=array();
		$menuPermissions=array();

		$DB=FgLoader::getInstance()->getObject('DBObject');/* @var $DB DBObject */
		$actLang=FgLanguage::getInstance()->getAct();
		
		if(is_numeric($id))
		{
			// get menu per ID
			$menuList =$DB
					->getAllAssoc("select A.*,H.NAME as MNAME from (fg_menu A, fg_links B) left join (fg_menu_lang H) on (A.ID=H.PARENT_ID and H.LANG='$actLang') where B.PARENTID=$id and B.PARENTTYPE=".
						FgVars::FG_TYPE_MENU_GROUP." and B.KINDTYPE=".FgVars::FG_TYPE_MENU_ITEM."  and A.ID=B.KINDID order by A.Ord asc");


			$menuPermissions = $DB
					->getAllAssoc("select P.OBJECTID, P.NAME, P.VAL  from (fg_menu A, fg_links B) left join (fg_perm P) ON (P.OBJECTID=A.ID and P.OBJECTTYPE=".
						FgVars::FG_TYPE_MENU_ITEM.") where B.PARENTID=$id and B.PARENTTYPE=".
						FgVars::FG_TYPE_MENU_GROUP." and B.KINDTYPE=".FgVars::FG_TYPE_MENU_ITEM."  and A.ID=B.KINDID ");
		}
		else
		{
			// get menu per name
			$menuList = $DB
					->getAllAssoc("select A.*,H.NAME as MNAME from (fg_menu A, fg_menu_group AG, fg_links B) left join (fg_menu_lang H) on (A.ID=H.PARENT_ID and H.LANG='$actLang') where AG.NAME='".$id."' and B.PARENTID=AG.ID and B.PARENTTYPE=".
						FgVars::FG_TYPE_MENU_GROUP." and B.KINDTYPE=".FgVars::FG_TYPE_MENU_ITEM."  and A.ID=B.KINDID order by A.Ord asc");


			$menuPermissions = $DB
					->getAllAssoc("select P.OBJECTID, P.NAME, P.VAL from (fg_menu A, fg_menu_group AG, fg_links B) ".
						"left join (fg_perm P) ON (P.OBJECTID=A.ID and P.OBJECTTYPE=".
						FgVars::FG_TYPE_MENU_ITEM.") where AG.NAME='".$id."' and B.PARENTID=AG.ID and B.PARENTTYPE=".
						FgVars::FG_TYPE_MENU_GROUP." and B.KINDTYPE=".FgVars::FG_TYPE_MENU_ITEM."  and A.ID=B.KINDID");

		}


		$menu=array();

		$last_level=0;
		$isParent=false;
		$counter=0;

		foreach($menuList as $tmp)
		{
			$arRechte = array();


			foreach($menuPermissions as $tmp1)
			{
				if($tmp1['OBJECTID']!= $tmp['ID'] )continue;
				$arRechte[$tmp1['NAME']] = $tmp1['VAL'];
			}

			if($actUser->checkPermission($arRechte))
			{
				$event=explode(',', $tmp['Event']);
				 $isParent=false;

				if(isset($menuList[$counter+1]) && $menuList[$counter]['Lvl']<$menuList[$counter+1]['Lvl']){
				    $isParent=true;
				 }

				$menu[] = array(
						'url'=>$tmp['Url']?$tmp['Url']:'javascript: return false;',
						'target'=>$tmp['Target'],
						'text'=>($tmp['MNAME']?$tmp['MNAME']:$tmp['Name']),
						'active'=>in_array($actEvent, $event),
						'evt'=>$event,
						'lvl'=>$tmp['Lvl'],
						'parent'=>$isParent
				);

				$last_level=$tmp['Lvl'];

			}

			$counter++;

		}

		$last_active=false;
		$last_active_lvl=false;

		for($i=count($menu)-1; $i>=0; $i--)
		{
			if($menu[$i]['active'] && $menu[$i]['lvl']>0)
			{
				$last_active=true;
				$last_active_lvl=$menu[$i]['lvl'];
				continue;
			}

			if($last_active && $last_active_lvl>$menu[$i]['lvl'])
			{
				$menu[$i]['active']=true;
				$last_active_lvl=$menu[$i]['lvl'];
			}

			if(!$menu[$i]['lvl'] && $last_active)
			{
				$last_active=false;
			}
		}



		return $menu;

	}



	public static function debug($mixt)
	{
		if(!FG_DEBUG) return;
		print('<pre>');
		print_r($mixt);
		print ('</pre>');
	}

	public static function sendMail($from,$to,$message)
	{
		//TODO: send mail
		mail($to,$from,$message);
	}

	/**
	 * Parse template from
	 *
	 * @param string $str
	 * @param array $assoc
	 * @param string $lmust
	 * @param string $rmust
	 * @return string $res
	 */
	public static function parseTemplate($str,$assoc,$lmust='#',$rmust='#'){
		$suchmuster='/'.$lmust.'([a-zA-Z0-9_]+)'.$rmust.'/e';
		$res=preg_replace($suchmuster,
	 "((isset(\$assoc['\\1']))?\$assoc['\\1']:'')",
		$str);
		return $res;
	}


	public static function getWfKategory($kat,$lang=null,$assoc=false, $name=false)
	{
		$DB=FgLoader::getInstance()->getObject('DBObject');


		if($lang)
			$resar = $DB->getAllAssoc("select A.ID,A.name,A.val,A.ord,B.LNG from (fg_wf A) left join (fg_wf_lang B) ON (B.PARENT_ID=A.ID and B.LANG='".$lang."') where A.wtype=".$kat." order by A.ord ");
		else
			$resar = $DB->getAllAssoc("select A.ID,A.name,A.val,A.ord from (fg_wf A) where A.wtype=".$kat." order by A.ord ");


		if($assoc)
		{
			$kategory=array();
			foreach($resar as $tmp)
			{
				if($name)
					$kategory[$tmp['name']]=($tmp['LNG'])?$tmp['LNG']:$tmp['val'];
				else
					$kategory[$tmp['ID']]=($tmp['LNG'])?$tmp['LNG']:$tmp['val'];
			}
			return $kategory;
		}
		else
		{
			return $resar;
		}
	}


	public static function parseRewriteUrl()
	{
		$uri=str_replace('/index.php', '', $_SERVER['REQUEST_URI']);


		if(preg_match("!/([^?]+)!", $uri, $regs))
		{


			$args=explode('/', $regs[1]);

			// set evt
			if(count($args)>0)
			{
				$_REQUEST['evt']=array_shift($args);
			}

			// set act
			if(count($args)>0)
			{
				$_REQUEST['act']=array_shift($args);
			}


			// set vars
			while(count($args)>1)
			{
				$k=FgUtill::checkVar(MSK_SAFESTRING, array_shift($args));
				$v=FgUtill::checkVar(MSK_SAFESTRING, array_shift($args));

				if(!is_null($k) && !is_null($v))
								$_REQUEST[$k]=$v;
			}


		}

	}

}

