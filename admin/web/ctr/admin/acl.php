<?php

class cAcl extends aCtr {
	public static function index() {


	}
	public static function aAction() {
		//$u->offset('aa',2);
		//$a=$u->set(['age'=>30,'name'=>'姓名aaaaa','atime'=>bexp('now()')],1);
		//$a=mUser::mod()->get();
		$list=new bList(mAclAction::mod());
		//$a=mUser::mod()->query('select * from user WHERE %s>%s',[[COL,'id'],[NUM,1]]);
		aTpl::set(['list'=>$list]);
	}
}