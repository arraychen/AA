<?php
class bMod {
	protected static $classInstance;
	public $test;
	public static function solo() {
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