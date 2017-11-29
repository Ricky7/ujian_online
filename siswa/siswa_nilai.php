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
    	 	<li class="active">Nilai Ujian</li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-4 col-md-offset-4">
	    	<input type="hidden" id="id_siswa" value="<?php echo $datas['id_siswa']; ?>">
	    	<h4 align="center">Nilai Ujian</h4>
	    	<div class="table-responsive" id="target">
		        <table class="table table-hover">
		          <tbody>
		            <?php
		              $query = "SELECT * FROM tbl_ujian INNER JOIN tbl_mapel INNER JOIN tbl_nilai ON (tbl_ujian.id_mapel=tbl_mapel.id_mapel) AND (tbl_ujian.id_ujian=tbl_nilai.id_ujian) WHERE tbl_nilai.id_siswa={$datas['id_siswa']}";
		              $records_per_page=10;
		              $newquery = $siswa->paging($query,$records_per_page);
		              $siswa->daftarNilai($newquery);
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
