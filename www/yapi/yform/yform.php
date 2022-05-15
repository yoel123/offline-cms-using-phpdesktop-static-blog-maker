<?php
class yform
{
	protected $_form_html; 
	protected $_input_html; 
	public $is_upload; 
	protected $_method; 
	protected $_action; 
	protected $_class; 
	protected $_title; 
	public function __construct($action, $method,$class="",$title="") 
    {
       $this->_method = $method;
       $this->_action =  $action;
       $this->_class = $class;
       $this->_title = $title;
       $this->is_upload = false;
	 
    }//end __construct 
	
	/*
	name:text
	description: creates a text input and adds it to $this->_input_html
	input:
	-name(string): the input name
	-class(string): input class
	-type(string): the input type (text,password,email)
	-label(string):input label
	-required(int):0 for not required 1 for required
	-col_size(int): bootstrap md_col class size
	-placeholder(string):the input placeholder
	-value(string):default input val
	output: null
	*/
	public function text($name,$class,$type="text",$label = "",$required=0,$placeholder="",$col_size="s12",$value ="")
    {
		if($required == 1){$required ="required";}else{$required ="";}
		$html = "<div class='row'>";
		$html .= "<div class='input-field col ".$col_size."'>";
		//input
		$html .= "<input name = '".$name."' id = '".$name."' type =".$type." class = 'col-md-".$col_size." ".$class."' 
		placeholder='".$placeholder."' ".$required." value='".$value."' />";
		//lable
		$html .= "<label class='active' for='".$name."'>".$label."</label>";
		$html .= "</div>";
		$html .= "</div>";
		$this->_input_html .= $html; 
		return $html;
	}//end text
	
		
	/*
	name:textarea
	description: creates a textarea and adds it to $this->_input_html
	input:
	-name(string): the input name
	-class(string): input class
	-label(string):input label
	-required(int):0 for not required 1 for required
	-col_size(int): bootstrap md_col class size
	-placeholder(string):the input placeholder (or defult value)
	output: null
	*/
	public function textarea($name,$class,$label = "",$required=0,$placeholder="",$col_size="s12")
    {
		if($required == 1){$required ="required";}else{$required ="";}
		$html = "<div class='row'>";
		$html .= "<div class='input-field col ".$col_size."'>";
		//$html .= "";
		//input
		$html .= "<textarea name = '".$name."' id = '".$name."'  class = '".$class."' 
		".$required.">".$placeholder."</textarea>";
		//lable
		$html .= "<label class='active' for='".$name."'>".$label."</label>";
		
		$html .= "</div>";
		$html .= "</div>";
		$this->_input_html .= $html; 
		return $html;
	}//end textarea
	
	/*
	name:select
	description: creates a select input and adds it to $this->_input_html
	input:
	-name(string): the input name
	-class(string): input class
	-label(string):input label
	-data(array): array that holds all the select items example: array(['value'=>1,'name'=>'foo'])
	-placeholder(string):text for default option (value=000)
	-required(int):0 for not required 1 for required
	-col_size(int): bootstrap md_col class size
	
	output: null
	*/
	public function select($name,$class,$label = "",$data=0,$placeholder="select",$required=0,$col_size=4)
    {
		if($required == 1){$required ="required";}else{$required ="";}
		$html = "<div class='row'>";
		$html = "<div class='input-field col ".$col_size."'>";
		//$html .= "";
		//lable
		$html .= "<label>".$label."</label>";
		//select
		$html .= "<select name = '".$name."' id = '".$name."' 
		class = '".$class."' ".$required.">";
		//options
		//placeholder
		$html .="<option value='000'>".$placeholder."</option>";
		foreach($data as $item)
		{
			if(isset($item['selected']) && $item['selected'] == 1){$selected ="selected";}else{$selected ="";}
			$html .="<option value='".$item['value']."' ".$selected.">".$item['name']."</option>";
		}
		$html .= "</select></div></div>";
		$this->_input_html .= $html; 
		return $html;	
	}//end select
	
	/*
	name:chackboxes
	description: creates a chackboxes input based on array and adds it to $this->_input_html
	input:
	-class(string): input class
	-data(array): array that holds all the chackbox items example: array(['value'=>1,'name'=>'foo','required'=>1,'checked'=>0,'label'=>1])
	-label(string):input label
	-col_size(int): bootstrap md_col class size
	output: null
	*/
	public function chackboxes($data=0,$class="",$label="",$col_size="s12")
    {
		$html = "<div class='row'>";
		$html = "<div class=' ".$col_size."'>";
		//$html .= "";
		//lable
		$html .= "<h6>".$label.":</h6>";
		foreach($data as $item)
		{
			if($item['required'] == 1){$required ="required";}else{$required ="";}
			if($item['checked'] == 1){$checked ="checked";}else{$checked ="";}
			if(!isset($item['value'])){$item['value'] ="";}
			
			
			$html .= " <label><input type='checkbox' value='".$item['value']."'  name = '".$item['name']."'  
			".$required." ".$checked."><span>".$item['label']."</span></label>";
			
		}
		$html .= "</div>";
		$this->_input_html .= $html; 
		return $html;
	}//end chackboxes
	/*
		if(in_array('bar', $_POST['foo'])){
	  echo 'bar was checked!';
}
	*/
	
	
	/*
	name:radio
	description: creates a radio input based on array and adds it to $this->_input_html
	input:
	-class(string): input class
	-data(array): array that holds all the chackbox items example: array(['value'=>1,'name'=>'foo','required'=>1,'label'=>1])
	-label(string):input label
	-col_size(int): bootstrap md_col class size
	output: null
	*/
	public function radios($data=0,$class="",$label="",$col_size="s12")
    {
		
		$html = "<div class='row'>";
		$html = "<div class='input-field col ".$col_size."'>";
		$html .= "<label>".$label."</label>";
		foreach($data as $item)
		{
			if($item['required'] == 1){$required ="required";}else{$required ="";}
			if(!isset($item['value'])){$item['value'] ="";}
			if(isset($item['checked'])&&$item['checked'] == 1){$checked ="checked='checked'";}else{$checked ="";}
			
			$html .= "<div class='radio".$class."'>";
			$html .= "<label><input type='radio' name='".$item['name']."' 
			value='".$item['value']."' ".$required." ".$checked.">".$item['label']."</label>";
			$html .= "</div>";
		}
		$html .= "</div>";
		$html .= "</div>";
		$this->_input_html .= $html; 
		return $html;
	}//end radios
	
	/*
	name:upload
	description: creates a upload file btn and adds it to $this->_input_html
	input:
	-name(string): input name 
	-label(string): input label 
	-class(string): input css class 
	-col_size(int): bootstrap md_col class size
	output: null
	*/
	public function upload($name,$label="",$class="",$col_size=4)
    {
		$html = "<div class='row'>";
		$html = "<div class='input-field col ".$col_size."'>";
		
		$html .= "<label>".$label."</label>
		<div class='col-md-".$col_size."'>
		<input name = '".$name."'  class='".$class."' type='file'>";
		
		$html .= "</div></div></div>";
		$this->_input_html .= $html; 
		return $html;
	}//end upload
	
	/*
	name:submit
	description: creates a submit input and adds it to $this->_input_html
	input:
	-name(string): input name 
	-label(string): input label 
	-class(string): input css class 
	-col_size(int): bootstrap md_col class size
	output: null
	*/
	public function submit($name,$label="",$class="btn btn-primary",$col_size="s12")
    {
		
		$html = "<div class='row'>";
		$html = "<div class='input-field col ".$col_size."'>";
		
		$html .= " <input  type='submit'
		name='".$name."' value='".$label."' class='".$class."'/>";
		
		$html .= "</div></div>";
		$this->_input_html .= $html; 
		return $html;
	}//end
	
	/*
	name:custom
	description: adds a custom elemnt to form 
	input:
	-string(string): any html or text
	output: string
	*/
	public function custom($string)
    {
		$this->_input_html .= $string; 
		return $string;
	}//end custom
	
	
	/*
	name:create
	description: creates the actual html form
	input:none
	output: the form html
	*/
	public function create()
    {
		//is upload form
		if($this->is_upload){$enctype = 'enctype="multipart/form-data"';}
		else{$enctype = '';}
		
		//create form tag
		$this->_form_html ='<form method = "'.$this->_method.'" action="'. $this->_action.'"
		class=" '.$this->_class.'" '.$enctype.'>

';
		//form title
		//$this->_form_html .='<legend>'.$this->_title.'</legend>';
		//if thers upload add what needed by html
		
		//add all inputs
		$this->_form_html .=$this->_input_html;
		//close form tag
		$this->_form_html .="</form>";
		return $this->_form_html;
	}//end
	
	//array(['value'=>1,'name'=>'foo'])
	/*
	name:convert_to_select_data
	description: creates data array for select element option elements
	input:
	-$arr(array)- your array from db
	-$val(string)- the value att (most of the time id drom db table)
	-$name(string)- what the user will see
	-$selected(string/int)- the selected val att value (again mostly the id of selected option)
	output: array in the neded format
	*/
	public static function convert_to_select_data($arr,$val,$name,$selected = false)
    {
		$return_arr = array();
		foreach($arr as $item)
		{
			if(!$selected || $item[$val] != $selected)
			{
				$return_arr[] = array('value'=>$item[$val],'name'=>$item[$name]);
			}
			else
			{
				$return_arr[] = array('value'=>$item[$val],'name'=>$item[$name],'selected'=>1);
			}
		}
		return $return_arr;
	}//end convert_to_select_data
	
	
	// array(['value'=>1,'name'=>'foo','required'=>1,'checked'=>0,'label'=>1])
	//$html .= " <label><input type='checkbox' value='".$item['value']."'  name = '".$item['name']."' 
		/*
	name:convert_to_select_data
	description: creates data array for select element option elements
	input:
	-$arr(array)- your array from db
	-$val(string)- the value att (most of the time id drom db table)
	-$name(string)- input name att
	-$lable(string)- the att of lable (most of the time name of row data from db table)
	-$selected(arr)- array of vals (ids mostly), that shod be chacked
	output: array in the neded format
	*/
	public static function convert_to_chackbox_data($arr,$val,$label,$name,$checked = false)
	{
		$return_arr = array();
		foreach($arr as $item)
		{
			if(!$checked || !in_array($item[$val], $checked) )
			{
				$return_arr[] = array('value'=>$item[$val],'name'=>$name,'label'=>$item[$label],'required'=>0,'checked'=>0);
			}
			else
			{
				$return_arr[] = array('value'=>$item[$val],'name'=>$name,'checked'=>1,'label'=>$item[$label],'required'=>0);
			}
		}
		return $return_arr;
	}//end convert_to_chackbox_data
}//end yform
 
?>