<?php

class cIndex extends bCtr {
	public static function index() {
		$fiels=mUser::fields();
		bFun::htmlpr($fiels);
	}
	public static function aLogin() {
		echo 'login';
	}
}