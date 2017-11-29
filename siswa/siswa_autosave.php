<?php  
  
    require_once "../class/Siswa.php";
    require_once "../class/DB.php";

  	$siswa = new Siswa($db);
  	$datas = $siswa->getSiswa();

	$siswa->cekLogin();

	$id_soal_es = $_POST['id_soal_es'];
	$id_siswa = $_POST['id_siswa'];
	$id_ujian = $_POST['id_ujian'];
	$jawaban = $_POST['jawaban'];

	$stmt = $db->prepare("SELECT * FROM tbl_jawaban_es WHERE id_soal_es=:id_soal_es AND id_ujian=:id_ujian AND id_siswa=:id_siswa");
	$stmt->execute(array(":id_soal_es"=>$id_soal_es, ":id_ujian"=>$id_ujian, ":id_siswa"=>$id_siswa));
	$editRow=$stmt->fetch(PDO::FETCH_ASSOC);

	if($stmt->rowCount()>0){

		$sql = "UPDATE tbl_jawaban_es SET jawaban='{$jawaban}' WHERE id_soal_es='{$id_soal_es}' AND id_ujian='{$id_ujian}' AND id_siswa='{$id_siswa}'";

		if ($db->prepare($sql)) {
	        if ($db->exec($sql)) {
	            return true;
	            echo "updated";
	        }
	    }
		
		return false;
		
	} else {

		$sql = "INSERT INTO tbl_jawaban_es (id_soal_es, id_ujian, id_siswa, jawaban) VALUES ('{$id_soal_es}', '{$id_ujian}', '{$id_siswa}', '{$jawaban}')";

		if ($db->prepare($sql)) {
	        if ($db->exec($sql)) {
	            return true;
	            echo "inserted";
	        }
	    }
	    return false;

	}

?>