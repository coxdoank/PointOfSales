<?php
include "connection/connDB.php";
include "login.php";

//$q = mysql_query("select * from terminal");
//while($rwpos = mysql_fetch_array($q)){
//$count = $rwpos['URL'] + 1;
//
//	if($rwpos['FLAG'] == 'N'){
//		$uri .= $_SERVER['HTTP_HOST'];
//		header('Location: '.$rwpos['URL'].'');
//		exit;	
//	}elseif($rwpos['FLAG'] == 'Y'){
//		$q = mysql_query("select * from terminal where FLAG = 'N' order by URL asc limit 1");
//		$rwpos = mysql_fetch_array($q);
//		$uri .= $_SERVER['HTTP_HOST'];
//		header('Location: '.$rwpos['URL'].'');
//		exit;		
//	}
//
//}

if(isset($_SESSION['login_user'])){
header("location: dashboard.php");
}
echo "It, Works";

?>