<?php echo view('template/header.php');?>



<body>

	<!--wrapper-->

	<div class="wrapper">

		<!--sidebar wrapper -->

		<div class="sidebar-wrapper " data-simplebar="true">

			<div class="sidebar-header">

				<div>

					<img src="<?=base_url()?>/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">

				</div>

				<div>

					<h4 class="logo-text">LOGO</h4>

				</div>

				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>

				</div>

			</div>

			<!--navigation-->

			<?php echo view('template/sidebar.php');?>

			<!--end navigation-->

		</div>

		<!--end sidebar wrapper -->

		<!--start header -->

		<?php echo view('template/topbar.php');?>

		<!--end header -->

		<!--start page wrapper -->

		<div class="page-wrapper">

		<div class="page-content">



			<?php  	echo view('template/breadcumbs');	?>

		</div>

		</div>

		<!--end page wrapper -->

		<!--start overlay-->

		<div class="overlay toggle-icon"></div>

		<!--end overlay-->

		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>

		<!--End Back To Top Button-->

		

		<?php echo view('template/copyright.php');?>

		

		

	</div>

	<!--end wrapper-->

	<!--start switcher-->

	

	<?php echo view('template/switcher.php');?>

	

	

