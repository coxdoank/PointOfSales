<?php 
include "connection/connDB.php";
// get ip server from file connDB.php
if(empty($ip_server) || $ip_server == ''){ 
	$ip_server = "127.0.0.1";
}else{
	$ip_server = $ip_server;
}

// Script by Akensai 
if (!$socket = @fsockopen("$ip_server", 80, $errno, $errstr, 1)){ 
$status_ping = "Offline"; 
$status_bar = "<img src='content/images/offline.gif' width='15' height='15' /> Offline"; 
//echo "<img src='content/images/offline.png' width='15' height='15' /> Offline";
} else { 
$status_ping = "Online"; 
$status_bar = "<img src='content/images/online.gif' width='15' height='15' /> Online";
//echo "<img src='content/images/online.png' width='15' height='15' /> Online";
fclose($socket); 
} 
?>