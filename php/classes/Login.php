<?
/**
* Login class
*/
require_once '../includes/initialize_database.php';
class Login
{	
	private $username;
	private $password;

	
	function __construct($username,$password)
	{
		# code...
		$this->$username = $username;
		$this->$password = md5($password);
	}
	function validateAndLogin()
	{	
		$db = (new Database())->connectToDatabase();
		$db->select('user_name','User');
		$result = $db->fetch_assoc_all();
		echo($result[0]['user_name']);
		while ( $row = $db->fetch_assoc()) {
			# code...
			// echo "Hi";
			echo($row['user_name']);
			// echo(gettype($row));
			// print_r($row);
		}
	}
}
$login = new Login('abc','abc');
$login -> validateAndLogin();
?>