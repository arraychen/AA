<?php
class Bapp {
	public static $ctrName;
	public static $actName;
	public static $user;
	public static function set() {
	}
	public static function check() {

	}
	public function user() {
		return [
			'id'	=>1,
			'name'=>'user',
			'groupId'=>1,
		];
	}
	public function route($requestUri) {
		$tmp=explode('?',$requestUri,2);
		$subDir='';
		$ctr='Cindex';
		$act='index';
		if(isset($tmp[0])) {
			$ctrTable=static::$ctrTable;
			$tmp=explode('/',$tmp[0]);
			unset($tmp[0]);
			$last=end($tmp);
			if ($last) {
				$act=$last;
			}

			foreach ($tmp as $val) {
					if(isset($ctrTable[$val])) {
						if(is_array($ctrTable[$val])) {
							$ctrTable=$ctrTable[$val];
							$subDir.='/'.$val;
						} else {
							$ctr='C'.$val;
							break;
						}
					} else {
						$act='404';
					}
			}
		}
//		static::$ctrName=$ctr;
//		static::$actName=$act;
		echo $subDir.'/'.$ctr,'->',$act;
		//$ctr::$act();
	}
}