-- phpMyAdmin SQL Dump
-- version 4.9.1deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 22, 2019 at 08:36 AM
-- Server version: 8.0.18-0ubuntu0.19.10.1
-- PHP Version: 7.3.11-0ubuntu0.19.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gotongsampah`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username_admin` varchar(250) NOT NULL,
  `password_admin` varchar(250) NOT NULL,
  `email_admin` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `donasi`
--

CREATE TABLE `donasi` (
  `id_donasi` int(11) NOT NULL,
  `fkid_user` int(11) DEFAULT NULL,
  `fkid_mitra` int(11) DEFAULT NULL,
  `Judul_Donasi` varchar(250) NOT NULL,
  `jenis_donasi` varchar(250) NOT NULL,
  `jumlah_donasi` int(11) NOT NULL,
  `informasi_donasi` varchar(250) NOT NULL,
  `keypicker` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donasi`
--

INSERT INTO `donasi` (`id_donasi`, `fkid_user`, `fkid_mitra`, `Judul_Donasi`, `jenis_donasi`, `jumlah_donasi`, `informasi_donasi`, `keypicker`) VALUES
(33, 4, NULL, 'Teman Qmacs', 'Besi', 50, 'Nama teman saya adalah tasrifin, mohon didaur ulang secepatnya     ', '1576972309n43u6eAqUP0raqgh6WQ0bIpEBYTlpyScreenshotfrom2019-12-2113-55-50.png'),
(43, 4, NULL, 'test', 'Plastik', 123, 'tase', '192eba692960b5d20d8c8cb41f31c4133083f283bbd9b2c01dc4ba5354c99c0fa68cb46812e4866b09616dacd1f6a88c23c2c813b2c825f4853d59475da28422.png');

--
-- Triggers `donasi`
--
DELIMITER $$
CREATE TRIGGER `donasi_AFTER_DELETE` AFTER DELETE ON `donasi` FOR EACH ROW BEGIN
	DECLARE ID_DNS INT;
    
    SET ID_DNS = OLD.id_donasi;
    SET SQL_SAFE_UPDATES = 0;
	DELETE FROM gambar_donasi WHERE gambar_donasi.id_donasi = ID_DNS;
	SET SQL_SAFE_UPDATES = 1;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `donasi_AFTER_INSERT` AFTER INSERT ON `donasi` FOR EACH ROW BEGIN
	INSERT INTO gambar_donasi(id_donasi,gambar) values (new.id_donasi, new.keypicker);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `donasi_AFTER_UPDATE` AFTER UPDATE ON `donasi` FOR EACH ROW BEGIN
	DECLARE ID_DNS INTEGER;
    DECLARE GBR_NEW VARCHAR(250);
    DECLARE GBR_OLD VARCHAR(250);
    
    SET ID_DNS = NEW.id_donasi;
    
    /* GET THE KEYPICKER FROM DONASI TABLE AND STORE IT TO VAR GBR_NEW*/
    SET GBR_NEW = NEW.keypicker;
    /* GET THE GAMBAR FROM GAMBAR_DONASI TABLE AND STORE IT TO VAR GBR_OLD*/
    SELECT gambar INTO GBR_OLD FROM gambar_donasi WHERE id_donasi = ID_DNS;
    IF GBR_NEW != GBR_OLD THEN
		SET SQL_SAFE_UPDATES = 0;
		UPDATE gambar_donasi 
        SET gambar_donasi.gambar = GBR_NEW
        WHERE gambar_donasi.id_donasi = ID_DNS;
        SET SQL_SAFE_UPDATES = 1;
	END IF;
    
    
    
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `gambar_donasi`
--

CREATE TABLE `gambar_donasi` (
  `id_gambar` int(11) NOT NULL,
  `id_donasi` int(11) NOT NULL,
  `gambar` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gambar_donasi`
--

INSERT INTO `gambar_donasi` (`id_gambar`, `id_donasi`, `gambar`) VALUES
(49, 33, '1576972309n43u6eAqUP0raqgh6WQ0bIpEBYTlpyScreenshotfrom2019-12-2113-55-50.png'),
(52, 43, '192eba692960b5d20d8c8cb41f31c4133083f283bbd9b2c01dc4ba5354c99c0fa68cb46812e4866b09616dacd1f6a88c23c2c813b2c825f4853d59475da28422.png');

-- --------------------------------------------------------

--
-- Table structure for table `mitra`
--

CREATE TABLE `mitra` (
  `id_mitra` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `nama` varchar(250) DEFAULT NULL,
  `handphone` varchar(250) DEFAULT NULL,
  `password` varchar(250) NOT NULL,
  `tanggallahir` date DEFAULT NULL,
  `jeniskelamin` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `alamat` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `activationCode` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mitra`
--

INSERT INTO `mitra` (`id_mitra`, `username`, `email`, `nama`, `handphone`, `password`, `tanggallahir`, `jeniskelamin`, `alamat`, `activationCode`) VALUES
(6, 'b', 'andrecsd9@gmail.com', 'Anak Jendral', '081101010101', '30ceec0fc83556170532786c5ad8e6df', '1991-01-01', 'Laki-Laki', 'Telur Buaya Netas', NULL),
(25, 'parahbanget', 'andrecsd6@gmail.com', NULL, NULL, '30ceec0fc83556170532786c5ad8e6df', '0000-00-00', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `alamat` varchar(250) DEFAULT NULL,
  `tanggallahir` date DEFAULT NULL,
  `handphone` varchar(15) DEFAULT NULL,
  `jeniskelamin` varchar(15) DEFAULT NULL,
  `password` varchar(250) NOT NULL,
  `nama` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `activationCode` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `alamat`, `tanggallahir`, `handphone`, `jeniskelamin`, `password`, `nama`, `activationCode`) VALUES
(4, 'a', 'andrecsd9@gmail.com', 'Jl. Jembatan Roboh Di Sundul Pak RW   ', '1998-06-08', '081287877573', 'Laki-Laki', '30ceec0fc83556170532786c5ad8e6df', 'Andre Haykal Rachman', NULL),
(6, 'asd', 'a@asd.a', NULL, NULL, NULL, NULL, 'f5bb0c8de146c67b44babbf4e6584cc0', NULL, NULL),
(8, 'peserta', 'andrecsd6@gmail.com', NULL, NULL, NULL, NULL, '30ceec0fc83556170532786c5ad8e6df', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `donasi`
--
ALTER TABLE `donasi`
  ADD PRIMARY KEY (`id_donasi`),
  ADD UNIQUE KEY `id_donasi` (`id_donasi`);

--
-- Indexes for table `gambar_donasi`
--
ALTER TABLE `gambar_donasi`
  ADD PRIMARY KEY (`id_gambar`);

--
-- Indexes for table `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id_mitra`),
  ADD UNIQUE KEY `username_mitra` (`username`),
  ADD UNIQUE KEY `email_mitra` (`email`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username_user` (`username`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD UNIQUE KEY `email_user` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donasi`
--
ALTER TABLE `donasi`
  MODIFY `id_donasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `gambar_donasi`
--
ALTER TABLE `gambar_donasi`
  MODIFY `id_gambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `mitra`
--
ALTER TABLE `mitra`
  MODIFY `id_mitra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;