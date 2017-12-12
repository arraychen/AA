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
	public const formRule=[
		'add'=>['name,age','*','{name}字段数据不能为空'],
		'login'=>['name,pass','*','{name}字段数据不能为空'],
		'update'=>['id,name,age','*'],
		'search'=>['name,age','*'],
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
}