<?php  
  
    require_once "../class/Admin.php";
    require_once "../class/DB.php";


  	$admin = new Admin($db);
	$datas = $admin->getAdmin();

	$admin->cekLogin();

	if(isset($_REQUEST['id'])) {

		$id_jur = $_REQUEST['id'];
		extract($admin->getDataByID('tbl_jurusan', 'id_jurusan', $id_jur));
	}

	if(isset($_POST['submit'])) {
	  
      try {
          $admin->editJurusan($id_jur, $_POST['jurusan']);
          header("Location: admin_data_jur.php");
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
	      <li><a href="admin_data_jur.php">Data Jurusan</a></li>
	      <li><a href="admin_input_jur.php">Input Jurusan</a></li>
	      <li class="active">Edit</li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-4 col-md-offset-4">
	    	<h4 align="center">Edit Jurusan</h4>
	    	
	    	<form method="post">
		        <div class="form-group" >
		          <small>Masukkan Nama Jurusan</small>
		          <input type="text" class="form-control" value="<?php echo $nama_jurusan; ?>" name="jurusan" required>
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