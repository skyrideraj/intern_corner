<?php

require_once __DIR__.'/../includes/initialize_database.php';
require_once __DIR__.'/../includes/GlobalConstants.php';
require_once __DIR__.'/./Answer.php';
require_once __DIR__.'/comment.php';


class Post
{

	var $post_id;
	var $title;
	var $description;
	var $answers;
	var $comments;
	var $username;
	var $total_votes;
	var $tags;
	var $timestamp;
	var $closed;
	var $no_of_close_requests;
	
	function __construct($post_id, $title, $description, $answers, $comments, $username, $total_votes, $tags, $timestamp, $closed, $no_of_close_requests)
	{
		# code...
	$this->post_id=$post_id;
	$this->title=$title;
	$this->description=$description;
	$this->answers=$answers;
	$this->comments=$comments;
	$this->username=$username;
	$this->total_votes=$total_votes;
	$this->tags=$tags;
	$this->timestamp=$timestamp;
	$this->closed=$closed;
	$this->no_of_close_requests=$no_of_close_requests;
	}

	function addPost(){
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
					$db->query("SELECT * FROM post WHERE user_name = '$username' LIMIT $limit_of_day");
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

			$db->query("INSERT INTO post (title,user_name,description,closed) VALUES('$this->title','$username','$this->description',0)");
			return array('status_code'=>200);

		}
		else{
			// forbidden
			return array('status_code'=>403,'detail'=>"User exceeded the limit");
		}
		
	}
	static function extractPosts($page_no){
		//page_no starts from 0
		$page_length=2;
		$db = (new Database())->connectToDatabase();
		$no_of_posts = $page_length*$page_no+$page_length;
		// echo $no_of_posts;
		$db->query("SELECT * FROM post ORDER BY timestamp DESC LIMIT $no_of_posts");
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
	static function extractAnswers($post_id){
		$db = (new Database)->connectToDatabase();
		$db->query("SELECT * FROM post_answer WHERE post_id=$post_id");
		$result = $db->fetch_assoc_all();
		$answer_array = array();
		for($i=0;$i<$db->returned_rows;$i++){
			$ans = new Answer($result[$i]['answer_id'],$post_id,$result[$i]['user_name'],$result[$i]['answer'],$result[$i]['timestamp']);
			$ans->db=NULL;
			array_push($answer_array,$ans);

		}
		return $answer_array;



	}

	static function extractComments($post_id){
		$db = (new Database)->connectToDatabase();
		$db->query("SELECT * FROM post_comments WHERE post_id=$post_id");
		$result = $db->fetch_assoc_all();
		$comment_array = array();
		for($i=0;$i<$db->returned_rows;$i++){
			$comment = new Comment($result[$i]['user_name'],$post_id,$result[$i]['comment_id'],$result[$i]['comment'],$result[$i]['timestamp']);
			$comment->db=NULL;
			array_push($comment_array,$comment);

		}
		return $comment_array;

	}
	static function calculateVotes($post_id){
		$db = (new Database())->connectToDatabase();
		$db->query("SELECT vote_type FROM post_votes WHERE post_id=$post_id");
		$result = $db->fetch_assoc_all();
		$total_votes=0;
		for($i=0;$i<($db->returned_rows);$i++){	
			$total_votes = $total_votes + $result[$i]['vote_type'];
		}
		// echo "$post_id "."$total_votes "."<br>";
		return $total_votes;

	}
	static function extractTags($post_id){
		$db = (new Database)->connectToDatabase();
		$db->query("SELECT tag_id FROM post_tags WHERE post_id=$post_id");
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

	static function sendMailToSubscribers($post_id){

	}
	static function edit($post_obj){
		//should also call sendMailToSubscribers
		
		sendMailToSubscribers();

	}
	static function addAnswer($ans_obj){
		//check if user has already voted?
		// var_dump($ans_obj);
		session_start();
		$username = $_SESSION['user']->username;
		$db = (new Database)->connectToDatabase();
		$post_id = $ans_obj->post_id;
		$db->query("SELECT * FROM post_answer WHERE post_id=$post_id AND user_name='$username'");
		if($db->returned_rows>0){
			//user has already added an answer
			//400=> Bad Request
			return array('status_code'=>400,'detail'=>'user already answered');

		}
		$db->query("INSERT INTO post_answer (post_id,answer,user_name) VALUES ($ans_obj->post_id,'$ans_obj->answer_text','$username')");
		//200=OK
		return array('status_code'=>200);



	}
	static function addComment($comment_obj){
		session_start();
		$username = $_SESSION['user']->username;
		$db = (new Database)->connectToDatabase();
		$post_id = $comment_obj->post_id;
		// $db->query("SELECT * FROM post_answer WHERE post_id=$post_id AND user_name='$username'");
		$db->query("INSERT INTO post_comments (post_id,comment,user_name) VALUES ($comment_obj->post_id,'$comment_obj->comment','$username')");
		//200=OK
		return array('status_code'=>200);

		
	}
	static function addTag($tags){
		//tags is an array
		//fetch corresponding tagids
		$length = count($tags);
		$db = (new Database)->connectToDatabase();
		for($i=0;$i<$length;$i++){
			$db->query("SELECT * FROM tag_table WHERE tag_name='$tags[i]'");
			if($db->returned_rows==0){
				//no tag found in tag table... so add it
				$db->query("INSERT INTO tag_table (tag_name) VALUES ('$tag[i]')");
			}
			else{
				//check if tag already there with post?
				
			}
		}

		
	}

	static function upVote($post_id){

		//controller must check if user is logged in or not

		session_start();
		$username = $_SESSION['user']->getUsername();
		$db = (new Database())->connectToDatabase();
		//fIRSTLY CHECK IF USER IS THE AUTHOR OF THE ANSWER?
		//
		
		$db->query("SELECT * FROM post WHERE user_name='$username' AND post_id=$post_id");


		
		if($db->returned_rows==0)
		{
			//has this user already voted?
			$db->query("SELECT * FROM post_votes WHERE post_id=$post_id AND user_name='$username'");
			if(($db->returned_rows)==1){
			//user has not voted on this answer
			//increase reputation of user who answered
			
			$db->query("DELETE FROM post_votes WHERE post_id=$post_id AND user_name='$username'");
			}
		//finally insert his vote
		$db->insert('post_votes',array('post_id'=>$post_id,'user_name'=>$username,'vote_type'=>1));
		//200=OKAY
		return array('status_code'=>200,'tot_votes'=>Post::calculateVotes($post_id));
		}
		else{
			//user has already voted on this post
			//400=BAD REQUEST
			return array('status_code'=>400,'detail'=>'user is the author of the answer');
		}

	}
	static function downVote($post_id){
		session_start();
		$username = $_SESSION['user']->getUsername();
		$db = (new Database())->connectToDatabase();
		//fIRSTLY CHECK IF USER IS THE AUTHOR OF THE ANSWER?
		//
		
		$db->query("SELECT * FROM post WHERE user_name='$username' AND post_id=$post_id");


		
		if($db->returned_rows==0)
		{
			//has this user already voted?
			$db->query("SELECT * FROM post_votes WHERE post_id=$post_id AND user_name='$username'");
			if(($db->returned_rows)==1){
			//user has not voted on this answer
			//increase reputation of user who answered
			
			$db->query("DELETE FROM post_votes WHERE post_id=$post_id AND user_name='$username'");
			}
		//finally insert his vote
		$db->insert('post_votes',array('post_id'=>$post_id,'user_name'=>$username,'vote_type'=>-1));
		//200=OKAY
		return array('status_code'=>200,'tot_votes'=>Post::calculateVotes($post_id));
		}
		else{
			//user has already voted on this post
			//400=BAD REQUEST
			return array('status_code'=>400,'detail'=>'user is the author of the answer');
		}

	}
	static function subscribe($post_id){
		session_start();
		$username = $_SESSION['user']->getUsername();
		$db = (new Database())->connectToDatabase();
		//has user already subscribed?
		$db->query("SELECT * FROM post_subscription WHERE user_name='$username' AND post_id=$post_id");
		if($db->returned_rows==0){
			$db->insert('post_subscription',array('user_name'=>$username,'post_id'=>$post_id));
				// OK
			return array('status_code'=>200);

		}
		else{
			//already subscribed
			//bad request
			return array('status_code'=>400,'detail'=>'user already subscribed');
		}


	}

	static function removeTag($post_id,$tag_id){
		session_start();
		$username = $_SESSION['user']->getUsername();
		$db = (new Database())->connectToDatabase();
		//firstly check if user is the author of the post?
		$db->query("SELECT * FROM post WHERE user_name='$username' AND post_id=$post_id");
		if($db->returned_rows==0){
			//user is not the author
			//bad request
			return array('status_code'=>400,'detail'=>'user is not the author');
		}
		$db->query("DELETE FROM post_tags WHERE post_id=$post_id AND tag_id=$tag_id");
		// ok
		return array('status_code'=>200);

		
	}

	static function delete($post_id){
		session_start();
		$threshold_to_delete = 50; //reputation
		$db=(new Database)->connectToDatabase();
		$username = $_SESSION['username']->username;
		//check if user is the author
		$db->query("SELECT * FROM post WHERE post_id=$post_id");
		$results = $db->fetch_assoc_all();
		$post_author = $results['user_name'];
		if($post_author==$username || ($_SESSION['user']->account_type==1)|| ($_SESSION['user']->account_type==3)){
			$db->query("DELETE FROM post WHERE post_id=$post_id");
			return array('status_code'=>200,'detail'=>'deleted');
		}
		// fetch reputation of the current user .... he is a student
		$db->query("SELECT * FROM Student WHERE user_name = '$username'");
		$results = $db->fetch_assoc_all();
		$reputation = $results['reputation'];
		if($reputation>$threshold_to_delete){
			
			//has user already requested?
			$db->query("SELECT * FROM post_close_requests WHERE post_id=$post_id AND user_name='$username'");
			if($db->returned_rows==1){
				// bad request
				return array('status_code'=>400,'detail'=>'already requested');
			}
						// insert into close request
			$db->query("INSERT INTO post_close_requests VALUES($post_id,$username)");
			//calculate the new value
			$db->query("SELECT * FROM post_close_requests WHERE post_id=$post_id");
			$num_results = $db->returned_rows;
			if($num_results>=3){
				//delete the post
				$db->query("DELETE FROM posts WHERE post_id=$post_id");
				return array('status_code'=>200,'detail'=>'deleted');
			}

		}
		
		return array('status_code'=>400,'detail'=>'not enough reputation');

		$db=null;
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
?>