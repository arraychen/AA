<?php

class cIndex extends \bCtr {
	public static function index() {
		//$a=mUser::solo();
		//admin\cUser::aLogin();
    //cTest::aLogin();
		echo '<p>this is index</p>class ctr:';
		aTpl::$layout='pc';
	}
	public static function aLogin() {
		echo 'login';
	}
}