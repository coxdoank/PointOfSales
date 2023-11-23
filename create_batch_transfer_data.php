<?php
include "connection/connDB.php";
// get ip server from file connDB.php
if(empty($ip_server) || $ip_server == ''){ $ip_server = "0.0.0.0"; }else{ $ip_server = $ip_server; }
if(empty($password) || $password == ''){ $password = ""; }else{ $password = "-p".$password; }
if(empty($password_svr) || $password_svr == ''){ $password_svr = ""; }else{ $password_svr = "-p".$password_svr; }

$myfile = fopen("syncron_transfer_data.bat", "w") or die("Unable to open file!");
$txt = "D:\ \r\ncd wamp64\bin\mysql\mysql5.7.31\bin \r\n";
fwrite($myfile, $txt);
$txt = "mysqldump -u$username $password db_pos > d:\backupdata_$Sekarang.sql \r\n";
// $txt = "mysqldump -u$username $password --no-create-info --replace db_pos ticket ticket_item transaction drawer_balance > dump_transfer_data.sql \r\n";
// fwrite($myfile, $txt);
// $txt = "mysql -u$username_svr $password_svr -h $ip_server db_pos < dump_transfer_data.sql";
fwrite($myfile, $txt);
fclose($myfile);
?> 