<?php
/**
* 
*/
require_once '../includes/initialize_database.php';
require_once 'User.php';
class Answer{
	var $post_id;
	var $answer_id;
	var $username;
	var $answer_text;
	var $total_votes;
	var $timestamp;
	var $db;
	function getDatabase(){
		if(!isset($this->db)){
			$this->db = (new Database())->connectToDatabase();
		}
		return $this->db;
	}
	
	function __construct($answer_id,$post_id,$username,$answer_text,$total_votes,$timestamp)
	{
		# code...
		$this->post_id=$post_id;
		$this->answer_id=$answer_id;
		$this->username=$username;
		$this->answer_text=$answer_text;
		$this->total_votes=$total_votes;
		$this->timestamp=$timestamp;
	}
	function calculateVotes(){
		$this->getDatabase();
		$this->db->query("SELECT vote_type FROM post_answer_votes WHERE answer_id=$this->answer_id");
		$result = $this->db->fetch_assoc_all();
		$this->total_votes=0;
		for($i=0;$i<($this->db->returned_rows);$i++){	
			$this->total_votes = $this->total_votes + $result[$i]['vote_type'];
		}
		echo $this->total_votes;


	}
	function edit(){

	}
	static function upVote($answer_id){

		//controller must check if user is logged in or not

		session_start();
		$username = $_SESSION['user']->getUsername();
		$db = (new Database())->connectToDatabase();
		//fIRSTLY CHECK IF USER IS THE AUTHOR OF THE ANSWER?
		//
		//insert code
		$db->query("SELECT user_name FROM post_answer WHERE answer_id=$answer_id AND user_name='$username'");


		//has this user already voted?
		if($db->returned_rows==0)
		{
			$db->query("SELECT * FROM post_answer_votes WHERE answer_id=$answer_id AND user_name='$username'");
			if(($db->returned_rows)==1){
			//user has not voted on this answer
			//increase reputation of user who answered
			
			$db->query("DELETE FROM post_answer_votes WHERE answer_id=$answer_id AND user_name='$username'");
			}
		//finally insert his vote
		$db->insert('post_answer_votes',array('answer_id'=>$answer_id,'user_name'=>$username,'vote_type'=>1));
		//200=OKAY
		return array('status_code'=>200);
		}
		else{
			//user has already voted on this answer
			//400=BAD REQUEST
			return array('status_code'=>400,'detail'=>'user is the author of the answer');
		}


	}
	static function downVote($answer_id){
		//controller must check if user is logged in or not

		session_start();
		$username = $_SESSION['user']->getUsername();
		$db = (new Database())->connectToDatabase();
		//fIRSTLY CHECK IF USER IS THE AUTHOR OF THE ANSWER?
		//
		//insert code
		$db->query("SELECT user_name FROM post_answer WHERE answer_id=$answer_id AND user_name='$username'");


		//has this user already voted?
		if($db->returned_rows==0)
		{
			$db->query("SELECT * FROM post_answer_votes WHERE answer_id=$answer_id AND user_name='$username'");
			if(($db->returned_rows)==1){
			//user has not voted on this answer
			//decrease reputation of user who answered
			$db->query("DELETE FROM post_answer_votes WHERE answer_id=$answer_id AND user_name='$username'");
			}
		//finally insert his vote
		$db->insert('post_answer_votes',array('answer_id'=>$answer_id,'user_name'=>$username,'vote_type'=>-1));
		//200=OKAY
		return array('status_code'=>200);
		}
		else{
			//user has already voted on this answer
			//400=BAD REQUEST
			return array('status_code'=>400,'detail'=>'user is the author of the answer');
		}

		}

	
	function delete($username){
		//check if user is the author??


	}
}

////////////
//testing //
////////////


// $ans = new Answer(1,NULL,'inuishan',NULL,NULL,NULL);
// $ans->upVote('inuishan');
// $ans->upVote('inui');
// $ans->upVote('inshan');
// $ans->downVote('inhan');
// $ans->downVote('inuian');
// $ans->downVote('inhan');
// $ans->downVote('inuishan');
// $ans->downVote('inuan');
// $ans->calculateVotes();
// Answer::upVote(1);


?>