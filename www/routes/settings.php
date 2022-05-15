<?php

//settings
Route::add('/admin/settings',function(){
	include('header.php');
	$html = "<a href='/'>back</a>";
	$html .= "<h1>settings</h1>";
	$table_settings = new ycrud($PDO,"settings");
	$all_settings = $table_settings ->get_all();
	$html .= ycrud_table("settings",$all_settings,array('name'),"/add_settings");
	
	
	$view = new Template(); 
	$view->title = "admin settings"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl'); 
	
});

	
// add settings form
Route::add('/add_settings',function(){
	include('header.php');

	//html form
    $form_settings = new yform("add_settings","POST","add_settings","");
	$form_settings->text("name","","text","name",0,"placeholder txt");
		$form_settings->textarea("value","","",0,"the content");
		
	$form_settings ->submit("sub","submit");
	$html = $form_settings ->create();
		
    $view = new Template(); 
	$view->title = "admin settings"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl');
});	
	
// edit settings form
Route::add('/edit_settings/([a-z-0-9]*)',function($id){
	include('header.php');
	
	//get post data
	$table_settings = new ycrud($PDO,"settings");
	$get_settings = $table_settings ->get_where("id='".$id."'")[0];

	//html form
    $form_settings = new yform("/edit_settings/".$get_settings ['id']."","POST","add_post","");
	$form_settings->text("name","","text","name",0,"placeholder txt","s12",$get_settings["name"]);
		$form_settings->textarea("value","","",0,$get_settings["value"]);
		
	$form_settings ->submit("sub","submit");
	$html = $form_settings ->create();
			
    $view = new Template(); 
	$view->title = "admin posts"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl');
});
//delete settings
	
Route::add('/delete_settings/([a-z-0-9]*)',function($id){
    include('header.php');
	//$table_settings = new ycrud($PDO,"settings");
	//$table_settings ->ydelete($id);
	yheader("/admin/settings");
});
		
	Route::add('/add_settings',function(){

    include('header.php');
	
	$table_settings = new ycrud($PDO,"settings");
	if(isset($_POST["sub"]))
	{
		$new_post = array(
		
		'name'=>$_POST['name'],
		'value'=>$_POST['value']
		);
		$table_settings ->create($new_post);
	}
	yheader("/admin/settings");
	
},"post");
		
	Route::add('/edit_settings/([a-z-0-9]*)',function($id){

    include('header.php');
	
	$table_settings = new ycrud($PDO,"settings");
	if(isset($_POST["sub"]))
	{
		$new_post = array(
		
		
		'value'=>$_POST['value']
		);
		$table_settings ->update($id,$new_post);
	}
	yheader("/admin/settings");
	
},"post");

?>