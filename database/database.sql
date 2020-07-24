-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 21, 2020 at 03:06 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eCommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `flat_number` varchar(5) NOT NULL,
  `street_number` int(5) NOT NULL,
  `street_name` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `postal_code` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `flat_number`, `street_number`, `street_name`, `city`, `province`, `postal_code`) VALUES
(1, '12', 39, 'Ezra Avenue', 'Waterloo', 'Ontario', 'N2L3A9'),
(2, '3B', 24, 'Austin Drive', 'Waterloo', 'Ontario', 'N2L3Y1'),
(3, 'A', 505, 'Glenelm Crescent', 'Waterloo', 'Ontarion', 'N2L5A7'),
(4, 'A', 365, 'Holly Street', 'Waterloo', 'Ontario', 'N2L4G2'),
(5, '501', 315, 'King Street North', 'Waterloo', 'Ontario', 'N2J2Z1');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `ip_address`, `product_id`, `quantity`) VALUES
(20, NULL, '192.168.64.1', 10, 2),
(21, NULL, '192.168.64.1', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(15) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Shirts', '2020-06-01 23:06:57', '2020-06-01 23:06:57', NULL),
(2, 'Joggers', '2020-06-01 23:07:32', '2020-06-01 23:07:32', NULL),
(3, 'Accessories', '2020-06-01 23:08:27', '2020-06-01 23:08:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_cost` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `order_time` datetime NOT NULL,
  `order_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `product_id`, `user_id`, `product_cost`, `quantity`, `address_id`, `order_time`, `order_status`) VALUES
(1, '1234567890', 1, 1, 41.49, 1, 1, '2020-06-01 16:10:49', 'delivered'),
(13, '7722678011', 10, 6, 63.38, 5, 4, '2020-06-21 00:53:14', 'Order Confirmed'),
(14, '7722678011', 1, 6, 41.49, 6, 4, '2020-06-21 00:53:14', 'Order Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_description` text NOT NULL,
  `product_image` varchar(100) NOT NULL,
  `cost` float NOT NULL,
  `quantity_available` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `product_name`, `product_description`, `product_image`, `cost`, `quantity_available`, `keywords`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Renzo performance shirt', 'Engineered using a fusion of athletic performance technologies like Dri Fit, Strategic Ventilation, and a special Jersey poly hybrid to withstand daily washing and anti bacterial properties.\r\n\r\nMaterials blend with ultra breathable meshing to provide the perfect balance between moisture management, breath-ability, and temperature control.\r\n\r\nEngineered panel cuts provide an ultra comfortable and aesthetic fitting.\r\n\r\nDesigned in Amsterdam.', 'shirt1.jpeg', 41.49, 10, 'shirt, black, blue, fit, sports, gym, outdoor, dry', '2020-06-02 00:01:45', NULL, NULL),
(2, 1, 'Arera prime shirt - White', 'Designed by Champions for Champions.\r\n\r\nA hybrid wear suitable for every round of life’s fight for success.\r\n\r\nComfort fit allows optimum freedom for all body types.\r\n\r\nHand made in Europe\r\n\r\nMade of Prometheus Bamboo', 'shirt2.jpeg', 27, 7, 'shirt, fit, dry, gym, fitness, outdoor, sports', '2020-06-02 00:04:26', NULL, NULL),
(3, 1, 'Human Savage Shirt - Orange', 'How do you stay Human?… in a hard world constructed to turn you into a Savage?\r\n\r\nPrometheus blends premium bamboo weave with elastane to create the most comfortable pieces you will ever wear\r\n\r\nFront flank reduced vs 1.0\r\nimproved ARC fit\r\nMade from breathable premium bamboo elastane\r\nHuman Savage premium full logo printing in the front and back\r\nMade in Europe', 'shirt3.jpeg', 41.49, 15, 'shirt, outdoor, durable, fit, fitness, gymnast, running, style, savage, human, human savage, orange', '2020-06-02 00:06:54', NULL, NULL),
(4, 1, 'Imperium shirt - Black and grey', 'Introducing the trademark Engineered Life Prometheus textile… The ultimate material for breath-ability, comfort, and styling.\r\n\r\nPrometheus blends premium bamboo weave with elastane to create the most comfortable pieces you will ever wear\r\n\r\nARC fit ensures a tailored and aesthetic fit\r\nBE logo on the upper left chest and upper back\r\nMade in Europe', 'shirt4.jpeg', 47.5, 5, 'shirt, imperium, black, grey, fit, gym, durable, sport', '2020-06-02 00:09:35', NULL, NULL),
(5, 1, 'Liber Shirt - Black and Grey', 'Introducing the trademark Engineered Life Prometheus textile… The ultimate material for breath-ability, comfort, and styling.\r\n\r\nPrometheus blends premium bamboo weave with elastane to create the most comfortable pieces you will ever wear\r\n\r\nARC fit ensures a tailored and aesthetic fit\r\nBE logo on the upper left chest and upper back\r\nMade in Europe', 'shirt5.jpeg', 50.89, 10, 'shirt, liber, black, grey, tshirt, fit, fitness, body engineers, tavi', '2020-06-02 00:11:14', NULL, NULL),
(6, 2, 'Liber jogger - Black and Grey', 'Introducing the trademark Engineered Life Prometheus textile… The ultimate material for breath-ability, comfort, and styling.\r\n\r\nPrometheus blends premium bamboo weave with elastane to create the most comfortable pieces you will ever wear\r\n\r\nARC fit ensures a tailored and aesthetic fit\r\nBack Pockets\r\nBE logo on upper left side\r\nMade in Europe', 'jogger1.jpeg', 89.81, 10, 'jogger, trackpant, fit, gym, sport, running, liber, black, grey', '2020-06-02 00:13:28', NULL, NULL),
(7, 2, 'Wodan jogger - Black and Light Grey', 'Introducing the trademark Engineered Life Prometheus textile… The ultimate material for breath-ability, comfort, and styling.\r\n\r\nPrometheus blends premium bamboo weave with elastane to create the most comfortable pieces you will ever wear\r\n\r\nARC fit ensures a tailored and aesthetic fit\r\nBack Pockets\r\nBE logo on upper left side\r\nMade in Europe', 'jogger2.jpeg', 89.81, 20, 'jogger, track, wodan, black, grey, fit, gym, stretchable', '2020-06-02 00:15:21', NULL, NULL),
(8, 2, 'Quadratus jogger - Black and Coral', 'Introducing the trademark Engineered Life Prometheus textile… The ultimate material for breath-ability, comfort, and styling.\r\n\r\nPrometheus blends premium bamboo weave with elastane to create the most comfortable pieces you will ever wear\r\n\r\nARC fit ensures a tailored and aesthetic fit\r\nBack Pockets\r\nBE logo on upper left side\r\nMade in Europe', 'jogger3.jpeg', 78.99, 13, 'jogger, quadratus, gym, black, coral, gym, workout', '2020-06-02 00:17:46', NULL, NULL),
(9, 2, 'Ronin Prometheus jogger - Petrol', 'Introducing the trademark Engineered Life Prometheus textile… The ultimate material for breath-ability, comfort, and styling.\r\n\r\nPrometheus blends premium bamboo weave with elastane to create the most comfortable pieces you will ever wear\r\n\r\nARC fit insures a tailored and aesthetic fit\r\nBack Pockets\r\nBE logo on upper left side\r\nadjustable calf tightness for a more aesthetic fit\r\nMade in Europe', 'jogger4.jpeg', 68.67, 18, 'jogger, prometheus, ronin, petrol, workout, gym, tavi', '2020-06-02 00:19:24', NULL, NULL),
(10, 2, 'Anax Performance jogger - Dutch Orange and Black', 'ANAX collection is engineered using a fusion of textile technologies found in football (soccer) and athletic performance wear.\r\n\r\nDri-fit materials blend with ultra-breathable meshing to provide the perfect balance between moisture management, breathability, and temperature control.\r\n\r\nEngineered panel cuts provide an ultra-comfortable and aesthetic fitting.\r\n\r\nDesigned in Amsterdam.', 'jogger5.jpeg', 63.38, 20, 'jogger, anax, performance, dutch, orange, black, fit, gym, sports, running', '2020-06-02 00:21:26', NULL, NULL),
(11, 3, 'BE Tactical Sling Bag - Army Green', 'Features:\r\n\r\nFully customizable sling pack fits laptops up to 18 inches, Sneakers, all gym essentials\r\nAdjustable cushioned shoulder strap\r\nTech pocket at the shoulder\r\nCovert TacTec pocket at rear\r\nSecondary double zip pocket\r\nHydration pocket\r\nOrganized storage area\r\nSturdy grab handle\r\nComfortable compression straps\r\nembroidered logo\r\n\r\nSpecifications:\r\n\r\nDurable, lightweight 1050D nylon\r\nWater resistant\r\nHook and loop flag patch\r\nself-healing zippers', 'accessory1.jpeg', 42.24, 15, 'bag, backpack, army, green, style, tactical', '2020-06-02 00:23:55', NULL, NULL),
(12, 3, 'BE Tactical Sling Bag - Fire Red', 'Features:\r\n\r\nFully customizable sling pack fits laptops up to 18 inches, Sneakers, all gym essentials\r\nAdjustable cushioned shoulder strap\r\nTech pocket at the shoulder\r\nCovert TacTec pocket at rear\r\nSecondary double zip pocket\r\nHydration pocket\r\nOrganized storage area\r\nSturdy grab handle\r\nComfortable compression straps\r\nembroidered logo\r\n\r\nSpecifications:\r\n\r\nDurable, lightweight 1050D nylon\r\nWater resistant\r\nHook and loop flag patch\r\nself-healing zippers', 'accessory2.jpeg', 42.24, 10, 'bag, backpack, fire, red, tactical, gym', '2020-06-02 00:25:39', NULL, NULL),
(13, 3, 'BE Tactical Sling Bag - Black', 'Features:\r\n\r\nFully customizable sling pack fits laptops up to 18 inches, Sneakers, all gym essentials\r\nAdjustable cushioned shoulder strap\r\nTech pocket at the shoulder\r\nCovert TacTec pocket at rear\r\nSecondary double zip pocket\r\nHydration pocket\r\nOrganized storage area\r\nSturdy grab handle\r\nComfortable compression straps\r\nembroidered logo\r\n\r\nSpecifications:\r\n\r\nDurable, lightweight 1050D nylon\r\nWater resistant\r\nHook and loop flag patch\r\nself-healing zippers', 'accessory3.jpeg', 42.24, 7, 'bag, backpack, black, tactical, gym', '2020-06-02 00:26:53', NULL, NULL),
(14, 3, 'BE Engineered Snapback – SAND', 'Limited Edition.\r\n\r\n100% acryl with embroidered BE logo on front.\r\n', 'accessory4.jpeg', 34.36, 20, 'cap, snapback, hat, sand, limited, special', '2020-06-02 00:28:27', NULL, NULL),
(15, 3, 'BE Engineered Snapback – BLACK', 'Limited Edition.\r\n\r\n100% acryl with embroidered BE logo on front.', 'accessory5.jpeg', 34.36, 14, 'cap, snapback, hat, black, style', '2020-06-02 00:29:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `product_id`, `user_id`, `rating`, `image`, `comment`, `created_at`) VALUES
(1, 1, 1, 4, NULL, 'Nice product', '2020-06-15 20:10:29'),
(12, 1, 6, 3, 'comment-shirt.jpg', 'Good product', '2020-06-20 22:47:02');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL,
  `postal_code` varchar(6) NOT NULL,
  `shipping_cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`id`, `postal_code`, `shipping_cost`) VALUES
(1, 'N2L3A9', 10);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email_address`, `password`, `first_name`, `last_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'hspectre@gmail.com', '1e4e8e7c3567e6cd39c10ff0a42b3639', 'Harvey', 'Spectre', '2020-06-01 23:00:07', '2020-06-01 23:00:07', NULL),
(2, 'mross@gmail.com', '4c3e1ec04215f69d6a8e9c023c9e4572', 'Mike', 'Ross', '2020-06-01 23:02:43', '2020-06-01 23:02:43', NULL),
(3, 'sholmes@gmail.com', '783cee5f9cdc3bc56fc30fbf300a9df1', 'Sherlock', 'Holmes', '2020-06-01 23:03:27', '2020-06-01 23:03:27', NULL),
(4, 'jwatson@gmail.com', '6e0b7076126a29d5dfcbd54835387b7b', 'John', 'Watson', '2020-06-01 23:04:15', '2020-06-01 23:04:15', NULL),
(5, 'oqueen@gmail.com', '553fcb594976460e66e32da18a2b6f88', 'Oliver', 'Queen', '2020-06-01 23:06:16', '2020-06-01 23:06:16', NULL),
(6, 'mmathers@gmail.com', 'cb05798be0b97cec8942fe36f352a423', 'Marshall', 'M', '2020-06-20 17:04:42', '2020-06-20 21:17:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `mapping_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`mapping_id`, `user_id`, `address_id`) VALUES
(1, 1, 1),
(9, 6, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_foreign_user_id` (`user_id`),
  ADD KEY `cart_foreign_product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_foreign_product_id` (`product_id`),
  ADD KEY `order_foreign_user_id` (`user_id`),
  ADD KEY `order_foreign_address_id` (`address_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_foreign_category_id` (`category_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_foreign_user` (`user_id`),
  ADD KEY `review_foreign_product` (`product_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`mapping_id`),
  ADD KEY `ua_foreign_user_id` (`user_id`),
  ADD KEY `ua_foreign_address_id` (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `mapping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_foreign_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `cart_foreign_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_foreign_address_id` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `order_foreign_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `order_foreign_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_foreign_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_foreign_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `review_foreign_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `ua_foreign_address_id` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `ua_foreign_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
