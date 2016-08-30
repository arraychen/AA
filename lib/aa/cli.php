<?php
class AC {
	public static function init($appDir,$configFile)
	{
		define('AA_ROOT',__DIR__);
		define('AA_APP_ROOT',$appDir);
		define('AA_CONF_ROOT',$configFile);
	}
	public static function run() {
		self::set();
	}

	public static function set() {
		spl_autoload_register(array('AA','loader'));
	}
	public static function check() {

	}
	public static function loader($className) {
		$inClass=[
			'AApp'=>'core/app.php',
			'Amod'=>'core/mod.php',
		];
		// use include so that the error PHP file may appear
		if(isset($inClass[$className])) {
			require(AA_ROOT.$inClass[$className]);
		} else {
			require(AA_APP_ROOT.$className.'.php');
		}
	}
}