<?php
class Bapp {
	public static $ctrTable,$ctrRule;
	public function user() {
		return [
			'id'	=>1,
			'name'=>'user',
			'groupId'=>1,
		];
	}
	public function want($request) {
		print_r(static::$ctrTable);die;
		return [
			'id','name','age',
			];
	}
}