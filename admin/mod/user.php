<?php
class mUser extends bData {
	//public static $dataName='adminW';
	public const type='sql';
	public const table='user';
	public const key='id';
	public const field=[
		'id'=>[],
		'name'=>[],
		'age'=>[],
	];
}