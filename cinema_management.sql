-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 12:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinema_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_current_user`
--

CREATE TABLE `app_current_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `app_current_user`
--

INSERT INTO `app_current_user` (`id`, `username`) VALUES
(1, 'Sharaya');

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` int(11) NOT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `operation` varchar(10) DEFAULT NULL,
  `old_values` text DEFAULT NULL,
  `new_values` text DEFAULT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `changed_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `table_name`, `operation`, `old_values`, `new_values`, `changed_at`, `changed_by`) VALUES
(1, 'film', 'INSERT', NULL, 'filmID=24, language=Tal, title=Enthiran, screen=download (5)94804.jpeg', '2025-01-02 13:46:57', 'Flying'),
(2, 'film', 'UPDATE', 'filmID=24, language=Tal, title=Enthiran, screen=download (5)94804.jpeg', 'filmID=24, language=Tal, title=Enthiran 2, screen=download (1)26855.jpeg', '2025-01-02 13:47:42', 'Flying'),
(3, 'film', 'DELETE', 'filmID=24, language=Tal, title=Enthiran 2, screen=download (1)26855.jpeg', NULL, '2025-01-02 13:47:58', 'Flying'),
(4, 'ticket', 'UPDATE', 'ticketID=7, ticket=VIP, price=32.50', 'ticketID=7, ticket=VIP, price=30.00', '2025-01-02 15:56:38', 'Sharaya'),
(5, 'staff', 'INSERT', NULL, 'staffID=DrNava, staffpassword=k2WU89jq6xNq, name=Navaneethan, staffStatus=Staff', '2025-01-06 09:39:26', 'Flying'),
(6, 'staff', 'UPDATE', 'staffID=Sharaya, staffpassword=gEOU99ihug==, name=Sharvinthiran, staffStatus=Staff', 'staffID=Sharaya, staffpassword=k3id5Mu5okJrTUrW, name=Sharvinthiran, staffStatus=Staff', '2025-01-06 10:07:56', 'Flying');

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `filmID` int(5) NOT NULL,
  `language` varchar(5) DEFAULT NULL,
  `title` varchar(40) DEFAULT NULL,
  `screen` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`filmID`, `language`, `title`, `screen`) VALUES
(17, 'Eng', 'Moana 2', 'images87939.jpeg'),
(18, 'Mly', 'Venom The Last Dance', 'download (2)89291.jpeg'),
(19, 'Chn', 'Popeye', 'download47394.jpeg'),
(20, 'Tal', 'Quantomania', 'download (1)75549.jpeg'),
(23, 'Eng', 'Cars The Movie', 'download (4)71709.jpeg');

--
-- Triggers `film`
--
DELIMITER $$
CREATE TRIGGER `after_delete_film` AFTER DELETE ON `film` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, old_values, changed_by)
    VALUES (
        'film',
        'DELETE',
        CONCAT('filmID=', OLD.filmID, ', language=', OLD.language, ', title=', OLD.title, ', screen=', OLD.screen),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_film` AFTER INSERT ON `film` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, new_values, changed_by)
    VALUES (
        'film',
        'INSERT',
        CONCAT('filmID=', NEW.filmID, ', language=', NEW.language, ', title=', NEW.title, ', screen=', NEW.screen),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_film` AFTER UPDATE ON `film` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, old_values, new_values, changed_by)
    VALUES (
        'film',
        'UPDATE',
        CONCAT('filmID=', OLD.filmID, ', language=', OLD.language, ', title=', OLD.title, ', screen=', OLD.screen),
        CONCAT('filmID=', NEW.filmID, ', language=', NEW.language, ', title=', NEW.title, ', screen=', NEW.screen),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hall`
--

CREATE TABLE `hall` (
  `hallID` int(5) NOT NULL,
  `hallName` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hall`
--

INSERT INTO `hall` (`hallID`, `hallName`) VALUES
(1, 'Alpha'),
(2, 'Beta'),
(3, 'Cosmos'),
(4, 'Delta'),
(6, 'Rose'),
(8, 'Elegant');

--
-- Triggers `hall`
--
DELIMITER $$
CREATE TRIGGER `after_delete_hall` AFTER DELETE ON `hall` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, old_values, changed_by)
    VALUES (
        'hall',
        'DELETE',
        CONCAT('hallID=', OLD.hallID, ', hallName=', OLD.hallName),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_hall` AFTER INSERT ON `hall` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, new_values, changed_by)
    VALUES (
        'hall',
        'INSERT',
        CONCAT('hallID=', NEW.hallID, ', hallName=', NEW.hallName),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_hall` AFTER UPDATE ON `hall` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, old_values, new_values, changed_by)
    VALUES (
        'hall',
        'UPDATE',
        CONCAT('hallID=', OLD.hallID, ', hallName=', OLD.hallName),
        CONCAT('hallID=', NEW.hallID, ', hallName=', NEW.hallName),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ipaddress`
--

CREATE TABLE `ipaddress` (
  `id` int(11) NOT NULL,
  `ipaddress` varchar(255) NOT NULL,
  `staffID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ipaddress`
--

INSERT INTO `ipaddress` (`id`, `ipaddress`, `staffID`) VALUES
(1, '127.0.0.1', 'Flying'),
(2, '192.168.100.115', 'Flying'),
(3, '192.168.100.99', 'Flying'),
(4, '::1', 'Flying'),
(5, '::1', 'Sharaya');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `salesID` bigint(6) UNSIGNED ZEROFILL NOT NULL,
  `showtimingID` int(5) DEFAULT NULL,
  `salesDate` date DEFAULT NULL,
  `salesTime` time DEFAULT NULL,
  `hallID` int(5) DEFAULT NULL,
  `ticketID` int(5) DEFAULT NULL,
  `filmID` int(5) DEFAULT NULL,
  `staffID` varchar(20) DEFAULT NULL,
  `seatNumber` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`salesID`, `showtimingID`, `salesDate`, `salesTime`, `hallID`, `ticketID`, `filmID`, `staffID`, `seatNumber`) VALUES
(000027, 32, '2025-01-01', '15:20:20', 2, 3, 17, 'Flying', 'A1'),
(000028, 33, '2025-01-01', '15:21:31', 4, 3, 17, 'Flying', 'A8'),
(000029, 34, '2025-01-01', '15:29:12', 6, 2, 20, 'Flying', 'A18'),
(000030, 35, '2025-01-01', '17:55:34', 4, 3, 19, 'GreenChai', 'A12'),
(000031, 34, '2025-01-01', '18:18:35', 6, 2, 20, 'Flying', 'A17'),
(000032, 33, '2025-01-01', '18:21:55', 4, 1, 17, 'Flying', 'A16');

--
-- Triggers `sales`
--
DELIMITER $$
CREATE TRIGGER `after_delete_sales` AFTER DELETE ON `sales` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, old_values, changed_by)
    VALUES (
        'sales',
        'DELETE',
        CONCAT('salesID=', OLD.salesID, ', ticketID=', OLD.ticketID),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_sales` AFTER INSERT ON `sales` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, new_values, changed_by)
    VALUES (
        'sales',
        'INSERT',
        CONCAT('salesID=', NEW.salesID, ', ticketID=', NEW.ticketID),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_sales` AFTER UPDATE ON `sales` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, old_values, new_values, changed_by)
    VALUES (
        'sales',
        'UPDATE',
        CONCAT('salesID=', OLD.salesID, ', ticketID=', OLD.ticketID),
        CONCAT('salesID=', NEW.salesID, ', ticketID=', NEW.ticketID),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `showtiming`
--

CREATE TABLE `showtiming` (
  `showtimingID` int(5) NOT NULL,
  `starttime` time DEFAULT NULL,
  `showdate` date DEFAULT NULL,
  `screen` varchar(200) NOT NULL,
  `filmID` varchar(30) NOT NULL,
  `hallID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `showtiming`
--

INSERT INTO `showtiming` (`showtimingID`, `starttime`, `showdate`, `screen`, `filmID`, `hallID`) VALUES
(32, '10:00:00', '2025-01-03', 'images87939.jpeg', '17', '2'),
(33, '11:00:00', '2025-01-02', 'images87939.jpeg', '17', '4'),
(34, '12:00:00', '2025-02-02', 'download (1)75549.jpeg', '20', '6'),
(35, '22:10:00', '2025-01-02', 'download47394.jpeg', '19', '4'),
(38, '12:30:00', '2025-01-04', 'download (4)71709.jpeg', '23', '8');

--
-- Triggers `showtiming`
--
DELIMITER $$
CREATE TRIGGER `after_delete_showtiming` AFTER DELETE ON `showtiming` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, old_values, changed_by)
    VALUES (
        'showtiming',
        'DELETE',
        CONCAT('showtimingID=', OLD.showtimingID, ', starttime=', OLD.starttime, ', showdate=', OLD.showdate),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_showtiming` AFTER INSERT ON `showtiming` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, new_values, changed_by)
    VALUES (
        'showtiming',
        'INSERT',
        CONCAT('showtimingID=', NEW.showtimingID, ', starttime=', NEW.starttime, ', showdate=', NEW.showdate),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_showtiming` AFTER UPDATE ON `showtiming` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, old_values, new_values, changed_by)
    VALUES (
        'showtiming',
        'UPDATE',
        CONCAT('showtimingID=', OLD.showtimingID, ', starttime=', OLD.starttime, ', showdate=', OLD.showdate),
        CONCAT('showtimingID=', NEW.showtimingID, ', starttime=', NEW.starttime, ', showdate=', NEW.showdate),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` varchar(20) NOT NULL,
  `staffpassword` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `staffStatus` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `staffpassword`, `name`, `staffStatus`) VALUES
('ChairsTable', 'kEOU7Mur', 'Muhd Aqil', 'Admin'),
('DrNava', 'k2WU89jq6xNq', 'Navaneethan', 'Staff'),
('Flying', 'h06H99aquU84GR8=', 'Kalla Deveshwara Rao', 'Admin'),
('GreenChai', 'mEKH8di2uktrTUrW', 'Kirtanah Manalan', 'Admin'),
('Sharaya', 'k3id5Mu5okJrTUrW', 'Sharvinthiran', 'Staff'),
('Vimal', 'hUKY5NXo7AI=', 'Vimal Rich', 'Staff');

--
-- Triggers `staff`
--
DELIMITER $$
CREATE TRIGGER `after_delete_staff` AFTER DELETE ON `staff` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, old_values, changed_by)
    VALUES (
        'staff',
        'DELETE',
        CONCAT('staffID=', OLD.staffID, ', staffpassword=', OLD.staffpassword, ', name=', OLD.name, ', staffStatus=', OLD.staffStatus),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_staff` AFTER INSERT ON `staff` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, new_values, changed_by)
    VALUES (
        'staff',
        'INSERT',
        CONCAT('staffID=', NEW.staffID, ', staffpassword=', NEW.staffpassword, ', name=', NEW.name, ', staffStatus=', NEW.staffStatus),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_staff` AFTER UPDATE ON `staff` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, old_values, new_values, changed_by)
    VALUES (
        'staff',
        'UPDATE',
        CONCAT('staffID=', OLD.staffID, ', staffpassword=', OLD.staffpassword, ', name=', OLD.name, ', staffStatus=', OLD.staffStatus),
        CONCAT('staffID=', NEW.staffID, ', staffpassword=', NEW.staffpassword, ', name=', NEW.name, ', staffStatus=', NEW.staffStatus),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `staff_view`
-- (See below for the actual view)
--
CREATE TABLE `staff_view` (
`masked_staffID` mediumtext
,`name` varchar(50)
,`staffStatus` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticketID` int(5) NOT NULL,
  `ticket` varchar(15) DEFAULT NULL,
  `price` float(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticketID`, `ticket`, `price`) VALUES
(1, 'Adult', 15.00),
(2, 'Children', 13.00),
(3, 'Senior', 10.00),
(7, 'VIP', 30.00);

--
-- Triggers `ticket`
--
DELIMITER $$
CREATE TRIGGER `after_delete_ticket` AFTER DELETE ON `ticket` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, old_values, changed_by)
    VALUES (
        'ticket',
        'DELETE',
        CONCAT('ticketID=', OLD.ticketID, ', ticket=', OLD.ticket, ', price=', OLD.price),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_ticket` AFTER INSERT ON `ticket` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, new_values, changed_by)
    VALUES (
        'ticket',
        'INSERT',
        CONCAT('ticketID=', NEW.ticketID, ', ticket=', NEW.ticket, ', price=', NEW.price),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_ticket` AFTER UPDATE ON `ticket` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, operation, old_values, new_values, changed_by)
    VALUES (
        'ticket',
        'UPDATE',
        CONCAT('ticketID=', OLD.ticketID, ', ticket=', OLD.ticket, ', price=', OLD.price),
        CONCAT('ticketID=', NEW.ticketID, ', ticket=', NEW.ticket, ', price=', NEW.price),
        (SELECT username FROM app_current_user LIMIT 1)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `staff_view`
--
DROP TABLE IF EXISTS `staff_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `staff_view`  AS SELECT concat(left(`staff`.`staffID`,1),repeat('*',octet_length(`staff`.`staffID`) - 1)) AS `masked_staffID`, `staff`.`name` AS `name`, `staff`.`staffStatus` AS `staffStatus` FROM `staff` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_current_user`
--
ALTER TABLE `app_current_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`filmID`);

--
-- Indexes for table `hall`
--
ALTER TABLE `hall`
  ADD PRIMARY KEY (`hallID`);

--
-- Indexes for table `ipaddress`
--
ALTER TABLE `ipaddress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`salesID`),
  ADD KEY `IDJadual` (`showtimingID`),
  ADD KEY `IDBilik` (`hallID`),
  ADD KEY `IDTiket` (`ticketID`),
  ADD KEY `IDFilem` (`filmID`),
  ADD KEY `IDStaf` (`staffID`);

--
-- Indexes for table `showtiming`
--
ALTER TABLE `showtiming`
  ADD PRIMARY KEY (`showtimingID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticketID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_current_user`
--
ALTER TABLE `app_current_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `filmID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `hall`
--
ALTER TABLE `hall`
  MODIFY `hallID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ipaddress`
--
ALTER TABLE `ipaddress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `salesID` bigint(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `showtiming`
--
ALTER TABLE `showtiming`
  MODIFY `showtimingID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticketID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`showtimingID`) REFERENCES `showtiming` (`showtimingID`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`hallID`) REFERENCES `hall` (`hallID`),
  ADD CONSTRAINT `sales_ibfk_3` FOREIGN KEY (`filmID`) REFERENCES `film` (`filmID`),
  ADD CONSTRAINT `sales_ibfk_4` FOREIGN KEY (`ticketID`) REFERENCES `ticket` (`ticketID`),
  ADD CONSTRAINT `sales_ibfk_5` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
