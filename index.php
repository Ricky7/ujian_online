<?php  
  
    require_once "class/Guru.php";
    require_once "class/Siswa.php";
    require_once "class/DB.php";


  	$guru = new Guru($db);
  	$siswa = new Siswa($db);
  	$dataguru = $guru->getGuru();
  	$datasiswa = $siswa->getSiswa();

  	if($guru->isGuruLoggedIn()){
      
      	switch ($dataguru['role']) {
        	case 'Guru':
	          header("location: guru/guru_index.php");
	          break;
	        
        	default:
	          header("location: index.php");
	          break;
      	}
  	}

  	if($siswa->isSiswaLoggedIn()){
      
      	switch ($datasiswa['role']) {
        	case 'Siswa':
	          header("location: siswa/siswa_index.php");
	          break;
	        
        	default:
	          header("location: index.php");
	          break;
      	}
  	}

  	if(isset($_POST['guru'])){

	      $nig = $_POST['nig'];
	      $password = $_POST['password'];

	      if($guru->login($nig, $password)){
	          
	        switch ($data) {
	          case 'Guru':
	            header("location: guru_index.php");
	            break;
	          
	          default:
	            header("location: index.php");
	            break;
	        }

	      }else{
	          $error = $guru->getLastError();
	      }
	  }

	  if(isset($_POST['siswa'])){

	      $nis = $_POST['nis'];
	      $password = $_POST['password'];

	      if($siswa->login($nis, $password)){
	          
	        switch ($data) {
	          case 'Siswa':
	            header("location: siswa_index.php");
	            break;
	          
	          default:
	            header("location: index.php");
	            break;
	        }

	      }else{
	          $error = $siswa->getLastError();
	      }
	  }

?>
<html>
<head>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>Ujian Online</title>

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <script data-require="jquery@*" data-semver="2.0.3" src="assets/js/jquery-3.2.1.min.js"></script>
    <script data-require="bootstrap@*" data-semver="3.1.1" src="assets/js/bootstrap.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
</head>

<body style="background:#C9E5BE;">
	<div class="container">
		<div class="row">
			<div class="col-md-12" style="padding-top:40px;">
				<center>
					<img src="assets/image/graduation.jpg" width="650px" height="250px">
				</center><br>
				<center>
					<button id="guru" class="btn btn-small">Login Guru</button>
					<button id="siswa" class="btn btn-small">Login Siswa</button>
				</center>
			</div>
		</div>
		
		<div id="content"></div>
		
	</div>
	
</body>
<script>
	$("#guru").click(function(){
	    //alert("The paragraph was clicked.");
	    $( "#content" ).load( "guru/guru_login.php" );
	});
	$("#siswa").click(function(){
	    //alert("The paragraph was clicked.");
	    $( "#content" ).load( "siswa/siswa_login.php" );
	});
</script>
</html>