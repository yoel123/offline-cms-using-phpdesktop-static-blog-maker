<?php
if(session_status() == PHP_SESSION_NONE)
{
 session_start();
}
require_once('config.php');
require_once('yapi/ytemplate/ytemplate_class.php');
require_once('yapi/ycrud/ycrud.php');
require_once('yapi/users/user_class.php');
require_once('yapi/upload/yupload_class.php');
require_once('yapi/yform/yform.php');
require_once('yapi/ytable/ytable.php');
require_once('yapi/helpers.php');

//print_r($_COOKIE);

		


?>

