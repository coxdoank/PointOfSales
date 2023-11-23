<?php 
include "../connection/connDB.php";
include "../connection/function.php";

$act 	= isset($_GET['act']) ? $_GET['act'] : $_POS['act'];
$id 	= isset($_GET['id']) ? $_GET['id'] : $_POS['act'];

if(isset($_POST['btnsave'])){
		$name			= $_POST['name'];
		$addressline1	= $_POST['addressline1'];
		$telephone		= $_POST['telephone'];	
		$ticketfooter	= $_POST['ticketfooter'];
		$openingbalance	= $_POST['openingbalance'];

		$table_menu_01 = "restaurant";
		$form_data_01 = array(
					'NAME' => $name,
					'ADDRESS_LINE1' => $addressline1,
					'TELEPHONE' => $telephone,
					'TICKET_FOOTER' => $ticketfooter,
					'OPENING_BALANCE' => $openingbalance
					);

		UpdateData($table_menu_01, $form_data_01, "WHERE ID = '$id'");
		echo "<script>alert('Updated Berhasil');</script>";	
		// header("location:?act=edit&id=$id");		
}

if($act=='' or $id==''){
	header("location:./");

}elseif($act=='edit'){
	$qmsedt	= "select * from restaurant where ID = '$id'";
	$qmsedt = mysqli_query($connection,$qmsedt);
	$rwcatedt = mysqli_fetch_row($qmsedt);
}
?>
<?php include "header.php"; ?>

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
	<div id="content-header">
		<div id="breadcrumb"> <a href="." title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home </a>
		<a href="#" class="current">Pengaturan Aplikasi POS</a>
		</div>
	</div>
<!--End-breadcrumbs-->

<?php if($act=='insert' || $act=='edit'){ ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span11">
			  <div class="widget-box">
			    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			      <h5>Pengaturan Aplikasi POS</h5>
			    </div>
			    <div class="widget-content nopadding">
			      <form name="form" class="form-horizontal" method="post" enctype="multipart/form-data" role="form" action="">
			      	<br/>
			        <div class="control-group">
			          <label class="control-label">Nama Toko :</label>
			          <div class="controls">
			            <input name="name" type="text" class="span8" value="<?php echo $rwcatedt[2] ?>" required/>
			            <input type="hidden" name="id" value="<?php echo $rwcatedt[2] ?>">
			          </div>
			        </div>
			        <div class="control-group">
			          <label class="control-label">Alamat Toko :</label>
			          <div class="controls">
			              <textarea  name="addressline1" rows="2" class="span11" required><?php echo $rwcatedt[3] ?></textarea>
			          </div>
			        </div>
			        <div class="control-group">
			          <label class="control-label">Telephone :</label>
			          <div class="controls">
			            <input name="telephone" type="text" class="span3" placeholder="Sort Order" value="<?php echo $rwcatedt[7] ?>" required/>
			          </div>
			        </div>
			        <div class="control-group">
			          <label class="control-label">Footer Struk :</label>
			          <div class="controls">
			          	<input name="ticketfooter" type="text" class="span8" value="<?php echo $rwcatedt[12] ?>" required/>
			          </div>
			        </div>			        
			        <div class="control-group">
			          <label class="control-label">Default Modal Awal :</label>
			          <div class="controls">
			          	<input name="openingbalance" type="text" class="span8" value="<?php echo $rwcatedt[14] ?>" required/>
			          </div>
			        </div>			        
			        <div class="control-group">
			          <label class="control-label">Logo :</label>
			          <div class="controls">
			            <input name="sortorder" type="file" class="span11" placeholder="Sort Order" value="<?php echo $rwcatedt[16] ?>"/>
			          </div>
			        </div>

			        <div class="form-actions" align="right">
			        <button type="button" name="btncancel" class="btn btn-danger" onclick="window.location.href='mscategory'"><i class="icon-undo"></i> Batal</button>
			          <button type="Submit" name="btnsave" class="btn btn-success"><i class="icon-save"></i> Simpan</button>
			        
			        </div>
			      </form>
			    </div>
			  </div>
			</div>
		</div>	
	</div>
<?php }else{ ?>	

	<div class="container-fluid">
		
	</div>
<?php } ?>	

</div>
<!--end-main-container-part-->

<?php include "footer.php"; ?>

<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/matrix.tables.js"></script>

