-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2021 年 7 月 11 日 05:27
-- サーバのバージョン： 10.4.19-MariaDB
-- PHP のバージョン: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `baito_map`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `info`
--

CREATE TABLE `info` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `money` int(11) NOT NULL,
  `work` varchar(255) NOT NULL,
  `work_time` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `info`
--

INSERT INTO `info` (`id`, `name`, `longitude`, `latitude`, `money`, `work`, `work_time`, `phone`) VALUES
(1, 'コンビニ', 34.489869, 136.839686, 500, 'レジ', '18-22', '0372982839'),
(2, 'コンビニ', 34.49099, 136.831601, 600, 'ホール', '15-20', '03723282839'),
(43, 'ふるさと館', 34.484574816773, 136.82201072781, 100, '勝又の奴隷', '0時から24時', '90901');

-- --------------------------------------------------------

--
-- テーブルの構造 `manage`
--

CREATE TABLE `manage` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `manage`
--

INSERT INTO `manage` (`id`, `user_id`, `password`) VALUES
(1, 'katumata', '1111'),
(17, 'map', '1111');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `manage`
--
ALTER TABLE `manage`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `info`
--
ALTER TABLE `info`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- テーブルの AUTO_INCREMENT `manage`
--
ALTER TABLE `manage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
