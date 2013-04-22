<?php
require_once __DIR__.'/./User.php';
require_once __DIR__.'/../includes/initialize_database.php';


class alumni{


var $username;
var $pastinternship;
var $current_employee;
var $other_details;
var $other_emailid;
var $past_companies;
var $area_of_interest;





/*static function displayProfile(){

	@session_start();
	$username=$_SESSION['user']->username;
	//echo $username;
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from allumni where user_name='$username' ");
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
			$db->query("SELECT * from alumni_area_of_intrest where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++)
			{		
				$result['area_of_interest'][$i]=$row[$i]['area_of_intrest'];
			}
			$db->query("SELECT * from alumni_past_companies where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++)
			{		
				$result['past_companies'][$i]=$row[$i]['past_companies'];
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
		$db->query("SELECT * from allumni where user_name='$username' ");
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
			$db->query("SELECT * from alumni_area_of_intrest where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++)
			{		
				$result['area_of_interest'][$i]=$row[$i]['area_of_intrest'];
			}
			$db->query("SELECT * from alumni_past_companies where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++)
			{		
			//echo "aaa";
				$result['past_companies'][$i]=$row[$i]['past_companies'];
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



static function buildProfile($other,$past_company,$past_int,$current_emp,$email)
{
	@session_start();
	$username=$_SESSION['user']->username;
	$x=Alumni::editProfile('current_employee',$current_emp)['status_code'];
	$y=Alumni::editProfile('past_internship',$past_int)['status_code'];
	$z=Alumni::editProfile('other_details',$other)['status_code'];
	$w=Alumni::editProfile('other_emailid',$email)['status_code'];
	$a=Alumni::updatePastCompanies2(1,$past_company)['status_code'];
	//echo $x."<br>".$y."<br>".$z."<br>".$w."<br>".$a."<br>";
	
	if(($x==200)&&($y==200)&&($z==200)&&($w==200)&&($a==200))
		return array('status_code'=>200);  
	else
		return array('status_code'=>400,'details'=>'bad request');  
	
}






static function updateAreasOfInterest($type, $area_of_interest){
	session_start();
		$username=$_SESSION['user']->username;
		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from alumni_area_of_intrest where user_name='$username' and area_of_intrest='$area_of_interest'");
			$rows=$db->returned_rows;
			if($rows==1)
				return array('status_code'=>400, 'detail'=> 'already exists'); 
			else{				
				$db->query(" INSERT INTO alumni_area_of_intrest values ('$username','$area_of_interest')");
				return array('status_code'=>200);
				}
		}
		if($type==-1)
		{	
			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from alumni_area_of_intrest where user_name='$username' and area_of_intrest='$area_of_interest'");
			$rows=$db->returned_rows;
			if($rows==1)
			{
			$db->query("DELETE FROM alumni_area_of_intrest WHERE user_name='$username' and area_of_intrest='$area_of_interest';");
			return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404, 'detail'=> 'area of intreset not found'); 
		}

	}

	
	
	static function updatePastCompanies2($type, $area_of_interest){
		$arr=explode(';',$area_of_interest);
		$s=array();
		$return_s=0;
		$crazy="";
		//echo 1;
	//$return_s=3;
		for($i=0;$i<sizeof($arr);$i++){
		//echo 2;
		$crazy=$arr[$i];
		if($crazy!="" && $crazy!=" "){
		//echo 3;
		$s1=Alumni::updatePastCompanies($type,$arr[$i]);
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
	


	static function updatePastCompanies($type, $past_companies){
		@session_start();
		$username=$_SESSION['user']->username;
		if($type==1)
		{
		//echo 4;

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from alumni_past_companies where user_name='$username' and past_companies='$past_companies'");
			$rows=$db->returned_rows;
			if($rows==0)
				$db->query(" INSERT INTO alumni_past_companies values ('$username','$past_companies')");
				return array('status_code'=>200);
				
		}
		if($type==-1)
		{
			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from alumni_past_companies where user_name='$username' and past_companies='$past_companies'");
			$rows=$db->returned_rows;
			if($rows==1)
			{
			$db->query("DELETE FROM alumni_past_companies WHERE user_name='$username' and past_companies='$past_companies';");
			return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404, 'detail'=> 'area of intreset not found'); 
		}

	}



	function addToDatabase()
	{
		
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from allumni where user_name='$this->username'");
		$rows=$db->returned_rows;
		if($rows==1)
		{
			return array('status_code'=>400, 'detail'=> 'already exists');
		}
		else 
		{
		$db->query("INSERT INTO allumni values ('$this->username','$this->current_employee','$this->pastinternship','$this->other_details','$this->other_emailid')");
		$pc=$this->past_companies;
		$aoi=$this->area_of_interest;
		Alumni :: updateAreasOfInterest(1,'$aoi' );
		Alumni :: updatePastCompanies(1,'$apc');
		return array('status_code'=>200);
		}
	}



	static function editProfile($field1,$value){
		@session_start();
		$username=$_SESSION['user']->username;
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from allumni where user_name='$username'");
		$rows=$db->returned_rows;
		if($rows==1)
		{
			$db->query("UPDATE allumni set $field1='$value' where user_name='$username' ");
			return array('status_code'=>200);
		}
		else 
			return array('status_code'=>404,'detail'=>'user not found');

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




	




function __construct($username,$pastinternship,$current_employee,$other_details,$other_emailid,$area_of_interest,$past_companies){
	$this->username=$username;
	$this->pastinternship=$pastinternship;
	$this->current_employee=$current_employee;
	$this->other_details=$other_details;
	$this->other_emailid=$other_emailid;
	$this->past_companies=$past_companies;
	$this->area_of_interest=$area_of_interest;

}

}
//$alum=new alumni('a11111','a','a','a','a111','a','a');
//$alum->addToDatabase();
//Alumni::updatePastCompanies(-1,'aaa11');
//Alumni::updateAreasOfInterest(-1,'a111aaaaaaa');
//Alumni::editProfile('current_employee','1211134');
//print_r(Alumni::displayProfile()['result']);

//Alumni::buildProfile('other','past_company','past_int','current_emp','email');

//$A=Alumni::displayProfile();
//print_r($A['result']);


?>