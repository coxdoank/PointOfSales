<?php 
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";

$mod	= isset($_GET['mod']) ? $_GET['mod'] : '';
$act	= isset($_GET['act']) ? $_GET['act'] : '';
$cat	= isset($_GET['cat']) ? $_GET['cat'] : '';
$id	 	= isset($_GET['id']) ? $_GET['id'] : 1;
$idm	= isset($_GET['idm']) ? $_GET['idm'] : '';
$xtrans	= isset($_GET['xtrans']) ? $_GET['xtrans'] : $BulanBerjalan;

$querytrs = mysqli_query($connection,"select 
						trs.TRANS_DATE
						from transaction trs
						where trs.TERMINAL = '$terminal'
						group by trs.TRANS_DATE
						order by trs.TRANS_DATE desc
						limit 7");
						
	if($xtrans == $BulanBerjalan){
	$trans_date = "$BulanBerjalan";
	$query = "select 
	(select count(*) as total_dine_in
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and month(trs.TRANS_DATE) = '$Month' and year(trs.TRANS_DATE) = '$Year' and tic.TICKET_TYPE = 'DINE IN' and tic.STATUS = 'COMPLETE'
	) as total_dine_in,
	
	(select count(*) as total_take_away
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and month(trs.TRANS_DATE) = '$Month' and year(trs.TRANS_DATE) = '$Year' and tic.TICKET_TYPE = 'TAKE AWAY' and tic.STATUS = 'COMPLETE'
	) as total_take_away,
	
	(select count(*) as total_transaksi
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and month(trs.TRANS_DATE) = '$Month' and year(trs.TRANS_DATE) = '$Year' and tic.STATUS = 'COMPLETE'
	) as total_transaksi,
	
	(select count(*) as total_transaksi_void
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and month(trs.TRANS_DATE) = '$Month' and year(trs.TRANS_DATE) = '$Year' and tic.STATUS = 'VOID'
	) as total_transaksi_void,
	
	(select sum(tic.AMOUNT) as total_sales_void
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and month(trs.TRANS_DATE) = '$Month' and year(trs.TRANS_DATE) = '$Year' and tic.STATUS = 'VOID'
	) as total_sales_void,
	
	(select sum(tic.AMOUNT) as sales_dine_in
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and month(trs.TRANS_DATE) = '$Month' and year(trs.TRANS_DATE) = '$Year' and tic.TICKET_TYPE = 'DINE IN' and tic.STATUS = 'COMPLETE'
	) as sales_dine_in,
	
	(select sum(tic.AMOUNT) as sales_take_away
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and month(trs.TRANS_DATE) = '$Month' and year(trs.TRANS_DATE) = '$Year' and tic.TICKET_TYPE = 'TAKE AWAY' and tic.STATUS = 'COMPLETE'
	) as sales_take_away,
	
	(select sum(tic.AMOUNT) as total_sales
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and month(trs.TRANS_DATE) = '$Month' and year(trs.TRANS_DATE) = '$Year' and tic.STATUS = 'COMPLETE'
	) as total_sales

	";
	
	}else{
	
	$trans_date = $xtrans;
	$query = "select 
	(select count(*) as total_dine_in
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and trs.TRANS_DATE = '$trans_date' and tic.TICKET_TYPE = 'DINE IN' and tic.STATUS = 'COMPLETE'
	) as total_dine_in,
	
	(select count(*) as total_take_away
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and trs.TRANS_DATE = '$trans_date' and tic.TICKET_TYPE = 'TAKE AWAY' and tic.STATUS = 'COMPLETE'
	) as total_take_away,
	
	(select count(*) as total_transaksi
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION and tic.STATUS = 'COMPLETE'
	where trs.TERMINAL = '$terminal' and trs.TRANS_DATE = '$trans_date'
	) as total_transaksi,
	
	(select count(*) as total_transaksi_void
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and trs.TRANS_DATE = '$trans_date' and tic.STATUS = 'VOID'
	) as total_transaksi_void,
	
	(select sum(tic.AMOUNT) as total_sales_void
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and trs.TRANS_DATE = '$trans_date' and tic.STATUS = 'VOID'
	) as total_sales_void,
	
	(select sum(tic.AMOUNT) as sales_dine_in
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and trs.TRANS_DATE = '$trans_date' and tic.TICKET_TYPE = 'DINE IN' and tic.STATUS = 'COMPLETE'
	) as sales_dine_in,
	
	(select sum(tic.AMOUNT) as sales_take_away
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and trs.TRANS_DATE = '$trans_date' and tic.TICKET_TYPE = 'TAKE AWAY' and tic.STATUS = 'COMPLETE'
	) as sales_take_away,
	
	(select sum(tic.AMOUNT) as total_sales
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and trs.TRANS_DATE = '$trans_date' and tic.STATUS = 'COMPLETE'
	) as total_sales
	";
	
	$query01 = "select usr.FIRST_NAME as kasir, sum(tic.AMOUNT) as total_sales
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	left join user usr on usr.USER_ID = trs.ASSIGNED_USER
	where trs.TERMINAL = '$terminal' and trs.TRANS_DATE = '$trans_date' and tic.STATUS = 'COMPLETE'
	group by usr.FIRST_NAME";
	
	$query02 = "select ttm.CATEGORY_NAME, sum(ttm.ITEM_COUNT) as TOTAL_ITEM
from th_ticket_item ttm
left join th_ticket tic on tic.NO_TRANSACTION = ttm.NO_TRANSACTION
left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
where tic.TERMINAL = '$terminal' and trs.TRANS_DATE = '$trans_date' and tic.STATUS = 'COMPLETE'
group by ttm.CATEGORY_NAME";
	
	$query03 = "select ttm.ITEM_NAME, sum(ttm.ITEM_COUNT) as TOTAL_ITEM
from th_ticket_item ttm
left join th_ticket tic on tic.NO_TRANSACTION = ttm.NO_TRANSACTION
left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
where tic.TERMINAL = '$terminal' and trs.TRANS_DATE = '$trans_date' and tic.STATUS = 'COMPLETE'
group by ttm.ITEM_NAME
order by TOTAL_ITEM desc";
	}
	
//print_r($query);
$query = mysqli_query($connection,$query);
$row = mysqli_fetch_array($query);

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
.btn_printout {
	font-size: 18px;
	text-decoration: none;
	width: 150px;
	border: 1px solid #ababab;
	color: #333;
	height: 35px;
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
<form action="" method="get">
<div class="navigation" id="navigation">
	<div class="navigationPanel" id="navigationPanel">
	  <table width="98%" align="center">
	    <tr>
	      <td colspan="2" class="label_dashboard_text">Work Period Report</td>
        </tr>
	    <tr>
	      <td colspan="2">&nbsp;</td>
        </tr>
	    <tr>
	      <td width="30%" class="label_dashboard_text">Transaction </td>
	      <td><select name="xtrans" class="select_payment" id="xtrans" onchange="this.form.submit()">
          	<option <?php if($xtrans == $trans_date){ echo"selected='selected'"; }else{ echo ""; } ?> ><?php echo "$BulanBerjalan" ?></option>
            <?php while($rwtrs=mysqli_fetch_array($querytrs)){ ?>
	        <option <?php if($xtrans == "$rwtrs[TRANS_DATE]"){ echo"selected='selected'"; }else{ echo ""; } ?>><?php echo "$rwtrs[TRANS_DATE]" ?></option>
            <?php } ?>
          </select></td>
        </tr>
	    <tr>
	      <td class="label_dashboard_text">&nbsp;</td>
	      <td>&nbsp;</td>
        </tr>
	    <tr>
	      <td class="label_dashboard_text">&nbsp;</td>
	      <td>&nbsp;</td>
        </tr>
	    <tr>
	      <td colspan="2" align="center" class="label_dashboard_text">
		  <?php if($xtrans == ""){ echo ""; }else{ ?>
          <table width="70%" cellpadding="1" cellspacing="0" class="table-model-01">
	        <tr>
	          <td width="45%"><span class="label_dashboard_text">Terminal</span></td>
	          <td width="10%" align="center"><span class="label_dashboard_text">:</span></td>
	          <td><span class="label_dashboard_text"><?php echo "$terminal" ?></span></td>
	          </tr>
	        <tr>
	          <td><span class="label_dashboard_text">Trans Date</span></td>
	          <td align="center"><span class="label_dashboard_text">:</span></td>
	          <td><span class="label_dashboard_text"><?php echo "$trans_date" ?></span></td>
	          </tr>
	        <tr>
	          <td>&nbsp;</td>
	          <td align="center">&nbsp;</td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td><span class="label_dashboard_text">Total Dine In</span></td>
	          <td align="center"><span class="label_dashboard_text">:</span></td>
	          <td><span class="label_dashboard_text"><?php echo "$row[total_dine_in]" ?></span></td>
	          </tr>
	        <tr>
	          <td><span class="label_dashboard_text"> Total Take Away</span></td>
	          <td align="center"><span class="label_dashboard_text">:</span></td>
	          <td><span class="label_dashboard_text"><?php echo "$row[total_take_away]" ?></span></td>
	          </tr>
	        <tr>
	          <td><span class="label_dashboard_text">Total Transaksi</span></td>
	          <td align="center"><span class="label_dashboard_text">:</span></td>
	          <td><span class="label_dashboard_text"><?php echo "$row[total_transaksi]" ?></span></td>
	          </tr>
	        <tr>
	          <td><span class="label_dashboard_text">Total Transaksi Void</span></td>
	          <td align="center"><span class="label_dashboard_text">:</span></td>
	          <td><span class="label_dashboard_text"><?php echo "$row[total_transaksi_void]" ?></span></td>
	          </tr>
	        <tr>
	          <td><span class="label_dashboard_text">Total Sales Void</span></td>
	          <td align="center"><span class="label_dashboard_text">:</span></td>
	          <td><span class="label_dashboard_text"><?php echo number_format($row['total_sales_void']) ?></span></td>
	          </tr>
	        <tr>
	          <td>&nbsp;</td>
	          <td align="center">&nbsp;</td>
	          <td>&nbsp;</td>
	          </tr>
	        <tr>
	          <td><span class="label_dashboard_text"> Sales Dine In</span></td>
	          <td align="center"><span class="label_dashboard_text">:</span></td>
	          <td><span class="label_dashboard_text"><?php echo number_format($row['sales_dine_in']) ?></span></td>
	          </tr>
	        <tr>
	          <td><span class="label_dashboard_text"> Sales Take Away</span></td>
	          <td align="center"><span class="label_dashboard_text">:</span></td>
	          <td><span class="label_dashboard_text"><?php echo number_format($row['sales_take_away']) ?></span></td>
	          </tr>
	        <tr>
	          <td><span class="label_dashboard_text">Total Sales</span></td>
	          <td align="center"><span class="label_dashboard_text">:</span></td>
	          <td><span class="label_dashboard_text"><?php echo number_format($row['total_sales']) ?></span></td>
	          </tr>
	        <tr>
	          <td>&nbsp;</td>
	          <td align="center">&nbsp;</td>
	          <td>&nbsp;</td>
	          </tr>
          </table>
          <?php if($xtrans == $BulanBerjalan){ echo ""; }else{ ?>
          <table width="70%" cellpadding="1" cellspacing="0" class="table-model-01">
            <tr>
              <td colspan="3" align="center" class="label_dashboard_text"><span class="label_dashboard_text">Total Sales By Cashier</span></td>
            </tr>
            <?php 
			$query01 = mysqli_query($connection,$query01);
			while($rows = mysqli_fetch_array($query01)){ ?>
            <tr>
              <td width="45%"><span class="label_dashboard_text"><?php echo $rows['kasir']?></span></td>
              <td width="10%" align="center"><span class="label_dashboard_text">:</span></td>
              <td><span class="label_dashboard_text"><?php echo number_format($rows['total_sales'])?></span></td>
            </tr>
            <?php } ?>
            <tr>
              <td>&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            
          </table>
          <table width="70%" cellpadding="1" cellspacing="0" class="table-model-01">
            <tr>
              <td colspan="3" align="center" class="label_dashboard_text"><span class="label_dashboard_text">Total Item Sales By Category</span></td>
            </tr>
            <?php 
			$query02 = mysqli_query($connection,$query02);
			while($row02 = mysqli_fetch_array($query02)){ ?>
            <tr class="label_dashboard_text">
              <td width="45%"><span class="label_dashboard_text"><?php echo $row02['CATEGORY_NAME']?></span></td>
              <td width="10%" align="center"><span class="label_dashboard_text">:</span></td>
              <td><span class="label_dashboard_text"><?php echo $row02['TOTAL_ITEM']?></span></td>
            </tr>
            <?php } ?>
            <tr class="label_dashboard_text">
              <td>&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            
        </table>
          <table width="70%" cellpadding="1" cellspacing="0" class="table-model-01">
            <tr>
              <td colspan="3" align="center" class="label_dashboard_text"><span class="label_dashboard_text">Total Item Sales By Menu</span></td>
            </tr>
            <?php 
			$query03 = mysqli_query($connection,$query03);
			while($row03 = mysqli_fetch_array($query03)){ ?>
            <tr class="label_dashboard_text">
              <td width="45%"><span class="label_dashboard_text"><?php echo $row03['ITEM_NAME']?></span></td>
              <td width="10%" align="center"><span class="label_dashboard_text">:</span></td>
              <td><span class="label_dashboard_text"><?php echo $row03['TOTAL_ITEM']?></span></td>
            </tr>
            <?php } ?>
            <tr class="label_dashboard_text">
              <td>&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <?php } ?>
          <?php } ?>
          </td>
        </tr>
	    <tr>
	      <td colspan="2" align="center" class="label_dashboard_text">&nbsp;</td></tr>
	    <tr>
	      <td colspan="2" align="center" class="label_dashboard_text"><input name="btn_print" type="button" class="btn_printout" id="btn_print" value="Print Out" onclick="window.location.href=('pos_report_print.php?xtrans=<?php echo"$xtrans"; ?>')"/></td>
        </tr>
	    <tr>
	      <td colspan="2" align="center" class="label_dashboard_text">&nbsp;</td>
        </tr>
      </table>
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
