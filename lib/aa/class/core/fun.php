<?php

class bFun {
	public static function printR($var,$type='html') {
		if ('html'==$type) {
			echo '<pre>',htmlspecialchars(print_r($var,1)),'</pre>';
		} elseif ('js'==$type) {
			echo $var;
		}
	}
	public static function varDump($var) {
		var_dump($var);
	}
}