<?php 
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";

$mod	= isset($_GET['mod']) ? $_GET['mod'] : '';
$act	= isset($_GET['act']) ? $_GET['act'] : '';
$cat	= isset($_GET['cat']) ? $_GET['cat'] : '';
$id	 	= isset($_GET['id']) ? $_GET['id'] : '';
$idm	= isset($_GET['idm']) ? $_GET['idm'] : '';
$idtr	= isset($_GET['idtr']) ? $_GET['idtr'] : '';

// restaurant
$qres = "select * from restaurant";
$qres = mysqli_query($connection,$qres);
$row = mysqli_fetch_array($qres);

//cek id transaksi 
$query = mysqli_query($connection,"select 
		trs.ID_TRANSACTION,
		trs.TERMINAL,
		trs.TRANS_DATE,
		trs.CREATE_DATE,
		trs.CLOSING_DATE,
		trs.OPENING_BALANCE,
		trs.ASSIGNED_USER,
		trs.FLAG,
		trs.SYNC,
		usr.FIRST_NAME,
		usr.LAST_NAME
		from transaction trs 
		left join user usr on usr.USER_ID = trs.ASSIGNED_USER
		where trs.ID_TRANSACTION = '$id'");
$rows = mysqli_fetch_array($query);
$idtrans = $rows['ID_TRANSACTION'];

// data modal,sales,drawer
$qdetail = "select 
(select
	sum(case when drw.ACCOUNT_NAME = 'MODAL' then drw.CASH_BALANCE else 0 end)
	from drawer_balance drw	
	left join transaction trs on trs.ID_TRANSACTION = drw.ID_TRANSACTION
	where drw.TERMINAL = '$terminal' and drw.ID_TRANSACTION = '$idtrans'
) as MODAL,

(select
	sum(case when drw.ACCOUNT_NAME = 'CASH IN' then drw.CASH_BALANCE else 0 end) as AMOUNT
	from drawer_balance drw	
	left join transaction trs on trs.ID_TRANSACTION = drw.ID_TRANSACTION
	where drw.TERMINAL = '$terminal' and drw.ID_TRANSACTION = '$idtrans'
) as CASH_IN,

(select
	sum(case when drw.ACCOUNT_NAME = 'CASH OUT' then drw.CASH_BALANCE else 0 end) as AMOUNT
	from drawer_balance drw	
	left join transaction trs on trs.ID_TRANSACTION = drw.ID_TRANSACTION
	where drw.TERMINAL = '$terminal' and drw.ID_TRANSACTION = '$idtrans'
) as CASH_OUT,

(select
	sum(case when drw.ACCOUNT_NAME = 'END SHIFT' then drw.CASH_BALANCE else 0 end)
	from drawer_balance drw	
	left join transaction trs on trs.ID_TRANSACTION = drw.ID_TRANSACTION
	where drw.TERMINAL = '$terminal' and drw.ID_TRANSACTION = '$idtrans'
) as END_SHIFT,

(select
	sum(case when drw.ACCOUNT_NAME = 'MODAL' then drw.CASH_BALANCE else 0 end) +
	sum(case when drw.ACCOUNT_NAME = 'CASH IN' then drw.CASH_BALANCE else 0 end) +
	sum(case when drw.ACCOUNT_NAME = 'CASH OUT' then drw.CASH_BALANCE else 0 end) +
	sum(case when drw.ACCOUNT_NAME = 'END SHIFT' then drw.CASH_BALANCE else 0 end)
	from drawer_balance drw	
	left join transaction trs on trs.ID_TRANSACTION = drw.ID_TRANSACTION
	where drw.TERMINAL = '$terminal' and drw.ID_TRANSACTION = '$idtrans'
) as TOTAL_CASH_DRAWER,

(select 
	sum(tic.AMOUNT) as a
	from ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where tic.TERMINAL = '$terminal' and trs.ID_TRANSACTION = '$idtrans' and tic.STATUS = 'COMPLETE' 
) as TOTAL_SALES,

(select 
	sum(tic.AMOUNT) as a
	from ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where tic.TERMINAL = '$terminal' and trs.ID_TRANSACTION = '$idtrans' and tic.STATUS = 'VOID'
) as TOTAL_VOID,

sum(AMOUNT) as CASH_DRAWER
from 
(
	select
	sum(case when drw.ACCOUNT_NAME = 'MODAL' then drw.CASH_BALANCE else 0 end) +
	sum(case when drw.ACCOUNT_NAME = 'CASH IN' then drw.CASH_BALANCE else 0 end) -
	sum(case when drw.ACCOUNT_NAME = 'CASH OUT' then drw.CASH_BALANCE else 0 end) -
	sum(case when drw.ACCOUNT_NAME = 'END SHIFT' then drw.CASH_BALANCE else 0 end) as AMOUNT
	from drawer_balance drw	
	left join transaction trs on trs.ID_TRANSACTION = drw.ID_TRANSACTION
	where drw.TERMINAL = '$terminal' and drw.ID_TRANSACTION = '$idtrans'
	union all
	select 
	sum(tic.AMOUNT) as a
	from ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where tic.TERMINAL = '$terminal' and trs.FLAG = 'N' and tic.STATUS in ('COMPLETE','VOID')
) x";
$qdetail = mysqli_query($connection,$qdetail);
$rwdtl = mysqli_fetch_array($qdetail);

mysqli_query($connection,"DELETE FROM ticket");
mysqli_query($connection,"DELETE FROM ticket_item");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "$terminal - End Shift #$id" ?></title>
<style type="text/css">
body,td,th,input,select,textarea {
	font-family: MyriadPro-Regular;
}
/*
body {
    font: 12pt;
	width: 100%;
	height: 100%;
}
* {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
}
.page {
    width: auto;
	height: auto;
	padding: 0mm;
}
 
@page {
    size: auto auto;
    margin: 0;
}
@media print{
	@page {
    size: auto auto;
    margin: 0;
}
    .page {
		width: auto;
        margin: 0;
        page-break-after: always;
    }
}
*/

body {
  /* font: 14pt; */
  /* margin: 0;
  padding: 0;   */
	width: 100%;
	height: 100%;
}
* {
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}
.page {
  width: 58mm;
  min-height: auto;
	height: auto;
  padding: 0mm;
}
 
@page {
    size: 58mm auto;
    margin: 0;
}
@media print{
	@page {
    size: 58mm auto;
    margin: 0;
}
    .page {
		width: 58mm;
        margin: 0;
        /* min-height: initial; */
        page-break-after: always;
    }
}

.text_header {
	font-family: 'MyriadPro-Regular';
	text-decoration: none;
	font-size: 12pt;
	font-weight: bold;
}
.text_subheader {
	font-family: 'MyriadPro-Regular';
	text-decoration: none;
	font-size: 9pt;
	font-weight: bold;
}
.text_content {
	font-family: 'MyriadPro-Regular';
	text-decoration: none;
	font-size: 9pt;
}
/* TABLE */
.table-model {
	font-family: 'MyriadPro-Regular';
	border-spacing: 0;
	border-collapse: collapse;
}
.table-model th {
	padding-top: 7px;
	padding-bottom: 7px;
	text-align: left;
	text-indent: 10px;
	background-color: #FFFFFF;
}
.table-model td {
	padding-top: 5px;
	padding-bottom: 5px;
	text-align: center;
	text-indent: 10px;
}

.table-model-01 {
	font-family: 'MyriadPro-Regular';
	border-spacing: 0;
	border-collapse: collapse;
}

.table-model-01 th {
	border-top-width: 1px;
	border-bottom-style: solid;
	border-top-color: #CCC;
	border-top-style: solid;
	border-bottom-color: #CCC;
	border-bottom-width: 1px;
	padding-top: 3px;
	padding-bottom: 3px;
	color: #666;
	text-align: left;
	text-indent: 10px;
	background-color: #FFFFFF;
}
.table-model-01 td {
	border-bottom-style: dashed;
	border-bottom-color: #999;
	border-bottom-width: 1px;
	padding-top: 3px;
	padding-bottom: 3px;
	text-align: left;
	text-indent: 2px;
}
</style>
<link href="content/css/stylesheet.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.text_header1 {	font-family: 'MyriadPro-Regular';
	text-decoration: none;
	font-size: 10pt;
	font-weight: bold;
}
</style>
<script>
    function pageRedirect() {
        window.print();
        window.location.replace("work_periods.php");
    }      
    setTimeout("pageRedirect()", 1000);
</script>
</head>

<body>
<div class="page">
  <table width="100%" align="center" cellpadding="1" cellspacing="0" class="table-model">
    <tr>
      <td align="center" class="label_dashboard_text"><span class="text_header1">
        <?php if($row['LOGO'] == "Y"){ echo "<img src='content/images/logo-odaba.png' width='150' height='150' />"; }else{ echo "$row[NAME]"; } ?>
      </span></td>
    </tr>
    <tr>
      <td align="center" class="label_header"><span class="text_subheader"><?php echo "$row[ADDRESS_LINE1]" ?>  <?php echo "$row[ADDRESS_LINE2]" ?></span></td>
    </tr>
    <tr>
      <td align="center"><span class="text_subheader"> Telp : <?php echo "$row[TELEPHONE]" ?></span></td>
    </tr>
    <tr>
      <td><table width="100%" cellpadding="1" cellspacing="0" class="table-model-01">
        <tr>
          <td colspan="3"><div align="center" class="text_header">END SHIFT</div></td>
          </tr>
        <tr>
          <td><span class="text_content">Terminal</span></td>
          <td align="center"><span class="text_content">:</span></td>
          <td><span class="text_content"><?php echo "$rows[TERMINAL]" ?></span></td>
          </tr>
        <tr>
          <td><span class="text_content">Trans Date</span></td>
          <td align="center"><span class="text_content">:</span></td>
          <td><span class="text_content"><?php echo "$rows[TRANS_DATE]" ?></span></td>
          </tr>
        <tr>
          <td><span class="text_content">Created</span></td>
          <td align="center"><span class="text_content">:</span></td>
          <td><span class="text_content"><?php echo "$rows[CREATE_DATE]" ?> Wib</span></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><span class="text_content">Cashier</span></td>
          <td align="center"><span class="text_content">:</span></td>
          <td><span class="text_content"><?php echo "$rows[FIRST_NAME] $rows[LAST_NAME]" ?></span></td>
          </tr>
        <tr>
          <td><span class="text_content"> Modal</span></td>
          <td align="center"><span class="text_content">:</span></td>
          <td><span class="text_content"><?php echo number_format($rwdtl['MODAL']) ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content"> Cash In</span></td>
          <td align="center"><span class="text_content">:</span></td>
          <td><span class="text_content"><?php echo number_format($rwdtl['CASH_IN']) ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content">Cash Out</span></td>
          <td align="center"><span class="text_content">:</span></td>
          <td><span class="text_content"><?php echo number_format($rwdtl['CASH_OUT']) ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content">End Shift</span></td>
          <td align="center"><span class="text_content">:</span></td>
          <td><span class="text_content"><?php echo number_format($rwdtl['END_SHIFT']) ?></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><span class="text_content">Total Void</span></td>
          <td align="center"><span class="text_content">:</span></td>
          <td><span class="text_content"><?php echo number_format($rwdtl['TOTAL_VOID']) ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content">Total Sales</span></td>
          <td align="center"><span class="text_content">:</span></td>
          <td><span class="text_content"><?php echo number_format($rwdtl['TOTAL_SALES']) ?></span></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
</body>
</html>