<?php 
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";

$mod	= isset($_GET['mod']) ? $_GET['mod'] : '';
$act	= isset($_GET['act']) ? $_GET['act'] : '';
$cat	= isset($_GET['cat']) ? $_GET['cat'] : '';
$id	 	= $_GET['id'] ? $_GET['id'] : 1;
$idm	= isset($_GET['idm']) ? $_GET['idm'] : '';
$trs	= isset($_GET['trs']) ? $_GET['trs'] : '';
$no		= isset($_GET['no']) ? $_GET['no'] : '';

//list category
$query_cat = "select * from menu_category";
$query_cat = mysqli_query($connection,$query_cat);

//list menu
$query_mn = "select * from menu_item where ID_CATEGORY = '$id'";
$query_mn = mysqli_query($connection,$query_mn);

//baca no id transaksi	
$query_noid = mysqli_query($connection,"select trs.NO_TRANSACTION from ticket trs where 
							trs.TERMINAL = '$terminal' and
							trs.NO_TRANSACTION = '$no'");
$rowid = mysqli_fetch_array($query_noid);
$notrans = $rowid['NO_TRANSACTION'];
	
//display harga
$q_display = "select 
sum(ttm.SUB_TOTAL) as SUBTOTAL, 
sum(ttm.DISCOUNT) as DISCOUNT, 
sum(ttm.TAX_AMOUNT) as TAX, 
sum(ttm.TOTAL_PRICE) as AMOUNT
from ticket_item ttm
left join ticket tic on tic.NO_TRANSACTION = ttm.NO_TRANSACTION
where 
ttm.NO_TRANSACTION = '$notrans' and 
ttm.TERMINAL = '$terminal' and
tic.NO_TRANSACTION = '$notrans' and 
tic.TERMINAL = '$terminal'
group by tic.TICKET_TYPE";
//print_r($q_display);
$q_display = mysqli_query($connection,$q_display);
$rwdisp = mysqli_fetch_array($q_display);

//display list item menu transaksi
$query_titem = "select * from ticket_item ttm where 
				ttm.TERMINAL = '$terminal' and 
				ttm.NO_TRANSACTION = '$notrans' 
				order by ttm.ID desc";
//print_r($query_titem);
$query_titem = mysqli_query($connection,$query_titem);
$count = mysqli_num_rows($query_titem); // hitung list item transaksi

if($act == 'add'){
//pengecekan data ticket item
$query01 = "select ttm.ITEM_COUNT from ticket_item ttm
			left join menu_item mit on mit.ID_MENU_ITEM = ttm.ITEM_ID
			where 
			ttm.TERMINAL = '$terminal' and 
			ttm.NO_TRANSACTION = '$notrans' and 
			ttm.ITEM_ID = '$idm' ";
$query01 = mysqli_query($connection,$query01);
$data = mysqli_fetch_array($query01);

//jika pada menu belum ada item
if($data['ITEM_COUNT'] == 0 || $data['ITEM_COUNT'] == ''){
	$query = "select * from menu_item item
left join menu_category cat on cat.ID_CATEGORY = item.ID_CATEGORY
where item.ID_MENU_ITEM = '$idm'";

	$query = mysqli_query($connection,$query);
	$row = mysqli_fetch_array($query);
	$sub_total = 1 * $row['PRICE'];
	
	$table_name = "ticket_item";
	$form_data = array(
				'TERMINAL' => $terminal,
				'ITEM_ID' => $row['ID_MENU_ITEM'],
				'ITEM_COUNT' => 1,
				'ITEM_NAME' => $row['MENU_NAME'],
				'CATEGORY_NAME' => $row['CATEGORY_NAME'],
				'ITEM_PRICE' => $row['PRICE'],
				'DISCOUNT_RATE' => 0,
				'SUB_TOTAL' => $sub_total,
				'DISCOUNT' => 0,
				'TAX_AMOUNT' => 0,
				'TOTAL_PRICE' => $sub_total,
				'NO_TRANSACTION' => $notrans
				);
	
	InsertData($table_name, $form_data);
	
	$query02 = mysqli_query($connection,"select 
							sum(ttm.TOTAL_PRICE) as AMOUNT
							from ticket_item ttm
							where 
							ttm.TERMINAL = '$terminal' and 
							ttm.NO_TRANSACTION = '$notrans'");
	$rwamount = mysqli_fetch_array($query02);
		
	$table_name01 = "ticket";
	$form_data01 = array(
				'AMOUNT' => $rwamount['AMOUNT']
				);
				
	UpdateData($table_name01, $form_data01, "WHERE NO_TRANSACTION = '$notrans' and TERMINAL = '$terminal'");	
	
	header("location:?act=$act&no=$no&id=$id&idm=$idm");
	
//jika data sudah ada 
}else{
	$query = "select * from ticket_item ttm
				left join menu_item mit on mit.ID_MENU_ITEM = ttm.ITEM_ID
				where 
				TERMINAL = '$terminal' and 
				ttm.ITEM_ID = '$idm' and
				ttm.NO_TRANSACTION = '$notrans'";

	$query = mysqli_query($connection,$query);
	$row = mysqli_fetch_array($query);
	$item_count = $row['ITEM_COUNT'] + 1;
	$sub_total = $row['ITEM_PRICE'] * $item_count;
	
	$table_name = "ticket_item";
	$form_data = array(
				'ITEM_COUNT' => $item_count,
				'SUB_TOTAL' => $sub_total,
				'TOTAL_PRICE' => $sub_total
				);
	UpdateData($table_name, $form_data, "WHERE ID = '$row[ID]' and TERMINAL = '$terminal' and ITEM_ID = '$idm'");
	
	$query02 = mysqli_query($connection,"select 
							sum(ttm.TOTAL_PRICE) as AMOUNT
							from ticket_item ttm
							where 
							ttm.TERMINAL = '$terminal' and 
							ttm.NO_TRANSACTION = '$notrans'");
	$rwamount = mysqli_fetch_array($query02);
		
	$table_name01 = "ticket";
	$form_data01 = array(
				'AMOUNT' => $rwamount['AMOUNT']
				);
				
	UpdateData($table_name01, $form_data01, "WHERE NO_TRANSACTION = '$notrans' and TERMINAL = '$terminal'");
		
	header("location:?act=$act&no=$no&id=$id&idm=$idm");
}
}


if($act == 'additem'){
	$query = "select * from ticket_item tic where tic.ID = '$idm'";
	//print_r($query);
	$query = mysqli_query($connection,$query);
	$row  = mysqli_fetch_array($query);
	$xqty = $row['ITEM_COUNT'];

	$xqty = $row['ITEM_COUNT'] + 1;
	$sub_total = $row['ITEM_PRICE'] * $xqty;
	
	$form_data = array(
				'ITEM_COUNT' => $xqty,
				'SUB_TOTAL' => $sub_total,
				'TOTAL_PRICE' => $sub_total
				);
	$table_name = "ticket_item";
	UpdateData($table_name, $form_data, "WHERE ID = '$idm'");

	$query02 = "select 
				sum(ttm.TOTAL_PRICE) as AMOUNT
				from ticket_item ttm
				where 
				ttm.TERMINAL = '$terminal' and 
				ttm.NO_TRANSACTION = '$no'";
	$query02 = mysqli_query($connection,$query02);
	$rwamount = mysqli_fetch_array($query02);
	
	$table_name_01 = "ticket";
	$form_data_01 = array(
				'AMOUNT' => $rwamount['AMOUNT']
				);
				
	UpdateData($table_name_01, $form_data_01, "WHERE NO_TRANSACTION = '$no' and TERMINAL = '$terminal'");	
	header("location:?id=$id&no=$no&idm=$idm");

}

if($act == 'minitem'){
	$query = "select * from ticket_item tic where tic.ID = '$idm'";
	//print_r($query);
	$query = mysqli_query($connection,$query);
	$row  = mysqli_fetch_array($query);
	$xqty = $row['ITEM_COUNT'] - 1;

	if($xqty > 0){
		$sub_total = $row['ITEM_PRICE'] * $xqty;
	
		$form_data = array(
					'ITEM_COUNT' => $xqty,
					'SUB_TOTAL' => $sub_total,
					'TOTAL_PRICE' => $sub_total
					);
		$table_name = "ticket_item";
		UpdateData($table_name, $form_data, "WHERE ID = '$idm'");
	
		$query02 = "select 
					sum(ttm.TOTAL_PRICE) as AMOUNT
					from ticket_item ttm
					where 
					ttm.TERMINAL = '$terminal' and 
					ttm.NO_TRANSACTION = '$no'";
		$query02 = mysqli_query($connection,$query02);
		$rwamount = mysqli_fetch_array($query02);
		
		$table_name_01 = "ticket";
		$form_data_01 = array(
					'AMOUNT' => $rwamount['AMOUNT']
					);
					
		UpdateData($table_name_01, $form_data_01, "WHERE NO_TRANSACTION = '$no' and TERMINAL = '$terminal'");	
		header("location:?id=$id&no=$no&idm=$idm");

	}elseif($xqty < 1){
		echo "";
	}
}

// ============ Proses button  ================ //

if($act == 'del'){
	$table_name = "ticket_item";
	DeleteData($table_name, " WHERE ID = '$idm'");
	header("location:?act=$act&no=$no&id=$id&idm=$idm");
}

if(isset($_POST['btn_cancel'])){
	$table_name = "ticket";
	$form_data = array(
				'CLOSING_DATE' => date('Y-m-d H:i:s'),
				'STATUS' => 'VOID'
				);
				
	UpdateData($table_name, $form_data, "WHERE NO_TRANSACTION = '$notrans' and TERMINAL = '$terminal'");
	/*DeleteData($table_name, " where TERMINAL = '$terminal' and ID_USER = '$user_check' and STATUS = 'OPEN' order by ID_TRANSACTION desc limit 1");*/
	
/*	$table_name = "ticket_item";		
	DeleteData($table_name, " where TERMINAL = '$terminal' and NO_TRANSACTION = '$notrans'");*/

	header("location:pos_ticket.php");
}

if(isset($_POST['btn_save'])){
	if($count == 0){
	echo "<script>alert('Item Cannot Empty');window.history.back(-1)</script>";			
	}else{
	$table_name = "ticket";
	$form_data = array(
				'AMOUNT' => $rwdisp['AMOUNT'],
				'STATUS' => 'SAVE'
				);
				
	UpdateData($table_name, $form_data, "WHERE NO_TRANSACTION = '$notrans' and TERMINAL = '$terminal'");
	
	$query02 = mysqli_query($connection,"select 
							sum(ttm.TOTAL_PRICE) as AMOUNT
							from ticket_item ttm
							where 
							ttm.TERMINAL = '$terminal' and 
							ttm.NO_TRANSACTION = '$notrans'");
	$rwamount = mysqli_fetch_array($query02);
		
	$table_name01 = "ticket";
	$form_data01 = array(
				'AMOUNT' => $rwamount['AMOUNT']
				);
				
	UpdateData($table_name01, $form_data01, "WHERE NO_TRANSACTION = '$notrans' and TERMINAL = '$terminal'");
	
	$table_name01 = "terminal";
	$form_data01 = array(
				'NO_TRANSACTION' => $notrans
				);
				
	UpdateData($table_name01, $form_data01, "TERMINAL = '$terminal'");

	header("location:pos_ticket.php");
	}
}

if(isset($_POST['btn_pay'])){
	if($count == 0){
	echo "";			
	}elseif($_POST['bayar'] < $_POST['transaksi']){
	echo "";
	}else{
	$table_name = "ticket";
	$form_data = array(
				'CLOSING_DATE' => date('Y-m-d H:i:s'),
				'PAYMENT_TYPE' => 'CASH',
				'AMOUNT' => $rwdisp['AMOUNT'],
				'TENDER_AMOUNT' => $_POST['bayar'],
				'DUE_AMOUNT' => $_POST['kembali'],
				'NOTE' => $_POST['catatan'],
				'STATUS' => 'COMPLETE'
				);
	// $form_data = array(
	// 	'NO_TRANSACTION' => $notrans,
	// 	'TERMINAL' => $terminal,
	// 	'ID_USER' => $user_check,	
	// 	'CREATE_DATE' => date('Y-m-d H:i:s'),
	// 	'TICKET_TYPE' => 'DINE IN',
	// 	'STATUS' => 'OPEN',
	// 	'ID_TRANSACTION' => $idtrans,
	// 	'CLOSING_DATE' => date('Y-m-d H:i:s'),
	// 	'TICKET_TYPE' => $_SESSION['TICKET_TYPE'],
	// 	'PAYMENT_TYPE' => 'CASH',
	// 	'AMOUNT' => $rwdisp['AMOUNT'],
	// 	'TENDER_AMOUNT' => $_POST['bayar'],
	// 	'DUE_AMOUNT' => $_POST['kembali'],
	// 	'NOTE' => $_POST['catatan'],
	// 	'STATUS' => 'COMPLETE',
	// 	'ID_TRANSACTION' => $idtrans
	// 	);
				
	UpdateData($table_name, $form_data, "WHERE NO_TRANSACTION = '$notrans' and TERMINAL = '$terminal'");
	
	$table_name01 = "terminal";
	$form_data01 = array(
				'NO_TRANSACTION' => $notrans
				);
				
	UpdateData($table_name01, $form_data01, "TERMINAL = '$terminal'");

	header("location:pos_print.php?id=$notrans");
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
		width:34%;
		height:60%;
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
	/* CONTENT */
	.content{
		width:64%;
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
	.btn_settle {
	font-size: 26px;
	text-decoration: none;
	width: 32%;
	background-color: #009933;
	border: 1px solid #ababab;
	color: #FFF;
	height: 97px;
	float: left;
	margin-right: 1%;
	}
.btn_save {
	font-size: 26px;
	text-decoration: none;
	width: 32%;
	background-color: #FFCC00;
	border: 1px solid #ababab;
	color: #000;
	height: 97px;
	float: left;
	margin-right: 1%;
}
.btn_close {
	font-size: 26px;
	text-decoration: none;
	width: 32%;
	background-color: #990000;
	border: 1px solid #ababab;
	color: #FFF;
	height: 97px;
	float: left;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 60%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.btn_payment {
	font-size: 33px;
	text-decoration: none;
	width: 2.2em;
	background-color: #50a8f2;
	border: 1px solid #ababab;
	color: #FFF;
	float: left;
	margin-right: 1%;
	height: 2.2em;
}
</style>
<link href="content/css/stylesheet.css" rel="stylesheet" type="text/css" />
</head>

<body onresize="resizeWindow()" onload="resizeWindow()">
<script type="text/javascript">
function addCode(key){
	var bayar = document.forms[1].bayar;
		bayar.value = bayar.value + key;
}

function submitForm(){
	document.forms[1].submit();
}	

function emptyCode(){
	document.forms[1].bayar.value = "";
}

function closeWin() {
             var win = window.open('', '_self');
             window.close();
             win.close(); return false;
} 

</script>
<div class="header">
  <div class="label_header"><strong><?php echo "$terminal"; ?></strong></div>
<img src="content/images/logo-01.png" width="125" height="25" /></div>
<form action="" method="post">
<div class="navigation" id="navigation">
	<div class="navigationPanel" id="navigationPanel">
    <div class="pos-display"><table width="95%" align="center">
  <tr>
    <td width="15%" class="pos-display-text01">Subtotal</td>
    <td width="30%" class="pos-display-text01">: <span class="pos-display-text01"><?php $subtotal = number_format($rwdisp['SUBTOTAL']); echo "$subtotal" ?></span></td>
    <td rowspan="3" align="right"><div class="pos-display-text02"><?php $amount = number_format($rwdisp['AMOUNT']); echo "$amount" ?></div></td>
  </tr>
  <tr class="pos-display-text01">
    <td class="pos-display-text01">Diskon</td>
    <td class="pos-display-text01">: <span class="pos-display-text01"><?php $discount = number_format($rwdisp['DISCOUNT']); echo "$discount" ?></span></td>
    </tr>
  <tr class="pos-display-text01">
    <td class="pos-display-text01">Pajak</td>
    <td class="pos-display-text01">: <span class="pos-display-text01"><?php $tax = number_format($rwdisp['TAX']); echo "$tax" ?></span></td>
    </tr>
    </table>
</div>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="table-model-01">
    <tr class="text_content">
      <td class="label_header"><strong>Product</strong></td>
      <td class="label_header"><strong>Qty</strong></td>
      <td class="label_header"><strong>Total</strong></td>
      <td width="2%" align="center">&nbsp;</td>
    </tr>
    
    <!-- list item menu transaksi -->
    <?php while($rwitem = mysqli_fetch_array($query_titem)){ ?>
    <tr class="text_content_02">
      <td><div class="label_header"><?php echo"$rwitem[ITEM_NAME]" ?></div>
        <div>Rp
          <?php $item_price = number_format($rwitem['ITEM_PRICE']); echo "$item_price"; ?>
        </div></td>
      <td class="label_header"><a href="<?php echo"?id=$id&act=minitem&no=$rwitem[NO_TRANSACTION]&idm=$rwitem[ID]" ?>" class="pos-qty-box">-</a><a href="<?php echo"pos_menu_qty_pending.php?id=$id&no=$rwitem[NO_TRANSACTION]&idm=$rwitem[ID]" ?>" class="pos-qty-box"><?php echo"$rwitem[ITEM_COUNT]" ?></a><a href="<?php echo"?id=$id&act=additem&no=$rwitem[NO_TRANSACTION]&idm=$rwitem[ID]" ?>" class="pos-qty-box">+</a></td>
      <td class="label_header">Rp <?php $total_price = number_format($rwitem['TOTAL_PRICE']); echo "$total_price"; ?></td>
      <td align="center"><a href="<?php echo"?act=del&no=$no&id=$id&idm=$rwitem[ID]" ?>"><img src="content/images/btn-delete.png" width="35" height="35"  style="border:0;" /></a></td>
    </tr>
    <?php } ?>
  </table>
  </div>
  
  <div class="clear"></div>
  <div>
    <input name="btn_pay" type="button" class="btn_settle" id="myBtn" value="Pay" />
    <input name="btn_save" type="submit" class="btn_save" id="submit2" value="Save"/>
    <input name="btn_cancel" type="submit" class="btn_close" id="submit" value="Void" onclick="javascript:return confirm('Are you sure you want to cancel this transaction ?')"/>
  </div>
</div>
</form>    
            <div class="content" id="content">
            <div class="contentPanel" id="contentPanel">
              <table width="100%">
                <tr>
                  <td width="10%" valign="top" class="label_header"><?php while($rwcat = mysqli_fetch_array($query_cat)){ ?>
                  <?php echo"<a href=\"?no=$no&id=$rwcat[ID_CATEGORY]\" class=\"menu_category\">$rwcat[CATEGORY_NAME]</a> "; } ?></td>
                  <td width="80%" valign="top" ><?php while($rwmn = mysqli_fetch_array($query_mn)){ ?>
                  <?php echo"<a href=\"?act=$act&no=$no&id=$id&idm=$idm&act=add&idm=$rwmn[ID_MENU_ITEM]\" class=\"menu_item\">$rwmn[MENU_NAME]</a> "; } ?></td>
                </tr>
              </table>
</div>
            <div class="clear"></div>


<?php if($count == 0){ echo ""; }else{ ?>


<!-- Start Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
   
    <div>

<script type="text/javascript">
	function calculateTotal() {
		
		if(document.cashpull.bayar.value == ''){
		document.getElementById('kembali').value = '';
		}else{
		var totalAmt = document.cashpull.transaksi.value;
		totalR = eval(document.cashpull.bayar.value - totalAmt);
		
		document.getElementById('kembali').value = totalR;
		}
	}

</script>
    
    <form name="cashpull" method="post" action="" id="cashpull">
  <table width="100%" align="center">
    <tr>
      <td valign="top"><table width="98%" border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td colspan="2" class="label_dashboard">Pembayaran <span class="close" id="close">×</span></td>
          </tr>
        <tr>
          <td><span class="label_dashboard_text">Total Transaksi</span></td>
          <td align="right"><span class="label_dashboard_text">
            <input name="transaksi" type="text" class="input_underline" id="transaksi" readonly="readonly" value="<?php echo "$rwdisp[AMOUNT]" ?>" />
          </span></td>
        </tr>
        <tr>
          <td><span class="label_dashboard_text">Tunai</span></td>
          <td align="right"><span class="label_dashboard_text">
            <input name="bayar" type="text" class="input_underline" tabindex="1" id="bayar" />
          </span></td>
        </tr>
        <tr>
          <td class="label_dashboard_text">Kembali</td>
          <td align="right"><span class="label_dashboard_text">
            <input name="kembali" type="text" class="input_underline" id="kembali" />
          </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><hr /></td>
          </tr>
        <tr>
          <td class="label_dashboard_text">Status Pesanan</td>
          <td align="right"><select name="status_pesanan" id="status_pesanan" class="select_payment">
    <option selected="selected"><?php echo $_SESSION['TICKET_TYPE'] ?></option>
    <option><?php if($_SESSION['TICKET_TYPE'] == 'DINE IN'){ echo"TAKE AWAY"; }else{ echo "DINE IN"; } ?></option>
  </select></td>
        </tr>
        <tr>
          <td class="label_dashboard_text">Catatan</td>
          <td align="right"><input name="catatan" type="text" class="input_underline_left" value="" /></td>
        </tr>
      </table></td>
      <td width="20%" align="right" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td width="80%" align="right"><input name="btn01" type="button" onclick="addCode('1'); calculateTotal();" class="btn_payment" id="btn01" value="1" /></td>
          <td width="80%" align="right"><input name="btn02" type="button" onclick="addCode('2'); calculateTotal();" class="btn_payment" id="btn02" value="2" /></td>
          <td width="80%" align="right"><input name="btn03" type="button" onclick="addCode('3'); calculateTotal();" class="btn_payment" id="btn03" value="3" /></td>
        </tr>
        <tr>
          <td align="right"><input name="btn04" type="button" onclick="addCode('4'); calculateTotal();" class="btn_payment" id="btn04" value="4" /></td>
          <td align="right"><input name="btn05" type="button" onclick="addCode('5'); calculateTotal();" class="btn_payment" id="btn05" value="5" /></td>
          <td align="right"><input name="btn06" type="button" onclick="addCode('6'); calculateTotal();" class="btn_payment" id="btn06" value="6" /></td>
        </tr>
        <tr>
          <td align="right"><input name="btn07" type="button" onclick="addCode('7'); calculateTotal();" class="btn_payment" id="btn07" value="7" /></td>
          <td align="right"><input name="btn08" type="button" onclick="addCode('8'); calculateTotal();" class="btn_payment" id="btn08" value="8" /></td>
          <td align="right"><input name="btn09" type="button" onclick="addCode('9'); calculateTotal();" class="btn_payment" id="btn09" value="9" /></td>
        </tr>
        <tr>
          <td align="right"><input name="btn_clear" type="reset"  class="btn_payment" id="btn_clear" value="Del" /></td>
          <td align="right"><input name="btn00" type="button" onclick="addCode('0'); calculateTotal();" class="btn_payment" id="btn00" value="0" /></td>
          <td align="right"><input name="btn_pay" type="submit" class="btn_payment" id="btn_pay" value="Pay" /></td>
        </tr>
      </table></td>
    </tr>
  </table>
  </form>
</div>
    
  </div>
</div>
<!-- End Modal -->
<?php } ?>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementById("close");

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
	document.forms[1].bayar.value = "";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
	document.forms[1].bayar.value = "";
	document.forms[1].kembali.value = "";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
            
</body>

<script type="text/javascript">
            
        function resizeWindow() 
        {
            var windowHeight = getWindowHeight();

            document.getElementById("content").style.height = (windowHeight - 160) + "px";
            document.getElementById("contentPanel").style.height = (windowHeight - 60) + "px";
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
