<?php 
// get ip server from Database
$qsrv = mysql_query("select IP_SERVER from restaurant");
$row = mysql_fetch_array($qsrv);
$ip_server = $row['IP_SERVER'];

// Script by Akensai 
if (!$socket = @fsockopen("$ip_server", 80, $errno, $errstr, 1)){ 
$status_ping = "Offline"; 
$status_bar = "<img src='content/images/offline.png' width='15' height='15' /> Offline"; 
//echo "<img src='content/images/offline.png' width='15' height='15' /> Offline";
} else { 
$status_ping = "Online"; 
$status_bar = "<img src='content/images/online.png' width='15' height='15' /> Online";
//echo "<img src='content/images/online.png' width='15' height='15' /> Online";
fclose($socket); 
} 

if($status_ping == 'Online'){
$table_name01 = "transaction";
$table_name02 = "ticket";
$table_name03 = "ticket_item";
$form_data = array(
			'SYNC' => 'Y'
			);
UpdateData($table_name01, $form_data, "WHERE TERMINAL = '$terminal'");
UpdateData($table_name02, $form_data, "WHERE TERMINAL = '$terminal'");
UpdateData($table_name03, $form_data, "WHERE TERMINAL = '$terminal'");
//jalankan file bat
//system("cmd /c syncron_transaction.bat");
exec("syncron_transaction.bat");
}elseif($status_ping == 'Offline'){
echo "";
}
?>