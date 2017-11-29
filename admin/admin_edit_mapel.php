<?php  
  
    require_once "../class/Admin.php";
    require_once "../class/DB.php";


  	$admin = new Admin($db);
	$datas = $admin->getAdmin();

	$admin->cekLogin();

	if(isset($_REQUEST['id'])) {

		$id_mapel = $_REQUEST['id'];
		extract($admin->getDataByID('tbl_mapel', 'id_mapel', $id_mapel));
	}

	if(isset($_POST['submit'])) {
	  
      try {
          $admin->editMapel($id_mapel, $_POST['mapel']);
          header("Location: admin_data_mapel.php");
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
	      <li><a href="admin_data_mapel.php">Data Mata Pelajaran</a></li>
	      <li><a href="admin_input_mapel.php">Input Mata Pelajaran</a></li>
	      <li class="active">Edit</li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-4 col-md-offset-4">
	    	<h4 align="center">Edit Mata Pelajaran</h4>
	    	
	    	<form method="post">
		        <div class="form-group" >
		          <small>Mata Pelajaran</small>
		          <input type="text" class="form-control" value="<?php echo $nama_mapel ?>" name="mapel" required>
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