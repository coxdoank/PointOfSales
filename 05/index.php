<?php
//GET URL LINK
$xurl = substr(GETCWD(), -2, 2);

include "../connection/connDB.php";
include "../login.php"; // Includes Login Script

$sql = "select * from terminal where URL = '$xurl'";
$result = $connection -> query($sql);
$rowtm = $result -> fetch_array(MYSQLI_ASSOC);

// $query_terminal = mysql_query("select * from terminal where URL = '$xurl'");
// $rowtm = mysql_fetch_array($query_terminal);
$pos = $rowtm['TERMINAL'];

if(isset($_SESSION['login_user'])){
header("location: ../dashboard.php");
}

if(isset($_POST['btnexit'])){
  exec("closeBrowser.bat");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Point Of Sales</title>
<style type="text/css">
.btn_login {
	font-size: 36px;
	text-decoration: none;
	height: 85px;
	width: 85px;
	background-color: #FFF;
	border: 1px solid #d8d8d8;
}
.btn_login:hover {
	background-color: #FFCC00;
}
.btn_login_long {

	font-size: 36px;
	text-decoration: none;
	height: 75px;
	width: 151px;
	border: 1px solid #CCC;
	background-color: #FFF;
}
.field_login {
	height: 38px;
	width: 265px;
	line-height: 35px;
	font-size: 24px;
	text-align: center;
	background-color: #FFF;
}
.space {
	height: 100px;
}
.text_content {
	font-size: 18px;
	font-weight: bold;
	color: #FFF;
}
.text_content_01 {
	font-size: 32px;
	letter-spacing: -1px;
	font-weight: bold;
	color: #FFF;
}
.text_content_02 {

	font-size: 11px;
	/* [disabled]letter-spacing: -1px; */
}
.text_startmenu {

	font-size: 20px;
	font-weight: bold;
	color: #FC0;
}
.btn_submit {
	height: 50px;
	width: 230px;
	font-size: 16px;
}
.fullscreen {
	height: 100%;
	width: 100%;
	position: absolute;
	left: 0px;
	top: 0px;
}
body {
	background-color: #50a8f2;
}
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('../content/images/page-loader.gif') 50% 50% no-repeat rgb(249,249,249);
}
</style>
<link href="../content/css/stylesheet.css" rel="stylesheet" type="text/css" />
<script src="../content/js/jquery.min.js"></script>
<script type="text/javascript">
$(window).load(function() {
	$(".loader").fadeOut("slow");
})
</script>
</head>

<body onload="emptyCode();">

<script type="text/javascript">
function addCode(key){
	var code = document.forms[0].code;
	if(code.value.length < 6){
		code.value = code.value + key;
	}
	if(code.value.length == 6){
		setTimeout(submitForm,1000);	
	}
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
<div class="loader"></div>
<div class="fullscreen">
  <table width="100%" border="0" style="height:100%;">
    <tr>
      <td width="60%" height="35" style="padding-left:5px;"><img src="../content/images/logo-02.png" width="125" height="25" /></td>
      <td align="right" class="text_content" style="padding-right:5px;"><span id="date_time"></span>
      <script type="text/javascript">window.onload = date_time('date_time');</script></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="text_content_01">&nbsp;</td>
      <td align="center" valign="middle"><form id="login" method="post" action="">
        <table width="180">
          <tr>
            <td colspan="3" align="center"><span class="text_content_01"><?php echo $error ? $error : $pos; ?></span></td>
          </tr>
          <tr>
            <td colspan="3" align="center"><input type="password" name="code" value="" maxlength="4" class="field_login" readonly="readonly" placeholder="Enter Pin" /></td>
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
            <td align="center"><input name="btn_clear" type="reset" class="btn_login" id="btn_clear" value="*" /></td>
            <td align="center"><input name="btn00" type="button" onclick="addCode('0');"class="btn_login" id="btn00" value="0" /></td>
            <td align="center"><input name="submit" type="submit" class="btn_login" id="submit" value="&gt;" /></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center"><input name="btnexit" type="submit" class="btn_login" id="btn_exit" value="Exit" /></td>
            <td align="center">&nbsp;</td>
          </tr>
          </table>
      </form></td>
    </tr>
  </table>
</div>
</body>
</html>