<?php
require_once __DIR__.'/Opportunity.php';
class ResearchOpportunity extends Opportunity
{
function __construct($username,$opportunity_id, $title, $description, $deadline, $start_date, $end_date, $stipend, $organization, $location, $tags, $timestamp,$total_votes){
	parent::__construct($username,$opportunity_id, $title, $description, $deadline, $start_date, $end_date, $stipend, $organization, $location, $tags, $timestamp,$total_votes);
	}



static function upVote($opportunity_id){

		//controller must check if user is logged in or not

		session_start();
		$username = $_SESSION['user']->username;
		$db = (new Database())->connectToDatabase();
		//fIRSTLY CHECK IF USER IS THE AUTHOR OF THE ANSWER?
		//
		
		$db->query("SELECT * FROM research_opportunity WHERE user_name='$username' AND opportunity_id=$opportunity_id");


		
		if($db->returned_rows==0)
		{
			//has this user already voted?
			$db->query("SELECT * FROM opportunity_votes WHERE opportunity_id=$opportunity_id AND user_name='$username'");
			if(($db->returned_rows)==1){
			//user has not voted on this answer
			//increase reputation of user who answered
			
			$db->query("DELETE FROM opportunity_votes WHERE opportunity_id=$opportunity_id AND user_name='$username'");
			}
		//finally insert his vote
		$db->insert('opportunity_votes',array('opportunity_id'=>$opportunity_id,'user_name'=>$username,'vote_type'=>1));
		//200=OKAY
		return array('status_code'=>200,'tot_votes'=>ResearchOpportunity::calculateVotes($opportunity_id));
		}
		else{
			//user has already voted on this post
			//400=BAD REQUEST
			return array('status_code'=>400,'detail'=>'user is the author of the answer');
		}

	}
static function downVote($opportunity_id){

		//controller must check if user is logged in or not

		session_start();
		$username = $_SESSION['user']->username;
		$db = (new Database())->connectToDatabase();
		//fIRSTLY CHECK IF USER IS THE AUTHOR OF THE ANSWER?
		//
		
		$db->query("SELECT * FROM research_opportunity WHERE user_name='$username' AND opportunity_id=$opportunity_id");


		
		if($db->returned_rows==0)
		{
			//has this user already voted?
			$db->query("SELECT * FROM opportunity_votes WHERE opportunity_id=$opportunity_id AND user_name='$username'");
			if(($db->returned_rows)==1){
			//user has not voted on this answer
			//increase reputation of user who answered
			
			$db->query("DELETE FROM opportunity_votes WHERE opportunity_id=$opportunity_id AND user_name='$username'");
			}
		//finally insert his vote
		$db->insert('opportunity_votes',array('opportunity_id'=>$opportunity_id,'user_name'=>$username,'vote_type'=>-1));
		//200=OKAY
		return array('status_code'=>200,'tot_votes'=>ResearchOpportunity::calculateVotes($opportunity_id));
		}
		else{
			//user has already voted on this post
			//400=BAD REQUEST
			return array('status_code'=>400,'detail'=>'user is the author of the answer');
		}

	}



static function calculateVotes($opportunity_id){
		$db = (new Database())->connectToDatabase();
		$db->query("SELECT vote_type FROM opportunity_votes WHERE opportunity_id=$opportunity_id");
		$result = $db->fetch_assoc_all();
		$total_votes=0;
		for($i=0;$i<($db->returned_rows);$i++){	
			$total_votes = $total_votes + $result[$i]['vote_type'];
		}
		// echo "$post_id "."$total_votes "."<br>";
		return $total_votes;

	}	




 function addOpportunity(){
		$threshold = 50;
		$limit_of_day = 3;
		$allowed_to_post = 1;
		$db = (new Database)->connectToDatabase();
		//check if user has reached his limit for today?
		$username = $this->username;
		//retrieve if student
		session_start();
		$account_type = $_SESSION['user']->account_type;
		// echo $account_type;
		if($account_type==2){
			// he is a student
			// retrieve his reputation
			// echo 1;
			$db->query("SELECT * FROM Student WHERE user_name='$username'");
			$result = $db->fetch_assoc_all();
			// print_r($result);
			$num_results=$db->returned_rows;

			if($num_results==0){
				//no post has been added by user
				// echo 1;
			}
			else{
				// echo 'inside';
				$reputation = $result[0]['reputation'];
				if($reputation<$threshold){
				//retrieve his last limit posts and then check their timestamps
					$db->query("SELECT * FROM research_opportunity WHERE user_name = '$username' LIMIT $limit_of_day");
					$results = $db->fetch_assoc_all();
					$num_results = $db->returned_rows;
					// echo "no of results "+$num_results;
					$count = 0;
					if($num_results==$limit_of_day){
						//retrieve timestamps of the posts
						for($i=0;$i<$num_results;$i++){
							$timestamp = $results[$i]['timestamp'];
							// echo "hdjsdkjsadfklsadfklsdnfklsdnfkl";
							// echo $timestamp;
							$date_year = explode(" ",$timestamp);
							$day = explode("-",$date_year[0])[2];
							$day = intval($day);
							$ser_day = intval(date("d"));
							// echo $ser_day;
							if($day==$ser_day){
								$count++;
							}

							// echo '<br>';
						}
						if($count==$limit_of_day){
							$allowed_to_post=0;
						}
					}
				}
			}



		}
		if($allowed_to_post==1){

			$db->query("INSERT INTO opportunity (opportunity_id,opportunity_type,timestamp) VALUES(NULL,2,NULL)");
			$db->query("SELECT MAX(opportunity_id) as opp from opportunity");
			$takeid = $db->fetch_assoc_all();
			$id = $takeid[0]['opp'];
				$tags_string = $this->tags;
				$tags_arr = explode(';', $tags_string);
				for($i=0;$i<sizeof($tags_arr);$i++){
				$indi_tag = $tags_arr[$i];
				//check if tag already exists?
				$db->query("SELECT * FROM tag_table WHERE tag_name='$indi_tag'");
				if($db->returned_rows==0){
				//insert in tag table
				$db->query("INSERT INTO tag_table(`tag_name`) VALUES('$indi_tag')");
				}
				//assosiate post with tag
				$db->query("SELECT * FROM tag_table WHERE tag_name='$indi_tag'");
				$results = $db->fetch_assoc_all();
				$tag_id = $results[0]['tag_id'];
				$db->query("INSERT INTO opportunity_tags VALUES($id,$tag_id)");
				}
			$db->query("INSERT INTO research_opportunity(`opportunity_id`, `name`, `user_name`, `description`, `deadline_for_application`, `start_date`, `end_date`, `stipend`, `organization`, `location`) VALUES($id,'$this->title','$username','$this->description','$this->deadline','$this->start_date','$this->end_date','$this->stipend','$this->organization','$this->location')");
			
			return array('status_code'=>200,'detail'=>"research opportunity posted");

		}
		else{
			// forbidden
			return array('status_code'=>403,'detail'=>"User exceeded the limit");
		}
		
    }
    static function extractOpportunity($page_no){
		//page_no starts from 0
		$page_length=10;
		$db = (new Database())->connectToDatabase();
		$no_of_posts = $page_length*$page_no+$page_length;
		// echo $no_of_posts;
		$db->query("SELECT * FROM research_opportunity ORDER BY 'timestamp' DESC LIMIT $no_of_posts");
		$result = $db->fetch_assoc_all();
		$rows_ret = $db->returned_rows;

		// print_r($result);
		//$result contains all results we want for specific page
		$low = $page_no*$page_length;

		$high = $low+$page_length;
		// echo 'low'.$low.' high '.$high.' rows '.$rows_ret.'<br>';
		$results_to_send = array();
		$count = 0;
		for($i=$low;($i<$high)&&($i<$rows_ret);$i++){
			// echo $result[$i]['post_id'];
			// echo '<br>';
			
			$count++;
			
			$total_votes = ResearchOpportunity::calculateVotes($result[$i]['opportunity_id']);
			
			// $tags = ResearchOpportunity::extractTags($result[$i]['opportunity_id']);
			
			// construct object accordingly 
			$opp = new ResearchOpportunity($result[$i]['user_name'],$result[$i]['opportunity_id'],$result[$i]['name'],$result[$i]['description'],$result[$i]['deadline_for_application'],$result[$i]['start_date'],$result[$i]['end_date'],$result[$i]['stipend'],$result[$i]['organization'],$result[$i]['location'],NULL,$result[$i]['timestamp'],NULL);
			array_push($results_to_send, $opp);
				
		}
		if($count==0){
			return array("status_code"=>204,"detail"=>"No more content");
		}
		// array_push($results_to_send);
		return $results_to_send;
		

    }


    static function extractTags($opportunity_id){
		$db = (new Database)->connectToDatabase();
		$db->query("SELECT tag_id FROM opportunity_tags WHERE opportunity_id=$opportunity_id");
		$results = $db->fetch_assoc_all();
		$ret = $db->returned_rows;
		$tags_arr = array();
		for($i=0;$i<$ret;$i++){
			$tag_id = $results[$i]['tag_id'];
			$db->query("SELECT tag_name FROM tag_table WHERE tag_id=$tag_id");
			$tag_name = $db->fetch_assoc();
			$tag_name = $tag_name['tag_name'];
			array_push($tags_arr,array('tag_id'=>$tag_id,'tag_name'=>$tag_name));

		}
		return $tags_arr;

	}

}

/////////////
// testing //
/////////////


//$var = ResearchOpportunity::extractOpportunity(0);
//print_r($var);


	
?>