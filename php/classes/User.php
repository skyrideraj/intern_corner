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
	var $contact_details;


	function __construct($username,$full_name,$email,$account_type,$contact_details)
	{
		# code...
		$this->username=$username;
		$this->full_name=$full_name;
		$this->email=$email;
		$this->account_type=$account_type;
		$this->contact_details=$contact_details;
	}
	function getUsername(){
		return $this->username;
	}

	
	
	
}
?>