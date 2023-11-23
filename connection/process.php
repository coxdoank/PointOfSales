<?php
include "../connection/connDB.php";
include "../connection/function.php";
	
$mod 	= isset($_POST['mod']) ? $_POST['mod'] : $_GET['mod'];
$act	= isset($_POST['act']) ? $_POST['act'] : $_GET['act'];

switch($mod){
    case "categories":
	$table_name = "categories";
	$form_data = array(
				'cat_id' => '',
				'cat_name' => $_POST['cat_name'],
				'cat_description' => $_POST['cat_description']
				);
		switch($act){
			case "add":		
			InsertData($table_name, $form_data);
			echo "<script>alert('Input Data Success');window.location.href=('../category_insert.php?act=$act')</script>";
			break;
			
			case "edit":

			break;
			
			case "del":	

			break;
			
			default:
			header("location:.");
		}
        break;
		
	default:
	header("location:.");
}
?> 