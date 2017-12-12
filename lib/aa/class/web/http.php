<?php
class bHttp {
	public static function error($data) {
		//$data=['code'=>'404','desc'=>'page not found']
		header('HTTP/1.0 '.$data[0].' '.$data[1]);
	  bFun::varDump($data);

		//TODO http header
		//body
	}
}