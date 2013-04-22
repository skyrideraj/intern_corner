<<<<<<< HEAD
<?php

require_once __DIR__.'/../includes/initialize_database.php';
class experince
{
var $username;
var $title;
var $description;
var $experince_id;
var $designation;
var $timestamp;


function __construct($username,$title,$description,$designation,$experince_id,$timestamp)
{
$this->username=$username;
$this->title=$title;
$this->description=$description;
$this->designation=$designation;
$this->experince_id=$experince_id;
$this->timestamp=$timestamp;
}

function insertIntoDatabase()
{
$db = (new Database())->connectToDatabase();
//$db->insert('user_experince',array($this->username,$this->title,$this->description));
$db->query("INSERT INTO user_experince (`user_name`, `experince_title`, `experince_description`, `designation`) values('$this->username','$this->title','$this->description','$this->designation')");
return array('status_code'=>200,'detail'=>'experience posted');
}


static function deleteDescription($id)
{
@session_start();
$username=$_SESSION['user']->username;
$db = (new Database())->connectToDatabase();
	$db->query("SELECT * from user_experince where experince_id='$id' and user_name='$username'");
	$rows=$db->returned_rows;
	if($rows>0){
		$db->query("DELETE from user_experince where experince_id='$id' and user_name='$username'");
		return array('status_code'=>200,'detail'=>'Experience deleted');
		}
	else{
		return array('status_code'=>203,'detail'=>'not permitted');
	}
}

static function getExperincesByUser()
{
		@session_start();
		$username=$_SESSION['user']->username;
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from user_experince where user_name='$username'");
		$rows=$db->returned_rows;
		$result=$db->fetch_assoc_all();
		//print_r($row);
		if($rows>0){
		$result_send=array();
		for($i=0;$i<$rows;$i++){
				$tosend = new experince($result[$i]['user_name'],$result[$i]['experince_title'],$result[$i]['experince_description'],$result[$i]['designation'],$result[$i]['experince_id'],$result[$i]['timestamp']);
				array_push($result_send, $tosend);
		}
		return array('status_code'=>200,'result'=>$result_send);
		}
		else
			return array('status_code'=>404,'detail'=>'user not found');

}




static function getExperince($id)
{
		@session_start();
		$username=$_SESSION['user']->username;
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from user_experince where experince_id='$id'");
		$rows=$db->returned_rows;
		$result=$db->fetch_assoc_all();
		//print_r($row);
		if($rows>0){
		$result_send=array();
		$i=0;
				$tosend = new experince($result[$i]['user_name'],$result[$i]['experince_title'],$result[$i]['experince_description'],$result[$i]['designation'],$result[$i]['experince_id'],$result[$i]['timestamp']);
				array_push($result_send, $tosend);
		
		return array('status_code'=>200,'result'=>$result_send);
		}
		else
			return array('status_code'=>404,'detail'=>'user not found');

}




static function getAllExperinces($page_no)
{
		$page_length=10;
		$db=(new Database())->connectToDatabase();
		$no_of_posts = $page_length*$page_no+$page_length;
		$db->query("SELECT * from user_experince ORDER BY timestamp DESC LIMIT $no_of_posts ");
		$rows_ret=$db->returned_rows;
		$result=$db->fetch_assoc_all();	
		if($rows_ret>0){
				$result_send=array();
				$low = $page_no*$page_length;
				$high = $low+$page_length;
				$results_to_send = array();
					for($i=$low;$i<$high&&$i<$rows_ret;$i++){
					$tosend = new experince($result[$i]['user_name'],$result[$i]['experince_title'],$result[$i]['experince_description'],$result[$i]['designation'],$result[$i]['experince_id'],$result[$i]['timestamp']);
					array_push($result_send, $tosend);
				}
			return array('status_code'=>200,'result'=>$result_send);	
			}
		else
			return array('status_code'=>404,'detail'=>'database empty');

}


  function editExperince($field1,$value,$id){
		
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from user_experince where user_name='$this->username' and experinceid='$id' ");
		$rows=$db->returned_rows;
		if($rows==1)
		{
			$db->query("UPDATE user_experince set $field1='$value' where user_name='$this->username' and experinceid='$id' ");
			return array('status_code'=>200);
		}
		else 
			return array('status_code'=>404,'detail'=>'user not found');

	}

}

//$eid=new experince("sky34","title","desc","Software intern");
//$eid->insertIntoDatabase();

?>
=======
<?php

require_once '../includes/initialize_database.php';
class experince
{
var $username;
var $title;
var $description;
var $experinceid;


function __construct($username,$title,$description,$id)
{
$this->experinceid=$id;
$this->username=$username;
$this->title=$title;
$this->description=$description;
}

function insertIntoDatabase()
{
$db = (new Database())->connectToDatabase();
$db->query("SELECT * FROM user_experince where experinceid='$this->experinceid'");
$rows=$db->returned_rows;
if($rows==1)
{
	return array('status_code'=>400 , 'detail'=> "already exists");
}
else 
{
$db->query("INSERT INTO user_experince values('$this->username','this->experinceid','$this->title','$this->description')");
return array('status_code'=>200);
}
}

function deleteExperince()
{
$db = (new Database())->connectToDatabase();
$db->query("SELECT * FROM user_experince where experinceid='$this->experinceid'");
$rows=$db->returned_rows;
echo "<br>".$rows;
if($rows==1)
{
$db->query("DELETE from user_experince where experinceid=$this->experinceid");
return array('status_code'=>200);
}
else 
return array('status_code'=>404, 'detail'=>'comment not found');
}


}

$eid=new experince(11,123,12354,7);
$eid->deleteExperince();
echo $eid->deleteExperince()['detail'];
?>
>>>>>>> a84ff92c4e6e02a26c77a9ea0d98ea4879eaddf7
