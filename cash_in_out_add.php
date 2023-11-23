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


//cek id transaksi 
$query = mysqli_query($connection,"select trs.ID_TRANSACTION from transaction trs where 
					trs.TERMINAL = '$terminal' and trs.FLAG = 'N'");
$row = mysqli_fetch_array($query);
$notrans = $row['ID_TRANSACTION'];

//cek uang cash di drawer 
$query01 = mysqli_query($connection,"select sum(AMOUNT) as CASH_DRAWER from 
(
	select
	sum(case when drw.ACCOUNT_NAME = 'MODAL' then drw.CASH_BALANCE else 0 end) +
	sum(case when drw.ACCOUNT_NAME = 'CASH IN' then drw.CASH_BALANCE else 0 end) -
	sum(case when drw.ACCOUNT_NAME = 'CASH OUT' then drw.CASH_BALANCE else 0 end) as AMOUNT
	from drawer_balance drw	
	left join transaction trs on trs.ID_TRANSACTION = drw.ID_TRANSACTION
	where drw.TERMINAL = '$terminal' and drw.ID_TRANSACTION = '$notrans'
	union all
	select 
	sum(tic.AMOUNT) as a
	from ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where tic.TERMINAL = '$terminal' and trs.FLAG = 'N' and tic.STATUS = 'COMPLETE'
) AMOUNT
");
$rows = mysqli_fetch_array($query01);
$cash_on_drawer = $rows['CASH_DRAWER'];

if(isset($_POST['btn_add'])){
$account_name 	= $_POST['account_name'];
$cash_balance  	= $_POST['cash_balance'];
$note		 	= $_POST['note'];

	if($account_name == '' || $cash_balance == ''){
	echo "<script>alert('Tolong Cek Kembali Form Cash In / Out');window.history.back(-1)</script>";
	}elseif($account_name == 'CASH OUT' and $cash_balance > $cash_on_drawer){
	echo "<script>alert('Cash Out lebih besar dari Jumlah Uang di Drawer');window.history.back(-1)</script>";
	}else{
	$table_name = "drawer_balance";
	$form_data = array(
				'CREATE_DATE' => date('Y-m-d H:i:s'),
				'ACCOUNT_NAME' => $account_name,
				'CASH_BALANCE' => $cash_balance,
				'TERMINAL' => $terminal,
				'ID_TRANSACTION' => $notrans,
				'NOTE' => $note,
				'UPDATE_BY' => $user_check
				);
				
	InsertData($table_name, $form_data);
	
	//cek no urut id transaksi 
	$query = mysqli_query($connection,"select drw.ID from drawer_balance drw
	where drw.ACCOUNT_NAME = '$account_name' and drw.TERMINAL = '$terminal' and drw.ID_TRANSACTION = '$notrans'
	order by drw.ID desc limit 1");
	$row = mysqli_fetch_array($query);
	$nouID = $row['ID'];
	
	header("location:cash_in_out_print.php?id=$nouID");
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
.radio_btn_label {
	font-size: 18px;
	height: 35px;
	line-height: 35px;
	float: left;
	clear: none;
	padding-right: 20px;
}
.input_text {
	height: 40px;
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
.input_textarea {
	text-decoration: none;
	border: 1px solid #DDD;
	border-radius: 2px;
	color: #3F3F3F;
	text-indent: 5px;
	border: solid 1px #dcdcdc;
	transition: box-shadow 0.3s, border 0.3s;
	font-size: 26px;
	height: 150px;
	width: 350px;
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
<style type="text/css">
.input_text1 {	height: 40px;
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
</style>
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
	      <td class="label_dashboard_text">ADD CASH IN / OUT</td>
        </tr>
	    <tr>
	      <td>&nbsp;</td>
        </tr>
	    <tr>
	      <td><span class="label_dashboard_text">Cash Type</span></td>
        </tr>
	    <tr>
	      <td class="radio_btn_label"><div class="radio_btn_label"><input name="account_name" type="radio" class="radio_btn" id="radio" value="CASH IN" />
	        <label>Cash In</label></div>
	        <div class="radio_btn_label"><input name="account_name" type="radio" class="radio_btn" id="radio2" value="CASH OUT" />
	        <label>Cash Out</label></div></td>
        </tr>
	    <tr>
	      <td>&nbsp;</td>
        </tr>
	    <tr>
	      <td><span class="label_dashboard_text">Cash On Drawer</span></td>
        </tr>
	    <tr>
	      <td><input name="cash_ondrawer" type="text" class="input_text" id="cash_ondrawer" value="<?php echo number_format($cash_on_drawer) ?>" readonly="readonly" /></td>
        </tr>
	    <tr>
	      <td><span class="label_dashboard_text">Balance</span></td>
        </tr>
	    <tr>
	      <td><input name="cash_balance" type="text" class="input_text" id="defaultKeypad" /></td>
        </tr>
	    <tr>
	      <td><span class="label_dashboard_text">Note</span></td>
        </tr>
	    <tr>
	      <td><textarea name="note" class="input_textarea" id="note"></textarea></td>
        </tr>
      </table>
	</div>
</div>
            <div class="content" id="content">
            <div class="contentPanel" id="contentPanel">
              <input name="btn_add" type="submit" class="btn_ticket_action" id="submit5" value="Add Cash" />
              <input name="btn_back" type="button" class="btn_ticket_action" id="btn_back" value="Back" onclick="window.location.href=('cash_in_out.php')" />
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
