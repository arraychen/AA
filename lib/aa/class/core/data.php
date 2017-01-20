<?php
class bData {
	private static $allModInstance;
	private static $allDataBaseConnect;
	public $datai='mysqli';
	public $server;
	public $base;
	public $api;
	public $count;
	public $autoId;
	public static function mod() {
		$className=get_called_class();
		if (empty(self::$allModInstance[$className])) {
			$obj=new $className;
			$obj->api= new $obj->datai;
			self::$allModInstance[$className]=$obj;
			return $obj;
		} else {
			return self::$allModInstance[$className];
		}
	}
	public static function connect() {
	}
	public function rule() {}
	public function map() {}

	public function getOne() {
		return $this->api->select('× from table where pk=');
	}
	public function getAll() {}
}