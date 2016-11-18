<?php

class bFun {
	public static function htmlpr($var) {
		echo '<pre>',htmlspecialchars(print_r($var,1)),'</pre>';
	}
}