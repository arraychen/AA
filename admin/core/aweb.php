<?php

class aApp extends bApp {
	public static $prefixDir='/a';
	public static $ctrTable=[
		'admin'	=>['user'=>1,'config'=>1,'update'=>1,'dev'=>['test'=>1]],
		'user'	=>1,
		'logout'=>1,
	];
}
class aCtr extends bCtr {
	public static function onStart() {
	}
	public static function onEnd() {
		echo '<hr size=1>included_files:';
		foreach (get_included_files() as $id=>$file) {
			echo '<br>',$id,' ',$file;
		}
	}
}
//class aMod extends bMod {}
//class aTpl extends bTpl {}
bTpl::$layout='pc';
