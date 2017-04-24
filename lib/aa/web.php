<?php

class AWeb {
	public static function run($appDir,$configFile='') {
		define('AA_ROOT',__DIR__.'/class/');
		define('APP_ROOT',$appDir.'/');
		if (!$configFile) {
			$configFile=$appDir.'/config.php';
		}
		spl_autoload_register(array('AWeb','AAloader'));
		include APP_ROOT.'core/init.php';
		bApp::loadConfig($configFile);
		bApp::webRoute($_SERVER['REQUEST_URI']);
	}
	public static function AAloader($className) {
    $nameSpace=explode('\\',$className);
    $className=strtolower(array_pop($nameSpace));
    switch ($className{0}) {
			case 'a':{
				//app-web实例初始化
				include APP_ROOT.'core/'.substr($className,1).'.php';
				//include APP_ROOT.'core/init.php';
				break;
			}
			case 'b':{
				//框架核心类
				$inClass=[
					'bapp'=>'core/app',
					'bmod'=>'core/mod',
					'bdata'=>'core/data',
					'bsql'=>'core/sql',
					'bcache'=>'core/cache',
					'bfun'=>'core/fun',
					'bctr'=>'web/ctr',
					'btpl'=>'web/tpl',
					'bhttp'=>'web/http',
				];
				if(isset($inClass[$className])) {
					include AA_ROOT.$inClass[$className].'.php';
				}
				break;
			}
			case 'c':{
				//应用控制器
				if ($nameSpace) {
					$nameSpace=strtolower(join('/',$nameSpace)).'/';
				} else $nameSpace='';
				include APP_ROOT.'web/ctr/'.$nameSpace.substr($className,1).'.php';
				break;
			}
			case 'd':{
				//数据库类型
				include AA_ROOT.'data/'.substr($className,1).'.php';
				break;
			}
			case 'm':{
				//应用数据模型
				include APP_ROOT.'mod/'.substr($className,1).'.php';
				break;
			}
	    default: {
		    require APP_ROOT.'core/'.$className.'.php';
	    }
		}
	}
}