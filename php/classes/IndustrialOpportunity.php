<?php
require_once __DIR__.'/Opportunity.php';
class IndustrialOpportunity extends Opportunity
{
function __construct($opportunity_id, $title, $description, $deadline, $start_date, $end_date, $stipend, $organization, $location, $tags, $timestamp){
	parent::__construct($opportunity_id, $title, $description, $deadline, $start_date, $end_date, $stipend, $organization, $location, $tags, $timestamp);
	}



static function upVote($opportunity_id){

		//controller must check if user is logged in or not

		session_start();
		$username = $_SESSION['user']->username;
		$db = (new Database())->connectToDatabase();
		//fIRSTLY CHECK IF USER IS THE AUTHOR OF THE ANSWER?
		//
		
		$db->query("SELECT * FROM industrial_oopportunity WHERE user_name='$username' AND opportunity_id=$opportunity_id");


		
		if($db->returned_rows==0)
		{
			//has this user already voted?
			$db->query("SELECT * FROM opoortunity_votes WHERE opportunity_id=$opportunity_id AND user_name='$username'");
			if(($db->returned_rows)==1){
			//user has not voted on this answer
			//increase reputation of user who answered
			
			$db->query("DELETE FROM opoortunity_votes WHERE opportunity_id=$opportunity_id AND user_name='$username'");
			}
		//finally insert his vote
		$db->insert('oppoortunity_votes',array('opportunity_id'=>$opportunity_id,'user_name'=>$username,'vote_type'=>1));
		//200=OKAY
		return array('status_code'=>200,'tot_votes'=>IndustrialOpportunity::calculateVotes($opportunity_id));
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
		
		$db->query("SELECT * FROM industrial_oopportunity WHERE user_name='$username' AND opportunity_id=$opportunity_id");


		
		if($db->returned_rows==0)
		{
			//has this user already voted?
			$db->query("SELECT * FROM opoortunity_votes WHERE opportunity_id=$opportunity_id AND user_name='$username'");
			if(($db->returned_rows)==1){
			//user has not voted on this answer
			//increase reputation of user who answered
			
			$db->query("DELETE FROM opoortunity_votes WHERE opportunity_id=$opportunity_id AND user_name='$username'");
			}
		//finally insert his vote
		$db->insert('oppoortunity_votes',array('opportunity_id'=>$opportunity_id,'user_name'=>$username,'vote_type'=>-1));
		//200=OKAY
		return array('status_code'=>200,'tot_votes'=>IndustrialOpportunity::calculateVotes($opportunity_id));
		}
		else{
			//user has already voted on this post
			//400=BAD REQUEST
			return array('status_code'=>400,'detail'=>'user is the author of the answer');
		}

	}



static function calculateVotes($opportunity_id){
		$db = (new Database())->connectToDatabase();
		$db->query("SELECT vote_type FROM opoortunity_votes WHERE opportunity_id=$opportunity_id");
		$result = $db->fetch_assoc_all();
		$total_votes=0;
		for($i=0;$i<($db->returned_rows);$i++){	
			$total_votes = $total_votes + $result[$i]['vote_type'];
		}
		// echo "$post_id "."$total_votes "."<br>";
		return $total_votes;

	}	

static function extractOpportunity($page_no){
		//page_no starts from 0
		$page_length=2;
		$db = (new Database())->connectToDatabase();
		$no_of_posts = $page_length*$page_no+$page_length;
		// echo $no_of_posts;
		$db->query("SELECT * FROM industrial_oopportunity ORDER BY timestamp DESC LIMIT $no_of_posts");
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
			
			$total_votes = Post::calculateVotes($result[$i]['post_id']);
			
			$tags = Post::extractTags($result[$i]['post_id']);
			
			$answers = Post::extractAnswers($result[$i]['post_id']);
			
			$comments=Post::extractComments($result[$i]['post_id']);
		
			$ques = new Post($result[$i]['post_id'],$result[$i]['title'],$result[$i]['description'],$answers,$comments,$result[$i]['user_name'],$total_votes,$tags,$result[$i]['timestamp'],$result[$i]['closed'],NULL);
			array_push($results_to_send, $ques);
				
		}
		if($count==0){
			return array("status_code"=>204,"detail"=>"No more content");
		}
		array_push($results_to_send);
		return $results_to_send;
		

	}


}

	
?>