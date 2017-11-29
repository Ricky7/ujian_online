<?php  
  
    require_once "../class/Siswa.php";
    require_once "../class/DB.php";


  	$siswa = new Siswa($db);

    $siswa->logout();

    // Redirect ke login
    header('location: ../index.php');
 ?>