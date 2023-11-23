<?php 
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";

$mod	= $_GET['mod'];
$act	= $_GET['act'];
$cat	= $_GET['cat'];
$id	 	= $_GET['id'] ? $_GET['id'] : 1;
$idm	= $_GET['idm'];

//list category
$query_cat = "select * from menu_category";
$query_cat = mysql_query($query_cat);

//list menu
$query_mn = "select * from menu_item where ID_CATEGORY = '$id'";
$query_mn = mysql_query($query_mn);

//baca no urut transaksi	
$query_noid = mysql_query("select count(*) as NOU_ID from transaction trs where 
			trs.TERMINAL = '$terminal'");
$rowid = mysql_fetch_array($query_noid);
$notrans = $rowid['NOU_ID'];
	
//display harga
$q_display = "select 
sum(ttm.SUB_TOTAL) as SUBTOTAL, 
sum(ttm.DISCOUNT) as DISCOUNT, 
sum(ttm.TAX_AMOUNT) as TAX, 
sum(ttm.TOTAL_PRICE) as AMOUNT 
from ticket_item ttm
where 
ttm.NO_TRANSACTION = '$notrans' and 
ttm.TERMINAL = '$terminal'";
//print_r($q_display);
$q_display = mysql_query($q_display);
$rwdisp = mysql_fetch_array($q_display);

//display list item menu transaksi
$query_titem = "select * from ticket_item ttm where 
				ttm.TERMINAL = '$terminal' and 
				ttm.NO_TRANSACTION = '$notrans' 
				order by ttm.ID desc";
//print_r($query_titem);
$query_titem = mysql_query($query_titem);
$count = mysql_num_rows($query_titem); // hitung list item transaksi

//pengecekan data ticket item
$query01 = "select ttm.ITEM_COUNT from ticket_item ttm
			left join menu_item mit on mit.ID_MENU_ITEM = ttm.ITEM_ID
			where 
			ttm.TERMINAL = '$terminal' and 
			ttm.NO_TRANSACTION = '$notrans' and 
			ttm.ITEM_ID = '$idm' ";
$query01 = mysql_query($query01);
$data = mysql_fetch_array($query01);

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
		width:44%;
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
		width:54%;
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
	font-size: 36px;
	text-decoration: none;
	width: 32%;
	background-color: #50a8f2;
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
.btn_option {
	font-size: 36px;
	text-decoration: none;
	width: 100%;
	background-color: #FFFFFF;
	border: 1px solid #ababab;
	color: #333;
	height: 97px;
	float: left;
}
.btn_option:hover {
	color: #FFF;
	background-color: #090;
}
</style>
<link href="content/css/stylesheet.css" rel="stylesheet" type="text/css" />
<script src="content/js/jquery.min.js"></script>
</head>

<body onresize="resizeWindow()" onload="resizeWindow()">
<script type="text/javascript">
function addCode(key){
	var code = document.forms[0].code;
		code.value = code.value + key;
}


function submitForm(){
	document.forms[0].submit();
}

function emptyCode(){
	document.forms[0].code.value = "";
}

function closeWin() {
             var win = window.open('', '_self');
             window.close();
             win.close(); return false;
} 
function date_time(id)
{
        date = new Date;
        year = date.getFullYear();
        month = date.getMonth();
        months = new Array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        d = date.getDate();
        day = date.getDay();
        days = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        result = ''+days[day]+', '+d+' '+months[month]+' '+year+', '+h+':'+m+':'+s;
        document.getElementById(id).innerHTML = result;
        setTimeout('date_time("'+id+'");','1000');
        return true;
}
</script>


<div class="header">
  <div class="label_header"><strong><?php echo "$terminal"; ?></strong></div>
<img src="content/images/logo-01.png" width="125" height="25" /></div>
<div class="navigation" id="navigation">
	<div class="navigationPanel" id="navigationPanel">
    <div class="pos-display">
      <div class="pos-display-order" align="center"><span class="pos-display-text02">
        ORDER LIST</span></div>
    </div>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="table-model-01">
    <tr class="text_content">
      <td class="label_header"><strong>Product</strong></td>
      <td class="label_header"><strong>Qty</strong></td>
      <td class="label_header"><strong>Total</strong></td>
    </tr>
    
    <!-- list item menu transaksi -->
    <?php while($rwitem = mysql_fetch_array($query_titem)){ ?>
    <tr class="text_content_02">
      <td><div class="label_header"><?php echo"$rwitem[ITEM_NAME]" ?></div></td>
      <td class="label_header"><?php echo"$rwitem[ITEM_COUNT]" ?></td>
      <td class="label_header">Rp <?php $total_price = number_format($rwitem['TOTAL_PRICE']); echo "$total_price"; ?></td>
    </tr>
    <?php } ?>
  </table>
  </div>
  
  <div class="clear"></div>
  <div></div>
</div>
    
            <div class="content" id="content">
            <div class="contentPanel" id="contentPanel">
            <form id="login" method="post" action="">
              <table width="100%" border="0" cellpadding="3" cellspacing="0">
                <tr>
                  <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0">
                    <tr>
                      <td><span class="label_dashboard">Total</span></td>
                      <td align="right"><span class="label_dashboard">
                        <input name="textfield" type="text" class="input_underline" id="textfield" value="<?php echo "$rwdisp[AMOUNT]" ?>" />
                      </span></td>
                    </tr>
                    <tr>
                      <td><span class="label_dashboard">Charged</span></td>
                      <td align="right"><span class="label_dashboard">
                        <input name="code" type="text" class="input_underline" value="" />
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0">
                    <tr>
                      <td width="80%" align="center"><input name="btn01" type="button" onclick="addCode('1');" class="btn_settle" id="1" value="1" />
                      <input name="btn02" type="button" onclick="addCode('2');" class="btn_settle" id="btn02" value="2" />
                      <input name="btn03" type="button" onclick="addCode('3');" class="btn_settle" id="btn03" value="3" /></td>
                    </tr>
                    <tr>
                      <td align="center"><input name="btn04" type="button" onclick="addCode('4');" class="btn_settle" id="btn04" value="4" />
                      <input name="btn05" type="button" onclick="addCode('5');" class="btn_settle" id="btn05" value="5" />
                      <input name="btn06" type="button" onclick="addCode('6');" class="btn_settle" id="btn06" value="6" /></td>
                    </tr>
                    <tr>
                      <td align="center"><input name="btn07" type="button" onclick="addCode('7');" class="btn_settle" id="btn07" value="7" />
                      <input name="btn08" type="button" onclick="addCode('8');" class="btn_settle" id="btn08" value="8" />
                      <input name="btn09" type="button" onclick="addCode('9');" class="btn_settle" id="btn09" value="9" /></td>
                    </tr>
                    <tr>
                      <td align="center"><input name="btn_clear" type="reset"  class="btn_settle" id="btn_clear" value="*" />
                      <input name="btn00" type="button" onclick="addCode('0');" class="btn_settle" id="btn00" value="0" />
                      <input name="submit" type="submit"  class="btn_settle" id="submit" value="Pay" />	</td>
                    </tr>
                    <tr>
                      <td align="center">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table>
              </form>
</div>
            <div class="clear"></div>

            
</body>

<script type="text/javascript">
            
        function resizeWindow() 
        {
            var windowHeight = getWindowHeight();

            document.getElementById("content").style.height = (windowHeight - 60) + "px";
            document.getElementById("contentPanel").style.height = (windowHeight - 60) + "px";
            document.getElementById("navigation").style.height = (windowHeight - 60) + "px";
			document.getElementById("navigationPanel").style.height = (windowHeight - 60) + "px";
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
