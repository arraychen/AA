<?php
class bCtr {
	private static $ctrEcho;
	public static function onLoad() {}
	public static function onEnd() {}

	public static function startCatchEcho() {
		ob_start();
	}
	public static function endCatchEcho() {
		self::$ctrEcho=ob_get_contents();
		ob_end_clean();
	}
	public static function getCtrEcho() {
		return self::$ctrEcho;
	}
}