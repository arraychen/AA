<?php
class Bctr {
	public static function before() {

	}
	public static function after() {

	}
	public static function auth() {

	}
	public static function httpCode($code) {
		echo 'page:',$code[0];
	}
}