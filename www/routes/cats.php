<?php 
Route::add('/admin/cats',function(){
	include('header.php');
	
	$html= "<a href='/'>back</a>";
	$html.= "<h1>cats</h1>";
	$cats_table = new ycrud($PDO,"cats");
	$all_cats = $cats_table->get_all();
	$new_cat = array('name'=>'tst33');

	$html .= ycrud_table("cat",$all_cats,array("id","name"),"/add_cat");
    $view = new Template(); 
	$view->title = "admin posts"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl');
});

Route::add('/view_cat/([a-z-0-9]*)',function($id){
	include('header.php');
	yheader("/admin/cats");
});
Route::add('/edit_cat/([a-z-0-9]*)',function($id){
	include('header.php');
	
	//get cat by id
	$cats_table = new ycrud($PDO,"cats");
	$get_cat = $cats_table->get_where("id='".$id."'")[0];
	
	//html form
    $add_cat_form = new yform("/edit_cat/".$get_cat['id'],"POST","add_post","");
	//text($name,$class,$type,$label,$required,$placeholder,$col_size,$value)
	$add_cat_form->text("name","","text","name",0,"the category name","s12",$get_cat['name']);
	$add_cat_form->submit("sub","submit");
	$html = $add_cat_form->create();
			
    $view = new Template(); 
	$view->title = "admin cats"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl');
});
Route::add('/add_cat',function(){
	include('header.php');
	
	//html form
    $add_cat_form = new yform("/add_cat","POST","add_post","");
	//text($name,$class,$type,$label,$required,$placeholder,$col_size,$value)
	$add_cat_form->text("name","","text","name",0,"the category name","s12","");
	$add_cat_form->submit("sub","submit");
	$html = $add_cat_form->create();
			
    $view = new Template(); 
	$view->title = "admin cats"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl');
});

Route::add('/delete_cat/([a-z-0-9]*)',function($id){
	include('header.php');
	$cats_table = new ycrud($PDO,"cats");
	$cats_table->ydelete($id);
	yheader("/admin/cats");
});

//form posts
Route::add('/edit_cat/([a-z-0-9]*)',function($id){
	include('header.php');
	$cats_table = new ycrud($PDO,"cats");
	if(isset($_POST["sub"]))
	{
		$new_cat = array(
		'name'=>$_POST["name"],
		);
		$cats_table->update($id,$new_cat);
	}
	yheader("/admin/cats");
},"post");

Route::add('/add_cat',function(){
	include('header.php');
	$cats_table = new ycrud($PDO,"cats");
	if(isset($_POST["sub"]))
	{
		$new_cat = array(
		'name'=>$_POST["name"],
		);
		$cats_table->create($new_cat);
	}
	
	yheader("/admin/cats");
},"post");
?>