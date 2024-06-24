<?php
//Database configuration
$dbHost='localhost';
$dbUsername='root';
$dbPassword='';
$dbName='dbwatsis';

//Create database connection
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

//Check if the connection is successful
if(!$conn){
    die('Could not connect to the database: '.mysqli_connect_error());
}

?>