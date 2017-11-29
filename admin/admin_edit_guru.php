<?php  
  
    require_once "../class/Admin.php";
    require_once "../class/DB.php";


  	$admin = new Admin($db);
	$datas = $admin->getAdmin();
	$jur = $admin->getJurusan();

	$admin->cekLogin();

	if(isset($_REQUEST['id'])) {

		$id_guru = $_REQUEST['id'];
		extract($admin->getDataByID('tbl_guru', 'id_guru', $id_guru));
	}

	if(isset($_POST['submit'])) {
	  
      try {
          $admin->editGuru(array(
		      'gender' => $_POST['gender'],
		      'nig' => $_POST['nig'],
		      'nama' => $_POST['nama']
		    ), $id_guru);
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
	      <li><a href="admin_input_guru.php">Input Guru</a></li>
	      <li class="active">Edit</li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-4 col-md-offset-4">
	    	<h4 align="center">Edit Guru</h4>
	    	
	    	<form method="post">
		        <div class="form-group" >
		          <small>No Induk Guru</small>
		          <input type="text" class="form-control" name="nig" value="<?php echo $nig ?>" required>
		        </div>

		         <div class="form-group" >
		          <small>Nama Guru</small>
		          <input type="text" class="form-control" name="nama" value="<?php echo $nama ?>" required>
		        </div>

		         <div class="form-group" >
		          <small>Jenis Kelamin</small><br>
		          <input type="radio" value="L" <?php echo ($gender=='L')?'Checked':'' ?> name="gender" required> Laki-laki
		          <input type="radio" value="P" <?php echo ($gender=='P')?'Checked':'' ?> name="gender" required> Perempuan
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