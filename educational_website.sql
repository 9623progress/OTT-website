-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2024 at 12:13 PM
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
-- Database: `educational_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `subject_description` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `subject`, `thumbnail`, `topic`, `unit`, `content`, `subject_description`, `date`) VALUES
(26, 'Basic Civil Engineering', 'Basic Civil Engineering.png', 'Construction', 'unit-1', 'Basic Civil Engineering.png', 'Basic Civil Engineering', '2024-01-12 16:01:28'),
(27, 'Basic Electrical Engineering', 'Basic Electrical Engineering.png', 'Construction', 'unit-1', 'Basic Electrical Engineering.png', 'Basic Electrical Engineering', '2024-01-12 16:02:14'),
(28, 'Basic Electronic Engineering', 'Basic Electronic Engineering.png', 'Construction', 'unit-1', 'Basic Electronic Engineering.png', 'Basic Electrical Engineering', '2024-01-12 16:02:38'),
(29, 'Basic Mechanical Engineering', 'Basic Mechanical Engineering.png', 'Construction', 'unit-1', 'Basic Mechanical Engineering.png', 'Basic Mechanical Engineering', '2024-01-12 16:03:15'),
(30, 'Data Structures and Algorithm', 'Data Structures and Algorithm.png', 'DSA', 'unit-1', 'Coglogo.jpeg', 'content', '2024-01-12 16:04:29'),
(36, 'Basic Civil Engineering', 'Basic Civil Engineering.png', 'video 1', 'unit-2', '20240105_085047.mp4', 'Basic Civil Engineering', '2024-01-14 23:43:32'),
(37, 'Basic Civil Engineering', 'Basic Civil Engineering.png', 'video 2', 'unit-2', '20231009_001544.mp4', 'Basic Civil Engineering', '2024-01-14 23:43:45'),
(38, 'Basic Civil Engineering', 'Basic Civil Engineering.png', 'video 1', 'unit-1', '20230106_171401.mp4', 'Basic Civil Engineering', '2024-01-14 23:44:05'),
(39, 'Basic Civil Engineering', 'Basic Civil Engineering.png', 'video 2', 'unit-1', '20230525_024047.mp4', 'Basic Civil Engineering', '2024-01-14 23:44:17'),
(44, 'Basic Electronic Engineering', 'Basic Electronic Engineering.png', 'pdf', 'unit-2', 'project-report-template-cognifront (Repaired) (4).pdf', 'Basic Electrical Engineering', '2024-01-21 00:00:06'),
(45, 'Basic Electronic Engineering', 'Basic Electronic Engineering.png', 'video', 'unit-2', '20230106_183106.mp4', 'Basic Electrical Engineering', '2024-01-21 00:25:25');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Date` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `subject`, `email`, `Date`) VALUES
(7, 'Basic Electrical Engineering', 'pragatijadhav862@gmail.com', '2024-01-16 18:46:55.285358'),
(10, 'Basic Mechanical Engineering', 'jpragati760@gmail.com', '2024-01-20 23:54:08.899238'),
(11, 'Basic Mechanical Engineering', 'pragatijadhav862@gmail.com', '2024-01-20 23:56:41.607732');

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `id` int(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`id`, `subject`, `price`, `Date`) VALUES
(1, 'Basic Civil Engineering', 1000, '2024-01-14 09:17:14'),
(2, 'Basic Electrical Engineering', 1000, '2024-01-14 09:17:32'),
(5, 'Basic Mechanical Engineering', 2000, '2024-01-14 09:44:11'),
(7, 'Data Structures and Algorithm', 3000, '2024-01-15 05:46:39'),
(8, 'Basic Electronic Engineering', 100, '2024-01-18 06:37:36');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(255) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(255) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `subject_id`, `email`, `rating`, `date`) VALUES
(4, 'Basic Civil Engineering', 'jpragati760@gmail.com', 3, '2024-01-18 11:25:02'),
(5, 'Basic Civil Engineering', 'pragatijadhav862@gmail.com', 5, '2024-01-18 11:25:53'),
(6, 'Basic Electrical Engineering', 'jpragati760@gmail.com', 3, '2024-01-18 11:50:08'),
(7, 'Basic Electronic Engineering', 'jpragati760@gmail.com', 5, '2024-01-18 23:54:47'),
(8, 'Basic Mechanical Engineering', 'jpragati760@gmail.com', 3, '2024-01-20 23:55:09'),
(9, 'Basic Mechanical Engineering', 'pragatijadhav862@gmail.com', 5, '2024-01-20 23:57:44'),
(10, 'Data Structures and Algorithm', 'jpragati760@gmail.com', 2, '2024-01-21 16:21:48');

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `date` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`id`, `email`, `subject`, `amount`, `date`) VALUES
(2, 'jpragati760@gmail.com', 'Basic Electronic Engineering', 100, '2024-01-20 08:36:11'),
(3, 'jpragati760@gmail.com', 'Basic Electronic Engineering', 100, '2024-01-20 08:50:08'),
(4, 'jpragati760@gmail.com', 'Basic Electrical Engineering', 1000, '2024-01-20 23:46:44'),
(5, 'jpragati760@gmail.com', 'Basic Mechanical Engineering', 2000, '2024-01-20 23:54:25'),
(6, 'pragatijadhav862@gmail.com', 'Basic Mechanical Engineering', 2000, '2024-01-20 23:56:51'),
(7, 'jpragati760@gmail.com', 'Basic Mechanical Engineering', 2000, '2024-01-21 16:10:04');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `mobile_no`, `password`, `date`) VALUES
(1, 'Pragati Jadhav', 'jpragati760@gmail.com', '9623436226', '$2y$10$IquVmgmFvixX5nlHTld3j.l29.0q64RrgoWSEdiKPoVLhqlIZWCaC', '2024-01-13 21:55:44'),
(2, 'Pragati Jadhav', 'jpragati@gmail.com', '9623436226', '$2y$10$CRGN8j7.CWAg8/.3uRYMfegVKmyk4gfaZdyiLvQeNoo1Ps4Wo6tMu', '2024-01-13 21:59:27'),
(3, 'Pragati Jadhav', 'pragati@gmail.com', '9623436226', '$2y$10$rSuVmaq8AOCR6wqvgko0ne6CbdSyETnt6dCNGab8mBV0wqD8/gSse', '2024-01-13 22:00:53'),
(4, 'Pragati Jadhav', 'progress@gmail.com', '9623436226', '$2y$10$HTLq5XRJKe4j1RhqUsIEj./AL.21wzyH2Iv61z1epVWJ/FPYmCSru', '2024-01-13 22:02:25'),
(5, 'Pragati Jadhav', 'pro1gress@gmail.com', '9623436226', '$2y$10$BpxHGxHgzrWAq7vPutKxAObfIn1R.WUVSebgO.PLFkOOe321C/cVe', '2024-01-13 22:04:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
