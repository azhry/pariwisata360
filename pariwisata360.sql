-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2018 at 09:06 PM
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
(2, 'Kepala Dinas', '2018-04-09 12:02:49', '2018-04-09 12:02:49');

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
(707278361, 2, 'azhryarl@gmail.com', 'd8bba894a37a322932dc80e05de59fe3', 'Azh', 'Palembang', '1996-08-05', '2018-04-09 12:19:55', '2018-04-09 12:33:12'),
(1495442337, 1, 'arliansyah_azhary@yahoo.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Azhary Arliansyah', 'Palembang', '1996-08-05', '2018-04-09 12:17:45', '2018-04-09 12:17:45');

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
  MODIFY `id_hak_akses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kategori_wisata`
--
ALTER TABLE `kategori_wisata`
  MODIFY `id_kategori` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `komentar_wisata`
--
ALTER TABLE `komentar_wisata`
  MODIFY `id_komentar` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1495442338;

--
-- AUTO_INCREMENT for table `rating_wisata`
--
ALTER TABLE `rating_wisata`
  MODIFY `id_rating` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wisata`
--
ALTER TABLE `wisata`
  MODIFY `id_wisata` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1531469178;

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
