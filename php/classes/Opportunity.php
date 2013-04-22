<?php

require_once __DIR__.'/../includes/initialize_database.php';
require_once __DIR__.'/../includes/GlobalConstants.php';
require_once __DIR__.'/./Answer.php';
require_once __DIR__.'/./comment.php';


class Opportunity
{

	// var $post_id;
	// var $title;
	// var $description;
	// var $answers;
	// var $comments;
	// var $username;
	// var $total_votes;
	// var $tags;
	// var $timestamp;
	// var $closed;
	// var $no_of_close_requests;

	var $opportunity_id;
	var $title;
	var $description;
	var $deadline;
	var $start_date;
	var $end_date;
	var $stipend;
	var $organization;
	var $location;
	var $tags;
	var $username;
	var $opportunity_type;
	var $timestamp;
	var $total_votes;
	
	function __construct($username,$opportunity_id, $title, $description, $deadline, $start_date, $end_date, $stipend, $organization, $location,$tags,$timestamp,$total_votes)
	{
		# code...
	$this->username=$username;
	$this->opportunity_id=$opportunity_id;
	$this->title=$title;
	$this->description=$description;
	$this->deadline=$deadline;
	$this->start_date=$start_date;
	$this->end_date=$end_date;
	$this->stipend=$stipend;
	$this->organization=$organization;
	$this->location=$location;
	$this->tags=$tags;
	$this->timestamp=$timestamp;
	if($opportunity_id!=NULL){
	$this->total_votes=Opportunity::calculateVotes($opportunity_id);
	}
	else $this->total_votes = 0;
	
	}

	static function upVote($opportunity_id){

		//controller must check if user is logged in or not

		@session_start();
		$username = $_SESSION['user']->username;
		$db = (new Database())->connectToDatabase();
		//fIRSTLY CHECK IF USER IS THE AUTHOR OF THE ANSWER?
		//
		
		$db->query("SELECT * FROM opportunity WHERE  opportunity_id=$opportunity_id");
		$results = $db->fetch_assoc_all();
		$type = $results[0]['opportunity_type'];
		switch ($type) {
			case 1:
				# code...
				$db->query("SELECT * FROM industrial_opportunity WHERE opportunity_id=$opportunity_id");
				$results2 = $db->fetch_assoc_all();
				$username = $results2[0]['user_name'];
				@session_start();
				$username2 = $_SESSION['user']->username;
				if($username2==$username){
					return array('status_code'=>400,'detail'=>'user is the author of the answer');
				}
				break;
			case 2:
				# code...
				$db->query("SELECT * FROM research_opportunity WHERE opportunity_id=$opportunity_id");
				$results2 = $db->fetch_assoc_all();
				$username = $results2[0]['user_name'];
				@session_start();
				$username2 = $_SESSION['user']->username;
				if($username2==$username){
					return array('status_code'=>400,'detail'=>'user is the author of the answer');
				}
				break;
			case 3:
				# code...
				$db->query("SELECT * FROM rural_opportunity WHERE opportunity_id=$opportunity_id");
				$results2 = $db->fetch_assoc_all();
				$username = $results2[0]['user_name'];
				@session_start();
				$username2 = $_SESSION['user']->username;
				if($username2==$username){
					return array('status_code'=>400,'detail'=>'user is the author of the answer');
				}
				break;
			
			default:
				# code...
				break;
		}


		
		
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
		return array('status_code'=>200,'tot_votes'=>IndustrialOpportunity::calculateVotes($opportunity_id));
		
		

	}
		static function downVote($opportunity_id){

		//controller must check if user is logged in or not

		@session_start();
		$username = $_SESSION['user']->username;
		$db = (new Database())->connectToDatabase();
		//fIRSTLY CHECK IF USER IS THE AUTHOR OF THE ANSWER?
		//
		
		$db->query("SELECT * FROM opportunity WHERE  opportunity_id=$opportunity_id");
		$results = $db->fetch_assoc_all();
		$type = $results[0]['opportunity_type'];
		switch ($type) {
			case 1:
				# code...
				$db->query("SELECT * FROM industrial_opportunity WHERE opportunity_id=$opportunity_id");
				$results2 = $db->fetch_assoc_all();
				$username = $results2[0]['user_name'];
				@session_start();
				$username2 = $_SESSION['user']->username;
				if($username2==$username){
					return array('status_code'=>400,'detail'=>'user is the author of the answer');
				}
				break;
			case 2:
				# code...
				$db->query("SELECT * FROM research_opportunity WHERE opportunity_id=$opportunity_id");
				$results2 = $db->fetch_assoc_all();
				$username = $results2[0]['user_name'];
				@session_start();
				$username2 = $_SESSION['user']->username;
				if($username2==$username){
					return array('status_code'=>400,'detail'=>'user is the author of the answer');
				}
				break;
			case 3:
				# code...
				$db->query("SELECT * FROM rural_opportunity WHERE opportunity_id=$opportunity_id");
				$results2 = $db->fetch_assoc_all();
				$username = $results2[0]['user_name'];
				@session_start();
				$username2 = $_SESSION['user']->username;
				if($username2==$username){
					return array('status_code'=>400,'detail'=>'user is the author of the answer');
				}
				break;
			
			default:
				# code...
				break;
		}


		
		
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
		return array('status_code'=>200,'tot_votes'=>IndustrialOpportunity::calculateVotes($opportunity_id));
		
		

	}

	static function delete($opportunity_id){
	@session_start();
	$user_name = $_SESSION['user']->username;
	$db = (new Database())->connectToDatabase();
	//get author of the opportunity
	$db->query("SELECT * FROM Opportunity WHERE opportunity_id=$opportunity_id");
	$result = $db->fetch_assoc_all();
	$opp_type = $result[0]['opportunity_type'];
	switch ($opp_type) {
		case 1:
			$db->query("SELECT * FROM industrial_opportunity WHERE opportunity_id=$opportunity_id");
			$res = $db->fetch_assoc_all();
			$username = $res[0]['user_name'];
			# code...
			break;
		case 2:
			$db->query("SELECT * FROM research_opportunity WHERE opportunity_id=$opportunity_id");
			$res = $db->fetch_assoc_all();
			$username = $res[0]['user_name'];
			# code...
			break;
		case 3:
			$db->query("SELECT * FROM rural_opportunity WHERE opportunity_id=$opportunity_id");
			$res = $db->fetch_assoc_all();
			$username = $res[0]['user_name'];
			# code...
			break;		
		
		default:
			# code...
			break;
	}
	if($user_name==$username){
		switch ($opp_type) {
			case 1:
				$db->query("DELETE FROM opportunity WHERE opportunity_id=$opportunity_id");


				$db->query("DELETE FROM industrial_opportunity WHERE opportunity_id=$opportunity_id");
				//msg to AKASH replicate above query to delete from individual table
				# code...
				break;
			case 2:
				$db->query("DELETE FROM opportunity WHERE opportunity_id=$opportunity_id");


				$db->query("DELETE FROM research_opportunity WHERE opportunity_id=$opportunity_id");
				# code...
				break;
			case 3:
				$db->query("DELETE FROM opportunity WHERE opportunity_id=$opportunity_id");


				$db->query("DELETE FROM rural_opportunity WHERE opportunity_id=$opportunity_id");
				# code...
				break;
			default:
				# code...
				break;
		}
		return array('status_code'=>200,'detail'=>'deleted');
	}
	return array('status_code'=>400,'detail'=>'you are not the author');
}




static function subscribe($opp_id){
	@session_start();
	$username = $_SESSION['user']->username;
	$db = (new Database())->connectToDatabase();
	$db->query("SELECT * FROM opportunity_subscription WHERE opportunity_id=$opp_id AND user_name='$username'");
	if($db->returned_rows==0){
	$db->query("INSERT INTO opportunity_subscription VALUES('$username',$opp_id)");
	return array('status_code'=>200);
	}
	return array('status_code'=>400,'details'=>'already subscribed');

}
static function unSubscribe($opp_id){
	@session_start();
	$username = $_SESSION['user']->username;
	$db = (new Database())->connectToDatabase();
	$db->query("SELECT * FROM opportunity_subscription WHERE opportunity_id=$opp_id AND user_name='$username'");
	if($db->returned_rows==0){
		return array('status_code'=>400,'details'=>'please subscribe first');
	}
	$db->query("DELETE FROM opportunity_subscription WHERE opportunity_id=$opp_id AND user_name='$username'");
	return array('status_code'=>200);
	
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

	
	

}

////////////
//testing //
////////////
// print_r(Post::extractPosts(0));
// echo '<br>';
// print_r(Post::extractPosts(1));
// echo '<br>';
// print_r(Post::extractPosts(2));
// echo '<br>';
// print_r(Post::extractPosts(3));
// echo '<br>';
// print_r(Post::extractPosts(4));
// echo '<br>';



////////////////////////
// add answer Testing //
////////////////////////
// $ans = new Answer(NULL,2,'sen','Hello I am an answer',NULL);
// print_r(Post::addAnswer($ans));
// 
// 


/////////////////////////
// add comment testing //
/////////////////////////
// $comment = new Comment(NULL,2,NULL,'Hello I am a comment');
// print_r(Post::addComment($comment));
// 


//////////////////////
// add post testing //
//////////////////////
// session_start();
// echo $_SESSION['user']->username;
// session_start();
// $post = new Post(NULL,'testT1','testd1',NULL,NULL,$_SESSION['user']->username,0,NULL,NULL,0,0);
// $rr = $post->addPost();
// print_r($rr);

//$opp=new Opportunity('skyrider',NULL,3,'title','desc','vrf','vrf','vrf',10,'vrf','vrf');
//$r = $opp->addOpportunity();
//print_r($r);
?>