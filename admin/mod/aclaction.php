<?php
class mAclAction extends bData {
	//public static $dataName='adminW';
	public const type='sql';
	public const table='acl_action';
	public const key='id';
	public const field=[
		'id'=>[NUM,'编号'],
		'path'=>[STR,'路径'],
		'name'=>[STR,'名称'],
	];
	public const inputRule=[
		//''=>[['name','*','{field}不能为空']],
		'add'=>[
			['path,name','*','{field}不能为空'],
		],
		'edit'=>[
			['id,path,name','*','{field}不能为空'],
		],
	];
	public const saveRule=[
	];
	public const showRule=[
	];
	public static function submitSave($data) {
		//print_r($data);
		//return [1,'登录成功！跳转中...','goto'=>['/a/admin/',0]];
		$res=self::mod()->get(['name'=>$data['name'],'pass'=>$data['pass']]);
		if($res->total==1) {
			aApp::$userClass::login(['id'=>$res->data[0]['id'],'level'=>$res->data[0]['level'],'name'=>$res->data[0]['name'],'groupid'=>$res->data[0]['groupid']]);
			return [1,'登录成功，页面跳转中...','goto'=>['/a/',0]];
		} else {
			return [0,'登录失败！请重试','error'=>['name'=>'帐号不存在或密码错误']];
		}
	}
}