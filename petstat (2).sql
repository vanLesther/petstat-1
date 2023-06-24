-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2023 at 10:46 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petstat`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `maoID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `brgyID` int(11) NOT NULL,
  `geoID` int(11) NOT NULL,
  `barangay` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`brgyID`, `geoID`, `barangay`) VALUES
(1, 100000, 'Acao'),
(2, 100001, 'Amerang'),
(3, 100002, 'Amurao'),
(4, 100003, 'Anuang'),
(5, 100004, 'Ayaman'),
(6, 100005, 'Ayong'),
(7, 100006, 'Bacan'),
(8, 100007, 'Balabag'),
(9, 100008, 'Baluyan'),
(10, 100009, 'Banguit'),
(11, 100010, 'Bulay'),
(12, 100011, 'Cadoldolan'),
(13, 100012, 'Cagban'),
(14, 100013, 'Calawagan'),
(15, 100014, 'Calayo'),
(16, 100015, 'Duyan-Duyan'),
(17, 100016, 'Gaub'),
(18, 100017, 'Gines Interior'),
(19, 100018, 'Gines Patag'),
(20, 100019, 'Guibuangan Tigbauan'),
(21, 100020, 'Inabasan'),
(22, 100021, 'Inaca'),
(23, 100022, 'Inaladan'),
(24, 100023, 'Ingas'),
(25, 100024, 'Ito Norte'),
(26, 100025, 'Ito Sur'),
(27, 100026, 'Janipaan Central'),
(28, 100027, 'Janipaan Este'),
(29, 100028, 'Janipaan Oeste'),
(30, 100029, 'Janipaan Olo'),
(31, 100030, 'Jelicuon Lusaya'),
(32, 100031, 'Jelicuon Montinola'),
(33, 100032, 'Lag-an'),
(34, 100033, 'Leong'),
(35, 100034, 'Lutac'),
(36, 100035, 'Manguna'),
(37, 100036, 'Maraguit'),
(38, 100037, 'Morubuan'),
(39, 100038, 'Pacatin'),
(40, 100039, 'Pagotpot'),
(41, 100040, 'Pamul-ogan'),
(42, 100041, 'Pamuringao Proper'),
(43, 100042, 'Pamuringao Garrido'),
(44, 100043, 'Zone I Pob. (Barangay 1)'),
(45, 100044, 'Zone II Pob. (Barangay 2)'),
(46, 100045, 'Zone III Pob. (Barangay 3)'),
(47, 100046, 'Zone IV Pob. (Barangay 4)'),
(48, 100047, 'Zone V Pob. (Barangay 5)'),
(49, 100048, 'Zone VI Pob. (Barangay 6)'),
(50, 100049, 'Zone VII Pob. (Barangay 7)'),
(51, 100050, 'Zone VIII Pob. (Barangay 8)'),
(52, 100051, 'Zone IX Pob. (Barangay 9)'),
(53, 100052, 'Zone X Pob. (Barangay 10)'),
(54, 100053, 'Zone XI Pob. (Barangay 11)'),
(55, 100054, 'Pungtod'),
(56, 100055, 'Puyas'),
(57, 100056, 'Salacay'),
(58, 100057, 'Sulanga'),
(59, 100058, 'Tabucan'),
(60, 100059, 'Tacdangan'),
(61, 100060, 'Talanghauan'),
(62, 100061, 'Tigbauan Road'),
(63, 100062, 'Tinio-an'),
(64, 100063, 'Tiring'),
(65, 100064, 'Tupol Central'),
(66, 100065, 'Tupol Este'),
(67, 100066, 'Tupol Oeste'),
(68, 100067, 'Tuy-an');

-- --------------------------------------------------------

--
-- Table structure for table `case`
--

CREATE TABLE `case` (
  `caseID` int(11) NOT NULL,
  `barangayID` int(11) NOT NULL,
  `residentID` int(11) NOT NULL,
  `petID` int(11) NOT NULL,
  `caseType` tinyint(1) NOT NULL,
  `description` varchar(500) NOT NULL,
  `caseStatus` tinyint(1) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `geolocation`
--

CREATE TABLE `geolocation` (
  `geoID` int(11) NOT NULL,
  `latitude` decimal(9,6) NOT NULL,
  `longitude` decimal(9,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `geolocation`
--

INSERT INTO `geolocation` (`geoID`, `latitude`, `longitude`) VALUES
(100000, '10.848964', '122.461899'),
(100001, '10.883751', '122.473368'),
(100002, '10.886936', '122.470015'),
(100003, '10.884943', '122.517209'),
(100004, '10.885794', '122.487165'),
(100005, '10.893027', '122.499433'),
(100006, '10.884555', '122.461535'),
(100007, '10.922577', '122.535072'),
(100009, '10.872372', '122.490318'),
(100010, '10.937175', '122.477458'),
(100011, '10.872403', '122.524800'),
(100012, '10.882848', '122.533492'),
(100013, '10.912917', '122.513968'),
(100014, '10.852573', '122.479204'),
(100015, '10.842126', '122.485694'),
(100016, '10.853218', '122.490344'),
(100017, '10.917746', '122.504353'),
(100018, '10.936122', '122.489249'),
(100020, '10.866239', '122.435766'),
(100021, '10.852873', '122.453128'),
(100022, '10.902666', '122.518559'),
(100023, '10.906923', '122.475892'),
(100026, '10.915980', '122.542807'),
(100028, '10.922051', '122.521360'),
(100029, '10.929424', '122.508033'),
(100030, '10.907501', '122.527269'),
(100031, '10.902759', '122.536477'),
(100032, '10.864485', '122.454927'),
(100033, '10.881789', '122.493425'),
(100034, '10.882383', '122.510449'),
(100035, '10.833569', '122.479969'),
(100036, '10.889842', '122.507638'),
(100037, '10.871116', '122.450295'),
(100038, '10.915394', '122.530480'),
(100039, '10.918942', '122.500394'),
(100040, '10.860267', '122.483772'),
(100041, '10.876586', '122.459645'),
(100042, '10.879060', '122.465502'),
(100054, '10.869324', '122.501311'),
(100055, '10.883180', '122.525263'),
(100056, '10.872054', '122.476270'),
(100057, '10.906462', '122.500250'),
(100058, '10.860234', '122.499710'),
(100059, '10.896689', '122.488930'),
(100060, '10.850311', '122.517943'),
(100061, '10.921707', '122.488367'),
(100062, '10.856930', '122.482571'),
(100063, '10.854668', '122.507196'),
(100064, '10.864334', '122.465748'),
(100065, '10.853915', '122.472327'),
(100090, '10.668400', '122.959200'),
(100091, '10.668400', '122.959200'),
(100092, '10.668400', '122.959200'),
(100093, '10.668400', '122.959200'),
(100094, '10.668400', '122.959200'),
(100095, '10.668400', '122.959200'),
(100096, '10.668400', '122.959200'),
(100097, '10.668400', '122.959200'),
(100098, '10.668400', '122.959200'),
(100099, '10.668400', '122.959200'),
(100100, '10.668400', '122.959200'),
(100101, '10.668400', '122.959200'),
(100102, '10.668400', '122.959200'),
(100103, '10.668400', '122.959200'),
(100104, '10.668400', '122.959200'),
(100105, '10.668400', '122.959200'),
(100106, '10.668400', '122.959200'),
(100107, '10.668400', '122.959200'),
(100108, '10.668400', '122.959200'),
(100109, '10.668400', '122.959200'),
(100110, '10.668400', '122.959200'),
(100111, '10.668400', '122.959200'),
(100112, '10.668400', '122.959200'),
(100113, '10.668400', '122.959200'),
(100114, '10.668400', '122.959200'),
(100115, '10.668400', '122.959200'),
(100116, '10.668400', '122.959200'),
(100117, '10.668400', '122.959200'),
(100118, '10.668400', '122.959200'),
(100119, '10.668400', '122.959200'),
(100120, '10.668400', '122.959200'),
(100121, '10.668400', '122.959200'),
(100122, '10.668400', '122.959200'),
(100123, '10.668400', '122.959200'),
(100124, '10.668400', '122.959200'),
(100125, '10.668400', '122.959200'),
(100126, '10.668400', '122.959200'),
(100127, '10.668400', '122.959200'),
(100128, '10.668400', '122.959200'),
(100129, '10.668400', '122.959200'),
(100130, '10.385300', '123.652500');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notidID` int(11) NOT NULL,
  `residentID` int(11) NOT NULL,
  `brgyID` int(11) NOT NULL,
  `caseID` int(11) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `petID` int(11) NOT NULL,
  `residentID` int(11) NOT NULL,
  `petType` tinyint(1) NOT NULL,
  `pname` varchar(50) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `color` varchar(50) NOT NULL,
  `vaccinationStatus` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`petID`, `residentID`, `petType`, `pname`, `sex`, `color`, `vaccinationStatus`, `status`) VALUES
(1, 28, 0, 'petstat', 0, 'black', 0, 1),
(2, 28, 1, 'petstat', 0, 'black', 0, 0),
(3, 31, 1, 'vanilla', 1, 'black and white', 0, 2),
(4, 31, 1, 'vanilla', 1, 'black and white', 0, 0),
(5, 31, 1, 'vanilla', 1, 'black and white', 0, 0),
(6, 31, 1, 'mocha', 1, 'brown with stri', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `resident`
--

CREATE TABLE `resident` (
  `residentID` int(11) NOT NULL,
  `geoID` int(11) NOT NULL,
  `brgyID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `contactNo` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `userType` tinyint(1) NOT NULL DEFAULT '0',
  `userStatus` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`residentID`, `geoID`, `brgyID`, `name`, `contactNo`, `email`, `password`, `userType`, `userStatus`) VALUES
(27, 100126, 43, 'van lesther Farol', '09933715629', 'v4n0613@gmail.com', '123', 0, 1),
(28, 100127, 43, 'petstat', '09933715629', 'qwerty@qwerty.qwerty', '111', 1, 0),
(29, 100128, 63, 'hans francis', '09754561234', 'hans@gmail.com', '123', 0, 0),
(30, 100129, 59, 'louvenn', '09736732234', 'loben@gmail.com', '123', 0, 0),
(31, 100130, 36, 'van lesther', '09933715629', 'v4n06a13@gmail.com', 'asd', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`maoID`);

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`brgyID`);

--
-- Indexes for table `case`
--
ALTER TABLE `case`
  ADD PRIMARY KEY (`caseID`),
  ADD KEY `barangayID` (`barangayID`),
  ADD KEY `petID` (`petID`),
  ADD KEY `residentID` (`residentID`);

--
-- Indexes for table `geolocation`
--
ALTER TABLE `geolocation`
  ADD PRIMARY KEY (`geoID`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD KEY `brgyID` (`brgyID`),
  ADD KEY `caseID` (`caseID`),
  ADD KEY `residentID` (`residentID`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`petID`),
  ADD KEY `residentID` (`residentID`);

--
-- Indexes for table `resident`
--
ALTER TABLE `resident`
  ADD PRIMARY KEY (`residentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `maoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `brgyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `case`
--
ALTER TABLE `case`
  MODIFY `caseID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geolocation`
--
ALTER TABLE `geolocation`
  MODIFY `geoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100131;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `petID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `resident`
--
ALTER TABLE `resident`
  MODIFY `residentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `case`
--
ALTER TABLE `case`
  ADD CONSTRAINT `case_ibfk_1` FOREIGN KEY (`barangayID`) REFERENCES `barangay` (`brgyID`),
  ADD CONSTRAINT `case_ibfk_2` FOREIGN KEY (`petID`) REFERENCES `pet` (`petID`),
  ADD CONSTRAINT `case_ibfk_3` FOREIGN KEY (`residentID`) REFERENCES `resident` (`residentID`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`brgyID`) REFERENCES `barangay` (`brgyID`),
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`caseID`) REFERENCES `case` (`caseID`),
  ADD CONSTRAINT `notification_ibfk_3` FOREIGN KEY (`residentID`) REFERENCES `resident` (`residentID`);

--
-- Constraints for table `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `pet_ibfk_1` FOREIGN KEY (`residentID`) REFERENCES `resident` (`residentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
