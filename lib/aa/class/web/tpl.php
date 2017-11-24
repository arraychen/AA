<?php

function e($s) {	echo $s;}
function ek($k) {	echo aApp::$tplClass::$data[$k]??aApp::$tplClass::$data[$k];}
function gk($k,$type='s') {
	if (isset(aApp::$tplClass::$data[$k])) return aApp::$tplClass::$data[$k];
	else {
		if ('a'==$type)  return [];
		elseif ('o'==$type)  return new stdClass();
		else  return '';
	}
}
function obs() {ob_start();}
function obe($key) {aApp::$tplClass::$block[$key]=ob_get_clean();}
function obi($file,&$var) {
	ob_start();
	include $file;
	$var=ob_get_clean();
}

class bTpl {
	public static $layout='pc';//
	public static $type='html';//html, json, mobile, text
	protected static $tplFile='';//常变
	protected static $tplName='';//常变
	public static $data=[]; //必须通过方法设置
	public static $block=[];
	public static function put($data,$tplName='') {
		self::$data=$data+self::$data;
		if($tplName)	self::$tplName=$tplName;
	}
	public static function show() {
		if (self::$tplFile) self::$tplFile.='.html';
		else {
			if(self::$tplName) {
				 self::$tplFile=APP_ROOT.'web/tpl/page/'.strtolower(bApp::$ctrDir.self::$tplName).'.html';
			} else {
				 self::$tplFile=APP_ROOT.'web/tpl/auto/'.strtolower(bApp::$ctrDir.bApp::$ctrName.'_'.bApp::$actName).'.html';
			}
		}
		if(file_exists( self::$tplFile)) {
			if (self::$layout) {
				foreach (self::$data as $dataKey=>$dataVal) {
					$$dataKey=$dataVal;
				}
				foreach (self::$block as $BlockKey=>$AATplBlockName) {
					if(file_exists( APP_ROOT.'web/tpl/block/'.$AATplBlockName.'.html')) {
					ob_start();
					include APP_ROOT.'web/tpl/block/'.$AATplBlockName.'.html';
					${ucfirst($BlockKey)}=ob_get_clean();
					}
				}
				ob_start();
				include self::$tplFile;
				$MAIN=ob_get_clean();
				include APP_ROOT.'web/tpl/layout/'.self::$layout.'.html';
			} else include self::$tplFile;
		} else {
			aApp::$httpClass::error(['404','tpl('.self::$tplFile.') not found']);
		}
	}
	public static function layout($data) {
		aApp::$funClass::printR($data);
	}
	public static function echoArray($data) {
		if (!empty($data)) {
			foreach ($data as $key => $value) {
				echo $key,':',$value,PHP_EOL;
			}
		}
	}
	public static function tr($tpl,$data) {
		foreach ($data as $key =>$val) {
			if(is_array($val))	$tran['{'.$key.'}']=$val[1];
			else $tran['{'.$key.'}']=$val;
		}
		return strtr($tpl,$tran);
	}
}
