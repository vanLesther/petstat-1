-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2023 at 12:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `brgyID` int(11) NOT NULL,
  `geoID` int(11) NOT NULL,
  `barangay` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `caseGeoID` int(11) NOT NULL,
  `petID` int(11) NOT NULL,
  `victimsName` varchar(50) NOT NULL,
  `caseType` tinyint(1) NOT NULL,
  `description` varchar(500) NOT NULL,
  `caseStatus` tinyint(1) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `case`
--

INSERT INTO `case` (`caseID`, `barangayID`, `residentID`, `caseGeoID`, `petID`, `victimsName`, `caseType`, `description`, `caseStatus`, `date`) VALUES
(1, 43, 28, 100146, 1, 'sfa', 0, 'hahaha', 1, '2023-11-03 02:14:40'),
(2, 43, 28, 100147, 11, 'hans', 0, 'test', 0, '2023-11-03 02:16:54'),
(3, 43, 28, 100149, 1, 'sfa', 0, 'test', 1, '2023-11-03 02:23:35'),
(4, 43, 28, 100150, 1, 'sfa', 0, 'hahaha', 0, '2023-11-03 02:26:36'),
(5, 43, 28, 100151, 1, 'sfa', 0, 'hahaha', 0, '2023-11-03 02:26:36'),
(6, 43, 28, 100152, 1, 'sfa', 0, 'hahaha', 1, '2023-11-03 02:35:18'),
(7, 43, 28, 100153, 1, 'sfa', 0, 'hahaha', 0, '2023-11-03 02:35:19'),
(8, 43, 28, 100154, 7, 'van', 0, 'test2', 0, '2023-11-03 02:41:49'),
(9, 43, 38, 100169, 1, 'Van Lesther', 0, 'Test', 0, '2023-11-04 15:48:22'),
(10, 43, 38, 100170, 1, 'Van Lesther', 0, 'Test', 0, '2023-11-04 15:48:22'),
(11, 43, 40, 100173, 16, 'test victim', 0, 'test test', 1, '2023-11-05 10:16:59'),
(12, 43, 40, 100174, 16, 'test victim', 0, 'test test', 2, '2023-11-05 10:16:59'),
(13, 43, 40, 100175, 11, 'hans', 0, 'Test', 0, '2023-11-05 10:18:13'),
(14, 43, 40, 100176, 11, 'hans', 0, 'Test', 0, '2023-11-05 10:18:13'),
(15, 43, 40, 100177, 1, 'van', 0, 'fghfgjh', 0, '2023-11-05 10:26:20'),
(16, 43, 40, 100178, 1, 'van', 0, 'fghfgjh', 0, '2023-11-05 10:26:20'),
(17, 43, 40, 100179, 15, 'sfa', 0, 'fghfgjh', 0, '2023-11-05 10:34:56'),
(18, 43, 40, 100180, 15, 'sfa', 0, 'fghfgjh', 0, '2023-11-05 10:34:56'),
(19, 43, 40, 100181, 23, 'Van Lesther', 0, 'Test', 0, '2023-11-19 08:09:32'),
(21, 43, 40, 100185, 1, '', 1, '', 1, '2023-11-19 08:52:48'),
(22, 43, 40, 100186, 1, '', 1, '', 0, '2023-11-19 08:59:11');

-- --------------------------------------------------------

--
-- Table structure for table `geolocation`
--

CREATE TABLE `geolocation` (
  `geoID` int(11) NOT NULL,
  `latitude` decimal(9,6) NOT NULL,
  `longitude` decimal(9,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `geolocation`
--

INSERT INTO `geolocation` (`geoID`, `latitude`, `longitude`) VALUES
(100000, 10.848964, 122.461899),
(100001, 10.883751, 122.473368),
(100002, 10.886936, 122.470015),
(100003, 10.884943, 122.517209),
(100004, 10.885794, 122.487165),
(100005, 10.893027, 122.499433),
(100006, 10.884555, 122.461535),
(100007, 10.922577, 122.535072),
(100009, 10.872372, 122.490318),
(100010, 10.937175, 122.477458),
(100011, 10.872403, 122.524800),
(100012, 10.882848, 122.533492),
(100013, 10.912917, 122.513968),
(100014, 10.852573, 122.479204),
(100015, 10.842126, 122.485694),
(100016, 10.853218, 122.490344),
(100017, 10.917746, 122.504353),
(100018, 10.936122, 122.489249),
(100020, 10.866239, 122.435766),
(100021, 10.852873, 122.453128),
(100022, 10.902666, 122.518559),
(100023, 10.906923, 122.475892),
(100026, 10.915980, 122.542807),
(100028, 10.922051, 122.521360),
(100029, 10.929424, 122.508033),
(100030, 10.907501, 122.527269),
(100031, 10.902759, 122.536477),
(100032, 10.864485, 122.454927),
(100033, 10.881789, 122.493425),
(100034, 10.882383, 122.510449),
(100035, 10.833569, 122.479969),
(100036, 10.889842, 122.507638),
(100037, 10.871116, 122.450295),
(100038, 10.915394, 122.530480),
(100039, 10.918942, 122.500394),
(100040, 10.860267, 122.483772),
(100041, 10.876586, 122.459645),
(100042, 10.879060, 122.465502),
(100054, 10.869324, 122.501311),
(100055, 10.883180, 122.525263),
(100056, 10.872054, 122.476270),
(100057, 10.906462, 122.500250),
(100058, 10.860234, 122.499710),
(100059, 10.896689, 122.488930),
(100060, 10.850311, 122.517943),
(100061, 10.921707, 122.488367),
(100062, 10.856930, 122.482571),
(100063, 10.854668, 122.507196),
(100064, 10.864334, 122.465748),
(100065, 10.853915, 122.472327),
(100090, 10.668400, 122.959200),
(100091, 10.668400, 122.959200),
(100092, 10.668400, 122.959200),
(100093, 10.668400, 122.959200),
(100094, 10.668400, 122.959200),
(100095, 10.668400, 122.959200),
(100096, 10.668400, 122.959200),
(100097, 10.668400, 122.959200),
(100098, 10.668400, 122.959200),
(100099, 10.668400, 122.959200),
(100100, 10.668400, 122.959200),
(100101, 10.668400, 122.959200),
(100102, 10.668400, 122.959200),
(100103, 10.668400, 122.959200),
(100104, 10.668400, 122.959200),
(100105, 10.668400, 122.959200),
(100106, 10.668400, 122.959200),
(100107, 10.668400, 122.959200),
(100108, 10.668400, 122.959200),
(100109, 10.668400, 122.959200),
(100110, 10.668400, 122.959200),
(100111, 10.668400, 122.959200),
(100112, 10.668400, 122.959200),
(100113, 10.668400, 122.959200),
(100114, 10.668400, 122.959200),
(100115, 10.668400, 122.959200),
(100116, 10.668400, 122.959200),
(100117, 10.668400, 122.959200),
(100118, 10.668400, 122.959200),
(100119, 10.668400, 122.959200),
(100120, 10.668400, 122.959200),
(100121, 10.668400, 122.959200),
(100122, 10.668400, 122.959200),
(100123, 10.668400, 122.959200),
(100124, 10.668400, 122.959200),
(100125, 10.668400, 122.959200),
(100126, 10.668400, 122.959200),
(100127, 10.879060, 122.465502),
(100128, 10.856930, 122.482571),
(100129, 10.860234, 122.499710),
(100130, 10.833569, 122.479969),
(100131, 0.000000, 0.000000),
(100132, 0.000000, 0.000000),
(100133, 0.000000, 0.000000),
(100134, 0.000000, 0.000000),
(100135, 0.000000, 0.000000),
(100136, 0.000000, 0.000000),
(100137, 0.000000, 0.000000),
(100138, 0.000000, 0.000000),
(100139, 0.000000, 0.000000),
(100140, 0.000000, 0.000000),
(100141, 0.000000, 0.000000),
(100142, 0.000000, 0.000000),
(100143, 0.000000, 0.000000),
(100144, 0.000000, 0.000000),
(100145, 0.000000, 0.000000),
(100146, 0.000000, 0.000000),
(100147, 0.000000, 0.000000),
(100148, 10.309900, 123.893000),
(100149, 0.000000, 0.000000),
(100150, 0.000000, 0.000000),
(100151, 10.309900, 123.893000),
(100152, 0.000000, 0.000000),
(100153, 10.309900, 123.893000),
(100154, 0.000000, 0.000000),
(100155, 10.309900, 123.893000),
(100156, 10.309900, 123.893000),
(100157, 10.309900, 123.893000),
(100158, 10.309900, 123.893000),
(100159, 10.309900, 123.893000),
(100160, 10.309900, 123.893000),
(100161, 10.309900, 123.893000),
(100162, 10.309900, 123.893000),
(100163, 10.309900, 123.893000),
(100164, 10.309900, 123.893000),
(100165, 10.309900, 123.893000),
(100166, 10.309900, 123.893000),
(100167, 10.879060, 122.465502),
(100168, 10.879060, 122.465502),
(100169, 0.000000, 0.000000),
(100170, 10.309900, 123.893000),
(100171, 10.879060, 122.465502),
(100172, 10.879060, 122.465502),
(100173, 0.000000, 0.000000),
(100174, 10.309900, 123.893000),
(100175, 0.000000, 0.000000),
(100176, 10.309900, 123.893000),
(100177, 0.000000, 0.000000),
(100178, 10.309900, 123.893000),
(100179, 0.000000, 0.000000),
(100180, 10.309900, 123.893000),
(100181, 10.309900, 123.893000),
(100182, 0.000000, 0.000000),
(100183, 0.000000, 0.000000),
(100184, 0.000000, 0.000000),
(100185, 0.000000, 0.000000),
(100186, 0.000000, 0.000000);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `vacID` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `petDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`petID`, `residentID`, `petType`, `pname`, `sex`, `color`, `vacID`, `status`, `petDate`) VALUES
(1, 28, 0, 'petstat', 0, 'black', 0, 1, '2023-11-19 09:05:47'),
(2, 28, 1, 'petstat', 0, 'black', 0, 1, '2023-11-19 09:05:47'),
(3, 31, 1, 'vanilla', 1, 'black and white', 0, 2, '2023-11-19 09:05:47'),
(4, 31, 1, 'vanilla', 1, 'black and white', 0, 1, '2023-11-19 09:05:47'),
(5, 31, 1, 'vanilla', 1, 'black and white', 0, 0, '2023-11-19 09:05:47'),
(6, 31, 1, 'mocha', 1, 'brown with stri', 0, 0, '2023-11-19 09:05:47'),
(7, 27, 0, 'van lesther Farol', 0, 'black and white', 0, 0, '2023-11-19 09:05:47'),
(8, 27, 0, 'van lesther Farol', 0, 'black and white', 0, 0, '2023-11-19 09:05:47'),
(9, 27, 0, 'petstat', 1, '12', 0, 0, '2023-11-19 09:05:47'),
(10, 27, 0, 'petstata', 0, 'black and white', 0, 0, '2023-11-19 09:05:47'),
(11, 27, 1, 'ERTER', 0, 'black and white', 0, 0, '2023-11-19 09:05:47'),
(12, 27, 1, 'petstat', 0, 'black and white', 0, 0, '2023-11-19 09:05:47'),
(13, 27, 0, 'petstat', 0, 'black and white', 0, 0, '2023-11-19 09:05:47'),
(14, 27, 0, 'petstat', 0, 'black and white', 0, 0, '2023-11-19 09:05:47'),
(15, 38, 0, 'test pet', 0, 'black and white', 0, 0, '2023-11-19 09:05:47'),
(16, 40, 0, 'pam G', 0, 'brown with stripes', 0, 0, '2023-11-19 09:05:47'),
(17, 40, 1, 'lester', 0, 'white', 0, 0, '2023-11-19 09:05:47'),
(18, 40, 1, 'lester', 0, 'white', 0, 0, '2023-11-19 09:05:47'),
(19, 40, 0, 'hjans', 0, 'white', 0, 0, '2023-11-19 09:05:47'),
(20, 40, 0, 'hjans', 0, 'white', 0, 0, '2023-11-19 09:05:47'),
(21, 40, 1, 'van', 0, 'black', 0, 0, '2023-11-19 09:05:47'),
(22, 40, 0, 'vas', 0, 'white', 0, 0, '2023-11-19 09:05:47'),
(23, 40, 1, 'tala', 1, 'brown with stripes', 0, 0, '2023-11-19 09:05:47'),
(24, 40, 0, 'petstat', 1, 'brown with stripes', 0, 0, '0000-00-00 00:00:00'),
(25, 40, 0, 'petstat', 1, 'brown with stripes', 0, 0, '0000-00-00 00:00:00'),
(26, 40, 1, 'petstat', 0, 'brown with stripes', 0, 0, '0000-00-00 00:00:00'),
(27, 40, 1, 'petstat', 0, 'brown with stripes', 0, 0, '2023-11-19 02:19:03'),
(28, 40, 0, 'petstat', 1, 'white', 0, 1, '2023-11-19 02:19:18'),
(29, 40, 0, 'petstat', 1, 'white', 0, 1, '2023-11-19 02:19:47'),
(30, 40, 0, 'van lesther Farol', 0, 'brown', 0, 0, '2023-11-19 11:32:35');

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
  `password` varchar(255) NOT NULL,
  `userType` tinyint(1) NOT NULL DEFAULT 0,
  `userStatus` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`residentID`, `geoID`, `brgyID`, `name`, `contactNo`, `email`, `password`, `userType`, `userStatus`) VALUES
(27, 100126, 44, 'van lesther Farol', '09933715629', 'v4n0613@gmail.com', '123', 0, 1),
(28, 100127, 43, 'petstat', '09933715629', 'qwerty@qwerty.qwerty', '111', 1, 0),
(29, 100128, 63, 'hans francis', '09754561234', 'hans@gmail.com', '123', 0, 0),
(30, 100129, 59, 'louvenn', '09736732234', 'loben@gmail.com', '123', 0, 0),
(31, 100130, 36, 'van lesther', '09933715629', 'v4n06a13@gmail.com', 'asd', 0, 0),
(32, 100148, 5, 'van', '09933715629', 'vanlesther.farol@students.isatu.edu.ph', 'aaa', 0, 0),
(33, 100157, 43, 'van', '09933715629', 'qwerty@qwerty.qwerty1', '$2y$10$qTY4LDZiwBieOte3T1eWJOx', 0, 0),
(34, 100158, 43, 'petstat', '09933715629', 'vanleatherfarol@gmail.com1', '$2y$10$DqbDIq/HGmiZ.nqCDkBQAOr', 0, 0),
(35, 100163, 42, 'sdas', '09933715629', 'vanlesther44@gmail.com1', '$2y$10$lTMsUIK5No9lc9ZbMDWG0.9', 0, 0),
(36, 100165, 43, 'hjans', '09933715629', 'qwerty@qwerty.qwerty11', '$2y$10$T2bzhrtFCXjri0jOiINkqOE', 0, 0),
(37, 100167, 43, 'hjans', '09933715629', 'qwerty@qwerty.qwerty000', '$2y$10$Cx6glXeSgF1oskOU1FFAF.u/SfdH5OZjtWHf38xnC/4Y34SazOnT6', 0, 0),
(38, 100168, 43, 'Van Lesther Farol', '09933715629', 'Vanlesther.farol@gmail.com', '$2y$10$xezVOAtVyOzpDNRHmSlwf.RjjdwAi3EUfRcTFhii7JTFWnHxTZJr2', 1, 0),
(39, 100171, 43, 'TESTVANUSER', '09933715629', 'test@user.van', '$2y$10$7L.Bd80xTME.zGIEj8YCBuAOHvTn0GLesWC8FrpHI0FTKnvEI7FdC', 0, 0),
(40, 100172, 43, 'user PamG', '09933715629', 'user@pamg.cab', '$2y$10$eBMuzhJGfhp65YgC16SW5OYT2.L7eJGVW17NmpU8pORY4BNUt6dNu', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vaccination`
--

CREATE TABLE `vaccination` (
  `vacID` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD KEY `residentID` (`residentID`),
  ADD KEY `caseGeoID` (`caseGeoID`);

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
  ADD KEY `residentID` (`residentID`),
  ADD KEY `vacID` (`vacID`);

--
-- Indexes for table `resident`
--
ALTER TABLE `resident`
  ADD PRIMARY KEY (`residentID`),
  ADD KEY `geoID` (`geoID`),
  ADD KEY `brgyID` (`brgyID`);

--
-- Indexes for table `vaccination`
--
ALTER TABLE `vaccination`
  ADD PRIMARY KEY (`vacID`);

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
  MODIFY `caseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `geolocation`
--
ALTER TABLE `geolocation`
  MODIFY `geoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100187;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `petID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `resident`
--
ALTER TABLE `resident`
  MODIFY `residentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `vaccination`
--
ALTER TABLE `vaccination`
  MODIFY `vacID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `case`
--
ALTER TABLE `case`
  ADD CONSTRAINT `case_ibfk_1` FOREIGN KEY (`barangayID`) REFERENCES `barangay` (`brgyID`),
  ADD CONSTRAINT `case_ibfk_2` FOREIGN KEY (`petID`) REFERENCES `pet` (`petID`),
  ADD CONSTRAINT `case_ibfk_3` FOREIGN KEY (`residentID`) REFERENCES `resident` (`residentID`),
  ADD CONSTRAINT `case_ibfk_5` FOREIGN KEY (`caseGeoID`) REFERENCES `geolocation` (`geoID`);

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

--
-- Constraints for table `resident`
--
ALTER TABLE `resident`
  ADD CONSTRAINT `resident_ibfk_1` FOREIGN KEY (`geoID`) REFERENCES `geolocation` (`geoID`),
  ADD CONSTRAINT `resident_ibfk_2` FOREIGN KEY (`brgyID`) REFERENCES `barangay` (`brgyID`);

--
-- Constraints for table `vaccination`
--
ALTER TABLE `vaccination`
  ADD CONSTRAINT `vaccination_ibfk_1` FOREIGN KEY (`vacID`) REFERENCES `pet` (`vacID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
