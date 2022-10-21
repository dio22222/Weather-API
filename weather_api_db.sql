-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2022 at 12:10 AM
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
(106, 'athens', 'Athens', '2022-10-21', 289.34, 16.18, 61.14, 288.58, 15.43, 59.77, 286.9, 13.75, 56.75, 290.46, 17.31, 63.15, 1022, 60, 10000, 3.09, 320, 0),
(107, 'thessaloniki', 'Thessaloniki', '2022-10-21', 288.49, 15.34, 59.61, 287.96, 14.81, 58.65, 285.26, 12.11, 53.79, 289.75, 16.6, 61.88, 1026, 72, 10000, 1.54, 110, 20),
(108, 'patras', 'Pátrai', '2022-10-21', 289.7, 16.55, 61.79, 289.06, 15.91, 60.63, 288.52, 15.37, 59.66, 289.74, 16.59, 61.86, 1023, 63, 10000, 5.53, 71, 0),
(109, 'heraklion', 'Heraklion', '2022-10-21', 289, 15.85, 60.53, 288.26, 15.11, 59.19, 288.64, 15.49, 59.88, 290.25, 17.1, 62.78, 1021, 62, 10000, 7.72, 320, 20),
(110, 'ioannina', 'Ioannina', '2022-10-21', 288.66, 15.51, 59.91, 287.99, 14.84, 58.71, 287.01, 13.86, 56.94, 288.66, 15.51, 59.91, 1025, 66, 10000, 0.51, 340, 0),
(111, 'larisa', 'Larissa', '2022-10-21', 286.09, 12.93, 55.29, 285.58, 12.43, 54.37, 285.47, 12.32, 54.17, 286.09, 12.93, 55.29, 1025, 82, 10000, 2.57, 90, 20),
(112, 'volos', 'Volos', '2022-10-21', 285.95, 12.8, 55.04, 285.4, 12.25, 54.05, 285.14, 11.99, 53.58, 285.95, 12.8, 55.04, 1026, 81, 10000, 2.13, 117, 30),
(113, 'athens', 'Athens', '2022-10-20', 289.34, 16.18, 61.14, 288.58, 15.43, 59.77, 286.9, 13.75, 56.75, 290.46, 17.31, 63.15, 1022, 60, 10000, 3.09, 320, 0),
(114, 'thessaloniki', 'Thessaloniki', '2022-10-20', 288.49, 15.34, 59.61, 287.96, 14.81, 58.65, 285.26, 12.11, 53.79, 289.75, 16.6, 61.88, 1026, 72, 10000, 1.54, 110, 20),
(115, 'patras', 'Pátrai', '2022-10-20', 289.7, 16.55, 61.79, 289.06, 15.91, 60.63, 288.52, 15.37, 59.66, 289.74, 16.59, 61.86, 1023, 63, 10000, 5.53, 71, 0),
(116, 'heraklion', 'Heraklion', '2022-10-20', 289, 15.85, 60.53, 288.26, 15.11, 59.19, 288.64, 15.49, 59.88, 290.25, 17.1, 62.78, 1021, 62, 10000, 7.72, 320, 20),
(117, 'ioannina', 'Ioannina', '2022-10-20', 288.66, 15.51, 59.91, 287.99, 14.84, 58.71, 287.01, 13.86, 56.94, 288.66, 15.51, 59.91, 1025, 66, 10000, 0.51, 340, 0),
(118, 'larisa', 'Larissa', '2022-10-20', 286.09, 12.93, 55.29, 285.58, 12.43, 54.37, 285.47, 12.32, 54.17, 286.09, 12.93, 55.29, 1025, 82, 10000, 2.57, 90, 20),
(119, 'volos', 'Volos', '2022-10-20', 285.95, 12.8, 55.04, 285.4, 12.25, 54.05, 285.14, 11.99, 53.58, 285.95, 12.8, 55.04, 1026, 81, 10000, 2.13, 117, 30),
(120, 'athens', 'Athens', '2022-10-19', 289.34, 16.18, 61.14, 288.58, 15.43, 59.77, 286.9, 13.75, 56.75, 290.46, 17.31, 63.15, 1022, 60, 10000, 3.09, 320, 0),
(121, 'thessaloniki', 'Thessaloniki', '2022-10-19', 288.49, 15.34, 59.61, 287.96, 14.81, 58.65, 285.26, 12.11, 53.79, 289.75, 16.6, 61.88, 1026, 72, 10000, 1.54, 110, 20),
(122, 'patras', 'Pátrai', '2022-10-19', 289.7, 16.55, 61.79, 289.06, 15.91, 60.63, 288.52, 15.37, 59.66, 289.74, 16.59, 61.86, 1023, 63, 10000, 5.53, 71, 0),
(123, 'heraklion', 'Heraklion', '2022-10-19', 289, 15.85, 60.53, 288.26, 15.11, 59.19, 288.64, 15.49, 59.88, 290.25, 17.1, 62.78, 1021, 62, 10000, 7.72, 320, 20),
(124, 'ioannina', 'Ioannina', '2022-10-19', 288.66, 15.51, 59.91, 287.99, 14.84, 58.71, 287.01, 13.86, 56.94, 288.66, 15.51, 59.91, 1025, 66, 10000, 0.51, 340, 0),
(125, 'larisa', 'Larissa', '2022-10-19', 286.09, 12.93, 55.29, 285.58, 12.43, 54.37, 285.47, 12.32, 54.17, 286.09, 12.93, 55.29, 1025, 82, 10000, 2.57, 90, 20),
(126, 'volos', 'Volos', '2022-10-19', 285.95, 12.8, 55.04, 285.4, 12.25, 54.05, 285.14, 11.99, 53.58, 285.95, 12.8, 55.04, 1026, 81, 10000, 2.13, 117, 30);

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
  ADD UNIQUE KEY `username_2` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forecast`
--
ALTER TABLE `forecast`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
