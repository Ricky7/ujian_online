<?php  
  
    require_once "../class/Guru.php";
    require_once "../class/DB.php";


  	$guru = new Guru($db);
  	$datas = $guru->getGuru();

	$guru->cekLogin();

	if(isset($_REQUEST['id'])) {

		$id_siswa = $_REQUEST['id'];
		$id_ujian = $_REQUEST['slug'];
		$dataSoal = $guru->getDataByID('tbl_ujian', 'id_ujian', $id_ujian);

	}

	if(isset($_POST['submit'])) {
	  $nilai = $_POST['nilai1']+$_POST['nilai2']+$_POST['nilai3']+$_POST['nilai4']+$_POST['nilai5'];
	  
      try {
          $guru->inputDataArray(array(
          	  'id_ujian' => $id_ujian,
		      'id_siswa' => $id_siswa,
		      'nilai' => $nilai
		    ), 'tbl_nilai');
          $guru->hapusJawaban($id_ujian, $id_siswa);
          $guru->hapusSoal($id_ujian, $id_siswa);
          header("Location: guru_data_koreksi.php");
        } catch (Exception $e) {
          die($e->getMessage());
        }
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
	      <li class="active">Koreksi</li>
	      
	    </ol>
	    <!-- //Menu -->

	    <!-- Content Input -->
	    <div class="col-md-12">
	      	<!-- Trigger the modal with a button -->
	      	
	    </div>
	    <!-- //Content -->

	    <!-- Content -->
	    <div class="col-md-12">
	    	<h4 align="center">Jawaban Soal Essay</h4>
	    	
			<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Beri Nilai</button>
			
	    	<div class="table-responsive" style="padding-top:10px;">
		        <table class="table table-hover">
		          <tbody>
		            <?php
		              $query = "SELECT * FROM tbl_jawaban_es INNER JOIN tbl_soal_es ON
		              (tbl_jawaban_es.id_soal_es=tbl_soal_es.id_soal_es)
		              WHERE tbl_jawaban_es.id_siswa={$id_siswa} AND tbl_jawaban_es.id_ujian={$id_ujian}";
		              $records_per_page=$dataSoal['jumlah_soal'];
		              $newquery = $guru->paging($query,$records_per_page);
		              $guru->daftarJawaban($newquery);
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

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Isi Soal</h4>
      </div>
      <div class="modal-body">
        <form method="post">
        	<div class="form-group" >
	          <small>Soal 1 </small><br>
	          <input type="number" name="nilai1" required><br>
	          <small>Soal 2 </small><br>
	          <input type="number" name="nilai2" required><br>
	          <small>Soal 3 </small><br>
	          <input type="number" name="nilai3" required><br>
	          <small>Soal 4 </small><br>
	          <input type="number" name="nilai4" required></br>
	          <small>Soal 5 </small><br>
	          <input type="number" name="nilai5" required>
	        </div>
      </div>
      <div class="modal-footer">
      	<button type="submit" name="submit" class="btn btn-success btn-sm">Submit</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        </form>
      </div>
    </div>

  </div>
</div>
<?php
	include "guru_footer.php";
?>
