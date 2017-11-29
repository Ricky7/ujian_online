<?php  
  
    require_once "../class/Guru.php";
    require_once "../class/DB.php";


  	$guru = new Guru($db);
  	$datas = $guru->getGuru();

	$guru->cekLogin();

	if(isset($_REQUEST['id'])) {

		$id_ujian = $_REQUEST['id'];
		$mapel = $_REQUEST['slug'];

	}

?>
<?php
	include "guru_header.php";
	include "guru_sidebar.php";
?>

<div class="col-md-9">
    <div class="profile-content">
    	<!-- Menu -->
    	<ol class="breadcrumb">
    	  <li><a href="guru_data_koreksi.php">Daftar Ujian</a></li>
	      <li class="active">Peserta</li>
	      
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-8 col-md-offset-2">
	    	<h4 align="center">Daftar Peserta Ujian Essay <?php echo $mapel ?></h4>
	    	
	    	<div class="table-responsive">
		        <table class="table table-hover">
		          <thead>
		            <th>NIS</th>
		            <th>Nama</th>
		            <th>Opsi</th>
		          </thead>
		          <tbody>
		            <?php
		              $query = "SELECT * FROM tbl_jawaban_es INNER JOIN tbl_siswa INNER JOIN tbl_ujian ON (tbl_jawaban_es.id_siswa=tbl_siswa.id_siswa) AND (tbl_jawaban_es.id_ujian=tbl_ujian.id_ujian) WHERE tbl_ujian.id_ujian={$id_ujian} GROUP BY tbl_jawaban_es.id_siswa";
		              $records_per_page=10;
		              $newquery = $guru->paging($query,$records_per_page);
		              $guru->daftarPeserta($newquery);
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
