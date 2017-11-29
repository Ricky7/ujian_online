<?php  
  
    require_once "../class/Guru.php";
    require_once "../class/DB.php";


  	$guru = new Guru($db);
  	$datas = $guru->getGuru();

	$guru->cekLogin();

	if(isset($_REQUEST['id'])) {

		$id_ujian = $_REQUEST['id'];
		$dataCount = $guru->getCountByID('tbl_soal_pg', 'id_ujian', $id_ujian);
		$dataSoal = $guru->getDataByID('tbl_ujian', 'id_ujian', $id_ujian);
	}

	if(isset($_POST['submit'])) {
	  
      try {
          $guru->inputDataArray(array(
          	  'id_ujian' => $id_ujian,
		      'soal' => $_POST['soal'],
		      'pil1' => $_POST['pil1'],
		      'pil2' => $_POST['pil2'],
		      'pil3' => $_POST['pil3'],
		      'pil4' => $_POST['pil4'],
		      'jawaban' => $_POST['jawaban']
		    ), 'tbl_soal_pg');
          header("Location: guru_isi_soal.php?id=$id_ujian");
        } catch (Exception $e) {
          die($e->getMessage());
        }
    }

    if(isset($_POST['waktu'])) {
	  
      try {
          $guru->setWaktu($id_ujian, $_POST['output4'].' '.$_POST['waktu_ujian'].':00');
          header("Location: guru_isi_soal.php?id=$id_ujian");
        } catch (Exception $e) {
          die($e->getMessage());
        }
    }

    if(isset($_POST['edit'])) {
	  
      try {
          $guru->editSoal(array(
		      'soal' => $_POST['soal'],
		      'pil1' => $_POST['pil1'],
		      'pil2' => $_POST['pil2'],
		      'pil3' => $_POST['pil3'],
		      'pil4' => $_POST['pil4'],
		      'jawaban' => $_POST['jawaban']
		    ), $_POST['id_soal']);
          header("Location: guru_isi_soal.php?id=$id_ujian");
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
    	  <li><a href="guru_data_ujian.php">Daftar Ujian</a></li>
	      <li class="active">Isi Soal</li>
	    </ol>
	    <!-- //Menu -->

	    <!-- Content Input -->
	    <div class="col-md-12">
	      	<!-- Trigger the modal with a button -->
	      	<center>
				<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Tambah Soal</button>
				<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myWaktu">Set Waktu</button>
			</center>
	    </div>
	    <!-- //Content -->
	    
	    <!-- Content Soal -->
	    <div class="col-md-12">
	      	<h4 align="center">Daftar Soal</h4>
	      	<h6 align="center"><font color="red">Total Soal : <?php echo $dataCount['total'].'/'.$dataSoal['jumlah_soal'] ?></font></h6>
	    	<div class="table-responsive">
		        <table class="table table-hover">
		          <thead>
		            <th>Soal</th>
		            <th>Jawaban</th>
		            <th>Opsi</th>
		          </thead>
		          <tbody>
		            <?php
		              $query = "SELECT * FROM tbl_soal_pg WHERE id_ujian = '{$id_ujian}' ORDER BY id_soal_pg DESC";
		              $records_per_page=8;
		              $newquery = $guru->paging($query,$records_per_page);
		              $guru->daftarSoal($newquery);
		             ?>
		             <tr>
		                <td colspan="5" align="center">
		              		<div class="pagination-wrap">
			                    <?php $guru->paginglink2($query,$records_per_page, $id_ujian); ?>
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
	          <small>Soal</small>
	          <textarea name="soal" rows="3" class="form-control" required></textarea>
	        </div>
	        <div class="form-group" >
	          <small>Pilihan 1</small>
	          <input type="text" class="form-control" name="pil1" required>
	        </div>
	        <div class="form-group" >
	          <small>Pilihan 2</small>
	          <input type="text" class="form-control" name="pil2" required>
	        </div>
	        <div class="form-group" >
	          <small>Pilihan 3</small>
	          <input type="text" class="form-control" name="pil3" required>
	        </div>
	        <div class="form-group" >
	          <small>Pilihan 4</small>
	          <input type="text" class="form-control" name="pil4" required>
	        </div>
	        <div class="form-group" >
	          <small>Jawaban Benar</small>
	          <select name="jawaban" class="form-control" required>
	          	<option></option>
	          	<option value="pil1">Pilihan 1</option>
	          	<option value="pil2">Pilihan 2</option>
	          	<option value="pil3">Pilihan 3</option>
	          	<option value="pil4">Pilihan 4</option>
	          </select>
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

<!-- Modal Waktu-->
<div id="myWaktu" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal Waktu-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Set Waktu</h4>
      </div>
      <div class="modal-body">
        <form method="post">
        	<div class="form-group" >
	          <small>Tanggal</small>
	          <input type="date" class="form-control" name="tgl_ujian" required>
	        </div>
	        <div class="form-group" >
	          <small>Waktu</small>
	          <input type="time" class="form-control" name="waktu_ujian" required>
	        </div>
	        <INPUT TYPE="hidden" NAME="string5" SIZE=15>
			<INPUT TYPE="hidden" NAME="format4" VALUE="yyyy-MM-dd" SIZE=15>
			<INPUT TYPE="hidden" NAME="newformat4" VALUE="MMM d, y" SIZE=15>
			<INPUT TYPE="hidden" NAME="output4" VALUE="" SIZE=15>
      </div>
      <div class="modal-footer">
      	<button type="submit" name="waktu" onClick="this.form.output4.value=formatDate(new Date(getDateFromFormat(this.form.tgl_ujian.value,this.form.format4.value)),this.form.newformat4.value)" class="btn btn-success btn-sm">Submit</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        </form>
      </div>
    </div>

  </div>
</div>

<!-- Modal Edit -->
<div id="myModalEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Soal</h4>
      </div>
      <div class="modal-body">
        <form method="post">
        	<div class="form-group" >
	          <small>Soal</small>
	          <textarea name="soal" rows="3" class="form-control soal" required></textarea>
	        </div>
	        <div class="form-group" >
	          <input type="hidden" class="form-control id" name="id_soal" required>
	        </div>
	        <div class="form-group" >
	          <small>Pilihan 1</small>
	          <input type="text" class="form-control pil1" name="pil1" required>
	        </div>
	        <div class="form-group" >
	          <small>Pilihan 2</small>
	          <input type="text" class="form-control pil2" name="pil2" required>
	        </div>
	        <div class="form-group" >
	          <small>Pilihan 3</small>
	          <input type="text" class="form-control pil3" name="pil3" required>
	        </div>
	        <div class="form-group" >
	          <small>Pilihan 4</small>
	          <input type="text" class="form-control pil4" name="pil4" required>
	        </div>
	        <div class="form-group" >
	          <small>Jawaban Benar</small>
	          <select name="jawaban" class="form-control jawaban" required>
	          	<option></option>
	          	<option value="pil1">Pilihan 1</option>
	          	<option value="pil2">Pilihan 2</option>
	          	<option value="pil3">Pilihan 3</option>
	          	<option value="pil4">Pilihan 4</option>
	          </select>
	        </div>
      </div>
      <div class="modal-footer">
      	<button type="submit" name="edit" class="btn btn-success btn-sm">Submit</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        </form>
      </div>
    </div>

  </div>
</div>
<script src="../assets/js/date.js"></script>
<script>
$(document).on( "click", '.edit_button',function(e) {
    var soal = $(this).data('soal');
    var pil1 = $(this).data('a');
    var pil2 = $(this).data('b');
    var pil3 = $(this).data('c');
    var pil4 = $(this).data('d');
    var jawaban = $(this).data('jb');
    var id = $(this).data('id');
    var option = $('<option value="'+jawaban+'" selected>'+jawaban+'</option>');

    $(".id").val(id);
    $(".soal").val(soal);
    $(".pil1").val(pil1);
    $(".pil2").val(pil2);
    $(".pil3").val(pil3);
    $(".pil4").val(pil4);
    
    $('.jawaban').append(option);    
  
});
</script>
<?php
	include "guru_footer.php";
?>
