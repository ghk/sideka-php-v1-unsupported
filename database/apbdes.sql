-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2015 at 09:51 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sideka`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_anggaran`
--

CREATE TABLE IF NOT EXISTS `tbl_anggaran` (
`id_anggaran` int(10) NOT NULL,
  `nomor` varchar(10) NOT NULL,
  `id_apbdes` int(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jumlah` int(30) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `id_parent` int(10) DEFAULT NULL,
  `tipe_apbdes` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=97 ;

--
-- Dumping data for table `tbl_anggaran`
--

INSERT INTO `tbl_anggaran` (`id_anggaran`, `nomor`, `id_apbdes`, `nama`, `jumlah`, `keterangan`, `id_parent`, `tipe_apbdes`) VALUES
(1, '1.1', 1, 'Pendapatan Asli Desa', 0, '', 0, 0),
(2, '1.2', 1, 'Pendapatan Transfer', 1258703660, '', 0, 0),
(3, '1.3', 1, 'Pendapatan Lain lain', 0, '', 0, 0),
(4, '2.1', 1, 'Bidang penyelenggaraan Pemerintahan Desa', 323635139, '', 0, 1),
(5, '2.2', 1, 'Bidang Pelaksanaan Pembangunan Desa', 470790000, '', 0, 1),
(6, '2.3', 1, 'Bidang Pembinaan Kemasyarakatan', 398600000, '', 0, 1),
(7, '2.4', 1, 'Bidang Pemberdayaan Masyarakat', 102529863, '', 0, 1),
(12, '1.1.1', 1, 'Hasil Usaha Desa', 0, '', 1, 0),
(13, '1.1.2', 1, 'Hasil Swadaya & Partisipasi Masyarakat dan Gotong Royong', 0, '', 1, 0),
(14, '1.1.3', 1, 'Lain-lain Pendapatan Asli Desa yang sah', 0, '', 1, 0),
(15, '1.2.1', 1, 'Bagian Dana Perimbangan Keuangan Pusat/ Dana Desa ( DD )', 302757669, '', 2, 0),
(16, '1.2.2', 1, 'Bagi hasil dari  Pajak & Retribusi Daerah Kabupaten', 0, '', 2, 0),
(17, '1.2.3', 1, 'Bagian Dana Perimbangan Daerah/ Alokasi Dana Desa (ADD)', 955945991, '', 2, 0),
(18, '1.2.4', 1, 'Bantuan Keuangan', 0, '', 2, 0),
(19, '1.2.4.1', 1, 'Bantuan Keuangan Provinsi', 0, '', 18, 0),
(20, '1.2.4.2', 1, 'Bantuan Keuangan Kabupaten', 0, '', 18, 0),
(21, '1.3.1', 1, 'Hibah ', 0, '', 3, 0),
(22, '1.3.2', 1, 'Sumbangan Pihak Ketiga Yang Tidak Mengikat', 0, '', 3, 0),
(23, '2.1.1', 1, 'Penghasilan Tetap & Tunjangan :', 237600000, '', 4, 1),
(24, '2.1.1.1', 1, 'Belanja Pegawai', 237600000, '', 23, 1),
(25, '2.1.1.1.1', 1, 'Penghasilan Tetap Kepala Desa dan Perangkat Desa', 176400000, '', 24, 1),
(26, '2.1.1.1.2', 1, 'Tunjangan Kepala Desa dan Perangkat Desa', 12000000, '', 24, 1),
(27, '2.1.1.1.3', 1, 'Tunjangan Badan Permusyawatan Desa ( BPD )', 49200000, '', 24, 1),
(28, '2.1.2', 1, 'Operasional Perkantoran :', 71695949, '', 4, 1),
(29, '2.1.2.1', 1, 'Belanja Barang dan Jasa', 58145949, '', 28, 1),
(30, '2.1.2.1.1', 1, 'Insentif Ketua RT/RW', 0, '', 29, 1),
(31, '2.1.2.1.2', 1, 'Alat Tulis Kantor ( ATK )', 25000000, '', 29, 1),
(32, '2.1.2.1.3', 1, 'Benda Pos ( Materai )', 560000, '', 29, 1),
(33, '2.1.2.1.4', 1, 'Pakaian Dinas dan Atribut', 5600000, '', 29, 1),
(34, '2.1.2.1.5', 1, 'Belanja Foto Copy dan Penjilidtan', 2000000, '', 29, 1),
(35, '2.1.2.1.6', 1, 'Belanja makan & Minum Rapat Desa', 2000000, '', 29, 1),
(36, '2.1.2.1.7', 1, 'Alat dan Bahan Kebersihan', 0, '', 29, 1),
(37, '2.1.2.1.8', 1, 'Perjalanan Dinas Luar dan Dalam Daerah', 6000000, '', 29, 1),
(38, '2.1.2.1.9', 1, 'Pemeliharaan', 0, '', 29, 1),
(39, '2.1.2.1.10', 1, 'Air, Listrik dan Telepon', 4985949, '', 29, 1),
(40, '2.1.2.1.11', 1, 'Honor ( Petugas Kebersihan Kantor )', 12000000, '', 29, 1),
(41, '2.1.2.2', 1, 'Belanja Modal', 13550000, '', 28, 1),
(42, '2.1.2.2.1', 1, 'Komputer', 5000000, '', 41, 1),
(43, '2.1.2.2.2', 1, 'Laptop', 7000000, '', 41, 1),
(44, '2.1.2.2.3', 1, 'Printer', 1550000, '', 41, 1),
(45, '2.1.2.2.4', 1, 'Mesin TIK', 0, '', 41, 1),
(46, '2.1.2.2.5', 1, 'Meja dan Kursi', 0, '', 41, 1),
(47, '2.1.3', 1, 'Operasional RT/RW', 0, '', 4, 1),
(48, '2.1.3.1', 1, 'Belanja Barang dan Jasa', 0, '', 47, 1),
(49, '2.1.3.1.1', 1, 'Alat Tulis Kantor ( ATK )', 0, '', 48, 1),
(50, '2.1.3.1.2', 1, 'Pengadaan', 0, '', 48, 1),
(51, '2.1.3.1.3', 1, 'Konsumsi Rapat', 0, '', 48, 1),
(52, '2.1.4', 1, 'Belanja Honorarium Sidang/Rapat BPD :', 14339190, '', 4, 1),
(53, '2.1.4.1', 1, 'Belanja Barang dan Jasa', 14339190, '', 52, 1),
(54, '2.1.4.1.1', 1, 'Honororarium Sidang/Rapat', 0, '', 53, 1),
(55, '2.1.4.1.1', 1, 'Honororarium Sidang/Rapat', 3500000, '', 53, 1),
(56, '2.1.4.1.2', 1, 'Alat Tulis Kantor ( ATK )', 5000000, '', 53, 1),
(57, '2.1.4.1.3', 1, 'Foto Copy/Cetak', 1039190, '', 53, 1),
(58, '2.1.4.1.4', 1, 'Konsumsi Rapat', 4800000, '', 53, 1),
(59, '2.2.1', 1, 'Pagar Sekolah TKN 001', 25000000, '', 5, 1),
(60, '2.2.2', 1, 'Lapangan volley Sekolah', 25000000, '', 5, 1),
(61, '2.2.3', 1, 'Normalisasi Aliran Air Dalam Desa', 50000000, '', 5, 1),
(62, '2.2.4', 1, 'Semenisasi Jln Lapangan Sepak Bola RW.001', 19750000, '', 5, 1),
(63, '2.2.5', 1, 'Balai RW.002', 49645000, '', 5, 1),
(64, '2.2.6', 1, 'Siring Jalan RW.003 ', 40000000, '', 5, 1),
(65, '2.2.7', 1, 'Balai RW.004', 49645000, '', 5, 1),
(66, '2.2.8', 1, 'Pembangunan Poskamling RW.005 ', 21000000, '', 5, 1),
(67, '2.2.9', 1, 'Semenisasi RW.006 ', 19750000, '', 5, 1),
(68, '2.2.10', 1, 'Peningkatan Lapangan Sepak Bola', 20000000, '', 5, 1),
(69, '2.2.11', 1, 'Pemeliharaan Jalan Dalam Desa', 100000000, '', 5, 1),
(70, '2.2.12', 1, 'Pengadaan Hadrah', 21000000, '', 5, 1),
(71, '2.2.13', 1, 'Pos Keamanan Pasar Desa', 15000000, '', 5, 1),
(72, '2.2.15', 1, 'Pemb. Pondok Pertanian', 15000000, '', 5, 1),
(73, '2.3.1', 1, 'Insentif', 270000000, '', 6, 1),
(74, '2.3.1.1', 1, 'Insentif Ketua RT/RW', 234000000, '', 73, 1),
(75, '2.3.1.2', 1, 'Insentif Petugas Keamanan Desa', 36000000, '', 73, 1),
(76, '2.3.2', 1, 'Belanja Bantuan Sosial', 128600000, '', 6, 1),
(77, '2.3.2.1', 1, 'Belanja BANSOS Dalam Bentuk Uang', 30000000, '', 76, 1),
(78, '2.3.2.1.1', 1, 'Belanja Bantuan LPTQ', 5000000, '', 77, 1),
(79, '2.3.2.1.2', 1, 'Belanja Bantuan Madrasah Diniah NuruL Hikmah', 10000000, '', 77, 1),
(80, '2.3.2.1.3', 1, 'Belanja Bantuan Kesenian Daerah', 15000000, '', 77, 1),
(81, '2.3.2.2', 1, 'Belanja Bantuan Keuangan', 98600000, '', 76, 1),
(82, '2.3.2.2.1', 1, 'Bantuan Operasional LPM', 10000000, '', 81, 1),
(83, '2.3.2.2.2', 1, 'Bantuan Operasional TP-PKK', 8000000, '', 81, 1),
(84, '2.3.2.2.3', 1, 'Bantuan Operasional Karang Taruna', 8000000, '', 81, 1),
(85, '2.3.2.2.4', 1, 'Bantuan Operasional Panitia HUT RI', 10000000, '', 81, 1),
(86, '2.3.2.2.5', 1, 'Bantuan Operasional Panitia ULTAH Desa', 14600000, '', 81, 1),
(87, '2.3.2.2.6', 1, 'Bantuan Operasional Radio Desa', 10000000, '', 81, 1),
(88, '2.3.2.2.7', 1, 'Bantuan Ops Forum Desa Sehat (FDS)', 5000000, '', 81, 1),
(89, '2.3.2.2.8', 1, 'Bantuan Operasional Posyandu & PMT', 25000000, '', 81, 1),
(90, '2.3.2.2.9', 1, 'Bantuan Keuangan Perpustakaan Desa ', 8000000, '', 81, 1),
(91, '2.4.1', 1, 'Kegiatan Pelatihan/BIMTEK/Orientasi Lap', 30000000, '', 7, 1),
(92, '2.4.2', 1, 'Belanja Perawatan/Pemeliharaan Kantor', 15529863, '', 7, 1),
(93, '2.4.3', 1, 'Belanja Perawatan  Kendaraan Dinas', 6000000, '', 7, 1),
(94, '2.4.4', 1, 'Belanja Pembuatan/Penyusunan Profil Desa, RPJMDes,RKPDes', 20000000, '', 7, 1),
(95, '2.4.5', 1, 'Belanja Penyusunan Perdes & PerKades', 10000000, '', 7, 1),
(96, '2.4.6', 1, 'Belanja Honor Tim Pengelola Kegiatan ( TPK )', 21000000, '', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_apbdes`
--

CREATE TABLE IF NOT EXISTS `tbl_apbdes` (
`id_apbdes` int(10) NOT NULL,
  `tahun` int(11) NOT NULL,
  `is_perubahan` tinyint(1) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_apbdes`
--

INSERT INTO `tbl_apbdes` (`id_apbdes`, `tahun`, `is_perubahan`, `nama`) VALUES
(1, 2015, 1, 'APBDes-P 2015');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_realisasi`
--

CREATE TABLE IF NOT EXISTS `tbl_realisasi` (
`id_realisasi` int(10) NOT NULL,
  `id_anggaran` int(10) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `jumlah` int(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tbl_realisasi`
--

INSERT INTO `tbl_realisasi` (`id_realisasi`, `id_anggaran`, `tanggal`, `jumlah`) VALUES
(1, 1, '2015-07-27 16:10:37', 1000000),
(2, 2, '2015-07-27 16:10:37', 2000000),
(3, 3, '2015-07-26 17:00:00', 3000001),
(4, 4, '2015-07-27 17:08:56', 10000000),
(5, 5, '2015-06-01 10:06:53', 100000222),
(6, 6, '2015-07-27 17:09:13', 10000000),
(7, 7, '2015-07-27 17:09:13', 10000000),
(8, 8, '2015-07-27 17:09:21', 10000000),
(17, 8, '2015-07-29 17:00:00', 999999999);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_anggaran`
--
ALTER TABLE `tbl_anggaran`
 ADD PRIMARY KEY (`id_anggaran`);

--
-- Indexes for table `tbl_apbdes`
--
ALTER TABLE `tbl_apbdes`
 ADD PRIMARY KEY (`id_apbdes`);

--
-- Indexes for table `tbl_realisasi`
--
ALTER TABLE `tbl_realisasi`
 ADD PRIMARY KEY (`id_realisasi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_anggaran`
--
ALTER TABLE `tbl_anggaran`
MODIFY `id_anggaran` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `tbl_apbdes`
--
ALTER TABLE `tbl_apbdes`
MODIFY `id_apbdes` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_realisasi`
--
ALTER TABLE `tbl_realisasi`
MODIFY `id_realisasi` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
