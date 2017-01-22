<?php
class bSql {
	public  $dbo; //数据库原始对象，可以直接调用
	public  $dataBase; //数据库原始对象，可以直接调用
	public  $table; //数据库原始对象，可以直接调用
	public function getConnect() {
		$className=get_called_class();
		if (isset(bData::$allConnect[$className]['server'])) {
			return bData::$allConnect[$className]['server'];
		} else {
			bData::$allConnect[$className]['server']=$this->connect();
		}
	}
	public function insert($table,$data) {
		$this->query('INSERT '.$table.$data);
	}
	public function update() {}
	public function delete() {}
	public function select() {return 123;}
	public function queryi($sql) {}
	public function query($sql) {
		return $this->queryi($sql);
	}
}