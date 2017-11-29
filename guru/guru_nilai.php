<?php
require('../class/Pdf.php');
require_once "../class/DB.php";


// Instanciation of inherited class
$pdf = new Pdf();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$id_ujian = $_REQUEST['id'];
$jenis_soal = $_REQUEST['slug'];

$query = "SELECT * FROM tbl_nilai INNER JOIN tbl_siswa INNER JOIN tbl_kelas ON
(tbl_nilai.id_siswa=tbl_siswa.id_siswa) AND (tbl_siswa.id_kelas=tbl_kelas.id_kelas) 
WHERE tbl_nilai.id_ujian = {$id_ujian}";
$stmt = $db->prepare($query);
$stmt->execute();

date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d H:i:s');
//Inisiasi untuk membuat header kolom

$column_nis = "";
$column_nama = "";
$column_kelas = "";
$column_nilai = "";

//For each row, add the field to the corresponding column
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{

    $nis = $row["nis"];
    $nama = $row["nama"];
    $kelas = $row["nama_kelas"];
    $nilai = $row["nilai"];
 
    $column_nis = $column_nis.$nis."\n";
    $column_nama = $column_nama.$nama."\n";
    $column_kelas = $column_kelas.$kelas."\n";
    $column_nilai = $column_nilai.$nilai."\n";
    
    

//Create a new PDF file
$pdf = new FPDF('P','mm',array(210,297)); //L For Landscape / P For Portrait
$pdf->AddPage();

//Menambahkan Gambar
//$pdf->Image('../foto/logo.png',10,10,-175);

$pdf->SetFont('Arial','B',13);
$pdf->Cell(80);
$pdf->Cell(30,10,'LAPORAN NILAI UJIAN SISWA',0,0,'C');
$pdf->Ln();
// $pdf->Cell(80);
// $pdf->Cell(30,10,'PT. ',0,0,'C');
// $pdf->Ln();

}

//Fields Name position
$Y_Fields_Name_position = 30;
//Gray color filling each Field Name box
$pdf->SetFillColor(110,180,230);
//Bold Font for Field Name
$pdf->SetFont('Arial','B',10);
$pdf->SetY($Y_Fields_Name_position);
$pdf->SetX(5);
$pdf->Cell(80,8,'TANGGAL : '.$tanggal,1,0,'C',1);
$pdf->SetX(140);
$pdf->Cell(35,8,'JENIS SOAL',1,0,'C',1);
$pdf->SetX(175);
$pdf->Cell(30,8,$jenis_soal,1,0,'C',1);

//Fields Name position
$Y_Fields_Name_position = 40;
//Gray color filling each Field Name box
$pdf->SetFillColor(110,180,230);
//Bold Font for Field Name
$pdf->SetFont('Arial','B',10);
$pdf->SetY($Y_Fields_Name_position);
$pdf->SetX(5);
$pdf->Cell(40,8,'NIS',1,0,'C',1);

$pdf->SetX(45);
$pdf->Cell(90,8,'NAMA SISWA',1,0,'C',1);

$pdf->SetX(135);
$pdf->Cell(30,8,'KELAS',1,0,'C',1);

$pdf->SetX(165);
$pdf->Cell(40,8,'NILAI',1,0,'C',1);

$pdf->Ln();

//Table position, under Fields Name
$Y_Table_Position = 48;

//Now show the columns
$pdf->SetFont('Arial','',10);

$pdf->SetY($Y_Table_Position);
$pdf->SetX(5);
$pdf->MultiCell(40,6,$column_nis,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(45);
$pdf->MultiCell(90,6,$column_nama,1,'L');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(135);
$pdf->MultiCell(30,6,$column_kelas,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(165);
$pdf->MultiCell(40,6,$column_nilai,1,'C');

$pdf->Output();
?>


