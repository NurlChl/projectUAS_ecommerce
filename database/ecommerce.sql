-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 11, 2023 at 02:34 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `id_produk` int NOT NULL,
  `nama_kategori` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `id_produk`, `nama_kategori`) VALUES
(6, 15, 'kursi'),
(8, 17, 'elegant'),
(9, 18, 'minimalist'),
(10, 19, 'kursi'),
(11, 20, 'sofa'),
(12, 21, 'elegant');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int NOT NULL,
  `id_produk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_produk`) VALUES
(5, 15),
(2, 19),
(7, 20);

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `id_komen` int NOT NULL,
  `id_produk` int NOT NULL,
  `pengguna` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_komen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`id_komen`, `id_produk`, `pengguna`, `isi_komen`) VALUES
(6, 15, 'cholil', 'sofa nya lembut banget de bes emang'),
(7, 15, 'cholil', 'keren produknya bagus'),
(8, 17, 'cholil', 'kursinya keren kece badai');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int NOT NULL,
  `pembuat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_produk` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` int NOT NULL,
  `harga` int NOT NULL,
  `deskripsi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `spesifikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `pembuat`, `nama_produk`, `stok`, `harga`, `deskripsi`, `spesifikasi`, `gambar`) VALUES
(15, 'gatau', 'sofa', 21, 100000, 'berkelas sofa dengan kualitas terbaik jangan main main', 'lembut\r\ntebal\r\nempuk', 0x363537313230353266336331352e6a7067),
(17, 'gatau', 'kusi elegant', 223, 2300000, 'kursi dengan daya tarik tinggi menggelegar', 'enak\r\nefisien\r\nnyaman', 0x363537313234333464313261392e6a7067),
(18, 'gatau', 'sofa goldug', 2, 50000000, 'sofa berkelas internasonal dengan desain sangat mengesankan', 'enak nyaman, bahas lembut dan empuk sekali', 0x363537313234663863616335612e6a7067),
(19, 'gatau', 'kursi santai', 23, 230000, 'berkelas enak buat di dudukin, untuk para remaja coock saat bersantai di indoor dan outdoor', 'lembut\r\nkokoh\r\ntahan lama \r\nkuat', 0x363537313333353063666131392e6a7067),
(20, 'cholil', 'sofa berkelas dunia', 23, 2000000, 'sofa berkelas coock untuk anda bersantai di rumah, menenangkan diri anda dengan tenang bersama keluarga', 'spesifikasinya : enak buat keluarga, lembut, empuk, minimalist, tahan lama, kuat', 0x363537343066353234663365332e6a7067),
(21, 'cholil', 'kursi mengkeren', 123, 15000000, 'kursi elit dapat menemani anda bersantai di tengah tengah hari yg penuh kesibukan', 'lembut, empuk, enak banget dipake buat duduk berkelas sekali', 0x363537356137616232363037322e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `posisi` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `posisi`) VALUES
(3, 'gatau', 'gatau@gmail.com', '$2y$10$hKtJH.tP7qZPAWtxTtK4ROjvAsnunmR7lO2XfAXwzrzwTvZLDiCGG', 'penjual'),
(4, 'cholil', 'cholil@gmail.com', '$2y$10$FV124FtbTgp638deOUv6N.tqWfa/Px8ToSe.il.dxwlS6mdL6.dNO', 'penjual');

-- --------------------------------------------------------

--
-- Table structure for table `warna`
--

CREATE TABLE `warna` (
  `id_warna` int NOT NULL,
  `id_produk` int NOT NULL,
  `nama_warna` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warna`
--

INSERT INTO `warna` (`id_warna`, `id_produk`, `nama_warna`) VALUES
(11, 15, '#25a3ad'),
(12, 15, '#19a966'),
(13, 15, '#fff4b8'),
(17, 17, '#ffffff'),
(18, 17, '#adadad'),
(19, 18, '#f5f5f5'),
(20, 18, '#ff9e9e'),
(21, 19, '#f0f0f0'),
(22, 19, '#e5c1a9'),
(23, 19, '#666666'),
(45, 20, '#ededed'),
(46, 20, '#454545'),
(47, 20, '#ffcd9e'),
(48, 20, '#b9d1f9'),
(49, 21, '#ff4d4d'),
(50, 21, '#2caa6f'),
(51, 21, '#424242'),
(52, 21, '#ffc9b3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD KEY `FK_kategori_produk` (`id_produk`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `FK_keranjang_produk` (`id_produk`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komen`),
  ADD KEY `FK_komentar_produk` (`id_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warna`
--
ALTER TABLE `warna`
  ADD PRIMARY KEY (`id_warna`),
  ADD KEY `FK_warna_produk` (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `warna`
--
ALTER TABLE `warna`
  MODIFY `id_warna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kategori`
--
ALTER TABLE `kategori`
  ADD CONSTRAINT `FK_kategori_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `FK_keranjang_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `FK_komentar_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;

--
-- Constraints for table `warna`
--
ALTER TABLE `warna`
  ADD CONSTRAINT `FK_warna_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
