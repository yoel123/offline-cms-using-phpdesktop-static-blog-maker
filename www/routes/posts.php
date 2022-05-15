<?php


//posts
Route::add('/admin/posts',function(){
	include('header.php');
	$html = "<a href='/'>back</a>";
	$html .= "<h1>posts</h1>";
	$posts_table = new ycrud($PDO,"post");
	$all_posts = $posts_table ->get_all();
	$html .= ycrud_table("post",$all_posts,array("id","title","date"),"/add_post");
	
	
	$view = new Template(); 
	$view->title = "admin posts"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl'); 
	
});

//posts by page


// add post form
Route::add('/add_post',function(){
	include('header.php');
	
	//get cats for chackbox array
	$cats_table = new ycrud($PDO,"cats");
	$all_cats = $cats_table->get_all();
	$checkbox_r = chackboxr_from_sql($all_cats,"cats_ids[]","name");
	
	//html form
    $add_post_form = new yform("add_post","POST","add_post","");
	$add_post_form->text("title","","text","title",0,"the post title");
	$add_post_form->textarea("content","","",0,"the post content");
	$add_post_form->text("date","","date","date",0,"dd/mm/yyyy");
	$add_post_form->chackboxes($checkbox_r,"","cats");
	$add_post_form->submit("sub","submit");
	$html = $add_post_form->create();
		
    $view = new Template(); 
	$view->title = "admin posts"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl');
});

// edit post form
Route::add('/edit_post/([a-z-0-9]*)',function($id){
	include('header.php');
	
	//get post data
	$posts_table = new ycrud($PDO,"post");
	$get_post = $posts_table->get_where("id='".$id."'")[0];
	//if post has cats (to put it in chackboxr_from_sql as selected array) 
	if(isset($get_post['cats_ids']))
	{
		//turn them back to array
		$cats_idsr = explode(",", $get_post['cats_ids']);
	}else{$cats_idsr = array();}
	//get cats for chackbox array
	$cats_table = new ycrud($PDO,"cats");
	$all_cats = $cats_table->get_all();
	$radio_r = chackboxr_from_sql($all_cats,"cats_ids[]","name",$cats_idsr);
	
	//html form
    $add_post_form = new yform("/edit_post/".$get_post ['id']."","POST","add_post","");
	$add_post_form->text("title","","text","title",0,"the post title","s12",$get_post['title']);
	$add_post_form->textarea("content","","",0,$get_post['content']);
	$add_post_form->text("date","","date","date",0,"dd/mm/yyyy","s12",$get_post['date']);
	$add_post_form->chackboxes($radio_r,"","cats");
	$add_post_form->submit("sub","submit");
	$html = $add_post_form->create();
			
    $view = new Template(); 
	$view->title = "admin posts"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl');
});

// add post send form
Route::add('/add_post',function(){
    include('header.php');
	//echo print_r($_POST);
	$posts_table = new ycrud($PDO,"post");
	if(isset($_POST["sub"]))
	{
		$new_post = array(
		'title'=>$_POST["title"],
		'content'=>$_POST["content"],
		'cats_ids'=>implode(",",$_POST["cats_ids"]),
		'date'=>$_POST["date"]
		);
		$posts_table->create($new_post);
	}
	yheader("/admin/posts");
	
},"post");

// delete post
Route::add('/delete_post/([a-z-0-9]*)',function($id){
    include('header.php');
	$posts_table = new ycrud($PDO,"post");
	$posts_table->ydelete($id);
	yheader("/admin/posts");
});

// edit post
Route::add('/edit_post/([a-z-0-9]*)',function($id){
	include('header.php');
	$posts_table = new ycrud($PDO,"post");
	if(isset($_POST["sub"]))
	{
		$new_post = array(
		'title'=>$_POST["title"],
		'content'=>$_POST["content"],
		'cats_ids'=>implode(",",$_POST["cats_ids"]),
		'date'=>$_POST["date"]
		);
		$posts_table->update($id,$new_post);
	}
	yheader("/admin/posts");
},"post");


// show post
Route::add('/view_post/([a-z-0-9]*)',function($id){
    include('header.php');
	$posts_table = new ycrud($PDO,"post");
	$get_post = $posts_table->get_where("id='".$id."'")[0];
	
	$html = "<h1>".$get_post['title']."</h1>";
	$html .= "<p>".$get_post['date']."</p>";
	$html .= "<p>".$get_post['content']."</p>";
	
	$view = new Template(); 
	$view->title = "admin posts"; 
	$view->content = $html; 
	echo $view->render('./templates/main.ytpl');
	
});
?>