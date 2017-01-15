<?php
class bMod {
	public static $defautDatai='mysqli';
	private static $allModInstance;
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
	public function nameRule() {}
	public function findRule() {}
	public function setRule() {}
	public function storeMap() {}
	public function htmlMap() {}
	public function jsonMap() {}

	public function insert() {}
	public function update() {}
	public function delete() {}
	public function select() {}
	public function count() {}
}