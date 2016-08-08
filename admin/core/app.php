<?php

class Aapp extends Bapp {

	public static $ctrTable=[
			''=>['index'=>1],
			'admin'=>['index'=>1,'user'=>1,'config'=>1,'update'=>1],
		];
	public static $ctrRule=[
			'dir'=>['ctr'],
		];
	public static function setCtrTable($arr=[]) {
		if($arr) {
			self::$ctrTable=$arr;
		}
	}
}