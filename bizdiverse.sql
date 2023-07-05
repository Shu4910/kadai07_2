-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2023-07-05 16:58:56
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
  `tel` int(12) NOT NULL,
  `birthday` date NOT NULL,
  `types` varchar(64) NOT NULL,
  `techo` varchar(64) NOT NULL,
  `info` varchar(64) NOT NULL,
  `zipcode` int(12) NOT NULL,
  `address1` varchar(64) NOT NULL,
  `address2` varchar(64) NOT NULL,
  `address3` varchar(64) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `prefecture` varchar(64) NOT NULL,
  `area` varchar(64) NOT NULL,
  `city` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `bizdiverse`
--

INSERT INTO `bizdiverse` (`id`, `name`, `kana`, `mail`, `tel`, `birthday`, `types`, `techo`, `info`, `zipcode`, `address1`, `address2`, `address3`, `pass`, `prefecture`, `area`, `city`) VALUES
(2, 'Shu', 'しゅう', 'test@test.jp', 2147483647, '2023-06-25', '身体障害', '-', '全ての情報', 8820035, '宮崎県', '延岡市', '日の出町', '$2y$10$Zcqmi9D22JIoamQUHnpkT.S9S/sPIh/RNCzP679uyXoRkS7fzP0JS', '', '', ''),
(9, 'テスト', 'ぱぱ', 'komaki@beyondborders.jp', 2147483647, '1992-09-10', '精神', '-', '全ての情報', 8820034, '宮崎県', '延岡市', '昭和町', '$2y$10$xrPms/tAD0KDiwJMhBLTR.HnwKokbpN.FELHzhQo.Z903mLUENR6u', '', '', ''),
(18, '小牧秀太郎あ', '', 'sz91hs@gmail.com', 0, '0000-00-00', '', '', '', 0, '', '', '', '$2y$10$YrmNvq7.dpbYMc25JcztgO.ap0A0msWKjZcITaEE7w/b9cKatCyr6', 'tokyo', 'inside', 'chiyoda,minato');

-- --------------------------------------------------------

--
-- テーブルの構造 `bizdiverse_company`
--

CREATE TABLE `bizdiverse_company` (
  `id_com` int(12) NOT NULL,
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

INSERT INTO `bizdiverse_company` (`id_com`, `houjin`, `tanto`, `com_email`, `com_tel`, `types`, `pass`, `content`, `zipcode`, `address1`, `address2`, `address3`, `address4`, `address5`, `prefecture`, `area`, `city`) VALUES
(2, 'aaa', 'adfa', 'hidehide@hide.co.jp', 0, '企業', '$2y$10$ON5s4cnQXIvujYwLNz55sea/6WpzND/LTc47m4elyUvuT4FDjaTju', '', 2340031, 'aa', 'adafa', 'fdasfa', '', '', '', '', ''),
(3, 'aaa', 'dafa', 'sz91hs@gmail.com', 2147483647, '企業', '$2y$10$6XaHiFjsyuybKoQx7cYydeXm4AV3SVC/JQGQfNN2.38UM8yiS1Jgu', 'pipi', 1020072, '東京都', '千代田区', '飯田橋', '', '', 'tokyo', 'inside', 'chiyoda,minato');

-- --------------------------------------------------------

--
-- テーブルの構造 `messages`
--

CREATE TABLE `messages` (
  `message_id` int(128) NOT NULL,
  `session_id` int(64) NOT NULL,
  `company_send_id` int(64) NOT NULL,
  `user_send_id` int(64) NOT NULL,
  `message_body` text NOT NULL,
  `send_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(128) NOT NULL,
  `com_sess_id` int(128) NOT NULL,
  `user_sess_id` int(128) NOT NULL,
  `session_start` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_end` datetime NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `bizdiverse`
--
ALTER TABLE `bizdiverse`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `bizdiverse_company`
--
ALTER TABLE `bizdiverse_company`
  ADD PRIMARY KEY (`id_com`);

--
-- テーブルのインデックス `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `company_send_id` (`company_send_id`),
  ADD KEY `messages_ibfk_2` (`user_send_id`);

--
-- テーブルのインデックス `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `com_sess_id` (`com_sess_id`),
  ADD KEY `sessions_ibfk_2` (`user_sess_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `bizdiverse`
--
ALTER TABLE `bizdiverse`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- テーブルの AUTO_INCREMENT `bizdiverse_company`
--
ALTER TABLE `bizdiverse_company`
  MODIFY `id_com` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(128) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(128) NOT NULL AUTO_INCREMENT;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`company_send_id`) REFERENCES `bizdiverse_company` (`id_com`) ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`user_send_id`) REFERENCES `bizdiverse` (`id`) ON UPDATE CASCADE;

--
-- テーブルの制約 `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`com_sess_id`) REFERENCES `bizdiverse_company` (`id_com`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`user_sess_id`) REFERENCES `bizdiverse` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
