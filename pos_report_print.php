<?php 
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";

// $xtrans	= $_GET['xtrans'];
$xtrans	= isset($_GET['xtrans']) ? $_GET['xtrans'] : '';

// restaurant
$qres = "select * from restaurant";
$qres = mysqli_query($connection,$qres);
$rows = mysqli_fetch_array($qres);

//data ticket item 
// $qtrans = mysqli_query($connection,"select * from vw_ticket_trans where TERMINAL = '$terminal'");

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
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where trs.TERMINAL = '$terminal' and trs.TRANS_DATE = '$trans_date' and tic.STATUS = 'COMPLETE'
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "$terminal - Report $xtrans" ?></title>
<link rel="stylesheet" href="css/paper.css">
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
	font-size: 10pt;
	font-weight: bold;
}
.text_subheader {
	font-family: 'MyriadPro-Regular';
	text-decoration: none;
	font-size: 8pt;
	font-weight: bold;
}
.text_content {
	font-family: 'MyriadPro-Regular';
	text-decoration: none;
	font-size: 8pt;
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
	padding-top: 5px;
	padding-bottom: 5px;
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
        window.location.replace("pos_report.php?xtrans=<?php echo "$xtrans" ?>");
    }      
    setTimeout("pageRedirect()", 1000);
</script>
</head>

<body>
<div class="page">
  <table width="100%" align="center" cellpadding="1" cellspacing="0" class="table-model">
    <tr>
      <td align="center" class="label_dashboard_text"><span class="text_header"><?php if($rows['LOGO'] == "Y"){ echo "<img src='content/images/logo-odaba.png' width='150' height='150' />"; }else{ echo "$row[NAME]"; } ?></span></td>
    </tr>
    <tr>
      <td><table width="100%" cellpadding="1" cellspacing="0" class="table-model-01">
        <tr>
          <td><span class="text_content">Terminal</span></td>
          <td width="40%"><span class="text_content">: <?php echo "$terminal" ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content">Trans Date</span></td>
          <td><span class="text_content">: <?php echo "$trans_date" ?></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><span class="text_content">Total Dine In</span></td>
          <td><span class="text_content">: <?php echo "$row[total_dine_in]" ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content"> Total Take Away</span></td>
          <td><span class="text_content">: <?php echo "$row[total_take_away]" ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content">Total Transaksi</span></td>
          <td><span class="text_content">: <?php echo "$row[total_transaksi]" ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content">Total Transaksi Void</span></td>
          <td><span class="text_content">: <?php echo "$row[total_transaksi_void]" ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content">Total Sales Void</span></td>
          <td><span class="text_content">: <?php echo number_format($row['total_sales_void']) ?></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><span class="text_content"> Sales Dine In</span></td>
          <td><span class="text_content">: <?php echo number_format($row['sales_dine_in']) ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content"> Sales Take Away</span></td>
          <td><span class="text_content">: <?php echo number_format($row['sales_take_away']) ?></span></td>
        </tr>
        <tr>
          <td><span class="text_content">Total Sales</span></td>
          <td><span class="text_content">: <?php echo number_format($row['total_sales']) ?></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <?php if($xtrans == $BulanBerjalan){ echo ""; }else{ ?>
        <table width="100%" cellpadding="1" cellspacing="0" class="table-model-01">
          <tr>
            <td colspan="2" align="center"><span class="text_content">Total Sales By Cashier</span></td>
          </tr>
          <?php 
			$query01 = mysqli_query($connection,$query01);
			while($rows = mysqli_fetch_array($query01)){ ?>
          <tr>
            <td width="45%"><span class="text_content"><?php echo $rows['kasir']?></span></td>
            <td><span class="text_content">: <?php echo number_format($rows['total_sales'])?></span></td>
          </tr>
          <?php } ?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
      </table>
        <table width="100%" cellpadding="1" cellspacing="0" class="table-model-01">
          <tr>
            <td colspan="2" align="center"><span class="text_content">Total Item Sales By Category</span></td>
          </tr>
          <?php 
			$query02 = mysqli_query($connection,$query02);
			while($row02 = mysqli_fetch_array($query02)){ ?>
          <tr>
            <td width="45%"><span class="text_content"><?php echo $row02['CATEGORY_NAME']?></span></td>
            <td><span class="text_content">: <?php echo $row02['TOTAL_ITEM']?></span></td>
          </tr>
          <?php } ?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="100%" cellpadding="1" cellspacing="0" class="table-model-01">
          <tr>
            <td colspan="2" align="center"><span class="text_content">Total Item Sales By Menu</span></td>
          </tr>
          <?php 
			$query03 = mysqli_query($connection,$query03);
			while($row03 = mysqli_fetch_array($query03)){ ?>
          <tr>
            <td width="45%"><span class="text_content"><?php echo $row03['ITEM_NAME']?></span></td>
            <td><span class="text_content">: <?php echo $row03['TOTAL_ITEM']?></span></td>
          </tr>
          <?php } ?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      <?php } ?>
      </td>
    </tr>
  </table>
</div>
</body>
</html>