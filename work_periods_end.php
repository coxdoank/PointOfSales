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

//cek id transaksi 
$query = mysqli_query($connection, "select trs.ID_TRANSACTION,trs.TRANS_DATE from transaction trs where 
					trs.TERMINAL = '$terminal' and trs.FLAG = 'N'");
$rws = mysqli_fetch_array($query);
$notrans = $rws['ID_TRANSACTION'];
$trsdate = explode("-",$rws['TRANS_DATE']);

//cek cash drawer 
$query01 = mysqli_query($connection, "select sum(AMOUNT) as CASH_DRAWER from 
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
) AMOUNT");
$rowss = mysqli_fetch_array($query01);
$cash_on_drawer = $rowss['CASH_DRAWER'];

//check work period 
$qwork = mysqli_query($connection, "select * from transaction trs 
left join user usr on usr.USER_ID = trs.ASSIGNED_USER
where trs.TERMINAL = '$terminal' and trs.FLAG = 'N' order by trs.ID desc limit 1");
$rows = mysqli_fetch_array($qwork);
$count = mysqli_num_rows($qwork);

if(isset($_POST['btn_end'])){
	$table_name = "transaction";
	$form_data = array(
				'CLOSING_DATE' => date('Y-m-d H:i:s'),
				'FLAG' => 'Y'
				);
				
	UpdateData($table_name, $form_data, "WHERE ID = '$rows[ID]' and TERMINAL = '$terminal'");
	
	$table_name_01 = "drawer_balance";
	$form_data_01 = array(
				'CREATE_DATE' => date('Y-m-d H:i:s'),
				'ACCOUNT_NAME' => 'END SHIFT',
				'CASH_BALANCE' => $cash_on_drawer,
				'TERMINAL' => $terminal,
				'ID_TRANSACTION' => $notrans,
				'NOTE' => 'END SHIFT',
				'UPDATE_BY' => $user_check
				);
				
	InsertData($table_name_01, $form_data_01);
	
	header("location:work_periods_end_print.php?id=$rows[ID_TRANSACTION]");	

	mysqli_query($connection,"INSERT INTO th_ticket (NO_TRANSACTION,TERMINAL,ID_USER,CREATE_DATE,CLOSING_DATE,DELIVERY_DATE,TICKET_TYPE,PAYMENT_TYPE,AMOUNT,TENDER_AMOUNT,DUE_AMOUNT,NOTE,STATUS,ID_TRANSACTION,SYNC)
	SELECT NO_TRANSACTION,TERMINAL,ID_USER,CREATE_DATE,CLOSING_DATE,DELIVERY_DATE,TICKET_TYPE,PAYMENT_TYPE,AMOUNT,TENDER_AMOUNT,DUE_AMOUNT,NOTE,STATUS,ID_TRANSACTION,SYNC FROM ticket");

	mysqli_query($connection,"INSERT INTO th_ticket_item (TERMINAL,ITEM_ID,ITEM_COUNT,ITEM_NAME,CATEGORY_NAME,ITEM_PRICE,DISCOUNT_RATE,SUB_TOTAL,DISCOUNT,TAX_AMOUNT,TOTAL_PRICE,NO_TRANSACTION,SYNC)
	SELECT TERMINAL,ITEM_ID,ITEM_COUNT,ITEM_NAME,CATEGORY_NAME,ITEM_PRICE,DISCOUNT_RATE,SUB_TOTAL,DISCOUNT,TAX_AMOUNT,TOTAL_PRICE,NO_TRANSACTION,SYNC FROM ticket_item");
	
	// mysqli_query($connection,"DELETE FROM ticket");
	// mysqli_query($connection,"DELETE FROM ticket_item");

	//baca parameter folder mysql bin
	$myfile = fopen("setParamMySQL.txt", "r") or die("Unable to open file!");
	$paramMySQL = fread($myfile,filesize("setParamMySQL.txt"));

	$myfile = fopen("setParamApp.txt", "r") or die("Unable to open file!");
	$paramApp = fread($myfile,filesize("setParamApp.txt"));
	
	//backup data after eod	
	exec("$paramMySQL\mysqldump -uroot db_pos > $paramApp\BackupTransDate_$trsdate[2]$trsdate[1]$trsdate[0].sql");
	fclose($myfile);
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
	line-height: 26px;
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
	line-height: 26px;
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
	      <td class="label_dashboard_text">END WORK PERIODS</td>
        </tr>
	    <tr>
	      <td>&nbsp;</td>
        </tr>
	    <tr>
	      <td><span class="label_dashboard_text">Terminal</span></td>
        </tr>
	    <tr>
	      <td><input name="txtterminal" type="text" class="input_text" id="txtterminal" value="<?php echo "$rows[TERMINAL]" ?>" readonly="readonly" />
          <input name="id" type="hidden" id="id" value="<?php echo "$rows[ID]" ?>" /></td>
        </tr>
	    <tr>
	      <td><span class="label_dashboard_text">Trans Date</span></td>
        </tr>
	    <tr>
	      <td><input name="txttrans_date" type="text" class="input_text" id="txttrans_date" value="<?php echo "$rows[TRANS_DATE]" ?>" readonly="readonly" /></td>
        </tr>
	    <tr>
	      <td><span class="label_dashboard_text">Opening Balance</span></td>
        </tr>
	    <tr>
	      <td><input name="txtbalance" type="text" class="input_text" id="txtbalance" pattern="[0-9.]+" value="<?php echo "$rows[OPENING_BALANCE]" ?>" readonly="readonly" /></td>
        </tr>
	    <tr>
	      <td><span class="label_dashboard_text">Assignee User</span></td>
        </tr>
	    <tr>
	      <td><input name="defaultKeypad" type="text" class="input_text1" id="defaultKeypad2" pattern="[0-9.]+" value="<?php echo "$rows[FIRST_NAME] $rows[LAST_NAME]" ?>" readonly="readonly" /></td>
        </tr>
      </table>
	</div>
</div>
            <div class="content" id="content">
            <div class="contentPanel" id="contentPanel">
              <input name="btn_end" type="submit" class="btn_ticket_action" id="submit5" value="End Period" onclick="javascript:return confirm('Are you sure want to close this period ?')" />
              <input name="btn_back" type="button" class="btn_ticket_action" id="btn_back" value="Back" onclick="window.location.href=('work_periods.php')" />
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
