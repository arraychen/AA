<?php

class aApp extends bApp {
	public const name='管理系统';		//网站名
	public static $ctrClass='aCtr';
	public static $tplClass='aTpl';
}
//class aMod extends bMod {}
class aCtr extends bCtr {
	public static $aclClass='mAcl';
	const prefixDir='/a';
	const ctrTable=[
		''=>1,
		//'admin'	=>['user'=>1,'group'=>1,'acl'=>1,'config'=>1,'update'=>1,'dev'=>['test'=>1]],
		'user'	=>[''=>0],
	];
	public static function onEnd() {
		static::$info['加载文件']=get_included_files();
	}
}
class aTpl extends bTpl {
	public static $layout='pc';
}
