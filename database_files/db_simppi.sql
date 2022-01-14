-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jan 2022 pada 15.52
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_simppi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan_aplikasi`
--

CREATE TABLE `pengaturan_aplikasi` (
  `id_pengaturan` int(11) NOT NULL,
  `show_full_sidebar` tinyint(1) NOT NULL DEFAULT 1,
  `app_name` varchar(12) COLLATE utf8mb4_bin NOT NULL,
  `color_theme` enum('DEFAULT','GREEN','BLUE','RED','ORANGE') COLLATE utf8mb4_bin NOT NULL DEFAULT 'DEFAULT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data untuk tabel `pengaturan_aplikasi`
--

INSERT INTO `pengaturan_aplikasi` (`id_pengaturan`, `show_full_sidebar`, `app_name`, `color_theme`) VALUES
(1, 0, 'SIM PPI', 'GREEN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_lengkap` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `level` enum('ADMIN_SUPER','ANGGOTA_PPI') COLLATE utf8mb4_bin NOT NULL,
  `picture` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `username`, `email`, `password`, `level`, `picture`) VALUES
(10, 'Muhammad Yahya', 'yahya', 'yahya@mail.com', '$2y$10$HW.qzoFcERlwxQqWdzne5..U6LfJOUF6N2BOWseCUnonl2YvFjtPu', 'ADMIN_SUPER', NULL),
(11, 'Muhammad Yahya', '20140908021', 'inikangyahya@gmail.com', '$2y$10$bUj/8XYQVdIBkpsCitfCAeGvZPD1kQfzOslCeLgn0.B2Dz8dfoyIG', 'ANGGOTA_PPI', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_perusahaan`
--

CREATE TABLE `profil_perusahaan` (
  `id_profil_perusahaan` int(11) NOT NULL,
  `nama_perusahaan` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `logo` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `telpon` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `fax` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `website` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data untuk tabel `profil_perusahaan`
--

INSERT INTO `profil_perusahaan` (`id_profil_perusahaan`, `nama_perusahaan`, `logo`, `telpon`, `fax`, `email`, `website`, `alamat`) VALUES
(3, 'PPI Kota Cirebon', 'uploads/52c942f2d886b20b4d03f114853860a7.jpg', '021-55910601', NULL, 'ppikotacirebon@gmail.com', 'ppikotacirebon.or.id', 'Cirebon');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pengaturan_aplikasi`
--
ALTER TABLE `pengaturan_aplikasi`
  ADD PRIMARY KEY (`id_pengaturan`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `profil_perusahaan`
--
ALTER TABLE `profil_perusahaan`
  ADD PRIMARY KEY (`id_profil_perusahaan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pengaturan_aplikasi`
--
ALTER TABLE `pengaturan_aplikasi`
  MODIFY `id_pengaturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `profil_perusahaan`
--
ALTER TABLE `profil_perusahaan`
  MODIFY `id_profil_perusahaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
