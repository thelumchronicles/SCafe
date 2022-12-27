-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 18, 2021 lúc 05:21 AM
-- Phiên bản máy phục vụ: 10.4.19-MariaDB
-- Phiên bản PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `scafe`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `atable`
--

CREATE TABLE `atable` (
  `atable_id` int(11) NOT NULL,
  `atable_name` varchar(255) NOT NULL,
  `room_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `atable`
--

INSERT INTO `atable` (`atable_id`, `atable_name`, `room_id`, `invoice_id`, `status`) VALUES
(3, 'Bàn 1 - Lầu 1', 1, NULL, 0),
(4, 'Bàn 2 - Lầu 1', 1, 112, 1),
(5, 'Bàn 1 - Lầu 2', 2, 115, 1),
(6, 'Bàn 2 - Lầu 2', 2, 116, 1),
(7, 'Bàn Cho Khách VIP', 2, 117, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount`
--

CREATE TABLE `discount` (
  `discount_id` int(11) NOT NULL,
  `discount_code` varchar(255) NOT NULL,
  `discount_percent` int(5) NOT NULL,
  `discount_des` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `discount`
--

INSERT INTO `discount` (`discount_id`, `discount_code`, `discount_percent`, `discount_des`) VALUES
(1, 'THUNGHIEM1', 15, 'Mã giảm thử nghiệm'),
(2, 'MAGIAM2', 10, 'Mã giảm 2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `discount_id` int(11) DEFAULT NULL,
  `discount_code` varchar(255) DEFAULT NULL,
  `discount_percent` int(11) DEFAULT NULL,
  `discount_price` int(11) DEFAULT NULL,
  `total_price` int(255) NOT NULL,
  `final_price` int(255) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `table_id`, `discount_id`, `discount_code`, `discount_percent`, `discount_price`, `total_price`, `final_price`, `time_stamp`, `status`) VALUES
(1, 3, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-19 00:41:28', 1),
(2, 3, NULL, NULL, NULL, 0, 18000, 18000, '2021-05-19 00:42:01', 2),
(3, 4, NULL, NULL, NULL, NULL, 0, 0, '2021-05-19 00:41:36', 2),
(4, 4, NULL, NULL, NULL, 0, 18000, 18000, '2021-05-19 00:50:22', 1),
(5, 4, NULL, NULL, NULL, 0, 8000, 8000, '2021-05-19 00:51:10', 1),
(6, 5, NULL, NULL, NULL, NULL, 0, 0, '2021-05-19 00:56:49', 2),
(7, 4, NULL, NULL, NULL, 0, 29000, 29000, '2021-05-19 00:56:47', 2),
(8, 3, NULL, NULL, NULL, 0, 20000, 20000, '2021-05-19 00:57:00', 1),
(9, 3, NULL, NULL, NULL, 0, 0, 0, '2021-05-19 01:01:22', 2),
(10, 3, 1, 'THUNGHIEM1', 15, 5100, 34000, 28900, '2021-05-19 01:02:10', 1),
(11, 3, NULL, NULL, NULL, 0, 18000, 18000, '2021-05-19 01:02:01', 1),
(12, 3, 1, 'THUNGHIEM1', 15, 4500, 30000, 25500, '2021-05-19 16:02:28', 1),
(13, 4, 1, 'THUNGHIEM1', 15, 9000, 60000, 51000, '2021-05-19 16:06:07', 2),
(14, 3, NULL, NULL, NULL, 0, 18000, 18000, '2021-05-22 04:11:52', 2),
(15, 5, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 21:49:36', 1),
(16, 4, 2, 'MAGIAM2', 10, 12200, 122000, 109800, '2021-05-28 00:07:09', 2),
(17, 6, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 00:07:11', 2),
(18, 7, 1, 'THUNGHIEM1', 15, 0, 0, 0, '2021-05-27 23:35:42', 2),
(19, 3, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-22 04:12:35', 2),
(20, 3, NULL, NULL, NULL, 0, 20000, 20000, '2021-05-22 04:15:32', 1),
(21, 3, NULL, NULL, NULL, 0, 20000, 20000, '2021-05-22 04:17:38', 2),
(22, 3, NULL, NULL, NULL, 0, 26000, 26000, '2021-05-22 04:27:33', 1),
(23, 3, NULL, NULL, NULL, 0, 18000, 18000, '2021-05-22 17:14:50', 1),
(24, 3, 2, 'MAGIAM2', 10, 0, 0, 0, '2021-05-27 22:00:57', 0),
(25, 3, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 22:12:17', 0),
(26, 5, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 22:13:17', 1),
(27, 3, NULL, NULL, NULL, 0, 118000, 118000, '2021-05-28 00:05:42', 2),
(28, 5, 2, 'MAGIAM2', 10, 0, 0, 0, '2021-05-27 23:02:39', 2),
(29, 5, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 23:43:20', 2),
(30, 7, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 23:35:45', 0),
(31, 7, NULL, NULL, NULL, 0, 20000, 20000, '2021-05-27 23:38:11', 2),
(32, 7, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 23:40:05', 0),
(33, 7, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 23:40:07', 0),
(34, 7, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 23:40:13', 0),
(35, 7, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 23:40:20', 0),
(36, 7, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 23:40:56', 0),
(37, 7, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 23:41:22', 2),
(38, 7, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 23:41:43', 0),
(39, 7, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-27 23:52:41', 2),
(40, 5, 1, 'THUNGHIEM1', 15, 3000, 20000, 17000, '2021-05-27 23:44:09', 0),
(41, 5, 1, 'THUNGHIEM1', 15, 9900, 66000, 56100, '2021-05-28 00:06:17', 2),
(42, 7, NULL, NULL, NULL, 0, 54000, 54000, '2021-05-27 23:53:06', 2),
(43, 7, NULL, NULL, NULL, NULL, 0, 0, '2021-05-27 23:53:08', 0),
(44, 7, 1, 'THUNGHIEM1', 15, 9000, 60000, 51000, '2021-05-27 23:54:08', 2),
(45, 7, 2, 'MAGIAM2', 10, 4000, 40000, 36000, '2021-05-28 00:06:14', 2),
(46, 3, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-28 00:07:07', 2),
(47, 7, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-28 00:06:29', 2),
(48, 7, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 00:07:16', 2),
(49, 5, 2, 'MAGIAM2', 10, 5600, 56000, 50400, '2021-05-28 00:07:06', 2),
(50, 3, 2, 'MAGIAM2', 10, 14700, 147000, 132300, '2021-05-28 05:03:10', 1),
(51, 4, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 00:21:58', 2),
(52, 5, NULL, NULL, NULL, 0, 78000, 78000, '2021-05-28 00:22:32', 2),
(53, 4, 2, 'MAGIAM2', 10, 5400, 54000, 48600, '2021-05-28 02:32:50', 2),
(54, 4, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 05:08:09', 1),
(55, 5, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 05:05:14', 1),
(56, 3, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 05:08:28', 1),
(57, 3, 1, 'THUNGHIEM1', 15, 0, 0, 0, '2021-05-28 05:09:25', 1),
(58, 3, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 05:11:06', 1),
(59, 3, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 05:11:29', 1),
(60, 3, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 05:15:10', 1),
(61, 3, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 05:15:43', 1),
(62, 3, 2, 'MAGIAM2', 10, 4600, 46000, 41400, '2021-05-28 05:16:24', 1),
(63, 3, 2, 'MAGIAM2', 10, 5400, 54000, 48600, '2021-05-28 05:17:38', 1),
(64, 4, 2, 'MAGIAM2', 10, 2800, 28000, 25200, '2021-05-28 05:18:13', 1),
(65, 3, NULL, NULL, NULL, 0, 72000, 72000, '2021-05-28 05:20:30', 1),
(66, 3, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-28 05:21:36', 1),
(67, 7, 1, 'THUNGHIEM1', 15, 4200, 28000, 23800, '2021-05-28 05:22:22', 1),
(68, 3, 2, 'MAGIAM2', 10, 2800, 28000, 25200, '2021-05-28 05:24:39', 1),
(69, 3, 1, 'THUNGHIEM1', 15, 8700, 58000, 49300, '2021-05-28 05:25:31', 1),
(70, 5, 2, 'MAGIAM2', 10, 2800, 28000, 25200, '2021-05-28 05:25:57', 1),
(71, 3, 1, 'THUNGHIEM1', 15, 4200, 28000, 23800, '2021-05-28 05:26:35', 1),
(72, 4, NULL, NULL, NULL, 0, 42000, 42000, '2021-05-28 05:56:23', 1),
(73, 3, 2, 'MAGIAM2', 10, 2800, 28000, 25200, '2021-05-28 05:27:57', 1),
(74, 5, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-28 06:39:26', 2),
(75, 3, NULL, NULL, NULL, 0, 40000, 40000, '2021-05-28 05:56:06', 1),
(76, 6, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 05:44:39', 0),
(77, 6, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 06:39:28', 2),
(78, 7, 2, 'MAGIAM2', 10, 2000, 20000, 18000, '2021-05-28 06:21:57', 1),
(79, 3, NULL, NULL, NULL, 0, 26000, 26000, '2021-05-28 06:18:47', 1),
(80, 4, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 06:39:24', 2),
(81, 3, 2, 'MAGIAM2', 10, 6000, 60000, 54000, '2021-05-28 06:21:18', 1),
(82, 3, 2, 'MAGIAM2', 10, 2800, 28000, 25200, '2021-05-28 06:36:12', 1),
(83, 3, 2, 'MAGIAM2', 10, 2800, 28000, 25200, '2021-05-28 06:38:47', 1),
(84, 3, NULL, NULL, NULL, 0, 43000, 43000, '2021-05-28 06:57:56', 1),
(85, 4, NULL, NULL, NULL, 0, 20000, 20000, '2021-05-28 07:03:29', 1),
(86, 3, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-28 06:59:52', 1),
(87, 3, 2, 'MAGIAM2', 10, 2800, 28000, 25200, '2021-05-28 07:02:47', 1),
(88, 3, 1, 'THUNGHIEM1', 15, 13200, 88000, 74800, '2021-05-28 07:03:21', 1),
(89, 3, 1, 'THUNGHIEM1', 15, 16500, 110000, 93500, '2021-05-28 07:06:33', 2),
(90, 4, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-28 07:04:37', 2),
(91, 4, NULL, NULL, NULL, 0, 76000, 76000, '2021-05-28 07:06:29', 2),
(92, 3, 2, 'MAGIAM2', 10, 5800, 58000, 52200, '2021-05-28 07:12:27', 2),
(93, 4, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-28 07:07:02', 1),
(94, 4, 1, 'THUNGHIEM1', 15, 5700, 38000, 32300, '2021-05-28 07:12:29', 2),
(95, 3, 1, 'THUNGHIEM1', 15, 9150, 61000, 51850, '2021-05-28 07:13:54', 2),
(96, 3, NULL, NULL, NULL, 0, 100000, 100000, '2021-05-28 07:18:15', 2),
(97, 4, NULL, NULL, NULL, 0, 20000, 20000, '2021-05-28 07:14:36', 2),
(98, 4, NULL, NULL, NULL, 0, 20000, 20000, '2021-05-28 07:14:44', 1),
(99, 4, NULL, NULL, NULL, NULL, 0, 0, '2021-05-28 07:18:17', 2),
(100, 3, NULL, NULL, NULL, 0, 34000, 34000, '2021-05-28 07:20:19', 2),
(101, 4, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-28 07:18:54', 1),
(102, 4, NULL, NULL, NULL, 0, 39000, 39000, '2021-05-28 07:20:21', 2),
(103, 3, NULL, NULL, NULL, 0, 38000, 38000, '2021-05-28 07:22:27', 2),
(104, 4, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-28 07:20:57', 1),
(105, 4, NULL, NULL, NULL, 0, 28000, 28000, '2021-05-28 07:22:29', 2),
(106, 3, NULL, NULL, NULL, 0, 60000, 60000, '2021-05-28 18:16:21', 1),
(107, 4, 1, 'THUNGHIEM1', 15, 4200, 28000, 23800, '2021-05-28 07:23:21', 1),
(108, 3, NULL, NULL, NULL, 0, 58000, 58000, '2021-05-28 20:17:49', 1),
(109, 3, 2, 'MAGIAM2', 10, 4600, 46000, 41400, '2021-05-28 20:18:51', 1),
(110, 3, NULL, NULL, NULL, 0, 10000, 10000, '2021-05-29 14:43:52', 1),
(111, 3, 1, 'THUNGHIEM1', 15, 10500, 70000, 59500, '2021-05-29 18:37:25', 1),
(112, 4, 1, 'THUNGHIEM1', 15, 11100, 74000, 62900, '2021-06-05 15:48:47', 0),
(113, 3, NULL, NULL, NULL, NULL, 0, 0, '2021-05-29 18:37:49', 2),
(114, 3, 2, 'MAGIAM2', 10, 5800, 58000, 52200, '2021-05-30 23:39:50', 2),
(115, 5, NULL, NULL, NULL, NULL, 0, 0, '2021-05-29 18:51:15', 0),
(116, 6, NULL, NULL, NULL, NULL, 0, 0, '2021-05-30 23:21:17', 0),
(117, 7, NULL, NULL, NULL, NULL, 0, 0, '2021-05-30 23:25:03', 0),
(118, 3, NULL, NULL, NULL, NULL, 0, 0, '2021-05-30 23:40:10', 2),
(119, 3, 2, 'MAGIAM2', 10, 2900, 29000, 26100, '2021-05-30 23:50:25', 1),
(120, 3, NULL, NULL, NULL, NULL, 0, 0, '2021-06-04 20:53:43', 2),
(121, 3, 1, 'THUNGHIEM1', 15, 5700, 38000, 32300, '2021-06-04 20:54:08', 1),
(122, 3, 1, 'THUNGHIEM1', 15, 6900, 46000, 39100, '2021-06-05 15:32:26', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoice_sep`
--

CREATE TABLE `invoice_sep` (
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_price` int(255) NOT NULL,
  `total_price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `invoice_sep`
--

INSERT INTO `invoice_sep` (`invoice_id`, `product_id`, `quantity`, `product_price`, `total_price`) VALUES
(1, 1, 1, 10000, 10000),
(1, 2, 1, 10000, 10000),
(1, 4, 1, 8000, 8000),
(4, 2, 1, 10000, 10000),
(4, 4, 1, 8000, 8000),
(5, 4, 1, 8000, 8000),
(8, 1, 1, 10000, 10000),
(8, 2, 1, 10000, 10000),
(10, 2, 1, 10000, 10000),
(10, 5, 2, 12000, 24000),
(11, 4, 1, 8000, 8000),
(11, 2, 1, 10000, 10000),
(12, 5, 1, 12000, 12000),
(12, 4, 1, 8000, 8000),
(12, 2, 1, 10000, 10000),
(20, 1, 1, 10000, 10000),
(20, 2, 1, 10000, 10000),
(22, 2, 1, 10000, 10000),
(22, 4, 2, 8000, 16000),
(23, 2, 1, 10000, 10000),
(23, 4, 1, 8000, 8000),
(0, 1, 4, 10000, 40000),
(0, 2, 3, 10000, 30000),
(0, 4, 0, 8000, 8000),
(0, 5, 0, 12000, 12000),
(0, 6, 0, 11000, 11000),
(31, 1, 1, 10000, 10000),
(31, 2, 1, 10000, 10000),
(40, 1, 1, 10000, 10000),
(40, 2, 1, 10000, 10000),
(50, 1, 4, 10000, 40000),
(50, 2, 3, 10000, 10000),
(50, 4, 1, 8000, 8000),
(50, 5, 3, 12000, 12000),
(50, 6, 3, 11000, 11000),
(62, 1, 1, 10000, 10000),
(62, 2, 2, 10000, 10000),
(62, 4, 2, 8000, 8000),
(63, 1, 2, 10000, 10000),
(63, 2, 1, 10000, 10000),
(63, 4, 3, 8000, 8000),
(64, 1, 1, 10000, 10000),
(64, 2, 1, 10000, 10000),
(64, 4, 1, 8000, 8000),
(65, 1, 1, 10000, 10000),
(65, 2, 1, 10000, 10000),
(65, 4, 4, 8000, 8000),
(65, 7, 1, 20000, 20000),
(66, 1, 1, 10000, 10000),
(66, 2, 1, 10000, 10000),
(66, 4, 1, 8000, 8000),
(67, 1, 1, 10000, 10000),
(67, 2, 1, 10000, 10000),
(67, 4, 1, 8000, 8000),
(68, 1, 1, 10000, 10000),
(68, 2, 1, 10000, 10000),
(68, 4, 1, 8000, 8000),
(69, 1, 1, 10000, 10000),
(69, 2, 4, 10000, 10000),
(69, 4, 1, 8000, 8000),
(70, 1, 1, 10000, 10000),
(70, 2, 1, 10000, 10000),
(70, 4, 1, 8000, 8000),
(71, 1, 1, 10000, 10000),
(71, 2, 1, 10000, 10000),
(71, 4, 1, 8000, 8000),
(72, 6, 2, 11000, 11000),
(72, 7, 1, 20000, 20000),
(73, 1, 1, 10000, 10000),
(73, 2, 1, 10000, 10000),
(73, 4, 1, 8000, 8000),
(75, 1, 2, 10000, 20000),
(75, 2, 2, 10000, 20000),
(78, 1, 1, 10000, 10000),
(78, 2, 1, 10000, 10000),
(79, 1, 1, 10000, 10000),
(79, 4, 2, 8000, 16000),
(81, 1, 1, 10000, 10000),
(81, 2, 1, 10000, 10000),
(81, 4, 2, 8000, 16000),
(81, 5, 2, 12000, 24000),
(82, 1, 1, 10000, 10000),
(82, 2, 1, 10000, 10000),
(82, 4, 1, 8000, 8000),
(83, 1, 1, 10000, 10000),
(83, 2, 1, 10000, 10000),
(83, 4, 1, 8000, 8000),
(84, 5, 1, 12000, 12000),
(84, 6, 1, 11000, 11000),
(84, 1, 1, 10000, 10000),
(84, 2, 1, 10000, 10000),
(85, 1, 1, 10000, 10000),
(85, 2, 1, 10000, 10000),
(86, 1, 1, 10000, 10000),
(86, 2, 1, 10000, 10000),
(86, 4, 1, 8000, 8000),
(87, 1, 1, 10000, 10000),
(87, 2, 1, 10000, 10000),
(87, 4, 1, 8000, 8000),
(88, 1, 1, 10000, 10000),
(88, 2, 1, 10000, 10000),
(88, 4, 1, 8000, 8000),
(88, 7, 3, 20000, 20000),
(93, 1, 1, 10000, 10000),
(93, 2, 1, 10000, 10000),
(93, 4, 1, 8000, 8000),
(98, 1, 1, 10000, 10000),
(98, 2, 1, 10000, 10000),
(101, 1, 1, 10000, 10000),
(101, 2, 1, 10000, 10000),
(101, 4, 1, 8000, 8000),
(104, 1, 1, 10000, 10000),
(104, 2, 1, 10000, 10000),
(104, 4, 1, 8000, 8000),
(106, 2, 3, 10000, 30000),
(106, 1, 1, 10000, 10000),
(106, 5, 1, 12000, 12000),
(107, 1, 1, 10000, 10000),
(107, 2, 1, 10000, 10000),
(107, 4, 1, 8000, 8000),
(106, 4, 1, 8000, 8000),
(108, 1, 2, 10000, 20000),
(108, 2, 3, 10000, 30000),
(108, 4, 1, 8000, 8000),
(109, 1, 2, 10000, 20000),
(109, 2, 1, 10000, 10000),
(109, 4, 2, 8000, 16000),
(110, 2, 1, 10000, 10000),
(112, 1, 1, 10000, 10000),
(112, 2, 4, 10000, 40000),
(112, 4, 3, 8000, 8000),
(111, 6, 2, 11000, 22000),
(111, 1, 3, 10000, 10000),
(111, 2, 1, 10000, 10000),
(111, 4, 1, 8000, 8000),
(119, 2, 1, 10000, 10000),
(119, 4, 1, 8000, 8000),
(119, 6, 1, 11000, 11000),
(121, 1, 1, 10000, 10000),
(121, 2, 2, 10000, 20000),
(121, 4, 1, 8000, 8000),
(122, 1, 2, 10000, 10000),
(122, 2, 1, 10000, 10000),
(122, 4, 2, 8000, 16000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`category_id`, `product_id`, `product_name`, `product_image`, `product_price`) VALUES
(1, 1, 'Coca', '/images/product/1621384366.jpg', 10000),
(1, 2, 'Pepsi', '/images/product/1621384417.jpg', 10000),
(1, 4, 'Bí đao', '/images/product/1621384454.jpg', 8000),
(2, 5, 'Cà phê truyền thống', '/images/product/1621384702.jpg', 12000),
(2, 6, 'Cà phê pha máy', '/images/product/1621384724.jpg', 11000),
(2, 7, 'Ice Blend', '/images/product/1621384757.jpg', 20000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_category`
--

CREATE TABLE `product_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `product_category`
--

INSERT INTO `product_category` (`category_id`, `category_name`) VALUES
(1, 'Giải khát'),
(2, 'Cafe'),
(3, 'Test Category');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `room`
--

INSERT INTO `room` (`room_id`, `room_name`) VALUES
(1, 'Lầu 1'),
(2, 'Lầu 2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_gender` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `user_fullname`, `user_image`, `user_gender`, `user_name`, `user_password`, `user_permission`) VALUES
(1, 'Phan Văn Quốc Tuấn', NULL, 0, 'phantuan', '123456', 0),
(3, 'Nguyễn Thị Thu Hằng 2', '/images/account/1621383833.jpg', 1, 'thuhang2', '1234', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_notification`
--

CREATE TABLE `user_notification` (
  `invoice_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `atable`
--
ALTER TABLE `atable`
  ADD PRIMARY KEY (`atable_id`);

--
-- Chỉ mục cho bảng `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`discount_id`);

--
-- Chỉ mục cho bảng `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `atable`
--
ALTER TABLE `atable`
  MODIFY `atable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `discount`
--
ALTER TABLE `discount`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `product_category`
--
ALTER TABLE `product_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
