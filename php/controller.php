<?php
require_once __DIR__.'/classes/Login.php';
require_once __DIR__.'/classes/Registration.php';
$ret_val = array();
if (isset($_POST["func"])){
	//echo("outside");
	switch($_POST["func"]){
		case "login":
			$login_obj = new Login($_POST['username'],$_POST['password']);
			$ret_val = $login_obj->validateAndLogin();
			break;
		case "register":
			$reg_obj = new Registration($_POST['username'],$_POST['fullname'],$_POST['email'],$_POST['password'],$_POST['category'],NULL);
			$ret_val=$reg_obj->handleRegistration();
			break;
		case "confirm":
			$reg_obj = new Registration($_POST['username'],NULL,NULL,NULL,NULL,$_POST['activation_code']);
			$ret_val=$reg_obj->register();
			break;	
	}
	}
	exit(json_encode($ret_val));
// 	
// echo "HO";
// $login_obj = new Login('sen','password');
// $ret_val = $login_obj->validateAndLogin();
// print_r($ret_val);

?>
