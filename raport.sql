-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2024 at 05:09 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `raport`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `nip` varchar(18) NOT NULL,
  `kd_mp` int(11) DEFAULT NULL,
  `nama_guru` varchar(30) DEFAULT NULL,
  `alamat` varchar(30) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `agama` enum('ISLAM','PROTESTAN','KATHOLIK','HINDU','BUDHA','KONGHUCU','LAINNYA') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`nip`, `kd_mp`, `nama_guru`, `alamat`, `jenis_kelamin`, `agama`) VALUES
('02', 15, 'REO', 'KLETERAN', 'L', 'ISLAM'),
('1', 15, 'AGUNG ', 'KLETERAN', 'L', 'ISLAM');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`) VALUES
(2, 'VII-A');

-- --------------------------------------------------------

--
-- Table structure for table `kelas_guru`
--

CREATE TABLE `kelas_guru` (
  `id` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `kd_mp` int(11) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `id_tahun_akademik` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas_guru`
--

INSERT INTO `kelas_guru` (`id`, `id_kelas`, `kd_mp`, `nip`, `id_tahun_akademik`) VALUES
(5, 2, 15, '1', 9),
(6, 2, 15, '02', 9);

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `kd_mp` int(11) NOT NULL,
  `nama_mp` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`kd_mp`, `nama_mp`) VALUES
(15, 'BAHASA INDONESIA ');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `nis` varchar(8) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `kd_mp` int(11) NOT NULL,
  `nilai_tp1` int(4) DEFAULT NULL,
  `nilai_tp2` int(4) DEFAULT NULL,
  `nilai_tp3` int(4) DEFAULT NULL,
  `nilai_tp4` int(4) DEFAULT NULL,
  `nilai_tp5` int(4) DEFAULT NULL,
  `nilai_tp6` int(4) DEFAULT NULL,
  `nilai_tp7` int(4) DEFAULT NULL,
  `rata_tp` int(4) DEFAULT NULL,
  `nilai_uh1` int(4) DEFAULT NULL,
  `nilai_uh2` int(4) DEFAULT NULL,
  `nilai_uh3` int(4) DEFAULT NULL,
  `nilai_uh4` int(4) DEFAULT NULL,
  `nilai_uh5` int(4) DEFAULT NULL,
  `nilai_uh6` int(4) DEFAULT NULL,
  `nilai_uh7` int(4) DEFAULT NULL,
  `rata_uh` int(4) DEFAULT NULL,
  `nilai_pts` int(4) DEFAULT NULL,
  `nilai_uas` int(4) DEFAULT NULL,
  `nilai_akhir` int(4) DEFAULT NULL,
  `nilai_huruf` enum('A','B','C','D','E') DEFAULT NULL,
  `deskripsi` mediumtext,
  `id_mp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`nis`, `id_kelas`, `kd_mp`, `nilai_tp1`, `nilai_tp2`, `nilai_tp3`, `nilai_tp4`, `nilai_tp5`, `nilai_tp6`, `nilai_tp7`, `rata_tp`, `nilai_uh1`, `nilai_uh2`, `nilai_uh3`, `nilai_uh4`, `nilai_uh5`, `nilai_uh6`, `nilai_uh7`, `rata_uh`, `nilai_pts`, `nilai_uas`, `nilai_akhir`, `nilai_huruf`, `deskripsi`, `id_mp`) VALUES
('001', 2, 15, 1, 1, 3, 1, 5, 31, 32, 11, 3, 4, 2, 3, 3, 3, 4, 3, 10, 29, 13, 'E', 'Sangat Kurang', NULL),
('585', 2, 15, 19, 27, 24, 25, 28, 20, 27, 24, 18, 76, 26, 43, 20, 37, 45, 38, 136, 137, 84, 'B', 'Baik', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profil_sekolah`
--

CREATE TABLE `profil_sekolah` (
  `idprofil_sekolah` int(4) NOT NULL,
  `nama` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `npsn` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `status` enum('Negeri','Swasta') CHARACTER SET utf8 DEFAULT NULL,
  `nama_kepsek` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `nip_kepsek` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `akreditasi` enum('kosong','A','B','C') CHARACTER SET utf8 DEFAULT NULL,
  `logo` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `provinsi` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `kabupaten` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `kecamatan` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `kelurahan` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `dusun` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `rt` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `rw` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `alamat` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `kodepos` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `lintang` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `bujur` varchar(15) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(8) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(30) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `agama` enum('ISLAM','PROTESTAN','KATHOLIK','HINDU','BUDHA','KONGHUCU','LAINNYA') DEFAULT NULL,
  `orang_tua` varchar(30) DEFAULT NULL,
  `asal_sekolah` varchar(50) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `nama`, `alamat`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `orang_tua`, `asal_sekolah`, `id_kelas`, `foto`) VALUES
('001', 'AGUNG', 'KLETERAN', '2024-06-29', 'L', 'ISLAM', 'Agung', 'sfsdf', 2, NULL),
('585', 'AGUNG', 'AA', '2024-06-22', 'L', 'ISLAM', 'Agung', 'Magelang', 2, '../uploads/585.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_akademik`
--

CREATE TABLE `tahun_akademik` (
  `id` int(11) NOT NULL,
  `tahun_akademik` varchar(9) DEFAULT NULL,
  `semester` varchar(6) DEFAULT NULL,
  `semester_aktif` tinyint(1) DEFAULT NULL,
  `tempat` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tahun_akademik`
--

INSERT INTO `tahun_akademik` (`id`, `tahun_akademik`, `semester`, `semester_aktif`, `tempat`, `tanggal`) VALUES
(9, '2001/2022', 'genap', 1, 'Kabupaten Magelang', '2024-06-22');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `email`, `created_at`) VALUES
(6, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin_email@example.com', '2024-06-17 05:04:04'),
(7, 'admin', 'ADMIN', 'admin', '', '2024-06-18 01:18:03'),
(8, 'guru1', 'GURU1', 'guru', '', '2024-06-18 01:18:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`nip`),
  ADD KEY `kd_mp` (`kd_mp`),
  ADD KEY `kd_mp_2` (`kd_mp`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `kelas_guru`
--
ALTER TABLE `kelas_guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `kd_mp` (`kd_mp`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`kd_mp`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`nis`,`id_kelas`,`kd_mp`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `kd_mp` (`kd_mp`),
  ADD KEY `fk_id_mp` (`id_mp`);

--
-- Indexes for table `profil_sekolah`
--
ALTER TABLE `profil_sekolah`
  ADD PRIMARY KEY (`idprofil_sekolah`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `siswa_ibfk_2` (`id_kelas`);

--
-- Indexes for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kelas_guru`
--
ALTER TABLE `kelas_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `kd_mp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `profil_sekolah`
--
ALTER TABLE `profil_sekolah`
  MODIFY `idprofil_sekolah` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`kd_mp`) REFERENCES `mata_pelajaran` (`kd_mp`);

--
-- Constraints for table `kelas_guru`
--
ALTER TABLE `kelas_guru`
  ADD CONSTRAINT `kelas_guru_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `kelas_guru_ibfk_2` FOREIGN KEY (`kd_mp`) REFERENCES `mata_pelajaran` (`kd_mp`),
  ADD CONSTRAINT `kelas_guru_ibfk_3` FOREIGN KEY (`nip`) REFERENCES `guru` (`nip`);

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `fk_id_mp` FOREIGN KEY (`id_mp`) REFERENCES `mata_pelajaran` (`kd_mp`),
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`),
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`kd_mp`) REFERENCES `mata_pelajaran` (`kd_mp`);

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
