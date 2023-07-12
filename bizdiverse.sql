-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
<<<<<<< HEAD
-- 生成日時: 2023 年 7 月 12 日 16:22
=======
-- 生成日時: 2023 年 7 月 12 日 16:25
>>>>>>> 865f163586ada2966c2c61af233e440e65a55935
-- サーバのバージョン： 10.4.28-MariaDB
-- PHP のバージョン: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `bizdiverse`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `bizdiverse`
--

CREATE TABLE `bizdiverse` (
  `id` int(12) NOT NULL,
  `name` varchar(64) NOT NULL,
  `kana` varchar(64) NOT NULL,
  `mail` varchar(128) NOT NULL,
  `tel` varchar(128) NOT NULL,
  `birthday` date NOT NULL,
  `types` varchar(64) NOT NULL,
  `techo` varchar(64) NOT NULL,
  `info` varchar(64) NOT NULL,
  `zipcode` int(12) NOT NULL,
  `address1` varchar(64) NOT NULL,
  `address2` varchar(64) NOT NULL,
  `address3` varchar(64) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `prefecture` varchar(64) DEFAULT NULL,
  `area` varchar(64) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `bizdiverse`
--

INSERT INTO `bizdiverse` (`id`, `name`, `kana`, `mail`, `tel`, `birthday`, `types`, `techo`, `info`, `zipcode`, `address1`, `address2`, `address3`, `pass`, `prefecture`, `area`, `city`, `content`) VALUES
(2, 'Shu', 'しゅう', 'test@test.jp', '2147483647', '2023-06-25', '身体障害', '-', '全ての情報', 8820035, '宮崎県', '延岡市', '日の出町', '$2y$10$Zcqmi9D22JIoamQUHnpkT.S9S/sPIh/RNCzP679uyXoRkS7fzP0JS', '', '', 'chiyoda', ''),
(9, 'テスト', 'ぱぱ', 'komaki@beyondborders.jp', '2147483647', '1992-09-10', '精神', '-', '全ての情報', 8820034, '宮崎県', '延岡市', '昭和町', '$2y$10$xrPms/tAD0KDiwJMhBLTR.HnwKokbpN.FELHzhQo.Z903mLUENR6u', '', '', 'chiyoda', ''),
(18, '小牧秀太郎', 'あああ', 'sz91hs@gmail.com', '08058039058', '1992-09-10', '精神', '-', '全ての情報', 2140031, '神奈川県', '川崎市多摩区', '東生田', '$2y$10$t6FsNb0i2bQ2JnzXxjZwPuSWUmOIC.PCm/HivlT8TAXbsN4Ry60Ea', 'tokyo', 'inside', 'chiyoda', 'ああ'),
(19, '小牧秀太郎', 'ああ', 'sz83hs@yahoo.co.jp', '08058039048', '1992-09-10', '精神', '-', '全ての情報', 1020072, '東京都', '千代田区', '飯田橋', '$2y$10$Lbb/vNzxecFVgsCqS.Zknehh8gEMhVHI930sfNJFc2X32fsEuyvzq', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `bizdiverse_company`
--

CREATE TABLE `bizdiverse_company` (
  `company_id` int(12) NOT NULL,
  `houjin` varchar(64) NOT NULL,
  `tanto` varchar(64) NOT NULL,
  `com_email` varchar(64) NOT NULL,
  `com_tel` int(12) NOT NULL,
  `types` varchar(64) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `zipcode` int(12) NOT NULL,
  `address1` varchar(64) NOT NULL,
  `address2` varchar(64) NOT NULL,
  `address3` varchar(64) NOT NULL,
  `address4` varchar(64) NOT NULL,
  `address5` varchar(64) NOT NULL,
  `prefecture` varchar(128) NOT NULL,
  `area` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `bizdiverse_company`
--

INSERT INTO `bizdiverse_company` (`company_id`, `houjin`, `tanto`, `com_email`, `com_tel`, `types`, `pass`, `content`, `zipcode`, `address1`, `address2`, `address3`, `address4`, `address5`, `prefecture`, `area`, `city`) VALUES
(2, 'aaa', 'adfa', 'hidehide@hide.co.jp', 0, '企業', '$2y$10$ON5s4cnQXIvujYwLNz55sea/6WpzND/LTc47m4elyUvuT4FDjaTju', '', 2340031, 'aa', 'adafa', 'fdasfa', '', '', '', '', ''),
(3, 'aaa', 'dafa', 'sz91hs@gmail.com', 2147483647, '企業', '$2y$10$6XaHiFjsyuybKoQx7cYydeXm4AV3SVC/JQGQfNN2.38UM8yiS1Jgu', 'pipi', 1020072, '東京都', '千代田区', '飯田橋', '', '', 'tokyo', 'inside', 'chiyoda,minato');

-- --------------------------------------------------------

--
-- テーブルの構造 `messages`
--

CREATE TABLE `messages` (
  `id` int(128) NOT NULL,
  `session_id` varchar(64) NOT NULL,
  `company_send_id` int(64) NOT NULL,
  `user_send_id` int(64) NOT NULL,
  `message_body` text NOT NULL,
  `send_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sender_type` enum('user','company') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `messages`
--

INSERT INTO `messages` (`id`, `session_id`, `company_send_id`, `user_send_id`, `message_body`, `send_at`, `sender_type`) VALUES
(1, '2_18', 2, 18, 'aaaa', '2023-07-12 05:23:10', 'user'),
(2, '3_9', 3, 9, 'ふぁふぁｄｆ', '2023-07-12 05:23:37', 'user'),
(3, '3_2', 3, 2, 'っっっふぁ', '2023-07-12 05:23:53', 'user'),
(4, '3_18', 3, 18, 'あああ', '2023-07-12 05:23:46', 'user'),
(5, '0', 32, 18, 'あああ', '2023-07-12 05:19:59', 'user'),
(6, '3_18', 3, 18, 'あああ', '2023-07-12 05:24:00', 'user'),
(7, '3_18', 3, 18, 'あああ', '2023-07-12 02:21:12', 'user'),
(8, '3_18', 3, 18, 'あああ', '2023-07-12 02:28:15', 'user'),
(9, '3_9', 3, 9, 'ふぁｄふぁ', '2023-07-12 02:29:03', 'user'),
(10, '3_9', 3, 9, 'あああ', '2023-07-12 03:43:11', 'user'),
(11, '3_18', 3, 18, 'aaa', '2023-07-12 04:27:11', 'company'),
(12, '3_18', 0, 0, 'あああ', '2023-07-12 04:33:00', 'company'),
(13, '3_18', 0, 0, 'いふぃいふぁ', '2023-07-12 04:33:04', 'company'),
(14, '3_18', 0, 0, 'ああ', '2023-07-12 04:38:36', 'company'),
(15, '3_18', 0, 0, 'あああ', '2023-07-12 05:41:35', 'company'),
(16, '3_18', 0, 0, 'あああ', '2023-07-12 05:44:06', 'company'),
(17, '3_18', 0, 0, 'テスト', '2023-07-12 05:44:25', 'company'),
(18, '3_18', 0, 0, 'テスト', '2023-07-12 05:44:58', 'user'),
(19, '3_18', 0, 0, 'あああ', '2023-07-12 05:51:57', 'user'),
(20, '3_18', 0, 0, 'あああ', '2023-07-12 05:53:35', 'user'),
(21, '3_18', 3, 18, 'あああ', '2023-07-12 06:10:21', 'user');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `bizdiverse`
--
ALTER TABLE `bizdiverse`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `bizdiverse`
--
ALTER TABLE `bizdiverse`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- テーブルの AUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
