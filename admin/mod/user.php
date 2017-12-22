<?php
class mUser extends bData {
	//public static $dataName='adminW';
	public const type='sql';
	public const table='user';
	public const key='id';
	public const field=[
		'id'=>[NUM,'编号'],
		'name'=>[STR,'帐号'],
		'pass'=>[STR,'密码'],
		'mobile'=>[STR,'手机'],
		'email'=>[STR,'电邮'],
		'groupid'=>[NUM,'组号'],
		'level'=>[NUM,'级别'],
		'ctime'=>[STR,'创建时间'],
		'atime'=>[STR,'登录时间'],
		'disable'=>[NUM,'禁用'],
		'loginip'=>[STR,'登录IP'],
	];
	public const inputRule=[
		//''=>[['name','*','{field}不能为空']],
		'login'=>[
			['name,pass','*','{field}不能为空'],
			//['name','url'],
		],
	];
	public const saveRule=[
		'add'=>['ctime'=>'NOW()'],
		'update'=>['atime'=>'','loginip'=>''],
	];
	public const showRule=[
		'html'=>['atime'=>['addTime','时间'],'img'=>['userImg','头像']],
	];
	public static function addTime($row) {
		return substr($row['atime'],0,4);
	}
	public static function userImg($row) {
		return '<img src="'.$row['id'].'">';
	}
	public static function submitLogin($data) {
		//print_r($data);
		//return [1,'登录成功！跳转中...','goto'=>['/a/admin/',0]];
		$res=self::mod()->get(['name'=>$data['name'],'pass'=>$data['pass']]);
		if($res->total==1) {
			aApp::$userClass::login(['id'=>$res->data['id'],'level'=>$res->data['level'],'name'=>$res->data['name'],'groupid'=>$res->data['groupid']]);
			return [1,'登录成功，页面跳转中...','goto'=>['/a/',0]];
		} else {
			return [0,'登录失败！请重试','error'=>['name'=>'帐号不存在或密码错误']];
		}
	}

	public static function submitLogin2($data) {
		echo 2;
		print_r($data);
	}
}