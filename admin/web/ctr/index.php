<?php

class cIndex extends \aCtr {
	public static function index() {
		//$a=mUser::solo();
		//admin\cUser::aLogin();
    //cTest::aLogin();
		echo '<p>this is index</p>class ctr:';
		bTpl::$layout='pc';
		bTpl::show('aaa');

	}
	public static function aLogin() {
		echo 'login';
	}
}