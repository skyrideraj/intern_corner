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
//$db->insert('user_experince',array($this->username,$this->title,$this->description));
$db->query("INSERT INTO user_experince values('$this->username','this->experinceid','$this->title','$this->description')");
}


function deleteDescription()
{
$db = (new Database())->connectToDatabase();
$db->query("DELETE from user_experince where experinceid=$this->experinceid");
}


}

$eid=new experince(1,123,1234,1);
$eid->insertIntoDatabase();

?>
