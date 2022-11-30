<?php
include './includes/connect.php';
$qry = $conn->query("SELECT * FROM project_list where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include './includes/new_project.php';
?>