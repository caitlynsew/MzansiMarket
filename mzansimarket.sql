-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2026 at 05:41 PM
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
-- Database: `mzansimarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `disputes`
--

CREATE TABLE `disputes` (
  `dispute_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disputes`
--

INSERT INTO `disputes` (`dispute_id`, `order_id`, `user_id`, `description`, `status`, `created_at`) VALUES
(1, 1, 1, 'I received an iPhone that was advertised as being in excellent condition, but the device has multiple issues that were not disclosed by the seller. The battery drains very quickly, the screen has visible scratches, and Face ID is not functioning properly. I would like assistance resolving this issue or requesting a refund.\r\n', 'Pending', '2026-06-02 20:47:08');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `fullname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `payment_method` varchar(50) DEFAULT 'Simulated Payment',
  `shipping_method` varchar(50) DEFAULT NULL,
  `shipping_fee` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `buyer_id`, `total_amount`, `order_date`, `fullname`, `phone`, `address`, `status`, `payment_method`, `shipping_method`, `shipping_fee`) VALUES
(3, 4, 14999.00, '2026-06-03 10:52:52', 'sean govender ', '083 321 1567', '11 Daffodil Street', 'Pending', 'Simulated Payment', NULL, 0.00),
(4, 8, 370.00, '2026-06-04 21:52:15', 'Tim Bradford', '081 435 5367', '20 Dahlia Crescent', 'Ready for Delivery', 'Simulated Payment', NULL, 0.00),
(5, 10, 200.00, '2026-06-10 15:22:02', 'Asha Sewkumar', '083 724 8284', '21 Dahlia Crescent, Ballito', 'Processing', 'EFT', 'Local Delivery', 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `price`) VALUES
(1, 4, 7, 90.00),
(2, 4, 11, 280.00),
(3, 5, 10, 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `seller_id`, `product_name`, `description`, `price`, `image`, `category`, `created_at`, `stock`) VALUES
(2, 3, 'iPhone 15 (128 GB)', 'Brand new Pink iPhone 15 in excellent condition. Features a 6.1-inch Super Retina XDR display, advanced dual-camera system, USB-C charging, and all-day battery life. Perfect for photography, social media, gaming, and everyday use. Includes original charging cable and packaging.', 14999.00, 'iphone15.webp', 'Electronics', '2026-06-02 19:52:27', 1),
(3, 3, 'Adjustable Gaming Chair', 'Comfortable pink and white gaming chair designed for long gaming sessions, studying, or office use. Features adjustable height, padded armrests, ergonomic back support, and a modern racing-style design for maximum comfort and style. Perfect for gamers, streamers, and home office setups.', 2100.00, 'gaming chair.webp', 'Furniture', '2026-06-02 20:00:56', 1),
(4, 2, 'Desk Lamp', 'Modern white desk lamp with a sleek minimalist design, perfect for bedrooms, study spaces, and office desks. Provides bright adjustable lighting ideal for reading, studying, or working late at night. Compact, stylish, and energy-efficient to suit any modern workspace.', 1000.00, 'lamp.webp', 'Furniture', '2026-06-02 20:04:57', 1),
(5, 5, 'Oversized Brown Jacket', 'Stylish oversized brown zip-up jacket with a soft suede-look finish. Perfect for casual streetwear and cooler weather.', 350.00, 'jacket.webp', 'Clothing', '2026-06-03 17:11:51', 5),
(6, 5, 'Wooden Side Table', 'Simple wooden side table suitable for bedrooms, lounges, or small apartments. Strong, neat, and easy to move.', 450.00, 'sidetable.jpg', 'Furniture', '2026-06-03 17:14:33', 3),
(7, 5, 'The Classic Cap', '- Must Have Hat of the Season\r\n- Adjustable Back Strap\r\n- Made with 50% Recycled Cotton', 90.00, 'cap.webp', 'Clothing', '2026-06-03 17:17:38', 14),
(8, 6, 'Handmade Beaded Necklace', 'Locally handmade beaded necklace inspired by South African craft designs. Lightweight, colourful, and perfect for everyday wear.', 120.00, 'necklace.avif', 'Other', '2026-06-03 17:20:28', 12),
(9, 6, 'Traditional Print Tote Bag', 'Stylish tote bag made with bold African-inspired print fabric. Great for shopping, school, or daily use.', 180.00, 'tote bag.jpg', 'Clothing', '2026-06-03 17:24:07', 8),
(10, 6, 'Local Art Print', 'Decorative wall art print inspired by South African landscapes and culture. Perfect for bedrooms or offices.', 150.00, 'Local Art Print.jpg', 'Other', '2026-06-03 17:26:50', 9),
(11, 7, 'Pre-Owned Bluetooth Speaker ', 'Compact Bluetooth speaker with clear sound and long battery life. Ideal for home use, picnics, and small gatherings.', 280.00, 'speaker.webp', 'Electronics', '2026-06-03 17:31:37', 3),
(12, 7, 'Wireless Earphones ', 'Affordable wireless earphones with charging case. Good for music, calls, and daily travel.', 320.00, 'earphones.webp', 'Electronics', '2026-06-03 17:33:35', 6);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 2, 4, 5, 'Amazing phone overall. The iPhone 15 has a smooth design, excellent camera quality, fast performance, and great battery life. Perfect for everyday use, social media, gaming, and photography. Definitely worth it if you want a reliable and premium smartphone experience.', '2026-06-03 11:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('buyer','seller','admin') DEFAULT NULL,
  `verified` enum('yes','no') DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `email`, `password`, `role`, `verified`, `created_at`) VALUES
(1, 'caitlyn sewkumar', 'caitlynsew@icloud.com', '$2y$10$QVuO546A/aVyih0IOBbCk.FXmry6g3iVMEL8ngVChLCb0nq3IH6/6', 'admin', 'no', '2026-06-02 19:24:50'),
(2, 'arya padaychee', 'aryap@gmail.com', '$2y$10$L7boJvN6d15/HJ21MvNWku7CYyaZ4gQbGac0RdBhqjEkFgalLz0NO', 'seller', 'yes', '2026-06-02 19:25:24'),
(3, 'tamica erin cowley', 'tamicaec@gmail.com', '$2y$10$tVsuXDRROSNYW4FrQlx.ZOSSe3NqdGh6t51Gj6Qvij9ioRnZM3r7C', 'seller', 'yes', '2026-06-02 19:46:46'),
(4, 'sean govender', 'seang@gmail.com', '$2y$10$0M2/PB3JTdvjLL.GWzcJ6.PTjFzjHeIok8136MIVk3Pr.sL5Jd4Kq', 'buyer', 'no', '2026-06-02 21:24:07'),
(5, 'Thabo Mkize', 'seller1@test.com', '$2y$10$OGB27cMgVhDdP8rNuASVlODJp6inCZcNtP.i06tIFftcHbDBJv5sq', 'seller', 'yes', '2026-06-03 17:02:40'),
(6, 'Aisha Naidoo', 'seller2@test.com', '$2y$10$LSJ88iQOg5RLAHQ4Paa60e22eoVkOV.85oOQDDL.f5kwpmh6HX.I2', 'seller', 'yes', '2026-06-03 17:03:29'),
(7, 'Lerato Dlamini', 'seller3@test.com', '$2y$10$Po1IW3CXHRBXJz1Inmr4E.HzT/fPm68fPYQmWjNtc3ykCOsy4tMYe', 'seller', 'no', '2026-06-03 17:04:56'),
(8, 'Tim Bradford', 'buyer1@test.com', '$2y$10$h90SFKBprLK6N/NpZvKtk.ONJ1kiDa0rZHqf0aeUySJItBk1SxFU2', 'buyer', 'no', '2026-06-03 17:05:43'),
(9, 'Lucy Chen', 'buyer2@test.com', '$2y$10$pvwHXl1p8p4/YWS40LtjpO6x3qQXEXKjXeqjcFemecCBY.GYBvNwy', 'buyer', 'no', '2026-06-03 17:06:18'),
(10, '  Asha Sewkumar', 'ashasew@gmail.com', '$2y$10$FYPbdghQTiWJ8wk5d0SuleN9SJc2aANIfI9w5nESJfFTZ16rZQ4Bq', 'buyer', 'no', '2026-06-10 15:18:54');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 4, 4, '2026-06-03 12:03:22'),
(2, 10, 10, '2026-06-10 15:20:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `disputes`
--
ALTER TABLE `disputes`
  ADD PRIMARY KEY (`dispute_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `disputes`
--
ALTER TABLE `disputes`
  MODIFY `dispute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
