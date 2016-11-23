<?php

class bApp {
	public static $CTR;
	public static $ctrDir='';
	public static $ACT;
	public static $USER;
	public static $ctrTable;
	public static function set() {
	}
	public static function check() {

	}
	public function user() {
		return ['id'=>1,'name'=>'user','groupId'=>1,];
	}

	public static function route($reqUri) {
		$tmp=explode('?',$reqUri,2);
		$subDir='';
		$ctrNameSpace='';
		$ctr='cIndex';
		$act='index';
		$actParam=[];
		if (isset($tmp[0])) {
			$ctrTable=static::$ctrTable;
			$tmp=explode('/',$tmp[0]);
			unset($tmp[0]);
			$node=0; // 0=start,1=dir,2=ctr,3=act,4=param

			foreach ($tmp as $val) {
				if (!$val) continue;
				if ($node==4) {
					$actParam[]=$val;
				} else {
					if (isset($ctrTable[$val])) {
						if (is_array($ctrTable[$val])) {
							$subDir.=$val.'/';
							$ctrNameSpace.=$val.'\\';
							$ctrTable=$ctrTable[$val];
							$act='httpCode';
							$node=1;
						} else {
							$ctr='c'.$val;
							$node=3;
						}
					} else {
						if (3==$node) {
							$act='a'.$val;
							$node=4;
						} else {
							$subDir=$ctrNameSpace='';
							$act='httpCode';
							$actParam[0]='404';
							break;
						}
					}
				}
			}
		}
		if($node==1) { //直接目录目录不存在
			$subDir=$ctrNameSpace='';
			$actParam=['404','ctr not found'];
		}

    $ctrFullName=$ctrNameSpace.$ctr;

		if (!class_exists($ctrFullName) || !method_exists($ctrFullName,$act)) {
      $ctrFullName='cIndex';
			$act='httpCode';
			$subDir='';
			$actParam=array('404','action not found');
		}

		echo '[route:dir=',$subDir,' namespace=',$ctrNameSpace,' ctrname=',$ctr,' call=',$ctrFullName,'::',$act,' parm=',join('|',$actParam),']',PHP_EOL;

		static::$CTR=$ctrFullName;
		static::$ctrDir=$subDir;
		static::$ACT=$act;
		$ctrFullName::$act($actParam);
	}
}