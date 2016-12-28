<?php
class bCtr {
	public static $echo;
	public static function onLoad() {}
	public static function onEnd() {}

	final public static function startCatchEcho() {
		ob_start();
	}
	final public static function endCatchEcho() {
		self::$echo=ob_get_contents();
		ob_end_clean();
	}
	final public static function getEcho() {
		return self::$echo;
	}
}