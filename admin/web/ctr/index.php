<?php

class cIndex extends \aCtr {
	public static function index() {
		//$a=mUser::solo();
		//admin\cUser::aLogin();
    //cTest::aLogin();
		echo '<p>this is index</p>class ctr:';
		$a=mUser::mod()->del('id=3');
		bFun::varDump($a);
		bTpl::$data=['title'=>'首页','menu'=>[[1,'用户'],[2,'管理']]];
		//bTpl::show('aaa');
	}
	public static function aLogin() {
		echo 'login';
	}
	public static function aTest() {
		echo 'test';
	}
}