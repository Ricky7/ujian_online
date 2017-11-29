<?php
	require_once "../class/Siswa.php";
    require_once "../class/DB.php";

  	$siswa = new Siswa($db);
  	$datas = $siswa->getSiswa();

	$siswa->cekLogin();

	$id_ujian = $_POST['id_ujian'];
	$null = 'NULL';

	if($siswa->setNull($id_ujian, $null)) {

		header("Location: siswa_menu_ujian.php");
	}
?>