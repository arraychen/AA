<?php

function e($str) {	echo $str;}
function ek($key) {	if (isset(bTpl::$data[$key])) echo bTpl::$data[$key];}
function eb($key) {	if (isset(bTpl::$block[$key])) echo bTpl::$block[$key];}
function gk($key,$type='s') {
	if (isset(bTpl::$data[$key])) return bTpl::$data[$key];
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
	public static $tplName='';
	public static $data=[];
	public static $block=[];
		public static function setData($data=[],$tplName='') {
		static::$data=$data;
			static::$tplName=$tplName;
	}
	public static function show() {
		if(static::$tplName) {
			$bTplFile=APP_ROOT.'web/tpl/page/'.strtolower(bApp::$ctrDir.static::$tplName).'.html';
		} else {
			$bTplFile=APP_ROOT.'web/tpl/auto/'.strtolower(bApp::$ctrDir.bApp::$CTR.'_'.bApp::$ACT).'.html';
		}
		if(file_exists($bTplFile)) {
			if (self::$layout) {
				ob_start();
				include $bTplFile;
				$main=ob_get_clean();
				include APP_ROOT.'web/tpl/layout/'.self::$layout.'.html';
			} else include $bTplFile;
		} else {
			bHttp::error(['404','tpl('.$bTplFile.') not found']);
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
