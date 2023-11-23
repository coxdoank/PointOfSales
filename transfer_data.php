<?php 
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";
include "ping.php";

$mod	= isset($_GET['mod']) ? $_GET['mod'] : '';
$act	= isset($_GET['act']) ? $_GET['act'] : '';
$cat	= isset($_GET['cat']) ? $_GET['cat'] : '';
$id	 	= isset($_GET['id']) ? $_GET['id'] : 1;
$idm	= isset($_GET['idm']) ? $_GET['idm'] : '';
$idtr	= isset($_POST['idtr']) ? $_POST['idtr'] : '';

// === SYNC TRANSFER DATA ===
if(isset($_POST['btn_transfer_data'])){
//cek apakah server UP, jika ya syncron data to server
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

//create batch file 
include "create_batch_transfer_data.php";
//jalankan file bat
//system("cmd /c syncron_transaction.bat");
exec("syncron_transfer_data.bat");

echo "<script>alert('Syncron Data To Server Success');window.location.href=('dashboard.php')</script>";
}elseif($status_ping == 'Offline'){
echo "<script>alert('Syncron Data To Server Failed, Server Offline');window.location.href=('dashboard.php')</script>";
}	
}

// === SYNC TRANSFER MASTER ===
if(isset($_POST['btn_transfer_master'])){
//cek apakah server UP, jika ya syncron data to server
if($status_ping == 'Online'){
//create batch file 
include "create_batch_transfer_master.php";
//jalankan file bat
//system("cmd /c syncron_transaction.bat");
exec("syncron_transfer_master.bat");

echo "<script>alert('Syncron Data Master Success');window.location.href=('dashboard.php')</script>";
}elseif($status_ping == 'Offline'){
echo "<script>alert('Syncron Data Master Failed, Server Offline');window.location.href=('dashboard.php')</script>";
}	
}

////PHP script to dump a MySql database 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// $database = 'db';
// $user = 'user';
// $pass = 'pass';
// $host = 'localhost';
// $dir = dirname(__FILE__) . 'dump.sql';

// echo "<h3>Backing up database to `<code>{$dir}</code>`</h3>";

// exec("mysqldump --user={$username} --password={$password} --host={$hostname} {$database} --result-file={$dir} 2>&1", $output);

// var_dump($output);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML s.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Point Of Sale System</title>
<style type="text/css">
	/* COMMON */
	@import url('../POS/content/css/font-face.css');
	
	body, html
	{
		height:100%;
		margin: 0px auto;
	}
	body
	{
	font-family: 'MyriadPro-Regular';
	margin: 0px;
	text-align: left;
	font-size: 12px;
	background-color: #e3e3e3;
	background-repeat: repeat-x;
	min-width: 768px;
	}
	.header{
		padding: 5px 5px;
	}
	.header div{
		float:right;
		padding:5px 5px;
	}
	.header div a{
		color:#666;
	}
	.header img, .navPanel img, .navSelect img{
		vertical-align:middle;
		margin:0px 5px 0px 0px;
		border:none;
	}
	.subHeader{
	height: 27px;
	background-color: #f0f0f0;
	}
	.subHeader div{
		padding:5px;
		font-size:14px;
		font-weight:bold;
		color:#10428C;
	}
	.clear{
		clear:both;
		float:none;
		height:0px;
	}
	.title{
		font-size:18px;
		font-weight:bold;
		padding:0px 5px;
	}
	/* TOOLBAR */
	.toolbar{
		height:25px;
		margin:0px 5px;
		background-image:url('../Mukti/content/images/toolbar_bg.png'); background-repeat:repeat-x;
		float:left;
	}
	.toolbarLeft{
		background-image:url('../Mukti/content/images/toolbar_left.png'); background-repeat:no-repeat;
		height:25px;
		width:7px;
		float:left;
	}
	.toolbarRight{
		background-image:url('../Mukti/content/images/toolbar_right.png'); background-repeat:no-repeat;
		height:25px;
		width:12px;	
		float:left;
	}
	.toolbarContent{
		padding:5px;
		float:left;
		height:25px;
	}
	.toolbarContent img{
		vertical-align:top;
		border:0px;
		margin-right:5px;
	}
	.toolbarContent a,.toolbarContent a:visited{
		padding:5px;
		color:#000000;
		text-decoration:none;
	}
	.toolbarContent a:hover{
		text-decoration:underline;
	}
	
	/* NAVIGATION */
	.navigation{
		width:80%;
		height:80%;
		margin: 5px 5px 0px 5px;
		border:solid 1px #ababab;
		background-color:#ffffff; 
		float:left;
		vertical-align:bottom;
		position:relative;
	}
	.navigationPanel{
		padding:0px;
		overflow:auto;
	}
	.navPanel{
	padding: 0px;
	height: 60%;
	}
	/* CONTENT */
	.content{
		width:18%;
		 margin: 2px 2px 0px 0px;
		/*background-color:#ffffff;
		border:solid 1px #ababab; */
		vertical-align:top;
		float:left;
	}
	.contentPanel{
		padding:0px;
		overflow:auto;
	}
	.navPanel a, .navPanel a:visited{
		padding:5px 5px;
		display:block;
		color:#000000;
		border:solid 1px #ffffff;
		text-decoration:none;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #cbd0db;
	}
	.navPanel a:hover{
		background-color:#ffde7b;
	}
	.navSeparator{
		height:10px;
		background-image:url('../Mukti/content/images/nav_separator.png'); background-repeat:repeat-x; background-position:center;
	}
	.navSelect{
		position:absolute;
		bottom:0px;
		width:100%;
	}
	.navSelect a{
		height:22px;
		display:block;
		padding:5px;
		background-image:url('../Mukti/content/images/nav_link.png'); background-repeat:repeat-x;
		font-weight:bold;
		text-decoration:none;
		color:#000000;
	}
	.navSelect a:hover{
		background-image:url('../Mukti/content/images/nav_link_hover.png'); background-repeat:repeat-x;
	}

	.btn_settle {
	font-size: 26px;
	text-decoration: none;
	width: 49%;
	background-color: #009933;
	border: 1px solid #ababab;
	color: #FFF;
	height: 97px;
	float: left;
	margin-right: 1%;
	}
.btn_close {
	font-size: 26px;
	text-decoration: none;
	width: 50%;
	background-color: #990000;
	border: 1px solid #ababab;
	color: #FFF;
	height: 97px;
	float: left;
}
.btn_ticket {
	font-size: 26px;
	text-decoration: none;
	width: 50%;
	background-color: #009933;
	border: 1px solid #ababab;
	color: #FFF;
	height: 250px;
	float: left;
	margin-bottom: 10px;
}
.btn_ticket:hover {
	background-color: #FFFFFF;
	color: #333;
}
.btn_ticket_action {
	font-size: 24px;
	text-decoration: none;
	width: 100%;
	background-color: #FFCC00;
	border: 1px solid #ababab;
	color: #000;
	height: 97px;
	float: left;
}
.btn_ticket_action:hover {
	background-color: #FFFFFF;
	color: #333;
}

.radio_btn {
	text-decoration: none;
	width: 35px;
	height: 35px;
	float: left;
	border: 1px solid #FFF;
}
.input_text {
	height: 40px;
	line-height: 25px;
	text-decoration: none;
	border: 1px solid #DDD;
	border-radius: 2px;
	color: #3F3F3F;
	text-indent: 5px;
	border: solid 1px #dcdcdc;
	transition: box-shadow 0.3s, border 0.3s;
	width: 350px;
	font-size: 26px;
}
.input_text[type=text]:focus, .input_text[type=text].focus {
	border: solid 1px #707070;	
	box-shadow: 0 0 0 1px #999999;
}
.select_box {
	height: 40px;
	text-decoration: none;
	border: 1px solid #DDD;
	border-radius: 3px;
	color: #3F3F3F;
	width: 350px;
	font-size: 26px;
}

.select_box:focus, .select_box.focus {
	border: solid 1px #707070;	
	box-shadow: 0 0 0 1px #999999;
}
</style>
<link href="content/css/stylesheet.css" rel="stylesheet" type="text/css" />
</head>

<body onresize="resizeWindow()" onload="resizeWindow()">
<div class="header">
  <div class="label_header"><strong><?php echo "$status_bar | $terminal"; ?></strong></div>
<img src="content/images/logo-01.png" width="125" height="25" /></div>
<form action="" method="post">
<div class="navigation" id="navigation">
	<div class="navigationPanel" id="navigationPanel">
    <div class="label_dashboard" style="padding:10px;"><span style="color:red;">Peringatan !!! </span><br />
    Sebelum melakukan Transfer Data ke server atau Transfer Data Master ke POS, pastikan status koneksi ke Server &quot;<span style="color:green;">Online</span>&quot;</div>
	  <div style="padding:10px;">
	    <input name="btn_transfer_data" type="submit" class="btn_ticket" id="submit" value="Transfer Data" />
	    <input name="btn_transfer_master" type="submit" class="btn_ticket" id="submit2" value="Transfer Master" />
	  </div>
	</div>
</div>
            <div class="content" id="content">
            <div class="contentPanel" id="contentPanel">
              <input name="btn_back" type="button" class="btn_ticket_action" id="btn_back" value="Back" onclick="window.location.href=('dashboard.php')" />
            </div>
              </form>
</body>

<script type="text/javascript">
            
        function resizeWindow() 
        {
            var windowHeight = getWindowHeight();

            document.getElementById("content").style.height = (windowHeight - 110) + "px";
            document.getElementById("contentPanel").style.height = (windowHeight - 110) + "px";
            document.getElementById("navigation").style.height = (windowHeight - 60) + "px";
			document.getElementById("navigationPanel").style.height = (windowHeight - 60) + "px";
        }
  
        function getWindowHeight() 
        {
            var windowHeight=0;
            if (typeof(window.innerHeight)=='number') 
            {
                windowHeight = window.innerHeight;
            }
            else {
                if (document.documentElement && document.documentElement.clientHeight) 
                {
                    windowHeight = document.documentElement.clientHeight;
                }
                else 
                {
                    if (document.body && document.body.clientHeight) 
                    {
                        windowHeight = document.body.clientHeight;
                    }
                }
            }
            return windowHeight;
        }
    </script>

</html>
