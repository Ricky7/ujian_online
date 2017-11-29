-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Sep 16, 2017 at 09:36 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_daniel`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `nama`, `username`, `password`, `role`) VALUES
(1, 'Jackey', 'admin', '$2y$10$CU/8phQfsNRTPldgCuHROekJiopxuxClTKcaTI.ZqCwFwg71jpeWG', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guru`
--

CREATE TABLE `tbl_guru` (
  `id_guru` int(11) NOT NULL,
  `nig` char(12) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_guru`
--

INSERT INTO `tbl_guru` (`id_guru`, `nig`, `nama`, `gender`, `password`, `role`) VALUES
(1, '081112424', 'Ringo', 'L', '$2y$10$EdHjQEwq3J0Dk5ItwF/uTeZ2ZFinYKVLyCb/Q.D0SkoTuauy90ylK', 'Guru'),
(2, '071114545', 'Lamria', 'P', '$2y$10$BRdwSH8QSegjQd0FMfutvOlpLNbcU8DHhogN/fx6w8PjxgSwGBTTa', 'Guru'),
(5, '081117878', 'Januar', 'L', '$2y$10$BRdwSH8QSegjQd0FMfutvOlpLNbcU8DHhogN/fx6w8PjxgSwGBTTa', 'Guru');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jawaban_es`
--

CREATE TABLE `tbl_jawaban_es` (
  `id_jawaban_es` int(11) NOT NULL,
  `id_soal_es` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `jawaban` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jawaban_pg`
--

CREATE TABLE `tbl_jawaban_pg` (
  `id_jawaban_pg` int(11) NOT NULL,
  `id_soal_pg` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `pilihan` varchar(5) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_jawaban_pg`
--

INSERT INTO `tbl_jawaban_pg` (`id_jawaban_pg`, `id_soal_pg`, `id_ujian`, `id_siswa`, `pilihan`, `status`) VALUES
(141, 9, 1, 1, 'pil2', '0'),
(142, 2, 1, 1, 'pil1', '0'),
(143, 25, 1, 1, 'pil4', '0'),
(144, 15, 1, 1, 'pil2', '0'),
(145, 11, 1, 1, 'pil1', '0'),
(146, 26, 1, 1, 'pil3', '0'),
(147, 23, 1, 1, 'pil4', '1'),
(148, 6, 1, 1, 'pil1', '0'),
(149, 16, 1, 1, 'pil2', '0'),
(150, 29, 1, 1, 'pil3', '1'),
(151, 12, 1, 1, 'pil4', '0'),
(152, 5, 1, 1, 'pil1', '0'),
(153, 14, 1, 1, 'pil2', '0'),
(154, 7, 1, 1, 'pil3', '0'),
(155, 31, 1, 1, 'pil4', '0'),
(156, 22, 1, 1, 'pil1', '0'),
(157, 17, 1, 1, 'pil2', '0'),
(158, 20, 1, 1, 'pil3', '1'),
(159, 4, 1, 1, 'pil1', '1'),
(160, 18, 1, 1, 'pil3', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jurusan`
--

CREATE TABLE `tbl_jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_jurusan`
--

INSERT INTO `tbl_jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
(1, 'NONE'),
(2, 'IPA'),
(3, 'IPS');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kelas`
--

CREATE TABLE `tbl_kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_kelas`
--

INSERT INTO `tbl_kelas` (`id_kelas`, `nama_kelas`) VALUES
(1, '1 A'),
(2, '1 B'),
(3, '1 C'),
(4, '1 D'),
(5, '2 IPA'),
(6, '2 IPS'),
(7, '3 IPA'),
(8, '3 IPS');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mapel`
--

CREATE TABLE `tbl_mapel` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_mapel`
--

INSERT INTO `tbl_mapel` (`id_mapel`, `nama_mapel`) VALUES
(1, 'Matematika'),
(2, 'Bahasa Indonesia'),
(3, 'Biologi'),
(5, 'Sejarah');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nilai`
--

CREATE TABLE `tbl_nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `nilai` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_nilai`
--

INSERT INTO `tbl_nilai` (`id_nilai`, `id_ujian`, `id_siswa`, `nilai`) VALUES
(3, 1, 1, 25),
(4, 1, 2, 35),
(10, 5, 1, 60),
(11, 5, 2, 90),
(12, 5, 1, 60);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `id_siswa` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `nis` char(12) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`id_siswa`, `id_kelas`, `id_jurusan`, `nis`, `nama`, `gender`, `password`, `role`) VALUES
(1, 4, 1, '131112020', 'Sardy', 'L', '$2y$10$LEXagzveT/jIUNHlLgIWtuqdiqdCwM2AlvZDomL2XH/YdtjQOjU7G', 'Siswa'),
(2, 4, 1, '131112727', 'Kartika', 'P', '$2y$10$BRdwSH8QSegjQd0FMfutvOlpLNbcU8DHhogN/fx6w8PjxgSwGBTTa', 'Siswa'),
(7, 1, 1, '131113030', 'Suryadi', 'L', '$2y$10$BRdwSH8QSegjQd0FMfutvOlpLNbcU8DHhogN/fx6w8PjxgSwGBTTa', 'Siswa'),
(8, 1, 1, '131113737', 'Mirnasari', 'P', '$2y$10$BRdwSH8QSegjQd0FMfutvOlpLNbcU8DHhogN/fx6w8PjxgSwGBTTa', 'Siswa');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_soal_es`
--

CREATE TABLE `tbl_soal_es` (
  `id_soal_es` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `soal` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_soal_es`
--

INSERT INTO `tbl_soal_es` (`id_soal_es`, `id_ujian`, `soal`) VALUES
(1, 5, 'Suatu penyajian singkat dengan mempertahankan urutan karangan asli disebutâ€¦.'),
(2, 5, 'Teknik membaca yang tepat digunakan untuk mencari entri pada indeks adalahâ€¦.'),
(3, 5, ' Buku yang menghimpun uraian tentang berbagai cabang ilmu atau bidang ilmu tertentu dalam bentuk artikel-artikel terpisah dan biasanya tersusun menurut abjad disebutâ€¦.'),
(4, 5, 'Peristiwa yang melibatkan orang-orang terkenal atau ternama merupakan berita yang menarik. Hal ini berarti ciri berita menonjolkanâ€¦.'),
(5, 5, 'Daftar kata atau istilah penting yang terdapat dalam buku cetakan (biasanya pada bagian akhir buku) disebutâ€¦'),
(6, 5, 'Jelaskan perbedaan antara ringkasan dan ikhtisar!'),
(7, 5, ' Sebutkan dan jelaskan unsur 5W + 1H dalam berita!'),
(8, 5, 'Mengapa kita harus kritis dalam menerima berita?'),
(9, 5, ' Apakah yang dimaksud dengan indeks?'),
(10, 5, 'Sebutkan hal-hal yang perlu diperhatikan saat mendengarkan pembacaan berita!'),
(11, 5, 'Sebut dan jelaskan 7 sifat berita!'),
(12, 5, 'Jelaskan pengertian dari berita!'),
(13, 5, 'Sebutkan hal-hal yang perlu diperhatikan dalam membaca memindai atau scanning!'),
(14, 5, 'Jelaskan pengertian dari piramida terbalik dalam sebuah penulisan!'),
(15, 5, 'Jelaskan tujuan penulisan piramida terbalik!!!');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_soal_pg`
--

CREATE TABLE `tbl_soal_pg` (
  `id_soal_pg` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `soal` varchar(100) NOT NULL,
  `pil1` varchar(30) NOT NULL,
  `pil2` varchar(30) NOT NULL,
  `pil3` varchar(30) NOT NULL,
  `pil4` varchar(30) NOT NULL,
  `jawaban` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_soal_pg`
--

INSERT INTO `tbl_soal_pg` (`id_soal_pg`, `id_ujian`, `soal`, `pil1`, `pil2`, `pil3`, `pil4`, `jawaban`) VALUES
(2, 1, 'Berdasarkan letak kalimat utama, paragraph di atas merupakan paragrafâ€¦', 'Induktif', 'Deduktif', 'Campuran', 'Naratif', 'pil3'),
(3, 1, 'Sudut pandang pada cuplikan cerita di atas adalahâ€¦', 'Orang pertama tokoh utama', 'Orang pertama tokoh utama', 'Orang pertama tokoh utama', 'Orang pertama tokoh utama', 'pil3'),
(4, 1, 'Dari kutipan cerita di atas, Baik Hati memiliki sifat-sifat berikut ini, kecualiâ€¦', 'sabar', 'suka menolong', 'kreatif', 'rajin', 'pil1'),
(5, 1, ' Hal yang tercantum dalam ruang lingkup proposal adalahâ€¦', 'Pihak yang bisa memperoleh man', 'Pihak penyelenggara kegiatan', 'Pihak pendukung kegiatan', 'Pihak sponsor', 'pil4'),
(6, 1, 'Berdasarkan penggalan naskah di atas, Yanti bersifatâ€¦', 'Sabar', 'Pendiam', 'Mudah tersinggung', 'Pendendam', 'pil2'),
(7, 1, 'Latar tempat pada cuplikan naskah di atas adalahâ€¦', 'Ruang kelas', 'Pekarangan rumah', ' Halaman sekolah', 'Taman kota', 'pil2'),
(8, 1, 'Latar waktu yang sesuai untuk penggalan cerita tersebut adalahâ€¦', 'Pagi hari, sebelum bel masuk b', 'Pagi hari, setelah bel masuk b', 'Siang hari, waktu istirahat', 'Siang hari, pulang sekolah', 'pil3'),
(9, 1, 'Berdasarkan penggalan naskah di atas, Yanti dan Santiâ€¦', 'Merupakah sahabat dekat', 'Saling memusuhi', 'Kurang akrab', 'Suka menolong satu sama lain', 'pil3'),
(10, 1, 'Yang menjadi tokoh tritagonis pada penggalan naskah di atasâ€¦', 'Yanti', 'Santi', 'Ana', 'Yanti dan Santi', 'pil2'),
(11, 1, 'Suasana yang terbentuk ada penggalan naskah di atasâ€¦', 'Seram', 'Tegang', 'Ramai', 'Hening', 'pil2'),
(12, 1, 'Wawancara mengapa pada proses ....', 'Dialog', 'Surat-suratan', ' Teks', 'Radio', 'pil2'),
(13, 1, 'Keterangan atau laporan mengenai kejadian atau peristiwa yang hangat disebut dengan ....', 'Resensi', 'Berita', 'Wawancara', 'Gagasan utama', 'pil3'),
(14, 1, 'Tulisan, ulasan/ timbangan mengenai nilai sebuah buku atau hasil karya disebut dengan ....', 'Resensi', 'Berita', 'Wawancara', 'Topik', 'pil3'),
(15, 1, 'Surat resmi yang dikeluarkan oleh instansi pemerintahan adalah surat ....', 'Dinas', 'Niaga ', 'Sosial', 'Kuasa', 'pil1'),
(16, 1, 'Surat resmi yang digunakan oleh perusahaan atau badan usaha termasuk surat ....', 'Dinas', 'Sosial', 'Kuasa', 'Umum', 'pil4'),
(17, 1, 'Surat yang digunakan untuk organisasi kemasyarakatan adalah surat ....', 'Dinas', 'Pribadi', 'Kuasa', 'Sosial', 'pil3'),
(18, 1, 'Jenis karangan yang menceritakan rangkaian peristiwa atau pengalaman berdasarkan waktu disebut karan', 'Narasi', 'Deskripsi', 'Eksposisi', 'Argumentasi', 'pil3'),
(19, 1, 'Jenis karangan yang melukiskan atau menggambarkan suatu objek apa adanya adalah karangan ....', 'Narasi', 'Deskripsi', 'Eksposisi', ' Argumentasi', 'pil3'),
(20, 1, 'Surat yang tidak mempunyai kepala surat adalah surat ....', 'Dinas', 'Pribadi ', 'Kuasa', 'Niaga', 'pil3'),
(21, 1, 'Kata drama berasal dari bahasa ....', 'Jerman', 'Indonesia', 'China', 'Amerika Serikat', 'pil3'),
(22, 1, 'Susunan naskah drama yang benar adalah ....', 'Tokoh, perwatakan, alur, tema', 'Tokoh, alur, perwatakan, tema', 'Alur, tokoh, perwatakan, tema', 'Perwatakan, tokoh, alur, tema', 'pil2'),
(23, 1, 'Sebagai suatu bentuk cerita yang berisi konflik, sikap dan sifat manusia dalam bentuk dialog disebut', 'Wawancara', 'Surat', 'Karangan', 'Drama', 'pil4'),
(24, 1, 'Susunan penulisan membuat kerangka-kerangka adalah ....', 'Pendahuluan, pembahasan, penut', 'Pembahasan, pendahuluan, penut', 'Penutup, pendahuluan, pembahas', 'Pembahasan, penutup, pendahulu', 'pil2'),
(25, 1, 'Kalimat yang tidak mempunyai kemungkinan banyak tafsir adalah kalimat ....', ' Induktif', 'Deduktif', 'Campuran', 'Pasif', 'pil2'),
(26, 1, 'Kalimat yang berupa gagasan utama atau inti kalimat yaitu ....', 'Utama', 'Induktif', 'Deduktif', 'Ambigu', 'pil2'),
(27, 1, 'Kalimat yang berisi gagasan pendukung yang berupa pengulangan dan fakta-fakta adalah ....', 'Utama', 'Induktif', 'Penjelas', 'Deduktif', 'pil2'),
(28, 1, 'Surat yang berisi pelimpahan kewenangan dari pemberi kuasa adalah surat ....', 'Dinas ', 'Pribadi', 'Kuasa', 'Niaga', 'pil3'),
(29, 1, 'Jenis karangan yang bertujuan untuk mempengaruhi pembaca dengan bukti-bukti atau alasan adalah ', 'Narasi', 'Deskripsi', 'Eksposisi', 'Argumentasi', 'pil3'),
(30, 1, 'Jenis karangan yang bertujuan menambah pengetahuan pembaca dengan cara memaparkan informasi secara a', 'Narasi', 'Deskripsi', 'Eksposisi', 'Argumentasi', 'pil2'),
(31, 1, 'Jenis karangan yang bertujuan untuk mempengaruhi pembaca dengan bukti-bukti, alasan alasan atau pend', 'Narasi', 'Deduktif', 'Eksposisi', 'Gagasan utama', 'pil2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ujian`
--

CREATE TABLE `tbl_ujian` (
  `id_ujian` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `jumlah_soal` int(100) NOT NULL,
  `jenis_soal` enum('PG','ES') NOT NULL,
  `waktu_selesai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_ujian`
--

INSERT INTO `tbl_ujian` (`id_ujian`, `id_mapel`, `id_kelas`, `id_jurusan`, `id_guru`, `jumlah_soal`, `jenis_soal`, `waktu_selesai`) VALUES
(1, 2, 4, 1, 1, 20, 'PG', NULL),
(2, 3, 1, 1, 5, 20, 'PG', NULL),
(4, 1, 1, 1, 2, 20, 'PG', NULL),
(5, 2, 4, 1, 1, 5, 'ES', 'September 9, 2017 15:00:00'),
(6, 5, 4, 1, 1, 10, 'PG', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `temp_soal`
--

CREATE TABLE `temp_soal` (
  `id_temp_soal` int(11) NOT NULL,
  `id_soal_pg` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_soal`
--

INSERT INTO `temp_soal` (`id_temp_soal`, `id_soal_pg`, `id_ujian`, `id_siswa`) VALUES
(446, 9, 1, 1),
(447, 2, 1, 1),
(448, 25, 1, 1),
(449, 15, 1, 1),
(450, 11, 1, 1),
(451, 26, 1, 1),
(452, 23, 1, 1),
(453, 6, 1, 1),
(454, 16, 1, 1),
(455, 29, 1, 1),
(456, 12, 1, 1),
(457, 5, 1, 1),
(458, 14, 1, 1),
(459, 7, 1, 1),
(460, 31, 1, 1),
(461, 22, 1, 1),
(462, 17, 1, 1),
(463, 20, 1, 1),
(464, 4, 1, 1),
(465, 18, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `nig` (`nig`);

--
-- Indexes for table `tbl_jawaban_es`
--
ALTER TABLE `tbl_jawaban_es`
  ADD PRIMARY KEY (`id_jawaban_es`),
  ADD KEY `id_soal_es` (`id_soal_es`),
  ADD KEY `id_ujian` (`id_ujian`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `tbl_jawaban_pg`
--
ALTER TABLE `tbl_jawaban_pg`
  ADD PRIMARY KEY (`id_jawaban_pg`),
  ADD KEY `id_soal_pg` (`id_soal_pg`),
  ADD KEY `id_ujian` (`id_ujian`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `tbl_jurusan`
--
ALTER TABLE `tbl_jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `tbl_mapel`
--
ALTER TABLE `tbl_mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `tbl_nilai`
--
ALTER TABLE `tbl_nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_ujian` (`id_ujian`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nim` (`nis`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indexes for table `tbl_soal_es`
--
ALTER TABLE `tbl_soal_es`
  ADD PRIMARY KEY (`id_soal_es`),
  ADD KEY `id_ujian` (`id_ujian`);

--
-- Indexes for table `tbl_soal_pg`
--
ALTER TABLE `tbl_soal_pg`
  ADD PRIMARY KEY (`id_soal_pg`),
  ADD KEY `id_ujian` (`id_ujian`);

--
-- Indexes for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  ADD PRIMARY KEY (`id_ujian`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_jurusan` (`id_jurusan`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `temp_soal`
--
ALTER TABLE `temp_soal`
  ADD PRIMARY KEY (`id_temp_soal`),
  ADD KEY `id_soal_pg` (`id_soal_pg`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_ujian` (`id_ujian`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_jawaban_es`
--
ALTER TABLE `tbl_jawaban_es`
  MODIFY `id_jawaban_es` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_jawaban_pg`
--
ALTER TABLE `tbl_jawaban_pg`
  MODIFY `id_jawaban_pg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;
--
-- AUTO_INCREMENT for table `tbl_jurusan`
--
ALTER TABLE `tbl_jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_mapel`
--
ALTER TABLE `tbl_mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_nilai`
--
ALTER TABLE `tbl_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_soal_es`
--
ALTER TABLE `tbl_soal_es`
  MODIFY `id_soal_es` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tbl_soal_pg`
--
ALTER TABLE `tbl_soal_pg`
  MODIFY `id_soal_pg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `temp_soal`
--
ALTER TABLE `temp_soal`
  MODIFY `id_temp_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=471;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD CONSTRAINT `tbl_siswa_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `tbl_jurusan` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_siswa_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_soal_pg`
--
ALTER TABLE `tbl_soal_pg`
  ADD CONSTRAINT `tbl_soal_pg_ibfk_1` FOREIGN KEY (`id_ujian`) REFERENCES `tbl_ujian` (`id_ujian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_ujian`
--
ALTER TABLE `tbl_ujian`
  ADD CONSTRAINT `tbl_ujian_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `tbl_guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_ujian_ibfk_2` FOREIGN KEY (`id_jurusan`) REFERENCES `tbl_jurusan` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_ujian_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_ujian_ibfk_4` FOREIGN KEY (`id_mapel`) REFERENCES `tbl_mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
