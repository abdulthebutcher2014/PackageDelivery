-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2020 at 08:54 PM
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
CREATE DATABASE IF NOT EXISTS `packagedeliverydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `packagedeliverydb`;

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `ID` int(11) NOT NULL,
  `FromLocation` int(11) NOT NULL,
  `ToLocation` int(11) NOT NULL,
  `Total` decimal(10,0) NOT NULL,
  `package` int(11) NOT NULL,
  `toUser` int(11) NOT NULL,
  `fromUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `ID` int(11) NOT NULL,
  `City` varchar(20) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Distance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`ID`, `City`, `State`, `Distance`) VALUES
(14, 'Salt Lake City', 'UT', 800),
(18, 'Omaha', 'NE', 55),
(20, 'Lincoln', 'NE', 0);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `ID` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE `parameters` (
  `ID` int(11) NOT NULL,
  `Property` varchar(25) NOT NULL,
  `value` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parameters`
--

INSERT INTO `parameters` (`ID`, `Property`, `value`) VALUES
(1, 'baseprice', '6.5'),
(2, 'rate', '0.18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `LogonID` varchar(20) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `isAdministrator` tinyint(1) NOT NULL,
  `Email` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `LogonID`, `Password`, `isAdministrator`, `Email`) VALUES
(15, 'Phat Ho', 'pho', '$2y$10$yCiBQILk6WgbkBKDU8/T6eTEUHvKhRVpUU6iZItAVB9KgQrygDBo6', 1, 'today@fun.com'),
(23, 'Phat Ho', 'today', '$2y$10$Dr/tHNWFRzvKQXd7SjZzAO9KycQ7r1FlpabmQizSXwSMB65tyrIfi', 0, 'today@fun.com'),
(25, 'Adminstrator', 'admin', '$2y$10$NHHqfVP/.DKpvSYrfDeJbet83W8RgePT2IVyiyjOPJRRXf11Ds8zi', 1, 'admin@jeffware.com');

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
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parameters`
--
ALTER TABLE `parameters`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
