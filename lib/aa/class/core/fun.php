<?php

class bFun {
	public static function printR($var,$type='html') {
		if ($type=='html') {
			echo '<pre>',htmlspecialchars(print_r($var,1)),'</pre>';
		} elseif ($type=='js') {
			echo $var;
		}
	}
	public static function varDump($var,$type='html') {
		var_dump($var);
	}
}