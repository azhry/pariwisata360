-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2018 at 12:50 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pariwisata360`
--

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id_hak_akses` int(11) NOT NULL,
  `label` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`id_hak_akses`, `label`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2018-04-09 12:02:49', '2018-04-09 12:02:49'),
(2, 'Kepala Dinas', '2018-04-09 12:02:49', '2018-04-09 12:02:49'),
(3, 'Pengunjung', '2018-04-21 12:51:05', '2018-04-21 12:51:05');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_wisata`
--

CREATE TABLE `kategori_wisata` (
  `id_kategori` bigint(20) NOT NULL,
  `nama_kategori` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_wisata`
--

INSERT INTO `kategori_wisata` (`id_kategori`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Wisata Alam', 'Wisata Alam', '2018-04-13 12:19:21', '2018-04-13 12:19:21'),
(2, 'Wisata Buatan', 'Wisata Buatan', '2018-04-13 12:19:21', '2018-04-13 12:19:21'),
(3, 'Wisata Keluarga', 'Wisata Keluarga', '2018-04-13 12:19:32', '2018-04-13 12:19:32');

-- --------------------------------------------------------

--
-- Table structure for table `komentar_wisata`
--

CREATE TABLE `komentar_wisata` (
  `id_komentar` bigint(20) NOT NULL,
  `id_pengguna` bigint(20) NOT NULL,
  `id_wisata` bigint(20) NOT NULL,
  `komentar` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `komentar_wisata`
--

INSERT INTO `komentar_wisata` (`id_komentar`, `id_pengguna`, `id_wisata`, `komentar`, `created_at`, `updated_at`) VALUES
(1, 197357386, 1071347239, 'Tes komentar', '2018-04-22 05:17:27', '2018-04-22 05:17:27'),
(2, 1866353805, 1071347239, 'kamu ganteng', '2018-04-22 08:21:18', '2018-04-22 08:21:18');

-- --------------------------------------------------------

--
-- Table structure for table `kuesioner`
--

CREATE TABLE `kuesioner` (
  `id_kuesioner` bigint(20) NOT NULL,
  `nama_kuesioner` varchar(250) NOT NULL,
  `id_wisata` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuesioner`
--

INSERT INTO `kuesioner` (`id_kuesioner`, `nama_kuesioner`, `id_wisata`, `created_at`, `updated_at`) VALUES
(1, 'Kuesioner Punti Kayu', 1071347239, '2018-04-22 07:07:08', '2018-04-22 07:07:08');

-- --------------------------------------------------------

--
-- Table structure for table `kuesioner_jawaban`
--

CREATE TABLE `kuesioner_jawaban` (
  `id_jawaban` bigint(20) NOT NULL,
  `id_pertanyaan` bigint(20) NOT NULL,
  `jawaban` text NOT NULL,
  `nilai` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuesioner_jawaban`
--

INSERT INTO `kuesioner_jawaban` (`id_jawaban`, `id_pertanyaan`, `jawaban`, `nilai`, `created_at`, `updated_at`) VALUES
(3, 1010944106, 'Jawaban 1', 1, '2018-04-22 10:39:21', '2018-04-22 10:39:21'),
(4, 1010944106, 'Jawaban 2', 2, '2018-04-22 10:39:21', '2018-04-22 10:39:21'),
(5, 1010944106, 'Jawaban 3', 3, '2018-04-22 10:39:21', '2018-04-22 10:39:21'),
(6, 1010944106, 'Jawaban 4', 4, '2018-04-22 10:39:21', '2018-04-22 10:39:21'),
(454128228, 1821394066, 'Jawaban 1', 1, '2018-04-22 10:46:47', '2018-04-22 10:46:47'),
(1029392317, 1821394066, 'Jawaban 3', 3, '2018-04-22 10:46:47', '2018-04-22 10:46:47'),
(1599761473, 1821394066, 'Jawaban 2', 2, '2018-04-22 10:46:47', '2018-04-22 10:46:47');

-- --------------------------------------------------------

--
-- Table structure for table `kuesioner_pertanyaan`
--

CREATE TABLE `kuesioner_pertanyaan` (
  `id_pertanyaan` bigint(20) NOT NULL,
  `id_kategori` bigint(20) NOT NULL,
  `id_kuesioner` bigint(20) NOT NULL,
  `pertanyaan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuesioner_pertanyaan`
--

INSERT INTO `kuesioner_pertanyaan` (`id_pertanyaan`, `id_kategori`, `id_kuesioner`, `pertanyaan`, `created_at`, `updated_at`) VALUES
(1010944106, 1, 1, 'Pertanyaan 1', '2018-04-22 10:39:21', '2018-04-22 10:39:21'),
(1821394066, 3, 1, 'Pertanyaan 2', '2018-04-22 10:46:46', '2018-04-22 10:46:46');

-- --------------------------------------------------------

--
-- Table structure for table `kuesioner_pertanyaan_kategori`
--

CREATE TABLE `kuesioner_pertanyaan_kategori` (
  `id_kategori` bigint(20) NOT NULL,
  `kategori` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuesioner_pertanyaan_kategori`
--

INSERT INTO `kuesioner_pertanyaan_kategori` (`id_kategori`, `kategori`, `created_at`, `updated_at`) VALUES
(1, 'Infrastruktur', '2018-04-22 09:10:44', '2018-04-22 09:10:44'),
(2, 'Kebersihan dan Keamanan', '2018-04-22 09:10:44', '2018-04-22 09:10:44'),
(3, 'Sarana dan Prasarana', '2018-04-22 09:11:03', '2018-04-22 09:11:03'),
(4, 'Sistem Informasi', '2018-04-22 09:11:03', '2018-04-22 09:11:03');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` bigint(20) NOT NULL,
  `id_hak_akses` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `tempat_lahir` varchar(150) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `id_hak_akses`, `email`, `password`, `nama`, `tempat_lahir`, `tanggal_lahir`, `created_at`, `updated_at`) VALUES
(197357386, 3, 'azhary.arliansyah@studentpartner.com', '985fabf8f96dc1c4c306341031569937', 'Azhary Arliansyah', 'Palembang', '1996-08-05', '2018-04-21 12:53:48', '2018-04-21 12:53:48'),
(707278361, 2, 'azhryarl@gmail.com', 'd8bba894a37a322932dc80e05de59fe3', 'Azh', 'Palembang', '1996-08-05', '2018-04-09 12:19:55', '2018-04-09 12:33:12'),
(1495442337, 1, 'arliansyah_azhary@yahoo.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Azhary Arliansyah', 'Palembang', '1996-08-05', '2018-04-09 12:17:45', '2018-04-09 12:17:45'),
(1866353805, 3, 'muhammadfarhan280296@gmail.com', 'a645424d423aef1eb6c8da9fbfb123c0', 'muhammad farhan', 'Palembang', '1996-02-28', '2018-04-22 08:19:34', '2018-04-22 08:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `rating_wisata`
--

CREATE TABLE `rating_wisata` (
  `id_rating` bigint(20) NOT NULL,
  `id_wisata` bigint(20) NOT NULL,
  `id_pengguna` bigint(20) NOT NULL,
  `rating` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating_wisata`
--

INSERT INTO `rating_wisata` (`id_rating`, `id_wisata`, `id_pengguna`, `rating`, `created_at`, `updated_at`) VALUES
(1, 1071347239, 197357386, 4, '2018-04-22 06:48:27', '2018-04-22 06:51:29'),
(2, 1071347239, 1866353805, 4, '2018-04-22 08:21:57', '2018-04-22 08:22:01');

-- --------------------------------------------------------

--
-- Table structure for table `wisata`
--

CREATE TABLE `wisata` (
  `id_wisata` bigint(20) NOT NULL,
  `id_kategori` bigint(20) NOT NULL,
  `nama_wisata` varchar(500) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` text NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wisata`
--

INSERT INTO `wisata` (`id_wisata`, `id_kategori`, `nama_wisata`, `deskripsi`, `foto`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1071347239, 1, 'Punti Kayu', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc', '[\"1071347239_monpera1.jpg\",\"1071347239_360_0145.jpg\"]', -3.0108194139871656, 104.77217518530279, '2018-04-13 19:04:58', '2018-04-13 19:04:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id_hak_akses`);

--
-- Indexes for table `kategori_wisata`
--
ALTER TABLE `kategori_wisata`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `komentar_wisata`
--
ALTER TABLE `komentar_wisata`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_wisata` (`id_wisata`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `kuesioner`
--
ALTER TABLE `kuesioner`
  ADD PRIMARY KEY (`id_kuesioner`),
  ADD KEY `id_wisata` (`id_wisata`);

--
-- Indexes for table `kuesioner_jawaban`
--
ALTER TABLE `kuesioner_jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `id_pertanyaan` (`id_pertanyaan`);

--
-- Indexes for table `kuesioner_pertanyaan`
--
ALTER TABLE `kuesioner_pertanyaan`
  ADD PRIMARY KEY (`id_pertanyaan`),
  ADD KEY `id_kuesioner` (`id_kuesioner`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kuesioner_pertanyaan_kategori`
--
ALTER TABLE `kuesioner_pertanyaan_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD KEY `id_hak_akses` (`id_hak_akses`);

--
-- Indexes for table `rating_wisata`
--
ALTER TABLE `rating_wisata`
  ADD PRIMARY KEY (`id_rating`),
  ADD KEY `id_wisata` (`id_wisata`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `wisata`
--
ALTER TABLE `wisata`
  ADD PRIMARY KEY (`id_wisata`),
  ADD KEY `id_kategori_wisata` (`id_kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id_hak_akses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori_wisata`
--
ALTER TABLE `kategori_wisata`
  MODIFY `id_kategori` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `komentar_wisata`
--
ALTER TABLE `komentar_wisata`
  MODIFY `id_komentar` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kuesioner`
--
ALTER TABLE `kuesioner`
  MODIFY `id_kuesioner` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kuesioner_jawaban`
--
ALTER TABLE `kuesioner_jawaban`
  MODIFY `id_jawaban` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1599761474;

--
-- AUTO_INCREMENT for table `kuesioner_pertanyaan`
--
ALTER TABLE `kuesioner_pertanyaan`
  MODIFY `id_pertanyaan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1821394067;

--
-- AUTO_INCREMENT for table `kuesioner_pertanyaan_kategori`
--
ALTER TABLE `kuesioner_pertanyaan_kategori`
  MODIFY `id_kategori` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1866353806;

--
-- AUTO_INCREMENT for table `rating_wisata`
--
ALTER TABLE `rating_wisata`
  MODIFY `id_rating` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wisata`
--
ALTER TABLE `wisata`
  MODIFY `id_wisata` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1071347240;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentar_wisata`
--
ALTER TABLE `komentar_wisata`
  ADD CONSTRAINT `komentar_wisata_ibfk_1` FOREIGN KEY (`id_wisata`) REFERENCES `wisata` (`id_wisata`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_wisata_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuesioner`
--
ALTER TABLE `kuesioner`
  ADD CONSTRAINT `kuesioner_ibfk_1` FOREIGN KEY (`id_wisata`) REFERENCES `wisata` (`id_wisata`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuesioner_jawaban`
--
ALTER TABLE `kuesioner_jawaban`
  ADD CONSTRAINT `kuesioner_jawaban_ibfk_1` FOREIGN KEY (`id_pertanyaan`) REFERENCES `kuesioner_pertanyaan` (`id_pertanyaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuesioner_pertanyaan`
--
ALTER TABLE `kuesioner_pertanyaan`
  ADD CONSTRAINT `kuesioner_pertanyaan_ibfk_1` FOREIGN KEY (`id_kuesioner`) REFERENCES `kuesioner` (`id_kuesioner`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kuesioner_pertanyaan_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kuesioner_pertanyaan_kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_ibfk_1` FOREIGN KEY (`id_hak_akses`) REFERENCES `hak_akses` (`id_hak_akses`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rating_wisata`
--
ALTER TABLE `rating_wisata`
  ADD CONSTRAINT `rating_wisata_ibfk_1` FOREIGN KEY (`id_wisata`) REFERENCES `wisata` (`id_wisata`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rating_wisata_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wisata`
--
ALTER TABLE `wisata`
  ADD CONSTRAINT `wisata_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_wisata` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
