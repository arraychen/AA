<?php
class bData {
	private static $allModInstance;
	private static $allDataBaseConnect;
	public $datai='mysqli';
	public $server;
	public $base;
	public $count;
	public $autoId;
	public static function mod() {
		$className=get_called_class();
		if (empty(self::$allModInstance[$className])) {
			$obj=new $className;
			self::$allModInstance[$className]=$obj;
			return $obj;
		} else {
			return self::$allModInstance[$className];
		}
	}
	public static function connect() {
		self::$allDataBaseConnect=get_called_class();
		if (empty(self::$allModInstance[$className])) {
			$obj=new $className;
			self::$allModInstance[$className]=$obj;
			return $obj;
		} else {
			return self::$allModInstance[$className];
		}
	}
	public function rule() {}
	public function map() {}

	public function getOne($) {}
	public function getAll() {}

	public function insert() {}
	public function update() {}
	public function delete() {}
	public function select() {}
	public function count() {}


}