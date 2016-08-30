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
				$inClass=[
					'Aapp'=>'app',
					'Amod'=>'mod',
					'Actr'=>'ctr',
					'Atpl'=>'tpl',
					'Afun'=>'fun',
				];
				if(isset($inClass[$className])) {
					include AA_APP_ROOT.'core/'.$inClass[$className].'.php';
				}
				break;
			}
			case 'B':{
				$inClass=[
					'Bapp'=>'core/app',
					'Bmod'=>'core/mod',
					'Bctr'=>'core/ctr',
					'Bfun'=>'web/fun',
					'Btpl'=>'web/tpl',
				];
				if(isset($inClass[$className])) {
					include AA_ROOT.'/'.$inClass[$className].'.php';
				}
				break;
			}
			case 'C':{
				include AA_APP_ROOT.'ctr/'.Aapp::$ctrSubDir.substr($className,1).'.php';
				break;
			}
			case 'M':{
				include AA_APP_ROOT.'mod/'.substr($className,1).'.php';
				break;
			}
		}
	}
}