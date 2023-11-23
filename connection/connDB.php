<?php
# Define Varibael Default
date_default_timezone_set('Asia/Jakarta');

$Year			= date("Y");
$nxyear		  	= $Year+1;
$lsyear  		= $Year-1;
$Month   		= date("m");
$Month_Name 	= date("M");
$Date			= date("d");
$LsDate		  	= $Date-1;

$Sekarang		= date("d-m-Y");
$Kemarin		= date("$LsDate-m-Y");
$BulanBerjalan	= date("M-Y");

$YeadMonth	    = date("Y-m");
$YeadMonthDateLs= date("Y-m-$LsDate");
$YeadMonthDate  = date("Y-m-d");
$LastWeek		= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
$Tommorow		= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));

$hostname 		= "localhost";
$database 		= "db_pos";
$username 		= "root";
$password		= "";

$ip_server		= "127.0.0.1";
$username_svr	= "root";
$password_svr	= "";

$connection = new mysqli($hostname,$username,$password,$database);
if (!$connection)
  {
  die('Could not connect: ' . mysql_error());
  }
// $db = mysql_select_db($database, $connection);
// if (!$db)
//   {
//   die('Could not set $db: ' . mysql_error());
//   }

// last 10 transaction only view

$dataPerPage = 10;
?>