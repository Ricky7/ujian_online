<?php  
  
    require_once "../class/Admin.php";
    require_once "../class/DB.php";


  	$admin = new Admin($db);
	$datas = $admin->getAdmin();
	$jur = $admin->getJurusan();

	$admin->cekLogin();

	if(isset($_POST['submit'])) {
	  
      try {
          $admin->inputDataArray(array(
		      'gender' => $_POST['gender'],
		      'nig' => $_POST['nig'],
		      'nama' => $_POST['nama'],
		      'password' => password_hash(12345, PASSWORD_DEFAULT),
		      'role' => 'Guru'
		    ), 'tbl_guru');
          header("Location: admin_data_guru.php");
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
	      <li><a href="admin_data_guru.php">Data Guru</a></li>
	      <li class="active">Input Guru</li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-4 col-md-offset-4">
	    	<h4 align="center">Input Guru</h4>
	    	
	    	<form method="post">
		        <div class="form-group" >
		          <small>No Induk Guru</small>
		          <input type="text" class="form-control" name="nig" required>
		        </div>

		         <div class="form-group" >
		          <small>Nama Guru</small>
		          <input type="text" class="form-control" name="nama" required>
		        </div>

		         <div class="form-group" >
		          <small>Jenis Kelamin</small><br>
		          <input type="radio" value="L" name="gender" required> Laki-laki
		          <input type="radio" value="P" name="gender" required> Perempuan
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