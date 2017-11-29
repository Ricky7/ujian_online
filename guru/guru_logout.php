<?php  
  
    require_once "../class/Guru.php";
    require_once "../class/DB.php";


  	$guru = new Guru($db);

    $guru->logout();

    // Redirect ke login
    header('location: ../index.php');
 ?>