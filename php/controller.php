<<<<<<< HEAD
<?php

//print_r($xxx);

require_once __DIR__.'/classes/Login.php';
require_once __DIR__.'/classes/Registration.php';
require_once __DIR__.'/classes/experince.php';
require_once __DIR__.'/classes/IndustrialOpportunity.php';
require_once __DIR__.'/classes/ResearchOpportunity.php';
require_once __DIR__.'/classes/RuralOpportunity.php';
require_once __DIR__.'/classes/Post.php';
require_once __DIR__.'/classes/Answer.php';
require_once __DIR__.'/classes/Faculty.php';
require_once __DIR__.'/classes/Alumni.php';
require_once __DIR__.'/classes/Search.php';
$request =  $_SERVER['REQUEST_URI'];
$xxx = explode("/",$request);
$method = $xxx[2];
$ret_val = array();
@session_start();
if ($method){
	//echo("outside");
	switch($method){
		case "checkProfileComplete":
			$acc_type = $_SESSION['user']->account_type;
			if($acc_type==2){
				$db = (new Database())->connectToDatabase();
				$username = $_SESSION['user']->username;
				$db->query("SELECT * FROM student WHERE user_name='$username'");
				$res = $db->fetch_assoc_all();
				$pro_comp = $res[0]['profile_complete'];
				if($pro_comp==0){
					$ret_val = array('status_code'=>1,'detail'=>'profile incomplete');
				}
				else{
				$ret_val = array('status_code'=>2,'detail'=>'profile complete');
				}
				}
				else{
					$ret_val = array('status_code'=>2,'detail'=>'profile complete');
				}
		break;	
		case "login":
			$login_obj = new Login($_POST['username'],$_POST['password']);
			$ret_val = $login_obj->validateAndLogin();
			break;
		case "forgot_password":
			$login_obj = new Login($_POST['username'],NULL);
			$ret_val = $login_obj->forgotPasswordHandler($_POST['username']);
			break;
		case "change_password":
			$username = $_SESSION['user']->username;
			$login_obj = new Login($username,NULL);
			$ret_val = $login_obj->changePassword($username,$_POST['oldpassword'],$_POST['newpassword']);
			break;
		case "register":
			$reg_obj = new Registration($_POST['username'],$_POST['fullname'],$_POST['email'],$_POST['password'],$_POST['category'],NULL);
			$ret_val=$reg_obj->handleRegistration();
			break;
		case "confirm":
			$reg_obj = new Registration($_POST['username'],NULL,NULL,NULL,NULL,$_POST['activation_code']);
			$ret_val=$reg_obj->register();
			break;	
		case "post_experience":
			$acc_type = $_SESSION['user']->account_type;
			if($acc_type==2){
				$db = (new Database())->connectToDatabase();
				$username = $_SESSION['user']->username;
				$db->query("SELECT * FROM student WHERE user_name='$username'");
				$res = $db->fetch_assoc_all();
				$pro_comp = $res[0]['profile_complete'];
				if($pro_comp==0){
					$ret_val = array('status_code'=>1,'detail'=>'profile incomplete');
				}
				else{
				$reg_obj = new experince($_POST['username'],$_POST['title'],$_POST['description'],$_POST['designation'],NULL,NULL);
				$ret_val=$reg_obj->insertIntoDatabase();
				}
			}
			if($acc_type==3){
				$db = (new Database())->connectToDatabase();
				$username = $_SESSION['user']->username;
				$reg_obj = new experince($_POST['username'],$_POST['title'],$_POST['description'],$_POST['designation'],NULL,NULL);
				$ret_val=$reg_obj->insertIntoDatabase();
				
			}
			if($acc_type==1){
				$db = (new Database())->connectToDatabase();
				$username = $_SESSION['user']->username;
				$reg_obj = new experince($_POST['username'],$_POST['title'],$_POST['description'],$_POST['designation'],NULL,NULL);
				$ret_val=$reg_obj->insertIntoDatabase();
				
			}
			
			break;
		case "logout":
			$ret_val = Login::logout();
			break;
			
//kesha akhil code			
		case "extractPost":
			$ret_val = Post::extractPosts($_POST['page_no']);		
			break;
		case "upVote":
			$ret_val = Post::upVote($_POST['post_id']);
			break;
		case "downVote":
			$ret_val = Post::downVote($_POST['post_id']);
			break;	
		case "addComment":
			//print_r($_SESSION['user']);
			$username = $_SESSION['user']->username;
			$comm_obj = new Comment($username,$_POST['post_id'],NULL,$_POST['comment'],NULL);
			$ret_val = Post::addComment($comm_obj);
			break;
		case "addAnswer":
			//print_r($_SESSION['user']);
			$username = $_SESSION['user']->username;
			$ans_obj = new Answer(NULL,$_POST['post_id'],$username,$_POST['answer'],NULL);
			$ret_val = Post::addAnswer($ans_obj);
			break;
		case "upVoteAnswer":
			$ret_val = Answer::upVote($_POST['answer_id']);
			break;
		case "downVoteAnswer":
			$ret_val = Answer::downVote($_POST['answer_id']);
			break;
		case "deleteComment":
			$ret_val = Comment::deleteComment($_POST['comment_id']);
			break;
		case "deleteAnswer":
			$ret_val = Answer::deleteAnswer($_POST['answer_id']);
			break;
		case "addPost":
			//print_r($_SESSION['user']);
			$username = $_SESSION['user']->username;
			$post_obj = new Post(NULL,$_POST['title'],$_POST['description'], NULL, NULL, $username, NULL, $_POST['tags'], NULL,$_POST['anonymous'], NULL);
			$ret_val =  $post_obj->addPost();
			break;
		case "deletePost":
			$ret_val = Post::delete_post($_POST['post_id']);
			break;	
//akhil kesha code ends			
			
		case "user_exp":
			$ret_val = experince::getExperincesByUser();
			break;
		case "get_exp":
			$ret_val = experince::getExperince($_POST['expid']);
			break;
		case "del_one_exp":
			$ret_val = experince::deleteDescription($_POST['expid']);
			break;
		case "all_exp":
			$ret_val = experince::getAllExperinces($_POST['page_no']);
			break;
		case "post_opportunity":
			if($_POST['type']==1){
				$reg_obj = new IndustrialOpportunity($_POST['username'],NULL,$_POST['title'],$_POST['description'],$_POST['deadline'],$_POST['start'],$_POST['end'],$_POST['stipend'],$_POST['organization'],$_POST['location'],$_POST['tags'],NULL,NULL);
				$ret_val=$reg_obj->addOpportunity();
			}
			else if($_POST['type']==2){
				$reg_obj = new ResearchOpportunity($_POST['username'],NULL,$_POST['title'],$_POST['description'],$_POST['deadline'],$_POST['start'],$_POST['end'],$_POST['stipend'],$_POST['organization'],$_POST['location'],$_POST['tags'],NULL,NULL);
				$ret_val=$reg_obj->addOpportunity();
			}
			else if($_POST['type']==3){
				$reg_obj = new RuralOpportunity($_POST['username'],NULL,$_POST['title'],$_POST['description'],$_POST['deadline'],$_POST['start'],$_POST['end'],$_POST['stipend'],$_POST['organization'],$_POST['location'],$_POST['tags'],NULL,NULL);
				$ret_val=$reg_obj->addOpportunity();
			}

			break;
		case "all_opp":
			if($_POST['req']=='opp_posts_1'){			
			$ret_val = IndustrialOpportunity::extractOpportunity($_POST['page_no']);
			}
			else if($_POST['req']=='opp_posts_2'){			
			$ret_val = ResearchOpportunity::extractOpportunity($_POST['page_no']);
			}
			else if($_POST['req']=='opp_posts_3'){			
			$ret_val = RuralOpportunity::extractOpportunity($_POST['page_no']);
			}
			break;
		case "opp_upvote":
			$ret_val = Opportunity::upVote($_POST['id']);
			break;
		case "opp_downvote":
			$ret_val = Opportunity::downVote($_POST['id']);
			break;
		case "delete_opp":
			$ret_val = Opportunity::delete($_POST['id']);
			break;
		case "subscribe_opp":
			$ret_val = Opportunity::subscribe($_POST['id']);
			break;
		case "unsubscribe_opp":
			$ret_val = Opportunity::unSubscribe($_POST['id']);
			break;
		case "search_faculty":
			$ret_val = Search::searchFaculty($_POST['type'],$_POST['val']);
			break;
		case "search_exp":
			$ret_val = Search::searchExperince($_POST['company']);
			break;
		case "search_opp":
			$ret_val = Search::searchOpportunityIndividually($_POST['type'],$_POST['attr'],$_POST['val']);
			break;
		case "view_profile_student":
			$ret_val = Student::displayProfile();
			break;
		case "view_profile_alumni":
			$ret_val = Alumni::displayProfile();
			break;
		case "view_profile_faculty":
			$ret_val = Faculty::displayProfile();
			break;
		case "unsubscribe":
			$ret_val = Student::editTagSubscription(-1,$_POST['tag']);
			break;
		case "subscribe":
			$ret_val = User::subscribeDigest();
			break;
		case "unsubscribe_digest":
			$ret_val = User::unSubscribeDigest();
			break;
		case "build_profile_student":
			$ret_val = Student::buildProfile2($_POST['email'],$_POST['other'],$_POST['cpi'],$_POST['contact'],$_POST['batch'],$_POST['program'],$_POST['intrest']);
			break;
		case "build_profile_faculty":
			$ret_val = Faculty::bulidProfile($_POST['intrest'],$_POST['expertise'],$_POST['pro_info'],$_POST['other_info']);
			break;
		case "build_profile_alumni":
			$ret_val = Alumni::buildProfile($_POST['other'],$_POST['past_company'],$_POST['past_int'],$_POST['current_emp'],$_POST['email']);
			break;	
		case "subscribe_tag":
			$ret_val = Post::subscribeTag($_POST['tag_id']);
			break;
			
	}
	}
	exit(json_encode($ret_val));
// 	
// echo "HO";
// $login_obj = new Login('sen','password');
// $ret_val = $login_obj->validateAndLogin();
// print_r($ret_val);

?>
=======
<?php
// echo "hi";
// $request = $_SERVER['REQUEST_URI'];
// $params     = explode("/", $request);  
// print_r($params);
require_once __DIR__.'/classes/Login.php';
require_once __DIR__.'/classes/Registration.php';
$ret_val = array();
if (isset($_POST["func"])){
	switch($_POST["func"]){
		case "login":
			$login_obj = new Login($_POST['username'],$_POST['password']);
			$ret_val = $login_obj->validateAndLogin();
			break;
		case "registration":
			$reg_obj = new Registration($_POST['username'],$_POST['full_name'],$_POST['email'],$_POST['password'],$_POST['account_type'],NULL);
			$ret_val = $reg_obj->handleRegistration();
			break;
		case "register":
			$reg_val = Registration::register($_POST['username'],$_POST['activation_code']);
			break;
		case "logout":
			$reg_val = Login::logout();
			break;
		case "extractPost":
			$ret_val = Post::extractPost($_POST['page_no']);		
			break;
				

	}
	}
	exit(json_encode($ret_val));


///////////////////////////////
// TESTING OF CONTROLLER.php //
///////////////////////////////
// 	
// echo "HO";
// $login_obj = new Login('sen','password');
// $ret_val = $login_obj->validateAndLogin();
// print_r($ret_val);
// 
// 



?>
>>>>>>> a84ff92c4e6e02a26c77a9ea0d98ea4879eaddf7
