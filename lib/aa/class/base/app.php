<?php

class bApp {
	public static $httpClass='bHttp';		//基础类名，可继承扩展
	public static $ctrClass='bCtr';			//基础类名，可继承扩展
	public static $tplClass='bTpl';			//基础类名，可继承扩展
	public static $errorClass='bError';	//基础类名，可继承扩展
	public static $funClass='bFun';	//基础类名，可继承扩展
	public static $userClass='bUser';

	public const prefixDir='';		//ctr绝对子目录名
	public const ctrTable=[];		//控制器表
	public const name='AA模板系统';	//网站名
	public static $config;			//配置信息
	public static $ctrName;			//控制器
	public static $fullCtr;			//控制器（含命名空间）
	public static $actName;			//动作名
	public static $ctrDir;			//动作目录
	public static $echo;				//输出字符
	public static $user=[];				//访问者信息

	public static function getConfig($item) {
		return static::$config[$item];
	}
	public static function cliRoute($cmd) {
		echo $cmd;//TODO 后续完善
	}
	public static function webRoute($reqUri,$configFile) {
		aApp::$config=include $configFile;
		$subDir=$ctrNameSpace='';
		$ctr='cIndex';
		$act='index';
		$actParam=[];
		$tmp=explode('?',$reqUri,2);
		if(aApp::$ctrClass::prefixDir) {
			$tmp=explode(aApp::$ctrClass::prefixDir,$tmp[0],2);
			if (isset($tmp[1]))	$tmp[0]=$tmp[1];
		}
		$tmp=explode('/',$tmp[0]);
		unset($tmp[0]);
		$errorCode=0;
		$acl=0;
		//$userLevel=static::$user['level']??static::$user['level']??0; //0=默认匿名 1 2 3 4 高更层级
		$node=0; // 0=root,1=dir,2=ctr,3=act,4=param
		$ctrTable=aApp::$ctrClass::ctrTable;
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
						if (isset($ctrTable[$val])) {
							if ($ctrTable[$val]>0) {
								$acl=1;
								break;
							}
						} else {
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
		aApp::$ctrDir=$subDir;
		if (isset($ctrTable[''])) {
		if ((1==$node && $ctrTable['']>0) || $acl) {
			aApp::$userClass::checkUserLogin();
			if (empty(aApp::$user['level']) || $ctrTable['']>aApp::$user['level']) $errorCode=403;
			if(aCtr::$aclClass::acl($subDir.$ctr.':'.$act)) $errorCode=403;
		} } else $errorCode=403;

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
		if($errorCode) {
			aApp::$httpClass::error([$errorCode,$ctrError]);
		} else {
			aApp::$ctrName=$ctr;
			aApp::$fullCtr=$subDir.$ctrFullName;
			aApp::$actName=$act;
			try {
				aApp::$ctrClass::startCatchEcho();
				$ctr::onLoad();
				$ctr::$act($actParam);
				$ctr::onEnd();
				aApp::$ctrClass::endCatchEcho();
				if (aApp::$tplClass::$autoTpl) {
					aApp::$tplClass::show();
				}
			} catch (bError $error) {
				aApp::$ctrClass::cleanCatch();
				aApp::$tplClass::$tplFile=AA_ROOT.'../buildin/sys/tpl/error';
				aApp::$tplClass::put(['error'=>$error]);
				if (aApp::$tplClass::$autoTpl) {
					aApp::$tplClass::show();
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