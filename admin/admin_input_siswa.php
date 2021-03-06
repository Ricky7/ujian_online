<?php  
  
    require_once "../class/Admin.php";
    require_once "../class/DB.php";


  	$admin = new Admin($db);
	$datas = $admin->getAdmin();
	$jur = $admin->getJurusan();
	$kel = $admin->getKelas();

	$admin->cekLogin();

	if(isset($_POST['submit'])) {
	  
      try {
          $admin->inputDataArray(array(
		      'gender' => $_POST['gender'],
		      'nis' => $_POST['nis'],
		      'nama' => $_POST['nama'],
		      'id_kelas' => $_POST['kelas'],
		      'id_jurusan' => $_POST['jurusan'],
		      'password' => password_hash(12345, PASSWORD_DEFAULT),
		      'role' => 'Siswa'
		    ), 'tbl_siswa');
          header("Location: admin_data_siswa.php");
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
	      <li><a href="admin_data_siswa.php">Data Siswa</a></li>
	      <li class="active">Input Siswa</li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-4 col-md-offset-4">
	    	<h4 align="center">Input Siswa</h4>
	    	
	    	<form method="post">
		        <div class="form-group" >
		          <small>No Induk Siswa</small>
		          <input type="text" class="form-control" name="nis" required>
		        </div>

		         <div class="form-group" >
		          <small>Nama Siswa</small>
		          <input type="text" class="form-control" name="nama" required>
		        </div>

		         <div class="form-group" >
		          <small>Jenis Kelamin</small><br>
		          <input type="radio" value="L" name="gender" required> Laki-laki
		          <input type="radio" value="P" name="gender" required> Perempuan
		        </div>

		        <div class="form-group" >
		          <small>Kelas</small>
		          <select name="kelas" class="form-control" required>
		          	  <option></option>
		              <?php foreach ($kel as $value): ?>
		              <option value="<?php echo $value['id_kelas']; ?>"><?php echo $value['nama_kelas']; ?></option>
		              <?php endforeach; ?>
		          </select>
		        </div>

		        <div class="form-group" >
		          <small>Jurusan</small>
		          <select name="jurusan" class="form-control" required>
		          	  <option></option>
		              <?php foreach ($jur as $value): ?>
		              <option value="<?php echo $value['id_jurusan']; ?>"><?php echo $value['nama_jurusan']; ?></option>
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