<?php
class Event_Login extends Event_Base
{

	const ERROR_CLASS = 'Event_Start_Error';

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{
		/* @var $smarty FgSmarty */
		$smarty = FgSmarty::getInstance();


		if(isset($_REQUEST['login']))
		{
			try
			{
				if(!$this->actUser->checkLogin($_REQUEST['login'], $_REQUEST['pass']))
				{
					$smarty->assign('error', 'Logindaten sind falsch');
				}
			}
			catch (Exception_Login $ex)
			{
				$smarty->assign('error', $ex->getMessage());
			}

		}

				
		$prevUri=FgSession::getInstance()->getUri(1);
		if(!$prevUri)
		{
			$prevUri='/'.FG_EVENT_DEFAULT;
		}

		$smarty->assign('actevt', $prevUri);
		$smarty->assign('actUser', $this->actUser);
		
				
		$smarty->display('Login.tpl');


		return false;
	}


}
