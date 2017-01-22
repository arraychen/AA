<?php

class AWeb {
	public static function run($appDir,$configFile='') {
		define('AA_ROOT',__DIR__.'/class');
		define('AA_APP_ROOT',$appDir.'/');
		if ($configFile) {
			define('AA_CONF_FILE',$configFile);
		} else {
			define('AA_CONF_FILE',$appDir.'/config.php');
		}
		spl_autoload_register(array('AWeb','AAloader'));
		bApp::loadConfig();
		bApp::webRoute($_SERVER['REQUEST_URI']);
	}
	public static function AAloader($className) {
    $nameSpace=explode('\\',$className);
    $className=strtolower(array_pop($nameSpace));
    switch ($className{0}) {
			case 'a':{
				//app实例核心类
				//include AA_APP_ROOT.'core/'.substr($className,1).'.php';
				include AA_APP_ROOT.'core/aweb.php';
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
					include AA_ROOT.'/'.$inClass[$className].'.php';
				}
				break;
			}
			case 'c':{
				//应用控制器
				if ($nameSpace) {
					$nameSpace=strtolower(join('/',$nameSpace)).'/';
				} else $nameSpace='';
				include AA_APP_ROOT.'web/ctr/'.$nameSpace.substr($className,1).'.php';
				break;
			}
			case 'd':{
				//数据库类型
				include AA_ROOT.'/data/'.substr($className,1).'.php';
				break;
			}
			case 'm':{
				//应用数据模型
				include AA_APP_ROOT.'mod/'.substr($className,1).'.php';
				break;
			}
	    default: {
		    require AA_APP_ROOT.'core/'.$className.'.php';
	    }
		}
	}
}