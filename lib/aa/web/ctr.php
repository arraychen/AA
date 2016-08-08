<?php
class Actl {
	public static function run() {
		self::who();
		self::want();
	}
	public static function who() {
		return 'user';
	}
	public static function want() {
		echo '<pre>';print_r($_SERVER);
	}
}