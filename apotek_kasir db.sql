-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260519.eecbf60603
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2026 at 08:26 AM
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
  `id_detail` int(11) NOT NULL,
  `id_pembelian` int(11) DEFAULT NULL,
  `id_obat` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
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
(35, 3, 4, 50, 7900, 395000),
(43, 8, 15, 100, 10000, 1000000),
(44, 9, 17, 10, 7500, 7500);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_obat` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `id_obat`, `jumlah`, `subtotal`) VALUES
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
(79, 39, 4, 6, 47400),
(80, 40, 4, 2, 15800),
(81, 41, 15, 1, 16000),
(82, 41, 7, 1, 7500),
(83, 42, 17, 2, 16000),
(84, 42, 4, 1, 7900),
(85, 43, 7, 2, 15000),
(86, 44, 7, 2, 15000),
(87, 45, 7, 2, 15000),
(88, 46, 12, 3, 60000),
(89, 47, 4, 2, 15800),
(90, 48, 4, 2, 15800),
(91, 49, 4, 1, 7900),
(92, 50, 4, 1, 7900),
(93, 51, 4, 1, 7900),
(94, 52, 4, 1, 7900),
(95, 53, 17, 1, 1000),
(96, 54, 17, 1, 10),
(97, 55, 4, 2, 15800),
(98, 56, 7, 2, 15000),
(99, 57, 17, 2, 16000),
(100, 58, 4, 1, 7900),
(101, 58, 6, 1, 18000),
(102, 59, 4, 2, 15800),
(103, 60, 4, 2, 15800),
(104, 61, 4, 2, 15800),
(105, 62, 7, 3, 22500),
(106, 63, 4, 1, 7900),
(107, 64, 4, 1, 7900),
(108, 65, 4, 1, 7900),
(109, 66, 4, 2, 15800),
(110, 67, 4, 2, 15800);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(11) NOT NULL,
  `nama_obat` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `expired` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `nama_obat`, `harga`, `stok`, `kategori`, `expired`) VALUES
(3, 'Vitamin C 1000mg', 11000, 215, 'Vitamin', '2027-05-20'),
(4, 'Antasida Doen', 8300, 30, 'Analgesik', '2026-12-15'),
(5, 'OBH Combi', 12000, 50, 'Batuk & Flu', '2026-08-10'),
(6, 'Betadine 60ml', 18000, 35, 'Antiseptik', '2028-01-30'),
(7, 'Bodrex', 7500, 299, 'Analgesik', '2026-11-05'),
(8, 'Promag', 6000, 90, 'Obat Lambung', '2027-03-22'),
(9, 'Diapet', 9000, 55, 'Obat Diare', '2026-09-18'),
(10, 'Neozep Forte', 11000, 65, 'Batuk & Flu', '2026-07-12'),
(11, 'Panadol Extra', 13000, 75, 'Analgesik', '2027-02-25'),
(12, 'Sangobion', 20000, 27, 'Suplemen Darah', '2027-10-14'),
(13, 'Redoxon', 25000, 25, 'Vitamin', '2027-06-01'),
(14, 'Tolak Angin', 5000, 250, 'Herbal', '2028-04-20'),
(15, 'Insto Eye Drops', 10000, 144, 'Obat Mata', '2026-05-15'),
(16, 'Paracetamol 500mg', 5000, 100, 'Analgesik', '2027-12-01'),
(17, 'Amoxicillin 500mg', 7500, 24, 'Antibiotik', '2026-10-01');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `no_faktur` varchar(50) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `no_faktur`, `id_supplier`, `tanggal`, `total_bayar`, `metode_pembayaran`) VALUES
(1, 'INV-2027', 1, '2026-04-21', 1100000, 'Kredit'),
(2, 'INV-2000', 2, '2026-04-21', 2750000, 'Kredit'),
(3, 'INV-2028', 3, '2026-04-28', 1307500, 'Cash'),
(8, 'INV-9013', 6, '2026-06-10', 1000000, 'Cash'),
(9, 'INV-1248', 7, '2026-06-10', 75000, 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`) VALUES
(1, 'CV Dwi Tunggal'),
(2, 'PT Kimia Farma (Distributor)'),
(3, 'PT Kalbe Farma'),
(4, 'PT DAMAI'),
(5, 'PT CAHAYA INDAH'),
(6, 'PT YAYU'),
(7, 'PT JASA');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `metode` varchar(20) DEFAULT NULL,
  `total_akhir` int(11) DEFAULT '0',
  `bayar` int(11) DEFAULT NULL,
  `kembalian` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tanggal`, `id_user`, `metode`, `total_akhir`, `bayar`, `kembalian`) VALUES
(23, '2026-04-14 15:40:11', NULL, 'Tunai', 23643, 0, 1357),
(24, '2026-04-14 15:41:38', NULL, 'QRIS', 7100, 0, 0),
(25, '2026-04-15 07:52:09', NULL, 'QRIS', 22000, 0, 0),
(26, '2026-04-15 07:52:41', NULL, 'QRIS', 28600, 0, 0),
(27, '2026-04-15 07:56:29', NULL, 'Tunai', 19360, 0, 640),
(28, '2026-04-15 08:17:46', NULL, 'QRIS', 7100, 0, 0),
(29, '2026-04-15 08:58:25', NULL, 'Tunai', 33000, 0, 2000),
(30, '2026-04-21 03:24:29', NULL, 'QRIS', 14200, 0, 0),
(31, '2026-04-28 12:45:27', NULL, 'Tunai', 52500, 52500, 0),
(32, '2026-04-28 12:45:54', NULL, 'QRIS', 21000, 21000, 0),
(33, '2026-04-28 12:46:38', NULL, 'QRIS', 36000, 36000, 0),
(34, '2026-04-28 12:50:12', NULL, 'QRIS', 7100, 7100, 0),
(35, '2026-04-28 14:51:23', NULL, 'Tunai', 21300, 22000, 700),
(36, '2026-04-28 14:51:45', NULL, 'Tunai', 7100, 8000, 900),
(37, '2026-04-28 15:05:49', NULL, 'Tunai', 15000, 15000, 0),
(38, '2026-04-28 15:19:46', NULL, 'Tunai', 30000, 35000, 5000),
(39, '2026-05-09 05:46:44', NULL, 'Tunai', 47400, 50000, 2600),
(40, '2026-05-21 09:48:05', NULL, 'QRIS', 15800, 15800, 0),
(41, '2026-05-21 09:50:10', NULL, 'QRIS', 23500, 23500, 0),
(42, '2026-05-21 09:51:56', NULL, 'QRIS', 23900, 23900, 0),
(43, '2026-05-21 09:52:22', NULL, 'QRIS', 15000, 15000, 0),
(44, '2026-05-21 09:52:51', NULL, 'QRIS', 15000, 15000, 0),
(45, '2026-05-21 10:18:40', NULL, 'QRIS', 15000, 15000, 0),
(46, '2026-05-22 03:30:51', NULL, 'QRIS', 60000, 60000, 0),
(47, '2026-05-22 03:34:08', NULL, 'QRIS', 15800, 15800, 0),
(48, '2026-05-22 03:34:58', NULL, 'QRIS', 15800, 15800, 0),
(49, '2026-05-22 03:35:38', NULL, 'QRIS', 7900, 7900, 0),
(50, '2026-05-22 03:36:04', NULL, 'Transfer', 7900, 7900, 0),
(51, '2026-05-22 03:37:04', NULL, 'QRIS', 7900, 7900, 0),
(52, '2026-05-22 04:03:01', NULL, 'QRIS', 7900, 7900, 0),
(53, '2026-05-22 04:04:12', NULL, 'QRIS', 1000, 1000, 0),
(54, '2026-05-22 04:06:04', NULL, 'QRIS', 10, 10, 0),
(55, '2026-05-22 04:41:01', NULL, 'Transfer', 15800, 15800, 0),
(56, '2026-05-22 06:50:27', NULL, 'QRIS', 15000, 15000, 0),
(57, '2026-05-22 08:44:34', NULL, 'Tunai', 16000, 16000, 0),
(58, '2026-05-22 08:55:10', NULL, 'QRIS', 25900, 25900, 0),
(59, '2026-06-02 10:18:53', NULL, 'Transfer', 15800, 15800, 0),
(60, '2026-06-02 10:25:00', NULL, 'QRIS', 15800, 15800, 0),
(61, '2026-06-02 10:26:07', NULL, 'Transfer', 15800, 15800, 0),
(62, '2026-06-02 10:43:45', NULL, 'QRIS', 22500, 22500, 0),
(63, '2026-06-02 10:58:07', NULL, 'Transfer', 7900, 7900, 0),
(64, '2026-06-02 10:59:24', NULL, 'Transfer', 7900, 7900, 0),
(65, '2026-06-02 11:01:06', NULL, 'Transfer', 7900, 7900, 0),
(66, '2026-06-02 13:54:01', NULL, 'Tunai', 15800, 20000, 4200),
(67, '2026-06-02 13:55:35', NULL, 'Tunai', 15800, 20000, 4200);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
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
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `fk_detail_pembelian` (`id_pembelian`),
  ADD KEY `fk_detail_pembelian_obat` (`id_obat`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `fk_detail_transaksi_transaksi` (`id_transaksi`),
  ADD KEY `fk_detail_transaksi_obat` (`id_obat`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `fk_pembelian_supplier` (`id_supplier`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_transaksi_user` (`id_user`);

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
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `fk_detail_pembelian` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian` (`id_pembelian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_pembelian_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `fk_detail_transaksi_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_transaksi_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `fk_pembelian_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;