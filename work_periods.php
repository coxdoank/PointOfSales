<?php 
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";

$mod	= isset($_GET['mod']) ? $_GET['mod'] : '';
$act	= isset($_GET['act']) ? $_GET['act'] : '';
$cat	= isset($_GET['cat']) ? $_GET['cat'] : '';
$id	 	= isset($_GET['id']) ? $_GET['id'] : 1;
$idm	= isset($_GET['idm']) ? $_GET['idm'] : '';
$idtr	= isset($_GET['idtr']) ? $_GET['idtr'] : '';

//query view transaction date
$query_ticket = $connection->query("select * from transaction trs 
left join user usr on usr.USER_ID = trs.ASSIGNED_USER
where trs.TERMINAL = '$terminal' order by trs.ID desc limit $dataPerPage");

//check work period jika ada bisa open transaksi POS
$qwork = $connection->query("select * from transaction trs where trs.TERMINAL = '$terminal' and trs.FLAG = 'N' order by trs.ID desc limit 1");
$count = mysqli_num_rows($qwork);

//cek apakah masih ada transaksi yang belum selesai
$qclose = $connection->query("select * from ticket tic where 
tic.TERMINAL = '$terminal' and tic.STATUS = 'OPEN' or
tic.TERMINAL = '$terminal' and tic.STATUS = 'SAVE'");
$count_close = mysqli_num_rows($qclose);

if(isset($_POST['btn_start'])){
	if($count == 1){
	echo "";
	}else{
	header("location:work_periods_add.php");
	}
}

if(isset($_POST['btn_end'])){
	if($count == 0){
	echo "";
	}elseif($count_close > 0){
	echo "<script>alert('Tidak bisa melakukan End Shift. Masih ada transaksi yang belum di selesai, silahkan cek kembali transaksi anda');window.location.href=('work_periods.php')</script>";	
	}else{
	header("location:work_periods_end.php");
	}
}
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
	font-family: "Segoe UI", "Segoe UI Semibold";
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
	font-family: "Segoe UI", "Segoe UI Semibold";
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
	font-family: "Segoe UI", "Segoe UI Semibold";
	font-size: 26px;
	text-decoration: none;
	width: 25%;
	background-color: #009933;
	border: 1px solid #ababab;
	color: #FFF;
	height: 97px;
	float: left;
}
.btn_ticket:hover {
	background-color: #FFFFFF;
	color: #333;
}
.btn_ticket_action {
	font-family: "Segoe UI", "Segoe UI Semibold";
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

</style>
<link href="content/css/stylesheet.css" rel="stylesheet" type="text/css" />
</head>

<body onresize="resizeWindow()" onload="resizeWindow()">
<div class="header">
  <div class="label_header"><strong><?php echo "$terminal"; ?></strong></div>
<img src="content/images/logo-01.png" width="125" height="25" /></div>
<form action="" method="post">
<div class="navigation" id="navigation">
	<div class="navigationPanel" id="navigationPanel">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="table-model-01">
    <tr class="text_content">
      <td class="label_header"><strong>Terminal</strong></td>
      <td class="label_header"><strong>Transaction Date</strong></td>
      <td class="label_header"><strong>Create Date</strong></td>
      <td class="label_header"><strong>Closing Date</strong></td>
      <td align="center"><span class="label_header"><strong>Assignee User</strong></span></td>
      </tr>
    <?php while($row = $query_ticket->fetch_array()){ ?>
    <tr class="text_content_02">
      <td><span class="label_header"><?php echo"$row[TERMINAL]" ?></span></td>
      <td><span class="label_header"><?php echo"$row[TRANS_DATE]" ?></span></td>
      <td class="label_header"><?php echo"$row[CREATE_DATE]" ?></td>
      <td class="label_header"><?php if($row['CLOSING_DATE'] == ''){ echo "-- Transaction Open --"; }else{ echo "$row[CLOSING_DATE]"; } ?></td>
      <td align="center"><span class="label_header"><?php echo"$row[FIRST_NAME] $row[LAST_NAME]" ?></span></td>
      </tr>
    <?php } ?>
  </table>
  </div>

</div>
</form>
            <div class="content" id="content">
            <div class="contentPanel" id="contentPanel">
            <form action="" method="post">
              <input name="btn_start" type="submit" class="btn_ticket_action" id="submit5" value="Start Period" />
              <input name="btn_end" type="submit" class="btn_ticket_action" id="submit6" value="End Period" />
              <input name="btn_back" type="button" class="btn_ticket_action" id="btn_back" value="Main Menu" onclick="window.location.href=('dashboard.php')" />
              </form>
            </div>
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
