<?
require_once 'User.php';
/**
* 
*/
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
	function professorRate(){

	}
	function displayProfile(){
		
	}
	function updateProfile($student){



	}
	function updateUser($username,$full_name){

	}
	function updateStudent(){

	}
	function updateAreasOfInterest(){

	}
	function updateExperience(){

	}
	function updateField(){

	}
	
	function __construct($username,$full_name,$email_id,$contact_details,$account_type,$field,$cpi,$batch,$reputation,$areas_of_interest,$profile_complete,$professor_rating_average,$resume,$experience)
	{
		# code...
		parent::__construct($username,$full_name,$email,$account_type,$contact_details);

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
?>