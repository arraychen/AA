<?php

class cUser extends aCtr {
	public static function index() {
		$user=mUser::mod();
		//$u->offset('aa',2);
		//$a=$u->set(['age'=>30,'name'=>'姓名aaaaa','atime'=>bexp('now()')],1);
		//$a=mUser::mod()->get();
		$userList=new bList($user);
		//$a=mUser::mod()->query('select * from user WHERE %s>%s',[[COL,'id'],[NUM,1]]);
		aTpl::set(['userList'=>$userList]);
	}
}