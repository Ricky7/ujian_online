<?php  
  
    require_once "../class/Siswa.php";
    require_once "../class/DB.php";


  	$siswa = new Siswa($db);
  	$datas = $siswa->getSiswa();

	$siswa->cekLogin();

	if(isset($_REQUEST['id'])) {

		$id_ujian = $_REQUEST['id'];
		$datax = $siswa->getDataByID('tbl_ujian', 'id_ujian', $id_ujian);
		$dataz = $siswa->getAnswerByID($id_ujian, $datas['id_siswa']);
		$datay = $siswa->getCountByID($id_ujian, $datas['id_siswa']);
		$dataw = $siswa->getNilaiByID($id_ujian, $datas['id_siswa']);

	}

	// jika expired & jawaban tidak ada
	if($datay['total'] <= 1) {
		//hapus temp soal
        $siswa->hapusData('temp_soal', $id_ujian, $datas['id_siswa']);
      	//hapus temp jawaban
        $siswa->hapusData('tbl_jawaban_pg', $id_ujian, $datas['id_siswa']);
		header("Location: siswa_menu_ujian.php");
	}

	$j_soal = $datax['jumlah_soal'];
	$nilai;
	if($dataz['total'] <= 0) {
		$nilai = 0; 
	} else {
		$nilai = ($dataz['total']*100) / $j_soal;
	}

	//ambil nilai dari database
	if($dataw['nilai'] == NULL) {
		//jika nilai tidak ada, insert baru
		try {
          $siswa->inputDataArray(array(
          	  'id_ujian' => $id_ujian,
		      'id_siswa' => $datas['id_siswa'],
		      'nilai' => $nilai
		    ), 'tbl_nilai');
          //hapus temp soal
          $siswa->hapusData('temp_soal', $id_ujian, $datas['id_siswa']);
          //hapus temp jawaban
          $siswa->hapusData('tbl_jawaban_pg', $id_ujian, $datas['id_siswa']);
          header("Location: siswa_menu_ujian.php");
        } catch (Exception $e) {
          die($e->getMessage());
        }
	} else {

		try {
          $siswa->updateNilai($nilai, $id_ujian, $datas['id_siswa']);
          //hapus temp soal
          $siswa->hapusData('temp_soal', $id_ujian, $datas['id_siswa']);
          //hapus temp jawaban
          $siswa->hapusData('tbl_jawaban_pg', $id_ujian, $datas['id_siswa']);
          header("Location: siswa_menu_ujian.php");
        } catch (Exception $e) {
          die($e->getMessage());
        }

	}

	

	//jika ada update nilai

	

?>