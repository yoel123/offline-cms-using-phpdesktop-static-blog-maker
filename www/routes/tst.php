<?php

//tst
Route::add('/admin/tst',function(){
	include('header.php');
	
	$html= "<a href='/'>back</a>";
	$html .= "<h1>tst</h1>";
	$table_tst = new ycrud($PDO,"tst");
	$all_tst = $table_tst ->get_all();
	$html .= ycrud_table("tst",$all_tst,array('name', 'date'),"/add_tst");
	
	
	$view = new Template(); 
	$view->title = "admin tst"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl'); 
	
});

	
// add tst form
Route::add('/add_tst',function(){
	include('header.php');

	//html form
    $form_tst = new yform("add_tst","POST","add_tst","");
	$form_tst->text("name","","text","name",0,"placeholder txt");
	$form_tst->text("date","","date","date",0,"dd/mm/yyyy");
		
	$form_tst ->submit("sub","submit");
	$html = $form_tst ->create();
		
    $view = new Template(); 
	$view->title = "admin tst"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl');
});	
	
// edit tst form
Route::add('/edit_tst/([a-z-0-9]*)',function($id){
	include('header.php');
	
	//get post data
	$table_tst = new ycrud($PDO,"tst");
	$get_tst = $table_tst ->get_where("id='".$id."'")[0];

	//html form
    $form_tst = new yform("/edit_tst/".$get_tst ['id']."","POST","add_post","");
	$form_tst->text("name","","text","name",0,"placeholder txt","s12",$get_tst["name"]);
	$form_tst->text("date","","date","date",0,$get_tst["date"]);
		
	$form_tst ->submit("sub","submit");
	$html = $form_tst ->create();
			
    $view = new Template(); 
	$view->title = "admin posts"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl');
});
//delete tst
	
Route::add('/delete_tst/([a-z-0-9]*)',function($id){
    include('header.php');
	$table_tst = new ycrud($PDO,"tst");
	$table_tst ->ydelete($id);
	yheader("/admin/tst");
});
		
Route::add('/add_tst',function(){

    include('header.php');
	
	$table_tst = new ycrud($PDO,"tst");
	if(isset($_POST["sub"]))
	{
		$new_post = array(
		
		'name'=>$_POST['name'],
		'date'=>$_POST['date']
		);
		$table_tst ->create($new_post);
	}
	yheader("/admin/tst");
	
},"post");
		
Route::add('/edit_tst/([a-z-0-9]*)',function($id){

    include('header.php');
	
	$table_tst = new ycrud($PDO,"tst");
	if(isset($_POST["sub"]))
	{
		$new_post = array(
		
		'name'=>$_POST['name'],
		'date'=>$_POST['date']
		);
		$table_tst ->update($id,$new_post);
	}
	yheader("/admin/tst");
	
},"post");

?>