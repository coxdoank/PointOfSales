<?php 
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";

$mod	= isset($_GET['mod']) ? $_GET['mod'] : '';
$act	= isset($_GET['act']) ? $_GET['act'] : '';
$cat	= isset($_GET['cat']) ? $_GET['cat'] : '';
$id	 	= isset($_GET['id']) ? $_GET['id'] : 1;
$idm	= isset($_GET['idm']) ? $_GET['idm'] : '';
$idtr	= isset($_POST['idtr']) ? $_POST['idtr'] : '';

// cek user
$query = "select * from user usr left join user_type ust on ust.ID = usr.USER_TYPE_ID where usr.USER_ID = '$user_check'";
$query = mysqli_query($connection,$query);
$row = mysqli_fetch_array($query);

if(isset($_POST['btn_save'])){
$txtuser_id 	= $_POST['txtuser_id'];
$txtuser_pass  = $_POST['txtuser_pass'];
$txtfirst_name = $_POST['txtfirst_name'];
$txtlast_name  = $_POST['txtlast_name'];

	if($txtfirst_name == ''){
	echo "<script>alert('Please input your first name');window.history.back(-1)</script>";
	}elseif($txtuser_pass == ''){
	$table_name = "user";
	$form_data = array(
				'FIRST_NAME' => $txtfirst_name,
				'LAST_NAME' => $txtlast_name
				);
				
	UpdateData($table_name, $form_data, "WHERE USER_ID = '$txtuser_id'");
	
	include "connection/connDBsvr.php";	
	UpdateDataSvr($table_name, $form_data, "WHERE USER_ID = '$txtuser_id'", $connection_svr);
	
	echo "<script>alert('Save Data Success, Password No Change');window.location.href=('dashboard.php')</script>";
	
	}else{
	$table_name = "user";
	$form_data = array(
				'USER_PASS' => $txtuser_pass,
				'FIRST_NAME' => $txtfirst_name,
				'LAST_NAME' => $txtlast_name
				);
				
	UpdateDataSvr($table_name, $form_data, "WHERE USER_ID = '$txtuser_id'", $connection);
	
	include "connection/connDBsvr.php";	
	UpdateDataSvr($table_name, $form_data, "WHERE USER_ID = '$txtuser_id'", $connection_svr);
	
	echo "<script>alert('Save Data Success, Password Has Been Changed, Please Login Again');window.location.href=('logout.php')</script>";
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
<link href="content/css/jquery.keypad.css" rel="stylesheet" type="text/css" />
<link href="content/css/jquery.datepick.css" rel="stylesheet">
<script src="content/js/jquery.min.js"></script>
<script src="content/js/jquery.plugin.js"></script>
<script src="content/js/jquery.datepick.js"></script>
<script>
$(function() {
	$('#poptransdate').datepick();
});
</script>

<!-- Script keypad -->
<script src="content/js/jquery.keypad.js"></script>
<script>
$(function () {
	$('#defaultKeypad').keypad();
	$('#inlineKeypad').keypad({onClose: function() {
		alert($(this).val());
	}});
});
</script>
</head>

<body onresize="resizeWindow()" onload="resizeWindow()">
<div class="header">
  <div class="label_header"><strong><?php echo "$terminal"; ?></strong></div>
<img src="content/images/logo-01.png" width="125" height="25" /></div>
<form action="" method="post">
<div class="navigation" id="navigation">
	<div class="navigationPanel" id="navigationPanel">
	  <table width="98%" align="center">
	    <tr>
	      <td class="label_dashboard_text">Manage User</td>
        </tr>
	    <tr>
	      <td>&nbsp;</td>
        </tr>
	    <tr>
	      <td><span class="label_dashboard_text">User ID</span></td>
        </tr>
	    <tr>
	      <td><input name="txtuser_id" type="text" class="input_text" id="txtuser_id" value="<?php echo "$row[USER_ID]"; ?>" readonly="readonly" /></td>
        </tr>
	    <tr>
	      <td><span class="label_dashboard_text">Password</span></td>
        </tr>
	    <tr>
	      <td><input name="txtuser_pass" type="password" class="input_text" id="defaultKeypad" value="" maxlength="6" /></td>
        </tr>
	    <tr>
	      <td><span class="label_dashboard_text">First Name</span></td>
        </tr>
	    <tr>
	      <td><input name="txtfirst_name" type="text" class="input_text" id="txtfirst_name" value="<?php echo "$row[FIRST_NAME]" ?>" /></td>
        </tr>
	    <tr>
	      <td><span class="label_dashboard_text">Last Name</span></td>
        </tr>
	    <tr>
	      <td><input name="txtlast_name" type="text" class="input_text" id="txtlast_name" value="<?php echo "$row[LAST_NAME]" ?>" /></td>
        </tr>
      </table>
	</div>
</div>
            <div class="content" id="content">
            <div class="contentPanel" id="contentPanel">
              <input name="btn_save" type="submit" class="btn_ticket_action" id="submit5" value="Save" />
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
