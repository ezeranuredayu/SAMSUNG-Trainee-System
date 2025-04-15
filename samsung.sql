-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 12:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `samsung`
--

-- --------------------------------------------------------

--
-- Table structure for table `kpi`
--

CREATE TABLE `kpi` (
  `kpi_no` int(11) NOT NULL,
  `kpi_trainee` varchar(50) NOT NULL,
  `kpi_date` date NOT NULL,
  `kpi_enddate` date NOT NULL,
  `kpi_store` varchar(3) NOT NULL,
  `kpi_hour` decimal(5,2) NOT NULL,
  `kpi_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kpi`
--

INSERT INTO `kpi` (`kpi_no`, `kpi_trainee`, `kpi_date`, `kpi_enddate`, `kpi_store`, `kpi_hour`, `kpi_status`) VALUES
(15, 'Muhammad Irfan Bin Azhar', '2025-03-01', '2025-03-07', '4', 5.00, 'Fully Achieve'),
(18, 'Muhammad Irfan Bin Azhar', '2025-03-22', '2025-03-15', '123', 131.00, 'Not Achieve'),
(19, 'Muhammad Irfan Bin Azhar', '2025-03-01', '2025-03-01', '1', 1.00, 'Not Achieve'),
(20, 'Muhammad Irfan Bin Azhar', '2025-03-22', '2025-03-16', '9', 9.00, 'Under Review'),
(22, 'Aina Abdul', '2025-04-07', '2025-04-12', '7', 24.00, 'Fully Achieve'),
(23, 'Muhammad Irfan Bin Azhar', '2025-04-06', '2025-04-09', '24', 48.00, 'Fully Achieve'),
(24, 'Aida Athirah Binti Haikal', '2025-04-01', '2025-04-15', '30', 110.00, 'Under Review'),
(25, 'Izzul Fikri', '2025-03-01', '2025-03-31', '40', 80.00, 'Under Review');

-- --------------------------------------------------------

--
-- Table structure for table `leave`
--

CREATE TABLE `leave` (
  `leave_no` int(11) NOT NULL,
  `leave_trainee` varchar(50) NOT NULL,
  `leave_date` date NOT NULL,
  `leave_category` varchar(50) NOT NULL,
  `leave_req` date NOT NULL,
  `leave_until` date NOT NULL,
  `leave_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave`
--

INSERT INTO `leave` (`leave_no`, `leave_trainee`, `leave_date`, `leave_category`, `leave_req`, `leave_until`, `leave_status`) VALUES
(6, 'Muhammad Irfan Bin Azhar', '2025-03-20', 'Medical Leave', '2025-03-20', '2025-03-22', 'Rejected'),
(7, 'Muhammad Irfan Bin Azhar', '2025-03-19', 'Emergency Leave', '2025-03-21', '2025-03-23', 'Pending'),
(9, 'Aina Abdul', '2025-04-07', 'Medical Leave', '2025-04-12', '2025-04-15', 'Rejected'),
(10, 'Muhammad Irfan Bin Azhar', '2025-04-09', 'Annual Leave', '2025-04-10', '2025-04-11', 'Rejected'),
(11, 'Aida Athirah Binti Haikal', '2025-04-15', 'Medical Leave', '2025-04-15', '2025-04-16', 'Pending'),
(12, 'Izzul Fikri', '2025-04-15', 'Emergency Leave', '2025-04-15', '2025-04-17', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `medical`
--

CREATE TABLE `medical` (
  `mc_no` int(11) NOT NULL,
  `mc_trainee` varchar(50) NOT NULL,
  `mc_senddate` date NOT NULL,
  `mc_date` date NOT NULL,
  `mc_slip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical`
--

INSERT INTO `medical` (`mc_no`, `mc_trainee`, `mc_senddate`, `mc_date`, `mc_slip`) VALUES
(7, 'Muhammad Irfan Bin Azhar', '2025-03-20', '2025-03-19', 'example mc.jpg'),
(8, 'Aida Athirah Binti Haikal', '2025-04-15', '2025-04-15', 'image.jpg'),
(9, 'Izzul Fikri', '2025-04-15', '2025-04-14', 'example mc.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_username` varchar(50) NOT NULL,
  `staff_password` varchar(255) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `staff_phone` varchar(12) NOT NULL,
  `staff_email` varchar(100) NOT NULL,
  `staff_area` varchar(100) NOT NULL,
  `staff_picture` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_username`, `staff_password`, `staff_name`, `staff_phone`, `staff_email`, `staff_area`, `staff_picture`, `reset_token`) VALUES
('adam123', '123', 'adam', '0119929386', 'adam@gmail.com', 'Kajang', 'images/uploads/adam123_1744164338.jpg', NULL),
('eireen04', 'eireen123', 'Eireen', '0166738293', 'eireen@gmail.com', 'Kajang', '', NULL),
('el02', 'el', 'Elisya', '0115505294', 'elisya@gmail.com', 'Kajang', '', NULL),
('elena11', 'qwe', 'Elena Sofea ', '0166908456', 'elena@gmail.com', '', '', NULL),
('ezera', 'qwe', 'Ezera Nur Edayu', '01122392034', 'ezenredy@gmail.com', 'Cheras', 'images/uploads/ezera_1744049943.jpg', 'b73f287db2ca8c6819c8a9200d10690ccf26930be576e65a2c31d4ee997aadff6172b48d59a3b46a74d14f12fa1bbb67f3db'),
('Hanifah11', '', 'Nur Hanifah', '01166945934', 'hanifah@gmail.com', 'Bangi', '', NULL),
('sakinah02', 'sakinah', 'Sakinah', '01166949343', 'sakinah@gmail.com', 'Wangsa Maju', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_visit`
--

CREATE TABLE `store_visit` (
  `store_no` int(11) NOT NULL,
  `store_trainee` varchar(50) NOT NULL,
  `store_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `store_date` date NOT NULL,
  `store_outlet` varchar(100) NOT NULL,
  `store_category` varchar(100) NOT NULL,
  `store_topic` varchar(255) NOT NULL,
  `store_pic` varchar(100) NOT NULL,
  `store_chop` varchar(255) NOT NULL,
  `store_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store_visit`
--

INSERT INTO `store_visit` (`store_no`, `store_trainee`, `store_time`, `store_date`, `store_outlet`, `store_category`, `store_topic`, `store_pic`, `store_chop`, `store_picture`) VALUES
(6, 'Muhammad Irfan Bin Azhar', '2025-03-19 15:12:54', '2025-03-28', 'aas', 'as', 'as', 'as', 'uploads/Samsung.jpg', 'uploads/Samsung Store.png'),
(7, 'Muhammad Irfan Bin Azhar', '2025-04-09 01:40:55', '2025-04-10', 'Ampang', 'SES', 'Training', 'Mr.Afiq', 'uploads/Samsung.jpg', 'uploads/Samsung Store.png'),
(8, 'Aida Athirah Binti Haikal', '2025-04-15 03:42:13', '2025-04-15', 'Lotus Digi', 'SES', 'Intro new products', 'Mr.Ryan', 'uploads/pic.png', 'uploads/Samsung Store.png'),
(9, 'Izzul Fikri', '2025-04-15 14:01:55', '2025-04-15', 'Pavillion Bukit Jalil', 'SES', 'Introduce New Table Product', 'Mr. Tan', 'uploads/Samsung.jpg', 'uploads/Samsung Store.png');

-- --------------------------------------------------------

--
-- Table structure for table `trainee`
--

CREATE TABLE `trainee` (
  `trainee_username` varchar(50) NOT NULL,
  `trainee_password` varchar(255) NOT NULL,
  `trainee_name` varchar(100) NOT NULL,
  `trainee_phone` varchar(12) NOT NULL,
  `trainee_email` varchar(100) NOT NULL,
  `trainee_area` varchar(100) NOT NULL,
  `trainee_picture` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainee`
--

INSERT INTO `trainee` (`trainee_username`, `trainee_password`, `trainee_name`, `trainee_phone`, `trainee_email`, `trainee_area`, `trainee_picture`, `reset_token`) VALUES
('aina', '123', 'Aina Abdul', '01199384934', 'ainaabdul@gmail.com', 'Bangi', 'images/uploads/aina_1743958501.jpg', NULL),
('biha12', '1234', 'Nabihah Binti Aiman', '0166906948', 'nurnabihaas@gmail.com', 'Cheras', '', NULL),
('Chai02', '', 'Chairyl Adam', '01144953856', 'chai@gmail.com', 'Bangi', '', NULL),
('irfan0303', 'irfan123', 'Muhammad Irfan Bin Azhar', '01155958394', 'irfanazhar030398@gmail.com', 'Bukit Jalil', 'images/uploads/irfan0303_1742018103.jpeg', NULL),
('izzul00', 'izzul', 'Izzul Fikri', '01122834758', 'izzul@gmail.com', 'Bukit Jalil', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kpi`
--
ALTER TABLE `kpi`
  ADD PRIMARY KEY (`kpi_no`);

--
-- Indexes for table `leave`
--
ALTER TABLE `leave`
  ADD PRIMARY KEY (`leave_no`);

--
-- Indexes for table `medical`
--
ALTER TABLE `medical`
  ADD PRIMARY KEY (`mc_no`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_username`);

--
-- Indexes for table `store_visit`
--
ALTER TABLE `store_visit`
  ADD PRIMARY KEY (`store_no`);

--
-- Indexes for table `trainee`
--
ALTER TABLE `trainee`
  ADD PRIMARY KEY (`trainee_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kpi`
--
ALTER TABLE `kpi`
  MODIFY `kpi_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `leave`
--
ALTER TABLE `leave`
  MODIFY `leave_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `medical`
--
ALTER TABLE `medical`
  MODIFY `mc_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `store_visit`
--
ALTER TABLE `store_visit`
  MODIFY `store_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
