<?
/**
* Login class
*/
require_once '../includes/initialize_database.php';
require_once 'User.php';
require_once 'Student.php';
class Login
{	
	var $username;
	var $password;
	var $value = "An error has occurred";
	var $result = array("head" => array(), "body" => array() );
	function __construct($username,$password)
	{
		# code...
		$this->username = $username;
		$this->password = md5($password);
	}
	function validateAndLogin()
	{	
		$xx = array($this->username,$this->password);
		$db = (new Database())->connectToDatabase();
		$username = $this->username;
		$password = $this->password;
		$db->query("SELECT user_name, full_name, email, account_type, activated, password FROM User WHERE user_name = '$username' AND password='$password'");
		$result = $db->fetch_assoc_all();
		$num_rows = $db->returned_rows;
		if($num_rows==0){
			//no user found with username and passowrd combination, redirect to login page only
			return array('404','login_page');

		}
		if($num_rows==1){
			//username and password exits and are cool
			$user = new User($result[0]['user_name'],$result[0]['full_name'],$result[0]['email'],$result[0]['account_type']);
			//check if student
			if($result[0]['account_type']==2)//student
				{
					
					//extract students information from student table
					$db->SELECT('cpi, contact_details, batch, other_email_id, other_details, profile_complete, reputation', 'Student', 'user_name=?',array($this->username));
					
					$result = $db->fetch_assoc_all();
					if($result[0]['profile_complete']==0){
						//user should be redirected to build profile page
						return array('202','build_profile');

					}
					else{
						//user should be redirected to home screen

						return array('202','home screen');
					}

				}
			

		}
		
				
	}
}
$login = new Login("sen","sen");
$login -> validateAndLogin();
?>