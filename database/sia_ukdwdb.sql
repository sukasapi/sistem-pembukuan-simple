-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 22, 2024 at 02:14 PM
-- Server version: 8.0.35
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sia_ukdwdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ukdw_akun`
--

CREATE TABLE `ukdw_akun` (
  `category_id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('in','out') NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ukdw_akun`
--

INSERT INTO `ukdw_akun` (`category_id`, `name`, `description`, `type`, `status`) VALUES
(4, 'test', NULL, 'in', 'inactive'),
(5, '0ktest', 'test', 'out', 'inactive'),
(6, 'Test', 'test', 'out', 'active'),
(7, '0ktest', 'test', 'in', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `ukdw_anggaran`
--

CREATE TABLE `ukdw_anggaran` (
  `kode_anggaran` varchar(200) NOT NULL,
  `kode_akun` int NOT NULL,
  `tahun_anggaran` year NOT NULL,
  `total_anggaran` decimal(10,0) NOT NULL,
  `create_date` datetime NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `kode_user` varchar(200) NOT NULL,
  `tipe_anggaran` enum('debit','kredit') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'debit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ukdw_anggaran`
--

INSERT INTO `ukdw_anggaran` (`kode_anggaran`, `kode_akun`, `tahun_anggaran`, `total_anggaran`, `create_date`, `status`, `kode_user`, `tipe_anggaran`) VALUES
('AGRN6740913dc7f1b5.62071323', 7, '2024', 21000000, '2024-11-22 21:12:13', '1', 'USR674068090fd396.43485430', 'debit'),
('AGRN674091485cf465.36153180', 6, '2024', 18000000, '2024-11-22 21:12:24', '1', 'USR674068090fd396.43485430', 'debit');

-- --------------------------------------------------------

--
-- Table structure for table `ukdw_transaksi`
--

CREATE TABLE `ukdw_transaksi` (
  `transaction_id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `create_date` datetime NOT NULL,
  `nominal` float NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ukdw_transaksi`
--

INSERT INTO `ukdw_transaksi` (`transaction_id`, `category_id`, `create_date`, `nominal`, `description`, `status`) VALUES
(1, 6, '2019-07-30 11:03:22', 0, '', 'inactive'),
(2, 7, '2019-07-30 11:03:22', 100000, 'test', 'active'),
(3, 6, '2019-07-30 11:09:38', 1000, 'keluar', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `ukdw_user`
--

CREATE TABLE `ukdw_user` (
  `id_user` varchar(200) NOT NULL,
  `nama_user` varchar(60) NOT NULL,
  `login_user` varchar(20) NOT NULL,
  `pass_user` varchar(255) NOT NULL,
  `role` enum('admin','manager','kasir') NOT NULL DEFAULT 'admin',
  `create_date` datetime NOT NULL,
  `status` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ukdw_user`
--

INSERT INTO `ukdw_user` (`id_user`, `nama_user`, `login_user`, `pass_user`, `role`, `create_date`, `status`) VALUES
('USR674068090fd396.43485430', 'toni joss', 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', '2024-11-22 00:00:01', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ukdw_akun`
--
ALTER TABLE `ukdw_akun`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `nama_akun` (`name`);

--
-- Indexes for table `ukdw_transaksi`
--
ALTER TABLE `ukdw_transaksi`
  ADD PRIMARY KEY (`transaction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ukdw_akun`
--
ALTER TABLE `ukdw_akun`
  MODIFY `category_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ukdw_transaksi`
--
ALTER TABLE `ukdw_transaksi`
  MODIFY `transaction_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
