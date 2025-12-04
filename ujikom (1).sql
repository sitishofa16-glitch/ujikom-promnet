-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Des 2025 pada 01.18
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ujikom`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(100) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `id_kategori`) VALUES
(7, 'Hujan Bulan Juni', 'Sapardi Djoko Damono', 'Gramedia Pustaka Utama', '2015', NULL),
(11, 'Jejak Arkeologi Perang Pasifik di Situs Lapangan Terbang Kendari II Konawe Selatan Sulawesi Tenggara', 'M. Irfan Mahmud, Syahruddin Mansyur', 'HASANUDDIN UNIVERSITY PRESS', '2016', NULL),
(12, 'Matematika untuk SMA/MA/SMK/MAK Kelas X (Edisi Revisi)', 'Dicky Susanto, Theja Kurniawan , Savitri K. Sihombing, Eunice Salim, Marianna Magdalena Radjawane, Ummy Salmah, Ambarsari Kusuma Wardani', 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi', '2023', NULL),
(14, 'Hujan', 'Tere Liye', 'Gramedia Pustaka Utama', '2016', NULL),
(15, 'Tenggelamnya Kapal Van Der Wijck', 'Hamka', 'Pustaka Dini', '1987', NULL),
(16, 'Komik Rampai Tema Lingkungan Hidup 5 Pandawa & Penglipuran', 'Izzah Annisa, Sarah Fauzia', 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi', '2023', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `tanggal_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `tanggal_input`) VALUES
(1, 'Fiksi', '2025-11-29 09:33:58'),
(2, 'Non-Fiksi', '2025-11-29 09:33:58'),
(3, 'Pendidikan', '2025-11-29 09:33:58'),
(4, 'Teknologi', '2025-11-29 09:33:58'),
(5, 'Bisnis', '2025-11-29 09:33:58'),
(6, 'Kesehatan', '2025-11-29 09:33:58'),
(7, 'Agama', '2025-11-29 09:33:58'),
(8, 'Anak-anak', '2025-11-29 09:33:58'),
(9, 'Komik', '2025-11-29 09:33:58'),
(10, 'Referensi', '2025-11-29 09:33:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(1, 'fafa', 'fafa@gmail.com', '$2y$10$ou64L/gEJRiaHpv/paWmAukT01Djs1gVfNtGJQXtZtKcy1DLRSiru'),
(2, 'fafet', 'fafet@gmail.com', '$2y$10$BtCI55wrwf8KlHLPw7xkLuY.i4/mdjehVxGMkZqKkEbyJsJXJfXgi');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `fk_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
