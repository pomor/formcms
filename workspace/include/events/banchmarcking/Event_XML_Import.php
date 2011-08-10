<?php
/**
 * Banchmarking module show Formular
 *
 * @author dm.ivanov
 * @copyright Daarwin Gmbh
 * @package Event_XML_Import
 *
 */
class Event_XML_Import extends Event_Base
{

	const ERROR_CLASS = 'Event_Start_Error';
	const IMPORT_FILE = 'benchmarking2008.xml';
	const TABLE_NAME = 'fg_tabl01_val';
	const RAUM = 'banchmarcking/';

	private $werte = array();
	private $felder = array();

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::run()
	 */
	public function run()
	{

		/* @var $smarty FgSmarty */
		$smarty = FgLoader::getInstance()->getObject('FgSmarty');
		$xml = simplexml_load_file(FG_SMARTY_TEMPLATE_DIR.'/'.self::RAUM.self::IMPORT_FILE);


		foreach ($xml->werte->itm as $tmp)
		{
			$this->werte[(string)$tmp->id] = (string)$tmp->name;
		}

		/* insert oder update formular */
		if(array_key_exists('save_action', $_REQUEST))
		{
			if( array_key_exists('itm', $_POST) )
			{
				if(!is_null(FgUtill::checkVar(MSK_INT, $_POST['itm'])) && $_POST['itm']>0 )
				{
					$this->DB->update(self::TABLE_NAME, $_POST, array('ID'=>1), "ID=".$_POST['itm'], 2,1);
				}

			}
			else
			{
				$_REQUEST['itm'] = $this->DB->insert(self::TABLE_NAME, $_POST, array('ID'=>1), 2,1);
			}

		}



		/* start output buffering */
		ob_start();



	    if(isset($_REQUEST['itm']) && !is_null(FgUtill::checkVar(MSK_INT, $_REQUEST['itm'])))
		{
			$this->felder = $this->DB->getAssoc("select * from ".self::TABLE_NAME." where ID=".$_REQUEST['itm']);
			print "<input type='hidden' name='itm' value='".$_REQUEST['itm']."'>";
		}


		/* XML to HTML Formular */
		$acnt=0;
		if(count($xml->h1))
		{
			foreach($xml->h1 as $tmp)
			{
				$this->create_h1($tmp,++$acnt);
			}
		}
		else
		{
			$this->create_h1($xml->h1,++$acnt);
		}




		$smarty->assign('content', ob_get_contents());

		/* end output buffering */
		ob_end_clean();


		$smarty->display(self::RAUM.'benchmarking.tpl');


		return true;
	}


	/**
	 * Generiert obere strukture
	 *
	 * @param XMLObject $h1
	 * @param int $cnt
	 */
	private function create_h1($h1,$cnt)
	{
		print '<div class="h1">'."\n";
			print '<div class="head">'."\n";
				if(isset($h1->title))print '<div class="title">'.$cnt.'.'.(string)$h1->title.'</div>'."\n";
			print '</div>'."\n";

			print '<div class="inhalt">'."\n";
			$acnt=0;
			if(count($h1->h2)>1)
			{
				foreach($h1->h2 as $tmp)
				{
					$this->create_h2($tmp,++$acnt);
				}
			}
			else
			{
				$this->create_h2($h1->h2,++$acnt);
			}
			print '</div>'."\n";
		print '</div>'."\n";
	}

	/**
	 * Generiert zweite ebene
	 *
	 * @param XMLObject $h2
	 * @param int $cnt
	 */
	private function create_h2($h2,$cnt)
	{
		print '<div class="h2">'."\n";

			print '<div class="head">';
				if(isset($h2->title))print '<div class="title">'.$cnt.'.'.(string)$h2->title.'</div>'."\n";

			print '</div>';

			print '<div class="inhalt">'."\n";
			if(isset($h2->text))print '<div class="text">'.(string)$h2->text.'</div>'."\n";

			$acnt=0;
			if(count($h2->h3)>1)
			{
				foreach($h2->h3 as $tmp)
				{
					$this->create_h3($tmp,++$acnt);
				}
			}
			else
			{
				$this->create_h3($h2->h3,++$acnt);
			}
			print '</div>'."\n";

		print '</div>'."\n";
	}

	/**
	 * Generiert dritte ebene
	 *
	 * @param XMLObject $h3
	 * @param int $cnt
	 */
	private function create_h3($h3,$cnt)
	{
		print '<div class="h3">'."\n";
			print '<div class="head">';
				if(isset($h3->title))print '<div class="title">'.$cnt.'.'.(string)$h3->title.'</div>'."\n";

			print '</div>'."\n";

			print '<div class="inhalt">'."\n";
				if(isset($h3->text))print '<div class="text">'.(string)$h3->text.'</div>'."\n";
				if(isset($h3->table))$this->create_table($h3->table->head->td, $h3->table->tr);
				if(isset($h3->form))
				{
					if(count($h3->form)>1)
					{
						foreach($h3->form as $tmp)
						{
							$this->create_form($tmp);
						}
					}
					else
					{
						$this->create_form($h3->form);
					}
				}

			print '</div>'."\n";
		print '</div>'."\n";
	}


	/**
	 * Generiert Tabelle
	 *
	 * @param XMLObject $head
	 * @param XMLObject $body
	 */
	private function create_table($head,$body)
	{
		print "<table>";
			print "<tr>\n";
			foreach($head as $tmp)
			{
				printf("<th>%s</th>\n",(string)$tmp);
			}
			print "</tr>\n";

			foreach($body as $tmp)
			{
				$this->create_tr($tmp);
			}


		print "</table>\n";
	}


	/**
	 * Generiert Kontent
	 * @param XMLObject $tr
	 */
	private function create_tr($tr)
	{
		print "<tr>\n";
		$ch=0;
		foreach($tr->td as $tmp)
		{
			if($ch++)print "<td>";
			else print "<td class='tdhead'>\n";
			if(isset($tmp->form))
			{
				if(count($tmp->form)>1)
				{
					foreach($tmp->form as $frm)
					{
						$this->create_form($frm);
					}
				}
				else
				{
					$this->create_form($tmp->form);
				}

			}
			else
			{
				print((string)$tmp);
			}



			print '</td>'."\n";

		}
		print "</tr>"."\n";
	}



	/**
	 * Generiert formular
	 * @param XMLObject $form
	 */
	private function create_form($form)
	{
		$feldid=(string)$form['id'];
		$val = '';

		if(array_key_exists( $feldid, $this->felder ))
			 $val = $this->felder[$feldid];
		else if(array_key_exists( $feldid, $_REQUEST ))
			 $val = $_REQUEST[$feldid];


		switch((string)$form['type'])
		{
			case 'text':

				printf("<input type='text' id='%s' name='%s' value='%s' check='%s' />\n",$feldid,$feldid,$val,$form['check']);
				break;
			case 'textarea':

				printf("<textarea type='text' id='%s' name='%s' value='%s' ></textarea>\n",$feldid,$feldid,$val);
				break;
			case 'radio':

				foreach ($form->wrt as $tmp)
				{
					$wertid=(string)$tmp['id'];
					$selected=($val==$wertid)?' checked="checked" ':'';
					printf("<input type='radio' id='%s' name='%s' value='%s' %s/>%s</br>\n",$feldid.'_'.$wertid,$feldid,$wertid,$selected,$this->werte[$wertid]);
				}
				break;
			case 'checkbox':
				$selected=($val==1)?' checked="checked" ':'';
				printf("<input type='checkbox' id='%s' name='%s' value='1' %s />%s</br>\n",$feldid,$feldid,$selected,(string)$form->title);
				break;
			case 'select':

				printf("<select id='%s' name='%s' />\n",$feldid,$feldid);
				foreach ($form->wrt as $tmp)
				{
					$wertid=(string)$tmp['id'];
					$locval = isset($tmp['value'])?(string)$tmp['value']:$wertid;
					$selected=($val==$locval)?' selected="selected" ':'';

					printf("<option value='%s' %s/>%s</option>\n",$locval,$selected,$this->werte[$wertid]);
				}
				print "</select>\n";
				break;

		}


	}



	/**
	 * Generiert Mysql Tabelle für daten
	 */
	private function createTable()
	{

		$res= "create table fg_tabl01_val ( `ID` int(11) NOT NULL AUTO_INCREMENT, ";

		foreach($this->felder as $k=>$v)
		{
			$res.= $k.' '.$v.' NOT NULL,';
		}

		$res.=' PRIMARY KEY (`ID`)) ENGINE=InnoDB DEFAULT CHARSET=utf8';


		$this->DB->query($res);
		FgUtill::debug( $DB->get_last_query() );

	}

	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::hasAccess()
	 */
	public function hasAccess()
	{

		/* permissions list */
		$perm = array(
			"MODULE_BENCHMARKING"=>1,
			"PERM_RECHTE"=>PERM_MONITOR
		);
		if($this->actUser->isLogin() && $this->actUser->checkPermission($perm))
				return true;

		return false;
	}


	/**
	 * (non-PHPdoc)
	 * @see workspace/include/interfaces/iEvent::getMainTemplate()
	 */
	public function getMainTemplate()
	{
		return 'index.tpl';
	}

}
