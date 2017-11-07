<?php

class aApp extends bApp {
	const prefixDir='/a';
	const ctrTable=[
		'admin'	=>['user'=>1,'config'=>1,'update'=>1,'dev'=>['test'=>1]],
		'user'	=>1,
		'logout'=>1,
	];
}
//class aMod extends bMod {}

class aCtr extends bCtr {
	public static function onEnd() {
		bCtr::$info['加载文件']=get_included_files();
	}
}

class aTpl extends bTpl {
	public static $layout='pc';
}
class aError extends bError {}