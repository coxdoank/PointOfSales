<?php 
include "connection/connDB.php";
include "connection/function.php";

$mod	= $_GET['mod'] ? $_GET['mod'] : 'trans';
$act	= $_GET['act'];
$cat	= $_GET['cat'];
$id	 = $_GET['id'] ? $_GET['id'] : 1;
$idm	= $_GET['idm'];

//list category
$query_cat = "select * from menu_category";
$query_cat = mysql_query($query_cat);

//list menu
$query_mn = "select * from menu_item where ID_CATEGORY = '$id'";
$query_mn = mysql_query($query_mn);

//list ticket item 
$query_titem = "select * from ticket_item";
$query_titem = mysql_query($query_titem);

if($act == 'add'){
//cek tiket
$query02 = "select tkt.ID_TICKET from ticket tkt ";
$query02 = mysql_query($query02);
$rowt	 = mysql_fetch_array($query02);

	
//pengecekan data
$query01 = "select * from ticket_item ttm
left join menu_item mit on mit.ID_MENU_ITEM = ttm.ITEM_ID
where ttm.ITEM_ID = '$idm'";
$query01 = mysql_query($query01);
$data = mysql_num_rows($query01);

//jika data belum ada 
if($data == 0){
	$query = "select * from menu_item item
left join menu_category cat on cat.ID_CATEGORY = item.ID_CATEGORY
where item.ID_MENU_ITEM = '$idm'";

	$query = mysql_query($query);
	$row = mysql_fetch_array($query);
	$sub_total = 1 * $row['PRICE'];
	
	$table_name = "ticket_item";
	$form_data = array(
				'ITEM_ID' => $row['ID_MENU_ITEM'],
				'ITEM_COUNT' => 1,
				'ITEM_NAME' => $row['MENU_NAME'],
				'CATEGORY_NAME' => $row['CATEGORY_NAME'],
				'ITEM_PRICE' => $row['PRICE'],
				'DISCOUNT_RATE' => 0,
				'ITEM_TAX_RATE' => 0,
				'SUB_TOTAL' => $sub_total,
				'DISCOUNT' => 0,
				'TAX_AMOUNT' => 0,
				'TOTAL_PRICE' => $sub_total
				);
				
	InsertData($table_name, $form_data);
	header("location:?mod=$mod&id=$id");
	
//jika data sudah ada 
}elseif($data > 0){
	$query = "select * from ticket_item ttm
left join menu_item mit on mit.ID_MENU_ITEM = ttm.ITEM_ID
where ttm.ITEM_ID = '$idm'";

	$query = mysql_query($query);
	$row = mysql_fetch_array($query);
	$item_count = $row['ITEM_COUNT'] + 1;
	$sub_total = $row['ITEM_PRICE'] * $item_count;
	
	$table_name = "ticket_item";
	$form_data = array(
				'ITEM_COUNT' => $item_count,
				'SUB_TOTAL' => $sub_total,
				'TOTAL_PRICE' => $sub_total
				);
	UpdateData($table_name, $form_data, "WHERE ITEM_ID = '$idm'");
	header("location:?mod=$mod&id=$id");
}

	
}


if($act == 'del'){
	$table_name = "ticket_item";
	DeleteData($table_name, "WHERE ID_TICKET_ITEM = '$idm'");
	header("location:?mod=$mod&id=$id");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
.fullscreen {
	height: 100%;
	width: 100%;
	position: absolute;
	left: 0px;
	top: 0px;
}
.btn_action_01 {
	font-family: "Segoe UI";
	font-size: 12px;
	line-height: 35px;
	text-decoration: none;
	background-color: #FFF;
	height: 35px;
	width: 100px;
	border: 1px solid #CCC;
}
.btn_menu_01 {
	font-family: "Segoe UI";
	font-size: 26px;
	text-decoration: none;
	background-color: #00aedb;
	height: 220px;
	width: 220px;
	color: #FFF;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	font-weight: bold;
}
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(content/images/page-loader.gif) 50% 50% no-repeat rgb(249,249,249);
}
.text_content {	font-family: "Segoe UI", "Segoe UI Semibold";
	font-size: 18px;
	font-weight: bold;
}
.text_content_02 {	font-family: "Segoe UI", "Segoe UI Semibold";
	font-size: 11px;
	/* [disabled]letter-spacing: -1px; */
}
.menu_category {
	float: left;
	height: 40px;
	width: 150px;
	border: 1px solid #CCC;
	line-height: 40px;
	margin-right: 5px;
	background-color: #F6F6F6;
	text-decoration: none;
	color: #333;
	font-family: "Segoe UI";
	font-size: 14px;
	border-radius: 5px;
}
.menu_category:hover {
	background-color: #39F;
	color: #FFF;
}
.menu_item {
	float: left;
	height: 65px;
	width: 120px;
	border: 1px solid #CCC;
	line-height: 65px;
	margin-right: 5px;
	background-color: #F6F6F6;
	text-decoration: none;
	color: #333;
	font-family: "Segoe UI";
	font-size: 14px;
	text-align: center;
	border-radius: 5px;
	margin-bottom: 5px;
}
.menu_item:hover {
	background-color: #F60;
}
</style>

</head>
<body>
<div class="">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="height:100%;">
    <tr>
      <td width="35%" height="35" style="padding-left:5px;">&nbsp;</td>
      <td width="35%" align="center">&nbsp;</td>
      <td width="35%" align="right"><span class="text_content" style="padding-right:5px;"><span id="date_time"></span>
          <script type="text/javascript">window.onload = date_time('date_time');</script>
      </span></td>
    </tr>
    <tr>
      <td colspan="3" valign="top"><table style="width:100%; height:100%;">
        <tr style="width:35%; height:5%;">
          <td width="35%" height="5%"><?php echo "$note" ?></td>
          <td align="center">
		  <?php while($rwcat = mysql_fetch_array($query_cat)){ ?> <?php echo"<a href=\"?mod=trans&id=$rwcat[ID_CATEGORY]\" class=\"menu_category\">$rwcat[CATEGORY_NAME]</a> "; } ?></td>
        </tr>
        <tr style="width:70%; height:95%;">
          <td valign="top">
          
          <table width="100%" border="0" cellpadding="3" cellspacing="0">
            <tr class="text_content">
              <td>Item</td>
              <td>Jumlah</td>
              <td>Harga</td>
              <td>Total</td>
              <td>&nbsp;</td>
            </tr>
            <?php while($rwitem = mysql_fetch_array($query_titem)){ ?> 
            <tr class="text_content_02">
              <td><?php echo"$rwitem[ITEM_NAME]" ?></td>
              <td><?php echo"$rwitem[ITEM_COUNT]" ?></td>
              <td><?php echo"$rwitem[ITEM_PRICE]" ?></td>
              <td><?php echo"$rwitem[TOTAL_PRICE]" ?></td>
              <td><a href="<?php echo"?act=del&id=$id&idm=$rwitem[ID_TICKET_ITEM]" ?>" style="border:0;"><img src="content/images/btn-delete.png" width="20" height="20" /></a></td>
            </tr><?php } ?>
          </table></td>
          <td valign="top">
          <?php while($rwmn = mysql_fetch_array($query_mn)){ ?> <?php echo"<a href=\"?mod=trans&id=$id&act=add&idm=$rwmn[ID_MENU_ITEM]\" class=\"menu_item\">$rwmn[MENU_NAME]</a> "; } ?>
          </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="35" colspan="3" align="center"><span class="text_content_02">Copyright &copy;  Harry Handoko 2016</span></td>
    </tr>
  </table>
</div>
</body>
</html>