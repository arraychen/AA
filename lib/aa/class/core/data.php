<?php
define('COL',1);//列名
define('NUM',2);//数字
define('STR',3);//字符
define('BIN',4);//二进制
define('EXP',5);//表达式
function bExp($tpl,$data=[]) {
	return new bExp($tpl,$data);
}
function bExc($col) {
	return new bExc($col);
}
class bData {
	private static $allModInstance;
	private static $allConnect;
	protected $driver;	//数据接口驱动器对象
	public $serverTag;	//数据库标签

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
		public function query($Tpl,$Bind) {
		return $this->driver->query($Tpl,$Bind);
	}
	public function get($Parm=[]) {
		return $this->driver->select(static::table,['where'=>$this->cond($Parm)]);
	}
	public function gets(array $Parm=[]) {
		if (isset($Parm['field'])) {
			$field=[];
			if (is_object($Parm['field'])) {
				if(get_class($Parm['field'])=='bExp')	$field[]=[EXP,$Parm['field']->tpl,$Parm['field']->data];
				else if(get_class($Parm['field'])=='bExc')	{
					foreach (static::field as $key=>$val) {
						if (!isset($Parm['field']->col[$key])) $field[]=[COL,$key];
					}
				}
			} elseif (is_array($Parm['field'])) {
				foreach ($Parm['field'] as $key=>$val) {
					if (is_object($val)) $field[]=[EXP,$val->tpl,$val->data];
					elseif (isset(static::field[$val])) $field[]=[COL,$val];
					elseif(isset(static::field[$key])) $field[]=[COL,$key,$val];
				}
			}
			$cond['field']=$field;
		}
		if (isset($Parm['where'])) $where=$Parm['where'];
		else $where=NULL;
		$cond['where']=$this->cond($where);
		$cond['key']=static::key;
		//bFun::printR($cond);
		return $this->driver->select(static::table,$cond);
	}
	public function add(array $Data) {
		$dataArr=[];
		foreach($Data as $key=>$val) {
			if (isset(static::field[$key])) {
				if (is_object($val)) {
					$dataArr[]=[EXP,$key,$val->tpl,$val->data];
				} else {
					$dataArr[]=[static::field[$key][0],$key,$val];
				}
			}
		}
		if ($dataArr)	return $this->driver->insert(static::table,$dataArr);
		else return false;
	}
	public function put(array $Data,$Cond=[]) {
		$dataArr=[];
		foreach ($Data as $key=>$val) {
			if(isset(static::field[$key])) {
				if (is_object($val)) {
					$dataArr[]=[EXP,$key,$val->tpl,$val->data];
				} else {
					$dataArr[]=[static::field[$key][0],$key,$val];
				}
			}
		}
		if($dataArr) {
			if ($Cond) {
				return $this->driver->update(static::table,$dataArr,$this->cond($Cond));
			} else {
				return $this->driver->insert(static::table,$dataArr);
			}
		} else return false;
	}
	public function del($Cond=[]) {
		return $this->driver->delete(static::table,$this->cond($Cond));
	}
	public function cond($Where=NULL) { //组建where条件
		$tmp=[];
		if (is_object($Where)) {
			$tmp[]=[EXP,$Where->tpl,$Where->data];
		} elseif (is_array($Where)) {
			foreach ($Where as $key=>$val) {
				if (is_object($val)) {
					$tmp[]=[EXP,$val->tpl,$val->data];
				} elseif (isset(static::field[$key])) {
					$tmp[]=[static::field[$key][0],$key,$val];
				} else
					$tmp[]=[static::field[static::key][0],static::key,$val];
			}
		} else if(!is_null($Where)) $tmp[]=[static::field[static::key][0],static::key,$Where];
		return $tmp;
	}
	public function offset( $offset,$limit=20) { //分页
		$this->driver->offset=(int)$offset;
		$this->driver->limit=(int)$limit;

	}

}
class bResult{
	public $page=0;			//页数
	public $total=0;		//总数
	public $limit=20;		//每页数量
	public $offset=0;			//偏移量
	public $data=[];			//数据
	public $count=0;			//数据总数
	public $affectedRow;	//返回数据
	public $autoId;				//自增编号
}
class bExp {
	//表达式类
	public $tpl;
	public $data;
	public function __construct(string $tpl,array $data=[]) {
		$this->tpl=$tpl;
		$this->data=$data;
	}
}
class bExc {
	//排除列
	public $col;
	public function __construct(array $col=[]) {
		$tmp=[];
		if (is_array($col)) {
			foreach ($col as $val) {
				$tmp[$val]=$val;
			}
		} else {
			$tmp[$val]=$val;
		}
		$this->col=$tmp;
	}
}
class bSql {
	public $dbi; 					//数据库接口对象或资源
	public $dataBase;			//数据库名称
	public $table;				//数据表名称
	public $limit=20;			//每页最大行数
	public $offset=0;			//偏移
	public $result;
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