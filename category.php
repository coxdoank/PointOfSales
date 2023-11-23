<?php 
include "connection/connDB.php";
include "connection/function.php";

$txtcari = isset($_POST['txtcari']) ? $_POST['txtcari'] : $_GET['txtcari']; 
$dataPerPage = 20;

//Paging
if(isset($_GET['page']))
{
    $noPage = $_GET['page'];
} 
else $noPage = 1;
$offset = ($noPage - 1) * $dataPerPage; 

//Query
$query 	 = "select * from categories cat ";

if($_POST['btnsearch'] || $_POST['txtcari']){
$query 	   .= " where cat.cat_name like '%$txtcari%'";
		
}elseif($txtcari){
$query 		.= " where cat.cat_name like '%$txtcari%'";
}else{
$query 		.= " ";
}

//Halaman sesuai Offset
$query .= " limit $offset,$dataPerPage";

//print_r($query);
$query   = mysql_query($query);
$jumData = mysql_num_rows($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body {
	font-family: "Segoe UI", "Segoe UI Semibold";
}
</style>
<link href="content/css/stylesheet.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
  <div class="label_header">List Categories</div>
  <div class="clear"></div>
  <div align="right">
    <table width="100%">
      <tr>
        <td width="70%" align="left"> Search Categories :
          <input name="txtcari" type="text" class="input medium" id="txtcari" />
          <input name="btnsearch" type="submit" class="input" id="btnsearch" value="Search" /></td>
        <td align="right"><input name="btnadd" type="button" class="input" id="button2" value="Add Customer" onclick="window.location.href=('category_insert.php?act=add')" /></td>
      </tr>
    </table>
  </div>
  <div class="clear"></div>
  <div>
    <table width="100%" cellpadding="0" class="table-model-01">
      <tr>
        <th>ID</th>
        <th>Categories</th>
        <th>Description</th>
        <th colspan="2" align="center">Action</th>
      </tr>
      <?php while($row = mysql_fetch_row($query)){	?>
      <tr>
        <td align="center"><?php echo $row[0] ?></td>
        <td><?php echo $row[1] ?></td>
        <td><?php echo $row[2] ?></td>
        <td width="35" align="center"><a href="<?php echo"category_insert.php?id=$row[0]&amp;act=edit" ?>" class="label_action">Edit</a></td>
        <td width="35" align="center"><a href="#" class="label_action"  onclick="return confirm('Anda yakin menghapus data ini ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <div class="clear"></div>
  <div>
    <?php
// menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
$jumPage = ceil($jumData/$dataPerPage);

// menampilkan link previous
if ($noPage > 1) echo  "<a href='".$_SERVER['PHP_SELF']."?txtcari=$txtcari&amp;page=".($noPage-1)."'  class='table_paging'>&lt;&lt; Prev</a>";

// memunculkan nomor halaman dan linknya
$showPage = isset($showPage) ? $showPage : '';
for($page = 1; $page <= $jumPage; $page++)
{
         if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)) 
         {   
            if (($showPage == 1) && ($page != 2))  echo "..."; 
            if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "...";
            if ($page == $noPage) echo " <b><span class='table_pagingselect'>".$page."</span></b> ";
            else echo " <a href='".$_SERVER['PHP_SELF']."?txtcari=$txtcari&amp;page=".$page."' class='table_paging'>".$page."</a> ";
            $showPage = $page;          
         }
}

// menampilkan link next
if ($noPage < $jumPage) echo "<a href='".$_SERVER['PHP_SELF']."?txtcari=$txtcari&amp;page=".($noPage+1)."'  class='table_paging'>Next &gt;&gt;</a>";

?>
  </div>
</form>
</body>
</html>