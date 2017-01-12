<?php

function ek($key) {
	if (isset(bTpl::$data[$key])) echo bTpl::$data[$key];
}
function gk($key) {
	if (isset(bTpl::$data[$key])) return bTpl::$data[$key];
	else return [];
}
function e($str) {
	echo $str;
}
function obs() {ob_start();}
function obe() {
	$str=ob_get_contents();
	ob_end_clean();
	return $str;
}

class bTpl {
	public static $layout='';
	public static $tplName='';
	public static $data=[];
		public static function setData($data=[],$tplName='') {
		static::$data=$data;
			static::$tplName=$tplName;
	}
	public static function show() {
		if(static::$tplName) {
			$bTplFile=AA_APP_ROOT.'web/tpl/page/'.bApp::$ctrDir.static::$tplName.'.html';
		} else {
			$bTplFile=AA_APP_ROOT.'web/tpl/auto/'.bApp::$ctrDir.bApp::$ACT.'.html';
		}
		if(file_exists($bTplFile)) {
			if (self::$layout) {
				obs();
				include $bTplFile;
				$main=obe();
				include AA_APP_ROOT.'web/tpl/layout/'.self::$layout.'.html';
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

			}
		}
	}
}
