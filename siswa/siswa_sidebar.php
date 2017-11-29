<!--
User Profile Sidebar by @keenthemes
A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
Licensed under MIT
-->
<div class="container">
    <div class="row profile">
		<div class="col-md-3">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<img src="../assets/image/student.svg" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						<?php echo $datas['nama']; ?>
					</div>
					<div class="profile-usertitle-job">
						Student
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class="profile-userbuttons">
					<a href="siswa_index.php" class="btn btn-success btn-sm">Profil</a>
					<a href="siswa_logout.php" class="btn btn-danger btn-sm">Logout</a>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li class="active">
							<a href="siswa_menu_ujian.php">
							<i class="glyphicon glyphicon-home"></i>
							Menu Ujian </a>
						</li>
						<li>
							<a href="siswa_nilai.php">
							<i class="glyphicon glyphicon-flag"></i>
							Nilai </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>