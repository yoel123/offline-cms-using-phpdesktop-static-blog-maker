<?php
	include "../header.php";
	//user validation
	/*if(!y_user::permission(1))
	{
		exit("your dont have permission to see this page");
	}*/
	
	$tblDemo = new ajaxCRUD("category", "cat", "id", "../yapi/ajaxc/");

	//parent cat
	$tblDemo->defineRelationship("parent_id", "cat", "id",
"name");
	//display as
	$tblDemo->displayAs("parent_id", "parent category");
	

	//dir galery
	$tblDemo->addButtonToRow("posts", "posts.php"); 
	
	//$tblDemo->turnOffAjaxADD();
	$tblDemo->showTable();

?>
