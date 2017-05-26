<?php
class mUser extends bData {
	//public static $dataName='adminW';
	public $table='user';
	public $key='id';
	public static function field() {
		return [
			'id'=>[],
			'name'=>[],
			'age'=>[],
		];
	}
}