<?php  
  
    require_once "../class/Admin.php";
    require_once "../class/DB.php";


  	$admin = new Admin($db);
	$datas = $admin->getAdmin();
	$jur = $admin->getJurusan();
	$kel = $admin->getKelas();
	$mapel = $admin->getMapel();
	$gurux = $admin->getGuru();

	$admin->cekLogin();

	if(isset($_REQUEST['id'])) {

		$id_ujian = $_REQUEST['id'];
		extract($admin->getDataByID('tbl_ujian', 'id_ujian', $id_ujian));
		extract($admin->getDataByID('tbl_mapel', 'id_mapel', $id_mapel));
		extract($admin->getDataByID('tbl_jurusan', 'id_jurusan', $id_jurusan));
		extract($admin->getDataByID('tbl_kelas', 'id_kelas', $id_kelas));
		extract($admin->getDataByID('tbl_guru', 'id_guru', $id_guru));
	}

	if(isset($_POST['submit'])) {
	  
      try {
          $admin->editUjian(array(
		      'jumlah_soal' => $_POST['jumlah'],
		      'jenis_soal' => $_POST['jenis'],
		      'id_guru' => $_POST['guru'],
		      'id_kelas' => $_POST['kelas'],
		      'id_jurusan' => $_POST['jurusan'],
		      'id_mapel' => $_POST['mapel']
		    ), $id_ujian);
          header("Location: admin_data_ujian.php");
        } catch (Exception $e) {
          die($e->getMessage());
        }
    }

?>
<?php
	include "admin_header.php";
	include "admin_sidebar.php";
?>

<div class="col-md-9">
    <div class="profile-content">
    	<!-- Menu -->
    	<ol class="breadcrumb">
	      <li><a href="admin_data_ujian.php">Daftar Ujian</a></li>
	      <li><a href="admin_input_ujian.php">Input Ujian</a></li>
	      <li class="active">Edit</li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-8 col-md-offset-2">
	    	<h4 align="center">Input Ujian</h4>
	    	
	    	<form method="post">

	    		<div class="form-group" >
		          <small>Mata Pelajaran</small>
		          <select name="mapel" class="form-control" required>
		          	  <option value="<?php echo $id_mapel ?>"><?php echo $nama_mapel ?></option>
		              <?php foreach ($mapel as $value): ?>
		              <option value="<?php echo $value['id_mapel']; ?>"><?php echo $value['nama_mapel']; ?></option>
		              <?php endforeach; ?>
		          </select>
		        </div>

		        <div class="form-group" >
		          <small>Jumlah Soal</small>
		          <input type="number" class="form-control" value="<?php echo $jumlah_soal ?>" name="jumlah" required>
		        </div>

		        <div class="form-group" >
		          <small>Jenis Soal</small><br> 
		          <input type="radio" value="PG" <?php echo ($jenis_soal=='PG')?'Checked':'' ?> name="jenis" required> Pilihan Berganda
		          <input type="radio" value="ES" <?php echo ($jenis_soal=='ES')?'Checked':'' ?> name="jenis" required> Essay Test
		        </div>

		        <div class="form-group" >
		          <small>Kelas</small>
		          <select name="kelas" class="form-control" required>
		          	  <option value="<?php echo $id_kelas ?>"><?php echo $nama_kelas ?></option>
		              <?php foreach ($kel as $value): ?>
		              <option value="<?php echo $value['id_kelas']; ?>"><?php echo $value['nama_kelas']; ?></option>
		              <?php endforeach; ?>
		          </select>
		        </div>

		        <div class="form-group" >
		          <small>Jurusan</small>
		          <select name="jurusan" class="form-control" required>
		          	  <option value="<?php echo $id_jurusan ?>"><?php echo $nama_jurusan ?></option>
		              <?php foreach ($jur as $value): ?>
		              <option value="<?php echo $value['id_jurusan']; ?>"><?php echo $value['nama_jurusan']; ?></option>
		              <?php endforeach; ?>
		          </select>
		        </div>

		        <div class="form-group" >
		          <small>Nama Guru</small>
		          <select name="guru" class="form-control" required>
		          	  <option value="<?php echo $id_guru ?>"><?php echo $nama ?></option>
		              <?php foreach ($gurux as $value): ?>
		              <option value="<?php echo $value['id_guru']; ?>"><?php echo $value['nig'].' '.$value['nama']; ?></option>
		              <?php endforeach; ?>
		          </select>
		        </div>
		        
		        <center>
		          <button type="submit" name="submit" class="btn btn-success btn-sm">Submit</button>
		        </center>
		    </form>
	    	
	      	
	    </div>
	    <!-- //Content -->
    </div>
</div>
<?php
	include "admin_footer.php";
?>