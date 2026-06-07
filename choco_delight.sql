-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2026 at 08:05 PM
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
-- Database: `choco_delight`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `name`, `email`, `created_at`) VALUES
(1, 'admin', 'admin123', 'Choco Admin', 'admin12@gmail.com', '2026-01-01 09:59:33');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Dairy Milk Chocolate', 'Dairy Milk Chocolate is a rich and creamy milk chocolate made with the goodness of quality cocoa and fresh milk. Its smooth texture and deliciously sweet taste melt perfectly in your mouth, making every bite a moment of pure joy. Ideal for sharing with loved ones or enjoying as a personal treat, Dairy Milk Chocolate brings happiness to every occasion.', '2026-01-01 11:00:25'),
(2, 'Kitkat Chocolate', 'KitKat ek popular wafer chocolate hai jisme crispy wafers aur smooth milk chocolate ka perfect combination hota hai. Har bite me crunchy texture aur rich chocolate taste milta hai, jo ise break time ke liye ideal snack banata hai.', '2026-01-02 15:00:55'),
(4, 'Premium Italian Chocolates (Venchi)', 'Venchi Premium Italian Chocolates represent the finest tradition of Italian chocolate craftsmanship.\r\nMade with high-quality cocoa and natural ingredients, Venchi focuses on purity and rich flavor.', '2026-01-25 12:33:09'),
(5, 'Milk Chocolate  ', 'Smooth, creamy chocolate made with milk solids. Sabse zyada popular & all-age favourite.', '2026-01-26 10:06:46'),
(7, 'Dark Chocolates', 'Rich, smooth, and slightly bitter chocolate made from premium cocoa. Perfect for chocolate lovers who enjoy intense flavor and a healthy treat.', '2026-01-29 05:09:03'),
(8, 'White Chocolates', 'Smooth, creamy chocolate made with real milk and cocoa butter. Sweet, rich, and perfect for every chocolate lover.', '2026-01-29 05:11:03'),
(9, 'Flavored Chocolates', 'Delicious chocolates infused with fruity, minty, or exotic flavors. Sweet, fun, and perfect for every chocolate lover.', '2026-01-29 05:13:11'),
(10, 'Nut & Fruit Chocolates', 'Crunchy nuts and juicy fruits blended with rich chocolate for a tasty, healthy treat. Perfect for snacking or gifting.', '2026-01-29 05:19:07'),
(11, 'Sugar Free & Healthy Chocolates', 'Delicious chocolates made without sugar, perfect for a guilt-free treat. Healthy, tasty, and suitable for everyone.', '2026-01-29 05:21:07'),
(12, 'Gift & Occasion Chocolates', 'Perfect chocolates for birthdays, festivals, or special moments. Sweet, beautifully crafted, and ready to delight anyone.', '2026-01-29 05:22:54'),
(13, 'toast', 'hiiiiiiiii', '2026-02-07 07:08:24');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Trusha Patel', 'trusha12@gmail.com', 'Godd!', '2026-02-15 09:22:00'),
(2, 'Riya', 'riya12@gmail.com', 'jjhj', '2026-02-20 05:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `password`) VALUES
(8, 'Krushna', 'krushna123@gmail.com', '1029384756', 'Gokul', '2026-01-22 05:44:36', '$2y$10$qSg/vFmOr9fYTxsd3dAbtOLyUODS3aYKWRQQJC6RW9SjuWv/AZkn6'),
(9, 'Radha', 'radha11@gmail.com', '0912873465', 'Raval,', '2026-01-22 05:46:24', '$2y$10$YYZMs9K65/qrw1W0wH/mruxL1xMBvCHSwfL.p/4o9CCs.hXop65oG'),
(10, 'Vishakha', 'vishakha123@gmail.com', '12332145665', 'Mathura', '2026-01-23 13:27:11', '$2y$10$7zlhvmzCHrgTx8ZlSX32YOCKM585GB1wwsoH6FGE5WhRoV2jEBBMO'),
(11, 'bittu', 'bittu12@gmail.com', '6863853948', 'ehheh', '2026-01-30 05:59:06', '$2y$10$GczDoUl170EtuJdsMGs0Qeo7xnYwaNsaAXgakP9OQAi2zOaEDjKv.'),
(12, 'dhruvi gajjar', '123@gmail.com', '1234', 'ahmedabad', '2026-02-07 06:57:33', '$2y$10$.F6ela5ry0pDREpUVltMjuOTsQlr5Jert8B.reeJPpCoMbxiyIcfe'),
(13, 'Thanak', 'thanak12@gmail.com', '1223456789', 'junagadh', '2026-02-15 08:45:38', '$2y$10$2rItyPkqAusWpzNmg31SLO80Ve44e.OxpZzBgcrnjhQlE1NgNvFB6'),
(14, 'nirva', 'nirva123@gmail.com', '1234567890', 'junagadh', '2026-02-28 04:41:40', '$2y$10$32kVWovpE.Sah02/lF6/CuZGjyvtlyubSS5fDJ4BZETYmn9y.ZxQC');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_person`
--

CREATE TABLE `delivery_person` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_person`
--

INSERT INTO `delivery_person` (`id`, `name`, `email`, `phone`, `status`, `created_at`, `password`, `user_id`) VALUES
(1, 'John ', 'delivery@chocodeligh', NULL, 'active', '2026-01-07 08:18:25', '$2y$10$zuIgq4j4/oUhJ9Pdb/gRLOrR.0wXWcj9IidkPan9IWE2QJRVxltT.', 1),
(7, 'Pari', 'pari123@gmail.com', '6434937493749', 'active', '2026-01-21 10:02:16', '', NULL),
(8, 'Nisha', 'nisha123@gmail.com', '6434937493749', 'active', '2026-01-21 11:00:40', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `customer_name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `product_id`, `customer_name`, `email`, `message`, `rating`, `created_at`) VALUES
(1, 1, 'Trusha', 'trusha12@gmail.com', 'very nice!', 4, '2026-01-02 08:34:22'),
(2, 12, 'Trusha', 'raj@gmail.com', 'Good!', 4, '2026-01-10 03:30:01'),
(3, 20, 'Radha', 'trushaghodasara@gmail.com', 'fgyuhj', 4, '2026-02-20 05:52:38'),
(4, 114, 'Radha', 'trusha@gmail.com', 'very nice!', 5, '2026-02-23 16:05:00'),
(5, 38, 'Radha', 'radha11@gmail.com', 'Very Nice!!', 5, '2026-03-11 16:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `product_id`, `filename`, `caption`, `created_at`) VALUES
(4, NULL, 'uploads/gallery/g_6992ea7f31ca2.jpg', 'Bite Into Bliss', '2026-02-16 09:59:27'),
(5, NULL, 'uploads/gallery/g_6992eb383204f.jpg', 'Savor the Sweetness', '2026-02-16 10:02:32'),
(6, NULL, 'uploads/gallery/g_6992eb41644ed.jpg', 'Melting Hearts Since Day One', '2026-02-16 10:02:41'),
(7, NULL, 'uploads/gallery/g_6992eb490dfae.jpg', 'Where Chocolate Dreams Come True', '2026-02-16 10:02:49'),
(8, NULL, 'uploads/gallery/g_6992eb54342a0.jpg', 'A Taste of Luxury', '2026-02-16 10:03:00'),
(10, NULL, 'uploads/gallery/g_6992edf9adf82.jpg', 'Sweet Moments, Sweeter Memories', '2026-02-16 10:14:17'),
(11, NULL, 'uploads/gallery/g_6992f65ea23e3.jpg', 'Crafted with Love & Cocoa', '2026-02-16 10:50:06'),
(12, NULL, 'uploads/gallery/g_6992f66d9dd09.jpg', 'Pure Happiness in Chocolate Form', '2026-02-16 10:50:21'),
(13, NULL, 'uploads/gallery/g_6992f676a3f85.jpg', 'Indulge in Every Bite', '2026-02-16 10:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivery_person_id` int(11) DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total`, `status`, `created_at`, `delivery_person_id`, `delivery_date`, `updated_at`) VALUES
(21, 8, 690.00, 'delivered', '2026-01-22 05:44:48', 1, NULL, '2026-01-23 17:21:40'),
(22, 9, 180.00, 'delivered', '2026-01-22 05:46:29', 1, NULL, '2026-01-23 17:21:40'),
(23, 8, 580.00, 'delivered', '2026-01-22 06:57:13', 1, NULL, '2026-01-23 18:54:40'),
(24, 8, 120.00, 'processing', '2026-01-22 07:13:39', 1, NULL, '2026-02-06 20:09:59'),
(25, 9, 88.00, 'pending', '2026-01-23 04:32:30', NULL, NULL, '2026-01-23 17:21:40'),
(26, 9, 130.00, 'pending', '2026-01-23 04:39:22', NULL, NULL, '2026-01-23 17:21:40'),
(27, 9, 690.00, 'pending', '2026-01-23 05:14:49', NULL, NULL, '2026-01-23 17:21:40'),
(28, 9, 199.00, '', '2026-01-23 05:51:33', 1, NULL, '2026-01-25 17:32:50'),
(29, 9, 130.00, 'delivered', '2026-01-23 05:55:56', 1, NULL, '2026-02-06 20:12:24'),
(30, 10, 700.00, 'delivered', '2026-01-23 13:27:49', 7, NULL, '2026-01-23 19:00:08'),
(31, 9, 180.00, '', '2026-01-25 11:37:14', 1, NULL, '2026-02-28 12:42:32'),
(32, 11, 176.00, 'pending', '2026-01-30 05:59:13', NULL, NULL, '2026-01-30 11:29:13'),
(33, 12, 999.00, 'delivered', '2026-02-07 06:59:09', 8, NULL, '2026-02-07 12:30:00'),
(34, 9, 1299.00, 'pending', '2026-02-18 05:28:58', NULL, NULL, '2026-02-18 10:58:58'),
(35, 9, 800.00, 'pending', '2026-02-23 16:03:33', NULL, NULL, '2026-02-23 21:33:33'),
(36, 14, 1150.00, 'shipped', '2026-02-28 04:42:56', 7, NULL, '2026-02-28 12:43:57'),
(37, 9, 3198.00, 'pending', '2026-03-11 08:26:17', NULL, NULL, '2026-03-11 13:56:17');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT 1,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(22, 21, 12, 3, 230.00),
(23, 22, 6, 3, 60.00),
(24, 23, 7, 1, 130.00),
(25, 23, 8, 5, 90.00),
(26, 24, 20, 1, 120.00),
(27, 25, 5, 1, 88.00),
(28, 26, 7, 1, 130.00),
(29, 27, 10, 1, 250.00),
(30, 27, 4, 4, 110.00),
(31, 28, 11, 1, 199.00),
(32, 29, 7, 1, 130.00),
(33, 30, 23, 2, 350.00),
(34, 31, 20, 1, 120.00),
(35, 31, 6, 1, 60.00),
(36, 32, 5, 2, 88.00),
(37, 33, 37, 1, 999.00),
(38, 34, 39, 1, 799.00),
(39, 34, 24, 1, 500.00),
(40, 35, 114, 2, 400.00),
(41, 36, 36, 1, 1150.00),
(42, 37, 38, 2, 1599.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `status` enum('pending','paid','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `amount`, `method`, `status`, `created_at`) VALUES
(18, 21, 690.00, 'Cash on Delivery', 'paid', '2026-01-22 05:44:48'),
(19, 22, 180.00, 'Cash on Delivery', 'paid', '2026-01-22 05:46:29'),
(20, 23, 580.00, 'Cash on Delivery', 'paid', '2026-01-22 06:57:13'),
(21, 24, 120.00, 'UPI', 'paid', '2026-01-22 07:13:40'),
(22, 25, 88.00, 'UPI', 'pending', '2026-01-23 04:32:30'),
(23, 26, 130.00, 'Card', 'pending', '2026-01-23 04:39:22'),
(24, 27, 690.00, 'Cash on Delivery', 'pending', '2026-01-23 05:14:49'),
(25, 28, 199.00, 'Cash on Delivery', 'pending', '2026-01-23 05:51:33'),
(26, 29, 130.00, 'Cash on Delivery', 'pending', '2026-01-23 05:55:56'),
(27, 30, 700.00, 'Cash on Delivery', 'pending', '2026-01-23 13:27:49'),
(28, 31, 180.00, 'Cash on Delivery', 'pending', '2026-01-25 11:37:14'),
(29, 32, 176.00, 'Cash on Delivery', 'pending', '2026-01-30 05:59:13'),
(30, 33, 999.00, 'UPI', 'pending', '2026-02-07 06:59:09'),
(32, 35, 800.00, 'Cash on Delivery', 'pending', '2026-02-23 16:03:33'),
(33, 36, 1150.00, 'Card', 'pending', '2026-02-28 04:42:56'),
(34, 37, 3198.00, 'Cash on Delivery', 'pending', '2026-03-11 08:26:17');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `show_on_home` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_trending` tinyint(1) DEFAULT 0,
  `is_best_seller` tinyint(1) DEFAULT 0,
  `is_fresh` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `subcategory_id`, `name`, `description`, `price`, `stock`, `image`, `show_on_home`, `created_at`, `is_trending`, `is_best_seller`, `is_fresh`) VALUES
(1, 1, 1, 'Dairy Milk Plain Chocolate', 'Experience the timeless taste of smooth and creamy milk chocolate that melts effortlessly in your mouth. Made with rich cocoa and fresh milk, this classic chocolate delivers pure happiness in every bite—perfect for sharing or enjoying all by yourself.', 55.00, 1230, 'uploads/p_6956542563464.jpg', 1, '2026-01-01 11:01:57', 1, 0, 0),
(2, 1, 1, 'Dairy Milk Silk', 'Indulge in the irresistibly smooth and luxurious texture of Dairy Milk Silk. Crafted to melt gently on your tongue, this chocolate offers a rich, velvety experience that turns every moment into a celebration of sweetness and pleasure.', 99.00, 1230, 'uploads/p_6957a03629974.jpg', 1, '2026-01-02 10:38:46', 0, 2, 0),
(3, 1, 1, 'Dairy Milk Silk Bubbly', 'Enjoy a light and airy chocolate experience with Dairy Milk Silk Bubbly. Filled with delicate chocolate bubbles, it delivers a soft crunch and a melt-in-mouth feel that makes every bite fun, playful, and delightfully smooth.', 150.00, 2304, 'uploads/p_6957a0cc6842e.jpg', 1, '2026-01-02 10:41:16', 0, 0, 3),
(4, 1, 1, 'Dairy Milk Silk Roast Almond', 'Treat yourself to the perfect blend of smooth milk chocolate and crunchy roasted almonds. Each bite combines rich silkiness with nutty goodness, creating a satisfying chocolate experience that’s both indulgent and wholesome.', 110.00, 111, 'uploads/p_6957a130e535f.jpg', 1, '2026-01-02 10:42:56', 0, 0, 0),
(5, 1, 1, 'Dairy Milk Silk Fruit & Nut', 'Discover a delicious mix of creamy milk chocolate, juicy dried fruits, and crunchy nuts. This delightful combination offers a balance of sweetness and texture, making it a perfect treat for those who love a rich and flavorful chocolate experience.', 88.00, 1123, 'uploads/p_6957a17573046.jpg', 1, '2026-01-02 10:44:05', 0, 0, 0),
(6, 1, 2, 'Dairy Milk Fruit & Nut', 'A classic combination of smooth milk chocolate, crunchy almonds, and juicy raisins. This timeless favorite delivers a rich, nutty crunch with a hint of fruity sweetness, creating a perfectly balanced and satisfying chocolate experience.', 60.00, 1110, 'uploads/p_6957a9fe5d248.jpg', 1, '2026-01-02 11:20:30', 0, 0, 0),
(7, 1, 2, 'Dairy Milk Crackle', 'Enjoy the fun and crunch of crisp rice blended into creamy milk chocolate. Dairy Milk Crackle offers a light, crispy texture with a smooth chocolatey finish, making every bite exciting, crunchy, and deliciously satisfying.', 130.00, 1120, 'uploads/p_6957aa4bb6351.jpg', 1, '2026-01-02 11:21:47', 0, 0, 0),
(8, 1, 2, 'Dairy Milk  Coffee Almonds', 'Indulge in the rich taste of creamy milk chocolate generously packed with crunchy roasted almonds. This chocolate offers a perfect harmony of smoothness and nutty crunch, ideal for almond lovers seeking a premium chocolate treat.', 90.00, 1230, 'uploads/p_6957aa984311c.jpg', 1, '2026-01-02 11:23:04', 0, 0, 0),
(9, 1, 4, 'Dairy Milk Silk Oreo', 'Indulge in the irresistible fusion of silky smooth milk chocolate and crunchy Oreo cookie pieces. Every bite delivers a perfect balance of creamy sweetness and chocolatey crunch, making it a delightful treat for Oreo lovers.', 199.00, 1234, 'uploads/p_6957c158e734d.jpg', 1, '2026-01-02 13:00:08', 0, 0, 0),
(10, 1, 4, 'Dairy Milk Silk Red Velvet', 'Experience the rich and velvety taste of red velvet blended with smooth Dairy Milk chocolate. This luxurious treat offers a soft, creamy texture with a hint of cocoa', 250.00, 1234, 'uploads/p_6957c19b9b286.jpg', 1, '2026-01-02 13:01:15', 0, 0, 0),
(11, 1, 4, 'Dairy Milk Silk Hazelnut', 'Savor the rich combination of smooth milk chocolate and crunchy roasted hazelnuts. This premium chocolate delivers a nutty crunch wrapped in silky sweetness, creating a truly indulgent and satisfying chocolate experience.', 199.00, 2345, 'uploads/p_6957c1ceb66eb.jpg', 1, '2026-01-02 13:02:06', 0, 0, 0),
(12, 1, 4, 'Dairy Milk Lickables', 'A fun and playful chocolate treat filled with creamy Dairy Milk chocolate and exciting surprises inside. Dairy Milk Lickables are perfect for kids and kids-at-heart, bringing joy, sweetness, and a little surprise in every pack.', 230.00, 1234, 'uploads/p_6957c1fd9c377.jpg', 1, '2026-01-02 13:02:53', 0, 0, 0),
(16, 2, 5, 'KitKat 2 Finger', 'Light crispy wafers coated with smooth milk chocolate – perfect for a quick break.', 20.00, 1230, 'uploads/p_6958a9a8514f1.jpg', 1, '2026-01-03 05:31:20', 0, 0, 0),
(17, 2, 5, 'KitKat 4 Finger', 'Four crunchy wafer fingers covered in rich milk chocolate, ideal for sharing.', 50.00, 1111, 'uploads/p_6959425d4d9ea.jpg', 1, '2026-01-03 16:22:53', 0, 0, 0),
(18, 2, 6, 'KitKat Dark Chocolate', 'Crispy wafers wrapped in intense dark chocolate for a bold chocolate taste.', 200.00, 2456, 'uploads/p_6959463eba14e.jpg', 1, '2026-01-03 16:39:26', 0, 0, 0),
(19, 2, 6, 'KitKat White Chocolate', 'Crunchy wafer fingers coated with creamy white chocolate for a smooth flavor.', 199.00, 1230, 'uploads/p_695946fb96486.jpg', 1, '2026-01-03 16:42:35', 0, 0, 0),
(20, 2, 6, 'KitKat Strawberry', 'Delicious wafers covered with strawberry-flavoured chocolate for a fruity twist.', 120.00, 1230, 'uploads/p_69594730750ba.jpg', 1, '2026-01-03 16:43:28', 0, 0, 0),
(21, 2, 6, 'KitKat Matcha Green Tea', 'Crispy wafers blended with authentic Japanese matcha green tea chocolate.', 255.00, 1230, 'uploads/p_6959476902084.jpg', 1, '2026-01-03 16:44:25', 0, 0, 0),
(22, 2, 6, 'KitKat Ruby', 'Naturally pink ruby chocolate with a fruity, slightly tangy flavour.', 120.00, 1230, 'uploads/p_695947a09a22c.jpg', 1, '2026-01-03 16:45:20', 0, 0, 0),
(23, 2, 7, 'KitKat Mini', 'Bite-sized KitKat pieces, perfect for snacking and sharing.', 350.00, 1234, 'uploads/p_69594beb21b49.jpg', 1, '2026-01-03 17:03:39', 0, 0, 0),
(24, 2, 7, 'KitKat Family Pack', 'Multiple KitKat bars packed together for family and group enjoyment.', 500.00, 1234, 'uploads/p_69594c144f163.jpg', 1, '2026-01-03 17:04:20', 0, 0, 0),
(25, 2, 6, 'KitKat Velvet', 'KitKat Velvet offers a smooth and luxurious chocolate experience with its rich, velvety coating and crispy wafer layers inside. Every bite delivers a perfect balance of creamy texture and crunchy wafers, making it an indulgent treat for special moments.', 199.00, 1239, 'uploads/p_69594c8b0f9bf.jpg', 1, '2026-01-03 17:06:19', 0, 0, 0),
(26, 4, 9, 'Venchi Gianduja Classic', 'Venchi Gianduja Classic blends premium cocoa with finely ground hazelnuts.\r\nIt delivers a silky smooth texture and rich chocolate aroma.\r\nThe flavor is balanced, not too sweet, and deeply satisfying.\r\nA timeless Italian chocolate experience.', 1100.00, 1234, 'uploads/p_697613a68f38c.jpg', 1, '2026-01-25 12:59:18', 0, 0, 0),
(27, 4, 9, 'Venchi Dark Gianduja', 'This dark Gianduja chocolate offers an intense cocoa taste with roasted hazelnuts.\r\nIt is less sweet and perfect for dark chocolate enthusiasts.\r\nThe texture remains smooth and melt-in-the-mouth.\r\nAn elegant and bold chocolate choice.', 1500.00, 1230, 'uploads/p_69761406c440e.jpg', 1, '2026-01-25 13:00:54', 0, 0, 0),
(28, 4, 9, 'Venchi Milk Gianduja', 'Venchi Milk Gianduja combines creamy milk chocolate with rich hazelnut paste.\r\nIt has a soft, sweet, and comforting flavor profile.\r\nPerfect for those who prefer mild and creamy chocolates.\r\nA classic favorite for all ages.', 2000.00, 1234, 'uploads/p_697614aa14b99.jpg', 1, '2026-01-25 13:03:38', 0, 0, 0),
(29, 4, 9, 'Venchi Gianduja Vegan', 'This vegan Gianduja is made without dairy but keeps the classic taste.\r\nIt uses plant-based ingredients and premium cocoa.\r\nSmooth texture with deep hazelnut flavor.\r\nIdeal for vegan and dairy-free customers.', 1000.00, 1234, 'uploads/p_6976151edeba7.jpg', 1, '2026-01-25 13:05:34', 0, 0, 0),
(30, 4, 9, 'Venchi Gianduja Gift Box', 'An assorted gift box featuring premium Gianduja chocolates.\r\nBeautifully packed for special occasions.\r\nOffers a variety of textures and flavors.\r\nA perfect gift for chocolate lovers.', 1240.00, 1234, 'uploads/p_69761565ab2b2.jpg', 1, '2026-01-25 13:06:45', 0, 0, 0),
(31, 4, 10, 'Venchi Cremino Classic', 'Venchi Cremino Classic features three smooth layers of chocolate and hazelnut cream.\r\nIt melts gently in the mouth with a rich, balanced taste.\r\nCrafted using traditional Italian techniques.\r\nA signature Venchi favorite.', 1220.00, 1234, 'uploads/p_697640483700c.jpg', 1, '2026-01-25 16:09:44', 0, 0, 0),
(32, 4, 10, 'Venchi Cremino Dark', 'This dark Cremino combines intense cocoa with smooth hazelnut layers.\r\nLess sweet and more cocoa-forward in taste.\r\nIdeal for dark chocolate lovers.\r\nA bold yet creamy chocolate option.', 2200.00, 1230, 'uploads/p_697640b9ca5f5.jpg', 1, '2026-01-25 16:11:37', 0, 0, 0),
(33, 4, 10, 'Venchi Cremino Milk', 'Made with creamy milk chocolate and soft hazelnut filling.\r\nIt offers a sweet and comforting flavor profile.\r\nPerfect for those who enjoy smooth milk chocolates.\r\nA timeless classic treat.', 800.00, 1239, 'uploads/p_6976412e52f0a.jpg', 1, '2026-01-25 16:13:34', 0, 0, 0),
(34, 4, 10, 'Venchi Cremino Pistachio', 'This Cremino features a rich pistachio cream layered with white chocolate.\r\nIt delivers a nutty, slightly sweet taste.\r\nSmooth texture with premium pistachio flavor.\r\nA luxurious and unique chocolate choice.', 550.00, 1234, 'uploads/p_697641697b1d1.jpg', 1, '2026-01-25 16:14:33', 0, 0, 0),
(35, 4, 10, 'Venchi Cremino Raspberry', 'A delightful blend of chocolate and raspberry-flavored cream layers.\r\nOffers a fruity twist with creamy smoothness.\r\nPerfectly balanced sweetness and tang.\r\nAn elegant flavored Cremino option.', 750.00, 1234, 'uploads/p_697641a212253.jpg', 1, '2026-01-25 16:15:30', 0, 0, 0),
(36, 4, 10, 'Venchi Cremino Coconut', 'This Cremino combines coconut cream with milk chocolate layers.\r\nIt has a tropical and smooth flavor profile.\r\nLight, creamy, and aromatic.\r\nIdeal for coconut chocolate lovers.', 1150.00, 1234, 'uploads/p_697642af2eec6.jpg', 1, '2026-01-25 16:19:59', 0, 0, 0),
(37, 4, 10, 'Venchi Cremino Assorted Mini Box', 'An assorted selection of mini Cremino chocolates.\r\nIncludes multiple flavors in one box.\r\nPerfect for sharing or gifting.\r\nA premium Venchi chocolate assortment.', 999.00, 1234, 'uploads/p_69764305bf0b3.jpg', 1, '2026-01-25 16:21:25', 0, 0, 0),
(38, 4, 10, 'Venchi Cremino Gift Box', 'A beautifully packaged gift box of Cremino chocolates.\r\nFeatures rich flavors and smooth textures.\r\nIdeal for celebrations and special occasions.\r\nA refined gift for chocolate enthusiasts.', 1599.00, 1234, 'uploads/p_697643473faf3.jpg', 1, '2026-01-25 16:22:31', 0, 0, 0),
(39, 4, 11, 'Venchi Sugar-Free Dark Chocolate Bar', 'A rich dark chocolate bar with no added sugar.\r\nDelivers intense cocoa taste and smooth texture.\r\nSweetened naturally without compromising flavor.\r\nIdeal for guilt-free indulgence.', 799.00, 1230, 'uploads/p_697647ade1940.jpg', 1, '2026-01-25 16:41:17', 0, 0, 0),
(40, 4, 11, 'Venchi Sugar-Free Milk Chocolate', 'Creamy milk chocolate made without added sugar.\r\nBalanced sweetness with a smooth finish.\r\nPerfect for everyday chocolate cravings.\r\nA healthier twist on a classic favorite.', 866.00, 1234, 'uploads/p_69764816e0462.jpg', 1, '2026-01-25 16:43:02', 0, 0, 0),
(41, 4, 11, 'Cherry Sugar Free', 'Venchi Cherry Sugar-Free Chocolate combines rich cocoa with a delicate cherry flavor.\r\nMade without added sugar, it offers natural sweetness and balanced taste.\r\nThe fruity cherry notes perfectly complement the smooth chocolate texture.\r\nAn elegant, guilt-free treat for health-conscious chocolate lovers.', 599.00, 1234, 'uploads/p_69764870ee219.jpg', 1, '2026-01-25 16:44:32', 0, 0, 0),
(43, 5, 12, 'Amul Milk Chocolate', 'Rich Indian milk chocolate with classic cocoa taste', 99.00, 1111, 'uploads/p_69773e58ce543.jpg', 0, '2026-01-26 10:13:44', 0, 0, 0),
(44, 5, 12, 'Milkybar', 'White milk chocolate, extra creamy', 90.00, 1236, 'uploads/p_69773ef9ea08b.jpg', 0, '2026-01-26 10:16:25', 0, 0, 0),
(45, 5, 12, 'Galaxy Smooth Milk', 'Very smooth & creamy milk chocolate', 85.00, 1234, 'uploads/p_69773f2c3f761.jpg', 0, '2026-01-26 10:17:16', 0, 0, 0),
(46, 5, 13, 'Hershey’s Almond Milk Chocolate', 'Milk chocolate with roasted almonds', 159.00, 1234, 'uploads/p_69774253622a9.jpg', 0, '2026-01-26 10:30:43', 0, 0, 0),
(47, 5, 12, 'Galaxy Fruit & Nut', 'Milk chocolate with raisins & nuts', 169.00, 1234, 'uploads/p_6977429a18832.jpg', 0, '2026-01-26 10:31:54', 0, 0, 0),
(48, 5, 13, 'Amul Fruit & Nut Chocolate', 'Indian milk chocolate with dry fruits', 125.00, 1234, 'uploads/p_697742c0d280d.jpg', 0, '2026-01-26 10:32:32', 0, 0, 0),
(50, 7, 15, 'Classic Dark Chocolate Bar', 'Rich, smooth dark chocolate with a perfect balance of sweetness and bitterness. Ideal for snacking or gifting.', 200.00, 1200, 'uploads/p_697af55c87733.jpg', 0, '2026-01-29 05:51:24', 0, 0, 0),
(51, 7, 15, '70% Cocoa Dark Chocolate', 'Bold and rich dark chocolate with 70% cocoa. Slightly bitter and perfect for true chocolate lovers.', 150.00, 1100, 'uploads/p_697af672a96d9.jpg', 0, '2026-01-29 05:56:02', 0, 0, 0),
(52, 7, 15, 'Sugar-Free Dark Chocolate', 'Rich dark chocolate without sugar. Guilt-free indulgence with intense cocoa flavor, perfect for health-conscious chocolate lovers.', 120.00, 1000, 'uploads/p_697af7ee7a6b0.jpg', 0, '2026-01-29 06:02:22', 0, 0, 0),
(53, 7, 15, 'Vegan Dark Chocolate', 'Rich, smooth, 100% plant-based dark chocolate. Perfect for vegans and chocolate lovers who enjoy intense cocoa flavor.', 450.00, 599, 'uploads/p_697b18497aaf5.jpg', 0, '2026-01-29 08:20:25', 0, 0, 0),
(54, 7, 15, 'Premium Dark Chocolate', 'Luxuriously rich and smooth dark chocolate with intense cocoa flavor. Crafted for true chocolate connoisseurs.', 900.00, 1500, 'uploads/p_697b19a0ab676.jpg', 0, '2026-01-29 08:26:08', 0, 0, 0),
(55, 7, 15, '85% Cocoa Dark Chocolate', 'Bold and intense dark chocolate with 85% cocoa. Perfect for those who love rich, slightly bitter chocolate.', 500.00, 1000, 'uploads/p_697b1c5dccb69.jpg', 0, '2026-01-29 08:37:49', 0, 0, 0),
(56, 7, 15, 'Mini Dark Chocolate', 'Bite-sized rich dark chocolate, perfect for snacking, sharing, or gifting. Smooth and slightly bitter for chocolate lovers.', 220.00, 2000, 'uploads/p_697b1d56208e8.jpg', 0, '2026-01-29 08:41:58', 0, 0, 0),
(57, 7, 15, 'Dark Chocolate Truffles', 'Smooth, creamy dark chocolate truffles with rich cocoa flavor. Perfect for gifting or indulging in a luxurious treat.', 450.00, 7000, 'uploads/p_697b1f489de27.jpg', 0, '2026-01-29 08:50:16', 0, 0, 0),
(58, 7, 16, 'Dark Chocolate with Almonds', 'Smooth dark chocolate with crunchy almonds. Perfect for snacking or gifting.', 350.00, 3000, 'uploads/p_697b2274cb3ac.jpg', 0, '2026-01-29 09:03:48', 0, 0, 0),
(59, 7, 16, 'Dark Chocolate with Cashews', 'Rich dark chocolate blended with roasted cashews.', 300.00, 1000, 'uploads/p_697b2396b1cd9.jpg', 0, '2026-01-29 09:08:38', 0, 0, 0),
(60, 7, 16, 'Dark Chocolate with Hazelnuts', 'Creamy dark chocolate with whole hazelnuts.', 100.00, 1230, 'uploads/p_697b246ceb969.jpg', 0, '2026-01-29 09:12:12', 0, 0, 0),
(61, 7, 16, 'Dark Chocolate with Pistachios', 'Premium dark chocolate with crunchy pistachios.', 360.00, 799, 'uploads/p_697b258d35c46.jpg', 0, '2026-01-29 09:17:01', 0, 0, 0),
(62, 7, 16, 'Crunchy Nut Dark Chocolate', 'Dark chocolate with roasted mixed nuts for extra crunch.', 180.00, 5000, 'uploads/p_697b26b834dfd.jpg', 0, '2026-01-29 09:22:00', 0, 0, 0),
(63, 7, 16, 'Premium Dark Chocolate with Nuts', 'Luxury dark chocolate blended with select crunchy nuts. Perfect for gifting.', 650.00, 2500, 'uploads/p_697b281cae4b4.jpg', 0, '2026-01-29 09:27:56', 0, 0, 0),
(64, 7, 16, 'Handmade Dark Chocolate with Nuts', 'Artisan handmade dark chocolate with rich cocoa and crunchy nuts. Perfect for gifting or special indulgence.', 400.00, 3500, 'uploads/p_697b28d95787f.jpg', 0, '2026-01-29 09:31:05', 0, 0, 0),
(65, 7, 16, 'Mini Dark Chocolate with Nuts', 'Bite-sized dark chocolate pieces with crunchy nuts, perfect for snacking.', 499.00, 5500, 'uploads/p_697b29d5da569.jpg', 0, '2026-01-29 09:35:17', 0, 0, 0),
(66, 7, 17, 'Caramel Filled Dark Chocolate', 'Rich dark chocolate with smooth caramel filling.', 300.00, 1200, 'uploads/p_697b3f8c64bde.jpg', 0, '2026-01-29 11:07:56', 0, 0, 0),
(67, 7, 17, 'Hazelnut Filled Dark Chocolate', 'Dark chocolate filled with rich hazelnut cream.', 320.00, 1350, 'uploads/p_697b4028ce46b.jpg', 0, '2026-01-29 11:10:32', 0, 0, 0),
(68, 7, 17, 'Almond Filled Dark Chocolate', 'Crunchy almond filling wrapped in dark chocolate.', 200.00, 899, 'uploads/p_697b418c38d48.jpg', 0, '2026-01-29 11:16:28', 0, 0, 0),
(69, 7, 17, 'Strawberry Filled Dark Chocolate', 'Sweet strawberry filling with rich dark chocolate.', 360.00, 6900, 'uploads/p_697b42505df95.jpg', 0, '2026-01-29 11:19:44', 0, 0, 0),
(70, 7, 17, 'Orange Filled Dark Chocolate', 'Zesty orange filling inside dark chocolate.', 330.00, 3000, 'uploads/p_697b43d7287dd.jpg', 0, '2026-01-29 11:26:15', 0, 0, 0),
(71, 7, 17, 'Coffee Filled Dark Chocolate', 'Bold coffee filling with intense dark chocolate.', 360.00, 4000, 'uploads/p_697b4525ceb6e.jpg', 0, '2026-01-29 11:31:49', 0, 0, 0),
(72, 7, 17, 'Mint Filled Dark Chocolate', 'Refreshing mint filling with dark chocolate.', 170.00, 5990, 'uploads/p_697b46a0859be.jpg', 0, '2026-01-29 11:38:08', 0, 0, 0),
(73, 7, 17, 'Cream Filled Dark Chocolate', 'Dark chocolate with soft, creamy center.', 180.00, 2000, 'uploads/p_697b488472b49.jpg', 0, '2026-01-29 11:46:12', 0, 0, 0),
(74, 9, 19, 'ChocoBerry Bliss', 'Smooth, rich chocolate blended with sweet and tangy berry flavor. A perfect bite of chocolatey goodness with a fruity twist.', 300.00, 1500, 'uploads/p_697d8f9b53fc8.jpg', 0, '2026-01-31 05:14:03', 0, 0, 0),
(75, 9, 19, 'BerryPop Chocolates', 'Delicious chocolate with a fun burst of juicy berry flavor. Sweet, smooth, and perfect for anytime treats.', 200.00, 1000, 'uploads/p_697d91d1dd65a.jpg', 0, '2026-01-31 05:23:29', 0, 0, 0),
(76, 9, 19, 'cadbury Choco Delight', 'Soft, creamy chocolate with a rich cocoa taste that melts in your mouth. A simple and delicious treat for chocolate lovers.', 100.00, 1500, 'uploads/p_697d9415710c6.jpg', 0, '2026-01-31 05:33:09', 0, 0, 0),
(77, 9, 19, 'ChocoFruit Fusion', 'Rich, creamy chocolate mixed with fresh fruity flavors for a tasty and refreshing treat.', 200.00, 1500, 'uploads/p_697d9d7561ac0.jpg', 0, '2026-01-31 06:13:09', 0, 0, 0),
(78, 9, 19, 'Strawberry Flavored Chocolate', 'Smooth, creamy chocolate with a sweet strawberry taste. A perfect blend of chocolatey richness and fruity freshness.', 150.00, 1200, 'uploads/p_697da03e76322.jpg', 0, '2026-01-31 06:25:02', 0, 0, 0),
(79, 9, 20, 'Fusion dark chocolates', 'Rich dark chocolate blended with exciting flavors for a bold, smooth, and perfectly balanced taste.', 250.00, 1000, 'uploads/p_697db10d6bed8.jpg', 0, '2026-01-31 07:36:45', 0, 0, 0),
(80, 9, 20, 'Coffee Crave Choco', 'Rich, smooth chocolate infused with a strong coffee flavor for a deep, satisfying bite. Perfect for true coffee lovers.', 300.00, 1500, 'uploads/p_697db2b99a554.jpg', 0, '2026-01-31 07:43:53', 0, 0, 0),
(81, 9, 20, 'Bold Brew Chocolates', 'Intense dark chocolate with a rich coffee kick. Bold flavor, smooth bite, pure indulgence.', 100.00, 2000, 'uploads/p_697db4988ab98.jpg', 0, '2026-01-31 07:51:52', 0, 0, 0),
(82, 9, 20, 'Mocha Magic Chocolates', 'Smooth chocolate with a creamy mocha flavor that melts in your mouth. A magical blend of chocolate and coffee.', 150.00, 300, 'uploads/p_697db685525e7.jpg', 0, '2026-01-31 08:00:05', 0, 0, 0),
(83, 9, 20, 'Treats Chocolates', 'Delicious, melt-in-your-mouth chocolate perfect for any time you want a sweet, joyful bite.', 200.00, 2000, 'uploads/p_697db8f192f74.jpg', 0, '2026-01-31 08:10:25', 0, 0, 0),
(84, 9, 21, 'Nutty Bliss Chocolates', 'Smooth chocolate loaded with crunchy nuts.', 99.00, 10000, 'uploads/p_697ec74b028ff.jpg', 0, '2026-02-01 03:23:55', 0, 0, 0),
(85, 9, 21, 'Nutty Delights Chocolates', 'Smooth chocolate blended with flavorful nuts.', 190.00, 15000, 'uploads/p_697ec82e812b4.jpg', 0, '2026-02-01 03:27:42', 0, 0, 0),
(86, 9, 21, 'Hazel Choco Treats Chocolates', 'Creamy chocolate with rich hazelnut flavor.', 250.00, 5000, 'uploads/p_697ec8bc70760.jpg', 0, '2026-02-01 03:30:04', 0, 0, 0),
(87, 9, 21, 'Nutty Nirvana Chocolates', 'Luxurious chocolate loaded with premium nuts.', 900.00, 60000, 'uploads/p_697ec96c660cc.jpg', 0, '2026-02-01 03:33:00', 0, 0, 0),
(88, 9, 21, 'ChocoNut Magic Chocolates', 'Magical blend of chocolate and crunchy nuts.', 450.00, 30000, 'uploads/p_697eca2fb3b15.jpg', 0, '2026-02-01 03:36:15', 0, 0, 0),
(89, 9, 21, 'Crunchy Nut Choco', 'Perfect mix of chocolate smoothness and nut crunch.', 200.00, 10000, 'uploads/p_697ecdf05e0e5.jpg', 0, '2026-02-01 03:52:16', 0, 0, 0),
(90, 12, 22, 'Festive Bliss Chocolates', 'Sweet chocolate made to celebrate every festival.', 300.00, 4000, 'uploads/p_697ed1e5f034e.jpg', 0, '2026-02-01 04:09:10', 0, 0, 0),
(91, 12, 22, 'Diwali Delight Choco Box', 'Sweet and festive chocolates perfect for gifting.', 500.00, 30000, 'uploads/p_697ed3dba903a.jpg', 0, '2026-02-01 04:17:31', 0, 0, 0),
(92, 12, 22, 'Raksha Sweet Bites', 'Delicious chocolates to celebrate sibling love.', 699.00, 8000, 'uploads/p_697ed4dc359df.jpg', 0, '2026-02-01 04:21:48', 0, 0, 0),
(93, 12, 22, 'Bond of Love Chocolates', 'Sweet treats made for special brother-sister moments.', 1000.00, 100000, 'uploads/p_697ed5a16ab47.jpg', 0, '2026-02-01 04:25:05', 0, 0, 0),
(94, 12, 23, 'Premium Bliss Gift Box', 'Smooth, rich chocolates for premium gifting.', 1500.00, 20000, 'uploads/p_697ed7cceaa35.jpg', 0, '2026-02-01 04:34:20', 0, 0, 0),
(95, 12, 23, 'Happiness Hamper Chocolates', 'A box full of happiness, joy, and chocolates.', 80000.00, 10000, 'uploads/p_697ed98f2d430.jpg', 0, '2026-02-01 04:41:51', 0, 0, 0),
(96, 12, 23, 'Royal Chocolate Gift Box', 'Premium chocolates with a royal look and rich taste.', 1500.00, 6000, 'uploads/p_697edc2eb0cba.jpg', 0, '2026-02-01 04:53:02', 0, 0, 0),
(97, 12, 23, 'Sweet Moments Gift Box', 'A delightful collection of chocolates made to celebrate love, joy, and special moments. Perfect for gifting.', 1000.00, 2000, 'uploads/p_697edf7e983d3.jpg', 0, '2026-02-01 05:07:10', 0, 0, 0),
(98, 12, 23, 'Classic Chocolate Gift Box', 'Timeless, delicious chocolates carefully packed for gifting. Simple, elegant, and loved by everyone.', 2000.00, 6000, 'uploads/p_697ee13fc48e7.jpg', 0, '2026-02-01 05:14:39', 0, 0, 0),
(99, 12, 24, 'Corporate Delight Chocolates', 'Elegant chocolate boxes for offices and clients.', 890.00, 5000, 'uploads/p_697ee5c6dca24.jpg', 0, '2026-02-01 05:33:59', 0, 0, 0),
(100, 12, 24, 'Premium Executive Choco Box', 'Luxurious chocolates carefully selected for corporate gifting. Perfect for clients, partners, and executives.', 900.00, 1000, 'uploads/p_697ee81f7bd4b.jpg', 0, '2026-02-01 05:43:59', 0, 0, 0),
(101, 12, 24, 'Business Treats Gift Box', 'Delicious chocolates thoughtfully packed for corporate gifting. Ideal for clients, colleagues, and business celebrations.', 2000.00, 1000, 'uploads/p_697ef489d31ed.jpg', 0, '2026-02-01 06:36:57', 0, 0, 0),
(102, 12, 24, 'Custom Bliss Chocolates', 'Personalized chocolates crafted to your choice, perfect for gifting, celebrations, and special messages.', 350.00, 4000, 'uploads/p_697ef7b0a20dd.jpg', 0, '2026-02-01 06:50:24', 0, 0, 0),
(103, 12, 24, 'Luxury Corporate Treats', 'Premium, rich chocolates designed for corporate gifting. Ideal for impressing clients, partners, and executives.', 400.00, 1000, 'uploads/p_697efad6273da.jpg', 0, '2026-02-01 07:03:50', 0, 0, 0),
(104, 10, 25, 'ChocoHazel Crunch Chocolates', 'Delicious chocolate with a crunchy hazelnut twist. Smooth, nutty, and perfectly satisfying.', 150.00, 5000, 'uploads/p_697eff9fc3ecd.jpg', 0, '2026-02-01 07:24:15', 0, 0, 0),
(105, 10, 25, 'Nutty Hazel Delight', 'Creamy chocolate loaded with rich hazelnuts for a nutty, satisfying treat.', 250.00, 1000, 'uploads/p_697f00c12c6fa.jpg', 0, '2026-02-01 07:29:05', 0, 0, 0),
(106, 10, 25, 'ChocoNut Hazel Fusion Chocolates', 'A perfect blend of smooth chocolate and crunchy hazelnuts for a rich, indulgent treat.', 200.00, 2000, 'uploads/p_697f020a0b898.jpg', 0, '2026-02-01 07:34:34', 0, 0, 0),
(107, 10, 25, 'Golden Hazel Chocolates', 'Luxurious chocolate with hazelnut crunch.', 420.00, 3000, 'uploads/p_697f030272ed8.jpg', 0, '2026-02-01 07:38:09', 0, 0, 0),
(108, 11, 26, 'Pure Plant Chocolates', '100% plant-based, rich and smooth chocolate.', 230.00, 60000, 'uploads/p_697f2d8179ecd.jpg', 0, '2026-02-01 10:40:01', 0, 0, 0),
(109, 11, 26, 'Vegan Bliss Chocolates', 'Creamy vegan chocolate with pure cocoa taste.', 360.00, 8000, 'uploads/p_697f2e5427c36.jpg', 0, '2026-02-01 10:43:32', 0, 0, 0),
(110, 11, 26, 'Green Cocoa Treats', 'Naturally made chocolate with plant goodness.', 500.00, 30000, 'uploads/p_697f2f36c5fd6.jpg', 0, '2026-02-01 10:47:18', 0, 0, 0),
(111, 11, 26, 'Dairy-Free Delight', 'Smooth chocolate without milk, full of taste.', 300.00, 1000, 'uploads/p_697f307bb8fe8.jpg', 0, '2026-02-01 10:52:43', 0, 0, 0),
(112, 11, 26, 'Plant Fusion Chocolates', 'Vegan chocolate blended with natural flavors.', 599.00, 6789, 'uploads/p_697f31ae1d618.jpg', 0, '2026-02-01 10:57:50', 0, 0, 0),
(113, 11, 27, 'Keto Bliss Chocolates', 'Sugar-free chocolate with rich cocoa taste.', 200.00, 3000, 'uploads/p_697f34b157f70.jpg', 0, '2026-02-01 11:10:41', 0, 0, 0),
(114, 11, 27, 'FitBite Chocolates', 'Light, tasty chocolates for a fit lifestyle.', 400.00, 80000, 'uploads/p_697f357e06029.jpg', 0, '2026-02-01 11:14:06', 0, 0, 0),
(115, 11, 27, 'Healthy Crave Chocolates', 'Guilt-free chocolate for everyday enjoyment.', 250.00, 90000, 'uploads/p_697f3673d9fe2.jpg', 0, '2026-02-01 11:18:11', 0, 0, 0),
(116, 11, 27, 'Zero Sugar Delight', 'Sweet taste without added sugar.', 600.00, 5678, 'uploads/p_697f381e465e1.jpg', 0, '2026-02-01 11:25:18', 0, 0, 0),
(117, 11, 27, 'Smart Treat Chocolates', 'Mindful chocolate for smart eating.', 350.00, 40000, 'uploads/p_697f397463bcf.jpg', 0, '2026-02-01 11:31:00', 0, 0, 0),
(118, 11, 28, 'StrongBite Chocolates', 'Strength-focused chocolate for daily energy.', 850.00, 10000, 'uploads/p_697f3b4978e78.jpg', 0, '2026-02-01 11:38:49', 0, 0, 0),
(119, 11, 28, 'FitPower Chocolates', 'Balanced protein and energy in every bite.', 1000.00, 120000, 'uploads/p_697f3c05e8e4c.jpg', 0, '2026-02-01 11:41:57', 0, 0, 0),
(120, 11, 28, 'Active Fuel Choco', 'Made to support workouts and busy days.', 120.00, 2999, 'uploads/p_697f3d810d33b.jpg', 0, '2026-02-01 11:48:17', 0, 0, 0),
(121, 11, 28, 'Muscle Munch Choco', 'Tasty protein chocolate for active people.', 200.00, 60000, 'uploads/p_697f3e5ddd6ad.jpg', 0, '2026-02-01 11:51:57', 0, 0, 0),
(122, 11, 28, 'ProCrunch Energy Choco', 'Crunchy protein chocolate with lasting energy.', 899.00, 6789, 'uploads/p_697f3ef7c02a6.jpg', 0, '2026-02-01 11:54:31', 0, 0, 0),
(123, 8, 18, 'Classic White Delight', 'Smooth and creamy white chocolate with a rich milky taste.', 190.00, 6090, 'uploads/p_697f40c46deed.jpg', 0, '2026-02-01 12:02:12', 0, 0, 0),
(124, 8, 18, 'White Velvet Choco', 'Soft, silky white chocolate for a luxurious feel.', 175.00, 8900, 'uploads/p_697f4710a4d96.jpg', 0, '2026-02-01 12:29:04', 0, 0, 0),
(125, 8, 18, 'Pure White Chocolates', 'Simple, clean white chocolate that melts in your mouth.', 275.00, 2786, 'uploads/p_697f47f9e1d15.jpg', 0, '2026-02-01 12:32:57', 0, 0, 0),
(126, 8, 18, 'SnowWhite Chocolates', 'Light, sweet, and creamy white chocolate goodness.', 60.00, 1456, 'uploads/p_697f48bc9351f.jpg', 0, '2026-02-01 12:36:12', 0, 0, 0),
(127, 8, 18, 'Simply White Choco', 'Pure white chocolate with no extra flavors.', 90.00, 1780, 'uploads/p_697f49693f4c6.jpg', 0, '2026-02-01 12:39:05', 0, 0, 0),
(128, 8, 29, 'White Nut Bliss', 'Creamy white chocolate with crunchy nut pieces.', 250.00, 1670, 'uploads/p_697f4bfc6544a.jpg', 0, '2026-02-01 12:50:04', 0, 0, 0),
(129, 8, 29, 'Nutty White Delight', 'Smooth white chocolate loaded with rich nuts.', 180.00, 1100, 'uploads/p_697f4e68bc6d4.jpg', 0, '2026-02-01 13:00:24', 0, 0, 0),
(130, 8, 29, 'White Gold Nut Chocolates', 'Premium white chocolate with rich nuts.', 510.00, 1900, 'uploads/p_697f503f1fa20.jpg', 0, '2026-02-01 13:08:15', 0, 0, 0),
(131, 8, 29, 'Creamy Nut White Choco', 'Classic white chocolate with nutty texture.', 210.00, 7891, 'uploads/p_697f50ed7d5f1.jpg', 0, '2026-02-01 13:11:09', 0, 0, 0),
(132, 8, 30, 'Velvet White Truffles', 'Smooth, creamy white chocolate truffles for a luxurious treat.', 450.00, 1890, 'uploads/p_697f66044ed2c.jpg', 0, '2026-02-01 14:41:08', 0, 0, 0),
(133, 8, 30, 'White Bliss Truffles', 'Rich and indulgent truffles made from pure white chocolate.', 500.00, 7811, 'uploads/p_697f66e4b1d12.jpg', 0, '2026-02-01 14:44:52', 0, 0, 0),
(134, 8, 30, 'Milky White Truffles', 'Sweet, creamy white chocolate crafted into truffles.', 290.00, 1820, 'uploads/p_697f67810bc45.jpg', 0, '2026-02-01 14:47:29', 0, 0, 0),
(135, 8, 30, 'Truffle Delight White', 'Perfectly crafted white chocolate truffles for gifting or indulgence.', 600.00, 4000, 'uploads/p_697f6850ccf54.jpg', 0, '2026-02-01 14:50:56', 0, 0, 0),
(136, 5, 31, 'ChocoWafer Crunch', 'Smooth milk chocolate with a crispy wafer bite.', 200.00, 1800, 'uploads/p_697f6b65e5279.jpg', 0, '2026-02-01 15:04:05', 0, 0, 0),
(137, 5, 31, 'Wafer Bliss Chocolates', 'Perfect mix of milk chocolate and wafer crunch.', 100.00, 1500, 'uploads/p_697f6bf2419dd.jpg', 0, '2026-02-01 15:06:26', 0, 0, 0),
(138, 5, 31, 'Crispy Choco Bites', 'Delicious milk chocolate with a crispy wafer twist.', 200.00, 1289, 'uploads/p_697f6cdb20a77.jpg', 0, '2026-02-01 15:10:19', 0, 0, 0),
(139, 5, 31, 'Milk Choco Crunchies', 'Classic milk chocolate with irresistible wafer crunch.', 190.00, 5120, 'uploads/p_697f6d997a0c6.jpg', 0, '2026-02-01 15:13:29', 0, 0, 0),
(140, 13, 32, 'zeera', 'lhkh', 345.00, 2, 'uploads/p_6986e570c2035.jpg', 0, '2026-02-07 07:10:40', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`, `description`, `created_at`) VALUES
(1, 1, 'Classic Dairy Milk', 'Classic Dairy Milk is the original taste of smooth and creamy milk chocolate, crafted with rich cocoa and the goodness of fresh milk. Its timeless flavor and melt-in-the-mouth texture make it a perfect treat for every age and every occasion. Whether shared with loved ones or enjoyed alone, Classic Dairy Milk turns simple moments into sweet memories.', '2026-01-01 11:01:07'),
(2, 1, 'Dairy Milk Fruits & Nuts', 'Dairy Milk Fruits & Nuts brings together the rich creaminess of milk chocolate with the delightful crunch of premium nuts and the natural sweetness of dried fruits. Every bite offers a perfect balance of smooth chocolate and wholesome textures, making it an ideal treat for those who love both indulgence and goodness.', '2026-01-02 10:47:24'),
(4, 1, 'Dairy Milk Special Editions', 'Dairy Milk Special Editions are crafted for those who love to explore exciting flavors with the signature smoothness of Dairy Milk chocolate. Each edition offers a unique twist—combining rich textures, indulgent fillings, and premium ingredients to create unforgettable chocolate experiences.', '2026-01-02 11:38:39'),
(5, 2, 'Classic KitKat', 'Classic KitKat me crispy wafer fingers hote hain jo smooth aur rich milk chocolate se coated hote hain. Yeh perfect crunch aur chocolate taste ka balance deta hai, jo har break ko tasty aur refreshing bana deta hai.', '2026-01-02 15:10:16'),
(6, 2, 'KitKat Flavoured', '\r\nKitKat Flavoured range me crispy wafers ko alag-alag delicious flavours jaise strawberry, dark chocolate, white chocolate aur matcha ke saath coat kiya jata hai. Yeh unique flavours har bite me classic crunch ke saath naya taste experience dete hain.*\r\n', '2026-01-03 16:24:24'),
(7, 2, 'KitKat Minis & Multipack', '🍫 **KitKat Minis & Multipack**\r\n*KitKat Minis & Multipack me chhote bite-size bars aur multiple packs hote hain, jo sharing aur group enjoyment ke liye perfect hote hain. Crispy wafers aur smooth milk chocolate ka classic taste har chhoti bite me milta hai.*\r\n', '2026-01-03 17:02:02'),
(9, 4, 'Gianduja Chocolates', 'Gianduja chocolates are a signature specialty of Venchi, made with rich cocoa and Piedmont hazelnuts.\r\nThey offer a smooth, creamy texture with a perfectly balanced nutty flavor.\r\nVenchi Gianduja chocolates are crafted using traditional Italian recipes.\r\nIdeal for chocolate lovers who enjoy refined and elegant flavors.', '2026-01-25 12:33:37'),
(10, 4, 'Cremino Chocolates', 'Venchi Cremino chocolates are known for their soft, layered texture and rich creaminess.\r\nThey are made using premium cocoa and smooth hazelnut or flavored cream layers.\r\nEach Cremino offers a delicate balance of sweetness and flavor.\r\nPerfect for those who enjoy refined and elegant chocolate experiences.', '2026-01-25 15:42:11'),
(11, 4, 'Sugar-Free Chocolates', 'Venchi Sugar-Free chocolates are crafted for those who want indulgence without added sugar.\r\nThey are sweetened using natural alternatives while preserving rich cocoa flavor.\r\nMade with high-quality ingredients and traditional Italian expertise.\r\nPerfect for health-conscious chocolate lovers and diabetic-friendly diets.', '2026-01-25 16:25:38'),
(12, 5, 'Plain Milk Chocolate', 'Simple chocolate taste, no extra fillings.', '2026-01-26 10:08:24'),
(13, 5, 'Milk Chocolate with Nuts', 'Milk chocolate mixed with crunchy nuts for rich flavour & texture.', '2026-01-26 10:21:04'),
(15, 7, 'Plain Dark Chocolate', 'Rich, smooth, and slightly bitter chocolate made from premium cocoa. Perfect for chocolate lovers who enjoy intense flavor.', '2026-01-29 05:40:55'),
(16, 7, 'Dark Chocolate with Nuts', 'Rich dark chocolate blended with crunchy nuts for a delicious and satisfying treat. Perfect for snacking or gifting.', '2026-01-29 08:57:13'),
(17, 7, 'Filled Dark Chocolates', 'Rich dark chocolate with a smooth and creamy filling inside. Perfect for those who love a surprise in every bite.', '2026-01-29 09:43:02'),
(18, 8, 'Plain White Chocolate', 'Smooth, creamy white chocolate with a rich and sweet taste. Perfect for those who love classic chocolate.', '2026-01-29 11:52:42'),
(19, 9, 'Fruit Flavored Chocolates', 'Delicious chocolates infused with fruity flavors for a sweet and refreshing taste. Perfect for fun snacking and gifting.', '2026-01-30 04:55:41'),
(20, 9, 'Coffee Chocolates', 'Rich chocolate infused with bold coffee flavor for a smooth, energizing treat. Perfect for coffee lovers.', '2026-01-31 07:33:36'),
(21, 9, 'Nut Flavored Chocolates', 'Creamy chocolate packed with crunchy, flavorful nuts for a deliciously satisfying treat.', '2026-01-31 08:18:52'),
(22, 12, 'Festival Chocolates', 'Delicious chocolates specially made for celebrations and gifting. Sweet, rich, and perfect for sharing happiness during festivals.', '2026-02-01 03:56:32'),
(23, 12, 'Chocolate Gift Boxes', 'Beautifully packed chocolates made for gifting on festivals and special occasions. A sweet way to share happiness.', '2026-02-01 04:28:46'),
(24, 12, 'Corporate & Custom Chocolate Gift', 'Premium chocolates specially packed for corporate gifting and personal customization. Perfect for clients, employees, and special occasions.', '2026-02-01 05:29:05'),
(25, 10, 'Hazelnut Chocolates', 'Smooth, creamy chocolate loaded with crunchy, flavorful hazelnuts. A perfect nutty treat for chocolate lovers.', '2026-02-01 07:11:15'),
(26, 11, 'Vegan Chocolates', 'Delicious dairy-free chocolates made from plant-based ingredients. Rich in cocoa taste and perfect for guilt-free indulgence.', '2026-02-01 10:36:26'),
(27, 11, 'Keto & Low Calorie Chocolates', 'Sugar-free, low-carb chocolates made for a healthy lifestyle. Rich taste with fewer calories, perfect for guilt-free treats.', '2026-02-01 11:02:09'),
(28, 11, 'Protein & Energy Chocolates', 'Power-packed chocolates enriched with protein and energy boosters. Perfect for workouts, busy days, and active lifestyles.', '2026-02-01 11:33:56'),
(29, 8, 'White Chocolate with Nuts', 'Creamy white chocolate blended with crunchy nuts for a rich, smooth, and satisfying treat.', '2026-02-01 12:46:09'),
(30, 8, 'White Chocolate Truffles', 'Rich and creamy white chocolate shaped into smooth truffles. A luxurious, melt-in-your-mouth treat.', '2026-02-01 13:14:18'),
(31, 5, 'Milk Chocolate with Wafer  ', 'Smooth milk chocolate layered over crispy wafer for a crunchy, melt-in-your-mouth treat.', '2026-02-01 14:59:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `user_type` enum('admin','delivery','customer') DEFAULT 'delivery',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `user_type`, `status`, `created_at`, `updated_at`, `role`) VALUES
(1, 'John Delivery', 'delivery@chocodelight.com', '$2y$10$JR2fMHH1JkYQ0/0oA6Qzx.EyCVrMah2dS55OsnwMXrV1SvKiRmRYK', '+91-9876543210', 'delivery', 'active', '2026-01-07 04:45:02', '2026-01-13 13:12:45', 'user'),
(7, 'Pari', 'pari123@gmail.com', '$2y$10$/VkgLRxj9w9jfyZWUSLkhOkjEkx2v6XzlpraW7lC9xHRwijYh3ZgO', '6434937493749', 'delivery', 'active', '2026-01-21 10:02:16', '2026-01-21 10:02:16', 'delivery'),
(8, 'Nisha', 'nisha123@gmail.com', '$2y$10$F0NY6TOzBLhYLH4xMvYWz./8bXP8DC/CmiiWFor0Yhz5izsA71V66', '6434937493749', 'delivery', 'active', '2026-01-21 11:00:40', '2026-01-21 11:00:40', 'delivery');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_person`
--
ALTER TABLE `delivery_person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `delivery_person_id` (`delivery_person_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `delivery_person`
--
ALTER TABLE `delivery_person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_delivery_person` FOREIGN KEY (`delivery_person_id`) REFERENCES `delivery_person` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`delivery_person_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payment_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
