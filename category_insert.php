<?php
include "connection/connDB.php"; 

//aksi
$act 		= $_GET['act'];
$mod		= "categories";
$id			= $_GET['id'];

if($act=='add'){
	$act='add';
	$label='Input Categories';
}elseif(isset($act)){
	$act='edit';
	$label ='Edit Categories';
	$query = mysql_query("select * from categories where cat_id='$id'");
	$row   = mysql_fetch_array($query);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<title><?php echo"$title[0]" ?></title>
<link rel="shortcut icon" href="content/img/favicon.ico" type="image/x-icon">
<link href="content/css/stylesheet.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="wrapper">
  <div class="container">
<div class="label_header"><?php echo "$label"; ?></div>
<div class="clear"></div>
<!-- START CONTENT -->
<div>
  <form id="form1" name="form1" method="post" action="<?php echo"connection/process.php?mod=$mod&amp;act=$act" ?>">
    <table width="100%" border="0" cellpadding="2">
      <tr>
        <td width="150" class="TextMainLink02">Categories</td>
        <td width="10" class="TextMainLink02">:</td>
        <td><span class="TextMainLink02">
          <input name="cat_name" type="text" placeholder="Categories" class="input large" id="cat_name" value="<?php echo"$row[cat_name]" ?>" tabindex="1"/>
          <input name="id" type="hidden" id="id" value="<?php echo"$id" ?>" />
          <input name="act" type="hidden" id="act" value="<?php echo"$act" ?>" />
        </span></td>
      </tr>
      <tr>
        <td class="TextMainLink02">Description</td>
        <td class="TextMainLink02">:</td>
        <td class="TextMainLink02"><input name="cat_description" type="text" placeholder="Description" class="input large" id="cat_description" tabindex="2" value="<?php echo"$row[cat_description]" ?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="TextMainLink02"><input name="Submit" type="submit" class="input" value="SAVE" tabindex="3"/>
          <input name="Submit2" type="button" class="input" value="CANCEL" onclick="window.location.href=('category.php')" tabindex="4" /></td>
      </tr>
    </table>
  </form>
</div>
<!-- END CONTENT -->

  </div>
</div>
</body>
</html>