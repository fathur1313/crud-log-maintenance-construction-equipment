-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2025 at 12:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perusahaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_akun`
--

CREATE TABLE `tb_akun` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `role` enum('user','admin','manager') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_akun`
--

INSERT INTO `tb_akun` (`id_user`, `username`, `password`, `role`) VALUES
(2, 'alkahfi', '$2y$10$4S0RFZ9Tn5ypW3fDnWttiOQF8m7oVqK2lGcDH3PUnHymEG444tacy', 'user'),
(5, 'akuadmin', '$2y$10$ADxR8LvlzlKwUQmeoOvHkOv3H8vmqoaBR0StLfbxoQwOuLWRQM7YG', 'admin'),
(6, 'annas', '$2y$10$R7f51nKu10DBUiGu/y9yRu9pmfNDNh6AQbTWwYTdJ3whAThMKNmSC', 'user'),
(9, 'manager', '$2y$10$REdLtPJLHRaJQ8QGUQmVMOtHTVSzel1LckjwA4B0cCSDFys3mLGJ6', 'manager'),
(12, 'vivas', '$2y$10$n5dcbu0c.AxqPg8W3S0CsOieA2aRcvSaSMEUfxNXb6lyMxgcoiAp.', 'manager'),
(14, 'bagas', '$2y$10$xMq0hmDeZeEbqSGghHgkhehcUgLXVtbc59f4JNHk2gDo1jVbTeCoO', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tb_laporan_unit`
--

CREATE TABLE `tb_laporan_unit` (
  `no` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `alat_berat` varchar(50) NOT NULL,
  `part_name` varchar(50) NOT NULL,
  `part_number` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_satuan` int(8) NOT NULL,
  `harga_total` int(8) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `foto_dokumentasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_laporan_unit`
--

INSERT INTO `tb_laporan_unit` (`no`, `tanggal`, `alat_berat`, `part_name`, `part_number`, `qty`, `harga_satuan`, `harga_total`, `keterangan`, `foto_dokumentasi`) VALUES
(1, '2025-05-05', 'Z1', 'oil engine', 'sae 40', 10, 50000, 500000, 'service berkala', 'img1.jpg'),
(2, '2025-05-06', 'Z2', 'v-belt kipas', 'a 40', 1, 50000, 50000, 'sudah retak', 'img2.jpg'),
(3, '2025-05-07', 'Z3', 'Oil Engine', '15W-40 SAE', 1, 50000, 50000, 'service berkala', 'img3.jpg'),
(4, '2025-05-08', 'Z4', 'Seal arm', 'E1010201549', 1, 50000, 50000, 'Pergantian Seal Arm', 'img4.jpg'),
(15, '2025-05-08', 'Z1', 'asdf', 'asdf', 0, 11, 11, 'asdf', '1746662145_WhatsApp Image 2025-05-05 at 19.50.14.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_akun`
--
ALTER TABLE `tb_akun`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tb_laporan_unit`
--
ALTER TABLE `tb_laporan_unit`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_akun`
--
ALTER TABLE `tb_akun`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_laporan_unit`
--
ALTER TABLE `tb_laporan_unit`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
