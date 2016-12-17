<?php

class bApp {
	public static $CTR;
	public static $ctrDir='';
	public static $ACT;
	public static $USER;
	public static $ctrTable;
	public static function iniset() {
	}
	public static function cliRoute($cmd) {
		echo $cmd;//TODO 后续完善
	}
	public static function webRoute($reqUri) {
		$subDir=$ctrNameSpace='';
		$ctr='cIndex';
		$act='index';
		$actParam=[];
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
							//进入目录
							$ctrTable=$ctrTable[$val];
							$subDir.=$val.'/';
							$ctrNameSpace.=$val.'\\';
							$node=1;
						} else {
							//判定是ctr
							$ctr='c'.$val;
							$node=3;
						}
					} else {
						$act='a'.$val;
						break;
					}
				}
			}
		}
		$ctrFullName=$ctrNameSpace.$ctr;
		echo '[route:dir="',$subDir,'" ctr="',$ctr,'" call="',$ctrFullName,'::',$act,'(',join(',',$actParam),')"]<hr>',PHP_EOL;

		if (!class_exists($ctrFullName) || !method_exists($ctrFullName,$act)) {
			$error='class or action '.$ctrFullName.'::'.$act.'() not found';
		} else {
			$error='';
		}

		if($error) {
			bHttp::error(['404',$error]);
		} else {
			static::$ctrDir=$subDir;
			static::$CTR=$ctrFullName;
			static::$ACT=$act;
			$ctrFullName::startCatchEcho();
			$ctrFullName::onLoad();
			$ctrFullName::$act($actParam);
			$ctrFullName::onEnd();
			$ctrFullName::endCatchEcho();
			bTpl::show($ctrFullName::getCtrEcho());
		}
	}
}