<?php
class mUser extends bData {
	public static $datai='mysqli';
	public static $table='user';
	public static function field() {
		return [
			'id'=>[],
			'name'=>[],
			'age'=>[],
		];
	}
}