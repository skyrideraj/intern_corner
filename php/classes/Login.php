<?php
/**
* Login class
*/
// require_once __DIR__.'../includes/initialize_database.php';
// require_once __DIR__.'User.php';
// require_once 'Student.php';
// 
// require_once __DIR__.'/../includes/initialize_database.php';
require_once __DIR__.'/../includes/initialize_database.php';
require_once __DIR__.'/User.php';
require_once __DIR__.'/Student.php';


class Login
{	
	var $username;
	var $password;
	var $value = "An error has occurred";
	var $result = array("head" => array(), "body" => array() );
	var $db;
	function __construct($username,$password)
	{
		# code..
		$this->username = $username;
		$this->password = md5($password);
	}
	function getDatabase(){
		if(!isset($this->db)){
			$this->db = (new Database())->connectToDatabase();
		}
		// return $this->db;
	}
	function validateAndLogin()
	{	
		$xx = array($this->username,$this->password);
		$this->getDatabase();
		$username = $this->username;
		$password = $this->password;
		$this->db->query("SELECT * FROM User WHERE user_name = '$username' AND password='$password'");
		$result = $this->db->fetch_assoc_all();
		$num_rows = $this->db->returned_rows;
		if($num_rows==0){
			//no user found with username and passowrd combination, redirect to login page only
			return array('status_code'=>404,'detail'=>'login_page');

		}
		if($num_rows==1){
			//username and password exists and are cool
			$user = new User($result[0]['user_name'],$result[0]['full_name'],$result[0]['email'],$result[0]['account_type'],$result[0]['contact_details']);

			//start session variables
			session_start();
			$_SESSION['user'] = $user;
			//check if student
			if($result[0]['account_type']==2)//student
				{
					
					//extract student's information from student table
					$this->db->query("SELECT * FROM Student WHERE user_name='$this->username'");
					$result = $this->db->fetch_assoc_all();
					if($result[0]['profile_complete']==0){
						//user should be redirected to build profile page
						//accepted
						return array('status_code'=>201,'detail'=>'build_profile');

					}
					else{
						//user should be redirected to home screen

						return array('status_code'=>202,'detail'=>'home screen');
					}

				}
			else if($result[0]['account_type']==1||$result[0]['account_type']==3){
				//student or faculty
				return array('status_code'=>202,'detail'=>'home screen');
			}
			

		}			
	}
	
	static function logout()
	{
		session_start();
		if(Login::checkSetAndEmpty($_SESSION['user'])){
			//user logged in?
			//okay
			unset($_SESSION['user']);
			session_destroy();
			return array('status_code'=>200);

		}
		else{

			return array('status_code'=>400);
		}
	}
	static function checkSetAndEmpty($var){
		if(isset($var)&&!empty($var)){
			return true;
		}
		else return false;


	}
	static function forgotPasswordHandler($username){
		// $db = (new Database())->connectToDatabase();
		// $this->getDatabase();
		$db->query("SELECT email FROM User WHERE user_name='$username'");
		if($db->returned_rows==0){
			//username not found
			// 400 => 'Bad Request',
			return array('status_code'=>400,'detail'=>'username not found');
		}
		else{
			$result = $this->db->fetch_assoc_all();
			$password = $this->generateRandomPassword(10);  
			$this->sendRandomPassword($password,$result[0]['email']);
			$password = md5($password);
        	// 200 => 'OK', 
			$this->changePasswordHandler($username,$password);
        	//update password entry in User table
        	

			return array('status_code'=>200); 
		}
	}

	function generateRandomPassword($length){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,$length);
		// return  $this->randString(10);
	}
	function sendRandomPassword($password,$email){
		//TODO
		// add send mail code
	}

	function changePasswordHandler($username,$password){
		$this->getDatabase();

		$this->db->query("UPDATE User SET password='$password' WHERE user_name='$username'");


	}

}

session_start();
$login = new Login("testuser13","sen");
// print_r($_SESSION['user']);
$ret_val = $login -> validateAndLogin();
// print_r($ret_val);
// print_r($_SESSION['user']);
// $login -> logout();
// print_r($_SESSION['user']);
// 
// Login::logout();
// session_start();
// $login = new Login("sen","password");

// $ret_val = $login->validateAndLogin();
// print_r($ret_val);
// print($_SESSION['user']->username);
?>