<?php  
  
    require_once "../class/Guru.php";
    require_once "../class/DB.php";


  	$guru = new Guru($db);
  	$datas = $guru->getGuru();

	$guru->cekLogin();

	if(isset($_POST['submit'])) {
	  
      try {
          $guru->ubahProfil(array(
          	'nama' => $_POST['nama'],
          	'gender' => $_POST['gender']
          	), $datas['id_guru']);
          header("Location: guru_index.php");
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
	      <li class="active">Profil</li>
	      <li><a href="guru_password.php">Password</a></li>
	    </ol>
	    <!-- //Menu -->
	    
	    <!-- Content -->
	    <div class="col-md-4 col-md-offset-4">
	    	<h4 align="center">Profil</h4>
	    	<img src="../assets/image/teacher.svg" class="img-responsive" alt=""><br>

	    	<form method="post">
		        <div class="form-group" >
		          <input type="text" class="form-control" name="nama" value="<?php echo $datas['nama'] ?>" required>
		        </div>

		        <div class="form-group" >
		          <small>Jenis Kelamin</small><br>
		          <input type="radio" value="L" <?php echo ($datas['gender']=='L')?'Checked':'' ?> name="gender" required> Laki-laki
		          <input type="radio" value="P" <?php echo ($datas['gender']=='P')?'Checked':'' ?> name="gender" required> Perempuan
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
	include "guru_footer.php";
?>
