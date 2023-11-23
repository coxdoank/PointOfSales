<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
	if (empty($_POST['password'])) {
	$error = "Password is invalid";
}
else
{
// Define $password
$password=$_POST['password'];
$connection = mysql_connect("localhost", "root", "");
// To protect MySQL injection for Security purpose
$password = stripslashes($password);
$password = mysql_real_escape_string($password);
// Selecting Database
$db = mysql_select_db("db_pos", $connection);
// SQL query to fetch information of registerd users and finds user match.
$query = mysql_query("select * from user where USER_PASS='$password'", $connection);
$rows = mysql_num_rows($query);
if ($rows == 1) {
$_SESSION['login_user']=$password; // Initializing Session
header("location: profile.php"); // Redirecting To Other Page
} else {
$error = "Username or Password is invalid";
}
mysql_close($connection); // Closing Connection
}
}
?>