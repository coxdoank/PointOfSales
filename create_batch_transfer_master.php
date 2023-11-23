<?php
include "connection/connDB.php";
// get ip server from file connDB.php
if(empty($ip_server) || $ip_server == ''){ $ip_server = "0.0.0.0"; }else{ $ip_server = $ip_server; }
if(empty($password) || $password == ''){ $password = ""; }else{ $password = "-p".$password; }
if(empty($password_svr) || $password_svr == ''){ $password_svr = ""; }else{ $password_svr = "-p".$password_svr; }

$myfile = fopen("syncron_transfer_master.bat", "w") or die("Unable to open file!");
$txt = "cd\ \r\ncd wamp\bin\mysql\mysql5.6.17\bin \r\n";
fwrite($myfile, $txt);
$txt = "mysqldump -u$username_svr $password_svr -h $ip_server --no-create-info --replace db_pos menu_category menu_item restaurant user > dump_transfer_master.sql \r\n";
fwrite($myfile, $txt);
//$txt = "mysql -u$username -p$password db_pos < truncate_table.sql \r\n";
//fwrite($myfile, $txt);
$txt = "mysql -u$username $password db_pos < dump_transfer_master.sql";
fwrite($myfile, $txt);
fclose($myfile);

//$myfile01 = fopen("truncate_table.sql", "w") or die("Unable to open file!");
//$txt01 = "truncate menu_category; \r\n";
//fwrite($myfile01, $txt01);
//$txt01 = "truncate menu_item; \r\n";
//fwrite($myfile01, $txt01);
//$txt01 = "truncate restaurant; \r\n";
//fwrite($myfile01, $txt01);
//$txt01 = "truncate user;";
//fwrite($myfile01, $txt01);
//fclose($myfile01);

?> 