<?php

class AA {
	public static $ctrSubDir='';
	public static function run($appDir,$configFile) {
		define('AA_ROOT',__DIR__);
		define('AA_APP_ROOT',$appDir.'/');
		define('AA_CONF_FILE',$configFile);
		spl_autoload_register(array('AA','AAloader'));
		Aapp::set();
		Aapp::check();
		Aapp::route($_SERVER['REQUEST_URI']);
	}
	public static function AAloader($className) {
		switch ($className{0}) {
			case 'A':{
				//app实例核心类
				$inClass=[
					'aApp'=>'app',
					'aMod'=>'mod',
					'aCtr'=>'ctr',
					'aTpl'=>'tpl',
					'aFun'=>'fun',
				];
				if(isset($inClass[$className])) {
					include AA_APP_ROOT.'core/'.$inClass[$className].'.php';
				}
				break;
			}
			case 'B':{
				//框架核心类
				$inClass=[
					'bApp'=>'core/app',
					'bMod'=>'core/mod',
					'bCtr'=>'core/ctr',
					'bFun'=>'web/fun',
					'bTpl'=>'web/tpl',
				];
				if(isset($inClass[$className])) {
					include AA_ROOT.'/'.$inClass[$className].'.php';
				}
				break;
			}
			case 'C':{
				//应用控制器
				include AA_APP_ROOT.'ctr/'.Aapp::$ctrSubDir.strtolower(substr($className,1)).'.php';
				break;
			}
			case 'M':{
				//应用数据模型
				include AA_APP_ROOT.'mod/'.substr($className,1).'.php';
				break;
			}
		}
	}
}