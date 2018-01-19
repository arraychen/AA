<?php
class mAcl extends bData {
	//public static $dataName='adminW';
	public const type='sql';
	public const table='acl_role';
	public const key='id';
	public const field=[
		'id'=>[NUM,'编号'],
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
	public static function acl($act) {
		$res=self::mod()->query('select b.func AS func from acl_action a LEFT JOIN acl_funcaction b ON (a.id=b.act) WHERE a.path=%s',[[STR,$act]]);
		if($res->total<1) {
			return 1;
		} else {
			foreach ($res->data as $val) {
				$funcId[]=$val['func'];
			}
			$res=self::mod()->query('select role from acl_roleuser WHERE user=%s AND (timelimit=0 OR (timelimit=1 AND etime>now()))',[[NUM,aApp::$user['id']]]);
			if ($res->total<1) return 1;
			else {
				foreach ($res->data as $val) {
					$roleId[]=$val['role'];
				}
			}
			$res=self::mod()->query('select count(1) from acl_access WHERE role IN('.join(',',$roleId).') AND func IN ('.join(',',$funcId).')');
			if ($res->total) return 0;
			else return 1;
		}
	}

	public static function menu($Pid=0) {
		$menu=[];
		$res=self::mod()->query('select c.path,c.name from acl_roleuser a LEFT JOIN acl_access b ON (a.role=b.role) LEFT JOIN acl_func c ON c.id=b.func WHERE a.user=%s AND (a.timelimit=0 OR (a.timelimit=1 AND a.etime>now())) AND c.pid=%s',[[NUM,aApp::$user['id']],[NUM,$Pid]]);
		if ($res->total<1) return 1;
		else {
				foreach ($res->data as $val) {
					$menu[]=[aCtr::prefixDir.$val['path'],$val['name']];
				}
		}
		return $menu;
	}
}