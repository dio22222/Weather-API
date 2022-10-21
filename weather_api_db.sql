-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2022 at 06:13 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weather_api_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `forecast`
--

CREATE TABLE `forecast` (
  `id` int(11) NOT NULL,
  `city_name_given` varchar(20) NOT NULL,
  `official_city_name` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `temp_kelvin` double NOT NULL,
  `temp_celcius` double NOT NULL,
  `temp_fahrenheit` double NOT NULL,
  `feels_like_kelvin` double NOT NULL,
  `feels_like_celcius` double NOT NULL,
  `feels_like_fahrenheit` double NOT NULL,
  `temp_min_kelvin` double NOT NULL,
  `temp_min_celcius` double NOT NULL,
  `temp_min_fahrenheit` double NOT NULL,
  `temp_max_kelvin` double NOT NULL,
  `temp_max_celcius` double NOT NULL,
  `temp_max_fahrenheit` double NOT NULL,
  `pressure` int(11) NOT NULL,
  `humidity` int(11) NOT NULL,
  `visibility` int(11) NOT NULL,
  `wind_speed` double NOT NULL,
  `wind_deg` int(11) NOT NULL,
  `clouds` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forecast`
--

INSERT INTO `forecast` (`id`, `city_name_given`, `official_city_name`, `date`, `temp_kelvin`, `temp_celcius`, `temp_fahrenheit`, `feels_like_kelvin`, `feels_like_celcius`, `feels_like_fahrenheit`, `temp_min_kelvin`, `temp_min_celcius`, `temp_min_fahrenheit`, `temp_max_kelvin`, `temp_max_celcius`, `temp_max_fahrenheit`, `pressure`, `humidity`, `visibility`, `wind_speed`, `wind_deg`, `clouds`) VALUES
(78, 'athens', 'Athens', '2222-10-21', 291.07, 17.92, 64.25, 290.35, 17.2, 62.96, 288.47, 15.32, 59.57, 292.13, 18.98, 66.16, 1021, 55, 10000, 6.69, 360, 20),
(79, 'thessaloniki', 'Thessaloniki', '2222-10-21', 290.39, 17.24, 63.03, 289.89, 16.74, 62.13, 287.93, 14.78, 58.6, 291.79, 18.64, 65.55, 1025, 66, 10000, 3.6, 190, 20),
(80, 'patras', 'Pátrai', '2222-10-21', 291.53, 18.37, 65.08, 290.99, 17.84, 64.11, 290.74, 17.59, 63.66, 293.14, 19.99, 67.98, 1022, 60, 10000, 5.46, 60, 0),
(81, 'heraklion', 'Heraklion', '2222-10-21', 289.78, 16.62, 61.93, 289.01, 15.86, 60.54, 289.2, 16.05, 60.89, 291.36, 18.21, 64.77, 1020, 58, 10000, 8.75, 310, 20),
(82, 'ioannina', 'Ioannina', '2222-10-21', 291.43, 18.28, 64.9, 290.7, 17.55, 63.59, 290.01, 16.86, 62.34, 291.43, 18.28, 64.9, 1023, 53, 10000, 2.24, 0, 0),
(83, 'larissa', 'Larissa', '2222-10-21', 289.09, 15.93, 60.69, 288.62, 15.47, 59.84, 288.81, 15.66, 60.18, 289.09, 15.93, 60.69, 1024, 72, 10000, 4.63, 90, 20),
(84, 'volos', 'Volos', '2222-10-21', 289.29, 16.14, 61.05, 288.79, 15.64, 60.15, 289.29, 16.14, 61.05, 290.14, 16.99, 62.58, 1025, 70, 10000, 2.53, 111, 68);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'dio', 'dio@gmail.com', 'imtheadmin', '2022-10-18 15:44:55', '2022-10-18 15:44:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forecast`
--
ALTER TABLE `forecast`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `city_name_given` (`city_name_given`),
  ADD KEY `official_city_name` (`official_city_name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forecast`
--
ALTER TABLE `forecast`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
