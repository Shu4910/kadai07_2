-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2023-08-03 17:04:57
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
-- データベース: `bizdiverse_user`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `bizdiverse_user`
--

CREATE TABLE `bizdiverse_user` (
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
  `content` text DEFAULT NULL,
  `work` varchar(128) DEFAULT NULL,
  `area_detail` varchar(128) DEFAULT NULL,
  `jigyousho` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `bizdiverse_user`
--

INSERT INTO `bizdiverse_user` (`id`, `name`, `kana`, `mail`, `tel`, `birthday`, `types`, `techo`, `info`, `zipcode`, `address1`, `address2`, `address3`, `pass`, `prefecture`, `area`, `city`, `content`, `work`, `area_detail`, `jigyousho`) VALUES
(2, '小牧秀太郎', 'あああ', 'komaki@beyondborders.jp', '09038835911', '1992-09-10', '精神', '無し', '全ての情報', 1020072, '東京都', '千代田区', '飯田橋', '$2y$10$LY26zquvthRMiHnf7.XS0el3r4QXTP9NG5Ihe3AharlMYDiV/EJjy', '', '', 'chiyoda', '', NULL, NULL, NULL),
(18, '小牧秀太郎', 'あああああ', 'sz91hs@gmail.com', '08058039058', '1992-09-10', '精神', '2級', '全ての情報', 2140031, '神奈川県', '川崎市多摩区', '東生田あ', '$2y$10$27mjTZ4xhQkenVSC7iSw2e33cSH/lVG6V/tbufhOGeU6haYuOb1Ai', 'tokyo', 'inside', 'chiyoda,minato,hachi', 'ああ', 'WEBデザイナー,ITエンジニア,DTP・CADオペレーター', 'あ', '同じ障害種別の通所者が多い,当事者職員がいる'),
(19, '小牧秀太郎', 'ああ', 'sz83hs@yahoo.co.jp', '08058039048', '1992-09-10', '精神', '-', '全ての情報', 1020072, '東京都', '千代田区', '飯田橋', '$2y$10$RcMojsqdjSYzeaPdZ7nJU./2GUfUGi5gBSHU34vJNmM3aCWWJwW8S', 'tokyo', 'inside', 'chiyoda,minato', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `bizdiverse_company`
--

CREATE TABLE `bizdiverse_company` (
  `company_id` int(12) NOT NULL,
  `houjin` varchar(64) NOT NULL,
  `tanto` varchar(64) NOT NULL,
  `mail` varchar(64) NOT NULL,
  `tel` varchar(128) NOT NULL,
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

INSERT INTO `bizdiverse_company` (`company_id`, `houjin`, `tanto`, `mail`, `tel`, `types`, `pass`, `content`, `zipcode`, `address1`, `address2`, `address3`, `address4`, `address5`, `prefecture`, `area`, `city`) VALUES
(2, '株式会社BEYOND BORDERS', 'aa', 'sz91hs@gmail.com', '08058039058', '企業', '$2y$10$TbBZVYiXIz2qwCmDHDM29eld0sBC9ieCalNAOjWlodX.g9s0167p2', 'あああああ', 1020072, '東京都', '千代田区', '飯田橋', '', '', 'tokyo', 'outside', 'hachi'),
(4, '株式会社ゼネラルパートナーズ', 'こまきテスト', 'komaki@beyondborders.jp', '8058039058', '就労移行', '$2y$10$hXPNFKE/pHfJYp/IHzi7Y.pMg24yj./5nQnIvJvZwYriC6NMGFqqm', 'ああああああ', 2140031, '神奈川県', '川崎市多摩区', '東生田', '', '', 'tokyo', 'inside', 'chiyoda'),
(5, '株式会社BEYOND BORDERS', 'あああa', 'sz91hs@gmail.com', '8058039058', '企業', '$2y$10$.97qir6GzUyOjBa3HbaqTuQPX/0hZauhiaMP6WfmZnuZ0lNmtoceu', 'aaa', 1020072, '２－５－３', 'スカイコート九段下８０５号室', '飯田橋', '', '', 'tokyo', 'outside', 'hachi'),
(6, '株式会社BEYOND BORDERSあ', 'ああああ', 'hidehide@hide.co.jp', '08058039053', '企業', '$2y$10$ep8szSSUPIWtBL4.5Mkm1ORR1TsYL.l6GTnqNtCjU6CCPIiVB4a0W', '', 2140031, '神奈川県', '川崎市多摩区', '東生田', '', '', 'tokyo', 'inside', 'minato');

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
  `sender_type` enum('user','company') NOT NULL,
  `last_id` int(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `messages`
--

INSERT INTO `messages` (`id`, `session_id`, `company_send_id`, `user_send_id`, `message_body`, `send_at`, `sender_type`, `last_id`) VALUES
(1, '2_18', 2, 18, 'aaaa', '2023-07-30 12:43:51', 'user', 138),
(2, '3_9', 3, 9, 'ふぁふぁｄｆ', '2023-07-13 13:54:16', 'user', 93),
(3, '3_2', 3, 2, 'っっっふぁ', '2023-07-13 12:13:37', 'user', 36),
(4, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(6, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(7, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(8, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(9, '3_9', 3, 9, 'ふぁｄふぁ', '2023-07-13 13:54:16', 'user', 93),
(10, '3_9', 3, 9, 'あああ', '2023-07-13 13:54:16', 'user', 93),
(11, '3_18', 3, 18, 'aaa', '2023-07-13 13:03:26', 'company', 60),
(12, '3_18', 0, 0, 'あああ', '2023-07-13 13:03:26', 'company', 60),
(13, '3_18', 0, 0, 'いふぃいふぁ', '2023-07-13 13:03:26', 'company', 60),
(14, '3_18', 0, 0, 'ああ', '2023-07-13 13:03:26', 'company', 60),
(15, '3_18', 0, 0, 'あああ', '2023-07-13 13:03:26', 'company', 60),
(16, '3_18', 0, 0, 'あああ', '2023-07-13 13:03:26', 'company', 60),
(17, '3_18', 0, 0, 'テスト', '2023-07-13 13:03:26', 'company', 60),
(18, '3_18', 0, 0, 'テスト', '2023-07-13 13:03:26', 'user', 60),
(19, '3_18', 0, 0, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(20, '3_18', 0, 0, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(21, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(23, '3_18', 0, 0, 'ああああ', '2023-07-13 13:03:26', 'company', 60),
(24, '3_18', 0, 0, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(25, '3_18', 0, 0, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(26, '3_18', 0, 0, 'あああふぁｄｓ', '2023-07-13 13:03:26', 'user', 60),
(27, '2_18', 0, 0, 'あああ', '2023-07-30 12:43:51', 'user', 138),
(29, '3_18', 0, 0, 'ああああかｃ', '2023-07-13 13:03:26', 'user', 60),
(30, '2_18', 0, 0, 'あああ', '2023-07-30 12:43:51', 'user', 138),
(31, '2_18', 2, 18, 'ぴぴ', '2023-07-30 12:43:51', 'user', 138),
(32, '3_18', 3, 18, 'ああああ', '2023-07-13 13:03:26', 'user', 60),
(33, '3_2', 0, 0, 'あああ', '2023-07-13 12:13:37', 'company', 36),
(34, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'company', 60),
(35, '3_2', 3, 2, 'あああ', '2023-07-13 12:13:37', 'company', 36),
(36, '3_2', 3, 2, 'あ', '2023-07-13 12:13:37', 'company', 36),
(37, '3_18', 3, 18, 'あ', '2023-07-13 13:03:26', 'company', 60),
(38, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'company', 60),
(39, '3_18', 3, 18, 'あ', '2023-07-13 13:03:26', 'company', 60),
(40, '3_18', 3, 18, 'ｓ', '2023-07-13 13:03:26', 'company', 60),
(41, '3_18', 3, 18, 'あ', '2023-07-13 13:03:26', 'company', 60),
(42, '3_18', 3, 18, '1', '2023-07-13 13:03:26', 'company', 60),
(43, '3_19', 3, 19, 'あああ', '2023-07-13 12:47:02', 'user', 51),
(44, '3_19', 3, 19, 'ああああ', '2023-07-13 12:47:02', 'company', 51),
(45, '3_19', 3, 19, 'あああ', '2023-07-13 12:47:02', 'company', 51),
(46, '3_19', 3, 19, 'ああ', '2023-07-13 12:47:02', 'user', 51),
(47, '3_19', 3, 19, 'あああ', '2023-07-13 12:47:02', 'company', 51),
(48, '3_19', 3, 19, 'あ', '2023-07-13 12:47:02', 'company', 51),
(49, '3_19', 3, 19, 'ｆ', '2023-07-13 12:47:02', 'company', 51),
(50, '3_19', 3, 19, 'っっｆ', '2023-07-13 12:47:02', 'company', 51),
(51, '3_19', 3, 19, 'あ', '2023-07-13 12:47:02', 'company', 51),
(52, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(53, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(54, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(55, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(56, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(57, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(58, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(59, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(60, '3_18', 3, 18, 'あああ', '2023-07-13 13:03:26', 'user', 60),
(61, '3_9', 3, 9, 'あ', '2023-07-13 13:54:16', 'user', 93),
(62, '3_9', 3, 9, 'っっふぁ', '2023-07-13 13:54:16', 'user', 93),
(63, '3_9', 3, 9, 'ｆだふぁ', '2023-07-13 13:54:16', 'user', 93),
(64, '4_2', 4, 2, 'あ', '2023-07-14 13:56:40', 'user', 125),
(65, '4_2', 4, 2, 'こんばんわ。', '2023-07-14 13:56:40', 'company', 125),
(66, '4_2', 4, 2, 'ふぁ', '2023-07-14 13:56:40', 'company', 125),
(67, '4_2', 4, 2, 'あだｆ', '2023-07-14 13:56:40', 'company', 125),
(68, '4_2', 4, 2, 'ふぁｄふぁｆ', '2023-07-14 13:56:40', 'company', 125),
(69, '4_2', 4, 2, 'ああ', '2023-07-14 13:56:40', 'company', 125),
(70, '4_18', 4, 18, 'あああ', '2023-07-14 13:49:42', 'user', 122),
(71, '4_18', 4, 18, 'っふぁ', '2023-07-14 13:49:42', 'company', 122),
(72, '3_9', 3, 9, 'あああ', '2023-07-13 13:54:16', 'user', 93),
(73, '3_9', 3, 9, 'あふぁふぁ', '2023-07-13 13:54:16', 'user', 93),
(74, '4_18', 4, 18, 'あああ', '2023-07-14 13:49:42', 'company', 122),
(75, '4_18', 4, 18, 'ふぁｆだ', '2023-07-14 13:49:42', 'company', 122),
(76, '4_18', 4, 18, 'ああ', '2023-07-14 13:49:42', 'company', 122),
(77, '4_18', 4, 18, 'ああ', '2023-07-14 13:49:42', 'company', 122),
(78, '3_9', 3, 9, 'あ', '2023-07-13 13:54:16', 'user', 93),
(79, '4_18', 4, 18, 'aaa', '2023-07-14 13:49:42', 'company', 122),
(80, '4_18', 4, 18, 'fadfaf', '2023-07-14 13:49:42', 'company', 122),
(81, '3_9', 3, 9, 'っっｆ', '2023-07-13 13:54:16', 'user', 93),
(82, '4_18', 4, 18, 'a', '2023-07-14 13:49:42', 'company', 122),
(83, '4_18', 4, 18, 'ふぁだ', '2023-07-14 13:49:42', 'user', 122),
(84, '4_18', 4, 18, 'あああ', '2023-07-14 13:49:42', 'company', 122),
(85, '4_18', 4, 18, 'あああ', '2023-07-14 13:49:42', 'company', 122),
(86, '4_18', 4, 18, 'あ', '2023-07-14 13:49:42', 'company', 122),
(87, '4_18', 4, 18, 'あ', '2023-07-14 13:49:42', 'company', 122),
(88, '3_9', 3, 9, 'あ', '2023-07-13 13:54:16', 'user', 93),
(89, '3_9', 3, 9, 'てすと', '2023-07-13 13:54:16', 'user', 93),
(90, '4_18', 4, 18, '6', '2023-07-14 13:49:42', 'company', 122),
(91, '4_18', 4, 18, '1', '2023-07-14 13:49:42', 'company', 122),
(92, '3_9', 3, 9, 'ｑ', '2023-07-13 13:54:16', 'user', 93),
(93, '3_9', 3, 9, '4', '2023-07-13 13:54:16', 'user', 93),
(94, '4_18', 4, 18, '2', '2023-07-14 13:49:42', 'company', 122),
(95, '4_18', 0, 18, '3', '2023-07-14 13:49:42', 'company', 122),
(96, '4_18', 0, 18, 'こんばんわ。この度は〇〇様のAというご資格を拝見してスカウトいたしました。', '2023-07-14 13:49:42', 'company', 122),
(97, '4_18', 0, 18, 'あ', '2023-07-14 13:49:42', 'company', 122),
(98, '4_18', 0, 18, '1', '2023-07-14 13:49:42', 'company', 122),
(99, '4_18', 0, 18, 'ｆ', '2023-07-14 13:49:42', 'company', 122),
(100, '4_18', 0, 18, 'あ', '2023-07-14 13:49:42', 'company', 122),
(101, '4_18', 0, 18, 'あ', '2023-07-14 13:49:42', 'company', 122),
(102, '4_18', 0, 18, 'ｆ', '2023-07-14 13:49:42', 'company', 122),
(103, '4_18', 0, 18, '1', '2023-07-14 13:49:42', 'company', 122),
(104, '4_18', 0, 18, '4', '2023-07-14 13:49:42', 'company', 122),
(105, '4_18', 0, 18, '3', '2023-07-14 13:49:42', 'company', 122),
(106, '4_18', 0, 18, 'ｄ', '2023-07-14 13:49:42', 'company', 122),
(107, '4_18', 0, 18, 'ｆ', '2023-07-14 13:49:42', 'company', 122),
(108, '4_18', 0, 18, '2', '2023-07-14 13:49:42', 'company', 122),
(109, '4_18', 0, 18, '4', '2023-07-14 13:49:42', 'company', 122),
(110, '4_18', 0, 18, '3', '2023-07-14 13:49:42', 'company', 122),
(111, '4_18', 0, 18, '2', '2023-07-14 13:49:42', 'company', 122),
(112, '4_18', 0, 18, '1', '2023-07-14 13:49:42', 'company', 122),
(113, '4_18', 0, 18, '1', '2023-07-14 13:49:42', 'company', 122),
(114, '4_18', 0, 18, 'pipi', '2023-07-14 13:49:42', 'company', 122),
(115, '4_18', 0, 18, 'あ', '2023-07-14 13:49:42', 'company', 122),
(116, '4_18', 0, 18, '3', '2023-07-14 13:49:42', 'company', 122),
(117, '4_18', 0, 18, '5', '2023-07-14 13:49:42', 'company', 122),
(118, '4_18', 0, 18, 'テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト', '2023-07-14 13:49:42', 'company', 122),
(119, '4_18', 0, 18, 'テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト', '2023-07-14 13:49:42', 'company', 122),
(120, '4_18', 0, 18, 'ぴぴ', '2023-07-14 13:49:42', 'company', 122),
(121, '4_18', 0, 18, 'あ', '2023-07-14 13:49:42', 'company', 122),
(122, '4_18', 0, 18, 'お', '2023-07-14 13:49:42', 'company', 122),
(123, '4_2', 0, 2, 'ぴ', '2023-07-14 13:56:40', 'company', 125),
(124, '4_2', 0, 2, 'ｐ', '2023-07-14 13:56:40', 'company', 125),
(125, '4_2', 0, 2, '4', '2023-07-14 13:56:40', 'company', 125),
(126, '2_18', 2, 18, 'ぴぴ', '2023-07-30 12:43:51', 'user', 138),
(127, '2_18', 2, 18, 'ああ', '2023-07-30 12:43:51', 'user', 138),
(128, '2_18', 2, 18, 'テスト', '2023-07-30 12:43:51', 'user', 138),
(129, '2_18', 2, 18, 'あ', '2023-07-30 12:43:51', 'user', 138),
(130, '2_18', 2, 18, 'あ', '2023-07-30 12:43:51', 'user', 138),
(131, '5_2', 5, 2, 'a', '2023-07-29 13:44:23', 'user', 132),
(132, '5_2', 0, 2, 'a', '2023-07-29 13:44:23', 'company', 132),
(133, '2_18', 0, 18, 'a', '2023-07-30 12:43:51', 'company', 138),
(134, '2_18', 2, 18, 'テスト', '2023-07-30 12:43:51', 'user', 138),
(135, '2_18', 0, 18, 'あ', '2023-07-30 12:43:51', 'company', 138),
(136, '2_18', 2, 18, '1', '2023-07-30 12:43:51', 'user', 138),
(137, '2_18', 2, 18, 'あ', '2023-07-30 12:43:51', 'user', 138),
(138, '2_18', 0, 18, '1', '2023-07-30 12:43:51', 'company', 138),
(139, '6_19', 6, 19, 'あ', '2023-07-30 12:47:33', 'user', NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `bizdiverse_user`
--
ALTER TABLE `bizdiverse_user`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `bizdiverse_company`
--
ALTER TABLE `bizdiverse_company`
  ADD PRIMARY KEY (`company_id`);

--
-- テーブルのインデックス `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `bizdiverse_user`
--
ALTER TABLE `bizdiverse_user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- テーブルの AUTO_INCREMENT `bizdiverse_company`
--
ALTER TABLE `bizdiverse_company`
  MODIFY `company_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
