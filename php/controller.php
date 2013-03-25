<?php
require_once __DIR__.'/classes/Login.php';
$ret_val = array();
if (isset($_POST["func"])){
	switch($_POST["func"]){
		case "login":
			$login_obj = new Login($_POST['username'],$_POST['password']);
			$ret_val = $login_obj->validateAndLogin();
	}
	}
	exit(json_encode($ret_val));
// 	
// echo "HO";
// $login_obj = new Login('sen','password');
// $ret_val = $login_obj->validateAndLogin();
// print_r($ret_val);

?>
