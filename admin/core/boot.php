<?php

class aApp extends bApp {
	public static $ctrTable=[
		'admin'	=>['user'=>1,'config'=>1,'update'=>1,'dev'=>['test'=>1]],
		'login'	=>1,
		'logout'=>1,
	];
}
class aCtr extends bCtr {}
class aMod extends bMod {}
class aTpl extends bTpl {}
