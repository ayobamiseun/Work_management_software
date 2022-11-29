<?php 
function sanitizeinput($input){

    $input = trim($input);
    
    $input = stripslashes($input);
    
    $input = htmlspecialchars($input);

    return $input;
  
    }  
$to = sanitizeinput($_POST['email']);
$title = sanitizeinput($_POST['title']);
$description = sanitizeinput($_POST['description']);

$sender = mail ($to, $title, $description);

?>