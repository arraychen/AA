<?php

class AA {
	public static function run($appDir,$configFile) {
		define('AA_ROOT',__DIR__.'/class');
		define('AA_APP_ROOT',$appDir.'/');
		define('AA_CONF_FILE',$configFile);
		spl_autoload_register(array('AA','AAloader'));
		aApp::set();
		aApp::check();
		aApp::route($_SERVER['REQUEST_URI']);
	}
	public static function AAloader($className) {
    $classArr=explode('\\',$className);
    $className=array_pop($classArr);
    $nameSpaceDir=join('/',$classArr).'/';
    switch ($className{0}) {
			case 'a':{
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
			case 'b':{
				//框架核心类
				$inClass=[
					'bApp'=>'core/app',
					'bMod'=>'core/mod',
					'bCtr'=>'core/ctr',
					'bFun'=>'core/fun',
					'bTpl'=>'web/tpl',
				];
				if(isset($inClass[$className])) {
					include AA_ROOT.'/'.$inClass[$className].'.php';
				}
				break;
			}
			case 'c':{
				//应用控制器
				include AA_APP_ROOT.'ctr/'.$nameSpaceDir.strtolower(substr($className,1)).'.php';
				break;
			}
			case 'm':{
				//应用数据模型
				include AA_APP_ROOT.'mod/'.substr($className,1).'.php';
				break;
			}
		}
	}
}