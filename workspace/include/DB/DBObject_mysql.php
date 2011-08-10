<?php
/**
 * Mysql worker
 * @author dm.ivanov
 * @copyright Daarwin GmbH
 * @version 1.0
 *
 */
require_once 'DB/DBObject.php';
class DBObject_mysql extends DBObject
{

	/**
	 * @see workspace/include/DB/DBObject::connection()
	 */
	public function connection($serv, $user, $pass, $dbname = '')
	{
		$this->db = mysql_connect($serv, $user, $pass) or die("No connections: " . mysql_error());
		$this->tab_struct = array();
		if ($dbname)
			mysql_select_db($dbname, $this->db) or die("No connect to DB" . $dbname);
		mysql_query("SET NAMES utf8", $this->db);
		mysql_query("SET CHARACTER SET utf8", $this->db);
		$this->loadTabStruct($dbname);
		return $this->db;
	}

	/**
	 * @see workspace/include/DB/DBObject::disconnect()
	 */
	public function disconnect()
	{
		@mysql_close($this->db);
	}

	/**
	 * @see workspace/include/DB/DBObject::getOne()
	 */
	public function getOne($sql, $rdef = '')
	{
		$this->last_query = $sql;
		$query = @mysql_query($sql, $this->db);
		$row = @mysql_fetch_row($query);
		@mysql_free_result($query);
		$ret = ($row[0]) ? $row[0] : $rdef;
		return $ret;
	}

	/**
	 * @see workspace/include/DB/DBObject::getArray()
	 */
	public function getArray($sql)
	{
		$this->last_query = $sql;
		$query = @mysql_query($sql, $this->db);
		$row = @mysql_fetch_row($query);
		@mysql_free_result($query);
		if (! is_array($row))
		{
			$row = array();
		}
		return $row;
	}

	/**
	 * @see workspace/include/DB/DBObject::getAssoc()
	 */
	public function getAssoc($sql)
	{
		$this->last_query = $sql;
		$query = @mysql_query($sql, $this->db);
		$row = @mysql_fetch_assoc($query);
		@mysql_free_result($query);
		if (! is_array($row))
		{
			$row = array();
		}
		return $row;
	}

	/**
	 * @see workspace/include/DB/DBObject::getAllAssoc()
	 */
	public function getAllAssoc($sql, $key = null)
	{
		$this->last_query = $sql;
		$query = @mysql_query($sql, $this->db);
		$ret = array();
		while (($row = @mysql_fetch_assoc($query)) != false)
		{
			if ($key)
			{
				$ret[$row[$key]] = $row;
			}
			else
			{
				$ret[] = $row;
			}
		}
		@mysql_free_result($query);
		return $ret;
	}

	/**
	 * @see workspace/include/DB/DBObject::getAllArray()
	 */
	public function getAllArray($sql)
	{
		$this->last_query = $sql;
		$query = @mysql_query($sql, $this->db);
		$ret = array();
		while (($row = @mysql_fetch_array($query)) != false)
		{
			$ret[] = $row;
		}
		@mysql_free_result($query);
		return $ret;
	}

	/**
	 * @see workspace/include/DB/DBObject::getCol()
	 */
	public function getCol($sql)
	{
		$ret = array();
		$query = @mysql_query($sql, $this->db);
		while (($row = @mysql_fetch_row($query)) != false)
		{
			$ret[] = $row[0];
		}
		@mysql_free_result($query);
		return $ret;
	}

	public function getKeyVal($sql)
	{
		$ret = array();
		$this->last_query = $sql;
		$query = @mysql_query($sql, $this->db);
		while (($row = @mysql_fetch_row($query)) != false)
		{
			$ret[$row[0]] = $row[1];
		}
		@mysql_free_result($query);
		return $ret;
	}

	/**
	 * @see workspace/include/DB/DBObject::query()
	 */
	public function query($sql, $is_result = false)
	{
		$this->last_query = $sql;
		$query = @mysql_query($sql, $this->db);
		if ($is_result)
		{
			return $query;
		}
		else
		{
			$result = @mysql_affected_rows($this->db);
			@mysql_free_result($query);
			return $result;
		}
	}

	/**
	 * @see workspace/include/DB/DBObject::insert()
	 */
	public function insert($tab, $obj_hash, $ignore, $auto_quote, $auto_safe = false)
	{
		$index = 0;
		$tab_struct = $this->getTabStruct($tab);
		if (! is_array($ignore))
		{
			$ignore = array();
		}
		$k_st = '';
		$v_st = '';
		if (is_array($tab_struct) && is_array($obj_hash))
		{
			foreach (array_keys($tab_struct) as $ky)
			{
				if (isset($obj_hash[$ky]) && ! isset($ignore[$ky]))
				{
					if ($auto_safe)
					{
						$obj_hash[$ky] = mysql_real_escape_string($obj_hash[$ky]);
					}
					if ($auto_quote == 1 || ($auto_quote == 2 && ($tab_struct[$ky] || preg_match("/^[0-9]/", $obj_hash[$ky]))))
					{
						$obj_hash[$ky] = "'" . $obj_hash[$ky] . "'";
					}
					$k_st .= "$ky,";
					$v_st .= $obj_hash[$ky] . ",";
				}
			}
			$k_st = substr($k_st, 0, - 1);
			$v_st = substr($v_st, 0, - 1);
			$sql = "insert into $tab ($k_st) values ($v_st)";
			$this->last_query = $sql;
			$query = @mysql_query($sql, $this->db);
			$index = @mysql_insert_id($this->db);
			if (! is_int($index))
			{
				return 0;
			}
		}
		return $index;
	}

	public function replace($tab, $obj_hash, $ignore, $auto_quote, $auto_safe = false)
	{
		$index = 0;
		$tab_struct = $this->getTabStruct($tab);
		if (! is_array($ignore))
		{
			$ignore = array();
		}
		$k_st = '';
		$v_st = '';
		if (is_array($tab_struct) && is_array($obj_hash))
		{
			foreach (array_keys($tab_struct) as $ky)
			{
				if (isset($obj_hash[$ky]) && ! isset($ignore[$ky]))
				{
					if ($auto_safe)
					{
						$obj_hash[$ky] = mysql_real_escape_string($obj_hash[$ky]);
					}
					if ($auto_quote == 1 || ($auto_quote == 2 && ($tab_struct[$ky] || preg_match("/^[0-9]/", $obj_hash[$ky]))))
					{
						$obj_hash[$ky] = "'" . $obj_hash[$ky] . "'";
					}
					$k_st .= "$ky,";
					$v_st .= $obj_hash[$ky] . ",";
				}
			}
			$k_st = substr($k_st, 0, - 1);
			$v_st = substr($v_st, 0, - 1);
			$sql = "replace into $tab ($k_st) values ($v_st)";
			$this->last_query = $sql;
			$query = @mysql_query($sql, $this->db);
			$index = @mysql_insert_id($this->db);
			if (! is_int($index))
			{
				return 0;
			}
		}
		return $index;
	}

	/**
	 * @see workspace/include/DB/DBObject::update()
	 */
	public function update($tab, $obj_hash, $ignore, $param_str, $auto_quote, $auto_safe = false)
	{
		$index = 0;
		$tab_struct = $this->getTabStruct($tab);
		if (! is_array($ignore))
		{
			$ignore = array();
		}
		$v_st = '';
		if (is_array($tab_struct) && $obj_hash && $param_str)
		{
			if (is_array($obj_hash))
			{
				foreach (array_keys($tab_struct) as $ky)
				{
					if (isset($obj_hash[$ky]) && ! isset($ignore[$ky]))
					{
						if ($auto_safe)
						{
							$obj_hash[$ky] = mysql_real_escape_string($obj_hash[$ky]);
						}
						if ($auto_quote == 1 || ($auto_quote == 2 && ($tab_struct[$ky] || preg_match("/^[0-9]/", $obj_hash[$ky]))))
						{
							$obj_hash[$ky] = "'" . $obj_hash[$ky] . "'";
						}
						$v_st .= $ky . "=" . $obj_hash[$ky] . ",";
					}
				}
				$v_st = substr($v_st, 0, - 1);
			}
			else
			{
				$v_st = $obj_hash;
			}
			$sql = "update $tab set $v_st where " . $this->makeWhere($param_str, $tab_struct, $auto_quote, $auto_safe);
			$this->last_query = $sql;
			$query = @mysql_query($sql, $this->db);
			$index = @mysql_affected_rows($this->db);
			if (! is_int($index))
			{
				return 0;
			}
		}
		return $index;
	}

	/**
	 * @see workspace/include/DB/DBObject::getTabStruct()
	 */
	public function getTabStruct($tname, $value = true)
	{
		$str = array();
		if (! isset($this->tab_struct[$tname]))
		{
			$query = @mysql_query("SHOW COLUMNS FROM " . $tname);
			while (($row = @mysql_fetch_row($query)) != false)
			{
				if ($value)
				{
					$str[$row[0]] = (preg_match("/date|time/i", $row[1])) ? 0 : 1;
				}
				else
				{
					if (preg_match("/int/i", $row[1]))
						$str[$row[0]] = 0;
					else
						$str[$row[0]] = '';
				}
			}
			@mysql_free_result($query);
			$this->tab_struct[$tname] = $str;
		}
		return $this->tab_struct[$tname];
	}

	protected function saveTabStruct($dbname)
	{
		$this->query("use " . $dbname);
		$tabl = $this->getCol("show tables");
		foreach ($tabl as $tmp)
		{
			$this->getTabStruct($tmp);
		}
		$trs = var_export($this->tab_struct, true);
		file_put_contents(FG_ROOT_DIR . '/workspace/temp/db_' . $dbname . '.php', '<?php $tab_struct =' . $trs . '; ?>');
	}

	protected function loadTabStruct($dbname)
	{
		if (! FG_DEBUG && file_exists(FG_ROOT_DIR . '/workspace/temp/db_' . $dbname . '.php'))
		{
			$tab_struct = array();
			require_once FG_ROOT_DIR . '/workspace/temp/db_' . $dbname . '.php';
			$this->tab_struct = $tab_struct;
		}
		else
		{
			$this->saveTabStruct($dbname);
		}
	}

	public function safe($str)
	{
		return mysql_real_escape_string($str);
	}
}
?>