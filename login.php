<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
	if (empty($_POST['code'])) {
	echo "<script>alert('Input Your Password');window.location.href=('.')</script>";
}
else
{
// Define $password
$code=$_POST['code'];
// $connection = mysql_connect("localhost", "root", "");
// To protect MySQL injection for Security purpose
$code = stripslashes($code);
$code = $connection -> real_escape_string($code);
// Selecting Database
// $db = mysql_select_db("db_pos", $connection);
// SQL query to fetch information of registerd users and finds user match.
$query = $connection -> query("select * from user where USER_PASS='$code'");
$row = $query -> fetch_array();
$rows = mysqli_num_rows($query);

if ($rows == 1) {
	//Info PC POS
	$localIP = getHostByName(getHostName());
	$q = $connection -> query("select * from terminal where URL = '$xurl' order by URL asc limit 1"); //Info PC POS
	$rwpos = $q -> fetch_array();
	$terminal = $rwpos['TERMINAL'];
	$connection->query("update terminal set IP_TERMINAL = '$localIP', FLAG = 'Y' where ID_TERMINAL = '".$rwpos['ID_TERMINAL']."'");

$_SESSION['terminal']=$terminal; // Initializing Session
$_SESSION['login_user']=$row['USER_ID']; // Initializing Session

header("location: ../dashboard.php"); // Redirecting To Other Page
} else {
echo "<script>alert('User Doesnt Exist');window.location.href=('.')</script>";
}
mysql_close($connection); // Closing Connection
}
}
?>