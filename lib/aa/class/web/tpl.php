<?php
class bTpl {
	public static $layout;
	public static $blockData;
	public static $layoutData;
	public static function show($data,$tplName='') {
		if($tplName) {
			$tplFile=AA_APP_ROOT.'web/tpl/page/'.bApp::$ctrDir.$tplName.'.html';
		} else {
			$tplFile=AA_APP_ROOT.'web/tpl/auto/'.bApp::$ctrDir.bApp::$ACT.'.html';
		}
		if(file_exists($tplFile)) {
			include $tplFile;
		} else {
			bHttp::error(['404',$tplFile.' not found']);
		}
	}
	public static function layout($data) {
		bFun::printR($data);
	}
}