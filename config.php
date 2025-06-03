<?php 
// var url 
$base_url= 'http://localhost/Requirement';

// var database

$db_host = 'localhost';
$db_user = 'root';
$db_pass ='';
$db_name ='requirement_doe';

//conet db

$conn =mysqli_connect($db_host,$db_user,$db_pass,$db_name)or die('connect faild');
?>