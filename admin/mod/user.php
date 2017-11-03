<?php
class mUser extends bData {
	//public static $dataName='adminW';
	public const type='sql';
	public const table='user';
	public const key='id';
	public const field=[
		'id'=>[NUM,'编号'],
		'name'=>[STR,'姓名'],
		'age'=>[NUM,'年龄'],
		'atime'=>[STR,'添加时间'],
	];
	public const rule=[
		'add'=>['name,age','*','{name}字段数据不能为空'],
		'update'=>['id,name,age','*'],
	];
}