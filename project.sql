-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2024 at 10:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminn`
--

CREATE TABLE `adminn` (
  `id` int(11) NOT NULL,
  `name` varchar(22) NOT NULL,
  `email` varchar(22) NOT NULL,
  `password` varchar(22) NOT NULL,
  `sex` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminn`
--

INSERT INTO `adminn` (`id`, `name`, `email`, `password`, `sex`) VALUES
(1, 'chriss', 'chriss@gmail.com', 'chriss', 'female'),
(2, 'clarisse', 'cla@gmail.com', 'clarisse', 'female');

-- --------------------------------------------------------

--
-- Table structure for table `mantainance`
--

CREATE TABLE `mantainance` (
  `mid` int(11) NOT NULL,
  `rname` varchar(22) NOT NULL,
  `bname` varchar(22) NOT NULL,
  `username` varchar(22) NOT NULL,
  `description` varchar(100) NOT NULL,
  `telephone` varchar(22) NOT NULL,
  `date` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mantainance`
--

INSERT INTO `mantainance` (`mid`, `rname`, `bname`, `username`, `description`, `telephone`, `date`) VALUES
(2, 'b1', 'uwayezu', 'felix', 'guhomoka', '075868676', '12/16/2024'),
(3, 'rr', 'rr', 'rr', 'rr', 'rr', 'rr'),
(4, 'rr', 'rr', 'rr', 'rr', 'rr', 'rr'),
(5, 'er', 'b1', 'ee', 'damaged sockert', '0456788', '2024-04-02'),
(6, 'b17', '17', 'clarisse', 'all desks and tables in our room are damaged', '07896543123', '12 march 2024');

-- --------------------------------------------------------

--
-- Table structure for table `pending_rooms`
--

CREATE TABLE `pending_rooms` (
  `pending_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `booked_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action` varchar(22) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_rooms`
--

INSERT INTO `pending_rooms` (`pending_id`, `room_id`, `booked_date`, `action`, `user_id`) VALUES
(1, 28, '2024-04-03 07:21:07', 'Approved', NULL),
(2, 17, '2024-04-03 07:22:25', 'Approved', 1),
(3, 27, '2024-04-03 07:23:23', 'Approved', NULL),
(4, 18, '2024-04-03 07:45:18', 'Approved', 1),
(5, 19, '2024-04-03 07:58:51', 'Approved', 1),
(10, 26, '2024-04-03 08:56:58', 'Approved', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(22) NOT NULL,
  `block` varchar(22) NOT NULL,
  `price` int(11) NOT NULL,
  `beds` int(11) NOT NULL,
  `dates` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `block`, `price`, `beds`, `dates`) VALUES
(17, 'lab3', 'l2hos', 200, 22, '2024-04-01 22:00:00.000000'),
(18, 'b17', '17', 33, 3, '2024-04-01 22:00:00.000000'),
(19, 'v12', 'byaruguru', 10000, 1, '2024-04-04 22:00:00.000000'),
(20, '234rr', 'b1', 4567, 6, '2024-04-01 22:00:00.000000'),
(21, '234rr', 'b1', 4567, 6, '2024-04-01 22:00:00.000000'),
(22, '234rr', 'b1', 4567, 6, '2024-04-01 22:00:00.000000'),
(23, '234rr', 'b1', 4567, 6, '2024-04-01 22:00:00.000000'),
(24, '234rr', 'b1', 4567, 6, '2024-04-01 22:00:00.000000'),
(25, '234rr', 'b1', 4567, 6, '2024-04-01 22:00:00.000000'),
(26, 'fdghj', 'erghtjyukli;o', 2147483647, 45677, '2024-04-01 22:00:00.000000'),
(27, 'b16', 'b1', 56, 55, '2024-04-01 22:00:00.000000'),
(28, 'r4', 'b1', 5000, 8, '2024-04-02 22:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(22) NOT NULL,
  `number` varchar(22) NOT NULL,
  `sex` varchar(5) NOT NULL,
  `location` varchar(22) NOT NULL,
  `password` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `sex`, `location`, `password`) VALUES
(1, 'felix', 'felix@gmail.com', '0789786352', 'femal', 'gake', 'felix'),
(3, 'ester', 'ester@gmail.com', '97696', 'femal', 'muhanga', 'ester'),
(14, 'kevin', 'email@gmail.com', '0785678545678765', 'tumba', 'clear', 'ttt'),
(15, 'felix2', 'fg@gmail.com', '+250794567865', 'm', 'tumba', 'bbbb');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminn`
--
ALTER TABLE `adminn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mantainance`
--
ALTER TABLE `mantainance`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `pending_rooms`
--
ALTER TABLE `pending_rooms`
  ADD PRIMARY KEY (`pending_id`),
  ADD KEY `pending_rooms_ibfk_1` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminn`
--
ALTER TABLE `adminn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mantainance`
--
ALTER TABLE `mantainance`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pending_rooms`
--
ALTER TABLE `pending_rooms`
  MODIFY `pending_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pending_rooms`
--
ALTER TABLE `pending_rooms`
  ADD CONSTRAINT `pending_rooms_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pending_rooms_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
