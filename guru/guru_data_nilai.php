<?php  
  
    require_once "../class/Guru.php";
    require_once "../class/DB.php";


  	$guru = new Guru($db);
  	$datas = $guru->getGuru();

	$guru->cekLogin();

?>
<?php
	include "guru_header.php";
	include "guru_sidebar.php";
?>

<div class="col-md-9">
    <div class="profile-content">
    	<!-- Menu -->
    	<ol class="breadcrumb">
	      <li class="active">Daftar Ujian</li>
	      <li><a href="#">Nilai</a></li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-6 col-md-offset-3">
	    	<h4 align="center">Data Ujian</h4>
	    	
	    	<div class="table-responsive">
		        <table class="table table-hover">
		          <thead>
		            <th>Mata Pelajaran</th>
		            <th>Jenis Soal</th>
		            <th>Kelas</th>
		            <th>Opsi</th>
		          </thead>
		          <tbody>
		            <?php
		              $query = "SELECT * FROM tbl_ujian INNER JOIN tbl_mapel INNER JOIN tbl_kelas ON (tbl_ujian.id_mapel=tbl_mapel.id_mapel) AND (tbl_ujian.id_kelas=tbl_kelas.id_kelas) WHERE tbl_ujian.id_guru = {$datas['id_guru']} ORDER BY tbl_kelas.nama_kelas ASC";
		              $records_per_page=10;
		              $newquery = $guru->paging($query,$records_per_page);
		              $guru->daftarUjian2($newquery);
		             ?>
		             <tr>
		                <td colspan="5" align="center">
		              		<div class="pagination-wrap">
			                    <?php $guru->paginglink($query,$records_per_page); ?>
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
	include "guru_footer.php";
?>
