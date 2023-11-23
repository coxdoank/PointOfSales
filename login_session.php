<?php
include "connection/connDB.php";
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
// $connection = mysql_connect("localhost", "root", "");
// Selecting Database
//$db = mysql_select_db("db_pos", $connection);
session_start();// Starting Session
// Storing Session
$terminal=$_SESSION['terminal'];
$user_check=$_SESSION['login_user'];

// SQL Query To Fetch Complete Information Of User
$ses_sql=$connection->query("select * from user where USER_ID='$user_check'");
$row = $ses_sql->fetch_assoc();
$login_session =$row['USER_ID'];
if(!isset($login_session)){
// mysql_close($connection); // Closing Connection
$connection -> close();
header('Location: index.php'); // Redirecting To Home Page
}
?>