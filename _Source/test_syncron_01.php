<?php
$con1 = mysql_connect("localhost", "root", "");
if (!$con1) {die('Could not connect: ' . mysql_error());}
mysql_select_db("db_pos", $con1);

$table = "ticket";

$result = mysql_query("SELECT * FROM $table where SYNC = 'N'", $con1);
$query = array();
while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
    $query[] = "('".implode("','", $row)."')";
}

$con2 = mysql_connect("10.10.1.77", "root", "");
if (!$con2) {die('Could not connect: ' . mysql_error());}
mysql_select_db("db_pos", $con2);
$sample = "INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')";

$print = "INSERT INTO $table VALUES ".implode(",", $query).';';
print_r($print);

//mysql_query('INSERT INTO user VALUES '.implode(',', $query).';', $con2);

?>