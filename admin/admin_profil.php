<?php  
  
    require_once "../class/Admin.php";
    require_once "../class/DB.php";


  	$admin = new Admin($db);
	$datas = $admin->getAdmin();

	$admin->cekLogin();

	if(isset($_POST['submit'])) {
	  
      try {
          $admin->ubahNama($datas['id_admin'], $_POST['nama']);
          header("Location: admin_profil.php");
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
	      <li class="active">Profil</li>
	      <li><a href="admin_password.php">Password</a></li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-4 col-md-offset-4">
	    	<h4 align="center">Profil</h4>
	    	<img src="../assets/image/admin.png" class="img-responsive" alt=""><br>

	    	<form method="post">
		        <div class="form-group" >
		          <input type="text" class="form-control" name="nama" value="<?php echo $datas['nama'] ?>" required>
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