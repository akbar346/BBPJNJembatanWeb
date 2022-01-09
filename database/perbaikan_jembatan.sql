-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 09, 2022 at 04:01 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perbaikan_jembatan`
--

-- --------------------------------------------------------

--
-- Table structure for table `c_menu`
--

CREATE TABLE `c_menu` (
  `id_menu` int(6) UNSIGNED NOT NULL,
  `nama_menu` varchar(30) NOT NULL,
  `link_menu` varchar(30) NOT NULL,
  `parent_menu` int(10) NOT NULL,
  `class_icon` varchar(100) NOT NULL,
  `urut` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `c_menu`
--

INSERT INTO `c_menu` (`id_menu`, `nama_menu`, `link_menu`, `parent_menu`, `class_icon`, `urut`) VALUES
(1, 'Dashboard', 'welcome', 0, 'fa fa-dashboard', '10'),
(2, 'Master', '#', 0, 'fa fa-gears', '20'),
(3, 'Jabatan', 'master/jabatan', 2, 'fa fa-shield', '21'),
(4, 'Jenis Kelamin', 'master/jenis_kelamin', 2, 'fa fa-hourglass-start', '22'),
(5, 'Satker', 'master/satker', 2, 'fa fa-archive', '23'),
(6, 'PPK', 'master/ppk', 2, 'fa fa-calculator', '24'),
(7, 'User', 'master/user', 2, 'fa fa-users', '25'),
(8, 'Menu Akses', 'master/akses', 2, 'fa fa-list', '26'),
(9, 'Master Kerusakan', '#', 0, 'fa fa-exchange', '30'),
(10, 'Kategori Kerusakan', 'kerusakan/kategori', 9, 'fa fa-exclamation', '31'),
(11, 'Jenis Kerusakan dan Perbaikan', 'kerusakan/perbaikan', 9, 'fa fa-eyedropper', '32'),
(12, 'Tingkat Kerusakan', 'kerusakan/tingkat', 0, 'fa fa-check', '33'),
(13, 'Kerusakan Jembatan', '#', 0, 'fa fa-file', '40'),
(14, 'Daftar Kerusakan', 'kerusakan/daftar', 13, 'fa fa-pencil', '41'),
(15, 'Histori Kerusakan', 'kerusakan/histori', 13, 'fa fa-road', '42'),
(16, 'Laporan Kerusakan', 'kerusakan/laporan', 13, 'fa fa-print', '43');

-- --------------------------------------------------------

--
-- Table structure for table `m_jabatan`
--

CREATE TABLE `m_jabatan` (
  `id_jabatan` int(6) UNSIGNED NOT NULL,
  `nama_jabatan` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_jabatan`
--

INSERT INTO `m_jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'Satker'),
(4, 'PPK'),
(5, 'Penilik'),
(6, 'Magang');

-- --------------------------------------------------------

--
-- Table structure for table `m_jenis_kelamin`
--

CREATE TABLE `m_jenis_kelamin` (
  `id_jenis_kelamin` int(6) UNSIGNED NOT NULL,
  `nama_jenis_kelamin` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_jenis_kelamin`
--

INSERT INTO `m_jenis_kelamin` (`id_jenis_kelamin`, `nama_jenis_kelamin`) VALUES
(1, 'Laki - Laki'),
(2, 'Perempuan');

-- --------------------------------------------------------

--
-- Table structure for table `m_kategori`
--

CREATE TABLE `m_kategori` (
  `id_kategori` int(6) UNSIGNED NOT NULL,
  `kode_kategori` varchar(100) NOT NULL,
  `nama_kategori` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_kategori`
--

INSERT INTO `m_kategori` (`id_kategori`, `kode_kategori`, `nama_kategori`) VALUES
(9, '800', 'Jembatan');

-- --------------------------------------------------------

--
-- Table structure for table `m_perbaikan`
--

CREATE TABLE `m_perbaikan` (
  `id_perbaikan` int(6) UNSIGNED NOT NULL,
  `kode_kerusakan` varchar(50) NOT NULL,
  `nama_kerusakan` varchar(200) NOT NULL,
  `id_kategori` int(6) UNSIGNED DEFAULT NULL,
  `ket_perbaikan` text NOT NULL,
  `marker` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_perbaikan`
--

INSERT INTO `m_perbaikan` (`id_perbaikan`, `kode_kerusakan`, `nama_kerusakan`, `id_kategori`, `ket_perbaikan`, `marker`) VALUES
(70, '811', 'Dek Berpasir', 9, 'Pembersihan Landasan Jembatan', '1546319586012.png'),
(71, '812', 'Pagar Yang Pudar', 9, 'Pengecetan Pagar atau Railing', '1546320067009.png'),
(72, '813', 'Penurunan Oprit', 9, 'Perataan Oprit', '1546320491534.png');

-- --------------------------------------------------------

--
-- Table structure for table `m_ppk`
--

CREATE TABLE `m_ppk` (
  `id_ppk` int(6) UNSIGNED NOT NULL,
  `kode_ppk` varchar(50) NOT NULL,
  `nama_ppk` varchar(200) NOT NULL,
  `id_satker` int(10) UNSIGNED NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_ppk`
--

INSERT INTO `m_ppk` (`id_ppk`, `kode_ppk`, `nama_ppk`, `id_satker`, `alamat`, `no_telp`) VALUES
(1, '001', 'PPK Tata Usaha', 12, '-', '-'),
(2, '002', 'PPK SMKS Suramadu', 12, '-', '-'),
(3, '003', 'PPK Pembangunan dan Pengujian', 12, '-', '-'),
(4, '004', 'PPK Preservasi dan Peralatan I', 12, '-', '-'),
(5, '005', 'PPK Preservasi dan Peralatan II', 12, '-', '-'),
(6, '006', 'PPK SMKS Suramadu', 12, '-', '-'),
(7, '001', 'PPK Perencanaan Jalan Nasional Wilayah Provinsi Bali', 11, 'Jl. Bedahulu No. 39 Denpasar', '0361-8449990'),
(8, '002', 'PPK Pengawasan Jalan Nasional Metropolitan Denpasar', 11, 'Jl. Bedahulu No. 39 Denpasar', '0361-8449990'),
(9, '001', 'PPK SKPD Provinsi Bali', 10, 'Jl. Beliton No.2 Denpasar', '0361-251123'),
(10, '003', 'Mengwitani-Bts Kota Denpasar - Tugu Ngurah Rai - Nusa Dua - Denpasar - Tuban', 9, 'Jl. Ahmad Yani No. 90 Denpasar', '0361 - 263057'),
(11, '004', 'Simpang Dewaruci', 9, 'Jl. Ahmad Yani No. 90 Denpasar', '0361 - 263057'),
(12, '002', 'Simpang Sanur - Simpang Tohpati - Sakah', 9, 'Jl. Ahmad Yani No. 90 Denpasar', '0361- 263057'),
(13, '001', 'Tabanan - Mengwitani - Singaraja - Dalam Kota Singaraja', 9, 'Jl. Ahmad Yani No. 90 Denpasar', '0361 - 263057'),
(14, '001', 'Singaraja - Kubutambahan - Amlapura', 8, 'Jl. Ahmad Yani No. 90 Denpasar', '0361 - 228961'),
(15, '002', 'Angentelu - Padang Bai - Blahbatu - Semebaung - Ciungwanara', 8, 'Jl. Ahmad Yani No. 90 Denpasar', '0361 - 228961'),
(16, '001', 'Gilimanuk - Cekik - Seririt - Bts Singaraja', 7, 'Jl. Ahmad Yani No.90 Denpasar', '0361 - 262590'),
(17, '002', 'Cekik - Bts Kota Negara - Antosari - Tabanan - Pekutatan', 7, 'Jl. Ahmad Yani No. 90 Denpasar', '0361 - 262590'),
(18, '001', 'Sidoarjo - Pandaan - Purwosari - Malang - Kepanjen', 1, 'Jl. Kebalen Wetan No.5 Malang', '0341-361603'),
(19, '002', 'Gempol - Bangil - Pasuruan - Probolinggo', 1, 'Jl. Mojopahit No.2 Sidoarjo', '031-8944962'),
(20, '003', 'Probolinggo - Paiton - Situbondo', 1, 'Jl. PB. Sudirman No.23 Probolinggo', '0335-428673'),
(21, '004', 'Situbondo - Ketapang - Banyuwangi', 1, 'Jl. Melati Gg. Kharisma No.15 D Situbondo', '0338-672696'),
(22, '005', 'Jolosutro - Kedungsalam - Balekambang - Sendangbiru', 1, 'Jl. Lebaksari 10/40 Malang ', '0341-400266'),
(23, '006', 'Sendangbiru - Jarit - Puger - Glenmore', 1, 'Jl. Teluk Etna Kav.111 Arjosari - Malang', '0341-488821'),
(24, '001', 'Mantingan - Ngawi - Maospati - Madiun -Ponorogo - Madiun - Caruban', 2, 'Jl. Pahlawan No.35 Madiun', '0351-462826'),
(25, '002', 'Ngawi - Caruban - Nganjuk - Kertosono', 2, 'Jl. Panglima Sudirman No. 187 Nganjuk', '0358-326310'),
(26, '003', 'Kertosono - Kediri - Tulungagung - Bts. Kab. Trenggalek', 2, 'Jl. Jaksa Agung Suprapto No.43 Kediri', '0354-771341'),
(27, '004', 'Glonggong - Pacitan - Hadiwarno - Bts. Kab. Trenggalek', 2, 'Jl. Marsda Iswahyudi No.2 Pacitan', '0357-885429'),
(28, '005', 'Bts. Kab. Pacitan - Jarakan - Trenggalek - Ponorogo - Dengok - Bts. Ponorogo', 2, 'Jl. Gatot Subroto No.33 Trenggalek', '0355-796025'),
(29, '006', 'Popoh - Prigi - Panggul', 2, 'Jl. Basuki Rachmad I/1 Tulungagung', '0355-332538'),
(30, '001', 'Sadang - Gresik - Arteri Tengah Surabaya - Arteri Timur Surabaya', 3, 'Jl. Raya Waru No.20 Sidoarjo', '031-8554071'),
(31, '002', 'PPK Arteri Barat Surabaya - Arteri Utara Surabaya - Legundi - Bunder - Sidoarjo', 3, 'Jl. Raya Waru No.20 Sidoarjo', '-'),
(32, '003', 'PPK Surabaya - Waru', 3, '-', '-'),
(33, '004', 'Kamal - Bangkalan - Kota Sampang', 3, '-', '-'),
(34, '005', 'Sampang - Pamekasan - Sumenep', 3, '-', '-'),
(35, '006', 'Tanjung Bumi - Pamekasan - Sumenep', 3, '-', '-'),
(36, '001', 'Bulu - Tuban - Sadang', 4, 'Jl. Veteran No.29 Tuban', '0356-332273'),
(37, '002', 'Tuban - Babat - Lamongan - Gresik', 4, 'Jl. Panglima Sudirman No.37 Sukodadi Lamongan', '0322-392743'),
(38, '003', 'Babat - Bojonegoro - Bts. Kota Ngawi', 4, 'Jl. Ahmad Yani No.84 Padangan Bojonegoro', '0353-551655'),
(39, '004', 'Kertosono - Jombang - Mojokerto - Gempol', 4, 'Jl. Terusan No.23 Mojokerto', '0321-362268'),
(40, '001', 'Perencanaan Jalan Nasional Provinsi Jawa Timur', 5, 'Jl. Raya Waru No. 20 Sidoarjo', '031 - 8550776'),
(41, '002', 'Pengawasan Jalan Nasional Provinsi Jawa Timur', 5, 'Jl. Raya Waru No. 20 Sidoarjo', '031 - 8550776'),
(42, '001', 'PPK S 01 Probolinggo - Lumajang - Turen', 6, 'Jl. Raya Bromo No.32 Ketapang, Probolingo', '-'),
(43, '002', 'PPK S 02 Bts Kab. Jember - Gentengkulon - Banyuwangi', 6, 'Jl. Yos Sudarso 68 Sukowidi, Klatak, Banyuwangi', '-'),
(44, '003', 'PPK S 03 Wonorejo - Jember - Bts. Kab. Banyuwangi', 6, 'Jln Jurusan Tanggul - Jember Km. Sbaya 181-000 Ds Tisnogambar Kecamatan Bangsalsari, Jember', '-'),
(45, '004', 'PPK S 04 Kepanjen - Blitar - Tulungagung', 6, 'Jln. Wahidin No. 16 Blitar', '');

-- --------------------------------------------------------

--
-- Table structure for table `m_satker`
--

CREATE TABLE `m_satker` (
  `id_satker` int(6) UNSIGNED NOT NULL,
  `kode_satker` varchar(50) NOT NULL,
  `nama_satker` varchar(200) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_satker`
--

INSERT INTO `m_satker` (`id_satker`, `kode_satker`, `nama_satker`, `alamat`, `no_telp`) VALUES
(1, 'J001', 'Satker Pelaksanaan Jalan Nasional Wilayah I Prov. Jawa Timur', 'Jalan Gayung Kebonsari No.40', '031-8286576'),
(2, 'J002', 'Satker Pelaksanaan Jalan Nasional Wilayah II Prov. Jawa Timur', 'Jalan Raya Waru No.20 Sidoarjo', '031-8546644'),
(3, 'J003', 'Satker Pelaksanaan Jalan Nasional Metropolitan I Surabaya', 'Jalan Gayung Kebonsari No.40 Surabaya', '031-8280933'),
(4, 'J004', 'Satker Pelaksanaan Jalan Nasional Metropolitan II Surabaya', 'Jalan Raya Waru No.20 Sidoarjo', '031-8554071'),
(5, 'J005', 'Satker Perencanaan dan Pengawasan Jalan Nasional Prov. Jatim', 'Jalan Raya Waru No.20 Sidoarjo', '031-8550776'),
(6, 'J006', 'SKPD-TP Dinas Bina Marga Provinsi Jawa Timur', 'Jalan Raya Waru No.20 Sidoarjo', '031-8550776'),
(7, 'B001', 'Satker Pelaksanaan Jalan Nasional Wilayah I Provinsi Bali', 'Jl. Ahmad Yani No. 90 Denpasar', '0361 - 262590'),
(8, 'B002', 'Satker Pelaksanaan Jalan Nasional Wilayah II Provinsi Bali', 'Jl. Ahmad Yani No. 90 Denpasar', '0361 - 228961'),
(9, 'B003', 'Satker Pelaksanaan Jalan Nasional Metropolitan Denpasar', 'Jl. Ahmad Yani No. 90 Denpasar', '0361 - 263057'),
(10, 'B004', 'Satker SKPD Provinsi Bali', 'Jl. Beliton No.2 Denpasar', '0361-251123'),
(11, 'B005', 'Satker Perencanaan dan Pengawasan Jalan Nasional Provinsi Bali', 'Jl. Bedahulu No. 39 Denpasar', '0361-8449990'),
(12, 'P001', 'Satker Balai Besar Pelaksanaan Jalan Nasional VIII', 'Jl. Raya Waru No. 20, Sidoarjo Jawa Timur', '08113131818');

-- --------------------------------------------------------

--
-- Table structure for table `m_status`
--

CREATE TABLE `m_status` (
  `id_status` int(6) UNSIGNED NOT NULL,
  `nama_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_status`
--

INSERT INTO `m_status` (`id_status`, `nama_status`) VALUES
(1, 'Data Baru'),
(2, 'Proses Perbaikan'),
(3, 'Perbaikan Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `m_tingkat`
--

CREATE TABLE `m_tingkat` (
  `id_tingkat` int(6) UNSIGNED NOT NULL,
  `nama_tingkat` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_tingkat`
--

INSERT INTO `m_tingkat` (`id_tingkat`, `nama_tingkat`) VALUES
(1, 'Rendah'),
(2, 'Sedang'),
(3, 'Tinggi');

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE `m_user` (
  `id_user` int(6) UNSIGNED NOT NULL,
  `nama_lengkap` text NOT NULL,
  `nip` varchar(50) NOT NULL,
  `passwd` varchar(250) NOT NULL,
  `id_jabatan` int(10) UNSIGNED NOT NULL,
  `email` varchar(200) NOT NULL,
  `no_hp` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `foto` varchar(250) NOT NULL,
  `id_jenis_kelamin` int(10) UNSIGNED NOT NULL,
  `tmp_lahir` varchar(30) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `id_satker` int(10) UNSIGNED DEFAULT NULL,
  `id_ppk` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`id_user`, `nama_lengkap`, `nip`, `passwd`, `id_jabatan`, `email`, `no_hp`, `status`, `foto`, `id_jenis_kelamin`, `tmp_lahir`, `tgl_lahir`, `alamat`, `id_satker`, `id_ppk`) VALUES
(1, 'Super Admin', '123456', 'e10adc3949ba59abbe56e057f20f883e', 1, 'sipekerja@binamarga.pu.go.id', '085646409494', 1, '1_Profil.png', 1, 'Sidoarjo', '1990-01-01', 'Sidoarjo', NULL, NULL),
(2, 'Satker 1', 'satker1', 'e10adc3949ba59abbe56e057f20f883e', 3, 'satker1@gmail.com', '088252552', 1, '2_Profil.jpeg', 1, 'Surabaya', '1999-06-09', 'Jl. Satker', 12, 1),
(3, 'PPK 1', 'ppk1', 'e10adc3949ba59abbe56e057f20f883e', 4, 'ppk1@gmail.com', '0829752852', 1, '_Profil.jpeg', 1, 'Surabaya', '1999-01-09', 'Jl. Surabaya', 12, 1),
(4, 'Penilik 1', 'penilik1', 'e10adc3949ba59abbe56e057f20f883e', 5, 'penilik1@gmail.com', '0829572525', 1, '2_Profil.jpeg', 1, 'Surabaya', '2008-01-09', 'Jl. Percobaan', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_kerusakan`
--

CREATE TABLE `t_kerusakan` (
  `id_kerusakan` int(6) UNSIGNED NOT NULL,
  `tgl_ins` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `id_perbaikan` int(10) UNSIGNED NOT NULL,
  `id_tingkat` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `gambar_1` varchar(250) NOT NULL,
  `gambar_2` varchar(250) NOT NULL,
  `tgl_pengecekan` timestamp NOT NULL DEFAULT current_timestamp(),
  `detail_kerusakan` text NOT NULL,
  `status` int(10) UNSIGNED NOT NULL,
  `id_user_proses` int(10) UNSIGNED DEFAULT NULL,
  `gambar_proses_1` varchar(250) DEFAULT NULL,
  `gambar_proses_2` varchar(250) DEFAULT NULL,
  `tgl_proses` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_user_selesai` int(10) UNSIGNED DEFAULT NULL,
  `gambar_selesai_1` varchar(250) DEFAULT NULL,
  `gambar_selesai_2` varchar(250) DEFAULT NULL,
  `tgl_selesai` timestamp NOT NULL DEFAULT current_timestamp(),
  `lat` varchar(250) NOT NULL,
  `lng` varchar(250) NOT NULL,
  `id_satker` int(10) UNSIGNED NOT NULL,
  `id_ppk` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t_menu_user`
--

CREATE TABLE `t_menu_user` (
  `id_menu_user` int(6) UNSIGNED NOT NULL,
  `id_menu` int(10) UNSIGNED NOT NULL,
  `id_jabatan` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_menu_user`
--

INSERT INTO `t_menu_user` (`id_menu_user`, `id_menu`, `id_jabatan`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `c_menu`
--
ALTER TABLE `c_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `m_jabatan`
--
ALTER TABLE `m_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `m_jenis_kelamin`
--
ALTER TABLE `m_jenis_kelamin`
  ADD PRIMARY KEY (`id_jenis_kelamin`);

--
-- Indexes for table `m_kategori`
--
ALTER TABLE `m_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `m_perbaikan`
--
ALTER TABLE `m_perbaikan`
  ADD PRIMARY KEY (`id_perbaikan`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `m_ppk`
--
ALTER TABLE `m_ppk`
  ADD PRIMARY KEY (`id_ppk`),
  ADD KEY `id_satker` (`id_satker`);

--
-- Indexes for table `m_satker`
--
ALTER TABLE `m_satker`
  ADD PRIMARY KEY (`id_satker`);

--
-- Indexes for table `m_status`
--
ALTER TABLE `m_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `m_tingkat`
--
ALTER TABLE `m_tingkat`
  ADD PRIMARY KEY (`id_tingkat`);

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_jabatan` (`id_jabatan`),
  ADD KEY `id_jenis_kelamin` (`id_jenis_kelamin`),
  ADD KEY `id_satker` (`id_satker`),
  ADD KEY `id_ppk` (`id_ppk`);

--
-- Indexes for table `t_kerusakan`
--
ALTER TABLE `t_kerusakan`
  ADD PRIMARY KEY (`id_kerusakan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_perbaikan` (`id_perbaikan`),
  ADD KEY `id_tingkat` (`id_tingkat`),
  ADD KEY `id_user_proses` (`id_user_proses`),
  ADD KEY `id_user_selesai` (`id_user_selesai`),
  ADD KEY `id_ppk` (`id_ppk`),
  ADD KEY `id_satker` (`id_satker`);

--
-- Indexes for table `t_menu_user`
--
ALTER TABLE `t_menu_user`
  ADD PRIMARY KEY (`id_menu_user`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `c_menu`
--
ALTER TABLE `c_menu`
  MODIFY `id_menu` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `m_jabatan`
--
ALTER TABLE `m_jabatan`
  MODIFY `id_jabatan` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `m_jenis_kelamin`
--
ALTER TABLE `m_jenis_kelamin`
  MODIFY `id_jenis_kelamin` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_kategori`
--
ALTER TABLE `m_kategori`
  MODIFY `id_kategori` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `m_perbaikan`
--
ALTER TABLE `m_perbaikan`
  MODIFY `id_perbaikan` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `m_ppk`
--
ALTER TABLE `m_ppk`
  MODIFY `id_ppk` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `m_satker`
--
ALTER TABLE `m_satker`
  MODIFY `id_satker` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `m_status`
--
ALTER TABLE `m_status`
  MODIFY `id_status` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_tingkat`
--
ALTER TABLE `m_tingkat`
  MODIFY `id_tingkat` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_user`
--
ALTER TABLE `m_user`
  MODIFY `id_user` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_kerusakan`
--
ALTER TABLE `t_kerusakan`
  MODIFY `id_kerusakan` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_menu_user`
--
ALTER TABLE `t_menu_user`
  MODIFY `id_menu_user` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_perbaikan`
--
ALTER TABLE `m_perbaikan`
  ADD CONSTRAINT `m_perbaikan_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `m_kategori` (`id_kategori`);

--
-- Constraints for table `m_ppk`
--
ALTER TABLE `m_ppk`
  ADD CONSTRAINT `m_ppk_ibfk_1` FOREIGN KEY (`id_satker`) REFERENCES `m_satker` (`id_satker`);

--
-- Constraints for table `m_user`
--
ALTER TABLE `m_user`
  ADD CONSTRAINT `m_user_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `m_jabatan` (`id_jabatan`),
  ADD CONSTRAINT `m_user_ibfk_2` FOREIGN KEY (`id_jenis_kelamin`) REFERENCES `m_jenis_kelamin` (`id_jenis_kelamin`),
  ADD CONSTRAINT `m_user_ibfk_3` FOREIGN KEY (`id_satker`) REFERENCES `m_satker` (`id_satker`),
  ADD CONSTRAINT `m_user_ibfk_4` FOREIGN KEY (`id_ppk`) REFERENCES `m_ppk` (`id_ppk`);

--
-- Constraints for table `t_kerusakan`
--
ALTER TABLE `t_kerusakan`
  ADD CONSTRAINT `t_kerusakan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `m_user` (`id_user`),
  ADD CONSTRAINT `t_kerusakan_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `m_kategori` (`id_kategori`),
  ADD CONSTRAINT `t_kerusakan_ibfk_3` FOREIGN KEY (`id_perbaikan`) REFERENCES `m_perbaikan` (`id_perbaikan`),
  ADD CONSTRAINT `t_kerusakan_ibfk_4` FOREIGN KEY (`id_tingkat`) REFERENCES `m_tingkat` (`id_tingkat`),
  ADD CONSTRAINT `t_kerusakan_ibfk_5` FOREIGN KEY (`id_user_proses`) REFERENCES `m_user` (`id_user`),
  ADD CONSTRAINT `t_kerusakan_ibfk_6` FOREIGN KEY (`id_user_selesai`) REFERENCES `m_user` (`id_user`),
  ADD CONSTRAINT `t_kerusakan_ibfk_7` FOREIGN KEY (`id_ppk`) REFERENCES `m_ppk` (`id_ppk`),
  ADD CONSTRAINT `t_kerusakan_ibfk_8` FOREIGN KEY (`id_satker`) REFERENCES `m_satker` (`id_satker`);

--
-- Constraints for table `t_menu_user`
--
ALTER TABLE `t_menu_user`
  ADD CONSTRAINT `t_menu_user_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `c_menu` (`id_menu`),
  ADD CONSTRAINT `t_menu_user_ibfk_2` FOREIGN KEY (`id_jabatan`) REFERENCES `m_jabatan` (`id_jabatan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
