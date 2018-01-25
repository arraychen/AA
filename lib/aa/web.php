<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-12-21
 * Time: 16:16
 */
class aWeb {
	public static function run($appDir,$configFile='') {
		define('AA_ROOT',__DIR__.'/class/');
		define('APP_ROOT',$appDir);
		if (!$configFile) $configFile=$appDir.'config.php';
		spl_autoload_register(array(__CLASS__,'AAloader'));
		include APP_ROOT.'base/init.php';
		aApp::webRoute($_SERVER['REQUEST_URI'],$configFile);
	}
	public static function AAloader($className) {
		$className=strtolower($className);
		switch ($className{0}) {
			case 'a':{
				//app-web实例初始化
				include APP_ROOT.'base/'.substr($className,1).'.php';
				//include APP_ROOT.'base/init.php';
				break;
			}
			case 'b':{
				//框架基础类
				$inClass=[
					'bapp'	=>'base/app',
					'bmod'	=>'base/mod',
					'bdata'	=>'base/data',
					'bsql'	=>'base/sql',
					'bcache'=>'base/cache',
					'bfun'	=>'base/fun',
					'bctr'	=>'web/ctr',
					'bacl'	=>'web/acl',
					'btpl'	=>'web/tpl',
					'buser'	=>'web/user',
					'bhttp'	=>'web/http',
					'blist'	=>'web/list',
					'bform'	=>'web/form',
				];
				if(isset($inClass[$className])) {
					include AA_ROOT.$inClass[$className].'.php';
				}
				break;
			}
			case 'c':{
				//应用控制器
				include APP_ROOT.'web/ctr/'.aApp::$ctrDir.substr($className,1).'.php';
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
				require APP_ROOT.'base/'.$className.'.php';
			}
		}
	}
}