<?php
require_once __DIR__.'/./User.php';
require_once __DIR__.'/../includes/initialize_database.php';


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


		static function professorRate($faculty,$rate){ //$faculty is students username
		@session_start();
		$username=$_SESSION['user']->username;
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from rating where student_user_name='$faculty'and faculty_user_name='$username' ");
		$rows=$db->returned_rows;
		if($rows==1)
			return array('status_code'=>400,'detail'=>'already rated');
		else
		{
			$db->query("INSERT INTO rating values('$faculty','$username','$rate')");
			return array('status_code'=>200);
		}
	}





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
		$db->query("INSERT INTO faculty values ('$this->username','$this->other_details','$this->project_details')");
		$aoe=$this->area_of_expertise;
		$aoi=$this->area_of_interest;
		Faculty :: updateAreasOfInterest(1,'$aoi' );
		Faculty :: updateAreasOfExpertise(1,'$aoe');
		return array('status_code'=>200);
		}
	}

static function bulidProfile($area_of_intrest,$area_of_expertise,$proj_info,$other_info)
{
@session_start();
$username=$_SESSION['user']->username;
$x=Faculty::updateAreasOfIntrest2(1,$area_of_intrest);
$y=Faculty::updateAreasOfExpertise2(1, $area_of_expertise);
 $z=Faculty::editProfile('other_details',$other_info);
 $w=Faculty::editProfile('project_details',$proj_info);
if(($x['status_code']==200)&&($y['status_code']==200)&&($z['status_code']==200)&&($w['status_code']==200))
return array('status_code'=>200);  
else
return array('status_code'=>400,'details'=>'bad request');  
}


	/*static function displayProfile(){

	@session_start();
	$username=$_SESSION['user']->username;
	//echo $username;
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from faculty where user_name='$username' ");
		//$result=array();
		$rows=$db->returned_rows;
		if($rows==1)
		{
			$row=$db->fetch_assoc_all();
			foreach($row[0] as $index=>$value){
				$result[$index]=$value;
			}
			$db->query("SELECT * from user where user_name='$username'");
			$row=$db->fetch_assoc_all();
			foreach($row[0] as $index=>	$value){
				$result[$index]=$value;
			}
			$db->query("SELECT * from faculty_area_of_intrest where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++)
			{		
				$result['area_of_interest'][$i]=$row[$i]['area_of_intrest'];
			}
			$db->query("SELECT * from faculty_area_of_expertise where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++)
			{		
				$result['area_of_expertise'][$i]=$row[$i]['area_of_expertise'];
			}



			$db->query("SELECT * from user_experince where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++)
			{		
				$result['experince'][$i]=array();
				$result['experince'][$i]['title']=$row[$i]['experince_title'];
				$result['experince'][$i]['description']=$row[$i]['experince_description'];
			}



			return array('status_code'=>200,'result'=>$result);
		}
		else
			return array('status_code'=>404,'detail'=>'user not found');

	}*/
	
	static function displayProfile(){

	@session_start();
	$username=$_SESSION['user']->username;
	//echo $username;
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from faculty where user_name='$username' ");
		//$result=array();
		$rows=$db->returned_rows;
		if($rows==1)
		{
			$row=$db->fetch_assoc_all();
			foreach($row[0] as $index=>$value){
				$result[$index]=$value;
			}
			$db->query("SELECT * from user where user_name='$username'");
			$row=$db->fetch_assoc_all();
			foreach($row[0] as $index=>	$value){
				$result[$index]=$value;
			}
			$db->query("SELECT * from faculty_area_of_intrest where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++)
			{		
				$result['area_of_interest'][$i]=$row[$i]['area_of_intrest'];
			}
			$db->query("SELECT * from faculty_area_of_expertise where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++)
			{		
				$result['area_of_expertise'][$i]=$row[$i]['area_of_expertise'];
			}

			$db->query("SELECT * from tag_table where tag_id in (SELECT tag_id from  tag_subscribed where user_name='$username')");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			if($rows>0){
			for($i=0;$i<$rows;$i++)
			{		
			$result['tag'][$i]=$row[$i];
			}
			}
			else 
				$result['tag']="";

			$db->query("SELECT * from user_experince where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++)
			{		
				$result['experince'][$i]=array();
				$result['experince'][$i]['title']=$row[$i]['experince_title'];
				$result['experince'][$i]['description']=$row[$i]['experince_description'];
			}



			return array('status_code'=>200,'result'=>$result);
		}
		else
			return array('status_code'=>404,'detail'=>'user not found');

	}


	static function updateAreasOfIntrest2($type, $area_of_interest){
	$arr=explode(';',$area_of_interest);
	$s=array();
	$return_s=0;
	$acrazy="";
	//$return_s=3;
	for($i=0;$i<sizeof($arr);$i++){
	$crazy=$arr[$i];
	if($crazy!="" && $crazy!=" "){
	$s1=Faculty::updateAreasOfInterest($type,$arr[$i]);
	$s[$i]=$s1['status_code'];
		}
	}
		//print_r($s);
		for($i=0;$i<sizeof($s);$i++)
		if ($s[$i]==404){
		$return_s=1;
		}
		if($return_s==0)
		  return array('status_code'=>200);
		else
		return array('status_code'=>400);
	}
	static function updateAreasOfExpertise2($type, $area_of_interest){
	$arr=explode(';',$area_of_interest);
	$s=array();
	$return_s=0;
	$acrazy="";
	//$return_s=3;
	for($i=0;$i<sizeof($arr);$i++){
	$crazy=$arr[$i];
	if($crazy!="" && $crazy!=" "){
	$s1=Faculty::updateAreasOfExpertise($type,$arr[$i]);
	$s[$i]=$s1['status_code'];

	}
		}
	for($i=0;$i<sizeof($s);$i++)
		if ($s[$i]==404){
		$return_s=1;
		}
		if($return_s==0)
		  return array('status_code'=>200);
		else
		return array('status_code'=>400);
	}


	 static function updateAreasOfInterest($type, $area_of_interest){
		@session_start();
		$username=$_SESSION['user']->username;
		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from faculty_area_of_intrest where user_name='$username' and area_of_intrest='$area_of_interest'");
			$rows=$db->returned_rows;
			if($rows==0)
				$db->query(" INSERT INTO faculty_area_of_intrest values ('$username','$area_of_interest')");
				return array('status_code'=>200);
				
		}
		if($type==-1)
		{	
			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from faculty_area_of_intrest where user_name='$username' and area_of_intrest='$area_of_interest'");
			$rows=$db->returned_rows;
			if($rows==1)
			{
			$db->query("DELETE FROM faculty_area_of_intrest WHERE user_name='$username' and area_of_intrest='$area_of_interest';");
			return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404, 'detail'=> 'area of intreset not found'); 
		}

	}


	static function updateAreasOfExpertise($type, $area_of_expertise){
		@session_start();
		$username=$_SESSION['user']->username;
		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from faculty_area_of_expertise where user_name='$username' and area_of_expertise='$area_of_expertise'");
			$rows=$db->returned_rows;
			if($rows==0)
				$db->query(" INSERT INTO faculty_area_of_expertise values ('$username','$area_of_expertise')");
				return array('status_code'=>200);
				
		}
		if($type==-1)
		{
			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from faculty_area_of_expertise where user_name='$username' and area_of_expertise='$area_of_expertise'");
			$rows=$db->returned_rows;
			if($rows==1)
			{
			$db->query("DELETE FROM faculty_area_of_expertise WHERE user_name='$username' and area_of_expertise='$area_of_expertise';");
			return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404, 'detail'=> 'area of intreset not found'); 
		}

	}

	 static function updateExperience($type,$experince_id,$experine_title,$experince_description){
		session_start();
		$username=$_SESSION['user']->username;


		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from user_experince where experinceid='$experince_id' ");
			$rows=$db->returned_rows;

			if($rows==1)
				return array('status_code'=>400, 'detail'=> 'already exists'); 
			else
			{
			$name=$username;	
			//echo "111".$name."222";

			$db->query("INSERT INTO user_experince values('$name','$experince_id','$experine_title','$experince_description')");
			return array('status_code'=>200);
			}
		}
		if($type==-1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from user_experince where experinceid='$experince_id' ");
			$rows=$db->returned_rows;
			if($rows==1)
			{
				$db->query("DELETE FROM user_experince WHERE user_name='$username' and experinceid='$experince_id';");
				return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404, 'detail'=> 'area of intreset not found');

		}
	}

	static function editProfile($field1,$value){
		@session_start();
		$username=$_SESSION['user']->username;
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from faculty where user_name='$username'");
		$rows=$db->returned_rows;
		if($rows==1)
		{
			$db->query("UPDATE faculty set $field1='$value' where user_name='$username' ");
			return array('status_code'=>200);
		}
		else 
			return array('status_code'=>404,'detail'=>'user not found');

	}



	function __construct($username,$full_name,$email_id,$contact_details,$account_type,$oter_details,$project_details,$area_of_expertise,$reputation,$areas_of_interest,$profile_complete,$experience)
	{
		# code...
		parent::__construct($username,$full_name,$email_id,$account_type,$contact_details);
		$this->reputation=$reputation;
		$this->areas_of_interest=$areas_of_interest;
		$this->profile_complete=$profile_complete;
		$this->experience=$experience;
		$this->areas_of_expertise=$area_of_expertise;
		$this->other_details=$oter_details;
		$this->project_details=$project_details;
		$this->reputation=$reputation;
	}



}



//print_r(Faculty :: displayProfile()['result']['experince'][0][0]);

//$fac= new Faculty('12211','a','a','a',2,'a','a','a',10,'a',FALSE,'ab');
//$fac->addToDatabase();
//Faculty::updateAreasOfExpertise(1,'aaaa');
//Faculty::updateAreasOfInterest(-1,'aaaaaaaaaaaaaaa');
//$fac->updateExperience(-1,'111111111','1234','12345');
//Faculty::editProfile('other_details','123456111111');
//


?>