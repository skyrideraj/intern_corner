
<?php
/**
* 
*/
require_once __DIR__.'/../includes/initialize_database.php';
class Registration
{

	var $username;
	var $full_name;
	var $email;
	var $account_type;
	var $activation_code;
	var $hashed_password;
	
	function __construct($username,$full_name,$email,$password,$account_type,$activation_code)
	{
		# code...
		$this->username=$username;
		$this->full_name=$full_name;
		$this->email=$email;
		$this->hashed_password=md5($password);
		$this->account_type=$account_type;
		$this->activation_code=$activation_code;
	}


	function generateActivationCode(){
		$this->activation_code = rand(1000,9999);
		// return $activation_code;
	}

	function sendActivationCode(){
		//mail code to email id
	}
	function validateDetails(){
		$db = (new Database())->connectToDatabase();
		$db->query("SELECT * FROM User WHERE user_name='$this->username'");
		if($db->returned_rows>=1){
		return false;
		}
	$db->query("SELECT * FROM Activation_Codes WHERE user_name='$this->username'");
	if($db->returned_rows>=1){
		return false;
		}
	return true;	

	}

	function handleRegistration(){
		$valid = $this->validateDetails();
		if($valid==false){
			//precondition failed... username already exists
			return array('status_code'=>412,'detail'=>'username already exists');
		}
		else{
			$this->generateActivationCode();
			$this->sendActivationCode();
			//enter details in Activation_Codes table
			$db = (new Database())->connectToDatabase();
			$db->insert('Activation_Codes',array('user_name'=>$this->username,'full_name'=>$this->full_name,'email'=>$this->email,'account_type'=>$this->account_type,'password'=>$this->hashed_password,'activation_code'=>$this->activation_code));
			return array('status_code'=>200);
			
		}
	}

	function register(){
		
		//called when user enters activation code
		//construct an object with username, NULL, NULL, NULL ,NULL

		//check if correct activation code
		$db = (new Database())->connectToDatabase();
		$db->query("SELECT * FROM Activation_Codes WHERE user_name='$this->username' AND activation_code='$this->activation_code'");
		if($db->returned_rows==0){
			return array('status_code'=>400,'detail'=>"username doesn't exist in the table or wrong activation code");
		}
		//successful
		//move entries to User table
		$result = $db->fetch_assoc_all();
		$db->insert('User',array('user_name' => $result[0]['user_name'], 'full_name' =>$result[0]['full_name'] ,'email' => $result[0]['email'],'account_type' => $result[0]['account_type'],'password' => $result[0]['password'],'contact_details' =>NULL));
		$db->query("DELETE from Activation_Codes WHERE user_name='$this->username'");
		return array('status_code'=>200);
	}
	
	

}


//testing.....


    /*$username = $_POST['username'];
	$full_name = $_POST['fullname'];
    $password = $_POST['password'];
	$email = $_POST['email'];
	$account_type = $_POST['category'];
	$activation_code;
    $reg = new Registration($username,$full_name,$email,$password,$account_type,NULL);
    $reg->handleRegistration();*/
// $reg = new Registration('testuser',NULL,NULL,NULL,NULL,73);
// $reg->register();
// session_start();
// print_r($_SESSION['user']);

?>
