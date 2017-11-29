<?php
	require_once "../class/DB.php";

	$jawaban = $_POST['jwb'];
	$id_soal_pg = $_POST['id_soal_pg'];
	$id_ujian = $_POST['id_ujian'];
	$id_siswa = $_POST['id_siswa'];

	$stmt = $db->prepare("SELECT * FROM tbl_jawaban_pg WHERE id_soal_pg=:id_soal_pg AND id_ujian=:id_ujian AND id_siswa=:id_siswa");
	$stmt->execute(array(":id_soal_pg"=>$id_soal_pg, ":id_ujian"=>$id_ujian, ":id_siswa"=>$id_siswa));
	$editRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$lax = $db->prepare("SELECT tbl_soal_pg.jawaban FROM temp_soal INNER JOIN tbl_soal_pg ON (temp_soal.id_soal_pg=tbl_soal_pg.id_soal_pg) WHERE temp_soal.id_soal_pg=:id_soal_pg");
	$lax->execute(array(":id_soal_pg"=>$id_soal_pg));
	$laxRow=$lax->fetch(PDO::FETCH_ASSOC);

	if($jawaban == $laxRow['jawaban']) {

		$status = 1;
	} else {
		$status = 0;
	}

	if($stmt->rowCount()>0){

		$sql = "UPDATE tbl_jawaban_pg SET pilihan='{$jawaban}', status='{$status}' WHERE id_soal_pg='{$id_soal_pg}' AND id_ujian='{$id_ujian}' AND id_siswa='{$id_siswa}'";

		if ($db->prepare($sql)) {
	        if ($db->exec($sql)) {
	            return true;
	            //echo "update sukses";
	        }
	    }
		
		return false;
		
	} else {

		$sql = "INSERT INTO tbl_jawaban_pg (id_soal_pg, id_ujian, id_siswa, pilihan, status) VALUES ('{$id_soal_pg}', '{$id_ujian}', '{$id_siswa}', '{$jawaban}', '{$status}')";

		if ($db->prepare($sql)) {
	        if ($db->exec($sql)) {
	            return true;
	            //echo "insert sukses";
	        }
	    }
	    return false;

	}
?>