<?
/**
* 
*/
require_once '../includes/initialize_database.php';
require_once '../includes/GlobalConstants.php';
require_once './Answer.php';


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
	static function extractPosts($page_no){
		//page_no starts from 0
		$page_length=1;
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
		$results_to_send = array();
		for($i=$low;$i<$high&&$i<$rows_ret;$i++){
			$total_votes = Post::calculateVotes($result[$i]['post_id']);
			$tags = NULL;
			$ques = new Post($result[$i]['post_id'],$result[$i]['title'],$result[$i]['description'],NULL,NULL,$result[$i]['user_name'],$total_votes,$tags,$result[$i]['timestamp'],$result[$i]['closed'],NULL);
			array_push($results_to_send, $ques);
			return $results_to_send;	
		}
		

	}
	function extractAnswers($post_id){

	}
	static function calculateVotes($post_id){
		$db = (new Database())->connectToDatabase();
		$db->query("SELECT vote_type FROM post_votes WHERE post_id=$post_id");
		$result = $db->fetch_assoc_all();
		$total_votes=0;
		for($i=0;$i<($db->returned_rows);$i++){	
			$total_votes = $total_votes + $result[$i]['vote_type'];
		}
		echo "$post_id "."$total_votes "."<br>";
		return $total_votes;

	}
	static function extractTags($post_id){

	}

}
print_r(Post::extractPosts(0));
echo '<br>';
print_r(Post::extractPosts(1));
echo '<br>';
print_r(Post::extractPosts(2));
echo '<br>';
print_r(Post::extractPosts(3));
echo '<br>';
print_r(Post::extractPosts(4));
echo '<br>';

?>