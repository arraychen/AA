<?php

class Cindex extends Actrl {
	public static function index() {
		$fiels=Muser::fields();
		print_r($fiels);
	}
}