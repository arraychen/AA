<?php

class Cuser extends Actr {
	public static function index() {
		$fiels=Muser::fields();
		print_r($fiels);
	}
	public static function Alogin() {
		echo 'login';
	}
}