<?php 
include "../connection/connDB.php";
include "../connection/function.php";

$act 	= isset($_GET['act']) ? $_GET['act'] : '';
$id 	= isset($_GET['id']) ? $_GET['id'] : '';

if(isset($_POST['btnsave'])){
		$categoryname	= $_POST['categoryname'];
		$visible		= $_POST['visible'];
		$sortorder		= $_POST['sortorder'];	

		$table_menu_category = "menu_category";
		$form_data_category = array(
					'CATEGORY_NAME' => $categoryname,
					'VISIBLE' => $visible,
					'SORT_ORDER' => $sortorder
					);

	if($act=='insert'){
		InsertData($table_menu_category, $form_data_category);
		header("location:?page=mscategory");

	}elseif($act=='edit'){
		UpdateData($table_menu_category, $form_data_category, "WHERE ID_CATEGORY = '$id'");	
		header("location:?page=mscategory");		

	}
}

if($act=='edit'){
	$qmsedt	= "select * from menu_category where ID_CATEGORY = '$id'";
	$qmsedt = mysqli_query($connection,$qmsedt);
	$rwcatedt = mysqli_fetch_row($qmsedt);
}elseif($act=='del'){
	$table_menu_category = "menu_category";		
	DeleteData($table_menu_category, " where ID_CATEGORY = '$id'");	
	header("location:?page=mscategory");
}
?>
<?php include "header.php"; ?>

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
	<div id="content-header">
		<div id="breadcrumb"> <a href="." title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home </a></div>
	</div>
<!--End-breadcrumbs-->

<?php if($act=='insert' || $act=='edit'){ ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span6">
			  <div class="widget-box">
			    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			      <h5>Menu Category</h5>
			    </div>
			    <div class="widget-content nopadding">
			      <form name="form" class="form-horizontal" method="post" enctype="multipart/form-data" role="form" action="">
			        <div class="control-group">
			          <label class="control-label">Category Menu</label>
			          <div class="controls">
			            <input name="categoryname" type="text" class="span11" placeholder="Category Menu" value="<?php echo isset($rwcatedt[1]) ? $rwcatedt[1] : ''; ?>" required/>
			            <input type="hidden" name="id" value="<?php echo isset($rwcatedt[0]) ? $rwcatedt[0] : ''; ?>"><?php echo isset($validasierror) ? $validasierror : ''; ?>
			          </div>
			        </div>
			        <div class="control-group">
			          <label class="control-label">Visible</label>
			          <div class="controls">
			            <input name="visible" type="text"  class="span11" placeholder="Visible"  value="<?php echo isset($rwcatedt[3]) ? $rwcatedt[3] : ''; ?>" required/>
			            <?php echo isset($validasierror) ? $validasierror : ''; ?>
			          </div>
			        </div>
			        <div class="control-group">
			          <label class="control-label">Sort Order</label>
			          <div class="controls">
			            <input name="sortorder" type="text" class="span11" placeholder="Sort Order" value="<?php echo isset($rwcatedt[4]) ? $rwcatedt[4] : ''; ?>" required/>
			            <?php echo isset($validasierror) ? $validasierror : ''; ?>
			          </div>
			        </div>
			        <div class="form-actions">
			          <button type="Submit" name="btnsave" class="btn btn-success">Save</button>
			          <button type="button" name="btncancel" class="btn btn-inverse" onclick="window.location.href='?page=mscategory'">Cancel</button>
			        </div>
			      </form>
			    </div>
			  </div>
			</div>
		</div>	
	</div>
<?php }else{ ?>	

	<div class="container-fluid">
		<div class="row-fluid"><button class="btn btn-sm btn-success" onclick="window.location.href='?page=mscategory&amp;act=insert'"><i class="icon-plus"></i> Tambah Category</button></div>

        <div class="widget-box">
			<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
				<h5>Data Master Category</h5>
			</div>
			<div class="widget-content nopadding">
				<table class="table table-bordered data-table">
				  <thead>
				    <tr>
				      <th>Category</th>
				      <th>Visible</th>
				      <th>Sort Order</th>
				      <th>Action</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
						<?php 
						$qmscat = mysqli_query($connection,"select * from menu_category");
						while($rwmscat = mysqli_fetch_row($qmscat)){ ?>
						<td><?php echo $rwmscat[1] ?></td>
						<td><?php echo $rwmscat[3] ?></td>
						<td><?php echo $rwmscat[4] ?></td>
						<td><a href="?page=mscategory&amp;act=edit&amp;id=<?php echo $rwmscat[0] ?>" class="btn btn-mini btn-info">Edit</a> | <a href="?page=mscategory&amp;act=del&amp;id=<?php echo $rwmscat[0] ?>" onClick="return confirm('Are you sure delete this data ?')" class="btn btn-mini btn-danger">Delete</a></td>
				    </tr>
				    <?php } ?>
				  </tbody>
				</table>
			</div>
        </div>	
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

