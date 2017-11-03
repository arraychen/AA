<?php

class cIndex extends \aCtr {
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
		$u=mUser::mod();
		//$u->offset('aa',2);
		//$a=$u->put(['age'=>30,'name'=>'姓名aaaaa','atime'=>bexp('now()')],1);
		$a=mUser::mod()->get();
		//$a=mUser::mod()->query('select * from user WHERE %s>%s',[[COL,'id'],[NUM,1]]);
		bTpl::set(['title'=>'首页','menu'=>[[1,'用户'],[2,'管理']],'userList'=>$a->data]);
		//bTpl::show('aaa');
	}
	public static function aLogin() {
		echo 'login';
	}
	public static function aTest() {
		echo 'test';
	}
}