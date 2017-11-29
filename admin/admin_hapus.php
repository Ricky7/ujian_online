<?php

  require_once "../class/Admin.php";
  require_once "../class/DB.php";


  $admin = new Admin($db);
  $datas = $admin->getAdmin();

  $admin->cekLogin();
    
  if(isset($_REQUEST['tb']) && isset($_REQUEST['set']) && isset($_REQUEST['id'])) {

      try {
          $admin->hapusData($_REQUEST['tb'], $_REQUEST['set'], $_REQUEST['id']);
          
          switch ($_REQUEST['tb']) {
            case 'tbl_jurusan':
                header("Location: admin_data_jur.php");
              break;

            case 'tbl_kelas':
                header("Location: admin_data_kelas.php");
              break;

            case 'tbl_mapel':
                header("Location: admin_data_mapel.php");
              break;

            case 'tbl_siswa':
                header("Location: admin_data_siswa.php");
              break;

            case 'tbl_guru':
                header("Location: admin_data_guru.php");
              break;

            case 'tbl_ujian':
                header("Location: admin_data_ujian.php");
              break;
            
            default:
                header("Location: admin_logout.php");
              break;
          }
      } catch (Exception $e) {
          die($e->getMessage());
      }
  }
    
?>