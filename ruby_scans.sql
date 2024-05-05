-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2023 at 07:20 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_code`
--

CREATE TABLE `coupon_code` (
  `coupon_id` int(10) NOT NULL,
  `coupon_code` varchar(100) NOT NULL,
  `coupon_value` int(10) NOT NULL,
  `coupon_validity` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `magazine-chapters`
--

CREATE TABLE `magazine-chapters` (
  `chapter_number` int(10) NOT NULL,
  `magazine_id` varchar(6) NOT NULL,
  `img_links_1` varchar(500) NOT NULL,
  `img_links_2` varchar(500) NOT NULL,
  `upload_date` date NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `magazine-details`
--

CREATE TABLE `magazine-details` (
  `mag_id` varchar(6) NOT NULL,
  `mag_title` varchar(150) NOT NULL,
  `mag_alt_title` varchar(150) NOT NULL,
  `mag_author` varchar(100) NOT NULL,
  `mag_genre` varchar(200) NOT NULL,
  `mag_type` varchar(10) NOT NULL,
  `mag_release` year(4) NOT NULL,
  `mag_status` varchar(15) NOT NULL,
  `mag_desc` varchar(500) NOT NULL,
  `mag_cover` varchar(50) NOT NULL,
  `mag_views` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_mail` varchar(200) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_pswd` varchar(255) NOT NULL,
  `signed_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `access_token` varchar(255) DEFAULT NULL,
  `user_list` varchar(1000) DEFAULT NULL,
  `user_bought` varchar(1000) DEFAULT NULL,
  `ruby_count` int(10) NOT NULL DEFAULT 0,
  `coupon_code` varchar(500) DEFAULT NULL,
  `toss_time` timestamp NULL DEFAULT NULL,
  `blackjack_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_msgs`
--

CREATE TABLE `user_msgs` (
  `msg_id` int(5) NOT NULL,
  `msg_by` varchar(200) NOT NULL,
  `msg_heading` varchar(200) NOT NULL,
  `msg_body` varchar(500) DEFAULT NULL,
  `msg_type` int(2) NOT NULL,
  `seen_status` tinyint(1) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coupon_code`
--
ALTER TABLE `coupon_code`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`);

--
-- Indexes for table `magazine-chapters`
--
ALTER TABLE `magazine-chapters`
  ADD PRIMARY KEY (`chapter_number`,`magazine_id`) USING BTREE;

--
-- Indexes for table `magazine-details`
--
ALTER TABLE `magazine-details`
  ADD PRIMARY KEY (`mag_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_mail`);

--
-- Indexes for table `user_msgs`
--
ALTER TABLE `user_msgs`
  ADD PRIMARY KEY (`msg_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coupon_code`
--
ALTER TABLE `coupon_code`
  MODIFY `coupon_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_msgs`
--
ALTER TABLE `user_msgs`
  MODIFY `msg_id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
