<?php

class cUser extends aCtr {
	public static function index() {
		$fiels=mUser::fields();
		print_r($fiels);
	}
	public static function aLogin() {
		echo 'loginadmin';
	}
}