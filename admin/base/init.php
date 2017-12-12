<?php

class aApp extends bApp {
	public const name='管理系统';		//网站名
	public static $httpClass='bHttp';
	public static $ctrClass='aCtr';
	public static $tplClass='aTpl';
	public static $errorClass='bError';
	const prefixDir='/a';
	const ctrTable=[
		''=>0,
		'admin'	=>['user'=>1,'config'=>1,'update'=>1,'dev'=>['test'=>1]],
		'user'	=>1,
		'logout'=>1,
	];
}
//class aMod extends bMod {}
class aCtr extends bCtr {
	public static function onEnd() {
		static::$info['加载文件']=get_included_files();
	}
}
class aTpl extends bTpl {
	public static $layout='pc';
}
