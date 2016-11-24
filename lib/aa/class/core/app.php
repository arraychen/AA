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
		return ['level'=>0,'name'=>'user','group'=>'web',];
	}

	public static function route($reqUri) {
		$subDir=$ctrNameSpace='';
		$ctr='cIndex';
		$act='index';
		$actParam=[];
		$error=1;
		$tmp=explode('?',$reqUri,2);
		if (isset($tmp[0])) {
			$ctrTable=static::$ctrTable;
			$tmp=explode('/',$tmp[0]);
			unset($tmp[0]);
			$node=0; // 0=root,1=dir,2=ctr,3=act,4=param

			foreach ($tmp as $val) {
				if (!$val) continue;
				if (3==$node){
					$act='a'.$val;
					$node=4;
				} elseif (4==$node) {
					$actParam[]=$val;
				} else {
					if (isset($ctrTable[$val])) {
						if (is_array($ctrTable[$val])) {
							$subDir.=$val.'/';
							$ctrNameSpace.=$val.'\\';
							$ctrTable=$ctrTable[$val];
							$node=1;
						} else {
							//$ctr='c'.$val;
							$act='index';
							$node=3;
							$error=0;
						}
					} else {
						break;
					}
				}
			}
		}
		$ctrFullName=$ctrNameSpace.$ctr;
		echo '[route:dir="',$subDir,'" ctr="',$ctr,'" call="',$ctrFullName,'::',$act,'(',join(',',$actParam),')"]',PHP_EOL;
		if($error) {
			if (0==$node) {
				$str=$ctrFullName.' no in ctr table';
			} elseif(1==$node) { //目录不存在
				$str='request a dir :'.$subDir.' no ctr';
			} else {
				if (!class_exists($ctrFullName) || !method_exists($ctrFullName,$act)) {
					$str='class or action '.$ctrFullName.'::'.$act.'() not found';
				}
			}
			bHttp::error(['404',$str]);
		} else {
			static::$CTR=$ctrFullName;
			static::$ctrDir=$subDir;
			static::$ACT=$act;
			$ctrFullName::$act($actParam);
		}
	}
}