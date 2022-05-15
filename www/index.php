<?php

error_reporting(-1);
// Include router class
include('yapi/route/Route.php');

//need to change : "404_handler": "/index.php", in settings.json

//posts routs
include("routes/posts.php");
include("routes/cats.php");
include("routes/tst.php");
include("routes/settings.php");

// Add base route (startpage)
Route::add('/',function(){
    include('header.php');
	$html =  '<a href="/admin/cats">cats</a>';
    $html .= '<a href="/admin/posts">posts</a>';
    $html .= '<a href="/admin/tst">tst</a>';
    $html .= '<a href="/code_gen">code gen</a>';
    $html .= '<a href="/admin/settings">settings</a>';
	
	$view = new Template(); 
	$view->title = "admin posts"; 
	//$view->content = $html; 
	$view->content = $view->render('./templates/admin_main.ytpl');; 
	echo $view->render('./templates/main.ytpl'); 
});

Route::add('/code_gen',function(){
	 include('crud_gen.php');
});

Route::add('/export',function(){
	include('header.php');
	$table_settings = new ycrud($PDO,"settings");
	$all_settings = $table_settings ->get_all();
	
	$posts_table = new ycrud($PDO,"post");
	$all_posts = $posts_table ->get_all();
	
	$cats_table = new ycrud($PDO,"cats");
	$all_cats = $cats_table->get_all();
	
	//extract settings
	//array_remove_num_keys($all_settings);//extract only named keys
	//extract($all_settings);
	$custom_css =yget_setting($all_settings,"custom_css");
	if($custom_css)
	{
		save_file("export_html/css","custom_style.css",$custom_css); 
	}
	
	
	//create main blog page index.html
		//search form js
		//pagnation (js based)
	ymake_index_page($all_posts,$all_cats,$all_settings);
	//about us page
	ymake_about_page($all_settings);
	//create cats page
	ymake_cats_page($all_cats);
	//create single cat page (that shows all posts of that cat
	ymake_cats_pages($all_cats,$all_posts);
	//search page
	ymake_search_page();
	
	//create single posts
	foreach($all_posts as $post)
	{
		ycreate_blog_html_file($post['title'],$post['content'],$post['date']);
	}
	
	//create json vertion of dbs
	$posts_json = "var posts_json= ".json_encode(array_remove_num_keys2d($all_posts)).";";
	save_file("export_html/js","posts.js",$posts_json);
	
	//xml sitemap
	
	//print_r($all_settings);
	//print_r($all_cats);
	//print_r($all_posts);
	
	echo"<h1>exported html</h1>";
	echo'<a href="javascript:history.back()" class="btn">Back</a>';
	
	$explorer = $_ENV["SYSTEMROOT"] . '\\explorer.exe';
	$folder_to_open = "export_html";
	shell_exec("$explorer /n,/e,$folder_to_open");
	
});

Route::add('/code_gen',function(){
	 include('crud_gen.php');
},"post");





// Post route example
Route::add('/contact-form',function(){
    echo 'Hey! The form has been sent:<br/>';
    print_r($_POST);
},'post');



// Accept only numbers as parameter. Other characters will result in a 404 error
Route::add('/foo/([0-9]*)/([a-z-0-9]*)',function($var1,$v2){
    echo $var1.$v2.' is a great number!';
});

Route::run('/');
	

	/*
		todo:
		cats crud v
		posts view
		posts rich text wisywag
		routs in thier own file v
		ytemplates(matrilizecss) v
		pagination
		front end
		export as html
		sitemap xml
	
	*/



?>
