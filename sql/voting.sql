-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2022 at 01:08 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `candidate_id` int(11) NOT NULL,
  `candidate_name` varchar(30) DEFAULT NULL,
  `candidate_photo` varchar(50) DEFAULT NULL,
  `candidate_party_photo` varchar(50) DEFAULT NULL,
  `candidate_party` varchar(50) DEFAULT NULL,
  `election_name` varchar(30) DEFAULT NULL,
  `vote` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`candidate_id`, `candidate_name`, `candidate_photo`, `candidate_party_photo`, `candidate_party`, `election_name`, `vote`) VALUES
(1, 'Abhilash', 'images/uploads/Abhilash344823.jpeg', 'images/uploads/Cycle617286.jpeg', 'Cycle', 'General Election', 9),
(2, 'Adithya', 'images/uploads/Adithya993108.jpeg', 'images/uploads/Bulb120958.jpeg', 'Bulb', 'General Election', 18);

-- --------------------------------------------------------

--
-- Table structure for table `election`
--

CREATE TABLE `election` (
  `id` int(1) NOT NULL,
  `election_name` varchar(30) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `election`
--

INSERT INTO `election` (`id`, `election_name`, `start_time`, `end_time`) VALUES
(1, 'General Election', '2022-04-07 20:17:03', '2022-04-20 12:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `voter`
--

CREATE TABLE `voter` (
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(8) DEFAULT NULL,
  `district` varchar(25) DEFAULT NULL,
  `taluk` varchar(25) DEFAULT NULL,
  `booth` varchar(25) DEFAULT NULL,
  `number` varchar(12) DEFAULT NULL,
  `aadhaar` varchar(12) NOT NULL,
  `otp` varchar(5) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `login` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `voter`
--

INSERT INTO `voter` (`fname`, `lname`, `dob`, `gender`, `district`, `taluk`, `booth`, `number`, `aadhaar`, `otp`, `email`, `login`) VALUES
('Abhilash', 'M', '1997-01-22', 'male', 'Bangalore', 'Bangalore-North', 'Dasarahalli', '9123456789', '222222222222', '64267', 'sannidhi.kharvi3@gmail.com', 1),
('Priya', 'K', '1999-06-16', 'female', 'Bangalore', 'Bangalore-South', 'Marthahalli', '5713871368', '777777777777', '38910', 'sannidhi0033@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`candidate_id`);

--
-- Indexes for table `election`
--
ALTER TABLE `election`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voter`
--
ALTER TABLE `voter`
  ADD PRIMARY KEY (`aadhaar`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
