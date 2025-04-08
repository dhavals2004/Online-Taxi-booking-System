-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 05:55 PM
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
-- Database: `taxibooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_regis`
--

CREATE TABLE `admin_regis` (
  `admin_id` int(10) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobileno` bigint(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_regis`
--

INSERT INTO `admin_regis` (`admin_id`, `fname`, `email`, `mobileno`, `username`, `password`, `address`) VALUES
(6, 'admin', 'admin123@gmail.com', 1234567890, 'admin', 'admin', 'Gandhinagar');

-- --------------------------------------------------------

--
-- Table structure for table `bankingss`
--

CREATE TABLE `bankingss` (
  `bank_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `ifsc_code` varchar(20) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `passbook_photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookrecord`
--

CREATE TABLE `bookrecord` (
  `booking_id` int(11) NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `drop_location` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('Pending','Confirmed','Completed','Cancelled','Pickup','Drop') DEFAULT 'Pending',
  `vehicle_id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `customer_id` int(10) NOT NULL,
  `pickup_time` datetime NOT NULL,
  `drop_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookrecord`
--

INSERT INTO `bookrecord` (`booking_id`, `pickup_location`, `drop_location`, `price`, `status`, `vehicle_id`, `driver_id`, `customer_id`, `pickup_time`, `drop_time`) VALUES
(2, 'Sector-3', 'Sector-9', 181.00, 'Cancelled', 4, 1, 1, '2025-04-04 18:31:45', '2025-04-04 19:31:45'),
(3, 'Sector-4', 'Gujarat Police Bhavan', 177.00, 'Cancelled', 4, 1, 1, '2025-04-04 18:32:07', '2025-04-04 19:32:07'),
(4, 'Infocity', 'Gujarat High Court', 155.00, 'Completed', 4, 2, 3, '2025-04-05 08:44:15', '2025-04-05 08:45:08');

-- --------------------------------------------------------

--
-- Table structure for table `cancellation`
--

CREATE TABLE `cancellation` (
  `cancellation_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `cancellation_time` datetime DEFAULT current_timestamp(),
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cancellation`
--

INSERT INTO `cancellation` (`cancellation_id`, `booking_id`, `customer_id`, `driver_id`, `cancellation_time`, `reason`) VALUES
(1, 2, 1, 1, '2025-04-04 22:01:55', 'not like\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `customer_regist`
--

CREATE TABLE `customer_regist` (
  `Customer_id` int(10) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobileno` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `approval_status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_regist`
--

INSERT INTO `customer_regist` (`Customer_id`, `fname`, `email`, `mobileno`, `username`, `password`, `approval_status`) VALUES
(1, 'Dhaval', 'dhaval01@mail.com', '9837845263', 'dhaval', 'dhaval', 'Approved'),
(2, 'Ayush', 'ayus01@gmail.com', '9907625432', 'ayush', 'ayush', 'Approved'),
(3, 'Kartik', 'kartik01@gmail.com', '9872338560', 'kartik', 'kartik', 'Approved'),
(4, 'Mohit', 'mohit7@gmail.com', '9968645873', 'mohit', 'mohit', 'Approved'),
(5, 'Jay Patel', 'jay67@gmail.com', '8964987432', 'jay', 'jay', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `driverre`
--

CREATE TABLE `driverre` (
  `Driver_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `licence_no` varchar(255) NOT NULL,
  `licence_photo` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `approval_status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driverre`
--

INSERT INTO `driverre` (`Driver_id`, `fname`, `email`, `phone`, `username`, `password`, `licence_no`, `licence_photo`, `address`, `photo`, `approval_status`) VALUES
(1, 'Ayush', 'Ayush12@gmail.com', '9986712456', 'ayush', 'ayush', 'GJ1120334245', 'uploads/1741541189_1.jpg', 'Gandhinagar', 'uploads/1741541189_3.png', 'Approved'),
(2, 'Mohit', 'mohit6@gmail.com', '9964587624', 'mohit', 'mohit', 'GJ18374536', 'uploads/1741541713_3.jpeg', 'Gandhinagar', 'uploads/1741541713_1.JPG', 'Approved'),
(3, 'Dhaval', 'dhaval4@gmail.com', '8643856342', 'dhaval', 'dhaval', 'GJ112036485', 'uploads/1741541897_2.jpeg', 'Junagadh', 'uploads/1741541897_5.jpg', 'Approved'),
(4, 'Kartik', 'Kartik45@gmail.com', '9986653214', 'kartik', 'kartik', 'GJ189356676', 'uploads/1741541958_1.JPG', 'Gandhinagar', 'uploads/1741541958_2.jpeg', 'Approved'),
(5, 'bhumit', 'bhumit1@gmail.com', '9987725985', 'bhumit', 'bhumit', 'Gj 12 7964443', 'uploads/1742401313_4.jpeg', 'Surat', 'uploads/1742401313_3.png', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Paid','Unpaid') DEFAULT 'Pending',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `customer_id`, `booking_id`, `payment_id`, `amount`, `status`, `payment_date`) VALUES
(2, 3, 4, 'pay_QFDwpYwYuzBrLD', 155.00, 'Paid', '2025-04-05 03:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles_infom`
--

CREATE TABLE `vehicles_infom` (
  `vehicle_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `number` varchar(50) NOT NULL,
  `insurance` varchar(50) NOT NULL,
  `puc` varchar(50) NOT NULL,
  `puc_cert` varchar(255) NOT NULL,
  `rc_book` varchar(255) NOT NULL,
  `prize_perkm` decimal(10,2) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles_infom`
--

INSERT INTO `vehicles_infom` (`vehicle_id`, `driver_id`, `model`, `number`, `insurance`, `puc`, `puc_cert`, `rc_book`, `prize_perkm`, `status`) VALUES
(2, 2, 'swift', 'GJ 18 YY 8753', '112-44-44', 'GJ12754433', 'uploads/1741541777_PUC_3.jpeg', 'uploads/1741541777_RC_1.JPG', 100.00, 'active'),
(3, 1, 'Alto S1', 'Gj 15 HH 5362', '9866-532-123', 'GJ98977', '', '', 70.00, 'active'),
(4, 5, 'ALTO', 'Gj 18  Hj 8698', '112-44-44', 'GJ1275443977', 'uploads/1742401375_PUC_5.jpg', 'uploads/1741541777_RC_1.JPG', 50.00, 'inactive'),
(5, 4, 'Ertiga', 'GJ 02 JH 2590', '987-465-234', 'GJ024735', 'uploads/1743607910_PUC_2.jpeg', 'uploads/1743607910_RC_4.jpeg', 140.00, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_regis`
--
ALTER TABLE `admin_regis`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bankingss`
--
ALTER TABLE `bankingss`
  ADD PRIMARY KEY (`bank_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `bookrecord`
--
ALTER TABLE `bookrecord`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `bookrecord_fk_vehicle` (`vehicle_id`),
  ADD KEY `bookrecord_fk_customer` (`customer_id`);

--
-- Indexes for table `cancellation`
--
ALTER TABLE `cancellation`
  ADD PRIMARY KEY (`cancellation_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `customer_regist`
--
ALTER TABLE `customer_regist`
  ADD PRIMARY KEY (`Customer_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `driverre`
--
ALTER TABLE `driverre`
  ADD PRIMARY KEY (`Driver_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `licence_no` (`licence_no`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_id` (`payment_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `vehicles_infom`
--
ALTER TABLE `vehicles_infom`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD UNIQUE KEY `number` (`number`),
  ADD KEY `vehicles_infom_ibfk_1` (`driver_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_regis`
--
ALTER TABLE `admin_regis`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bankingss`
--
ALTER TABLE `bankingss`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookrecord`
--
ALTER TABLE `bookrecord`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cancellation`
--
ALTER TABLE `cancellation`
  MODIFY `cancellation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_regist`
--
ALTER TABLE `customer_regist`
  MODIFY `Customer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `driverre`
--
ALTER TABLE `driverre`
  MODIFY `Driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehicles_infom`
--
ALTER TABLE `vehicles_infom`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bankingss`
--
ALTER TABLE `bankingss`
  ADD CONSTRAINT `bankingss_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driverre` (`Driver_id`) ON DELETE CASCADE;

--
-- Constraints for table `bookrecord`
--
ALTER TABLE `bookrecord`
  ADD CONSTRAINT `bookrecord_fk_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer_regist` (`Customer_id`),
  ADD CONSTRAINT `bookrecord_fk_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles_infom` (`vehicle_id`);

--
-- Constraints for table `cancellation`
--
ALTER TABLE `cancellation`
  ADD CONSTRAINT `cancellation_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookrecord` (`booking_id`),
  ADD CONSTRAINT `cancellation_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer_regist` (`Customer_id`),
  ADD CONSTRAINT `cancellation_ibfk_3` FOREIGN KEY (`driver_id`) REFERENCES `driverre` (`Driver_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_regist` (`Customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookrecord` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles_infom`
--
ALTER TABLE `vehicles_infom`
  ADD CONSTRAINT `vehicles_infom_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driverre` (`Driver_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
