<?php

function e($s) {	echo $s;}
function ek($k) {	if (isset(bTpl::$data[$k])) echo bTpl::$data[$k];}
function eb($k) {	if (isset(bTpl::$block[$k])) echo bTpl::$block[$k];}
function gk($k,$type='s') {
	if (isset(bTpl::$data[$k])) return bTpl::$data[$k];
	else {
		if ('a'==$type)  return [];
		elseif ('o'==$type)  return new stdClass();
		else  return '';
	}
}
function obs() {ob_start();}
function obe($key) {bTpl::$block[$key]=ob_get_clean();}
function obi($file,&$var) {
	ob_start();
	include $file;
	$var=ob_get_clean();
}

class bTpl {
	public static $layout='';
	public static $tplFile='';
	public static $tplName='';
	public static $type='html';//html, json, mobile, text
	public static $data=[];
	public static $block=[];
	public static function set($data,$tplName='') {
		static::$data=$data+static::$data;
		if($tplName)	static::$tplName=$tplName;
	}
	public static function show() {
		$tplDir=APP_ROOT.'web/tpl/';
		if (static::$tplFile) $tplFile=static::$tplFile.'.html';
		else {
			if(static::$tplName) {
				$tplFile=$tplDir.'page/'.strtolower(bApp::$ctrDir.static::$tplName).'.html';
			} else {
				$tplFile=$tplDir.'auto/'.strtolower(bApp::$ctrDir.bApp::$CTR.'_'.bApp::$ACT).'.html';
			}
		}
		if(file_exists($tplFile)) {
			if (static::$layout) {
				ob_start();
				include $tplFile;
				$main=ob_get_clean();
				include $tplDir.'layout/'.static::$layout.'.html';
			} else include $tplFile;
		} else {
			bHttp::error(['404','tpl('.$tplFile.') not found']);
		}
	}
	public static function layout($data) {
		bFun::printR($data);
	}
	public static function echoArray($data) {
		if (empty($data)) echo '';
		else {
			foreach ($data as $key => $value) {
				echo $key,':',$value,PHP_EOL;
			}
		}
	}
}
