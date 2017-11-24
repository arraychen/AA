<?php

class bApp {
	public static $httpClass='bHttp';		//基础类名，可继承扩展
	public static $ctrClass='bCtr';			//基础类名，可继承扩展
	public static $tplClass='bTpl';			//基础类名，可继承扩展
	public static $errorClass='bError';	//基础类名，可继承扩展
	public static $funClass='bFun';	//基础类名，可继承扩展

	public const prefixDir='';		//ctr绝对子目录名
	public const ctrTable=[];		//控制器表
	public static $config;			//配置信息
	public static $ctrName;			//控制器
	public static $fullCtr;			//控制器（含命名空间）
	public static $actName;			//动作名
	public static $ctrDir;			//动作目录
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
		$errorCode=0;
		$userLevel=static::$user['level']??static::$user['level']??0; //0=默认匿名 1 2 3 4 高更层级
		$node=0; // 0=root,1=dir,2=ctr,3=act,4=param
		$ctrTable=static::ctrTable;
		foreach ($tmp as $val) {
			//if (strlen($val)<1) continue;
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
						if (strlen($val)>0) $ctr='c'.$val;
						$node=3;
						if (isset($ctrTable[$val]) && $ctrTable[$val]>$userLevel) {
							$errorCode=403;
							break;
						}
					}
				} else {
					if (strlen($val)>0) $act='a'.$val;
					break;
				}
			}
		}
		if (1==$node && isset($ctrTable['']) && $ctrTable['']>$userLevel) {
			$errorCode=403;
		}
		$ctrFullName=$ctr;
		//echo '[route:dir="',$subDir,'" ctr="',$ctr,'" call="',$ctrFullName,'::',$act,'(',join(',',$actParam),')"]<hr size=1>',PHP_EOL;

		if (403==$errorCode) {
			$ctrError='access denied';
		} else {
			if (!class_exists($ctrFullName) || !method_exists($ctrFullName,$act)) {
				$ctrError='class or action '.$ctrFullName.'::'.$act.'() not found';
				$errorCode=404;
			} else {
				$ctrError=NULL;
			}
		}
		if($ctrError) {
			static::$httpClass::error([$errorCode,$ctrError]);
		} else {
			static::$ctrDir=$subDir;
			static::$ctrName=$ctr;
			static::$fullCtr=$ctrFullName;
			static::$actName=$act;
			try {
				static::$ctrClass::startCatchEcho();
				$ctrFullName::onLoad();
				$ctrFullName::$act($actParam);
				$ctrFullName::onEnd();
				static::$ctrClass::endCatchEcho();
				if (static::$autoTpl) {
					static::$tplClass::show();
				}
			} catch (bError $error) {
				static::$ctrClass::cleanCatch();
				static::$tplClass::$tplFile=AA_ROOT.'../buildin/sys/tpl/error';
				static::$tplClass::put(['error'=>$error]);
				if (static::$autoTpl) {
					static::$tplClass::show();
				}
			}
		}
	}
}
class bError extends ErrorException {
	public $echo;
	public $env;
	public function setSeverity($id) {
		$this->severity=$id;
	}
}