<?
/**
* 
*/
require_once '../includes/initialize_database.php';
require_once '../includes/GlobalConstants.php';


class Post
{

	var $post_id;
	var $title;
	var $description;
	var $answers;
	var $comments;
	var $username;
	var $totalvotes;
	var $tags;
	var $timestamp;
	var $closed;
	var $no_of_close_requests;
	
	function __construct($post_id, $title, $description, $answers, $comments, $username, $totalvotes, $tags, $timestamp, $closed, $no_of_close_requests)
	{
		# code...
	$this->post_id=$post_id;
	$this->title=$title;
	$this->description=$description;
	$this->answers=$answers;
	$this->comments=$comments;
	$this->username=$username;
	$this->totalvotes=$totalvotes;
	$this->tags=$tags;
	$this->timestamp=$timestamp;
	$this->closed=$closed;
	$this->no_of_close_requests=$no_of_close_requests;
	}

	function extractAnswers($post_id){

	}

	static function extractPosts($page_no){
		$page_length=1;
		$db = (new Database())->connectToDatabase();
		$no_of_posts = $page_length*$page_no;
		$db->query("SELECT * FROM post ORDER BY timestamp DESC LIMIT $no_of_posts");
		$result = $db->fetch_assoc_all();
		//$result contains all results we want for specific page
		$low = $page_no*$page_length+1;
		$high = $low+$page_length;
		$results_to_send = array();
		

	}
}
Post::extractPosts(2);
?>