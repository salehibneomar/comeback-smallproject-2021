-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2021 at 04:13 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comeback_todo_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `id` int(6) NOT NULL,
  `title` varchar(250) NOT NULL,
  `details` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Not Done, 1 = Done',
  `user_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`id`, `title`, `details`, `start_date`, `end_date`, `status`, `user_id`) VALUES
(13, 'Hello 111', '', '2021-05-25', '2021-05-27', 0, 2),
(16, 'ডাক্তার দেখানোর সিরিয়াল দিতে হবে', '', '2021-05-29', '2021-05-30', 1, 1),
(17, 'ডাক্তার দেখাবো', '', '2021-05-31', '2021-05-31', 1, 1),
(21, 'Watch Tutorials of some basic Digital Device and how they works', '', '2021-05-30', '2021-06-02', 0, 1),
(22, 'MySQL couse from SQLtuts', '', '2021-06-03', '2021-06-10', 0, 1),
(23, 'PHP OOP course from Udemy', '', '2021-06-12', '2021-06-20', 0, 1),
(24, 'OOP basic flash course downloaded from random site', '', '2021-06-22', '2021-06-26', 0, 1),
(25, 'Laravel 5.8 todo from UDEMY', '', '2021-06-28', '2021-07-03', 0, 1),
(26, 'Laravel from Laracast Basic', '', '2021-07-05', '2021-07-15', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(6) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `pin` varchar(250) NOT NULL,
  `joined_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `phone_number`, `pin`, `joined_date`) VALUES
(1, 'Saleh', '01704915210', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2021-05-18'),
(2, 'Sakib', '01611332774', '3acd0be86de7dcccdbf91b20f94a68cea535922d', '2021-05-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `todo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
