<?php
class bCtr {
	public static $request;
	public static $echo;
	public static $info=[];
	public static $ro=0; //只读
	const prefixDir='/a';
	const ctrTable=[
		''=>0
	];
	public static function onLoad() {}
	public static function onEnd() {}

	final public static function startCatchEcho() {
		ob_start();
	}
	final public static function endCatchEcho() {
		self::$echo=ob_get_contents();
		ob_end_clean();
	}
	final public static function cleanCatch() {
		ob_clean();
	}
	final public static function getEcho() {
		return self::$echo;
	}
}