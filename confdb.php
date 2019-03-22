<?php
error_reporting(E_ERROR | E_PARSE);
$user  = 'root';
$pass = '';
$db = 'conference';

$dbh= new PDO('mysql:host=localhost;dbname=conference', $user, $pass) ;
?>