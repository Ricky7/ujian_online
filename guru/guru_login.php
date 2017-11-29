<?php  
  
   //  require_once "../class/Guru.php";
   //  require_once "../class/DB.php";


  	// $guru = new Guru($db);
  	// $datas = $guru->getGuru();
  	// $data = $datas['role'];

  	// if($guru->isGuruLoggedIn()){
      
   //    	switch ($data) {
   //      	case 'Guru':
	  //         header("location: guru_index.php");
	  //         break;
	        
   //      	default:
	  //         header("location: index.php");
	  //         break;
   //    	}
  	// }

  	// if(isset($_POST['submit'])){
  	// 		
	  //     $nig = $_POST['nig'];
	  //     $password = $_POST['password'];

	  //     if($guru->login($nig, $password)){
	          
	  //       switch ($data) {
	  //         case 'Guru':
	  //           header("location: guru_index.php");
	  //           break;
	          
	  //         default:
	  //           header("location: index.php");
	  //           break;
	  //       }

	  //     }else{
	  //         $error = $guru->getLastError();
	  //     }
	  // }

?>
<div class="row" id="test">
	<div class="col-md-4 col-md-offset-4" style="padding-top:30px;">
		<h4 align="center" style="color:#fff;">Login Guru</h4>
		<form method="post">
			<?php if (isset($error)): ?>
              <div class="alert alert-danger">
                  <?php echo $error ?>
              </div>
	         <?php endif; ?>
		  <div class="form-group" >
		    <label style="color:#fff;">No Induk Guru</label>
		    <input type="text" class="form-control" name="nig" placeholder="NIG">
		  </div>
		  <div class="form-group">
		    <label style="color:#fff;">Password</label>
		    <input type="password" class="form-control" name="password" placeholder="Password">
		  </div>
		  <center>
		  	<button type="submit" name="guru" class="btn btn-success">Masuk</button>
		  </center>
		</form>
	</div>
</div>