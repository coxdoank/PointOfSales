<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
.btn_settle {
	font-size: 33px;
	text-decoration: none;
	width: 2.2em;
	background-color: #50a8f2;
	border: 1px solid #ababab;
	color: #FFF;
	float: left;
	margin-right: 1%;
	height: 2.2em;
}
</style>
</head>

<body>
<div>
  <table width="600" align="center">
    <tr>
      <td width="350" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td colspan="2">&nbsp;</td>
          </tr>
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
      <td align="right" valign="top"><table width="82%" border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td width="80%" align="right"><input name="btn01" type="button" onclick="addCode('1');" class="btn_settle" id="1" value="1" /></td>
          <td width="80%" align="right"><input name="btn02" type="button" onclick="addCode('2');" class="btn_settle" id="btn02" value="2" /></td>
          <td width="80%" align="right"><input name="btn03" type="button" onclick="addCode('3');" class="btn_settle" id="btn03" value="3" /></td>
        </tr>
        <tr>
          <td align="right"><input name="btn04" type="button" onclick="addCode('4');" class="btn_settle" id="btn04" value="4" /></td>
          <td align="right"><input name="btn05" type="button" onclick="addCode('5');" class="btn_settle" id="btn05" value="5" /></td>
          <td align="right"><input name="btn06" type="button" onclick="addCode('6');" class="btn_settle" id="btn06" value="6" /></td>
        </tr>
        <tr>
          <td align="right"><input name="btn07" type="button" onclick="addCode('7');" class="btn_settle" id="btn07" value="7" /></td>
          <td align="right"><input name="btn08" type="button" onclick="addCode('8');" class="btn_settle" id="btn08" value="8" /></td>
          <td align="right"><input name="btn09" type="button" onclick="addCode('9');" class="btn_settle" id="btn09" value="9" /></td>
        </tr>
        <tr>
          <td align="right"><input name="btn_clear" type="reset"  class="btn_settle" id="btn_clear" value="Del" /></td>
          <td align="right"><input name="btn00" type="button" onclick="addCode('0');" class="btn_settle" id="btn00" value="0" /></td>
          <td align="right"><input name="submit" type="submit"  class="btn_settle" id="submit" value="Pay" /></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
</body>
</html>