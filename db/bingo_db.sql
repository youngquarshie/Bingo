-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2021 at 10:53 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bingo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `vat_charge_value` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `currency` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `vat_charge_value`, `address`, `phone`, `country`, `message`, `currency`) VALUES
(1, 'Anifax Enterprise', '0', 'Community 7', '', 'Ghana', 'hello everyone one', 'GHS');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expenses_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `amount` decimal(13,2) NOT NULL,
  `expense_date` varchar(25) NOT NULL,
  `expense_time` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expenses_id`, `user_id`, `purpose`, `amount`, `expense_date`, `expense_time`) VALUES
(3, 6, 'TNT', '20.00', '1625616000', '1625748839'),
(4, 6, 'TNT', '25.00', '1625443200', '1625748839');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name_of_game` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `name_of_game`) VALUES
(4, 'MONDAY SPECIAL (M/S)'),
(5, 'LUCKY TUESDAY (LT)'),
(6, 'MIDWEEK (M/W)'),
(7, 'FORTUNE THURSDAY (FT)'),
(8, 'FRIDAY BONANZA (FB)'),
(9, 'NATIONAL (NAT)');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `permission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `permission`) VALUES
(1, 'Administrator', 'a:36:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:11:\"createBrand\";i:9;s:11:\"updateBrand\";i:10;s:9:\"viewBrand\";i:11;s:11:\"deleteBrand\";i:12;s:14:\"createCategory\";i:13;s:14:\"updateCategory\";i:14;s:12:\"viewCategory\";i:15;s:14:\"deleteCategory\";i:16;s:11:\"createStore\";i:17;s:11:\"updateStore\";i:18;s:9:\"viewStore\";i:19;s:11:\"deleteStore\";i:20;s:15:\"createAttribute\";i:21;s:15:\"updateAttribute\";i:22;s:13:\"viewAttribute\";i:23;s:15:\"deleteAttribute\";i:24;s:13:\"createProduct\";i:25;s:13:\"updateProduct\";i:26;s:11:\"viewProduct\";i:27;s:13:\"deleteProduct\";i:28;s:11:\"createOrder\";i:29;s:11:\"updateOrder\";i:30;s:9:\"viewOrder\";i:31;s:11:\"deleteOrder\";i:32;s:11:\"viewReports\";i:33;s:13:\"updateCompany\";i:34;s:11:\"viewProfile\";i:35;s:13:\"updateSetting\";}'),
(4, 'Cashier', 'a:8:{i:0;s:11:\"viewProduct\";i:1;s:11:\"createOrder\";i:2;s:9:\"viewOrder\";i:3;s:13:\"createProfile\";i:4;s:13:\"updateProfile\";i:5;s:11:\"viewProfile\";i:6;s:13:\"deleteProfile\";i:7;s:13:\"updateSetting\";}'),
(5, 'Manager', 'a:23:{i:0;s:11:\"createBrand\";i:1;s:11:\"updateBrand\";i:2;s:9:\"viewBrand\";i:3;s:11:\"deleteBrand\";i:4;s:14:\"createCategory\";i:5;s:14:\"updateCategory\";i:6;s:12:\"viewCategory\";i:7;s:14:\"deleteCategory\";i:8;s:15:\"createAttribute\";i:9;s:15:\"updateAttribute\";i:10;s:13:\"viewAttribute\";i:11;s:15:\"deleteAttribute\";i:12;s:13:\"createProduct\";i:13;s:13:\"updateProduct\";i:14;s:11:\"viewProduct\";i:15;s:11:\"createOrder\";i:16;s:11:\"updateOrder\";i:17;s:9:\"viewOrder\";i:18;s:11:\"deleteOrder\";i:19;s:11:\"viewReports\";i:20;s:13:\"updateCompany\";i:21;s:11:\"viewProfile\";i:22;s:13:\"updateSetting\";}'),
(6, 'New Admin', 'a:47:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:14:\"createExpenses\";i:9;s:14:\"updateExpenses\";i:10;s:12:\"viewExpenses\";i:11;s:14:\"deleteExpenses\";i:12;s:14:\"createCategory\";i:13;s:14:\"updateCategory\";i:14;s:12:\"viewCategory\";i:15;s:14:\"deleteCategory\";i:16;s:14:\"createSupplier\";i:17;s:14:\"updateSupplier\";i:18;s:12:\"viewSupplier\";i:19;s:14:\"deleteSupplier\";i:20;s:13:\"createProduct\";i:21;s:13:\"updateProduct\";i:22;s:11:\"viewProduct\";i:23;s:13:\"deleteProduct\";i:24;s:15:\"updateStockLogs\";i:25;s:13:\"viewStockLogs\";i:26;s:11:\"createOrder\";i:27;s:11:\"updateOrder\";i:28;s:9:\"viewOrder\";i:29;s:11:\"deleteOrder\";i:30;s:13:\"createReports\";i:31;s:13:\"updateReports\";i:32;s:11:\"viewReports\";i:33;s:13:\"deleteReports\";i:34;s:17:\"viewProductReport\";i:35;s:13:\"createCompany\";i:36;s:13:\"updateCompany\";i:37;s:11:\"viewCompany\";i:38;s:13:\"deleteCompany\";i:39;s:13:\"createProfile\";i:40;s:13:\"updateProfile\";i:41;s:11:\"viewProfile\";i:42;s:13:\"deleteProfile\";i:43;s:13:\"createSetting\";i:44;s:13:\"updateSetting\";i:45;s:11:\"viewSetting\";i:46;s:13:\"deleteSetting\";}');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `r_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_added` varchar(255) NOT NULL,
  `time_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`r_id`, `game_id`, `user_id`, `date_added`, `time_added`) VALUES
(56, 4, 6, '1625443200', '1625748839'),
(57, 5, 6, '1625529600', '1625748966'),
(58, 6, 6, '1625616000', '1625748992'),
(60, 7, 6, '1625702400', '1625758711'),
(64, 8, 6, '1625788800', '1625846892');

-- --------------------------------------------------------

--
-- Table structure for table `records_item`
--

CREATE TABLE `records_item` (
  `id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `winning_draw` varchar(50) NOT NULL,
  `gross_amount` decimal(13,2) NOT NULL,
  `net_amount` decimal(13,2) NOT NULL,
  `no_of_books` int(11) NOT NULL,
  `no_of_wins` int(11) NOT NULL,
  `total_wins` decimal(13,2) NOT NULL,
  `unit` int(11) NOT NULL,
  `total_balance` decimal(13,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `records_item`
--

INSERT INTO `records_item` (`id`, `record_id`, `winning_draw`, `gross_amount`, `net_amount`, `no_of_books`, `no_of_wins`, `total_wins`, `unit`, `total_balance`) VALUES
(88, 56, '25-6-8-7-10', '2500.00', '1000.00', 25, 10, '2400.00', 240, '-1400.00'),
(89, 57, '25-5-4-10', '40000.00', '16000.00', 50, 25, '6000.00', 240, '10000.00'),
(90, 58, '1-2-5-4', '50000.00', '20000.00', 20, 14, '3360.00', 240, '16640.00'),
(92, 60, '2-58-6-2-9', '50000.00', '20000.00', 10, 12, '2880.00', 240, '17120.00'),
(96, 64, '6-9-54-76', '76505.00', '30602.00', 15, 25070, '6016800.00', 240, '-5986198.00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `supplier_address` varchar(100) NOT NULL,
  `supplier_contact` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `supplier_address`, `supplier_contact`) VALUES
(3, 'Dan Botwe1', 'Mile 7 Police Station', '0572301169'),
(5, 'quarshie', 'asddsada', '544444');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `unit_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_value`) VALUES
(4, 240),
(5, 230);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `firstname`, `lastname`, `phone`, `gender`) VALUES
(1, 'admin', '$2y$10$yfi5nUQGXUZtMdl27dWAyOd/jMOmATBpiUvJDmUu9hJ5Ro6BE5wsK', 'admin@admin.com', 'john', 'doe', '80789998', 1),
(6, 'king00', '$2y$10$aXhlydUZTFp.ZRRxuK6US.7JVZV0WpsVLxHxZ4ra.3IBSfO5unaF.', 'admin@gmail.com', 'Kingsley', 'Anie', '54455', 1),
(7, 'cashier', '$2y$10$OUrnMFzEdL2fsdLph/7Y4OLqMb1vYUHL0kxl8Qo7mHu5ZrBNzu.cq', 'cashier@gmail.com', 'cashier', 'lady', '02565411255', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(7, 6, 6),
(8, 7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `weekly_reports`
--

CREATE TABLE `weekly_reports` (
  `id` int(11) NOT NULL,
  `gross_amount` decimal(13,2) NOT NULL,
  `net_amount` decimal(13,2) NOT NULL,
  `no_of_books` int(11) NOT NULL,
  `total_wins` decimal(13,2) NOT NULL,
  `total_balance` decimal(13,2) NOT NULL,
  `actual_total_balance` decimal(13,2) DEFAULT NULL,
  `expenses` decimal(13,2) DEFAULT NULL,
  `date_generated` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expenses_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `records_item`
--
ALTER TABLE `records_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weekly_reports`
--
ALTER TABLE `weekly_reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expenses_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `records_item`
--
ALTER TABLE `records_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `weekly_reports`
--
ALTER TABLE `weekly_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
