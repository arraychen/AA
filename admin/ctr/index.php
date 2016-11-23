<?php

class cIndex extends \bCtr {
	public static function index() {
		//$a=mUser::solo();
		//admin\cUser::aLogin();
    //cTest::aLogin();
		echo '<p>this is index</p>class ctr:';
		admin\dev\cTest::aLogin();
	}
	public static function aLogin() {
		echo 'login';
	}
}