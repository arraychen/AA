<?php

class cIndex extends bCtr {
	public static function index() {
		$a=mUser::solo();
		$a->test='a';
		$b=mUser::solo();
		$fiels=mUser::fields();
		echo $b->test;
		bFun::vd($fiels);
		cUser::aLogin();
	}
	public static function aLogin() {
		echo 'login';
	}
}