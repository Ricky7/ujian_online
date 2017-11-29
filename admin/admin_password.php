<?php  
  
    require_once "../class/Admin.php";
    require_once "../class/DB.php";


  	$admin = new Admin($db);
	$datas = $admin->getAdmin();

	$admin->cekLogin();

?>
<?php
	include "admin_header.php";
	include "admin_sidebar.php";
?>

<div class="col-md-9">
    <div class="profile-content">
    	<!-- Menu -->
    	<ol class="breadcrumb">
    		<li><a href="admin_profil.php">Profil</a></li>
	      <li class="active">Password</li>  
	    </ol>
	    <!-- //Menu -->

	    <!-- Content -->
	    <div class="col-md-4 col-md-offset-4">
	    	<h4 align="center">Change Password</h4>
	      <?php
	          if(isset($_POST['submit'])) {
	  
	              try {
	                  $admin->ubahPassword($datas['id_admin'], $_POST['old_pass'], $_POST['new_pass']);
	                  //header("refresh: 5");
	                } catch (Exception $e) {
	                  die($e->getMessage());

	                }
	            }
	        ?>
	      <form method="post">
	        <div class="form-group" >
	          <small>Password Lama</small>
	          <input type="password" class="form-control" name="old_pass" placeholder="Password Lama">
	        </div>
	        <div class="form-group">
	          <small>Password Baru</small>
	          <input type="password" class="form-control" name="new_pass" placeholder="Password Baru">
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