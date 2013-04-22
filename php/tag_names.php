<?php
require_once __DIR__.'/includes/initialize_database.php';
$db = (new Database())->connectToDatabase();
$db->query("SELECT * FROM tag_table");
$results = $db->fetch_assoc_all();
$tag_name = array();
for($i=0;$i<$db->returned_rows;$i++){
	$tag_name[$i] = $results[$i]['tag_name'];

}
print_r($tag_name);

?>