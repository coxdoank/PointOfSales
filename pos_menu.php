<?php
include "connection/connDB.php";
include "connection/function.php";

$mod	= $_GET['mod'] ? $_GET['mod'] : 'trans';
$act	= $_GET['act'];
$cat	= $_GET['cat'];
$id	 	= $_GET['id'] ? $_GET['id'] : 1;
$idm	= $_GET['idm'];

//list ticket item 
$query_titem = "select * from ticket_item";
$query_titem = mysql_query($query_titem);

if($act == 'del'){
	$table_name = "ticket_item";
	DeleteData($table_name, "WHERE ID_TICKET_ITEM = '$idm'");
	header("location:pos_menu.php");
}
?>
<link href="content/css/stylesheet.css" rel="stylesheet" type="text/css">
<style type="text/css">
body,td,th {
	font-family: MyriadPro-Regular;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>

<table width="100%" border="0" cellpadding="3" cellspacing="0" class="table-model-01">
  <tr class="text_content">
    <td class="label_header">Product</td>
    <td class="label_header">Qty</td>
    <td class="label_header">Total</td>
    <td align="center">&nbsp;</td>
  </tr>
  <?php while($rwitem = mysql_fetch_array($query_titem)){ ?>
  <tr class="text_content_02">
    <td><div class="label_header"><?php echo"$rwitem[ITEM_NAME]" ?></div>
      <div>Rp 
      <?php $item_price = number_format($rwitem['ITEM_PRICE']); echo "$item_price"; ?></div></td>
    <td class="label_header"><a href="<?php echo"pos_menu_qty.php?idm=$rwitem[ID_TICKET_ITEM]" ?>" class="pos-qty-box"><?php echo"$rwitem[ITEM_COUNT]" ?></a></td>
    <td class="label_header"><?php $total_price = number_format($rwitem['TOTAL_PRICE']); echo "$total_price"; ?></td>
    <td align="center"><a href="<?php echo"?act=del&id=$id&idm=$rwitem[ID_TICKET_ITEM]" ?>"><img src="content/images/btn-delete.png" width="20" height="20"  style="border:0;" /></a></td>
  </tr>
  <?php } ?>
</table>
