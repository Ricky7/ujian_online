<?php  
  
    require_once "../class/Admin.php";
    require_once "../class/DB.php";


  	$admin = new Admin($db);

    $admin->logout();

    // Redirect ke login
    header('location: admin_login.php');
 ?>