-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2015 at 01:48 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `website`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`idcat` int(11) NOT NULL,
  `category` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`idcat`, `category`) VALUES
(1, 'Artikelku'),
(2, 'Pengarang'),
(3, 'Penulis');

-- --------------------------------------------------------

--
-- Table structure for table `cat_post`
--

CREATE TABLE IF NOT EXISTS `cat_post` (
`id_cat_post` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `idcat` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cat_post`
--

INSERT INTO `cat_post` (`id_cat_post`, `id_post`, `idcat`) VALUES
(2, 1, 3),
(3, 1, 3),
(4, 1, 3),
(5, 1, 3),
(6, 1, 3),
(7, 1, 3),
(8, 1, 3),
(9, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`idcomment` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `author` text NOT NULL,
  `url` text NOT NULL,
  `email` text NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posting`
--

CREATE TABLE IF NOT EXISTS `posting` (
`id_post` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `excerpt` text NOT NULL,
  `date_post` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posting`
--

INSERT INTO `posting` (`id_post`, `iduser`, `title`, `content`, `excerpt`, `date_post`) VALUES
(3, 1, 'Hello World v2', '<p>Hello World, This My First Posting.</p>\r\n', 'Hello World, This My First Posting.\r\n', '2015-07-02 18:49:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`iduser` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `date_register` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `level_user` enum('admin','member') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`iduser`, `username`, `password`, `email`, `first_name`, `last_name`, `date_register`, `level_user`) VALUES
(1, 'admin', 'c0e024d9200b5705bc4804722636378a', '', '', '', '2015-06-12 10:39:28', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`idcat`);

--
-- Indexes for table `cat_post`
--
ALTER TABLE `cat_post`
 ADD PRIMARY KEY (`id_cat_post`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`idcomment`);

--
-- Indexes for table `posting`
--
ALTER TABLE `posting`
 ADD PRIMARY KEY (`id_post`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `idcat` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cat_post`
--
ALTER TABLE `cat_post`
MODIFY `id_cat_post` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `idcomment` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posting`
--
ALTER TABLE `posting`
MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
