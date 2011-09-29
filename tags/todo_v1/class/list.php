<?php

include_once 'object.php';

class TodoList extends XoopsObject
{
	// constructor
	function TodoList($id = null)
	{
		$this->db =& Database::getInstance();
		$this->initVar('id',            XOBJ_DTYPE_INT,       null,   false);
		$this->initVar('tag',           XOBJ_DTYPE_TXTBOX,    null,   false,   100);
		$this->initVar('title',         XOBJ_DTYPE_TXTBOX,    null,   false,   250);
		$this->initVar('note',          XOBJ_DTYPE_TXTAREA,   null,   false);
		$this->initVar('priority',      XOBJ_DTYPE_INT,          0,   false);
		$this->initVar('complete',      XOBJ_DTYPE_INT,          0,   false);
		$this->initVar('published',     XOBJ_DTYPE_TXTBOX,    null,   false,   100);
		$this->initVar('weight',        XOBJ_DTYPE_INT,          0,   false);
		$this->initVar('percent',       XOBJ_DTYPE_INT,          0,   false);
		
		// for backward compatibility
		if (isset($id)) {
			if (is_array($id)) {
				$this->assignVars($id);
			} else {
				$this->load(intval($id));
			}
		}
	}
	
	function &load($id)
	{
		$sql = 'SELECT * FROM '.$this->db->prefix(DB_TODO).' WHERE id = '.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
	}
	
}

class TodoListHandler extends XoopsObjectHandler
{
	// Create a new Object
    function &create($isNew = true)
    {
        $obj =& new TodoList();
        if ($isNew) {
            $obj->setNew();
        }
        return $obj;
    }
	
	// Load a Object
	function &get($id)
    {	
		$ret = false;
		if (intval($id) > 0) {
			$sql = 'SELECT * FROM '.$this->db->prefix(DB_TODO).' WHERE id = '.$id;
			if ($result = $this->db->query($sql)) {
				$numrows = $this->db->getRowsNum($result);
				if ($numrows == 1) {
					$obj =& new TodoList();
					$obj->assignVars($this->db->fetchArray($result));
					$ret =& $obj;
				}
			}
		}
        return $ret;
    }
	
	function &getArray($id)
    {	
		$arr = '';
		if (intval($id) > 0) {
			$sql = 'SELECT * FROM '.$this->db->prefix(DB_TODO).' WHERE id = '.$id;
			if ($result = $this->db->query($sql)) {
				$numrows = $this->db->getRowsNum($result);
				if ($numrows == 1) {
					$arr = $this->db->fetchArray($result);
				}
			}
		}
        return $arr;
    }
	
	// Store a Object
	function insert(&$obj) 
	{
		if (strtolower(get_class($obj)) != 'todolist') {
			return false;
		}
		if (!$obj->isDirty()) {
			return true;
		}
		if (!$obj->cleanVars()) {
			return false;
		}
		$ins_into = '' ;
		$ins_set  = '' ;
		$upd_set  = '' ;
		foreach ( $obj->cleanVars as $k=>$v ) {
			${$k} = $v;
			if( $k == 'id' ) continue;
			$ins_into .= sprintf('`%s`',$k).', ' ;
			$ins_set  .= $this->db->quoteString($v).' ,' ;
			$upd_set  .= sprintf('`%s`',$k).'='.$this->db->quoteString($v).', ' ;
		}
		$ins_into = substr($ins_into, 0, -2);
		$ins_set  = substr($ins_set,  0, -2);
		$upd_set  = substr($upd_set,  0, -2);

		if ($obj->isNew()) {
			$sql = 'INSERT INTO '.$this->db->prefix(DB_TODO).' ('.$ins_into.') VALUES ('.$ins_set.')';
		} else {
			$sql = 'UPDATE '.$this->db->prefix(DB_TODO).' SET '.$upd_set.' WHERE id='.$id;
		}
		//echo 'SQL debug:<br />'.$sql.'<br />';
		$result = $this->db->queryF($sql);
		if (!$result) {
			//$this->setErrors('無法寫入資料庫.');
			return false;
		}
		if (empty($id)) {
			$id = $this->db->getInsertId();
		}
		$obj->assignVar('id', $id);
		return true;
	}
	
	// Delete data from the database
	function delete(&$obj)
	{
		if (strtolower(get_class($obj)) != 'todolist') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE id = %u", $this->db->prefix(DB_TODO), $obj->getVar('id'));
		//echo 'SQL debug:<br />'.$sql.'<br />';
		$result = $this->db->queryF($sql);
		if (!$result) {
			//$this->setErrors('無法由資料庫刪除資料.');
			return false;
		}
		return true;
	}
	
	// Retrieve objects from the database
	function &getObjects($criteria=array(), $orderby='weight DESC', $limit=0, $start=0, $asobject=true)
	{
		$ret = array();
		$sql = 'SELECT * FROM '.$this->db->prefix(DB_TODO);
		if ( is_array($criteria) && count($criteria) > 0 ) {
			$sql_query = ' WHERE ';
			foreach ( $criteria as $c ) {
				$sql_query .= $c.' AND ';
			}
			$sql .= substr($sql_query, 0, -5);
		}
		if (!empty($orderby)) {
			$sql .= ' ORDER BY '.$orderby;
		}
		//echo 'SQL debug:<br />'.$sql.'<br />';
		$result = $this->db->query($sql, intval($limit), intval($start));
		if (!$result) {
			return $ret;
		}
		while ($myrow = $this->db->fetchArray($result)) {
			$obj =& new TodoList();
			$obj->assignVars($myrow);
			if ( !$asobject ) {
				$ret[$myrow['id']] = &$obj;
			} else {
				$ret[] = &$obj;
			}
			unset($obj);
		}
		return $ret;
	}	
	
	// Count  objects from the database
	function &getCount($criteria=array())
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix(DB_TODO);
		if ( is_array($criteria) && count($criteria) > 0 ) {
			$sql_query = ' WHERE ';
			foreach ( $criteria as $c ) {
				$sql_query .= $c.' AND ';
			}
			$sql .= substr($sql_query, 0, -5);
		}
		//echo 'SQL debug:<br />'.$sql.'<br />';
		$result = $this->db->query($sql);
		if (!$result) {
            return 0;
        }
		list($count) = $this->db->fetchRow($result);
		return $count;
	}
	
	function &getMaxWeight()
	{
		$sql = 'SELECT MAX(weight) FROM '.$this->db->prefix(DB_TODO);
		//echo 'SQL debug:<br />'.$sql.'<br />';
		$result = $this->db->query($sql);
		if (!$result) {
            return 0;
        }
		list($weight) = $this->db->fetchRow($result);
		return $weight;
	}
	
	function isExists($id=0)
	{
		$id = intval($id);	
		if( empty($id) ) {
			return false;
		}
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix(DB_TODO).' WHERE ';
		$sql .= 'id ='.$id;
		//echo 'SQL debug:<br />'.$sql.'<br />';
		$result = $this->db->query($sql);
		list($count) = $this->db->fetchRow($result);
		if ( $count > 0 ){
			return true;
		}
		return false;
	}
}
?>