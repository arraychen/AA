<?php
class bMod {
	protected static $classInstance;
	public static function mod() {
		$className=get_called_class();
		if (empty(static::$classInstance[$className])) {
			$obj=new $className;
			static::$classInstance[$className]=$obj;
			return $obj;
		} else {
			return static::$classInstance[$className];
		}
	}
	public function rule() {
	}
}