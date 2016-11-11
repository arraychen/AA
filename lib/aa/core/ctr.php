<?php
class bCtr {
	public static function before() {

	}
	public static function after() {

	}
	public static function auth() {

	}
	public static function httpCode($code) {
		$htmlData=[
			'tile'=>'http:',
			'header'=>'Status Code: '.$code[0],
			'body'=>'page:'.$code[0],
		];
		aTpl::show($htmlData);
	}
}