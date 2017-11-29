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
					<img src="../assets/image/admin_logo.png" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						<?php echo $datas['nama']; ?>
					</div>
					<div class="profile-usertitle-job">
						Administrator
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class="profile-userbuttons">
					<a href="admin_profil.php" class="btn btn-success btn-sm">Profil</a>
					<a href="admin_logout.php" class="btn btn-danger btn-sm">Logout</a>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li class="active">
							<a href="admin_data_ujian.php">
							<i class="glyphicon glyphicon-home"></i>
							Daftar Ujian </a>
						</li>
						<li>
							<a href="admin_data_siswa.php">
							<i class="glyphicon glyphicon-user"></i>
							Siswa </a>
						</li>
						<li>
							<a href="admin_data_guru.php">
							<i class="glyphicon glyphicon-user"></i>
							Guru </a>
						</li>
						<li>
							<a href="admin_data_jur.php">
							<i class="glyphicon glyphicon-flag"></i>
							Jurusan </a>
						</li>
						<li>
							<a href="admin_data_mapel.php">
							<i class="glyphicon glyphicon-flag"></i>
							Mata Pelajaran </a>
						</li>
						<li>
							<a href="admin_data_kelas.php">
							<i class="glyphicon glyphicon-flag"></i>
							Kelas </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>