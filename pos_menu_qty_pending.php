<?php
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";

$mod	= $_GET['mod'] ? $_GET['mod'] : 'trans';
$act	= $_GET['act'];
$cat	= $_GET['cat'];
$id	 	= $_GET['id'];
$idm	= $_GET['idm'];
$no		= $_GET['no']; //no transaksi

$query = "select * from ticket_item tic where tic.ID = '$idm'";
//print_r($query);
$query = mysql_query($query);
$row  = mysql_fetch_array($query);
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
	
	$query02 = mysql_query("select 
							sum(ttm.TOTAL_PRICE) as AMOUNT
							from ticket_item ttm
							where 
							ttm.TERMINAL = '$terminal' and 
							ttm.NO_TRANSACTION = '$no'");
	$rwamount = mysql_fetch_array($query02);
	
	$table_name01 = "ticket";
	$form_data01 = array(
				'AMOUNT' => $rwamount['AMOUNT']
				);
				
	UpdateData($table_name01, $form_data01, "WHERE TERMINAL = '$terminal' and NO_TRANSACTION = '$no'");	
	header("location:pos_pending.php?no=$no&id=$id");
}
}

//list ticket item 
$query_titem = "select * from ticket_item where ID = '$idm'";
$query_titem = mysql_query($query_titem);
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
<script src="content/js/jquery.min.js"></script>
<script type="text/javascript">
$(window).load(function() {
	$(".loader").fadeOut("slow");
})
</script>
</head>

<body>
</head>

<body onload="emptyCode();">
<script type="text/javascript">
function addCode(key){
	var code = document.forms[0].code;
	if(code.value.length < 5){
		code.value = code.value + key;
	}
	if(code.value.length == 5){
		setTimeout(submitForm,1000);	
	}
}

function submitForm(){
	document.forms[0].submit();
}

function emptyCode(){
	document.forms[0].code.value = "<?php echo"$rwitem[ITEM_COUNT]" ?>";
}

</script>
<div class="divCenter">
<center>
<form id="login" method="post" action="">
  <table width="100%" cellspacing="5">
    <tr>
      <td valign="middle"><table width="230" class="table-model-01">
      <?php while($rwitem = mysql_fetch_array($query_titem)){ ?>
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
        <tr>
          <td colspan="3" align="center"><input type="text" name="code" value="" maxlength="4" class="lcd" /></td>
        </tr>
        <tr>
          <td align="center"><input name="btn01" type="button" onclick="addCode('1');" class="btn_login" id="1" value="1" /></td>
          <td align="center"><input name="btn02" type="button" onclick="addCode('2');"class="btn_login" id="btn02" value="2" /></td>
          <td align="center"><input name="btn03" type="button" onclick="addCode('3');"class="btn_login" id="btn03" value="3" /></td>
        </tr>
        <tr>
          <td align="center"><input name="btn04" type="button" onclick="addCode('4');"class="btn_login" id="btn04" value="4" /></td>
          <td align="center"><input name="btn05" type="button" onclick="addCode('5');"class="btn_login" id="btn05" value="5" /></td>
          <td align="center"><input name="btn06" type="button" onclick="addCode('6');"class="btn_login" id="btn06" value="6" /></td>
        </tr>
        <tr>
          <td align="center"><input name="btn07" type="button" onclick="addCode('7');"class="btn_login" id="btn07" value="7" /></td>
          <td align="center"><input name="btn08" type="button" onclick="addCode('8');"class="btn_login" id="btn08" value="8" /></td>
          <td align="center"><input name="btn09" type="button" onclick="addCode('9');"class="btn_login" id="btn09" value="9" /></td>
        </tr>
        <tr>
          <td align="center"><input name="btn_clear" type="reset" class="btn_back" id="btn_clear" value="&lt;" /></td>
          <td align="center"><input name="btn00" type="button" onclick="addCode('0');"class="btn_login" id="btn00" value="0" /></td>
          <td align="center"><input name="submit" type="submit" class="btn_save" id="submit" value="Save" /></td>
        </tr>
        </table></td>
    </tr>
  </table>
</form>
</center>
</div>
</body>
</html>