<?php
class bSql {
	public $dbi=null; //数据库接口对象，可以直接调用
	public $dataBase; //当前数据库
	public $table;    //当前表
	public $autoId;   //当前表
	public function __construct($config) {
		$this->dbi=$this->connect($config);
	}
	public function insert($table,$data) {
		$this->query('INSERT '.$table.$data);
	}
	public function update() {}
	public function delete() {}
	public function select() {return 123;}
	public function query($sql) {
		return $this->dbo->query($sql);
	}
}