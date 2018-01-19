<?php
class bForm {
	public const option=[
		'method'=>'post',
		];
	static public $AllForm;
	static public $count=0;
	static public $resOutputed=0;
	public $md5;
	public $mod;
	public $id;
	public $rowTpl;
	public $data;
	public $target;// self,blank,iframe,json
	public $error=[];// array [field=>string]
	public $result;// array [boole,string,extrstring];
	public function __construct($mod,$target='iframe') {
		static::$count++;
		$this->id=static::$count;
		$this->target=$target;
		$this->mod=$mod;
		$this->md5=substr(md5(aApp::name.'_'.aApp::$ctrName.'_'.aApp::$actName.'_'.$this->id),0,10);
		if(!empty($_POST['aform'.$this->md5][$this->id])) {
			$state='';
			if (!empty($_POST['aform'.$this->md5]['submit'])) {
				$key=array_keys($_POST['aform'.$this->md5]['submit']);
				if (isset($key[0])) $state=$key[0];
			}
			$handler='submit'.$state;
			if (class_exists($mod) && method_exists($mod,$handler)) {
				$this->result=[0,'表单验证失败'];
				if(!($this->result['error']=$mod::checkInputRule($_POST['aform'.$this->md5][$this->id],$state))) {
					$this->result=$mod::$handler($_POST['aform'.$this->md5][$this->id]);
				}
			} else {
				$this->result=[0,'无法处理请求（'.$mod.':'.$handler.'方法不存在）'];
			}
			if ($this->target=='iframe'){
				echo '<script language="JavaScript">';
				if (isset($this->result['error'])) {
					foreach ($this->result['error'] as $key=>$val) {
						echo 'parent.document.getElementById("aform',$this->id,'_title_',$key,'").className="aform_error";parent.document.getElementById("aform',$this->id,'_label_',$key,'").className="aform_error";parent.document.getElementById("aform',$this->id,'_label_',$key,'").innerHTML="',$val,'";';
					}
				}

				if($this->result[0]==1) {
					if (isset($this->result['goto'])) {
						echo 'parent.location.href="',$this->result['goto'][0],'";';
					}
				}
				echo 'parent.document.getElementById("aform',$this->id,'_result").innerHTML="',htmlspecialchars($this->result[1]),'";';
				echo '</script>';
				die;
			}elseif ($this->target=='json') {
				echo json_encode($this->result);
				die;
			} else {
				if ($this->result[0]==0) {
					$this->data=$_POST['aform'.$this->md5][$this->id];
				} else {
					if (isset($this->result['goto'])) {
						header('Location: '.$this->result['goto'][0]);
						die;
					}
				}
			}
		}
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

	public function form($html='') {
		$Opt=static::option;
		if (static::$resOutputed==0 && $this->target=='iframe') {
			static::$resOutputed=1;
			echo '<iframe style="display:none" height="0" name="aform_taget"></iframe>';
		}
		echo '<form ';
		foreach ($Opt as $key=>$val) {
			echo $key,'="',$val,'"';
		}
		echo ' id="aform',$this->id,'" name="aform_',$this->id,'" target="';
		if ($this->target=='self' || $this->target=='blank') echo '_',$this->target;
		elseif($this->target=='iframe') echo 'aform_taget';
		else  echo '_self';
		echo '"',$html,'>';
	}
	public function text($name,$html='') {
		echo '<input type="text" id="aform',$this->id,'_',$name,'" name="aform',$this->md5,'[',$this->id,'][',$name,']"';
		if (isset($this->data[$name])) echo ' value="',$this->data[$name],'"';
		if($html) echo ' ',$html;
		if(isset($this->result['error'][$name])) echo ' class="aform_error"';
		elseif($this->data) echo ' class="aform_ok"';
		echo '>';
	}
	public function password($name,$html='') {
		echo '<input type="password" id="aform',$this->id,'_',$name,'" name="aform',$this->md5,'[',$this->id,'][',$name,']"';
		if (isset($this->data[$name])) echo ' value="',$this->data[$name],'"';
		if($html) echo ' ',$html;
		if(isset($this->result['error'][$name])) echo ' class="aform_error"';
		elseif($this->data) echo ' class="aform_ok"';
		echo '>';
	}
	public function hidden($name,$html='') {
		echo '<input type="hidden" id="aform',$this->id,'_',$name,'" name="aform',$this->md5,'[',$this->id,'][',$name,']"';
		if (isset($this->data[$name])) echo ' value="',$this->data[$name],'"';
		if($html) echo ' ',$html;
		if(isset($this->result['error'][$name])) echo ' class="aform_error"';
		elseif($this->data) echo ' class="aform_ok"';
		echo '>';
	}
	public function checkbox($name,$html='') {
		echo '<input type="checkbox" id="aform',$this->id,'_',$name,'" name="aform',$this->md5,'[',$this->id,'][',$name,']"';
		if($html) echo ' ',$html;
		if(isset($this->result['error'][$name])) echo ' class="aform_error"';
		elseif($this->data) echo ' class="aform_ok"';
		echo '>';
	}
	public function radio($name,$html='') {
		echo '<input type="radio" id="aform',$this->id,'_',$name,'" name="aform',$this->md5,'[',$this->id,'][',$name,']"';
		if($html) echo ' ',$html;
		if(isset($this->result['error'][$name])) echo ' class="aform_error"';
		elseif($this->data) echo ' class="aform_ok"';
		echo '>';
	}
	public function textarea($name,$html='') {
		echo '<textarea id="aform',$this->id,'_',$name,'" name="aform',$this->md5,'[',$this->id,'][',$name,']"';
		if($html) echo ' ',$html;
		if(isset($this->result['error'][$name])) echo ' class="aform_error"';
		elseif($this->data) echo ' class="aform_ok"';
		echo '></textarea>';
	}
	public function select($name,$html='') {
		echo '<select id="aform_',$this->id,'_',$name,'" name="aform',$this->md5,'[',$this->id,'][',$name,']"';
		if($html) echo ' ',$html;
		if(isset($this->result['error'][$name])) echo ' class="aform_error"';
		elseif($this->data) echo ' class="aform_ok"';
		echo '></select>';
	}
	public function submit($name='submit',$text='提交',$html='') {
		echo '<input type="submit" id="aform',$this->id,'_submit_',$name,'" name="aform',$this->md5,'[submit][',$name,']" value="',$text,'"';
		echo $html,'>';
	}
	public function buttom($name,$text,$html='') {
		echo '<input type="buttom" id="aform',$this->id,'_buttom_',$name,'" name="aform',$this->md5,'[submit][',$name,']" value="',$text,'"';
		echo $html,'>';
	}

	public function label($name,$text,$html='') {
		echo '<label id="aform',$this->id,'_label_',$name,'" for="aform',$this->id,'_',$name,'"';
		if($html) echo ' ',$html;
		if(isset($this->result['error'][$name])) echo ' class="aform_error"';
		elseif($this->data) echo ' class="aform_ok"';
		echo '>';
		if(isset($this->result['error'][$name])) echo $this->result['error'][$name];
		else  echo $text;
		echo '</label>';
	}
	public function title($name,$html='') {
		echo '<label id="aform',$this->id,'_title_',$name,'" for="aform',$this->id,'_',$name,'"',$html,'>',$this->mod::field[$name][1],'</label>';
	}
	public function result() {
		echo '<div id="aform',$this->id,'_result" class="afrom_result">',$this->result[1],'</div>';
	}
	public function end() {
		echo '</form>';
	}
}