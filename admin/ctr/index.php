<?php

class cIndex extends bCtr {
	public static function index() {
		$fiels=mUser::fields();
		print_r($fiels);
	}
	public static function aLogin() {
		echo 'login';
	}
}