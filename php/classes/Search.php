<?php

require_once __DIR__.'/../includes/initialize_database.php';
require_once __DIR__.'/User.php';

class Search{

	function __construct(){

	}

	static function searchTypeOfOpportunity($type){				// to search latest 5 oppportunities of certain type
		$db=(new Database())->connectToDatabase();
		$table=$type."_opportunity";
		$db->query("SELECT * from $table order by timestamp limit 5 ");
		$row=$db->fetch_assoc_all();
		$rows=$db->returned_rows;
		if($rows>0)
		{
		//echo "11111<br>";
		foreach($row as $a)
			//echo $a['opportunity_id'];
		return array('status_code'=>200,'result'=>$row);
		}
		else 
			return array('status_code'=>404,'detail'=>'no record found');
 	}

 	var $tag_id;
 	static function searchOpportunityBytags($tag){
 		$db=(new Database())->connectToDatabase();
 		$db->query("SELECT * from tag_table where tag_name='$tag' ");
 		$row=$db->fetch_assoc_all();
 		$tag_id=$row[0]['tag_id'];
 		echo $tag_id."<br>";
 		$db->query("SELECT * from opportunity_tags where tag_id='$tag_id' ");
 		echo $tag_id;
 		$rows=$db->returned_rows;
 		if($rows>0){

 		$row=$db->fetch_assoc_all();
 		return array('status_code'=>200,'result'=>$row);

 		}
 		else 
 			return array('status_code'=>404,'detail'=>'no record found');

 	}





static function searchOpportunity($type,$location,$org,$stipend,$tag){
 		$db=(new Database())->connectToDatabase();
		$table=$type."_opportunity";
		$condition="";
 		if($location!=NULL){
 			$condition.="location='".$location."'";
 		}
 		if($org!=NULL){
 			if($condition=="")
 			$condition.="organization='".$org."' ";
 			else
 			$condition.=" AND organization='".$org."' ";
 		}
 		if($stipend!=NULL){
 			if($condition=="")
 			$condition.="stipend>".$stipend;
 		else
 			$condition.=" AND stipend>".$stipend;
 		}
 			for($i=0;$i<count($tag)-1;$i++)
 				$tag_name="";
			$tag_name.="tag_name='".$tag[$i]."' OR ";
			$tag_name.="tag_name='".$tag[$i]."'";
			$query="select * from(select * from " .  $table  ." where opportunity_id in (select opportunity_id from opportunity_tags where tag_id in (select tag_id from tag_table where ".$tag_name.")))as r3 where ".$condition;
			$db->query($query);
			$rows=$db->returned_rows;
 			$row=$db->fetch_assoc_all();
 			if($rows==0){
 			return array('status_code'=>404,'detail'=>'no record found');
 			}
 			else
 			return array('status_code'=>200,'result'=>$row);
 	}



 	static function searchExperince($companyname){
 		$db=(new Database())->connectToDatabase();
 		$db->query("SELECT * from user_experince where experince_title='$companyname'");
 		$rows=$db->returned_rows;
 		$row=$db->fetch_assoc_all();
 		if($rows==0)
 			return array('status_code'=>404,'detail'=>'no record found');
 		else 
 			return array('status_code'=>200,'result'=>$row);

 	}	



 	static function searchOpportunityIndividually($type , $attribute ,$value){
 		$db=(new Database())->connectToDatabase();
		$table=$type."_opportunity";

 		switch ($attribute) {
 			case 'location':
 			{
 				$db->query("SELECT * from $table where location='$value' order by timestamp limit 5 ");
			$row=$db->fetch_assoc_all();
			$rows=$db->returned_rows;
			if($rows>0)
			{
			//echo "11111<br>";
			foreach($row as $a)
				//echo $a['opportunity_id'];
			return array('status_code'=>200,'result'=>$row);
			}
			else 
				return array('status_code'=>404,'detail'=>'no record found');
 			}

 			case 'organization':
 			{
 				$db->query("SELECT * from $table where organization='$value' order by timestamp limit 5  ");
			$row=$db->fetch_assoc_all();
			$rows=$db->returned_rows;
			if($rows>0)
			{
			//echo "11111<br>";
			foreach($row as $a)
				//echo $a['opportunity_id'];
			return array('status_code'=>200,'result'=>$row);
			}
			else 
				return array('status_code'=>404,'detail'=>'no record found');
 			}
 			case 'stipend':
 			{
 				$db->query("SELECT * from $table where stipend>$value  order by timestamp limit 5 ");
			$row=$db->fetch_assoc_all();
			$rows=$db->returned_rows;
			if($rows>0)
			{
			//echo "11111<br>";
			foreach($row as $a)
			return array('status_code'=>200,'result'=>$row);
			}
			else 
				return array('status_code'=>404,'detail'=>'no record found');
 			}





 		}

 	}
 	static function searchFaculty($type,$value){
 			$db=(new Database())->connectToDatabase();
 			switch ($type){
 				case 'area_of_interest':{
 					$db->query("SELECT user_name FROM faculty_area_of_intrest where area_of_intrest='$value' ");
 					$rows=$db->returned_rows;
					$results_to_send = array();
 					if($rows>0){
 						$row=$db->fetch_assoc_all();
						foreach ($row as $r){
						$username = $r['user_name'];
						$db->query("SELECT * FROM user where user_name='$username' ");
						$result=$db->fetch_assoc_all();
						$u = new User($result[0]['user_name'],$result[0]['full_name'],$result[0]['email'],$result[0]['account_type']);
						array_push($results_to_send, $u);
						}
 						return array('status_code'=>200,'result'=>$results_to_send);
 					}
 					else
 						return array('status_code'=>404,'detail'=>'no record found');
 					
 				}/*
				
				case 'area_of_interest':{
 					$db->query("SELECT * FROM faculty_area_of_intrest where area_of_intrest='$value' ");
 					$rows=$db->returned_rows;
 					if($rows>0){
 						$row=$db->fetch_assoc_all();
 						return array('status_code'=>200,'result'=>$row);
 					}
 					else
 						return array('status_code'=>404,'detail'=>'no record found');
 					
 				}
 				
*/
 				case 'name' :{
 					$db->query("SELECT * FROM faculty where user_name='$value' ");
 					$rows=$db->returned_rows;
 					if($rows>0){
 						$row=$db->fetch_assoc_all();
 						return array('status_code'=>200,'result'=>$row);
 					}
 					else
 						return array('status_code'=>404,'detail'=>'no record found');				

 				}
 				
 				case 'area_of_expertise':{
 					$db->query("SELECT * FROM faculty_area_of_expertise where area_of_expertise='$value' ");
 					$rows=$db->returned_rows;
					$results_to_send = array();
 					if($rows>0){
 						$row=$db->fetch_assoc_all();
						foreach ($row as $r){
						$username = $r['user_name'];
						$db->query("SELECT * FROM user where user_name='$username' ");
						$result=$db->fetch_assoc_all();
						$u = new User($result[0]['user_name'],$result[0]['full_name'],$result[0]['email'],$result[0]['account_type']);
						array_push($results_to_send, $u);
						}
 						return array('status_code'=>200,'result'=>$results_to_send);
 					}
 					else
 						return array('status_code'=>404,'detail'=>'no record found');
 					

 				}
				
				/*

 				case 'area_of_expertise':{
 					$db->query("SELECT * FROM faculty_area_of_expertise where area_of_expertise='$value' ");
 					$rows=$db->returned_rows;
 					if($rows>0){
 						$row=$db->fetch_assoc_all();
						foreach ($row as $r){
						$username = $r['user_name'];
						$db->query("SELECT * FROM user where user_name='$username' ");
						$result=$db->fetch_assoc_all();
						if($db->returned_rows==0){
						}
						else
						{
						$u = new User($result[0]['user_name'],$result[0]['full_name'],$result[0]['email'],$result[0]['account_type']);
						array_push($results_to_send, $u);
						}
						}
 						return array('status_code'=>200,'result'=>$results_to_send);
 					}
 						//return array('status_code'=>200,'result'=>$row);
 					
 					else
 						return array('status_code'=>404,'detail'=>'no record found');
 					

 				}
 				*/
 				case 'project_details':{
 					$db->query("SELECT * FROM faculty where project_details like '%$value%' ");
 					$rows=$db->returned_rows;
 					if($rows>0){
 						$row=$db->fetch_assoc_all();
 						return array('status_code'=>200,'result'=>$row);
 					}
 					else
 						return array('status_code'=>404,'detail'=>'no record found');
 					

 				}
 			}
 	}

}


//$stud=new student_search();
//$stud->searchOpportunity('rural','field','ct');    // error waht kinda dunno
//$a1=$stud->searchFaculty('area_of_interest','1');
//$a2=$stud->searchFaculty('area_of_expertise','1');
//echo $stud->searchFaculty('area_of_interest','1')['result'][0]['user_name'];
//echo $stud->searchFaculty('area_of_interest','1')['result'][1]['user_name'];
//$stud->searchOpportunity('rural','stipend',0);
//echo "<br>";
//$a3=array_intersect($a1['result'][0], $a2['result'][0]);
//echo $a3['user_name'];
//student_search::searchOpportunityBytags('asdf');
//echo student_search::searchOpportunityBytags('asdf')['status_code'];
//$a1=student_search :: searchOpportunity('rural','field','ct')['result'];
//$a2=student_search :: searchOpportunity('rural','organization','11')['result'];
//print_r($a1);
//echo "<br>";
//print_r($a2);
//print_r(student_search :: searchFaculty('name','1')['result']);
//$a3=array_intersect_assoc($a1,$a2);
//print_r($a3);
//echo student_search::searchExperince(1234)['result'][0]['user_name'];
?>

