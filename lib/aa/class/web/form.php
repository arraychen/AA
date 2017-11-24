<?php
class bForm {
	public const Option=['method'=>'POST'];
	public $method;
	public function __construct($Opt=[]) {
		$Opt=$Opt+self::Option;
		echo '<form ';
		foreach ($Opt as $key=>$val) {
			echo '"',$key,'"="',$val,'"';
		}
		echo '>';
	}
	public function set($Opt) {
		$option=[
			'action'=>'',
			'method'=>['POST','GET'],
			'name'=>'aa_form',
			'id'=>'',
			'target'=>'',
			'novalidate'=>'',
			'autocomplete'=>'',
			'enctype'=>['url-encoded',''],
		];
	}

	public function input() {
		echo '<input type="text" name="name">';
	}
	public function checkbox() {
		echo '<input type="checkbox" name="name">';
	}
	public function text() {
		echo '<textarea></textarea>';
	}
	public function select() {
		echo '<select></select>';
	}
	public function submit() {
		echo '<select></select>';
	}
	public function buttom() {
		echo '<select></select>';
	}
	public function label() {
		echo '<label></label>';
	}

	public function end() {
		echo '</form>';
	}

}