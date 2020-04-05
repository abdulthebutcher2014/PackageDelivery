-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2020 at 06:22 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `packagedeliverydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

DROP TABLE IF EXISTS `deliveries`;
CREATE TABLE `deliveries` (
  `ID` int(11) NOT NULL,
  `FromLocation` int(11) NOT NULL,
  `ToLocation` int(11) NOT NULL,
  `Total` decimal(10,0) NOT NULL,
  `package` int(11) NOT NULL,
  `toUser` int(11) NOT NULL,
  `fromUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`ID`, `FromLocation`, `ToLocation`, `Total`, `package`, `toUser`, `fromUser`) VALUES
(1, 1, 1, '5', 23, 15, 25);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `package_delivery` (`package`),
  ADD KEY `fromLocation_packages` (`FromLocation`),
  ADD KEY `toLocation_package` (`ToLocation`),
  ADD KEY `fromUser_delivery` (`fromUser`),
  ADD KEY `toUser_delivery` (`toUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `fromUser_delivery` FOREIGN KEY (`fromUser`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `package_delivery` FOREIGN KEY (`package`) REFERENCES `packages` (`ID`),
  ADD CONSTRAINT `toUser_delivery` FOREIGN KEY (`toUser`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
