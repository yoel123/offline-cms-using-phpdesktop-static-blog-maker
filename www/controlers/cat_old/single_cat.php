<?php

	include "header.php";
	$dsn = 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME;
	$pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
	$cat =  new ycrud($pdo,"cat"); 
	$post =  new ycrud($pdo,"post"); 
	//get category from db
	$this_cat = $cat->get_where("name = '".$name."'"); 
	$this_cat = $this_cat['0']; 
	//get all posts in category
	$this_posts = $post->get_where("cat_id = '".$this_cat['id']."'");
	
	$view = new Template();
	$view->title = "edit_category"; 
    $view->cat = $this_cat;
    $view->posts = $this_posts;
	$view->content = $view->render('templates/cat/single_cat.ytpl') ; //login form template
	echo $view->render('templates/bootstrap_updir.ytpl');

 ?>

