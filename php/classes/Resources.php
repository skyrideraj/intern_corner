<?php
require_once __DIR__.'/../includes/initialize_database.php';
require_once __DIR__.'/User.php';
  
class Resource{
	

  var $resourceid;
  var $username;
  var $path;

  static function addToDataBase(){
  $db=(new Database())->connectToDatabase();
  
  session_start();
  $username=$_SESSION['user']->username;
  if ($_FILES["file"]["error"] > 0)
    {
    //echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
      return array('status_code'=>400 , 'detail'=>'bad request'  );
    }
  else
    {
    /*echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br  />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
    */
    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      $a=$_FILES["file"]["name"] . " already exists. ";

      }
    else
      {
        $filename=$username;
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "../../upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      }
    }

  $path="../../upload/" . $_FILES["file"]["name"];
  //echo $path;
  $fileName = $_FILES['file']['name'];
	$tmpName  = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileType = $_FILES['file']['type'];

	/*$fp= fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	$content = addslashes($content);
	fclose($fp);*/
	
	$db->query("INSERT INTO resources(user_name,resource) values('$username','$path') ");
  }

  


   static function getResourcePath(){
    //$id=$this->resourceid;
    $id=1;
    $db=(new Database)-> connectToDatabase();
    $db->query("SELECT * from resources where resourceid='$id' ");
    $row=$db->fetch_assoc_all();
    $rows=$db->returned_rows;
    $path1=$row[0]['resource'];
    if($rows==1)
      return array('status_code'=>200, 'result'=>$path1);
    else 
    return array('status_code'=>404 ,'detail'=>'resource not found');
  }

  function __construct($username,$path,$resourceid){
    $this->username=$username;
    $this->resourceid=$resourceid;
    $this->path=$path;
  }
}

  //echo Resource :: getResourcePath()['result'];
	Resource :: addToDataBase();

  ?>