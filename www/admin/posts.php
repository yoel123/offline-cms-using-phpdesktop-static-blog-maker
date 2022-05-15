<?php
	include "../header.php";
	//user validation
	/*if(!y_user::permission(1))
	{
		exit("your dont have permission to see this page");
	}*/
	
	$cat_id = $_GET['id'];
	
	$tblDemo = new ajaxCRUD("posts", "post", "id", "../yapi/ajaxc/");

	//parent cat
	$tblDemo->defineRelationship("cat_id", "cat", "id",
"name");

	//display as
	$tblDemo->displayAs("cat_id", "category");
	
	//upload img
	//alowd ext
	$allowedExts = array("png", "jpg", "jpeg", "gif", "bmp"); 
	$tblDemo->setFileUpload("main_img", "../img/", "../img/",$allowedExts);
	
	//display img
	$tblDemo->formatFieldWithFunction('main_img', 'makeImg');
	
	$tblDemo->setTextareaHeight('contant', 100);
	
	//if isset category id
	if(isset($cat_id))
	{
		
		$tblDemo->addWhereClause("WHERE cat_id = ".$cat_id." ");
		
	}
	
	//$tblDemo->turnOffAjaxADD();
	$tblDemo->showTable();

?>