-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2023 at 09:50 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_xyz`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(17, 'Block heels', 'thick-shaped heels with a large surface area'),
(18, 'Wedge heels', ' no separation from the heel to the sole, provide stability and support'),
(19, 'Medium heels', ' between two and three inches, offer comfort and style'),
(20, 'Pumps', 'go-to allrounder'),
(21, 'Stiletto heels', 'pointy, thin heels that can give you height');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `f_name` varchar(150) NOT NULL,
  `l_name` varchar(150) NOT NULL,
  `email` varchar(200) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` int(10) NOT NULL,
  `password` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `f_name`, `l_name`, `email`, `address`, `phone`, `password`, `created_at`, `updated_at`) VALUES
(12, 'rikina', 'manandhar', 'rikinamdr@gmail.com', 'madhyapur thimi', 2147483647, '$2y$10$g89oFlmpvFx/OVdacR0PeOt08y4kCKuh6jJI5vUS04KryKsR0MjJO', '2023-11-26 10:30:24', '2023-11-26 10:30:24'),
(13, 'jeena', 'kalu', 'jeena@gmail.com', 'nagadesh', 15093047, '$2y$10$Lppuo8HVTND5tkwObqO.ZejtOgDtBGrWdzvxjGBmCarMxQ7KyNqau', '2023-11-26 10:40:02', '2023-11-26 10:40:02'),
(14, 'deepika', 'sakhakarmi', 'deep@gmail.com', 'dhara, bhaktapur', 16638057, '$2y$10$OFoSQ/AQPvRHfuoh2QIYxuNy9YyTWldVvZmduqBc1bEDseJLW91/a', '2023-11-26 10:41:16', '2023-11-26 10:41:16'),
(15, 'shriya', 'joshu', 'shriya@gmail.com', 'dudhpati', 16638453, '$2y$10$VR8jtAeMZCP2/x77eQ18ruz9L9am1//mGXjA4uGuoyxEQB/oyoVKC', '2023-11-26 15:08:28', '2023-11-26 15:08:28'),
(16, 'deepika', 'shrestha', 'deepi@gmail.com', 'madhyapur thimi', 2147483647, '$2y$10$vmMYd3Nj5qs7iva06uFOFu7pYxb8.e9Dl.YaGHJwpa3amzId6aLWu', '2023-12-07 11:10:12', '2023-12-07 11:10:12');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivery_date` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total_price`, `payment_method`, `order_date`, `delivery_date`, `status`) VALUES
(7, 12, 11800, 'Cash on Delivery', '2023-11-25 18:15:00', '2023-11-26 00:00:00', 1),
(8, 13, 8000, 'Cash on Delivery', '2023-11-25 18:15:00', '2023-11-26 00:00:00', 1),
(9, 14, 17700, 'Cash on Delivery', '2023-11-25 18:15:00', '2023-11-26 00:00:00', 1),
(10, 12, 6000, 'Cash on Delivery', '2023-11-25 18:15:00', NULL, 0),
(11, 15, 5000, 'Cash on Delivery', '2023-11-25 18:15:00', NULL, 0),
(12, 12, 20000, 'Cash on Delivery', '2023-12-06 18:15:00', NULL, 0),
(13, 12, 6000, 'Cash on Delivery', '2023-12-06 18:15:00', NULL, 0),
(14, 16, 5000, 'Cash on Delivery', '2023-12-06 18:15:00', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` int(11) NOT NULL,
  `order_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `quantity`, `price`, `total`) VALUES
(7, 7, 46, 1, 1800, 0),
(8, 8, 46, 1, 1800, 0),
(9, 8, 50, 1, 1700, 0),
(10, 8, 51, 1, 2500, 0),
(11, 8, 47, 1, 2000, 0),
(12, 9, 45, 1, 1200, 0),
(13, 9, 46, 5, 1800, 0),
(14, 9, 48, 1, 2500, 0),
(15, 9, 53, 1, 2500, 0),
(16, 9, 51, 1, 2500, 0),
(17, 10, 47, 3, 2000, 0),
(18, 11, 48, 2, 2500, 0),
(19, 12, 48, 8, 2500, 0),
(20, 13, 47, 3, 2000, 0),
(21, 14, 48, 2, 2500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `price`, `quantity`, `image`, `description`, `created_at`, `updated_at`, `admin_id`) VALUES
(45, 'Pinky', 19, 1200, 100, 'heels2.jpeg', 'Size:37,37,38', '2023-11-26 10:19:35', '2023-11-26 10:19:35', 34),
(46, 'Mary Jane heels', 21, 1800, 70, 'heels7.jpg', 'size:34,35', '2023-11-26 10:21:10', '2023-11-26 10:21:10', 34),
(47, 'Court shoes', 20, 2000, 30, 'sandal7.jpg', 'size;37,38,39', '2023-11-26 10:22:30', '2023-11-26 10:22:30', 34),
(48, 'Court shoes', 17, 2500, 40, 'heels1.jpg', 'size:39,40', '2023-11-26 10:23:45', '2023-11-26 10:23:45', 34),
(49, 'Decorative Heel', 21, 2000, 30, 'sandal_1.webp', 'size:33,34,35', '2023-11-26 10:24:59', '2023-11-26 10:24:59', 34),
(50, 'Flare', 20, 1700, 30, 'shoe3.JPG', 'size:34,35,36', '2023-11-26 10:27:04', '2023-11-26 10:27:04', 34),
(51, 'French', 21, 2500, 20, 'shoe4.JPG', 'size:36,37,38', '2023-11-26 10:33:04', '2023-11-26 10:33:04', 34),
(53, 'Kitten', 17, 2500, 40, 'sandal3.jpg', 'size:37,39', '2023-11-26 10:36:57', '2023-11-26 10:36:57', 34),
(55, 'new product', 17, 122, 12, 'm4.jpg', 'size: 12\r\nnew \r\ngbtnpjm\r\nadnjjjdnnnnnnd  dbddajjne dnbyeyyyyee beeeeeeeeeeeeeeeeeeeee eeeeeeeeeee eeeeeeeeeee', '2023-12-10 03:30:35', '2023-12-10 03:30:35', 12);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `l_name` varchar(150) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `f_name`, `l_name`, `password`, `email`, `created_at`, `updated_at`, `address`, `phone`) VALUES
(12, 'rikina', 'manandhar', '$2y$10$lj/yJafUk/H9oFqzvdNoqudMuAWlPcLezH.y/NVecNzqnVpnIsKOy', 'rikinamdr@gmail.com', '2023-11-22 12:35:01', '2023-11-22 12:35:01', NULL, NULL),
(34, 'deepika', 'shrestha', '$2y$10$yBWOsFUiUoUgncMPHIqWKOhRiN1O10BrxJRCFI0h8GKTaV.sRZQty', 'deepika@gmail.com', '2023-11-25 05:22:25', '2023-11-25 05:22:25', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`customer_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
