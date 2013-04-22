<?php
// echo "hi";
// $request = $_SERVER['REQUEST_URI'];
// $params = explode("/", $request);
// print_r($params);
require_once __DIR__.'/classes/Login.php';
require_once __DIR__.'/classes/Registration.php';
require_once __DIR__.'/classes/Post.php';
$ret_val = array();
if (isset($_POST["func"])){
switch($_POST["func"]){
case "login":
$login_obj = new Login($_POST['username'],$_POST['password']);
$ret_val = $login_obj->validateAndLogin();
break;
case "registration":
$reg_obj = new Registration($_POST['username'],$_POST['full_name'],$_POST['email'],$_POST['password'],$_POST['account_type'],NULL);
$ret_val = $reg_obj->handleRegistration();
break;
case "register":
$reg_val = Registration::register($_POST['username'],$_POST['activation_code']);
break;
case "logout":
$reg_val = Login::logout();
break;
case "extractPost":
$ret_val = Post::extractPosts($_POST['page_no']);	
break;


}
}
exit(json_encode($ret_val));


///////////////////////////////
// TESTING OF CONTROLLER.php //
///////////////////////////////
//
// echo "HO";
// $login_obj = new Login('sen','password');
// $ret_val = $login_obj->validateAndLogin();
// print_r($ret_val);
//
//



?>