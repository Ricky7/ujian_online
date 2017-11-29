<?php  
  
    require_once "../class/Admin.php";
    require_once "../class/DB.php";


  	$admin = new Admin($db);
	$datas = $admin->getAdmin();

	$admin->cekLogin();

?>
<?php
	include "admin_header.php";
	include "admin_sidebar.php";
?>

<div class="col-md-9">
    <div class="profile-content">
    	<!-- Menu -->
    	<ol class="breadcrumb">
	      <li class="active">Data Siswa</li>
	      <li><a href="admin_input_siswa.php">Input Siswa</a></li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-8 col-md-offset-2">
	    	<h4 align="center">Data Siswa</h4>
	    	
	    	<div class="table-responsive">
		        <table class="table table-hover">
		          <thead>
		            <th>No Induk Siswa</th>
		            <th>Nama</th>
		            <th>Jenis Kelamin</th>
		            <th>Kelas</th>
		            <th>Jurusan</th>
		            <th colspan="2">Opsi</th>
		          </thead>
		          <tbody>
		            <?php
		              $query = "SELECT * FROM tbl_siswa INNER JOIN tbl_kelas INNER JOIN tbl_jurusan ON (tbl_siswa.id_kelas=tbl_kelas.id_kelas) AND (tbl_siswa.id_jurusan=tbl_jurusan.id_jurusan)";       
		              $records_per_page=10;
		              $newquery = $admin->paging($query,$records_per_page);
		              $admin->daftarSiswa($newquery);
		             ?>
		             <tr>
		                <td colspan="7" align="center">
		              		<div class="pagination-wrap">
			                    <?php $admin->paginglink($query,$records_per_page); ?>
			                </div>
		                </td>
		            </tr>
		          </tbody>
		        </table>
	        </div>
	      	
	    </div>
	    <!-- //Content -->
    </div>
</div>
<?php
	include "admin_footer.php";
?>