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
	public static $tplFile='';//常变
	public static $tplName='';//常变
	public static $data=[]; //必须通过方法设置
	public static $block=[];
	public static $nav=[]; //导航数组
	public static function put($data,$tplName='') {
		static::$data=$data+static::$data;
		if($tplName)	static::$tplName=$tplName;
	}
	public static function show() {
		if (static::$tplFile) static::$tplFile.='.html';
		else {
			if(static::$tplName) {
				 static::$tplFile=APP_ROOT.'web/tpl/page/'.strtolower(bApp::$ctrDir.static::$tplName).'.html';
			} else {
				 static::$tplFile=APP_ROOT.'web/tpl/auto/'.strtolower(bApp::$ctrDir.bApp::$ctrName.'_'.bApp::$actName).'.html';
			}
		}
		if(file_exists( static::$tplFile)) {
			if (static::$layout) {
				foreach (static::$data as $dataKey=>$dataVal) {
					$$dataKey=$dataVal;
				}
				foreach (static::$block as $BlockKey=>$AATplBlockName) {
					if(file_exists( APP_ROOT.'web/tpl/block/'.$AATplBlockName.'.html')) {
					ob_start();
					include APP_ROOT.'web/tpl/block/'.$AATplBlockName.'.html';
					${ucfirst($BlockKey)}=ob_get_clean();
					}
				}
				ob_start();
				include static::$tplFile;
				$MAIN=ob_get_clean();
				include APP_ROOT.'web/tpl/layout/'.static::$layout.'.html';
			} else include static::$tplFile;
		} else {
			aApp::$httpClass::error(['404','tpl('.static::$tplFile.') not found']);
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
