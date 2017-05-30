<?php

class dMysqli extends bSql {
	public static function quote($f) {	return '`'.$f.'`';}
	public function connect($config) {
		if ($this->dbi=new mysqli($config['host'],$config['user'],$config['password'],$config['database'],$config['port'],$config['socket'])) {
			$this->dbi->set_charset($config['charset']);
			$this->dataBase=$config['database'];
			return true;
		}
		return false;
	}
	public function close() {
		return $this->dbi->close();
	}
	public function dataBase($name) {
		$this->dataBase=$name;
		return $this->dbi->select_db($this->dataBase);
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

	public function get($Table,$parm) {
		$where='';
		$group='';
		$having='';
		$order='';
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
		if($field) {
				$select=join(',',$field);
		} else
			$select='*';
		if (isset($parm['where'])) {
			$tmp=[];
			foreach ($parm['where'] as $key=>$val) {
				$tmp[]=$key.'='.$val;
			}
			if($tmp) $where=' WHERE '.join(' AND ',$tmp);
		}

		if (isset($parm['group']))
			$group=' GROUP BY '.$parm['group'];
		if (isset($parm['having']))
			$having=' HAVING '.$parm['having'];
		if (isset($parm['order']))
			$order=' ORDER BY '.$parm['order'];
		if (isset($parm['limit']))
			$limit=' LIMIT '.$parm['limit'];
		else
			$limit=' LIMIT '.$this->offset.','.$this->limit;
		$sql='SELECT '.$select.' FROM '.$Table.$where.$group.$having.$order.$limit;
		bCtr::$info['SQL'][]=$this->dataBase.':'.$sql;
		$data=[];
		if ($result=$this->dbi->query($sql)) {
			$this->total=$result->num_rows;
			if (isset($parm['key'])) {
				while ($row=$result->fetch_array(MYSQLI_ASSOC)) {
					$data[$row[$parm['key']]]=$row;
				}
			} else {
				while ($row=$result->fetch_array(MYSQLI_ASSOC)) {
					$data[]=$row;
				}
			}
			bFun::printR($result);
			$result->free();
		}
		bFun::printR($this);
		return $data;
	}
	public function add($Table,$parm) {
		/*
		 * table *
		 * data  *
		 * on
		 */
		foreach ($parm as $key=>$val) {
			$data[]=$key.'="'.$val.'"';
		}
		/*
		if (isset($parm['on'])) {
			$on=' ON DUPLICATE KEY UPDATE '.$parm['on'];
		} else {
			$on='';
		}
		*/
		$sql='INSERT '.$Table.' SET '.join(',',$data);

		$result=$this->dbi->query($sql);
		$this->autoId=$this->dbi->insert_id;
		$this->affectedRow=$this->dbi->affected_rows;
		bFun::printR($this);
		return $result;
	}
	public function put($Table,$Data,$Where) {
		/*
		 * table *
		 * data  *
		 * where *
		 * limit
		 */
		foreach ($Data as $key=>$val) {
			$data[]=$key.'="'.$val.'"';
		}
		if ($Where) {
			$where=' WHERE '.$Where;
		} else $where='';
		$sql='UPDATE '.$Table.' SET '.join(',',$data).$where;
		$result=$this->dbi->query($sql);
		$this->affectedRow=$this->dbi->affected_rows;
		bFun::printR($this);
		return $result;
	}
	public function del($Table,$Where) {
		/*
		 * table *
		 * where *
		 * limit
		 */
		if ($Where) {
			$where=' WHERE '.$Where;
		} else {
			return false;
		}
		$sql='DELETE FROM '.$Table.$where;
		$result=$this->dbi->query($sql);
		$this->affectedRow=$this->dbi->affected_rows;
		bFun::printR($this);
		return $result;
	}
	public function create($Table,$parm) {
		/*
		 * table *
		 * def *
		 */
		$sql='CREATE TABLE '.$Table.' IF NOT EXISTS '.$parm['def'];
		return $this->dbi->query($sql);
	}

}