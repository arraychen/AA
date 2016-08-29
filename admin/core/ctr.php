<?php
class Actr extends Bctr {
	public function http403() {
		echo 'page:403';
	}
	public function http404() {
		echo 'page:404';
	}
}