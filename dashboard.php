<?php
include "connection/connDB.php";
include "login_session.php";

//hak akses
$qakses = $connection -> query("select * from user usr
left join user_type ust on ust.ID = usr.USER_TYPE_ID
where usr.USER_ID = '$user_check'");
$rwakses = $qakses -> fetch_array();
if($rwakses['USER_TYPE'] == 'CASHIER'){
	$page_work_periods = "";
	}else{
	$page_work_periods = "onclick=\"window.location.href=('work_periods.php')\"";
}

//informasi top header user
$q_usr = $connection -> query("select * from user where USER_ID = '$user_check'");
$r_usr = $q_usr -> fetch_array();
$usr_login = "$r_usr[FIRST_NAME] $r_usr[LAST_NAME]";

//check work period jika sudah create modal. bisa open transaksi POS
$qwork = $connection -> query("select * from transaction trs where trs.TERMINAL = '$terminal' and trs.FLAG = 'N' order by trs.ID desc limit 1");
$count = mysqli_num_rows($qwork);
if($count == 0){
	$page_pos_ticket = "";
	}else{
	$page_pos_ticket = "onclick=\"window.location.href=('pos_ticket.php')\"";
}

if($count == 0 || $rwakses['USER_TYPE'] == 'CASHIER'){
	$page_cash_in_out = "";
	}else{
	$page_cash_in_out = "onclick=\"window.location.href=('cash_in_out.php')\"";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Point Of Sales System</title>
<style type="text/css">
.fullscreen {
	height: 100%;
	width: 100%;
	position: absolute;
	left: 0px;
	top: 0px;
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
.btn_action_01 {
	font-size: 12px;
	line-height: 35px;
	text-decoration: none;
	background-color: #FFF;
	height: 35px;
	width: 100px;
	border: 1px solid #CCC;
}
.btn_menu_01 {
	font-size: 18pt;
	text-decoration: none;
	background-color: #3498db;
	height: 160pt;
	width: 160pt;
	color: #FFF;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	font-weight: bold;
}
.btn_menu_01:hover {
	text-decoration: none;
	background-color: #FFCC00;
	color: #333;
}

.text_content {	
	font-size: 18px;
	font-weight: bold;
}
.text_content_02 {
	font-size: 11px;
	/* [disabled]letter-spacing: -1px; */
}
</style>
<link href="content/css/stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
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
</head>
<body>
<div class="fullscreen">
  <table width="100%" height="100%">
    <tr>
      <td width="33%" height="35" style="padding-left:5px;"><img src="content/images/logo-01.png" width="125" height="25" /></td>
      <td width="33%" align="center" class="text_content">Selamat Datang, <?php echo "$usr_login"; ?> | <?php echo"$terminal" ?></td>
      <td width="33%" align="right"><span class="text_content" style="padding-right:5px;"><span id="date_time"></span>
          <script type="text/javascript">window.onload = date_time('date_time');</script>
      </span></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><table cellspacing="10">
        <tr>
          <td align="right"><input name="button" type="button" class="btn_menu_01" id="button" value="Work Periods" <?php echo "$page_work_periods" ?> /></td>
          <td align="center"><input name="button2" type="button" class="btn_menu_01" id="button2" value="POS" <?php echo "$page_pos_ticket" ?> /></td>
          <td><input name="button3" type="button" class="btn_menu_01" id="button3" value="Tickets" onclick="window.location.href=('ticket.php')" /></td>
          <td><input name="button4" type="button" class="btn_menu_01" id="button4" value="Cash In / Out" <?php echo "$page_cash_in_out" ?> /></td>
        </tr>
        <tr>
          <td align="right"><input name="button5" type="button" class="btn_menu_01" id="button5" value="Manage User" onclick="window.location.href=('manage_user.php')"/></td>
          <td align="center"><input name="button6" type="button" class="btn_menu_01" id="button6" value="Transfer Data" onclick="window.location.href=('transfer_data.php')" /></td>
          <td><input name="button7" type="button" class="btn_menu_01" id="button7" value="Report" onclick="window.location.href=('pos_report.php')"/></td>
          <td><input name="button8" type="button" onclick="window.location.href=('logout.php')" class="btn_menu_01" id="button8" value="Logout" /></td>
        </tr>
    </table></td>
    </tr>
    <tr>
      <td height="20" colspan="3" align="center" class="label_header">&nbsp;</td>
    </tr>
  </table>
</div>
</body>
</html>