<?php

require_once '../includes/initialize_database.php';
class experince
{
var $username;
var $title;
var $description;
var $experinceid;


function __construct($username,$title,$description,$id)
{
$this->experinceid=$id;
$this->username=$username;
$this->title=$title;
$this->description=$description;
}

function insertIntoDatabase()
{
$db = (new Database())->connectToDatabase();
$db->query("SELECT * FROM user_experince where experinceid='$this->experinceid'");
$rows=$db->returned_rows;
if($rows==1)
{
	return array('status_code'=>400 , 'detail'=> "already exists");
}
else 
{
$db->query("INSERT INTO user_experince values('$this->username','this->experinceid','$this->title','$this->description')");
return array('status_code'=>200);
}
}

function deleteExperince()
{
$db = (new Database())->connectToDatabase();
$db->query("SELECT * FROM user_experince where experinceid='$this->experinceid'");
$rows=$db->returned_rows;
echo "<br>".$rows;
if($rows==1)
{
$db->query("DELETE from user_experince where experinceid=$this->experinceid");
return array('status_code'=>200);
}
else 
return array('status_code'=>404, 'detail'=>'comment not found');
}


}

$eid=new experince(11,123,12354,7);
$eid->deleteExperince();
echo $eid->deleteExperince()['detail'];
?>
