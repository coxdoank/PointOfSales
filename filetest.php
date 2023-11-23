<?php
include "connection/connDB.php";
include "connection/function.php";

$table_name = "ticket";
$form_data = array(
            'NO_TRANSACTION' => '1',
            'TERMINAL' => 'POS 01',
            'TICKET_TYPE' => 'DINE IN',
            'STATUS' => 'OPEN',
            'PAYMENT_TYPE' => 'CASH',
            'STATUS' => 'COMPLETE'
            );

$field = array_keys($form_data);
$form_data = "insert into ".$table_name." (".implode(",", $field).") values ('".implode("','", $form_data)."');";
            
$isi = var_dump($form_data);

        
// $message = "insert into $table_menu_category (CATEGORY_NAME,VISIBLE,SORT_ORDER) values ('$categoryname','$visible','$sortorder');";            
            
$myFile = "backupfile_$Date$Month$Year.txt";
if (file_exists($myFile)) {
    $fh = fopen($myFile, 'a');
    fwrite($fh, $form_data."\n");
  } else {
    $fh = fopen($myFile, 'w');
    fwrite($fh, $form_data."\n");
  }
  fclose($fh);

?>