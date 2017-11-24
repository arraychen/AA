<?php
class bList {
	public $mod;
	public $form;
	public $headTpl;
	public $rowTpl;
	public function __construct($mod) {
		$this->mod=$mod;
	}
	public function search($col,$tpl='') {
		$this->form=new bForm();
	}
	public function table($Col=[]) {
		if ($Col) {
			foreach ($Col as $val) {
				if (isset($this->mod::field[$val]))	$field[$val]=$this->mod::field[$val];
				if (isset($this->mod::outRule['html'][$val]))	$field[$val]=$this->mod::outRule['html'][$val];
			}
		} else {
			$field=$this->mod::field;
		}
		$data=$this->mod->get();
		echo '<table border=1 id="aa_blist_',$this->mod::table,'" class="aa_blist">';
		if ($this->headTpl) {
			echo bTpl::tr($this->headTpl,$field);
		} else {
			echo '<tr>';
			foreach ($field as $key=>$val) {
				echo '<th>',$val[1],'</th>';
			}
			echo '</tr>';
		}
		foreach ($data->data as $val) {
			if (isset($this->mod::outRule['html'])) {
				$vField=[];
				foreach ($this->mod::outRule['html'] as $vKey => $outRule) {
					$staticFun=$outRule[0];
					$vField[$vKey]=$this->mod::$staticFun($val);
				}
				$extVal=$vField+$val;
			} else $extVal=$val;
			if ($this->rowTpl) {
				echo bTpl::tr($this->rowTpl,$extVal);
			} else {
				echo '<tr>';
				if ($Col) {
					foreach ($Col as $colName) {
						echo '<td>',$extVal[$colName],'</td>';
					}
				} else {
					foreach ($val as $k=>$v) {
						echo '<td>',$v,'</td>';
					}
				}
				echo '</tr>';
			}
		}
		echo '</table>';
	}
	public function pager() {

	}
}