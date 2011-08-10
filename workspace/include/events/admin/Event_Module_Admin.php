<?php
class Event_Module_Admin extends Event_Base
{
	const ERROR_CLASS = 'Event_Start_Error';
	const ROOM = 'admin/';

	public function run()
	{
		switch ($this->action)
		{
			case 'update':
				return $this->actionUpdate();
			case 'create':
				return $this->actionCreate();
			default:
				return $this->actionList();
		}
	}

	private function actionCreate()
	{
		$db = $this->DB; /* @var $db DBObject */
		$tabstruct = $db->getTabStruct('fg_sys_module');
		$send_struct = array('STATUS' => 'OK', 'MODUL' => array());
		foreach ($tabstruct as $k => $v)
		{
			$send_struct['MODUL'][$k] = '';
		}
		$id = $db->insert('fg_sys_module', array('Info' => 'Insert new modul'), false, 2, 1);
		if (! $id)
		{
			$id = $db->getOne("select ID from fg_sys_module where Space='' and Name=''");
			if ($id)
			{
				$send_struct['MODUL']['ID'] = $id;
				$send_struct['STATUS'] = 'FOUND';
			}
			else
			{
				$send_struct['STATUS'] = 'ERROR';
			}
		}
		else
		{
			$send_struct['MODUL']['ID'] = $id;
		}
		print json_encode($send_struct);
		return false;
	}

	private function actionUpdate()
	{
		$db = $this->DB; /* @var $db DBObject */
		$tabstruct = $db->getTabStruct('fg_sys_module');
		$id = FgUtill::checkVar(MSK_ZAHL, FgUtill::getVal('id', $_REQUEST));
		$name = FgUtill::checkVar(MSK_SAFESTRING, FgUtill::getVal('name', $_REQUEST));
		$val =  FgUtill::getVal('val', $_REQUEST);
		if ($id && array_key_exists($name, $tabstruct) && $name != 'ID')
		{
			$ret = $db->update('fg_sys_module', array($name => $val), false, array(array('ID', '=', $id)), 2, 1);
			if ($ret > 0)
			{
				print json_encode(array('STATUS' => 'OK'));
			}
			else
			{
				print json_encode(array('STATUS' => 'Error: Duplicated record','MYSQL'=>$db->debug()));
			}
		}
		else
		{
			print json_encode(array('STATUS' => 'Error: Parameter'));
		}
		return false;
	}

	/**
	 * show Modules List
	 * 
	 */
	private function actionList()
	{
		$list = $this->DB->getAllAssoc("select * from fg_sys_module order by ID desc");
		$smarty = FgSmarty::getInstance();
		$smarty->assign('items', $list);
		$smarty->display(self::ROOM . 'Event_Module_Admin_List.tpl');
		return true;
	}

	/* (non-PHPdoc)
	 * @see Event_Base::hasAccess()
	 */
	public function hasAccess()
	{
		/* permissions list */
		$perm = array("PERM_RECHTE" => PERM_OWNER);
		if ($this->actUser->isLogin() && $this->actUser->checkPermission($perm))
		{
			return true;
		}
		return false;
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

