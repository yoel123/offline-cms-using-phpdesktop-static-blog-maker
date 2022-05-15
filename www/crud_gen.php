<?php

include('header.php');

//the form
$crud_form = new yform("","POST","","crud code gen");
$crud_form->text("name","","text","the table name");
$crud_form->text("col_names","","text","the table columns");
$crud_form->text("form_fields","","text","the add and edit form field types");
$crud_form->text("table_cols","","text","the table display cols for the crud table");
$crud_form->submit("sub","submit");
$html = $crud_form->create();
		
$view = new Template(); 
$view->title = "admin posts"; 
$view->content = $html; 
echo $view->render('./templates/main.ytpl');

//handle form
if(isset($_POST['sub']))
{
	$name = $_POST['name'];
	$col_names =  explode(",", $_POST['col_names']);
	$form_fields =  explode(",", $_POST['form_fields']);
	$table_cols =  explode(",", $_POST['table_cols']);
	
	//create fields array for add and edit
	//needs to come out a 2d array like this: [["text","name"],["date","the_date"]]
	$fields_r = array();
	$i=0;
	foreach($col_names as $col)
	{
		$fields_r[$i] = array();
		//set field type
		if(isset($form_fields[$i])){$fields_r[$i][0] = $form_fields[$i];}
		//set field name
		$fields_r[$i][1] = $col;
		$i++;
	}
	//turn table cold to a string with comma and single quotes
	$table_cols =  "'" . implode ( "', '", $table_cols ) . "'";
	

	$textarea = "<textarea  rows='200' cols='200'>";
	$textarea .= ydata_table_gen($name,$name,$table_cols);
	$textarea .= yadd_form($name,$fields_r);
	$textarea .= yedit_form($name,$fields_r);
	$textarea .= y_deleate_do($name);
	$textarea .= ypost_form_do($name,$fields_r,"add");
	$textarea .= ypost_form_do($name,$fields_r,"edit");
	$textarea .= "</textarea>";

	echo $textarea;
	
}//end post sub



/*
	$name-the form data name (for form action etc)
	$fields_r - array of the forms fields code:
	[["text","title"],["select","city"]]
*/
function yform_fields_gen($name,$fields_r)
{
	$fields_code="";
	foreach($fields_r as $fn)
	{
		if($fn[0]=="text")
		{
			$fields_code .= '$form_'.$name.'->text("'.$fn[1].'","","text","'.$fn[1].'",0,"placeholder txt");';
		}
		if($fn[0]=="textarea")
		{
			$fields_code .= '$form_'.$name.'->textarea("'.$fn[1].'","","",0,"the content");';
		}
		if($fn[0]=="date")
		{
			$fields_code .= '$form_'.$name.'->text("'.$fn[1].'","","date","'.$fn[1].'",0,"dd/mm/yyyy");';
		}
		if($fn[0]=="select"){}
		if($fn[0]=="chackbox")
		{
			$fields_code .= '$form_'.$name.'->chackboxes(array(),"","'.$name.'");';
		}
		if($fn[0]=="redio"){}
		if($fn[0]=="upload"){}
		$fields_code .= '
		';//new line
	}//end foreach	
	
	return $fields_code;
}//end yform_fields_gen


/*
	$name-the form data name (for form action etc)
	$fields_r - array of the forms fields code:
	[["text","title"],["select","city"]]
*/
function yedit_form_fields_gen($name,$fields_r)
{
	$fields_code="";
	foreach($fields_r as $fn)
	{
		//
		if($fn[0]=="text")
		{
			$fields_code .= '$form_'.$name.'->text("'.$fn[1].'","","text","'.$fn[1].'",0,"placeholder txt","s12",$get_'.$name.'["'.$fn[1].'"]);';
		}
		if($fn[0]=="textarea")
		{
			$fields_code .= '$form_'.$name.'->textarea("'.$fn[1].'","","",0,$get_'.$name.'["'.$fn[1].'"]);';
		}
		if($fn[0]=="date")
		{
			$fields_code .= '$form_'.$name.'->text("'.$fn[1].'","","date","'.$fn[1].'",0,$get_'.$name.'["'.$fn[1].'"]);';
		}
		if($fn[0]=="select"){}
		if($fn[0]=="chackbox")
		{
			$fields_code .= '$form_'.$name.'->chackboxes(array(),"","'.$name.'");';
		}
		if($fn[0]=="redio"){}
		if($fn[0]=="upload"){}
		$fields_code .= '
		';//new line
	}//end foreach	
	
	return $fields_code;
}//end yform_fields_gen



/*
	$name-the form data name (for form action etc)
	$fields_r - array of the forms fields code:
	[["text","title"],["select","city"]]
*/
function yadd_form($name,$fields_r)
{
	
	$fields_code = yform_fields_gen($name,$fields_r);

	
	$code = <<<EOT
	
// add $name form
Route::add('/add_$name',function(){
	include('header.php');

	//html form
    \$form_$name = new yform("add_$name","POST","add_$name","");
	$fields_code
	\$form_$name ->submit("sub","submit");
	\$html = \$form_$name ->create();
		
    \$view = new Template(); 
	\$view->title = "admin $name"; 
	\$view->content = \$html; 
	echo \$view->render('./templates/main.ytpl');
});
EOT;

	return $code;
}//end add_form

function yedit_form($name,$fields_r)
{
	
	$fields_code = yedit_form_fields_gen($name,$fields_r);

	$code = <<<EOT
	
	
// edit $name form
Route::add('/edit_$name/([a-z-0-9]*)',function(\$id){
	include('header.php');
	
	//get post data
	\$table_$name = new ycrud(\$PDO,"$name");
	\$get_$name = \$table_$name ->get_where("id='".\$id."'")[0];

	//html form
    \$form_$name = new yform("/edit_$name/".\$get_$name ['id']."","POST","add_post","");
	$fields_code
	\$form_$name ->submit("sub","submit");
	\$html = \$form_$name ->create();
			
    \$view = new Template(); 
	\$view->title = "admin posts"; 
	\$view->content = \$html; 
	echo \$view->render('./templates/main.ytpl');
});
EOT;

		

	return $code;
	
}//end yedit_form

function ydata_table_gen($name,$table_name,$columns)
{

$code = <<<EOT

//$name
Route::add('/admin/$name',function(){
	include('header.php');
	\$html = "<a href='/'>back</a>";
	\$html .= "<h1>$name</h1>";
	\$table_$name = new ycrud(\$PDO,"$table_name");
	\$all_$name = \$table_$name ->get_all();
	\$html .= ycrud_table("$name",\$all_$name,array($columns),"/add_$name");
	
	
	\$view = new Template(); 
	\$view->title = "admin $name"; 
	\$view->content = \$html; 
	echo \$view->render('./templates/main.ytpl'); 
	
});


EOT;

	return $code;
	
}//end data_table_gen





function y_deleate_do($name)
{
	$code = <<<EOT

//delete $name
	
Route::add('/delete_$name/([a-z-0-9]*)',function(\$id){
    include('header.php');
	\$table_$name = new ycrud(\$PDO,"$name");
	\$table_$name ->ydelete(\$id);
	yheader("/admin/$name");
});
EOT;

	return $code;
}

function ypost_form_do($name,$fields_r,$type)
{
	$code = "";
	$sql_action = "";//insert or update command
	$array_fields = "";//the array to be inserted updated
	
	//if its add form post put this code at the start
	if($type =="add")
	{
		$code .= "
		
	Route::add('/add_$name',function(){";
		$sql_action .= "\$table_$name ->create(\$new_post);";
	}
	//or if its edit form post action
	if($type =="edit")
	{
		$code .= "
		
	Route::add('/edit_$name/([a-z-0-9]*)',function(\$id){";
		$sql_action .= "\$table_$name ->update(\$id,\$new_post);";
	}
	
	//loop the fields_r array to get each form fields name
	foreach($fields_r as $fn)
	{
		$array_fields .="
		'".$fn[1]."'=>\$_POST['".$fn[1]."'],";
	}
	
	$array_fields = rtrim($array_fields, ",");
	
	$code .= <<<EOT


    include('header.php');
	
	\$table_$name = new ycrud(\$PDO,"$name");
	if(isset(\$_POST["sub"]))
	{
		\$new_post = array(
		$array_fields
		);
		$sql_action
	}
	yheader("/admin/$name");
	
},"post");
EOT;

	return $code;	
}//end ypost_form_do



?>