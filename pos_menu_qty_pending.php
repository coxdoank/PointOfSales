<?php
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";

// $mod	= $_GET['mod'] ? $_GET['mod'] : 'trans';
// $act	= $_GET['act'];
// $cat	= $_GET['cat'];
// $id	 	= $_GET['id']; //daftar menu
// $idm	= $_GET['idm'];
// $no		= $_GET['no']; //no transaksi

$mod	= isset($_GET['mod']) ? $_GET['mod'] : 'trans';
$act	= isset($_GET['act']) ? $_GET['act'] : '';
$cat	= isset($_GET['cat']) ? $_GET['cat'] : '';
$id	 	= isset($_GET['id']) ? $_GET['id'] : '';
$idm	= isset($_GET['idm']) ? $_GET['idm'] : '';
$no		= isset($_GET['no']) ? $_GET['no'] : '';

$query = "select * from ticket_item tic where tic.ID = '$idm'";
//print_r($query);
$query = mysqli_query($connection,$query);
$row  = mysqli_fetch_array($query);
$xqty = $row['ITEM_COUNT'];

if(isset($_POST['submit'])) {
	if (empty($_POST['code'])) {
	$error = "Please Input Qty";
}
else
{
	$sub_total = $row['ITEM_PRICE'] * $_POST['code'];
	
	$form_data = array(
				'ITEM_COUNT' => $_POST['code'],
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
				
	UpdateData($table_name_01, $form_data_01, "WHERE TERMINAL = '$terminal' and NO_TRANSACTION = '$no'");	
	header("location:pos_pending.php?no=$no&id=$id");
}
}

//list ticket item 
$query_titem = "select * from ticket_item where ID = '$idm'";
$query_titem = mysqli_query($connection,$query_titem);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type='text/css'>
.button {
	background-color: #444444;
	font-size: 45px;
	color: white;
	width: 1.5em;
	height: 1.5em;
	border: 4px solid white;
	}
.lcd {
	background-color: #FFFFFF;
	font-size: 40px;
	color: black;
	border: 1px solid #CCC;
	width: 220pt;
	text-align: center;
	height: 60pt;
	}
.btn_login {
	font-size: 36px;
	text-decoration: none;
	height: 75pt;
	width: 75pt;
	background-color: #FC0;
	border: 1px solid #FFF;
}
.btn_back {
	font-size: 36px;
	text-decoration: none;
	height: 75pt;
	width: 75pt;
	background-color: #666;
	border: 1px solid #FFF;
	color: #FFF;
}
.btn_save {
	font-size: 26px;
	text-decoration: none;
	height: 75pt;
	width: 75pt;
	background-color: #009933;
	border: 1px solid #FFF;
	color: #FFF;
}
.field_login {	height: 38px;
	width: 265px;
	line-height: 35px;
	font-size: 24px;
	text-align: center;
	background-color: #FFF;
}
.text_header {
	font-size: 36px;
	color: #000;
}
.text_content {
	font-size: 24px;
	color: #000;
}
.divCenter {
	position:absolute;
	top:25%;
	left:35%;
	margin-top:-50px;
	margin-left: -50px;
	width: 100px;
	height: 100px;
}
</style>
<link href="content/css/stylesheet.css" rel="stylesheet" type="text/css" />

<script type='text/javascript'>
function addIt(cKey) { d = document.forms[0].elements["code"]; d.value =  (cKey.value=='<') ? d.value.slice(0,-1) : ((cKey.value=='clear') ? "" : d.value+cKey.value); }
</script>

</head>

<body>
<div class="divCenter">
<form id="login" method="post" action="">
  <table width="100%" cellspacing="5">
    <tr>
      <td valign="middle"><table width="230" class="table-model-01">
      <?php while($rwitem = mysqli_fetch_array($query_titem)){ ?>
        <tr class="text_content">
          <td colspan="3" class="text_header"><p align="center"><strong>Item</strong></p></td>
        </tr>
        <tr class="text_content">
          <td class="label_header"><span class="label_header">Product</span></td>
          <td class="label_header"><span class="label_header">:</span></td>
          <td class="label_header"><div class="label_header"><span class="label_header"><?php echo"$rwitem[ITEM_NAME]" ?></span></div></td>
        </tr>
        
        <tr class="text_content_02">
          <td><span class="label_header">Harga</span></td>
          <td class="label_header"><span class="label_header">:</span></td>
          <td class="label_header"><span class="label_header">Rp
            <?php $item_price = number_format($rwitem['ITEM_PRICE']); echo "$item_price"; ?>
          </span></td>
          </tr>
        <tr class="text_content_02">
          <td><span class="label_header">Qty</span></td>
          <td class="label_header"><span class="label_header">:</span></td>
          <td class="label_header"><span class="label_header"><?php echo"$rwitem[ITEM_COUNT]" ?></span></td>
        </tr>
        <tr class="text_content_02">
          <td><span class="label_header">Total</span></td>
          <td class="label_header"><span class="label_header">:</span></td>
          <td class="label_header"><span class="label_header">
            Rp
               <?php $total_price = number_format($rwitem['TOTAL_PRICE']); echo "$total_price"; ?>
          </span></td>
        </tr>
        <?php } ?>
      </table></td>
      <td><table width="180">
        <!-- <tr>
          <td colspan="3" align="center"><input type="text" name="code" value="" maxlength="4" class="lcd" /></td>
        </tr> -->
        <tr>
			<center>
			<input type='text' class=lcd size=12 name="code" style='width:200px'>
			<br>
			<INPUT class=button type=button value=1 onClick="addIt(this)"><INPUT class=button type=button value=2 onClick="addIt(this)"><INPUT class=button type=button value=3 onClick="addIt(this)"><BR>
			<INPUT class=button type=button value=4 onClick="addIt(this)"><INPUT class=button type=button value=5 onClick="addIt(this)"><INPUT class=button type=button value=6 onClick="addIt(this)"><BR>
			<INPUT class=button type=button value=7 onClick="addIt(this)"><INPUT class=button type=button value=8 onClick="addIt(this)"><INPUT class=button type=button value=9 onClick="addIt(this)"><BR>
			<INPUT class=button type=button value=0 onClick="addIt(this)"><br><INPUT class=button type=button value=< onClick="addIt(this)"><!-- <INPUT class=button type=button value=+ onClick="addIt(this)"> -->
			<!--<input class=button type='button' value=clear onClick="addIt(this)" style='width:100px'>--><input name='submit' type='submit' class=button id='submit' value=Save style='width:120px; background-color:#009900'><BR>
			</center>          
        </tr>
        </table></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>