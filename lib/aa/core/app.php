<?php

class Bapp {
	public static $CTR;
	public static $ctrSubDir;
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
	/**
	 * @param $reqUri
	 */
	public static function route($reqUri) {
		$tmp=explode('?',$reqUri,2);
		$subDir='';
		$ctr='Cindex';
		$act='index';
		$actParam=[];
		if (isset($tmp[0])) {
			$ctrTable=static::$ctrTable;
			$tmp=explode('/',$tmp[0]);
			unset($tmp[0]);
			$node=0;
			// 0=root,1=dir,2=ctr,3=act,4=param
			foreach ($tmp as $val) {
				if ($node==3) {
					$actParam[]=$val;
				}
				else {
					if (isset($ctrTable[$val])) {
						if (is_array($ctrTable[$val])) {
							$subDir.=$val.'/';
							$ctrTable=$ctrTable[$val];
							$node=1;
						}
						else {
							$ctr='C'.$val;
							$node=2;
						}
					}
					else {
						if (1==$node) {
							if ($val) {
								$subDir='';
								$act='httpCode';
								$actParam[0]='404';
							}
							break;
						}
						elseif (2==$node) {
							if ($val)
								$act='A'.$val;
							$node=3;
						}
						else {
							$subDir='';
							if ($val) {
								$act='httpCode';
								$actParam[0]='404';
							}
							break;
						}
					}
				}
			}
		}
		echo 'route:',$subDir.$ctr,'->',$act,PHP_EOL;
		static::$ctrSubDir=$subDir;
		if (class_exists($ctr)&&method_exists($ctr,$act)) {
		}
		else {
			$ctr='Cindex';
			$act='httpCode';
			$actParam[0]='404';
		}
		static::$CTR=$ctr;
		static::$ACT=$act;
		$ctr::$act($actParam);
	}
}