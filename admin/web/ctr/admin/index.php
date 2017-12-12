<?php

class cIndex extends aCtr {
	public static function onLoad() {
		aTpl::$block=['menu'=>'menu','left'=>'left'];
		aTpl::put(['title'=>'用户首页 '.aApp::name,'topMenu'=>[[1,'用户'],[2,'管理']],'leftMenu'=>[[1,'添加'],[2,'删除']]]);
	}
	public static function index() {
		//$a=mUser::solo();
		//admin\cUser::aLogin();
    //cTest::aLogin();
		echo '<p>this is index</p>class ctr:';
		//$a=mUser::mod()->del(3);
		//mUser::mod()->put(['age'=>30,'name'=>'姓名2','atime'=>bexp('now()')]);
		//$a=mUser::mod()->get(bexp(1));
		/*
		$a=mUser::mod()->get([
			'field'=>['id','name','atime'],
			//'field'=>['id','name','age','atime','me'=>'atime'],
			//'field'=>bexp('*,id as aid'),
			//'field'=>bexc(['atime']),
			'where'=>['name'=>'姓名'],
			]);
		*/
		$user=mUser::mod();
		//$u->offset('aa',2);
		//$a=$u->put(['age'=>30,'name'=>'姓名aaaaa','atime'=>bexp('now()')],1);
		//$a=mUser::mod()->get();
		$userList=new \bList($user);
		//$a=mUser::mod()->query('select * from user WHERE %s>%s',[[COL,'id'],[NUM,1]]);
		aTpl::put(['userList'=>$userList]);
		//bTpl::show('aaa');
	}
	public static function aLogin() {
		echo 'login';
	}
	public static function aTest() {
		echo 'test';
	}
}