<?php
class mUser extends bData {
	//public static $dataName='adminW';
	public $table='user';
	public static function field() {
		return [
			'id'=>[],
			'name'=>[],
			'age'=>[],
		];
	}
}