-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2025 at 03:21 PM
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
-- Database: `skyboomcrackershop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `product_image_path` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(3, 'FLOWER POTS'),
(4, 'GROUND CHAKKER'),
(5, 'COLOUR CRACKLING FOUNTAIN'),
(7, 'TWINKLING STAR'),
(8, 'BIJILI CRACKERS'),
(9, '1 & 2 SOUND CRACKERS'),
(10, 'PAPER BOMBS'),
(11, 'ROCKETS'),
(12, 'SPARKLERS '),
(13, 'COMBO PACK'),
(16, 'FANCY PENCILS / FANCY CANDLES');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `discount_range` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`discount_range`) VALUES
('80');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`admin_id`, `username`, `password`) VALUES
(1, 'admin', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `orderedpro`
--

CREATE TABLE `orderedpro` (
  `orderedpro_id` int(11) NOT NULL,
  `ordercus_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `product_image_path` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderedpro`
--

INSERT INTO `orderedpro` (`orderedpro_id`, `ordercus_id`, `product_name`, `cost`, `quantity`, `total_cost`, `product_image_path`) VALUES
(21, 35, 'JELLY BEAN CANDLE', 160.00, 1, 160.00, '../uploads/1764479781_JELLY BEAN CANDLE.jpg'),
(25, 37, ' 2¾\" KURUVI', 16.00, 1, 16.00, '../uploads/1764171172_2.75 KURUVI.jpg'),
(26, 37, '3½\"DLX LAKSHMI', 20.00, 2, 40.00, '../uploads/1764171200_3.5DLX LAKSHMI.jpg'),
(27, 37, '4\" DELUXE LAKSHMI', 20.00, 1, 20.00, '../uploads/1764171221_4DELUXE LAKSHMI.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(250) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `address` varchar(250) NOT NULL,
  `mail_id` varchar(250) NOT NULL,
  `state` varchar(250) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `packing_cost` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` date NOT NULL,
  `orderpro_id` text NOT NULL,
  `order_status` varchar(250) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `contact_no`, `address`, `mail_id`, `state`, `total`, `packing_cost`, `total_amount`, `order_date`, `orderpro_id`, `order_status`) VALUES
(35, 'Swetha', '9876543212', 'T.Nagar, Srivilliputtur', 'swetha@gmail.com', 'Tamil Nadu', 160.00, 50.00, 210.00, '2025-11-30', '21', 'Delivered'),
(37, 'SUNDARAMARI S', '9876543211', '33 M.K.Nagar, Madurai', 'sundar@gmail.com', 'Tamil Nadu', 76.00, 50.00, 126.00, '2025-11-30', '25,26,27', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `category` varchar(250) NOT NULL,
  `product_image_path` varchar(250) NOT NULL,
  `cost` varchar(250) NOT NULL,
  `stock_status` varchar(250) NOT NULL,
  `pcs_details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `category`, `product_image_path`, `cost`, `stock_status`, `pcs_details`) VALUES
(1, 'FLOWER POTS ASOKA', 'FLOWER POTS', '../uploads/1764053540_flowerpotsasoka.jpg', '600', 'Available', '1Box/10pcs'),
(2, 'GROUND CHAKKAR BIG', 'GROUND CHAKKER', '../uploads/1764058435_GROUNDCHAKKARBIG.jpg', '750', 'Available', '1Box/10pcs'),
(3, 'GROUND CHAKKAR SPECIAL', 'GROUND CHAKKER', '../uploads/1764060370_groundchakkarspecial.jpg', '300', 'Available', '1Box/10pcs'),
(4, 'GROUND CHAKKAR DELUX', 'GROUND CHAKKER', '../uploads/1764060414_GROUNDCHAKKARdelux.jpg', '720', 'Available', '1Box/10pcs'),
(5, 'SPINNER CHAKKAR', 'GROUND CHAKKER', '../uploads/1764060452_spinnerchakkar.jpg', '600', 'Available', '1Box/10pcs'),
(6, 'DISCO WHEEL', 'GROUND CHAKKER', '../uploads/1764060483_discowheel.jpg', '560', 'Available', '1Box/10pcs'),
(7, 'FLOWER POTS SPECIAL', 'FLOWER POTS', '../uploads/1764060523_flowerpotsspecial.jpg', '450', 'Available', '1Box/10pcs'),
(8, 'GROUND CHAKKAR DELUX', 'FLOWER POTS', '../uploads/1764060556_flowerpotsdelux.jpg', '550', 'Available', '1Box/10pcs'),
(9, 'COLOR KOTTI', 'FLOWER POTS', '../uploads/1764060580_flowerpotsccolorkotti.jpg', '440', 'Available', '1Box/10pcs'),
(10, 'DORA BUJJI CRACKLING To GOLD', 'COLOUR CRACKLING FOUNTAIN', '../uploads/1764170588_DORA BUJJI CRACKLING To GOLD.jpg', '650', 'Available', '1Box/1pcs'),
(12, 'SHIN CHAN CRACKLING To GREEN', 'COLOUR CRACKLING FOUNTAIN', '../uploads/1764170615_SHIN CHAN CRACKLING To GREEN.jpg', '700', 'Available', '1Box/1pcs'),
(14, 'TOM & JERRY CRACKLING To SILVER', 'COLOUR CRACKLING FOUNTAIN', '../uploads/1764170661_TOM & JERRY CRACKLING To SILVER.jpg', '760', 'Available', '1Box/1pcs'),
(15, 'MOTTU PATLU SILVER To RED & GREEN', 'COLOUR CRACKLING FOUNTAIN', '../uploads/1764170686_MOTTU PATLU SILVER To RED & GREEN.jpg', '700', 'Available', '1Box/1pcs'),
(17, '1½\" TWINKLING STAR', 'TWINKLING STAR', '../uploads/1764170773_1.5twinkklingstar.jpg', '300', 'Available', '1Box/10pcs'),
(18, '4\" TWINKLING STAR', 'TWINKLING STAR', '../uploads/1764170800_4twinkingstar.jpg', '350', 'Available', '1Box/10pcs'),
(19, 'RED BIJJILI', 'BIJILI CRACKERS', '../uploads/1764170863_redbijili.jpg', '200', 'Available', '1Box/100pcs'),
(20, 'STRIPPED BIJJILI', 'BIJILI CRACKERS', '../uploads/1764170889_strippedbijili.jpg', '200', 'Available', '1Box/100pcs'),
(21, ' 2¾\" KURUVI', '1 & 2 SOUND CRACKERS', '../uploads/1764171172_2.75 KURUVI.jpg', '80', 'Available', '1Box/5pcs'),
(22, '3½\"DLX LAKSHMI', '1 & 2 SOUND CRACKERS', '../uploads/1764171200_3.5DLX LAKSHMI.jpg', '100', 'Available', '1Box/10pcs'),
(23, '4\" DELUXE LAKSHMI', '1 & 2 SOUND CRACKERS', '../uploads/1764171221_4DELUXE LAKSHMI.jpg', '100', 'Available', '1Box/10pcs'),
(24, '4\" GOLD LAKSHMI', '1 & 2 SOUND CRACKERS', '../uploads/1764171347_4GOLD LAKSHMI.jpg', '100', 'Available', '1Box/10pcs'),
(25, '5\" DLX LAKSHMI / LION', '1 & 2 SOUND CRACKERS', '../uploads/1764171375_5 DLX LAKSHMI  LION.jpg', '100', 'Available', '1Box/10pcs'),
(26, ' 2 SOUND CRACKER', '1 & 2 SOUND CRACKERS', '../uploads/1764171403_2 SOUND CRACKER.jpg', '120', 'Available', '1Box/5pcs'),
(27, '1/4, Kg PAPER BOMB', 'PAPER BOMBS', '../uploads/1764243961_0.25 Kg PAPER BOMB.jpg', '300', 'Available', '1Box/1pcs'),
(28, '1/2, kg PAPER BOMB', 'PAPER BOMBS', '../uploads/1764243984_0.5 kg PAPER BOMB.jpg', '600', 'Available', '1Box/1pcs'),
(29, 'ROCKET BOMB', 'ROCKETS', '../uploads/1764244061_ROCKET BOMB.jpg', '450', 'Available', '1Box/10pcs'),
(30, 'ROCKET BOMB', 'ROCKETS', '../uploads/1764244061_ROCKET BOMB.jpg', '450', 'Available', '1Box/10pcs'),
(31, 'LUNIK ROCKET', 'ROCKETS', '../uploads/1764244085_LUNIK ROCKET.jpg', '600', 'Available', '1Box/10pcs'),
(32, '2 SOUND ROCKET', 'ROCKETS', '../uploads/1764244116_2 SOUND ROCKET.jpg', '650', 'Available', '1Box/10pcs'),
(33, 'WHISTLING ROCKET', 'ROCKETS', '../uploads/1764244151_WHISTLING ROCKET.jpg', '650', 'Available', '1Box/5pcs'),
(34, '10 CM ELECTRIC SPARKLERS', 'SPARKLERS ', '../uploads/1764244473_10 CM ELECTRIC SPARKLERS.jpg', '150', 'Available', '1Box/10pcs'),
(35, '10 CM CRACKLING SPARKLERS', 'SPARKLERS ', '../uploads/1764244497_10 CM CRACKLING SPARKLERS.jpg', '150', 'Available', '1Box/10pcs'),
(36, '10 CM GREEN SPARKLERS', 'SPARKLERS ', '../uploads/1764244523_10 CM GREEN SPARKLERS.jpg', '150', 'Available', '1Box/10pcs'),
(37, '10 CM RED SPARKLERS', 'SPARKLERS ', '../uploads/1764244549_10 CM RED SPARKLERS.jpg', '150', 'Available', '1Box/10pcs'),
(38, '15 CM ELECTRIC SPARKLERS', 'ROCKETS', '../uploads/1764244571_15 CM ELECTRIC SPARKLERS.jpg', '300', 'Available', '1Box/10pcs'),
(39, '15 CM CRACKLING SPARKLERS', 'SPARKLERS ', '../uploads/1764244633_15 CM CRACKLING SPARKLERS.jpg', '300', 'Available', '1Box/10pcs'),
(40, '15 CM GREEN SPARKLERS', 'SPARKLERS ', '../uploads/1764244657_15 CM GREEN SPARKLERS.jpg', '300', 'Available', '1Box/10pcs'),
(41, '15 CM RED SPARKLERS', 'SPARKLERS ', '../uploads/1764244680_15 CM RED SPARKLERS.jpg', '300', 'Available', '1Box/10pcs'),
(42, 'ROTATING / UMBRELLA SPARKLERS', 'SPARKLERS ', '../uploads/1764244702_ROTATING  UMBRELLA SPARKLERS.jpg', '700', 'Available', '1Box/1pcs'),
(43, '15 CM ELECTRIC SPARKLERS', 'SPARKLERS ', '../uploads/1764244789_15 CM ELECTRIC SPARKLERS.jpg', '300', 'Available', '1Box/10pcs'),
(44, 'KIDS COMBO PACK (45 ITEMS)', 'COMBO PACK', '../uploads/1764244948_3000 Rs. KIDS COMBO PACK (45 ITEMS).jpg', '15000', 'Available', '1Box'),
(45, 'COMBO FAMILY PACK (60 ITEMS)', 'COMBO PACK', '../uploads/1764244971_5000 Rs. COMBO FAMILY PACK (60 ITEMS).jpg', '20000', 'Available', '1Box'),
(46, 'COMBO JUMBO PACK (72 ITEMS)', 'COMBO PACK', '../uploads/1764244999_7000 Rs. COMBO JUMBO PACK (72 ITEMS).jpg', '30000', 'Available', '1Box'),
(47, 'COMBO VIP PACK (85 ITEMS)', 'COMBO PACK', '../uploads/1764245028_10000 Rs. COMBO VIP PACK (85 ITEMS).jpg', '55000', 'Available', '1Box'),
(49, 'ULTRA PENCIL', 'FANCY PENCILS / FANCY CANDLES', '../uploads/1764478145_ULTRA PENCIL.jpg', '750', 'Available', '1Box/3pcs'),
(50, 'SPORTS SHOOTING GUN', 'FANCY PENCILS / FANCY CANDLES', '../uploads/1764478199_SPORTS SHOOTING GUN.jpg', '850', 'Available', '1Box/5pcs'),
(51, 'CROCODILE CANDLE', 'FANCY PENCILS / FANCY CANDLES', '../uploads/1764478253_CROCODILE CANDLE.jpg', '850', 'Available', '1Box/1pcs'),
(52, 'KING CANDLE', 'FANCY PENCILS / FANCY CANDLES', '../uploads/1764478281_KING CANDLE.jpg', '300', 'Available', '1pcs'),
(54, 'QUEEN CANDLE', 'FANCY PENCILS / FANCY CANDLES', '../uploads/1764478392_QUEEN CANDLE.jpg', '325', 'Available', '1pcs'),
(57, 'JELLY BEAN CANDLE', 'FANCY PENCILS / FANCY CANDLES', '../uploads/1764479781_JELLY BEAN CANDLE.jpg', '850', 'Available', '1Box/3pcs');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `orderedpro`
--
ALTER TABLE `orderedpro`
  ADD PRIMARY KEY (`orderedpro_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orderedpro`
--
ALTER TABLE `orderedpro`
  MODIFY `orderedpro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
