<?php

class bData {
	private static $allModInstance;
	private static $allConnect;
	protected $driver;	//数据接口驱动器对象
	public $serverTag;	//数据库标签
	public $page;				//页数
	public $limit;			//每页数量
	public $offset;			//偏移量
	public static function mod($serverTag='') {
		$className=get_called_class();
		if (empty(self::$allModInstance[$className][$serverTag])) {
			$obj=new $className;
			$obj->connect($serverTag);
			self::$allModInstance[$className][$serverTag]=$obj;
			return $obj;
		} else {
			return self::$allModInstance[$className][$serverTag];
		}
	}
	public static function closeConnect($serverTag='') {
		if (!empty(self::$allConnect)) {
			if ($serverTag) {
				self::$allConnect[$serverTag]->close();
			} else {
				foreach (self::$allConnect as $val) {
					$val->dbi->close();
				}
			}
		}
	}
	public function __construct($serverTag='') {
			$this->connect($serverTag);
	}
	public function connect($serverTag) {  //连接服务器
		$dataConfig=bApp::getConfig('data');
		if (!$serverTag) {//如果空则取第一个配置信息
			$key=each($dataConfig);
			$serverTag=$key[0];
		}
		//bFun::printR($dataConfig);die;
		if (empty(self::$allConnect[$serverTag])) {
			$className='d'.$dataConfig[$serverTag][0];
			$obj=new $className($dataConfig[$serverTag][1]);
			self::$allConnect[$serverTag]=$obj;
			$this->driver=$obj;
		} else {
			$this->driver=self::$allConnect[$serverTag];
		}
	}

	public function get($Parm=[]) {
		if (is_array($Parm)) {
			$cond['where']=$Parm;
		} else
			$cond['where']=[static::key=>$Parm];
		return $this->driver->get(static::table,$cond);
	}
	public function add($Data) {
		return $this->driver->add(static::table,$Data);
	}
	public function put($Data,$Cond='') {
		if (!$Cond) {
			if (isset($Data[static::key])) {
				$Cond=static::key.'="'.$Data[static::key].'"';
			} else {
				return $this->driver->add(static::table,$Data);
			}
		}
		return $this->driver->put(static::table,$Data,$Cond);
	}
	public function del($Cond) {
		return $this->driver->del(static::table,$Cond);
	}
	public function load($Cond) {
		return $this->driver->load($Cond);
	}
}

class bSql {
	public $dbi; 					//数据库接口对象或资源
	public $dataBase;			//数据库名称
	public $table;				//数据表名称
	public $autoId;   		//自增ID
	public $affectedRow=0;	//影响的行数
	public $total=0;			//总记录数
	public $limit=20;			//每页最大行数
	public $page=0;				//页数
	public $offset=0;			//偏移
	public function __construct($config) {
		$this->connect($config);
	}
	public function get($table,$cond) {
	}
	public function add($table,$data) {
	}
	public function put($Table,$Data,$Where) {
	}
	public function del($table,$data) {
	}
	public function load($Cond) {
		return true;
	}
	public function query($sql) {
	}
}
class bNosql {
	public $dbi; 					//数据库接口对象或资源
	public $dataBase;			//数据库名称
	public $table;    		//数据表名称
	public $autoId;   		//自增ID
	public $affectedRow;	//影响的行数
	public $total;				//总记录数
	public $limit;   			//最大行数
	public $offset;   		//偏移
	public function __construct($config) {
		$this->connect($config);
	}
	public function get($table,$data) {
	}
	public function put($table,$data) {
	}
	public function del($table,$data) {
	}
}
class bCache {
	public $dbi; 					//数据库接口对象或资源
	public $dataBase;			//数据库名称
	public $table;    		//数据表名称
	public $autoId;   		//自增ID
	public $affectedRow;	//影响的行数
	public $total;				//总记录数
	public $limit;   			//最大行数
	public $offset;   		//偏移
	public function __construct($config) {
		$this->connect($config);
	}
	public function get($table,$data) {
	}
	public function put($table,$data) {
	}
	public function del($table,$data) {
	}
}
class bDict {
	public function __construct($config) {
		$this->connect($config);
	}
	public function get($table,$data) {
	}
	public function put($table,$data) {
	}
	public function del($table,$data) {
	}
}