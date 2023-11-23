<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
$terminal = isset($_SESSION['terminal']) ? $_SESSION['terminal'] : '';
	
include "connection/connDB.php";
$q = $connection->query("select * from terminal where TERMINAL = '$terminal'");
$rwpos = $q->fetch_array();

$uri .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
header("location: ".$rwpos['URL']."");

$connection->query("update terminal set FLAG = 'N' where TERMINAL = '$terminal'");
// mysql_close($connection);
$connection -> close();


//header("Location: /POS"); // Redirecting To Home Page
}
?>