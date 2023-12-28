-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Jul 2022 pada 04.47
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_ekstra`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_akademik`
--

CREATE TABLE `data_akademik` (
  `id_akademik` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_pembina` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_kegiatan` int(11) NOT NULL,
  `id_thnAkd` int(11) NOT NULL,
  `tahun` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_akademik`
--

INSERT INTO `data_akademik` (`id_akademik`, `id_siswa`, `id_pembina`, `id_kelas`, `id_kegiatan`, `id_thnAkd`, `tahun`) VALUES
(144, 221, 13, 17, 1, 3, '2022-07'),
(145, 222, 13, 18, 1, 3, '2022-07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_kegiatan`
--

CREATE TABLE `data_kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `nama_kegiatan` varchar(100) NOT NULL,
  `deskripsi_kegiatan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_kegiatan`
--

INSERT INTO `data_kegiatan` (`id_kegiatan`, `nama_kegiatan`, `deskripsi_kegiatan`) VALUES
(1, 'PRAMUKA', '<span style=\"font-family: arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\"><font color=\"#000000\">Gerakan Pramuka Indonesia adalah nama organisasi pendidikan nonformal yang menyelenggarakan pendidikan kepanduan di Indonesia. Kata '),
(2, 'PMR', '-'),
(3, 'B.VOLI', '-'),
(4, 'FUTSAL', '-'),
(5, 'ATLETIK', '-'),
(6, 'AL BANJARI', '-'),
(7, 'TARI', '-'),
(8, 'LUKIS', '-'),
(9, 'K. KERAJINAN', '-'),
(11, 'BULU TANGKIS', '-'),
(12, 'PASKIBRAKA', '-'),
(13, 'ROBOTIKA', '-'),
(14, 'TATA BOGA', '-'),
(15, 'T. BUSANA', '-'),
(16, 'TILAWAH', '-'),
(17, 'KECANTIKAN', '-'),
(18, 'ANSAMBLE', '-'),
(20, 'RENANG', '<p>-</p>');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_kelasmaster`
--

CREATE TABLE `data_kelasmaster` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_kelasmaster`
--

INSERT INTO `data_kelasmaster` (`id_kelas`, `nama_kelas`) VALUES
(2, 'X MIPA 2'),
(3, 'X MIPA 3'),
(4, 'X MIPA 4'),
(5, 'XI MIPA 1'),
(6, 'XI MIPA 2'),
(7, 'XI MIPA 3'),
(8, 'XI MIPA 4'),
(9, 'XII MIPA 1'),
(10, 'XII MIPA 2'),
(11, 'XII MIPA 3'),
(12, 'XII MIPA 4'),
(13, 'X IPA 1'),
(14, 'X IPA 2'),
(15, 'X IPA 3'),
(16, 'X IPA 4'),
(17, 'XI IPA 1'),
(18, 'XI IPA 2'),
(19, 'XI IPA 3'),
(20, 'XI IPA 4'),
(21, 'XII IPA 1'),
(22, 'XII IPA 2'),
(23, 'XII IPA 3'),
(24, 'XII IPA 4'),
(25, 'X IPS 1'),
(26, 'X IPS 2'),
(27, 'X IPS 3'),
(28, 'X IPS 4'),
(29, 'XI IPS 1'),
(30, 'XI IPS 2'),
(31, 'XI IPS 3'),
(32, 'XI IPS 4'),
(33, 'XII IPS 1'),
(34, 'XII IPS 2'),
(35, 'XII IPS 3'),
(36, 'XII IPS 4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pembina`
--

CREATE TABLE `data_pembina` (
  `id_pembina` int(11) NOT NULL,
  `pembina_userid` int(11) NOT NULL,
  `nip_pembina` varchar(100) NOT NULL,
  `nama_pembina` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telp_pembina` int(15) NOT NULL,
  `mengajar_kegiatan` int(11) NOT NULL,
  `gambar_pembina` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_pembina`
--

INSERT INTO `data_pembina` (`id_pembina`, `pembina_userid`, `nip_pembina`, `nama_pembina`, `alamat`, `telp_pembina`, `mengajar_kegiatan`, `gambar_pembina`, `created_at`, `updated_at`) VALUES
(13, 413, '197208202006041022', 'Agus Suprianto, S.Pd', 'pamekasan madura', 0, 1, '1656303383_ef88cbcf0aa02393bd9a.jpg', '2022-06-10 00:00:00', '2022-06-26 23:16:23'),
(14, 417, '19208947987347', 'Fathor Rachman. S.Pd', 'pamekasan', 0, 2, 'default.jpg', '2022-06-17 00:00:00', '2022-07-19 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_siswa`
--

CREATE TABLE `data_siswa` (
  `id_siswa` int(11) NOT NULL,
  `siswa_userid` int(11) NOT NULL,
  `nis_siswa` int(11) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `pilihan_kegiatan` int(11) NOT NULL,
  `jk` varchar(50) NOT NULL,
  `alamat_siswa` varchar(255) NOT NULL,
  `gambar_siswa` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data_siswa`
--

INSERT INTO `data_siswa` (`id_siswa`, `siswa_userid`, `nis_siswa`, `nama_siswa`, `pilihan_kegiatan`, `jk`, `alamat_siswa`, `gambar_siswa`, `created_at`, `updated_at`) VALUES
(221, 445, 4061, 'ACH. AFIFUDDIN', 1, 'L', 'pamekasan', 'default.jpg', '2022-07-18 21:41:01', NULL),
(222, 446, 4092, 'ACHMAD HELMI IMRON', 1, 'L', 'pamekasan', 'default.jpg', '2022-07-18 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `home`
--

CREATE TABLE `home` (
  `id_setHome` int(11) NOT NULL,
  `judul_home` varchar(255) NOT NULL,
  `deskripsi_home` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `home`
--

INSERT INTO `home` (`id_setHome`, `judul_home`, `deskripsi_home`) VALUES
(1, 'Selamat Datang di Web Ekstrakurikuler SMAN 1 PADEMAWU', '<p><span style=\"color: rgb(77, 81, 86); font-family: arial, sans-serif; font-size: 14px;\"><b>Ekstrakurikuler adalah </b></span></p><p><span style=\"color: rgb(77, 81, 86); font-family: arial, sans-serif; font-size: 14px;\">kegiatan non-pelajaran formal yang dilakukan peserta didik sekolah atau universitas, umumnya di luar jam belajar kurikulum standar. Kegiatan-kegiatan ini ada pada setiap jenjang pendidikan dari sekolah dasar sampai universitas</span></p>');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_kegiatan`
--

CREATE TABLE `jadwal_kegiatan` (
  `id_jadwal` int(11) NOT NULL,
  `J_bulan` varchar(50) NOT NULL,
  `J_tanggal` date NOT NULL,
  `J_materi` varchar(255) NOT NULL,
  `J_waktu` time NOT NULL,
  `J_keterangan` varchar(255) NOT NULL,
  `id_kegiatan` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jadwal_kegiatan`
--

INSERT INTO `jadwal_kegiatan` (`id_jadwal`, `J_bulan`, `J_tanggal`, `J_materi`, `J_waktu`, `J_keterangan`, `id_kegiatan`, `created_at`, `updated_at`) VALUES
(44, '2022-07', '2022-07-19', 'Pembelajaran pramuka juli 2022', '11:43:00', 'pembelajaran pramuka', 1, '2022-07-18 21:43:36', NULL),
(45, '2022-07', '2022-07-18', 'Pembelajaran pramuka juli 2', '06:27:00', 'Pembelajaran pramuka juli 2', 1, '2022-07-19 21:28:12', NULL),
(46, '2022-07', '2022-07-22', 'Pembelajaran pramuka juli 2', '14:30:00', '<p>Pembelajaran pramuka juli 2<br></p>', 1, '2022-07-19 21:30:07', NULL),
(47, '2022-07', '2022-07-30', 'Pembelajaran pramuka juli 4', '16:36:00', '<p>Pembelajaran pramuka juli 4<br></p>', 1, '2022-07-19 21:36:20', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_siswa`
--

CREATE TABLE `nilai_siswa` (
  `id_nilai` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `nilai` varchar(10) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `thn_akademik` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `nilai_siswa`
--

INSERT INTO `nilai_siswa` (`id_nilai`, `id_siswa`, `nilai`, `id_jadwal`, `thn_akademik`, `created_at`, `updated_at`) VALUES
(311, 221, '80', 44, 3, '2022-07-18 21:43:44', NULL),
(312, 222, '75', 44, 3, '2022-07-18 21:47:53', NULL),
(313, 221, '70', 45, 3, '2022-07-19 21:28:12', NULL),
(314, 222, '85', 45, 3, '2022-07-19 21:28:12', NULL),
(315, 221, '75', 46, 3, '2022-07-19 21:30:07', NULL),
(316, 222, '85', 46, 3, '2022-07-19 21:30:07', NULL),
(317, 221, '85', 47, 3, '2022-07-19 21:36:20', NULL),
(318, 222, ' 80', 47, 3, '2022-07-19 21:36:20', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_akademik`
--

CREATE TABLE `tahun_akademik` (
  `id_thnAkd` int(11) NOT NULL,
  `tahun` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tahun_akademik`
--

INSERT INTO `tahun_akademik` (`id_thnAkd`, `tahun`, `status`) VALUES
(2, '2023/2024', 'tidak aktif'),
(3, '2021/2022', 'aktif'),
(5, '2025/2026', 'tidak aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `kegiatan` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`, `kegiatan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 1, NULL, NULL, '2022-06-11 04:01:08', '2022-06-11 04:01:08'),
(413, 'pembina', '1212', 2, 1, NULL, '2022-06-10 00:00:00', '2022-06-10 00:00:00'),
(417, 'pembina', '68586', 2, 2, NULL, '2022-06-17 00:00:00', '2022-07-19 00:00:00'),
(445, '4061', '12345', 3, 1, 'sudah validasi', '2022-07-18 21:39:51', NULL),
(446, '4092', '8859', 3, 1, 'sudah validasi', '2022-07-18 00:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_akademik`
--
ALTER TABLE `data_akademik`
  ADD PRIMARY KEY (`id_akademik`),
  ADD KEY `siswa_id` (`id_siswa`,`id_pembina`),
  ADD KEY `id_kelas` (`id_kelas`,`id_kegiatan`),
  ADD KEY `id_thnAkd` (`id_thnAkd`),
  ADD KEY `data_akademik_ibfk_2` (`id_pembina`),
  ADD KEY `data_akademik_ibfk_5` (`id_kegiatan`);

--
-- Indeks untuk tabel `data_kegiatan`
--
ALTER TABLE `data_kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indeks untuk tabel `data_kelasmaster`
--
ALTER TABLE `data_kelasmaster`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `data_pembina`
--
ALTER TABLE `data_pembina`
  ADD PRIMARY KEY (`id_pembina`),
  ADD KEY `pembina_userid` (`pembina_userid`),
  ADD KEY `mengajar_kegiatan` (`mengajar_kegiatan`);

--
-- Indeks untuk tabel `data_siswa`
--
ALTER TABLE `data_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `siswa_userid` (`siswa_userid`),
  ADD KEY `kelas` (`pilihan_kegiatan`),
  ADD KEY `pilihan_kegiatan` (`pilihan_kegiatan`);

--
-- Indeks untuk tabel `home`
--
ALTER TABLE `home`
  ADD PRIMARY KEY (`id_setHome`);

--
-- Indeks untuk tabel `jadwal_kegiatan`
--
ALTER TABLE `jadwal_kegiatan`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_kegiatan` (`id_kegiatan`);

--
-- Indeks untuk tabel `nilai_siswa`
--
ALTER TABLE `nilai_siswa`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_siswa` (`id_siswa`,`id_jadwal`),
  ADD KEY `id_jadwal` (`id_jadwal`);

--
-- Indeks untuk tabel `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  ADD PRIMARY KEY (`id_thnAkd`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_akademik`
--
ALTER TABLE `data_akademik`
  MODIFY `id_akademik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT untuk tabel `data_kegiatan`
--
ALTER TABLE `data_kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `data_kelasmaster`
--
ALTER TABLE `data_kelasmaster`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `data_pembina`
--
ALTER TABLE `data_pembina`
  MODIFY `id_pembina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `data_siswa`
--
ALTER TABLE `data_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT untuk tabel `home`
--
ALTER TABLE `home`
  MODIFY `id_setHome` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jadwal_kegiatan`
--
ALTER TABLE `jadwal_kegiatan`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `nilai_siswa`
--
ALTER TABLE `nilai_siswa`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT untuk tabel `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  MODIFY `id_thnAkd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=447;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_akademik`
--
ALTER TABLE `data_akademik`
  ADD CONSTRAINT `data_akademik_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `data_siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `data_akademik_ibfk_2` FOREIGN KEY (`id_pembina`) REFERENCES `data_pembina` (`id_pembina`) ON UPDATE CASCADE,
  ADD CONSTRAINT `data_akademik_ibfk_4` FOREIGN KEY (`id_kelas`) REFERENCES `data_kelasmaster` (`id_kelas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `data_akademik_ibfk_5` FOREIGN KEY (`id_kegiatan`) REFERENCES `data_kegiatan` (`id_kegiatan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `data_akademik_ibfk_6` FOREIGN KEY (`id_thnAkd`) REFERENCES `tahun_akademik` (`id_thnAkd`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_pembina`
--
ALTER TABLE `data_pembina`
  ADD CONSTRAINT `data_pembina_ibfk_1` FOREIGN KEY (`pembina_userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_pembina_ibfk_2` FOREIGN KEY (`mengajar_kegiatan`) REFERENCES `data_kegiatan` (`id_kegiatan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_siswa`
--
ALTER TABLE `data_siswa`
  ADD CONSTRAINT `data_siswa_ibfk_1` FOREIGN KEY (`siswa_userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_siswa_ibfk_2` FOREIGN KEY (`pilihan_kegiatan`) REFERENCES `data_kegiatan` (`id_kegiatan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal_kegiatan`
--
ALTER TABLE `jadwal_kegiatan`
  ADD CONSTRAINT `jadwal_kegiatan_ibfk_1` FOREIGN KEY (`id_kegiatan`) REFERENCES `data_kegiatan` (`id_kegiatan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai_siswa`
--
ALTER TABLE `nilai_siswa`
  ADD CONSTRAINT `nilai_siswa_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `data_siswa` (`id_siswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_siswa_ibfk_2` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_kegiatan` (`id_jadwal`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
