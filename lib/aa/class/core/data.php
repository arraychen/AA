<?php
class bData {
	private static $allModInstance;
	public static $allConnect;
	public $driver;   //array 驱动器配置信息
	public $serverTag;//数据库标签
	public $dbo;      //数据接口对象
	public $count;    //计数
	public $set;      //数据集
	public $autoId;   //自增长ID
	public $pkey;   	//主键
	public $page;   	//主键
	public $offset;   	//偏移
	public static function mod($serverTag='') {
		$className=get_called_class();
		if (empty(self::$allModInstance[$className][$serverTag])) {
			$obj=new $className;
			$obj->select($serverTag);
			self::$allModInstance[$className][$serverTag]=$obj;
			return $obj;
		} else {
			return self::$allModInstance[$className][$serverTag];
		}
	}
	public static function connectServer($serverTag,$dataConfig) {
		if (empty(self::$allConnect[$serverTag])) {
			$className='d'.$dataConfig[0];
			$obj=new $className($dataConfig[1]);
			self::$allConnect[$serverTag]=$obj;
			return $obj;
		} else {
			return self::$allConnect[$serverTag];
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
			$this->select($serverTag);
	}
	public function select($serverTag) {  //选择服务器
		$dataConfig=bApp::getConfig('data');
		if (!$serverTag) {
			$key=each($dataConfig);
			$serverTag=$key[0];
		}
		$this->dbo=self::connectServer($serverTag,$dataConfig[$serverTag]);
	}

	public function get($Parm) { //获取数据
		return $this->dbo->select($Parm);
	}
	public function put() { //保存数据

	}
	public function del() { //删除数据

	}
}