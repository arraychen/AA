<?php
class bSql {
	public $dbi; 					//数据库接口对象或资源
	public $dataBase;			//数据库名称
	public $table;    		//数据表名称
	public $autoId;   		//自增ID
	public $affectedRow;	//影响的行数
	public $total;				//总记录数
	public $limit;   			//最大行数
	public $offset;   		//偏移
	public function __construct($config) {
		$this->dbi=$this->connect($config);
	}
	public function insert($table,$data) {
		$this->query('INSERT '.$table.$data);
	}
	public function update($table,$data,$where) {
		$this->dbi->query($sql);
	}
	public function delete() {}
	public function select() {return 123;}
	public function query($sql) {
		return $this->dbi->query($sql);
	}
}