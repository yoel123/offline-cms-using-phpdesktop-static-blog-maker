<?php
	include "../header.php";
	//user validation
	/*if(!y_user::permission(1))
	{
		exit("your dont have permission to see this page");
	}*/
	
	$tblDemo = new ajaxCRUD("config", "config", "id", "../yapi/ajaxc/");

	//display as
	//$tblDemo->displayAs("parent_id", "parent category");
	
	//disallow edit
	$tblDemo->disallowEdit('att_name');
	//disallow delete
	$tblDemo->disallowDelete();
	
	//$tblDemo->turnOffAjaxADD();
	$tblDemo->showTable();

?>