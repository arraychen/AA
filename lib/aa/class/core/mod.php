<?php
class bMod {
	protected static $classInstance;
	public static function solo() {
		$className=get_called_class();
		if (empty(static::$classInstance)) {
			$obj=new $className;
			static::$classInstance[$className]=$obj;
		} else {
			return static::$classInstance;
		}
	}
	public function rule() {
	}
}