<?php 
include "../connection/connDB.php";
include "../connection/function.php";
include "header.php";

$qccat = mysqli_query($connection,"select * from menu_category");
$qcitm = mysqli_query($connection,"select * from menu_item");

$qsale = "select 
	(select count(*) as total_dine_in
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where month(trs.TRANS_DATE) = '1' and year(trs.TRANS_DATE) = '2020' and tic.TICKET_TYPE = 'DINE IN' and tic.STATUS = 'COMPLETE'
	) as total_dine_in,
	
	(select count(*) as total_take_away
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where month(trs.TRANS_DATE) = '1' and year(trs.TRANS_DATE) = '2020' and tic.TICKET_TYPE = 'TAKE AWAY' and tic.STATUS = 'COMPLETE'
	) as total_take_away,
	
	(select count(*) as total_transaksi
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where month(trs.TRANS_DATE) = '1' and year(trs.TRANS_DATE) = '2020' and tic.STATUS = 'COMPLETE'
	) as total_transaksi,
	
	(select count(*) as total_transaksi_void
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where month(trs.TRANS_DATE) = '1' and year(trs.TRANS_DATE) = '2020' and tic.STATUS = 'VOID'
	) as total_transaksi_void,
	
	(select sum(tic.AMOUNT) as total_sales_void
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where month(trs.TRANS_DATE) = '1' and year(trs.TRANS_DATE) = '2020' and tic.STATUS = 'VOID'
	) as total_sales_void,
	
	(select sum(tic.AMOUNT) as sales_dine_in
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where month(trs.TRANS_DATE) = '1' and year(trs.TRANS_DATE) = '2020' and tic.TICKET_TYPE = 'DINE IN' and tic.STATUS = 'COMPLETE'
	) as sales_dine_in,
	
	(select sum(tic.AMOUNT) as sales_take_away
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where month(trs.TRANS_DATE) = '1' and year(trs.TRANS_DATE) = '2020' and tic.TICKET_TYPE = 'TAKE AWAY' and tic.STATUS = 'COMPLETE'
	) as sales_take_away,
	
	(select sum(tic.AMOUNT) as total_sales
	from th_ticket tic
	left join transaction trs on trs.ID_TRANSACTION = tic.ID_TRANSACTION
	where month(trs.TRANS_DATE) = '1' and year(trs.TRANS_DATE) = '2020' and tic.STATUS = 'COMPLETE'
	) as total_sales

	";

// print_r($qsale);
$tccat = mysqli_num_rows($qccat);
$tcitm = mysqli_num_rows($qcitm);
$qsale = mysqli_query($connection,$qsale);
$rwsale = mysqli_fetch_row($qsale);
?>

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
	<div id="content-header">
		<div id="breadcrumb"> <a href="./" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Dashboard</a></div>
	</div>
<!--End-breadcrumbs-->
<div class="container-fluid">
	<div class="row-fluid">
		<div class="widget-box widget-plain">
			<div class="center">
				<ul class="stat-boxes2">
				  <li>
				    <div class="left peity_bar_neutral"><span><span style="display: none;">2,4,9,7,12,10,12</span>
				      <canvas width="50" height="24"></canvas>
				      </span>Bulan Berjalan</div>
				    <div class="right"> <strong><?php echo $rwsale[0] ?></strong> Total Dine In </div>
				  </li>
				  <li>
				    <div class="left peity_line_neutral"><span><span style="display: none;">10,15,8,14,13,10,10,15</span>
				      <canvas width="50" height="24"></canvas>
				      </span>Bulan Berjalan</div>
				    <div class="right"> <strong><?php echo $rwsale[1] ?></strong> Total Take Away </div>
				  </li>
				  <li>
				    <div class="left peity_bar_bad"><span><span style="display: none;">3,5,6,16,8,10,6</span>
				      <canvas width="50" height="24"></canvas>
				      </span>Bulan Berjalan</div>
				    <div class="right"> <strong><?php echo $rwsale[2] ?></strong> Total Transaksi</div>
				  </li>
				  <li>
				    <div class="left peity_line_good"><span><span style="display: none;">12,6,9,23,14,10,17</span>
				      <canvas width="50" height="24"></canvas>
				      </span>Bulan Berjalan</div>
				    <div class="right"> <strong><?php echo $rwsale[3] ?></strong> Total Transaction Void </div>
				  </li>
				  <li>
				    <div class="left peity_bar_good"><span>12,6,9,23,14,10,13</span>Bulan Berjalan</div>
				    <div class="right"> <strong><?php if($rwsale[4]==''){ echo "0"; }else{ echo number_format($rwsale[4]); } ?></strong> Sales Sales Void </div>
				  </li>
				  <li>
				    <div class="left peity_bar_neutral"><span><span style="display: none;">2,4,9,7,12,10,12</span>
				      <canvas width="50" height="24"></canvas>
				      </span>Bulan Berjalan</div>
				    <div class="right"> <strong><?php echo number_format($rwsale[5]) ?></strong> Sales Dine In  </div>
				  </li>
				  <li>
				    <div class="left peity_line_neutral"><span><span style="display: none;">10,15,8,14,13,10,10,15</span>
				      <canvas width="50" height="24"></canvas>
				      </span>Bulan Berjalan</div>
				    <div class="right"> <strong><?php echo number_format($rwsale[6]) ?></strong> Sales Take Away </div>
				  </li>
				  <li>
				    <div class="left peity_bar_bad"><span><span style="display: none;">3,5,6,16,8,10,6</span>
				      <canvas width="50" height="24"></canvas>
				      </span>Bulan Berjalan</div>
				    <div class="right"> <strong><?php echo number_format($rwsale[7]) ?></strong> Total Sales </div>
				  </li>
				</ul>
			</div>
		</div>
	</div>
</div>
	    
	<div class="container-fluid">
	<!--Action boxes-->
	    <div class="quick-actions_homepage">
	      <ul class="quick-actions">
	        <li class="bg_lb"> <a href="ms_category.php"> <i class="icon-dashboard"></i> <span class="label label-important"><?php echo $tccat ?></span> Master Category </a> </li>
	        <li class="bg_lg"> <a href="ms_item.php"> <i class="icon-signal"></i><span class="label label-important"><?php echo $tcitm ?></span> Master Item</a> </li>
	      </ul>
	    </div>
	<!--End-Action boxes-->   
	</div>


</div>
<!--end-main-container-part-->
<?php include "footer.php"; ?>
<?php include "footer_script.php"; ?>