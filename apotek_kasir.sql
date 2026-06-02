-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260408.cb44fe5aec
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 13, 2026 at 05:45 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apotek_kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id_detail` int NOT NULL,
  `id_pembelian` int DEFAULT NULL,
  `id_obat` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `harga_beli` int DEFAULT NULL,
  `subtotal` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`id_detail`, `id_pembelian`, `id_obat`, `qty`, `harga_beli`, `subtotal`) VALUES
(10, 2, 7, 300, 7500, 2250000),
(11, 2, 14, 100, 5000, 500000),
(12, 1, 3, 100, 11000, 1100000),
(33, 3, 17, 100, 8000, 800000),
(34, 3, 4, 15, 7500, 112500),
(35, 3, 4, 50, 7900, 395000);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int NOT NULL,
  `id_transaksi` int DEFAULT NULL,
  `id_obat` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `subtotal` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `id_obat`, `jumlah`, `subtotal`) VALUES
(17, 9, 0, 1, 10000),
(18, 9, 1, 1, 5000),
(19, 10, 0, 1, 7000),
(20, 10, 1, 1, 15000),
(21, 11, 0, 1, 10000),
(22, 11, 1, 1, 15000),
(23, 11, 2, 1, 5000),
(24, 12, 0, 1, 15000),
(25, 12, 1, 1, 7100),
(26, 12, 2, 1, 18000),
(27, 13, 0, 1, 7100),
(28, 13, 1, 1, 7100),
(29, 14, 0, 1, 8000),
(30, 14, 1, 1, 8000),
(31, 14, 2, 1, 6000),
(32, 14, 3, 1, 18000),
(33, 14, 4, 1, 18000),
(34, 15, 0, 1, 8000),
(35, 15, 1, 1, 8000),
(36, 15, 2, 1, 6000),
(37, 15, 3, 1, 6000),
(38, 16, 0, 1, 7100),
(39, 16, 1, 1, 7100),
(40, 17, 0, 1, 7100),
(41, 18, 0, 1, 7100),
(42, 18, 1, 1, 7100),
(43, 18, 2, 1, 18000),
(44, 18, 3, 1, 18000),
(45, 19, 0, 1, 7100),
(46, 19, 1, 1, 7100),
(47, 20, 0, 1, 7100),
(48, 22, 2, 1, 7100),
(49, 23, 0, 1, 7100),
(50, 23, 1, 1, 7100),
(51, 23, 2, 1, 7100),
(52, 24, 0, 1, 7100),
(53, 25, 0, 1, 9000),
(54, 25, 1, 1, 11000),
(55, 26, 0, 1, 18000),
(56, 26, 1, 1, 8000),
(57, 27, 0, 1, 10500),
(58, 27, 1, 1, 7100),
(59, 28, 0, 1, 7100),
(60, 29, 0, 1, 10500),
(61, 29, 1, 1, 10500),
(62, 29, 2, 1, 9000),
(63, 30, 0, 1, 7100),
(64, 30, 1, 1, 7100),
(65, 31, 17, 1, 10500),
(66, 31, 17, 1, 10500),
(67, 31, 17, 1, 10500),
(68, 31, 17, 1, 10500),
(69, 31, 17, 1, 10500),
(70, 32, 17, 1, 10500),
(71, 32, 17, 1, 10500),
(72, 33, 6, 1, 18000),
(73, 33, 6, 1, 18000),
(74, 34, 4, 1, 7100),
(75, 35, 4, 3, 21300),
(76, 36, 4, 1, 7100),
(77, 37, 4, 2, 15000),
(78, 38, 4, 4, 30000),
(79, 39, 4, 6, 47400);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int NOT NULL,
  `nama_obat` varchar(100) DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `expired` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `nama_obat`, `harga`, `stok`, `kategori`, `expired`) VALUES
(3, 'Vitamin C 1000mg', 11000, 215, 'Vitamin', '2027-05-20'),
(4, 'Antasida Doen', 7900, 53, 'Analgesik', '2026-12-15'),
(5, 'OBH Combi', 12000, 50, 'Batuk & Flu', '2026-08-10'),
(6, 'Betadine 60ml', 18000, 36, 'Antiseptik', '2028-01-30'),
(7, 'Bodrex', 7500, 311, 'Analgesik', '2026-11-05'),
(8, 'Promag', 6000, 90, 'Obat Lambung', '2027-03-22'),
(9, 'Diapet', 9000, 55, 'Obat Diare', '2026-09-18'),
(10, 'Neozep Forte', 11000, 65, 'Batuk & Flu', '2026-07-12'),
(11, 'Panadol Extra', 13000, 75, 'Analgesik', '2027-02-25'),
(12, 'Sangobion', 20000, 30, 'Suplemen Darah', '2027-10-14'),
(13, 'Redoxon', 25000, 25, 'Vitamin', '2027-06-01'),
(14, 'Tolak Angin', 5000, 250, 'Herbal', '2028-04-20'),
(15, 'Insto Eye Drops', 16000, 45, 'Obat Mata', '2026-05-15'),
(16, 'Paracetamol 500mg', 5000, 100, 'Analgesik', '2027-12-01'),
(17, 'Amoxicillin 500mg', 8000, 109, 'Antibiotik', '2026-10-01');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int NOT NULL,
  `no_faktur` varchar(50) DEFAULT NULL,
  `nama_supplier` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `total_bayar` int DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `no_faktur`, `nama_supplier`, `tanggal`, `total_bayar`, `metode_pembayaran`) VALUES
(1, 'INV-2027', 'CV SINAR MUTIARA', '2026-04-21', 1100000, 'Kredit'),
(2, 'INV-2000', 'CV CAHAYA PURNAMA', '2026-04-21', 2750000, 'Kredit'),
(3, 'INV-2028', 'CV Sejahtera Abadi', '2026-04-28', 1307500, 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `alamat` text,
  `telepon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `telepon`) VALUES
(1, 'CV Dwi Tunggal', 'Jl. Merdeka No 1', '081234567890'),
(2, 'PT Kimia Farma (Distributor)', 'Jl. Sudirman No 10', '089876543210'),
(3, 'PT Kalbe Farma', 'Kawasan Industri Cikarang', '0219876543');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `metode` varchar(20) DEFAULT NULL,
  `ppn` int DEFAULT '0',
  `diskon` int DEFAULT '0',
  `total_akhir` int DEFAULT '0',
  `bayar` int DEFAULT NULL,
  `kembalian` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tanggal`, `id_user`, `metode`, `ppn`, `diskon`, `total_akhir`, `bayar`, `kembalian`) VALUES
(23, '2026-04-14 15:40:11', NULL, 'Tunai', 2343, 0, 23643, 0, 1357),
(24, '2026-04-14 15:41:38', NULL, 'QRIS', 0, 0, 7100, 0, 0),
(25, '2026-04-15 07:52:09', NULL, 'QRIS', 2000, 0, 22000, 0, 0),
(26, '2026-04-15 07:52:41', NULL, 'QRIS', 2600, 0, 28600, 0, 0),
(27, '2026-04-15 07:56:29', NULL, 'Tunai', 1760, 0, 19360, 0, 640),
(28, '2026-04-15 08:17:46', NULL, 'QRIS', 0, 0, 7100, 0, 0),
(29, '2026-04-15 08:58:25', NULL, 'Tunai', 3000, 0, 33000, 0, 2000),
(30, '2026-04-21 03:24:29', NULL, 'QRIS', 0, 0, 14200, 0, 0),
(31, '2026-04-28 12:45:27', NULL, 'Tunai', 0, 0, 52500, 52500, 0),
(32, '2026-04-28 12:45:54', NULL, 'QRIS', 0, 0, 21000, 21000, 0),
(33, '2026-04-28 12:46:38', NULL, 'QRIS', 0, 0, 36000, 36000, 0),
(34, '2026-04-28 12:50:12', NULL, 'QRIS', 0, 0, 7100, 7100, 0),
(35, '2026-04-28 14:51:23', NULL, 'Tunai', 0, 0, 21300, 22000, 700),
(36, '2026-04-28 14:51:45', NULL, 'Tunai', 0, 0, 7100, 8000, 900),
(37, '2026-04-28 15:05:49', NULL, 'Tunai', 0, 0, 15000, 15000, 0),
(38, '2026-04-28 15:19:46', NULL, 'Tunai', 0, 0, 30000, 35000, 5000),
(39, '2026-05-09 05:46:44', NULL, 'Tunai', 0, 0, 47400, 50000, 2600);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$12$boWEOudZkyjRjtq6HXbGY.nt1uVkOHFc3bJ/Pmob7KAJyc/uZhLSa', 'admin'),
(3, 'kasir', '$2y$12$kQKLyTXJw.hWekFYQSYD2OVs3WDihdlzvQzJu0RWeRXuc3IuQ0KHW', 'kasir'),
(4, 'admin1', '$2y$12$YDsFdFEoW2k1ao/i0EZeKejMfexFzr6ysSPxplwKFsej4EpB9ND6m', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
