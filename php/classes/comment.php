<?php

require_once '../includes/initialize_database.php';
class experince
{
var $username;
var $comment;
var $postid;
var $commentid;


function __construct($username,$postid,$id,$text)
{
$this->commentid=$id;
$this->username=$username;
$this->comment=$text;
$this->postid=$postid;
}

function insertIntoDatabase()
{
$db = (new Database())->connectToDatabase();
$db->query("INSERT INTO post_comments values('$this->comment','this->commentid','$this->postid','$this->description');");
}


function deleteComment()
{
$db = (new Database())->connectToDatabase();
$db->query("DELETE from post_comments where commentid='$this->commentid';");
}


function editComment()
{
$db = (new Database())->connectToDatabase();
$db->query("UPDATE post_comments set comment='$this->comment' where commentid='$this->commentid' ;");
}



}

//$eid=new experince(1,1,1,"bb");
$//eid->editComment();
?>
