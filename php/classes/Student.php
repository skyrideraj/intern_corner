<?php
//echo 111;
require_once __DIR__.'/./User.php';
require_once __DIR__.'/../includes/initialize_database.php';
//echo 333;
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

	function professorRate($faculty,$rate){
		$db=(new Database())->connectToDatabase;
		$db->query("INSERT INTO rating values($this->user_name,$faculty,$rate)");

	}
	function displayProfile(){
		
	}
	function updateProfile($student){



	}
	function updateUser($username,$full_name){

	}
	function updateStudent(){

	}


	function updateAreasOfInterest($type, $area_of_interest){
		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			echo $this->username;
			$db->query(" INSERT INTO student_area_of_intrest values ('$this->username','$area_of_interest')");
		}
		if($type==-1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("DELETE FROM student_area_of_intrest WHERE user_name='$this->username' and area_of_intrest='$area_of_interest';");
		}

	}

	function updateExperience($experince_id,$experine_title,$experince_description,$type){


		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("INSERT INTO user_experince values('$this->$username','$experince_id','$experince_title','$experince_description')");
		}
		if($type==-1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("DELETE FROM user_experince WHERE user_name='$this->username'and experince_id='$experince_id';");
		}



	}


	function updateField($field,$type){
		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			echo "$this->username";
			$db->query("UPDATE field SET '$field'=1 where user_name='$this->username';");
		}
		if($type==-1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("UPDATE field SET '$field'=0 where user_name='$this->username';");

		}
	}
	
	function __construct($username,$full_name,$email_id,$contact_details,$account_type,$field,$cpi,$batch,$reputation,$areas_of_interest,$profile_complete,$professor_rating_average,$resume,$experience)
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
	}


}

$stud= new Student('a','a','a','a',1,'ct',5,'btech',0,NULL,NULL,NULL,NULL,NULL);
//$student->updateAreasOfInterest(-1,"area_of_interest11");
?>