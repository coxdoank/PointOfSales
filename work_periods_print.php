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
$qres = $connection -> query($qres);
$row = $qres -> fetch_array();

//cel id transaksi 
$query = $connection -> query("select 
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
$rows = $query -> fetch_array();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "$terminal - Modal Awal #$id" ?></title>
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
          <td><span class="text_content"> Balance</span></td>
          <td align="center"><span class="text_content">:</span></td>
          <td>            <span class="text_content">
            <?php $modal = number_format($rows['OPENING_BALANCE']); echo"$row[CSYMBOL] $modal"; ?>          
            </span></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
</body>
</html>