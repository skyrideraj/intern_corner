
<?php
require_once __DIR__.'/includes/initialize_database.php';
$db = (new Database())->connectToDatabase();
//$db->query("SELECT * FROM IndustrialOpportunity ORDER BY timestamp DESC");
$str = "Next Week deadlines<br> Industrial Internship";
$from=date('Y-m-d H:i:s');
$till=date('Y-m-d h:i:s', strtotime("+1 week"));
$final_emails=array();
$db->query("SELECT * from industrial_opportunity where `timestamp` BETWEEN '$from' and '$till'");
// echo $db->returned_rows;    
$results_i = $db->fetch_assoc_all();
print_r($results_i);
$nums = $db->returned_rows;
for($i=0;$i<$nums;$i++){
    $opp_id = $results_i[$i]['opportunity_id'];
    //echo "Hello-----------------".$opp_id.'<br>';
    $db->query("SELECT * FROM industrial_opportunity WHERE opportunity_id=$opp_id");
    $results = $db->fetch_assoc_all();
    $str.="Name:".$results[0]['name']."<br>organization:".$results[0]['organization']."<br>Deadline:".$results[0]['deadline_for_application']."<br>";




    $db->query("SELECT * FROM opportunity_subscription WHERE opportunity_id=$opp_id");
    // echo $db->returned_rows;    
    $usernames = $db->fetch_assoc_all();
    $rows = $db->returned_rows;
    for($j=0;$j<$rows;$j++){
		$indi_user = $usernames[$j]['user_name'];
        // echo 'Username--------'.$indi_user;
		$db->query("SELECT * FROM user WHERE user_name='$indi_user'");
        // echo 'hello'.$db->returned_rows.'<br>';
		$email = $db->fetch_assoc_all();
		$email = $email[0]['email'];
		array_push($final_emails, $email);

    }

}
$db->query("SELECT * from research_opportunity where `timestamp` BETWEEN '$from' and '$till'");
$results_i = $db->fetch_assoc_all();
$nums = $db->returned_rows;
for($i=0;$i<$nums;$i++){
    $opp_id = $results_i[$i]['opportunity_id'];
    $db->query("SELECT * FROM research_opportunity WHERE opportunity_id=$opp_id");
    $results = $db->fetch_assoc_all();
    $str.="Name:".$results[0]['name']."<br>organization:".$results[0]['organization']."<br>Deadline:".$results[0]['deadline_for_application']."<br>";
    $db->query("SELECT * FROM opportunity_subscription WHERE opportunity_id=$opp_id");
    $usernames = $db->fetch_assoc_all();
    $rows = $db->returned_rows;
    for($j=0;$j<$rows;$j++){
		$indi_user = $rusernames[$j]['user_name'];
		$db->query("SELECT * FROM user WHERE user_name='$indi_user'");
		$email = $db->fetch_assoc_all();
		$email = $email[0]['email'];
		array_push($final_emails, $email);

    }

}
$db->query("SELECT * from rural_opportunity where `timestamp` BETWEEN '$from' and '$till'");
$results_i = $db->fetch_assoc_all();
$nums = $db->returned_rows;
for($i=0;$i<$nums;$i++){
    $opp_id = $results_i[$i]['opportunity_id'];
    $db->query("SELECT * FROM rural_opportunity WHERE opportunity_id=$opp_id");
    $results = $db->fetch_assoc_all();
    $str.="Name:".$results[0]['name']."<br>organization:".$results[0]['organization']."<br>Deadline:".$results[0]['deadline_for_application']."<br>";
    $db->query("SELECT * FROM rural_subscription WHERE opportunity_id=$opp_id");
    $usernames = $db->fetch_assoc_all();
    $rows = $db->returned_rows;
    for($j=0;$j<$rows;$j++){
		$indi_user = $usernames[$j]['user_name'];
		$db->query("SELECT * FROM user WHERE user_name='$indi_user'");
		$email = $db->fetch_assoc_all();
		$email = $email[0]['email'];
		array_push($final_emails, $email);

    }

}
$final_emails = array_unique($final_emails);
echo $str;
// echo $condt;
?>