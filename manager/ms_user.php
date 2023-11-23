<?php 
include "../connection/connDB.php";
include "../connection/function.php";

$act 	= isset($_GET['act']) ? $_GET['act'] : '';
$id 	= isset($_GET['id']) ? $_GET['id'] : '';

if(isset($_POST['btnsave'])){
		$userid	= $_POST['userid'];
		$userpass	= $_POST['userpass'];
		$firstname		= $_POST['firstname'];
		$lastname		= $_POST['lastname'];	
		$usertypeid		= $_POST['usertypeid'];	

		$table_menu = "user";
		$form_data = array(
					'USER_ID' => $userid,
					'USER_PASS' => $userpass,
					'FIRST_NAME' => $firstname,
					'LAST_NAME' => $lastname,
					'USER_TYPE_ID' => $usertypeid
					);

	if($act=='insert'){
		$cekcode = mysqli_query($connection,"select * from user where USER_PASS = '$userpass'");
		$cekcode = mysqli_num_rows($cekcode);

		if($cekcode>0){
			echo "<script>alert('Passcode sudah digunakan, silahkan menggunakan passcode lain');window.history.back(-1)</script>";
		}else{
		InsertData($table_menu, $form_data);
		header("location:?page=msuser");
		}

	}elseif($act=='edit'){
		UpdateData($table_menu, $form_data, "WHERE ID_USER = '$id'");	
		header("location:?page=msuser");		

	}
}

if($act=='edit'){
	$qmsedt	= "select * from user u left join user_type t on t.ID = u.USER_TYPE_ID where ID_USER = '$id'";
	$qmsedt = mysqli_query($connection,$qmsedt);
	$rwcatedt = mysqli_fetch_row($qmsedt);
}elseif($act=='del'){
	$table_menu = "user";		
	DeleteData($table_menu, " where ID_USER = '$id'");	
	header("location:?page=msuser");
}
?>
<?php include "header.php"; ?>

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
	<div id="content-header">
		<div id="breadcrumb"> <a href="." title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home </a>
		<a href="#" class="current">Pengaturan Pengguna</a>
		</div>
	</div>
<!--End-breadcrumbs-->

<?php if($act=='insert' || $act=='edit'){ ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span6">
			  <div class="widget-box">
			    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
			      <h5>DATA PENGGUNA</h5>
			    </div>
			    <div class="widget-content nopadding">
			      <form name="form" class="form-horizontal" method="post" enctype="multipart/form-data" role="form" action="">
			      	<div class="control-group">
			          <label class="control-label">User ID</label>
			          <div class="controls">
			            <input name="userid" type="text" onkeypress="return isNumberKey(event)" maxlength="6" class="span11" placeholder="User ID" value="<?php echo isset($rwcatedt[1]) ? $rwcatedt[1] : ''; ?>" required/>
			            <input type="hidden" name="id" value="<?php echo isset($rwcatedt[0]) ? $rwcatedt[0] : ''; ?>">
			          </div>
			        </div>
			        <div class="control-group">
			          <label class="control-label">User Passcode</label>
			          <div class="controls">
			            <input name="userpass" type="text" onkeypress="return isNumberKey(event)" maxlength="6" class="span11" placeholder="User Passcode" value="<?php echo isset($rwcatedt[2]) ? $rwcatedt[2] : ''; ?>" required/>
			          </div>
			        </div>
			        <div class="control-group">
			          <label class="control-label">First Name</label>
			          <div class="controls">
			            <input name="firstname" type="text"  class="span11" placeholder="First Name"  value="<?php echo isset($rwcatedt[3]) ? $rwcatedt[3] : ''; ?>" required/>
			          </div>
			        </div>
			        <div class="control-group">
			          <label class="control-label">Last Name</label>
			          <div class="controls">
			            <input name="lastname" type="text" class="span11" placeholder="Last Name" value="<?php echo isset($rwcatedt[4]) ? $rwcatedt[4] : ''; ?>" required/>
			          </div>
			        </div>
			        <label class="control-label">Kategori Menu</label>
					<div class="controls">
						<select name="usertypeid">
							<?php 
							if($act=='insert'){
							$qmenucat = mysqli_query($connection,"select * from user_type where USER_TYPE <> 'Administrator'");
							while($rwctgr = mysqli_fetch_row($qmenucat)){
							echo "<option value=\"$rwctgr[0]\">$rwctgr[1]</option>";
								} 
							}elseif($act=='edit'){

							echo "<option value=\"$rwcatedt[10]\">$rwcatedt[11]</option>";
							$qmenucat = mysqli_query($connection,"select * from user_type where USER_TYPE <> 'Administrator'");
							while($rwctgr = mysqli_fetch_row($qmenucat)){
							echo "<option value=\"$rwctgr[0]\">$rwctgr[1]</option>";
								}
							}
							?>
						</select>
					</div>				        
			        <div class="form-actions">
			          <button type="Submit" name="btnsave" class="btn btn-success"><i class="icon-save"></i> Simpan</button>
			          <button type="button" name="btncancel" class="btn btn-danger" onclick="window.location.href='?page=msuser'"><i class="icon-undo"></i> Batal</button>
			        </div>
			      </form>
			    </div>
			  </div>
			</div>
		</div>	
	</div>
<?php }else{ ?>	

	<div class="container-fluid">
		<div class="row-fluid"><button class="btn btn-sm btn-success" onclick="window.location.href='?page=msuser&amp;act=insert'"><i class="icon-plus"></i> Tambah Pengguna</button></div>

        <div class="widget-box">
			<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
				<h5>Data User</h5>
			</div>
			<div class="widget-content nopadding">
				<table class="table table-bordered data-table">
				  <thead>
				    <tr>
				      <th>No</th>
				      <th>Nama Depan</th>
				      <th>Nama Belakang</th>
				      <th>User ID</th>
				      <th>Level</th>
				      <th>Aksi</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
						<?php 
						$qmscat = mysqli_query($connection,"select * from user u left join user_type t on t.ID = u.USER_TYPE_ID ");
						$no=0;
						while($rwmscat = mysqli_fetch_row($qmscat)){
						$no++;?>
						<td><?php echo $no;?></td> 
						<td><?php echo strtoupper($rwmscat[3]) ?></td>
						<td><?php echo strtoupper($rwmscat[4]) ?></td>
						<td><?php echo $rwmscat[1] ?></td>
						<td><?php echo $rwmscat[11] ?></td>
						<td><a href="?page=msuser&amp;act=edit&amp;id=<?php echo $rwmscat[0] ?>" class="btn btn-mini btn-info"><i class="icon-save"></i> Edit</a>
						<a href="?page=msuser&amp;act=del&amp;id=<?php echo $rwmscat[0] ?>" onClick="return confirm('Are you sure delete this data ?')" class="btn btn-mini btn-danger"><i class="icon-remove"></i> Hapus</a></td>
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

