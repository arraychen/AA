<?php

class bFun {
	public static function pr($var,$type='html') {
		if ($type=='html') {
			echo '<pre>',htmlspecialchars(print_r($var,1)),'</pre>';
		} elseif ($type=='js') {
			echo $var;
		}
	}
	public static function vd($var,$type='html') {
		var_dump($var);
	}
}