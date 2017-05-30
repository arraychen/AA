<?php

class bApp {
	public const prefixDir='';		//ctr相对目录
	public const ctrTable=[];		//控制器表
	public static $config;			//配置信息
	public static $CTR;					//控制器
	public static $fullCtr;			//控制器（含命名空间）
	public static $ACT;					//动作名
	public static $ctrDir;			//动作名
	public static $echo;				//输出字符
	public static $user;				//用户信息
	public static $autoTpl=1;		//模板是否自动加载

	public static function getConfig($item) {
		return static::$config[$item];
	}
	public static function cliRoute($cmd) {
		echo $cmd;//TODO 后续完善
	}
	public static function webRoute($reqUri,$configFile) {
		static::$config=include $configFile;
		$subDir=$ctrNameSpace='';
		$ctr='cIndex';
		$act='index';
		$actParam=[];
		$tmp=explode('?',$reqUri,2);
		if(static::prefixDir) {
			$tmp=explode(static::prefixDir,$tmp[0],2);
			if (isset($tmp[1]))	$tmp[0]=$tmp[1];
		}
		$tmp=explode('/',$tmp[0]);
		unset($tmp[0]);
		$node=0; // 0=root,1=dir,2=ctr,3=act,4=param
		$ctrTable=static::ctrTable;
		foreach ($tmp as $val) {
			if (!$val) continue;
			if (3==$node) {
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
		$ctrFullName=$ctrNameSpace.$ctr;
		//echo '[route:dir="',$subDir,'" ctr="',$ctr,'" call="',$ctrFullName,'::',$act,'(',join(',',$actParam),')"]<hr size=1>',PHP_EOL;

		if (!class_exists($ctrFullName) || !method_exists($ctrFullName,$act)) {
			$error='class or action '.$ctrFullName.'::'.$act.'() not found';
		} else {
			$error='';
		}
		if($error) {
			bHttp::error(['404',$error]);
		} else {
			static::$ctrDir=$subDir;
			static::$CTR=$ctr;
			static::$fullCtr=$ctrFullName;
			static::$ACT=$act;
			bCtr::startCatchEcho();
			$ctrFullName::onLoad();
			$ctrFullName::$act($actParam);
			$ctrFullName::onEnd();
			bCtr::endCatchEcho();
			if (static::$autoTpl) {
				bTpl::show();
			}
		}
	}
}