<?php
class bSql {
	public $link;
	public $datai;
	public function quote($field) {
		return '`'.$field.'`';
	}
	public function insert($table,$data) {
		$this->$datai->query('INSERT ');
	}
	public function update() {}
	public function delete() {}
	public function select() {}
	public function count() {}
	public function query() {}
}