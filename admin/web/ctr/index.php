<?php

class cIndex extends \aCtr {
	public static function index() {
		//$a=mUser::solo();
		//admin\cUser::aLogin();
    //cTest::aLogin();

		echo '<p>this is index</p>class ctr:';
		bTpl::$data['title']='首页';
		bTpl::$data['menu']=[[1,'用户'],[2,'管理']];
		//bTpl::show('aaa');
	}
	public static function aLogin() {
		echo 'login';
	}
	public static function aTest() {
		echo 'test';
	}
}