<?php

require_once __DIR__.'/../includes/initialize_database.php';
class Comment
{
var $username;
var $comment;
var $post_id;
var $comment_id;
var $timestamp;


function __construct($username,$post_id,$comment_id,$text,$timestamp)
{
$this->comment_id=$comment_id;
$this->username=$username;
$this->comment=$text;
$this->post_id=$post_id;
$this->timestamp = $timestamp;
}

function insertIntoDatabase()
{
$db = (new Database())->connectToDatabase();
$db->query("SELECT * from post_comments where comment_id=$this->comment_id");
$rows=$db->returned_rows;
if($rows==1)
{
	return array('status_code'=>400, 'detail'=>'comment already exist');
}
else
{
$db->query("INSERT INTO post_comments values('$this->comment','$this->comment_id','$this->post_id','$this->username');");
return array('status_code'=>200);
}
}


function deleteComment()
{
$db = (new Database())->connectToDatabase();
$db->query("SELECT * from post_comments where comment_id='$this->comment_id';");
$rows=$db->returned_rows;
if($rows==1)
{
$db->query("DELETE from post_comments where comment_id='$this->comment_id';");
return array('status_code'=>200);
}
else 
return array('status_code'=>404,'detail'=>'comment not found');
}


function editComment()
{
$db = (new Database())->connectToDatabase();
$db->query("SELECT * from post_comments where comment_id='$this->comment_id';");
$rows=$db->returned_rows;
if($rows==1)
{
$db->query("UPDATE post_comments set comment='$this->comment' where comment_id='$this->comment_id' ;");
return array('status_code'=>200);
}
else 
return array('status_code'=>404,'detail'=>'comment not found');
}



}

//$eid=new Comment(11,11,11,"babbb");
//$eid->insertIntoDatabase();
//echo $eid->insertIntoDatabase()['detail'];
//$eid->editComment();
//$eid->deleteComment();
//echo $eid->deleteComment()['detail'];
?>
