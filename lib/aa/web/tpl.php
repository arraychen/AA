<?php
class Btpl {
	public static function show($data) {
		echo $data;
	}
	public function rule() {
		return [
			'id','name','age',
			];
	}
}