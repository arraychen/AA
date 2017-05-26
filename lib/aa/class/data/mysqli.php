<?php

class dMysqli extends bSql {
	public static function quote($f) {	return '`'.$f.'`';}
	public function connect($config) {
		if ($this->dbi=new mysqli($config['host'],$config['user'],$config['password'],$config['database'],$config['port'],$config['socket'])) {
			$this->dbi->set_charset($config['charset']);
			return true;
		}
		return false;
	}
	public function close() {
		return $this->dbi->close();
	}
	public function dataBase($name) {
		$this->dataBase=self::quote($name);
		return $this->dbi->select_db($this->dataBase);
	}
	public function table($name) {
		$this->table=self::quote($name);
	}
	public function query($sql) {
		$res=$this->dbi->query($sql);
		$this->autoId=$this->dbi->insert_id;
		$this->affectedRow=$this->dbi->affected_rows;
		return $res;
	}
	public function fetch($result) {
		$this->total=$result->num_rows;
		return $result->fetch_assoc();
	}
	public function select($parm) {
		$where='';
		$group='';
		$having='';
		$order='';
		$limit='';
		$field=[];
		if (isset($parm['field'])) {
			if (is_array($parm['field'])) {
				foreach ($parm['field'] as $val) {
					$field[]=self::quote($val);
				}
			} else
				$field[]=$parm['field'];
		}
		if (isset($parm['expr'])) {
			$field[]=$parm['expr'];
		}
		$select=join(',',$field);
		if (isset($parm['where']))
			$where=' WHERE '.$parm['where'];
		if (isset($parm['group']))
			$group=' GROUP BY '.$parm['group'];
		if (isset($parm['having']))
			$having=' HAVING '.$parm['having'];
		if (isset($parm['order']))
			$order=' ORDER BY '.$parm['order'];
		if (isset($parm['limit']))
			$limit=' LIMIT '.$parm['limit'];
		$sql='SELECT '.$select.' FROM '.$parm['table'].$where.$group.$having.$order.$limit;
		if ($result=$this->dbi->query($sql)) {
			$this->total=$result->num_rows;
			$data=[];
			if (isset($parm['key'])) {
				while ($row=$result->fetch_array(MYSQLI_ASSOC)) {
					$data[$row[$parm['key']]]=$row;
				}
			} else {
				while ($row=$result->fetch_array(MYSQLI_ASSOC)) {
					$data[]=$row;
				}
			}
			$result->free();
			return $data;
		}
		return;
	}
	public function insert($parm) {
		/*
		 * table *
		 * data  *
		 * on
		 */
		foreach ($parm['data'] as $key=>$val) {
			$data[]=$key.'='.$val;
		}
		if (isset($parm['on'])) {
			$on=' ON DUPLICATE KEY UPDATE '.$parm['on'];
		} else {
			$on='';
		}
		$sql='INSERT '.$parm['table'].' SET '.join(',',$data).$on;

		$result=$this->dbi->query($sql);
		$this->autoId=$this->dbi->insert_id;
		$this->affectedRow=$this->dbi->affected_rows;
		return $result;
	}
	public function update($parm) {
		/*
		 * table *
		 * data  *
		 * where *
		 * limit
		 */
		foreach ($parm['data'] as $key=>$val) {
			$data[]=$key.'='.$val;
		}
		if (isset($parm['where'])) {
			$where=' WHERE '.$parm['where'];
		} else {
			return false;
		}
		$sql='UPDATE '.$parm['table'].' SET '.join(',',$data).$where.(isset($parm['limit'])?$parm['limit']:'');
		$result=$this->dbi->query($sql);
		$this->affectedRow=$this->dbi->affected_rows;
		return $result;
	}
	public function delete($parm) {
		/*
		 * table *
		 * where *
		 * limit
		 */
		if (isset($parm['where'])) {
			$where=' WHERE '.$parm['where'];
		} else {
			return false;
		}
		$sql='DELETE FROM '.$parm['table'].$where.(isset($parm['limit'])?$parm['limit']:'');
		$result=$this->dbi->query($sql);
		$this->affectedRow=$this->dbi->affected_rows;
		return $result;
	}
	public function create($parm) {
		/*
		 * table *
		 * def *
		 */
		$sql='CREATE TABLE '.$parm['table'].' IF NOT EXISTS '.$parm['def'];
		return $this->dbi->query($sql);
	}

}