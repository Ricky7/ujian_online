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
	      <li class="active">Daftar Ujian</li>
	      <li><a href="admin_input_ujian.php">Input Ujian</a></li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-12">
	    	<h4 align="center">Data Ujian</h4>
	    	
	    	<div class="table-responsive">
		        <table class="table table-hover">
		          <thead>
		            <th>Mata Pelajaran</th>
		            <th>Jumlah Soal</th>
		            <th>Jenis Soal</th>
		            <th>Pengajar</th>
		            <th colspan="2">Opsi</th>
		          </thead>
		          <tbody>
		            <?php
		              $query = "SELECT * FROM tbl_ujian INNER JOIN tbl_mapel INNER JOIN tbl_guru ON (tbl_ujian.id_mapel=tbl_mapel.id_mapel) AND (tbl_ujian.id_guru=tbl_guru.id_guru) ORDER BY tbl_mapel.nama_mapel ASC";       
		              $records_per_page=10;
		              $newquery = $admin->paging($query,$records_per_page);
		              $admin->daftarUjian($newquery);
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