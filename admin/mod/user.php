<?php
class mUser extends bMod {
	public static $setDefautDatai='mysqli';
	public static function field() {
		return [
			'id'=>[],
			'name'=>[],
			'age'=>[],
		];
	}
}