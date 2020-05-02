-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: sql1.njit.edu
-- Generation Time: Apr 30, 2020 at 07:36 PM
-- Server version: 8.0.17
-- PHP Version: 5.6.40

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `as2757`
--

--
-- Dumping data for table `BOOK`
--

INSERT INTO `BOOK` (`DOCID`, `ISBN`) VALUES
(1, 1342),
(2, 1234),
(3, 42343),
(4, 6767),
(5, 8978),
(6, 457),
(7, 86),
(8, 1123),
(9, 896),
(10, 956634),
(11, 2356),
(12, 12346);

--
-- Dumping data for table `BORROWS`
--

INSERT INTO `BORROWS` (`BORNUMBER`, `READERID`, `DOCID`, `COPYNO`, `LIBID`, `BDTIME`, `RDTIME`) VALUES
(1, 1, 1, 1, 1, '2017-05-17 14:05:01', '2020-02-12 23:17:30'),
(6, 1, 1, 1, 1, '2020-03-31 17:46:11', '2020-04-28 23:51:02'),
(7, 3, 2, 1, 1, '2020-04-28 23:15:06', NULL),
(8, 1, 1, 2, 1, '2020-04-28 23:25:39', '2020-04-28 23:46:09'),
(9, 1, 1, 2, 1, '2020-04-28 23:51:29', '2020-04-29 00:51:48'),
(10, 1, 1, 1, 1, '2020-04-28 23:54:31', '2020-04-30 00:33:42'),
(11, 1, 1, 2, 1, '2020-04-29 01:07:15', '2020-04-29 01:07:47'),
(12, 1, 1, 2, 1, '2020-04-29 02:02:45', '2020-04-29 18:07:44'),
(13, 1, 2, 2, 1, '2020-04-29 21:05:54', '2020-04-30 00:33:41'),
(14, 6, 8, 1, 1, '2020-04-30 00:22:48', NULL),
(15, 6, 11, 1, 1, '2020-04-30 00:23:54', '2020-04-30 00:30:05'),
(16, 6, 5, 1, 1, '2020-04-30 00:24:42', NULL),
(17, 6, 7, 1, 1, '2020-04-30 00:24:59', NULL),
(18, 6, 9, 1, 1, '2020-04-30 00:25:11', NULL),
(19, 6, 12, 1, 1, '2020-04-30 00:25:20', '2020-04-30 00:32:27'),
(20, 6, 10, 1, 1, '2020-04-30 00:29:43', NULL),
(21, 6, 4, 1, 1, '2020-04-30 00:32:25', NULL),
(22, 11, 1, 1, 1, '2020-04-30 00:33:51', NULL);

--
-- Dumping data for table `BRANCH`
--

INSERT INTO `BRANCH` (`LIBID`, `LNAME`, `LLOCATION`) VALUES
(1, 'CentralAveLib', 'Central Avenue'),
(2, 'NewarkLib', 'Newark'),
(3, 'DowntownBooks', 'New York');

--
-- Dumping data for table `COPY`
--

INSERT INTO `COPY` (`DOCID`, `COPYNO`, `LIBID`, `POSITION`) VALUES
(1, 1, 1, 'At the back'),
(1, 2, 1, 'Somewhere In The Middle'),
(1, 3, 1, 'Somewhere In The Front'),
(2, 1, 1, 'All the way at the back'),
(2, 2, 1, 'All the way up'),
(3, 1, 1, 'everywhere'),
(4, 1, 1, 'out here'),
(5, 1, 1, 'in the middle'),
(6, 1, 1, 'at the back'),
(7, 1, 1, 'all the way up'),
(8, 1, 1, '6 feet underground'),
(9, 1, 1, 'ask librarian'),
(10, 1, 1, 'up there'),
(11, 1, 1, 'down here'),
(12, 1, 1, 'cloud 9');

--
-- Dumping data for table `DOCUMENT`
--

INSERT INTO `DOCUMENT` (`DOCID`, `TITLE`, `PDATE`, `PUBLISHERID`) VALUES
(1, '20,000 Leagues', '2019-11-13', 1),
(2, '40,000 Leagues', '2019-11-13', 1),
(3, 'doc3', '2017-09-19', 2),
(4, 'doc4', '2019-12-09', 2),
(5, 'newdoc', '2019-05-19', 3),
(6, 'doc6', '2020-02-17', 3),
(7, '6 Underground', '2020-01-21', 1),
(8, 'Holy Guacamole', '2019-10-21', 1),
(9, 'adventures of tintin', '2020-04-13', 2),
(10, 'night at the museum', '2020-04-05', 2),
(11, 'the illusionist', '2020-04-02', 3),
(12, 'new book', '2020-04-01', 3);

--
-- Dumping data for table `PUBLISHER`
--

INSERT INTO `PUBLISHER` (`PUBLISHERID`, `PUBNAME`, `ADDRESS`) VALUES
(1, 'publisher1', 'newark 100'),
(2, 'Unique Pubs', 'Where-ever'),
(3, 'NotSoCool Publishing', 'Hoth');

--
-- Dumping data for table `READER`
--

INSERT INTO `READER` (`READERID`, `RTYPE`, `RNAME`, `ADDRESS`) VALUES
(1, 'passive', 'Anakin Skywalker', 'Tatooine'),
(2, 'meh', 'reader2', 'over here'),
(3, 'passive', 'Luke Skywalker', 'Chott El Jerid'),
(4, 'aggressive', 'Darth Vader', 'Death Star'),
(5, 'aggressive and avid', 'Bilbo Baggins', 'Shire'),
(6, 'casual', 'Frodo Baggins', 'Shire'),
(7, 'somewhat', 'Doom Guy', 'Hell'),
(8, 'easy', 'dairol', 'passaic'),
(9, 'smth', 'nameee', 'home'),
(10, 'rtype1', 'rname2', 'address3'),
(11, 'rtype5', 'rname6', 'address11'),
(12, 'rtype7', 'rname11', 'address99'),
(13, 'rtype100', 'rname100', 'adress100'),
(14, 'passive', 'Dairol', 'Garfield');

--
-- Dumping data for table `RESERVES`
--

INSERT INTO `RESERVES` (`RESNUMBER`, `READERID`, `DOCID`, `COPYNO`, `LIBID`, `DTIME`) VALUES
(4, 1, 1, 2, 1, '2020-04-29 18:07:53'),
(5, 1, 1, 3, 1, '2020-04-29 21:11:27');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
