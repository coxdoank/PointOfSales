<?php 
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";

$mod	= $_GET['mod'] ? $_GET['mod'] : 'trs';
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

if($act == 'add'){
//cek tiket
$query02 = "select tkt.ID_TICKET from ticket tkt ";
$query02 = mysql_query($query02);
$rowt	 = mysql_fetch_array($query02);

//pengecekan data ticket item
$query01 = "select * from ticket_item ttm
left join menu_item mit on mit.ID_MENU_ITEM = ttm.ITEM_ID
where TERMINAL = '$terminal' and ttm.ITEM_ID = '$idm'";
$query01 = mysql_query($query01);
$data = mysql_num_rows($query01);

//baca no id transaksi	
	$query_noid = "select * from transaction trs where 
						trs.TERMINAL = '$terminal' and
						trs.ID_USER = '$user_check' and
						trs.STATUS = 'OPEN'
						order by trs.ID_TRANSACTION desc limit 1";
	//print_r($query);					
	$query_noid = mysql_query($query_noid);
	$rowid = mysql_fetch_array($query_noid);
	$notrans = $rowid['ID_TRANSACTION'];

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
	header("location:?mod=$mod&id=$id");
	
//jika data sudah ada 
}elseif($data > 0){
	$query = "select * from ticket_item ttm
left join menu_item mit on mit.ID_MENU_ITEM = ttm.ITEM_ID
where TERMINAL = '$terminal' and ttm.ITEM_ID = '$idm'";

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
	UpdateData($table_name, $form_data, "WHERE ID_TICKET_ITEM = '$row[ID_TICKET_ITEM]' and TERMINAL = '$terminal' and ITEM_ID = '$idm'");
	header("location:?mod=$mod&id=$id");
}
}

//list ticket item 
$query_titem = "select * from ticket_item where TERMINAL = '$terminal' order by ID_TICKET_ITEM desc";
$query_titem = mysql_query($query_titem);

if($act == 'del'){
	$table_name = "ticket_item";
	DeleteData($table_name, " WHERE ID_TICKET_ITEM = '$idm'");
	header("location:?mod=$mod&id=$id");
}

if(isset($_POST['btn_cancel'])){
	$table_name = "transaction";		
	DeleteData($table_name, " where TERMINAL = '$terminal' and ID_USER = '$user_check' and STATUS = 'OPEN' order by ID_TRANSACTION desc limit 1");

	header("location:pos_ticket.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML s.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Point Of Sale System</title>
<style type="text/css">
	/* COMMON */
	@import url('../Mukti/content/css/font-face.css');
	
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
		background-image:url('../Mukti/content/images/toolbar_bg.png'); background-repeat:repeat-x;
		float:left;
	}
	.toolbarLeft{
		background-image:url('../Mukti/content/images/toolbar_left.png'); background-repeat:no-repeat;
		height:25px;
		width:7px;
		float:left;
	}
	.toolbarRight{
		background-image:url('../Mukti/content/images/toolbar_right.png'); background-repeat:no-repeat;
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
		background-image:url('../Mukti/content/images/nav_separator.png'); background-repeat:repeat-x; background-position:center;
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
		background-image:url('../Mukti/content/images/nav_link.png'); background-repeat:repeat-x;
		font-weight:bold;
		text-decoration:none;
		color:#000000;
	}
	.navSelect a:hover{
		background-image:url('../Mukti/content/images/nav_link_hover.png'); background-repeat:repeat-x;
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
</style>
<link href="content/css/stylesheet.css" rel="stylesheet" type="text/css" />
</head>

<body onresize="resizeWindow()" onload="resizeWindow()">
<div class="header">
  <div class="label_header"><strong><?php echo "$terminal"; ?></strong></div>
<img src="content/images/logo.png" width="125" height="25" /></div>
<div class="navigation" id="navigation">
	<div class="navigationPanel" id="navigationPanel">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="table-model-01">
    <tr class="text_content">
      <td class="label_header"><strong>Product</strong></td>
      <td class="label_header"><strong>Qty</strong></td>
      <td class="label_header"><strong>Total</strong></td>
      <td width="2%" align="center">&nbsp;</td>
    </tr>
    <?php while($rwitem = mysql_fetch_array($query_titem)){ ?>
    <tr class="text_content_02">
      <td><div class="label_header"><?php echo"$rwitem[ITEM_NAME]" ?></div>
        <div>Rp
          <?php $item_price = number_format($rwitem['ITEM_PRICE']); echo "$item_price"; ?>
        </div></td>
      <td class="label_header"><a href="<?php echo"pos_menu_qty.php?id=$id&idm=$rwitem[ID_TICKET_ITEM]" ?>" class="pos-qty-box"><?php echo"$rwitem[ITEM_COUNT]" ?></a></td>
      <td class="label_header">Rp <?php $total_price = number_format($rwitem['TOTAL_PRICE']); echo "$total_price"; ?></td>
      <td align="center"><a href="<?php echo"?act=del&id=$id&idm=$rwitem[ID_TICKET_ITEM]" ?>"><img src="content/images/btn-delete.png" width="35" height="35"  style="border:0;" /></a></td>
    </tr>
    <?php } ?>
  </table>
  </div>
  
  <div class="clear"></div>
  <div>
<form action="" method="post">
    <input name="btn_settle" type="submit" class="btn_settle" id="submit" value="Settle" />
    <input name="btn_cancel" type="submit" class="btn_close" id="submit" value="Cancel"/>
</form>    
  </div>
</div>
            <div class="content" id="content">
            <div class="contentPanel" id="contentPanel">
              <table width="100%">
                <tr>
                  <td width="10%" valign="top" class="label_header"><?php while($rwcat = mysql_fetch_array($query_cat)){ ?>
                  <?php echo"<a href=\"?mod=$trs&id=$rwcat[ID_CATEGORY]\" class=\"menu_category\">$rwcat[CATEGORY_NAME]</a> "; } ?></td>
                  <td width="80%" valign="top" ><?php while($rwmn = mysql_fetch_array($query_mn)){ ?>
                  <?php echo"<a href=\"?mod=$trs&id=$id&act=add&idm=$rwmn[ID_MENU_ITEM]\" class=\"menu_item\">$rwmn[MENU_NAME]</a> "; } ?></td>
                </tr>
              </table>
</div>
            <div class="clear"></div>

            
</body>

<script type="text/javascript">
            
        function resizeWindow() 
        {
            var windowHeight = getWindowHeight();

            document.getElementById("content").style.height = (windowHeight - 110) + "px";
            document.getElementById("contentPanel").style.height = (windowHeight - 160) + "px";
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
