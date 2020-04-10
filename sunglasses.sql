-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2020 at 01:50 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sunglasses`
--

-- --------------------------------------------------------

--
-- Table structure for table `cartdetails`
--

CREATE TABLE `cartdetails` (
  `productid` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(50) NOT NULL,
  `cartid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cartdetails`
--

INSERT INTO `cartdetails` (`productid`, `quantity`, `image`, `cartid`) VALUES
(1, 1, '', 38),
(5, 1, '', 38),
(5, 2, '', 42),
(5, 1, '', 62),
(6, 1, '', 62),
(7, 1, '', 63),
(8, 1, '', 62);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(20) NOT NULL,
  `userid` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total` double NOT NULL,
  `checkout` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `userid`, `created_date`, `total`, `checkout`) VALUES
(38, 1, '2020-04-02 16:17:59', 3111, 1),
(42, 2, '2020-04-03 15:25:09', 2222, 1),
(62, 1, '2020-04-09 18:50:44', 3956, 1),
(63, 1, '2020-04-09 20:21:26', 300, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(1, 'sunglasses', 2000, '84f5335489a03df5088c5b3085ae4e68.jpg'),
(5, 'Gradient sunglasses', 1111, '57cb8a1baac73528767d0b9a266e1345.jpg'),
(6, 'Cat Eye Sunglasses', 2345, '3a295814055b3cd26c191e9107be5e52.jpg'),
(7, 'Sun Kids', 300, '682b88e33633ee570784cf8f17324122.jpg'),
(8, 'square sunglasses', 500, '70df455c114e4ea71502b7c7907cab88.jpg'),
(9, 'round kids', 500, 'eacbecb049e6ce288f0041b77a31ffc7.jpg'),
(16, 'Classic metal frame', 600, '9f55c72091a72ddd988c9790215fe17c.jpg'),
(19, 'wood frame sunglasses', 600, '0d345311c619c87ba7dfc4be9f42d578.jpg'),
(20, 'black Ray-Ban', 1200, '5d652e1593e8d66de74c7c9887e86b8d.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(50) NOT NULL,
  `userid` int(11) NOT NULL,
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `token`, `userid`, `updated_date`) VALUES
(20, 'c5f5aea2458ce61d95a1c6f542325c26', 3, '2020-04-02 16:55:13'),
(27, '3938b3c0384313973e77121013d4aa53', 2, '2020-04-03 17:01:16'),
(51, 'a365336ea604b0d20d905c76da80383f', 1, '2020-04-10 13:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `admin`) VALUES
(1, 'Fengcai', '202cb962ac59075b964b07152d234b70', 'caifeng619@gmail.com', 1),
(2, 'cai', '81dc9bdb52d04dc20036dbd8313ed055', 'cai@gmail.com', 0),
(3, 'Tiancai', '81dc9bdb52d04dc20036dbd8313ed055', 'tiancai@gmail.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cartdetails`
--
ALTER TABLE `cartdetails`
  ADD PRIMARY KEY (`productid`,`cartid`),
  ADD KEY `cartid` (`cartid`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cartdetails`
--
ALTER TABLE `cartdetails`
  ADD CONSTRAINT `cartdetails_ibfk_1` FOREIGN KEY (`cartid`) REFERENCES `carts` (`id`),
  ADD CONSTRAINT `cartdetails_ibfk_2` FOREIGN KEY (`productid`) REFERENCES `products` (`id`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
