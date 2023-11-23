<?php
// $page = geturi(); //get url name
$page = $_GET['page']; 

//not for submenu
switch ($page) 
{
	case 'dashboard' : $odashboard = 'open' ; break;
	case 'mscategory' or 'msitem' : $omstr = 'open' ; break;
	case 'msaplikasi' or 'msapli' : $omstr = 'open' ; break;
	case 'msuser' or 'msuser' : $omstr = 'open' ; break;
}
?>

<ul class="nav nav-list">
	<li class="<?php echo $odashboard ?>">
		<a href="index.php?page=dashboard">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text"> Dashboard </span>
		</a>

		<b class="arrow"></b>
	</li>

	<li class="<?php echo $omstr ?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-desktop"></i>
			<span class="menu-text">
				Master
			</span>

			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			<li class="">
				<a href="index.php?page=mscategory">
					<i class="menu-icon fa fa-caret-right"></i>
					Menu Category
				</a>

				<b class="arrow"></b>
			</li>

			<li class="">
				<a href="index.php?page=msitem">
					<i class="menu-icon fa fa-caret-right"></i>
					Menu Item
				</a>

				<b class="arrow"></b>
			</li>

			<li class="">
				<a href="index.php?page=msapli">
					<i class="menu-icon fa fa-caret-right"></i>
					Menu Aplikasi
				</a>

				<b class="arrow"></b>
			</li>

			<li class="">
				<a href="index.php?page=msuser">
					<i class="menu-icon fa fa-caret-right"></i>
					Menu User
				</a>

				<b class="arrow"></b>
			</li>

		</ul>
	</li>

	<!-- <li class="<?php echo $ospd ?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-desktop"></i>
			<span class="menu-text">
				Master
			</span>

			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			<li class="">
				<a href="create_spd">
					<i class="menu-icon fa fa-caret-right"></i>
					Supplier
				</a>

				<b class="arrow"></b>
			</li>

			<li class="">
				<a href="view_spd">
					<i class="menu-icon fa fa-caret-right"></i>
					Pelanggan
				</a>

				<b class="arrow"></b>
			</li>

			<li class="<?php if($page=='page_kosong'){ echo "open"; } ?>">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-caret-right"></i>

					Three Level Menu
					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					<li class="">
						<a href="page_kosong">
							<i class="menu-icon fa fa-leaf green"></i>
							Item #1
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-pencil orange"></i>

							4th level
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="#">
									<i class="menu-icon fa fa-plus purple"></i>
									Add Product
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="#">
									<i class="menu-icon fa fa-eye pink"></i>
									View Products
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
	</li> -->	

</ul>