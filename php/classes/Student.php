<?php
require_once __DIR__.'/./User.php';
require_once __DIR__.'/../includes/initialize_database.php';

class Student extends User
{
	var $field;
	var $cpi;
	var $batch;
	var $reputation;
	var $profile_complete;
	var $professor_rating_average;
	var $resume;
	var $experience;
	var $areas_of_interest;
	var $other_email_id;
	var $other_details;

	function professorRate($faculty,$rate){

		$db=(new Database())->connectToDatabase;
		$db->query("SELECT * from rating where student_user_name='$this->username'and faculty_user_name='$faculty' ");
		$rows=$db->returned_rows;
		if($rows==1)
			return array('status_code'=>400,'detail'=>'already rated');
		else
		{
			$db->query("INSERT INTO rating values($this->username,$faculty,$rate)");
			return array('status_code'=>200);
		}
	}
	function displayProfile(){
		
	}
	function updateProfile($student){



	}
	function updateUser($username,$full_name){

	}
	function updateStudent(){

	}


	function addToDatabase()
	{
		$db=(new Database())->connectToDatabase;
		$db=query("INSERT INTO student values ('this->username','this->professor_rating_average','this->cpi','this->batch','this->other_email_id','this->other_details','this->resume','this->reputation')");
		return array('status_code'=>200);
	
	}

	function updateAreasOfInterest($type, $area_of_interest){
		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query(" INSERT INTO student_area_of_intrest values ($this->username,'$area_of_interest')");
			return array('status_code'=>200);
		}
		if($type==-1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT FROM student_area_of_intrest WHERE user_name='$this->username' and area_of_intrest=$area_of_interest;" );
			$rows=$db->returned_rows;
			if($rows=1)
			{
			$db->query("DELETE FROM student_area_of_intrest WHERE user_name='$this->username' and area_of_intrest=$area_of_interest;");
			return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404,'detail'=>'comment not found');
		}

	}

	function updateExperience($type,$experince_id,$experine_title,$experince_description){


		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("INSERT INTO user_experince values('$this->$username','$experince_id','$experince_title','$experince_description')");
			return array('status_code'=>200);
		}
		if($type==-1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * FRom user_experince where user_name='this->username'and experinceid=$experince_id");
			//echo $db->query("SELECT * FRom user_experince where user_name='this->username'and experinceid=$experince_id");
			$rows=$db->returned_rows;
			echo "<br>";
			echo $rows;
			if ($rows==1)
			{
			$db->query("DELETE FROM user_experince WHERE user_name='$this->username' and experinceid='$experince_id';");
			return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404,'detail'=>'comment not found');
		}



	}


	function updateField($type,$field){
		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT  * from field where user_name='$this->username'");
			$rows=$db->returned_rows;
			if ($rows==1)
			{
				$db->query("UPDATE field SET '$field'=1 where user_name='$this->username';");
				return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404,'detail'=>'comment not found');

		}
		if($type==-1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT  * from field where user_name='$this->username'");
			$rows=$db->returned_rows;
			if ($rows==1)
			{
				$db->query("UPDATE field SET '$field'=0 where user_name='$this->username';");
				return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404,'detail'=>'comment not found');

		}
	}
	
	function __construct($username,$full_name,$email_id,$contact_details,$account_type,$other_email_id,$other_details,$field,$cpi,$batch,$reputation,$areas_of_interest,$profile_complete,$professor_rating_average,$resume,$experience)
	{
		# code...
		parent::__construct($username,$full_name,$email_id,$account_type,$contact_details);

		$this->field=$field;
		$this->cpi=$cpi;
		$this->batch=$batch;
		$this->reputation=$reputation;
		$this->areas_of_interest=$areas_of_interest;
		$this->profile_complete=$profile_complete;
		$this->professor_rating_average=$professor_rating_average;
		$this->resume=$resume;
		$this->experience=$experience;
		$this->other_details=$other_details;
		$this->other_email_id=$other_email_id;

	}


}

//$stud= new Student('11','a','a','a',1,'a','a','ct',5,'btech',0,NULL,NULL,NULL,NULL,NULL);
//$stud->updateAreasOfInterest(-1,"area_of_interest13");

//$stud->updateExperience(-1,5,'1234','1234');
//echo $stud->updateExperience(-1,5,'1234','1234')['detail'];

?>