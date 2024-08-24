-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2024 at 04:00 PM
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
-- Database: `souza`
--

-- --------------------------------------------------------

--
-- Table structure for table `ims_itemcodes`
--

CREATE TABLE `ims_itemcodes` (
  `id` int(11) NOT NULL,
  `cat` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `sunits` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ims_itemcodes`
--

INSERT INTO `ims_itemcodes` (`id`, `cat`, `code`, `description`, `sunits`) VALUES
(9, 'Electronics', 'ELEC001', 'Smartphone - 64GB', 'kg'),
(10, 'Electronics', 'ELEC002', 'Laptop - 15.6 inch', 'kg'),
(11, 'Furniture', 'FURN001', 'Office Chair', 'kg'),
(12, 'Furniture', 'FURN002', 'Desk - Adjustable', 'kg'),
(13, 'Clothing', 'CLOTH001', 'T-Shirt - Cotton', 'kg'),
(14, 'Clothing', 'CLOTH002', 'Jeans - Denim', 'N/A'),
(15, 'Stationery', 'STAT001', 'Notebook - 100 Pages', 'N/A'),
(16, 'Stationery', 'STAT002', 'Pen - Ballpoint', 'N/A'),
(17, 'Groceries', 'GROC001', 'Milk', 'ltr'),
(18, 'Groceries', 'GROC002', 'Sugar', 'kg'),
(19, 'Bakery', 'BAKE001', 'Bread', 'loaf'),
(20, 'Bakery', 'BAKE002', 'Butter', 'kg'),
(21, 'Pharmacy', 'PHAR001', 'Aspirin', 'box'),
(22, 'Pharmacy', 'PHAR002', 'Vitamins', 'bottle');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `inv_no` int(50) NOT NULL,
  `date` date NOT NULL,
  `category` varchar(200) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `unit` varchar(50) NOT NULL,
  `qty` int(100) NOT NULL,
  `price` varchar(200) NOT NULL,
  `vat` decimal(10,0) NOT NULL,
  `basic_Amount` varchar(100) NOT NULL,
  `discount_type` varchar(50) NOT NULL,
  `discount_val` varchar(50) NOT NULL,
  `total_price` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vat`
--

CREATE TABLE `vat` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `vatper` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vat`
--

INSERT INTO `vat` (`id`, `code`, `vatper`) VALUES
(1, 'vat1', 2),
(2, 'vat2', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ims_itemcodes`
--
ALTER TABLE `ims_itemcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vat`
--
ALTER TABLE `vat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ims_itemcodes`
--
ALTER TABLE `ims_itemcodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vat`
--
ALTER TABLE `vat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
