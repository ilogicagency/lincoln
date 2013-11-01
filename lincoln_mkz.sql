-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 19, 2013 at 09:33 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lincoln_mkz`
--
CREATE DATABASE IF NOT EXISTS `lincoln_mkz` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lincoln_mkz`;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `uploaded` varchar(255) NOT NULL,
  `synced` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `preferred_language` varchar(255) NOT NULL,
  `country_of_residence` varchar(255) NOT NULL,
  `emirate_uae_only` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `current_car` varchar(255) NOT NULL,
  `model_of_current_car` varchar(255) NOT NULL,
  `delivery_address_uae_only` varchar(255) NOT NULL,
  `scenary` varchar(32) NOT NULL,
  `drive_style` varchar(32) NOT NULL,
  `music` varchar(32) NOT NULL,
  `lighting` varchar(32) NOT NULL,
  `feature_mode` tinyint(1) NOT NULL DEFAULT '0',
  `feature_music` tinyint(1) NOT NULL DEFAULT '0',
  `feature_lighting` tinyint(1) NOT NULL DEFAULT '0',
  `feature_traffic` tinyint(1) NOT NULL DEFAULT '0',
  `feature_shift` tinyint(1) NOT NULL DEFAULT '0',
  `feature_touch` tinyint(1) NOT NULL DEFAULT '0',
  `feature_voice` tinyint(1) NOT NULL DEFAULT '0',
  `feature_lane` tinyint(1) NOT NULL DEFAULT '0',
  `feature_noise` tinyint(1) NOT NULL DEFAULT '0',
  `feature_park` tinyint(1) NOT NULL DEFAULT '0',
  `booking` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `social_id` varchar(255) NOT NULL,
  `social_type` varchar(255) NOT NULL,
  `social_token` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `meta` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `receive_info` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
