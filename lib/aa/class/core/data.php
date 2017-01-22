<?php
class bData {
	private static $allModInstance;
	private static $allConnect;
	public $driver='dMysqli';
	public $server;
	public $dbi;
	public $count;
	public $autoId;
	public static function mod($server='') {
		$className=get_called_class();
		if (empty(self::$allModInstance[$className])) {
			$obj=new $className;
			if ($server) $obj->server=$server;
			$obj->dbi= new $obj->datai;
			self::$allModInstance[$className]=$obj;
			return $obj;
		} else {
			return self::$allModInstance[$className];
		}
	}
	public static function connect($server='') {
		$className=get_called_class();
		if (empty(self::$allModInstance[$className])) {
			$obj=new $className;
			if ($server) $obj->server=$server;
			$obj->dbi= new $obj->datai;
			self::$allModInstance[$className]=$obj;
			return $obj;
		} else {
			return self::$allModInstance[$className];
		}
	}
	public static function closeConnect($server='') {
		$className=get_called_class();
		if (empty(self::$allModInstance[$className])) {
			$obj=new $className;
			if ($server) $obj->server=$server;
			$obj->dbi= new $obj->datai;
			self::$allModInstance[$className]=$obj;
			return $obj;
		} else {
			return self::$allModInstance[$className];
		}
	}
	public static function closeAllConnect() {
		if (!empty(self::$allConnect)) {
			foreach (self::$allConnect as $val) {
				$val->close();
			}
		}
	}
	public function rule() {}
	public function map() {}

	public function getOne() {
		return $this->dbi->select('× from table where pk=');
	}
	public function getAll() {}
}