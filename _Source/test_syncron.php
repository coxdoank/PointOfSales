<?php
// origin
$dblink1=mysql_connect('localhost', 'root', ''); 
mysql_select_db('db_pos', $dblink1);  

// destination
$dblink2=mysql_connect('10.10.1.77', 'root', ''); 
mysql_select_db('db_pos',$dblink2); 

$res_from = mysql_query("select * from ticket", $dblink1); 
if($res_from === FALSE) {
    die(mysql_error()); // for error handling
}

while($table = mysql_fetch_array($res_from)) { 
echo($table[0] . "<br />"); // optional, only for show the name tables

$table=$table[0];

$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$dblink1)); // retrieve table structure from mysite1.com 

mysql_query(" $tableinfo[1] ",$dblink2); // use found structure to make table on mysite2.com

$res_to = mysql_query("SELECT * FROM $table  ",$dblink1); // select all content from table mysite1.com  
while ($row = mysql_fetch_array($res_to, MYSQL_ASSOC) ) {
    $sql_error = "";
	//$print = "INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')";
	//print_r($print);
    mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$dblink2); // insert one row into new table on mysite2.com`enter code here`
    $sql_error = mysql_error($dblink2);
}
if ($sql_error) {
    echo $sql_error;
}else {
    echo "copy table ".$table." done.<br />";
}
    flush();
}

mysql_close($dblink1); 
mysql_close($dblink2);
?>