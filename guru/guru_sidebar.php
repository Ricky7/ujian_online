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
					<img src="../assets/image/teacher.svg" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						<?php echo $datas['nama']; ?>
					</div>
					<div class="profile-usertitle-job">
						Teacher
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class="profile-userbuttons">
					<a href="guru_index.php" class="btn btn-success btn-sm">Profil</a>
					<a href="guru_logout.php" class="btn btn-danger btn-sm">Logout</a>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li class="active">
							<a href="guru_data_ujian.php">
							<i class="glyphicon glyphicon-home"></i>
							Menu Ujian </a>
						</li>
						<li>
							<a href="guru_data_nilai.php">
							<i class="glyphicon glyphicon-flag"></i>
							Daftar Nilai </a>
						</li>
						<li>
							<a href="guru_data_koreksi.php">
							<i class="glyphicon glyphicon-flag"></i>
							Koreksi Essay</a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>