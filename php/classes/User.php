<?
/**
* 
*/
class User
{	
	var $username;
	var $full_name;
	var $email;
	var $account_type;
	var $activated;


	function __construct($username,$full_name,$email,$account_type,$activated)
	{
		# code...
		$this->username=$username;
		$this->full_name=$full_name;
		$this->email=$email;
		$this->account_type=$account_type;
		$this->activated=$activated;
	}

	
	
	
}
?>