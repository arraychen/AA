<?php

class cIndex extends aCtr {
	public static function index() {
		//aTpl::$autoTpl=1;
		aTpl::show();
	}
	public static function aTest() {
		echo 'test';
	}
}