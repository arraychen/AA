<?php

class dMysqli extends bSql {
	public static function col($F) {	return '`'.str_replace('`','``',$F).'`';}
	public static function bin($Input) {
		return '\''.str_replace(['\\','\'','"',"\0"],['\\\\','\\\'','\\"',"\\\0"],$Input).'\'';
	}
	public static function str($Input) {
		return '\''.str_replace(['\\','\'','"',"\r","\n","\0","\b","\Z"],['\\\\','\\\'','\\""',"\\\r","\\\n","\\\0","\\\b","\\\Z"],$Input).'\'';
	}
	public static function num($Input) {
		if(is_numeric($Input))
			return $Input;
		else return 0;
	}
	public static function exp($Tpl,$Input=[]) {
		if ($Input) {
			$arg=[];
			foreach ($Input as $val) {
				if (COL==$val[0]) { // field
					$arg[]=self::quote($val[1]);
				} elseif (NUM==$val[0]) { //num
					$arg[]=self::num($val[1]);
				} elseif (STR==$val[0]) { //string
					$arg[]=self::str($val[1]);
				}
			}
			return vsprintf($Tpl,$arg);
		} else return $Tpl;
	}
	public static function buildField($Item=[]) {
		/* 组合多个列
		 *例子： [[STR,'a','name'],[NUM,1],[COL,'key'],[EXP,'from_unixtime(%s)',[NUM,100000]]]
		 */
		$fieldArr=[];
		foreach ($Item as $value) {
			if (EXP==$value[0]) {//expr
				$fieldArr[]=self::exp($value[1],$value[2]);
			} elseif (COL==$value[0]) {
				$fieldArr[]=self::col($value[1]).(isset($value[2])?' AS '.self::col($value[2]):'');
			} elseif (NUM==$value[0]){
				$fieldArr[]=self::num($value[1]);
			} else {
				$fieldArr[]=self::str($value[1]);
			}
		}
		return join(',',$fieldArr);
	}
	public static function buildValue($Item) {
		/* 组合值
		 * 例子：[[NUM,'age',30],[STR,'name','tom'],[EXP,'time','now()',[]]]
		 */
		$valueArr=[];
		foreach ($Item as $value) {
			if (NUM==$value[0]) {//num
				$safeValue=self::num($value[2]);
			} elseif (STR==$value[0]) {//string
				$safeValue=self::str($value[2]);
			} elseif (BIN==$value[0]) {//bing
				$safeValue=self::bin($value[2]);
			} elseif (EXP==$value[0]) {//express
				if (isset($value[3]))	$safeValue=self::exp($value[2],$value[3]);
				else $safeValue=$value[2];
			}
			$valueArr[]=self::col($value[1]).'='.$safeValue;
		}
		return join(',',$valueArr);
	}
	public static function buildWhere($Where,$Join='AND') {
		/*
		 * 组合条件
		 * 例子：[[NUM,'id',1],[STR,'name','tom'],[EXP,'%s>%s',[[COL,'age'],[NUM,20]]]]
		 */
		$whereArr=[];
		foreach ($Where as $value) {
			if (NUM==$value[0]) {//num
				$whereArr[]=self::col($value[1]).'='.self::num($value[2]);
			} elseif (STR==$value[0]) {//string
				$whereArr[]=self::col($value[1]).'='.self::str($value[2]);
			} elseif (EXP==$value[0]) {
				$whereArr[]=self::exp($value[1],$value[2]);
			}
		}
		return join(' '.$Join.' ',$whereArr);
	}


	public function connect($config) {
		$mysqli=mysqli_init();
		$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 1);
		if (@$mysqli->real_connect($config['host'],$config['user'],$config['password'],$config['database'],$config['port'],$config['socket'])) {
			$this->dbi=$mysqli;
			$this->dbi->set_charset($config['charset']);
			$this->dataBase=$config['database'];
		} else {
			$error=new bError($mysqli->connect_error);
			$error->echo='连接服务器超时(>1秒)';
			throw $error;
		}
	}
	public function close() {
		return $this->dbi->close();
	}
	public function dataBase($name) {
		$this->dataBase=$name;
		return $this->dbi->select_db($this->dataBase);
	}
	public function query($Sql,$Bind=[]) {
		if ($Bind) {
			$Sql=self::exp($Sql,$Bind);
		}
		bCtr::$info['SQL'][]=__LINE__.':'.$this->dataBase.':'.$Sql;
		if($result=$this->dbi->query($Sql)) {
//			bFun::varDump($result);
			$return=new bResult();
			if ($this->dbi->insert_id) {
				$return->autoId=$this->dbi->insert_id;
				$return->affectedRow=$this->dbi->affected_rows;
			//bFun::printR($this->dbi);
			} elseif(isset($result->num_rows)) {
				$data=[];
				$return->total=$result->num_rows;
				if($result->num_rows>0) {
					$return->page=ceil($result->num_rows/$this->limit);
					while ($row=$result->fetch_array(MYSQLI_ASSOC)) {
						$data[]=$row;
					}
				}
				$result->free();
				$return->data=$data;
			}
			return $return;
		}
		return false;
	}

	public function select($Table,$Parm) {
		$where=$group=$having=$order='';
		$field='*';
		if (isset($Parm['field'])) {
			$field=self::buildField($Parm['field']);
		}
		if (isset($Parm['where'])) {
			$where=self::buildWhere($Parm['where']);
		}
		if (isset($Parm['group']))
			$group=' GROUP BY '.$Parm['group'];
		if (isset($Parm['having']))
			$having=' HAVING '.$Parm['having'];
		if (isset($Parm['order']))
			$order=' ORDER BY '.$Parm['order'];
		if (isset($Parm['limit']))
			$limit=' LIMIT '.$Parm['limit'];
		else
			$limit=' LIMIT '.$this->offset.','.$this->limit;
		$sql='SELECT '.$field.' FROM '.$Table.($where?' WHERE '.$where:'').$group.$having.$order.$limit;
		return $this->query($sql);
	}
	public function insert($Table,$Data) {
		$sql='INSERT '.$Table.' SET '.self::buildValue($Data);
		return $this->query($sql);
	}
	public function update($Table,$Data,$Where) {
		/* table *
		 * data  *
		 * where *
		 * limit
		 */
		if ($Where) {
			$sql='UPDATE '.$Table.' SET '.self::buildValue($Data).' WHERE '.self::buildWhere($Where);
			return $this->query($sql);
		}
		return false;
	}
	public function delete($Table,$Where) {
		/* table *
		 * where *
		 * limit
		 */
		if ($Where) {
			$where=self::buildWhere($Where);
			$sql='DELETE FROM '.$Table.($where?' WHERE '.$where:'');
			return $this->query($sql);
		}
		return false;
	}
	public function create($Table,$parm) {
		/* table *
		 * define *
		 */
		$sql='CREATE TABLE '.$Table.' IF NOT EXISTS '.$parm['define'];
		return $this->query($sql);
	}
}