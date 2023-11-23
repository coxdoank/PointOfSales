<?php 
include "../connection/connDB.php";
include "../connection/function.php";

$act 	= isset($_GET['act']) ? $_GET['act'] : '';
$id 	= isset($_GET['id']) ? $_GET['id'] : '';

if(isset($_POST['btnsave'])){
		$menuname	= $_POST['menuname'];
		$price		= digittodb($_POST['price']);
		$idcategory	= $_POST['idcategory'];	

		$table_menu_item = "menu_item";
		$form_data_category = array(
					'MENU_NAME' => $menuname,
					'PRICE' => $price,
					'ID_CATEGORY' => $idcategory
					);

	if($act=='insert'){
		InsertData($table_menu_item, $form_data_category);
		header("location:?page=msitem");

	}elseif($act=='edit'){
		UpdateData($table_menu_item, $form_data_category, "WHERE ID_MENU_ITEM = '$id'");	
		header("location:?page=msitem");		

	}
}

if($act=='edit'){
	$qmsedt	 = "select i.ID_MENU_ITEM,i.MENU_NAME,i.PRICE,c.CATEGORY_NAME,i.ID_CATEGORY ";
	$qmsedt	.= "from menu_item i ";
	$qmsedt	.= "left join menu_category c on c.ID_CATEGORY = i.ID_CATEGORY ";	
	$qmsedt	.= "where i.ID_MENU_ITEM = '$id'";	
	$qmsedt = mysqli_query($connection,$qmsedt);
	$rwcatedt = mysqli_fetch_row($qmsedt);
}elseif($act=='del'){
	$table_menu_item = "menu_item";		
	DeleteData($table_menu_item, " where ID_MENU_ITEM = '$id'");	
	header("location:?page=msitem");
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
			          <label class="control-label">Menu Name</label>
			          <div class="controls">
			            <input name="menuname" type="text" class="span11" placeholder="Menu Name" value="<?php echo isset($rwcatedt[1]) ? $rwcatedt[1] : ''; ?>" required/>
			            <input type="hidden" name="id" value="<?php echo isset($rwcatedt[0]) ? $rwcatedt[0] : ''; ?>">
			          </div>
			        </div>
			        <div class="control-group">
			          <label class="control-label">Price</label>
			          <div class="controls">
			            <input name="price" type="text" id="priceempty" class="span11" placeholder="Price" onkeyup="format(this)" onkeypress="return isNumberKey(event)" value="<?php echo isset($rwcatedt[2]) ? $rwcatedt[2] : ''; ?>" required/>
			            
			          </div>
			        </div>
			        <!-- <div class="control-group">
			          <label class="control-label">Category Name</label>
			          <div class="controls">
			            <input name="idcategory" type="text" class="span11" placeholder="Category Name" value="<?php echo isset($rwcatedt[3]) ? $rwcatedt[3] : ''; ?>" required/>
			            
			          </div>
			        </div> -->
			        <label class="control-label">Category Name</label>
					<div class="controls">
						<select name="idcategory">
							<?php 
							if($act=='insert'){
							$qmenucat = mysqli_query($connection,"select c.ID_CATEGORY, c.CATEGORY_NAME from menu_category c");
							while($rwctgr = mysqli_fetch_row($qmenucat)){
							echo "<option value='$rwctgr[0]'>$rwctgr[1]</option>";
								} 
							}elseif($act=='edit'){

							echo "<option value='$rwcatedt[4]'>$rwcatedt[3]</option>";
							$qmenucat = mysqli_query($connection,"select c.ID_CATEGORY, c.CATEGORY_NAME from menu_category c");
							while($rwctgr = mysqli_fetch_row($qmenucat)){
							echo "<option value='$rwctgr[0]'>$rwctgr[1]</option>";
								}
							}
							?>
						</select>
					</div>			        
			        <div class="form-actions">
			          <button type="Submit" name="btnsave" class="btn btn-success">Save</button>
			          <button type="button" name="btncancel" class="btn btn-inverse" onclick="window.location.href='?page=msitem'">Cancel</button>
			        </div>
			      </form>
			    </div>
			  </div>
			</div>
		</div>	
	</div>
<?php }else{ ?>	

	<div class="container-fluid">
		<div class="row-fluid"><button class="btn btn-sm btn-success" onclick="window.location.href='?page=msitem&amp;act=insert'"><i class="icon-plus"></i> Tambah Item</button></div>

        <div class="widget-box">
			<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
				<h5>Data Master Item</h5>
			</div>
			<div class="widget-content nopadding">
				<table class="table table-bordered data-table">
				  <thead>
				    <tr>
				      <th>Menu Name</th>
				      <th>Price</th>
				      <th>Category Name</th>
				      <th>Action</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
						<?php 
						$qmsitm	 = "select i.ID_MENU_ITEM,i.MENU_NAME,i.PRICE,c.CATEGORY_NAME,i.ID_CATEGORY ";
						$qmsitm	.= "from menu_item i ";
						$qmsitm	.= "left join menu_category c on c.ID_CATEGORY = i.ID_CATEGORY ";
						$qmsitm  = mysqli_query($connection,$qmsitm);
						while($rwmscat = mysqli_fetch_row($qmsitm)){ ?>
						<td><?php echo $rwmscat[1] ?></td>
						<td><?php echo number_format($rwmscat[2]) ?></td>
						<td><?php echo $rwmscat[3] ?></td>
						<td><a href="?page=msitem&amp;act=edit&amp;id=<?php echo $rwmscat[0] ?>" class="btn btn-mini btn-info">Edit</a> | <a href="?page=msitem&amp;act=del&amp;id=<?php echo $rwmscat[0] ?>" onClick="return confirm('Are you sure delete this data ?')" class="btn btn-mini btn-danger">Delete</a></td>
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

