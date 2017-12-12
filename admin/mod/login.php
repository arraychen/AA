<?php
class mLogin extends bData {
	//public static $dataName='adminW';
	public const type='form';
	public const table='';
	public const key='';
	public const field=[
		'name'=>[STR,'帐号'],
		'pass'=>[STR,'密码'],
	];
	public const inputRule=[
		//''=>[['name','*','{field}不能为空']],
		'login'=>[
			//['name,pass','*','{field}不能为空'],
			['name','url'],
		],
	];
	public const saveRule=[
	];
	public const outRule=[
	];
	public static function submitLogin($data) {
		print_r($data);
	}
	public static function submitLogin2($data) {
		echo 2;
		print_r($data);
	}
	public static function checkUrls($Param,$Data) {
		return '哈哈哈';
	}
}