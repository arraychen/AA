<?php

class bData {
	private static $allModInstance;
	public static $allConnect;
	public $driver;   //驱动器名称
	public $serverTag;//数据库标签
	public $dbo;      //数据接口对象
	public $count;    //计数
	public $set;      //数据集
	public $page;   	//页数
	public $offset;   	//偏移量
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
			$this->connect($serverTag);
	}
	public function connect($serverTag) {  //选择服务器
		$dataConfig=bApp::getConfig('data');
		if (!$serverTag) {
			$key=each($dataConfig);
			$serverTag=$key[0];
		}
		$this->dbo=self::connectServer($serverTag,$dataConfig[$serverTag]);
	}
	public function getRaw($Parm) { //获取原始数据
		return $this->dbo->select($Parm);
	}
	public function put($data,$cond=NULL) { //保存数据
		if (is_null($cond)) {
			$this->dbo->update($data);
		} else {
			$this->dbo->insert($data);
		}
	}
	public function del($cond) { //删除数据
		$this->dbo->delete($cond);
	}
}