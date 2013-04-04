<?php
require_once '../includes/initialize_database.php';
require_once 'User.php';


class Faculty extends User
{
	
	var $area_of_interest;
	var $area_of_expertise;
	var $ohter_details;
	var $project_details;
	var $profile_complete;
	var $experience;
	var $areas_of_interest;
	var $reputation;





	function addToDatabase()
	{
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from faculty where user_name='$this->username'");
		$rows=$db->returned_rows;
		if($rows==1)
		{
			return array('status_code'=>400, 'detail'=> 'already exists');
		}
		else 
		{
		$db->query("INSERT INTO faculty values ('this->username','this->other_details','this->project_details')");
		return array('status_code'=>200);
		}
	}
	function updateAreasOfInterest($type, $area_of_interest){
		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from faculty_area_of_intrest where user_name='$this->username' and area_of_interest='$area_of_interest'");
			$rows=$db->returned_rows;
			if(rows==1)
				return array('status_code'=>400, 'detail'=> 'already exists'); 
			else{				
				$db->query(" INSERT INTO faculty_area_of_intrest values ('$this->username','$area_of_interest')");
				return array('statsu_code'=>200);
				}
		}
		if($type==-1)
		{
			$db->query("SELECT * from faculty_area_of_intrest where user_name='$this->username' and area_of_interest='$area_of_interest'");
			$rows=$db->returned_rows;
			if(rows==1)
			{
			$db->query("DELETE FROM faculty_area_of_intrest WHERE user_name='$this->username' and area_of_intrest='$area_of_interest';");
			return array('statsu_code'=>200);
			}
			else 
				return array('status_code'=>404, 'detail'=> 'area of intreset not found'); 
		}

	}


	function updateAreasOfExpertise($type, $area_of_expertise){
		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from faculty_area_of_expertise where user_name='$this->username' and area_of_expertise='$area_of_expertise'");
			$rows=$db->returned_rows;
			if(rows==1)
				return array('status_code'=>400, 'detail'=> 'already exists'); 
			else{				
				$db->query(" INSERT INTO faculty_area_of_expertise values ('$this->username','$area_of_expertise')");
				return array('status_code'=>200);
				}
		}
		if($type==-1)
		{
			$db->query("SELECT * from faculty_area_of_expertise where user_name='$this->username' and area_of_expertise='$area_of_expertise'");
			$rows=$db->returned_rows;
			if(rows==1)
			{
			$db->query("DELETE FROM faculty_area_of_expertise WHERE user_name='$this->username' and area_of_expertise='$area_of_expertise';");
			return array('statsu_code'=>200);
			}
			else 
				return array('status_code'=>404, 'detail'=> 'area of intreset not found'); 
		}

	}

	function updateExperience($experince_id,$experine_title,$experince_description,$type){


		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from user_experince where experinceid='$experinceid' ");
			$rows=$db->returned_rows;
			if($rows==1)
				return array('status_code'=>400, 'detail'=> 'already exists'); 
			else
			{
			$db->query("INSERT INTO user_experince values('$this->$username','$experince_id','$experince_title','$experince_description')");
			return array('statsu_code'=>200);
			}
		}
		if($type==-1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from user_experince where experinceid='$experinceid' ");
			$rows=$db->returned_rows;
			if($rows==1)
			{
				$db->query("DELETE FROM user_experince WHERE user_name='$this->username' and experinceid='$experince_id';");
				return array('statsu_code'=>200);
			}
			else 
				return array('status_code'=>404, 'detail'=> 'area of intreset not found');

		}
	}

	function updateProfile()
	{
		//say can write another class calling the methods as per requirements 		
	}



	function __construct($username,$full_name,$email_id,$contact_details,$account_type,$oter_details,$project_details,$area_of_expertise,$reputation,$areas_of_interest,$profile_complete,$experience)
	{
		# code...
		parent::__construct($username,$full_name,$email_id,$account_type,$contact_details);
		$this->reputation=$reputation;
		$this->areas_of_interest=$areas_of_interest;
		$this->profile_complete=$profile_complete;
		$this->experience=$experience;
		$this->areas_of_expertise=$areas_of_expertise;
		$this->other_details=$other_details;
		$this->project_details=$project_details;
		$this->reputation=$reputation;
	}




$fac= new Faculty('13','a','a','a',2,'a','a','a',10,'a',FALSE,'ab');








}
?>