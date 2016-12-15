<?php
class bMod {
	protected static $allModInstance;
	public static function mod() {
		$className=get_called_class();
		if (empty(static::$allModInstance[$className])) {
			$obj=new $className;
			static::$allModInstance[$className]=$obj;
			return $obj;
		} else {
			return static::$allModInstance[$className];
		}
	}
	public function nameRule() {}
	public function storeMap() {}
	public function htmlMap() {}
	public function jsonMap() {}
	public function findRule() {}
	public function insert() {}
	public function update() {}
	public function delete() {}
	public function select() {}
	public function count() {}
}