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

// cek hak akses proses void
$qakses = mysqli_query($connection,"select * from user usr
left join user_type ust on ust.ID = usr.USER_TYPE_ID
where usr.USER_ID = '$user_check'");
$rwakses = mysqli_fetch_array($qakses);

//query list ticket
$query_ticket = "select * from ticket tkt
left join transaction trs on trs.ID_TRANSACTION = tkt.ID_TRANSACTION
where tkt.TERMINAL = '$terminal' and trs.FLAG = 'N' and tkt.STATUS = 'COMPLETE'
order by tkt.ID desc limit $dataPerPage";
$query_ticket = mysqli_query($connection,$query_ticket);

//no urut id transaksi berikutnya
$query = mysqli_query($connection,"select * from ticket tkt where 
					tkt.TERMINAL = '$terminal'");
$count = mysqli_num_rows($query);
$notrans = $count + 1;

//id transaksi 
$qidtrs = mysqli_query($connection,"select ID_TRANSACTION from transaction trs where trs.TERMINAL = '$terminal' and trs.FLAG = 'N'");
$rwtrs = mysqli_fetch_array($qidtrs);
$idtrans = $rwtrs['ID_TRANSACTION'];

if(isset($_POST['btn_dine'])){
	$table_name = "ticket";
	$form_data = array(
				'NO_TRANSACTION' => $notrans,
				'TERMINAL' => $terminal,
				'ID_USER' => $user_check,	
				'CREATE_DATE' => date('Y-m-d H:i:s'),
				'TICKET_TYPE' => 'DINE IN',
				'STATUS' => 'OPEN',
				'ID_TRANSACTION' => $idtrans
				);
				
	InsertData($table_name, $form_data);
	header("location:pos.php");
}

if(isset($_POST['btn_refresh'])){
	echo "<meta http-equiv='refresh' content='0;url='>";
}

// if(isset($_POST['btn_reprint'])){
// 	if(empty($idtr) || $idtr == ''){
// 	echo "<script>alert('Silahkan pilih No Bill/ Transaksi terlebih dahulu sebelum melakukan Reprint');window.history.back(-1)</script>";		
// 	}else{
// 	header("location:ticket_reprint.php?id=$idtr");
// 	}
// }

if(isset($_POST['btn_void'])){
	if(empty($idtr) || $idtr == ''){
	echo "<script>alert('Silahkan pilih No Bill/ Transaksi terlebih dahulu sebelum melakukan void');window.history.back(-1)</script>";	
	}elseif($rwakses['USER_TYPE'] == 'CASHIER'){
	echo "<script>alert('Login User anda sebagai cashier, silahkan login Supervisor / Manager / Administrator untuk melakukan Void');window.history.back(-1)</script>";		
	}else{
	$table_name = "ticket";
	$form_data = array(
				'STATUS' => 'VOID'
				);
	UpdateData($table_name, $form_data, "WHERE NO_TRANSACTION = '$idtr' and TERMINAL = '$terminal'");
	echo "<meta http-equiv='refresh' content='0;url='>";
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
		background-image:url('../POS/content/images/toolbar_bg.png'); background-repeat:repeat-x;
		float:left;
	}
	.toolbarLeft{
		background-image:url('../POS/content/images/toolbar_left.png'); background-repeat:no-repeat;
		height:25px;
		width:7px;
		float:left;
	}
	.toolbarRight{
		background-image:url('../POS/content/images/toolbar_right.png'); background-repeat:no-repeat;
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
		width:84%;
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
		width:14%;
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
		background-image:url('../POS/content/images/nav_separator.png'); background-repeat:repeat-x; background-position:center;
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
		background-image:url('../POS/content/images/nav_link.png'); background-repeat:repeat-x;
		font-weight:bold;
		text-decoration:none;
		color:#000000;
	}
	.navSelect a:hover{
		background-image:url('../POS/content/images/nav_link_hover.png'); background-repeat:repeat-x;
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
	width: 33.3%;
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
      <td colspan="6" class="label_header"><strong>Last 20 Transaction <?php echo $terminal ?></strong></td>
      </tr>
    <tr class="text_content">
      <td class="label_header"><strong>No. Bill</strong></td>
      <td class="label_header"><strong>Ticket Type</strong></td>
      <td class="label_header"><strong>Item</strong></td>
      <td class="label_header"><strong>Amount</strong></td>
      <td class="label_header"><strong>Status</strong></td>
      <td align="center">&nbsp;</td>
    </tr>
    <?php while($rwtck = mysqli_fetch_array($query_ticket)){ ?>
    <tr class="text_content_02">
      <td><span class="label_header"># <?php echo"$rwtck[NO_TRANSACTION]" ?></span></td>
      <td><span class="label_header"><?php echo"$rwtck[TICKET_TYPE]" ?></span></td>
      <td class="label_header">
      
      <!-- list item ticket -->
	<?php
	//query list item
	$query_listitem = "select * from ticket_item ttm
						where 
						ttm.TERMINAL = '$terminal' and 
						ttm.NO_TRANSACTION = '$rwtck[NO_TRANSACTION]'";
	//print_r($query_listitem);
	$query_listitem = mysqli_query($connection,$query_listitem);
	while($rwlist = mysqli_fetch_array($query_listitem)){
	?>
        
        <div><?php echo "$rwlist[ITEM_COUNT] $rwlist[ITEM_NAME] "; ?> | <span class="label_small">Rp
<?php $item_price = number_format($rwlist['ITEM_PRICE']); echo "$item_price"; ?>
        </span></div>
		<?php } ?>
	  </td>
      <td class="label_header">Rp <?php $total_price = number_format($rwtck['AMOUNT']); echo "$total_price"; ?></td>
      <td><span class="label_header"><?php echo"$rwtck[STATUS]" ?></span></td>
      <td align="center"><input name="idtr" type="radio" class="radio_btn" id="radio<?php echo"$rwtck[NO_TRANSACTION]" ?>" value="<?php echo"$rwtck[NO_TRANSACTION]" ?>" /></td>
    </tr>
    <?php } ?>
  </table>
  </div>
  
  
  <div class="clear"></div>
  <div>
    <input name="btn_refresh" type="submit" class="btn_ticket" id="submit" value="Refresh" />
    <input name="btn_reprint" type="submit" disable class="btn_ticket" id="submit3" value="RePrint" disabled="disabled" />
<input name="btn_void" type="submit" class="btn_ticket" id="submit2" value="Refund" onclick="javascript:return confirm('Are you sure want to void this transaction ?')"/>
  </div>
</div>
</form>
            <div class="content" id="content">
            <div class="contentPanel" id="contentPanel">
            <form action="" method="post">
              <input name="btn_back" type="button" class="btn_ticket_action" id="submit5" value="Back" onclick="window.location.href=('dashboard.php')" />
            </form>
            </div>
            <div class="clear"></div>

            
</body>

<script type="text/javascript">
            
        function resizeWindow() 
        {
            var windowHeight = getWindowHeight();

            document.getElementById("content").style.height = (windowHeight - 110) + "px";
            document.getElementById("contentPanel").style.height = (windowHeight - 110) + "px";
            document.getElementById("navigation").style.height = (windowHeight - 160) + "px";
			document.getElementById("navigationPanel").style.height = (windowHeight - 160) + "px";
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
