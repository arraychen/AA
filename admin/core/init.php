<?php

class aApp extends bApp {
	const prefixDir='/a';
	const ctrTable=[
		'admin'	=>['user'=>1,'config'=>1,'update'=>1,'dev'=>['test'=>1]],
		'user'	=>1,
		'logout'=>1,
	];
}

class aCtr extends bCtr {
	public static function onEnd() {
		bCtr::$info['included']=get_included_files();
	}
}

bTpl::$layout='pc';
//class aMod extends bMod {}
//class aTpl extends bTpl {}
