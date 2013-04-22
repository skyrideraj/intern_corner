<?php
	require_once '/includes/initialize_database.php';
	require_once __DIR__.'/classes/User.php';
  session_start();
  $username=$_SESSION['user']->username;
  //echo $username;

  if ($_FILES["file"]["error"] > 0 && $_FILES["file"]["size"] > 0)
    {
    //echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
		$path="upload/" . $username.".pdf";
		//echo $path;0
      //move_uploaded_file($_FILES["file"]["tmp_name"],$path);
	  if(file_exists($path)) {
			chmod($path,0755); //Change the file permissions if allowed
			unlink($path); //remove the file
		}

		move_uploaded_file($_FILES['file']['tmp_name'],$path);
          
    }  

  
//window.history.back();

?>
<html>
<head>
<script>
window.history.back();
</script>
</head>
</html>