-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 20, 2018 at 11:47 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `osmalldb1`
--

-- --------------------------------------------------------

--
-- Table structure for table `sysmodule`
--

CREATE TABLE `sysmodule` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL,
  `sysname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sysmodule`
--

INSERT INTO `sysmodule` (`id`, `parent_id`, `sysname`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'report', 'Report', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'ageing', 'Ageing', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 'statement', 'Statement', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 1, 'reconline', 'Receipt Issued(Online)', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 1, 'recopossum', 'Receipt Issued(Opossum)', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 1, 'treport', 'Tracking Report', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 1, 'salesmemo', 'Sales Memo', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 1, 'sstreport', 'SST Report', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 1, 'purorder', 'Purchase Order', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 1, 'invoice', 'Invoice Received', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 1, 'purorderi', 'Purchase Order Issued', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 1, 'crednoterec', 'Credit Note Received', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 1, 'debnoterec', 'Debit Note Issued', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 1, 'debnoteiss', 'Debit Note Issued', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 1, 'delordiss', 'Delivery Order Issued', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 1, 'delordrec', 'Delivery Order Received', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 1, 'saleslog', 'Sales Log', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 1, 'salordgat', 'Sales Order Gator', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 1, 'invissgat', 'Invoice Issued Gator', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 1, 'wastage', 'Wastage Form', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 21, 'system', 'System', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 21, 'jaguar', 'Jaguar', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 21, 'gator', 'Gator', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 21, 'opossum', 'OPPossum', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 21, 'arapaima', 'Arapaima', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 21, 'logistics', 'Logistics', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 21, 'warehouse', 'Warehouse', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 21, 'raw', 'RaW', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 21, 'humancap', 'HumanCap', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 21, 'wallet', 'Wallet', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 21, 'beluga', 'Beluga', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 32, 'inventory', 'Inventory', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 33, 'oshop', 'O-Shop', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 34, 'analytics', 'Analytics', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 35, 'data', 'Data', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 35, 'custlist', 'Customer List', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 35, 'stafflist', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 35, 'dealertab', 'Dealer Tab', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 35, 'suppllist', 'Supplier List', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 35, 'autolink', 'Autolink', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 41, 'specialoffer', 'Special Offer', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sysmodule`
--
ALTER TABLE `sysmodule`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sysmodule`
--
ALTER TABLE `sysmodule`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
