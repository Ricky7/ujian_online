<?php  
  
    require_once "../class/Siswa.php";
    require_once "../class/DB.php";


  	$siswa = new Siswa($db);
  	$datas = $siswa->getSiswa();

	$siswa->cekLogin();

?>
<?php
	include "siswa_header.php";
	include "siswa_sidebar.php";
?>

<div class="col-md-9">
    <div class="profile-content">
    	<!-- Menu -->
    	<ol class="breadcrumb">
    		<li class="active">Daftar Ujian</li>  
    	 	<li><a href="#">Isi</a></li> 	
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-12">
	    	<h4 align="center">Ujian Tersedia</h4>
	    	
	    	<div class="table-responsive">
		        <table class="table table-hover">
		          <thead>
		            <th>Mata Pelajaran</th>
		            <th>Jumlah Soal</th>
		            <th>Jenis Soal</th>
		            <th>Kelas</th>
		            <th>Opsi</th>
		          </thead>
		          <tbody>
		            <?php
		              $query = "SELECT * FROM tbl_ujian INNER JOIN tbl_mapel INNER JOIN tbl_kelas ON (tbl_ujian.id_mapel=tbl_mapel.id_mapel) AND (tbl_ujian.id_kelas=tbl_kelas.id_kelas) 
		              WHERE tbl_ujian.id_kelas = {$datas['id_kelas']} AND tbl_ujian.waktu_selesai IS NOT NULL";
		              $records_per_page=10;
		              $newquery = $siswa->paging($query,$records_per_page);
		              $siswa->daftarUjian($newquery);
		             ?>
		             <tr>
		                <td colspan="5" align="center">
		              		<div class="pagination-wrap">
			                    <?php $siswa->paginglink($query,$records_per_page); ?>
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
	include "siswa_footer.php";
?>
