<?php
/**
* 
*/
class User
{	
	var $username;
	var $full_name;
	var $email;
	var $account_type;


	function __construct($username,$full_name,$email,$account_type)
	{
		# code...
		$this->username=$username;
		$this->full_name=$full_name;
		$this->email=$email;
		$this->account_type=$account_type;
	}
	function getUsername(){
		return $this->username;
	}
	static function subscribeDigest(){
	@session_start();
	$username = $_SESSION['user']->username;
	$db = (new Database())->connectToDatabase();
	$db->query("UPDATE user SET digest=1 where user_name='$username'");
	return array('status_code'=>200);
}
	static function unSubscribeDigest(){
	@session_start();
	$username = $_SESSION['user']->username;
	$db = (new Database())->connectToDatabase();
	$db->query("UPDATE user SET digest=0 where user_name='$username'");
	return array('status_code'=>200);
}
	
	
	
}
?>