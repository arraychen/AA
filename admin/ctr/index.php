<?php

class Cindex extends Bctr {
	public static function index() {
		$fiels=Muser::fields();
		print_r($fiels);
	}
	public static function Alogin() {
		echo 'login';
	}
}