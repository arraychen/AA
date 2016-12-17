<?php
class bData {
	private static $linkSet;
	public static function dbLink() {
		$linkName='';
		if (empty(self::$allModInstance[$className])) {
			$obj=new $className;
			self::$allModInstance[$className]=$obj;
			return $obj;
		} else {
			return self::$linkSet[$className];
		}
	}
	public static function field() {
		return [
			'id','name','age',
			];
	}
	public function rule() {
		return [
			'id','name','age',
			];
	}
}