<?php
class bTpl {
	public static $layout;
	public static $data;
	public static function show($data) {
	  echo $data;
	}
	public static function layout($data) {
		bFun::printR($data);
	}

}