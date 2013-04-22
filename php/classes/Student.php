<<<<<<< HEAD
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
	var $area_of_interest;
	var $other_email_id;
	var $other_details;

	
	static function professorRate($faculty,$rate){
		session_start();
		$username=$_SESSION['user']->username;
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from rating where student_user_name='$username'and faculty_user_name='$faculty' ");
		$rows=$db->returned_rows;
		if($rows==1)
			return array('status_code'=>400,'detail'=>'already rated');
		else
		{
			$db->query("INSERT INTO rating values('$username','$faculty','$rate')");
			return array('status_code'=>200);
		}
	}






/*static function displayProfile(){

	session_start();
	$username=$_SESSION['user']->username;
	
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from student where user_name='$username' ");
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
			$db->query("SELECT * from student_area_of_intrest where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			$result['area_of_interest']=array();
			for($i=0;$i<$rows;$i++)
			{		
				$result['area_of_interest'][$i]=$row[$i]['area_of_intrest'];
			}
			$db->query("SELECT * from field where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			foreach($row[0] as $index=>$value){
				$result[$index]=$value;
			}

			$db->query(" SELECT tag_name from tag_table where tagid in( SELECT tagid FROM opportunity_tags WHERE opportunityid IN (SELECT opportunityid FROM rural_oopportunity WHERE user_name =  '$username' ))");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++){
				
				$result['tag'][$i]=$row[$i]['tag_name'];
			}

			$db->query(" SELECT tag_name from tag_table where tagid in( SELECT tagid FROM opportunity_tags WHERE opportunityid IN (SELECT opportunityid FROM industrial_oopportunity WHERE user_name =  '$username' ))");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for(;$i<$rows;$i++){
				$result['tag'][$i]=$row[$i]['tag_name'];
			}

			$db->query(" SELECT tag_name from tag_table where tagid in( SELECT tagid FROM opportunity_tags WHERE opportunityid IN (SELECT opportunityid FROM research_oopportunity WHERE user_name =  '$username' ))");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for(;$i<$rows;$i++){
				$result['tag'][$i]=$row[$i]['tag_name'];
			}



			$db->query(" SELECT tag_name from tag_table where tagid in( SELECT tagid FROM post_tags WHERE postid IN (SELECT postid FROM post WHERE user_name =  '$username' ))");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for(;$i<$rows;$i++){
				$result['tag'][$i]=$row[$i]['tag_name'];
			}


			$db->query("SELECT * from user_experince where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++)
			{		
				$result['experince'][$i]=array();
				$result['experince'][$i]['title']=$row[$i]['experince_title'];
				$result['experince'][$i]['id']=$row[$i]['experince_id'];
				$result['experince'][$i]['description']=$row[$i]['experince_description'];
			}
			

			return array('status_code'=>200,'result'=>$result);
		}
		else
			return array('status_code'=>404,'detail'=>'user not found');

	}*/

/*static function displayProfile(){

	@session_start();
	$username=$_SESSION['user']->username;
	
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from student where user_name='$username' ");
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
			$db->query("SELECT * from student_area_of_intrest where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			$result['area_of_interest']=array();
			for($i=0;$i<$rows;$i++)
			{		
				$result['area_of_interest'][$i]=$row[$i]['area_of_intrest'];
			}
			$db->query("SELECT * from field where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			foreach($row[0] as $index=>$value){
				$result[$index]=$value;
			}

			$db->query(" SELECT tag_name from tag_table where tag_id in( SELECT tag_id FROM opportunity_tags WHERE opportunity_id IN (SELECT opportunity_id FROM rural_oopportunity WHERE user_name =  '$username' ))");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++){
				
				$result['tag'][$i]=$row[$i]['tag_name'];
			}

			$db->query(" SELECT tag_name from tag_table where tag_id in( SELECT tag_id FROM opportunity_tags WHERE opportunity_id IN (SELECT opportunity_id FROM industrial_oopportunity WHERE user_name =  '$username' ))");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for(;$i<$rows;$i++){
				$result['tag'][$i]=$row[$i]['tag_name'];
			}

			$db->query(" SELECT tag_name from tag_table where tag_id in( SELECT tag_id FROM opportunity_tags WHERE opportunity_id IN (SELECT opportunity_id FROM research_oopportunity WHERE user_name =  '$username' ))");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for(;$i<$rows;$i++){
				$result['tag'][$i]=$row[$i]['tag_name'];
			}



			$db->query(" SELECT tag_name from tag_table where tag_id in( SELECT tag_id FROM post_tags WHERE post_id IN (SELECT post_id FROM post WHERE user_name =  '$username' ))");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for(;$i<$rows;$i++){
				$result['tag'][$i]=$row[$i]['tag_name'];
			}


			$db->query("SELECT * from user_experince where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			
			for($i=0;$i<$rows;$i++)
			{		
				$result['experince'][$i]=array();
				$result['experince'][$i]['title']=$row[$i]['experince_title'];
				$result['experince'][$i]['id']=$row[$i]['experince_id'];
				$result['experince'][$i]['description']=$row[$i]['experince_description'];
			}
			

			return array('status_code'=>200,'result'=>$result);
		}
		else
			return array('status_code'=>404,'detail'=>'user not found');

	}
*/

/*static function displayProfile(){

    @session_start();
    $username=$_SESSION['user']->username;
    
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from student where user_name='$username' ");
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
			foreach($row[0] as $index=>    $value){
				$result[$index]=$value;
			}
			$db->query("SELECT * from student_area_of_intrest where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			if($rows>0){
			$result['area_of_interest']=array();
			for($i=0;$i<$rows;$i++)
			{		
				$result['area_of_interest'][$i]=$row[$i]['area_of_intrest'];
			}
			}
			else 
				$result['area_of_interest']="";

			$db->query("SELECT * from field where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			if($rows==1){
			foreach($row[0] as $index=>$value){
				$result[$index]=$value;
				}
			}
			else {
				$result['ct']=0;
				$result['el']=0;
				$result['it']=0;
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
			if($rows>0){
			for($i=0;$i<$rows;$i++)
			{		
				$result['experince'][$i]=array();
				$result['experince'][$i]['title']=$row[$i]['experince_title'];
				$result['experince'][$i]['id']=$row[$i]['experince_id'];
				$result['experince'][$i]['description']=$row[$i]['experince_description'];
			}
			}
			else
				$result['experince']="";

			return array('status_code'=>200,'result'=>$result);
		}
		else
			return array('status_code'=>404,'detail'=>'user not found');

    }*/
	
	static function displayProfile(){

    @session_start();
    $username=$_SESSION['user']->username;
    
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from student where user_name='$username' ");
		//$result=array();
		$rows=$db->returned_rows;
		if($rows==1)
		{
			$row=$db->fetch_assoc_all();
			foreach($row[0] as $index=>$value){
				if($index=='contact_no'){
				if($value==0){}
				else{
				$result[$index]=$value;
				}
				
				}
				else{
				$result[$index]=$value;
				}
			}
			$db->query("SELECT * from user where user_name='$username'");
			$row=$db->fetch_assoc_all();
			foreach($row[0] as $index=>    $value){
				$result[$index]=$value;
			}
			$db->query("SELECT * from student_area_of_intrest where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			if($rows>0){
			$result['area_of_interest']=array();
			for($i=0;$i<$rows;$i++)
			{		
				$result['area_of_interest'][$i]=$row[$i]['area_of_intrest'];
			}
			}
			else 
				$result['area_of_interest']="";

			$db->query("SELECT * from field where user_name='$username'");
			$rows=$db->returned_rows;
			$row=$db->fetch_assoc_all();
			if($rows==1){
			foreach($row[0] as $index=>$value){
				$result[$index]=$value;
				}
			}
			else {
				$result['ct']=0;
				$result['el']=0;
				$result['it']=0;
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
			if($rows>0){
			for($i=0;$i<$rows;$i++)
			{		
				$result['experince'][$i]=array();
				$result['experince'][$i]['title']=$row[$i]['experince_title'];
				$result['experince'][$i]['id']=$row[$i]['experince_id'];
				$result['experince'][$i]['description']=$row[$i]['experince_description'];
			}
			}
			else
				$result['experince']="";

			return array('status_code'=>200,'result'=>$result);
		}
		else
			return array('status_code'=>404,'detail'=>'user not found');

    }

	

	static function editProfile($field1,$value){
		session_start();
		$username=$_SESSION['user']->username;
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from student where user_name='$username'");
		$rows=$db->returned_rows;
		if($rows==1)
		{
			$db->query("UPDATE student set $field1='$value' where user_name='$username' ");
			return array('status_code'=>200);
		}
		else 
			return array('status_code'=>404,'detail'=>'user not found');

	}


	function updateUser($username,$full_name){

	}
	function updateStudent(){

	}


	function addToDatabase()
	{
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from student where user_name='$this->username'");
		$rows=$db->returned_rows;
		if($rows==0){
		$db->query("INSERT INTO student values ('$this->username','$this->professor_rating_average','$this->cpi','$this->batch','$this->other_email_id','$this->other_details','$this->resume','$this->reputation')");
		//$db->insert('student',array('user_name'=>$this->username,'avg_prof_rating'=>$this->professor_rating_average,'cpi'=>$this->cpi,'branch'=>$this->batch,'other_emailid'=>$this->other_email_id,'other_details'=>$this->other_details,'resume'=>$this->resume,'reputation'=>$this->reputation));
		$aoi=$this->area_of_interest;
		$field1=$this->field;

		Student::updateAreasOfInterest(1,'$aoi');
		Student::updateField(1,'$field1');


		return array('status_code'=>200);
		}
		else 
			return array('status_code'=>400, 'detail'=> 'already exists');
	
	}

/*	static function buildProfile($other_email,$other_info,$cpi,$contact_no,$batch,$program)
	{
		@session_start();
		$username=$_SESSION['user']->username;
		$db=(new Database())->connectToDatabase();
		$db->query("SELECT * from student where user_name='$username'");
		$rows=$db->returned_rows;
		if($rows!=1){
		$db->query("INSERT INTO student(user_name,branch,cpi,other_emailid,other_details,batch,contact_no,reputation,avg_prof_rating) values ('$username','$program','$cpi','$other_email','$other_info','$batch','$contact_no',1,1)");



		if ($_FILES["resume"]["error"] > 0)
    {
    	$path=NULL;
      	return array('status_code'=>400 , 'detail'=>'bad request'  );
    }
  else
    {
    
    if (file_exists("C:/xampp/htdocs/intern_corner-master2/upload/" .$username.".pdf"))
      {
      $a=$_FILES["resume"]["name"] . " already exists. ";
      echo "fe";
      }
    else
      {
      move_uploaded_file($_FILES["resume"]["tmp_name"],
      "C:/xampp/htdocs/intern_corner-master2/upload/" .$username.".pdf");
      echo "Stored in: " . "upload/" .$username.".pdf";
      $path="C:/xampp/htdocs/intern_corner-master2/upload/" .$username.".pdf";
  		echo $path;
      }
    }

	
	$db->query("UPDATE student SET resume='$path' where user_name='$username'");	
  

	$db->query("SELECT * from student where user_name='$username'");
	$row=$db->fetch_assoc_all();
	$check=0;
	print_r($row[0]);
	foreach($row[0] as $index=>$value){
	if($value==NULL)
		$check=1;
	echo "is null";
	}
	if($check==1){
		$db->query("UPDATE student set profile_complete=FALSE where user_name='$username'");
	}
	else 
		$db->query("UPDATE student set profile_complete=TRUE where user_name='$username'");

		return array('status_code'=>200);
		}

	

	else 
			return array('status_code'=>400, 'detail'=> 'already exists');
	
	}

	*/
	

static function buildProfile2($other_email,$other_info,$cpi,$contact_no,$batch,$program,$area_of_interest){
	@session_start();
	$username=$_SESSION['user']->username;	
	$x=Student::buildProfile($other_email,$other_info,$cpi,$contact_no,$batch,$program)['status_code'];
	$y=Student::updateAreasOfIntrest2(1, $area_of_interest)['status_code'];
	//echo $x."<br>";
	//echo $y;
	if($x==200 && $y==200)
		return array('status_code'=>200);
	else
		return array('status_code'=>400,'detail'=>'bad request');
}



static function buildProfile($other_email,$other_info,$cpi,$contact_no,$batch,$program)
    {
	@session_start();
	$username=$_SESSION['user']->username;
	$db=(new Database())->connectToDatabase();
	$db->query("SELECT * from student where user_name='$username'");
	$rows=$db->returned_rows;
	$row=$db->fetch_assoc_all();
	if($contact_no==NULL or $contact_no==""){
	$contact_no=0;
		}
	$db->query("UPDATE student set user_name='$username',branch='$program',cpi=$cpi,other_emailid='$other_email',other_details='$other_info',batch='$batch',contact_no='$contact_no',reputation=1,avg_prof_rating=1,profile_complete=1 where user_name='$username'");
	return array('status_code'=>200);

    
    }
	
static function editTagSubscription($type,$tag){
    @session_start();
    $username=$_SESSION['user']->username;
    $db=(new Database())->connectToDatabase();
    if($type==1){
    $db->query("SELECT * from tag_table where tag_name='$tag' ");
    $row=$db->fetch_assoc_all();
    $rows=$db->returned_rows;
    //print_r();
    if($rows!=0){
		$tagg=$row[0]['tag_id'];
		$db->query("INSERT INTO tag_subscribed values ('$tagg','$username')");
		return array('status_code'=>200);
		}
    else{
		$db->query("INSERT INTO tag_table(tag_name) values ('$tag')");
		$db->query("SELECT * from tag_table where tag_name='$tag' ");
		$row1=$db->fetch_assoc_all();
		$tagg=$row1[0]['tag_id'];
		$db->query("INSERT INTO tag_subscribed values ('$tagg','$username')");
		return array('status_code'=>200);
    }
		
    }

    else if($type==-1){
    $db->query("SELECT * from tag_table where tag_name='$tag' ");
    $row=$db->fetch_assoc_all();
    $rows=$db->returned_rows;
    if($rows==1){
		$tagg=$row[0]['tag_id'];
		$db->query("SELECT * from tag_subscribed where user_name='$username' and tag_id='$tagg' ");
		if($db->returned_rows==1){
			$db->query("DELETE from tag_subscribed where user_name='$username' and tag_id='$tagg'");
			return array('status_code'=>200);
		}
    }
    return array('status_code'=>404,'detail'=>'tag not found');
    }
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
		$s1=Student::updateAreasOfInterest($type,$arr[$i]);
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



	static function updateAreasOfInterest($type, $area_of_interest){



		@session_start();
		$username=$_SESSION['user']->username;
		if($type==1)
		{
			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * from student_area_of_intrest where user_name='$username' and area_of_intrest='$area_of_interest';");
			$rows=$db->returned_rows;
			//echo "1111".$rows."<br>";
			if($rows==0)
			$db->query(" INSERT INTO student_area_of_intrest values ('$username','$area_of_interest')");
			
			return array('status_code'=>200);
			
		}
		if($type==-1)
		{

			$db=(new Database())->connectToDatabase();
			$name=$username;
			$db->query("SELECT * from student_area_of_intrest where user_name='$username' and area_of_intrest='$area_of_interest';" );
			$rows=$db->returned_rows;
			if($rows==1)
			{
			$db->query("DELETE FROM student_area_of_intrest WHERE user_name='$username' and area_of_intrest='$area_of_interest';");
			//echo "1111";
			return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404,'detail'=>'comment not found');
		}

	}

	static function updateExperience($type,$experince_id,$experine_title,$experince_description){
		session_start();
		$username=$_SESSION['user']->username;


		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$name=$username;
			$db->query("INSERT INTO user_experince values('$username','$experince_id','$experine_title','$experince_description')");
			return array('status_code'=>200);
		}
		if($type==-1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT * FRom user_experince where user_name='$username'and experinceid='$experince_id' ");
			//echo $db->query("SELECT * FRom user_experince where user_name='this->username'and experinceid=$experince_id");
			$rows=$db->returned_rows;
			//echo "<br>";
			//echo $rows;
			if ($rows==1)
			{
			$db->query("DELETE FROM user_experince WHERE user_name='$username' and experinceid='$experince_id';");
			return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404,'detail'=>'comment not found');
		}



	}


	static function updateField($type,$field){
		session_start();
		$username=$_SESSION['user']->username;
		if($type==1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT  * from field where user_name='$username'");
			$rows=$db->returned_rows;
			if ($rows==1)
			{
				$db->query("UPDATE field SET $field=1 where user_name='$username';");
				return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404,'detail'=>'comment not found');

		}
		if($type==-1)
		{

			$db=(new Database())->connectToDatabase();
			$db->query("SELECT  * from field where user_name='$username'");
			$rows=$db->returned_rows;
			if ($rows==1)
			{
				$db->query("UPDATE field SET $field=0 where user_name='$username';");
				return array('status_code'=>200);
			}
			else 
				return array('status_code'=>404,'detail'=>'comment not found');

		}
	}
	
	function __construct($username,$full_name,$email_id,$contact_details,$account_type,$other_email_id,$other_details,$field,$cpi,$batch,$reputation,$area_of_interest,$profile_complete,$professor_rating_average,$resume,$experience)
	{
		# code...
		parent::__construct($username,$full_name,$email_id,$account_type,$contact_details);

		$this->field=$field;
		$this->cpi=$cpi;
		$this->batch=$batch;
		$this->reputation=$reputation;
		$this->area_of_interest=$area_of_interest;
		$this->profile_complete=$profile_complete;
		$this->professor_rating_average=$professor_rating_average;
		$this->resume=$resume;
		$this->experience=$experience;
		$this->other_details=$other_details;
		$this->other_email_id=$other_email_id;

	}


}

//Student:: updateField(-1,'ct');

//$stud= new Student('1511111111','a1','a1','a1',1,'a1','a1','ct',5,'btech',0,'udm_alloc_agent_array(databases)',NULL,NULL,NULL,NULL);
//Student::updateAreasOfInterest(-1,'area_of_interest14');
//$stud->addToDatabase();

//Student::professorRate('2','10');
//$stud->editProfile('branch','asdf');
//echo $stud->updateExperience(-1,'11112','1234','1234')['detail'];   ///deleting  error
//echo $stud->updateExperience(-1,5,'1234','1234')['detail'];
//echo "<br>".Student::displayProfile()['status_code'];
//print_r(Student::displayProfile()['result']);
//foreach(Student::displayProfile().['result'] as $index=>$value)
//echo $index."=>".$value."<br>"
//print_r(Student::buildProfile('nitin@gmail.com','xyz',10,9898989898,2010,null));
//error addtodatbase inner methods St
//print_r(Student::displayProfile()['result']);
//echo Student :: buildprofile('other_email','other_info',111,11111,'batch','asdfs')['status_code'];

=======
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

>>>>>>> a84ff92c4e6e02a26c77a9ea0d98ea4879eaddf7
?>