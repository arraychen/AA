<?php
class bTpl {
	public static $layout;
	public static $data;
	public static function show($data) {
		
	  bFun::printR($data);
	}
	public static function layout($data) {
		bFun::printR($data);
	}

}