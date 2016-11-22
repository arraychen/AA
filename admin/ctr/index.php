<?php

class cIndex extends \bCtr {
	public static function index() {
		//$a=mUser::solo();
    echo 'index';
		admin\cUser::aLogin();
    //cTest::aLogin();
	}
	public static function aLogin() {
		echo 'login';
	}
}