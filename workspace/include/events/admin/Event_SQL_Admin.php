<?php
class Event_SQL_Admin extends Event_Base
{
	const ERROR_CLASS = 'Event_Start_Error';
	const ROOM = 'admin/';

	public function run()
	{
		$this->actionList();
		return true;
	}

	private function actionList()
	{
		$smarty = FgSmarty::getInstance();
		$result = array();
		if (isset($_POST['sql']))
		{		
			
			$arSql = preg_split("/;\s*\r?\n/", $_POST['sql'],NULL,PREG_SPLIT_NO_EMPTY);
			foreach ($arSql as $sql)
			{
				$elem = array();
				$elem['sql'] =stripslashes(trim($sql));
				$ret=array();
				
				if (preg_match("/^select/i", $sql))
				{
					$ret = $this->DB->getAllAssoc($elem['sql']);
				}
				else
				{
					$cnt = $this->DB->query($elem['sql']);
					$ret[]=array('Affected row'=>$cnt);
				}
				$elem['data'] = $ret;
				$result[] = $elem;
			}
		}
		$smarty->assign('result', $result);
		$smarty->display(self::ROOM . 'Event_SQL_Admin.tpl');
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

