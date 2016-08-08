<?php

class Cindex extends Actr {
	public static function index() {
		$fiels=Muser::fields();
		print_r($fiels);
	}
}