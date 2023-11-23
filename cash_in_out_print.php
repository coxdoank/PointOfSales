<?php 
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";

$mod	= isset($_GET['mod']) ? $_GET['mod'] : '';
$act	= isset($_GET['act']) ? $_GET['act'] : '';
$cat	= isset($_GET['cat']) ? $_GET['cat'] : '';
$id	 	= isset($_GET['id']) ? $_GET['id'] : '';
$idm	= isset($_GET['idm']) ? $_GET['idm'] : '';
$idtr	= isset($_POST['idtr']) ? $_POST['idtr'] : '';

// restaurant
$qres = "select * from restaurant";
$qres = mysqli_query($connection,$qres);
$row = mysqli_fetch_array($qres);

//cel id transaksi 
$query = mysqli_query($connection,"select 
drw.CREATE_DATE,
drw.ACCOUNT_NAME,
drw.CASH_BALANCE,
drw.TERMINAL,
drw.ID_TRANSACTION,
drw.NOTE,
drw.UPDATE_BY,
usr.FIRST_NAME,
usr.LAST_NAME,
trs.TRANS_DATE
from drawer_balance drw
left join transaction trs on trs.ID_TRANSACTION = drw.ID_TRANSACTION
left join user usr on usr.USER_ID = trs.ASSIGNED_USER
where drw.ID = '$id'");
$rows = mysqli_fetch_array($query);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "$terminal - $rows[ACCOUNT_NAME] #$id" ?></title>
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
<script>
    function pageRedirect() {
        window.print();
        window.location.replace("cash_in_out.php");
    }      
    setTimeout("pageRedirect()", 1000);
</script>
</head>

<body>
<div class="page">
  <table width="100%" align="center" cellpadding="1" cellspacing="0" class="table-model">
    <tr>
      <td align="center" class="label_dashboard_text"><span class="text_header"><?php echo "$row[NAME]" ?></span></td>
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
          <td colspan="2"><div align="center" class="text_header"><?php echo "$rows[ACCOUNT_NAME]" ?></div></td>
          </tr>
        <tr>
          <td><span class="text_content">Terminal</span></td>
          <td><span class="text_content">: <?php echo "$rows[TERMINAL]" ?></span></td>
          </tr>
        <tr>
          <td><span class="text_content">Trans Date</span></td>
          <td><span class="text_content">: <?php echo "$rows[TRANS_DATE]" ?></span></td>
          </tr>
        <tr>
          <td><span class="text_content">Created</span></td>
          <td><span class="text_content">: <?php echo "$rows[CREATE_DATE]" ?> Wib</span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><span class="text_content">Cashier</span></td>
          <td><span class="text_content">: <?php echo "$rows[FIRST_NAME] $rows[LAST_NAME]" ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content"> Balance</span></td>
          <td><span class="text_content">: <?php echo number_format($rows['CASH_BALANCE']) ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content"> Note</span></td>
          <td><span class="text_content">: <?php if($rows['NOTE'] == ''){ echo "-"; }else{ echo"$rows[NOTE]"; } ?></span></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
</body>
</html>