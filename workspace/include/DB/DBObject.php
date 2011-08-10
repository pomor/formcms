<?php
abstract class DBObject implements iStorable
{
	protected $db;
	protected $last_query;
	protected $tab_struct;
	protected $last_row_count = 0;

	/**
	 * database object
	 */
	public function getDB()
	{
		return $this->db;
	}

	public function __destruct()
	{
		try
		{
			$this->disconnect();
		}
		catch (Exception $ex)
		{
		}
	}

	/**
	 *
	 * last query for debuging
	 */
	public function debug()
	{
		return $this->last_query;
	}

	public function getName()
	{
		return 'DBObject';
	}

	public function getNamespace()
	{
		return 'class';
	}

	/**
	 * Connect to database
	 *
	 * @param string $serv
	 * @param string $user
	 * @param string $pass
	 * @param string $dbname
	 */
	abstract public function connection($serv, $user, $pass, $dbname = '');

	/**
	 * disconnect from database
	 *<code>
	 *<?php
	 * MyLoader::loadObject('DB/');
	 *$mydb = DBLoader::getDB('mysql');
	 *?>
	 *</code>
	 *
	 */
	abstract public function disconnect();

	/**
	 * get one element
	 *
	 * @param string $sql sql abfrage
	 * @param mixed $rdef default wert
	 */
	abstract public function getOne($sql, $rdef = '');

	/**
	 * get as array
	 *
	 * @param string $sql
	 */
	abstract public function getArray($sql);

	/**
	 * Get result as hash
	 *
	 * @param string $sql
	 * @return array key=val
	 */
	abstract public function getAssoc($sql);

	/**
	 * get hash arrays
	 *
	 * @param string $sql
	 * @param string $key
	 * @return array[int][key]
	 */
	abstract public function getAllAssoc($sql, $key = null);

	/**
	 * get as array[][,,,]
	 * Enter description here ...
	 * @param String $sql
	 * @return array[int][int,int,...]
	 */
	abstract public function getAllArray($sql);

	/**
	 * get eine spalte
	 *
	 * @param String $sql
	 */
	abstract public function getCol($sql);

	/**
	 * get assoc from too first [0]=>[1]
	 *
	 * @param String $sql
	 * @return array $k=>$v
	 */
	abstract public function getKeyVal($sql);

	/**
	 * SQL abfrage
	 *
	 * @param string $sql
	 */
	abstract public function query($sql,$is_result=false);

	/**
	 * update table
	 *
	 * @param String $tab tabel name
	 * @param array $obj_hash params array
	 * @param array $ignore	ignore array
	 * @param String $param_str	where string (a=b and c=d)
	 * @param int $auto_quote	0-no, 1- allways, 2-intelegent
	 * @param boolean $auto_safe	false - not safe, true - safe whith mysql_real_escape_string
	 * @return int affected_rows
	 */
	abstract public function update($tab, $obj_hash, $ignore, $param_str, $auto_quote, $auto_safe = false);

	/**
	 * insert into table
	 *
	 * @param $tab tabele name
	 * @param $obj_hash params array
	 * @param $ignore	ignore array
	 * @param $auto_quote	0-no, 1- allways, 2-intelegent
	 * @param $auto_safe	false - not safe, true - safe
	 * @return insert_id
	 */
	abstract public function insert($tab, $obj_hash, $ignore, $auto_quote, $auto_safe = false);

	/**
	 * get tabelen strukture
	 *
	 * @param String $tname table name
	 * @param boolean $value type detect
	 * @return array tabel structure
	 */
	abstract public function replace($tab, $obj_hash, $ignore, $auto_quote, $auto_safe = false);

	abstract public function getTabStruct($tname, $value = true);

	abstract protected function saveTabStruct($dbname);

	abstract protected function loadTabStruct($dbname);	

	abstract public function safe($str);
	
	protected function makeWhere($in, $tabstruct, $auto_safe, $auto_quote)
	{
		if (is_array($in))
		{
			$where = array();
			foreach ($in as $ky)
			{
				if (isset($tabstruct[$ky[0]]))
				{
					if ($auto_safe)
					{
						$ky[2] = $this->safe($ky[2]);
					}
					if ($auto_quote == 1 || ($auto_quote == 2 && ($tabstruct[$ky[0]] || preg_match("/^[0-9]/", $ky[2]))))
					{
						$ky[2] = "'" . $ky[2] . "'";
					}
					if ($ky[2] == '')
					{
						$ky[2] = "''";
					}
					$where[] = $ky[0] . $ky[1] . $ky[2];
				}
			}
			return implode(' and ', $where);
		}
		return $in;
	}

	/**
	 * generate SQL WHERE string from array 
	 * 
	 * Example:
	 * <code>
	 * <?php
	 * $where = array(
	 * array('B.PARENTID','=',$parent_id,MSK_ZAHL),
	 * array('B.PARENTTYPE','=',$parent_type,MSK_ZAHL),
	 * array('B.KINDTYPE','=',FgVars::FG_TYPE_KONTAKT,MSK_ZAHL),
	 * );
	 * $DB=FgLoader::getInstance()->getObject('DBObject','class');
	 * $result = $DB->getAssoc("select * from ".FgVars::getTablePerType(FgVars::FG_TYPE_KONTAKT).
	 * " where ".$DB->makeWhereFromArray($where));
	 * ?>
	 * </code>
	 * 
	 * @param array $in
	 * @param int $auto_safe safe value
	 * @param int $auto_quote quoted value
	 * @return string
	 */
	public function makeWhereFromArray($in, $auto_safe = 1, $auto_quote = 2)
	{
		if (is_array($in))
		{
			$where = array();
			foreach ($in as $ky)
			{
				if ($auto_safe)
				{
					$ky[2] = $this->safe(FgUtill::checkVar($ky[3], $ky[2]));
				}
				if ($auto_quote == 1 || ($auto_quote == 2 && (is_numeric($ky[2]))))
				{
					$ky[2] = "'" . $ky[2] . "'";
				}
				if ($ky[2] == '')
				{
					$ky[2] = "''";
				}
				$where[] = $ky[0] . $ky[1] . $ky[2];
			}
			return implode(' and ', $where);
		}
		return $in;
	}

	public function getLastCount()
	{
		return $this->last_row_count;
	}

	protected function setLastCount($cnt)
	{
		$this->last_row_count = $cnt;
	}
}
