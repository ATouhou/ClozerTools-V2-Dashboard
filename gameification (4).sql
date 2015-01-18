-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 23, 2014 at 07:25 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aas_testing4`
--

-- --------------------------------------------------------

--
-- Table structure for table `gameification`
--

CREATE TABLE IF NOT EXISTS `gameification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_name` varchar(100) NOT NULL,
  `game_description` tinytext NOT NULL,
  `game_points` int(11) NOT NULL,
  `badge_image` varchar(350) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `user_type` enum('salesrep','agent','doorrep','manager') NOT NULL,
  `status` enum('running','disabled') NOT NULL,
  `type` enum('points','achievements','trophies','badges') NOT NULL,
  `query_table` varchar(50) NOT NULL,
  `sql_query` tinytext NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `gameification`
--

INSERT INTO `gameification` (`id`, `game_name`, `game_description`, `game_points`, `badge_image`, `date_from`, `date_to`, `user_type`, `status`, `type`, `query_table`, `sql_query`, `order`, `created_at`, `updated_at`) VALUES
(13, '10 Systems', 'Sell 10 Systems to unlock this achievement', 10, '10systems.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'achievements', 'totsales', 'grosssale|system', 3, '0000-00-00', '0000-00-00'),
(15, '10 Supers', 'Sell 10 Super Systems to unlock this achievement', 10, '10supers.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'achievements', 'totsales', 'grosssale|supersystem', 4, '0000-00-00', '0000-00-00'),
(16, '10 Megas', 'Sell 10 Mega Systems to unlock this achievement', 10, '10supers.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'achievements', 'totsales', 'grosssale|megasystem', 5, '0000-00-00', '0000-00-00'),
(17, '10 Novas', 'Sell 10 Nova Systems to unlock this achievement', 10, '10supers.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'achievements', 'totsales', 'grosssale|novasystem', 6, '0000-00-00', '0000-00-00'),
(18, '10 Majestics', 'Sell 10 Majestics to unlock this achievement', 10, '10majestics.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'achievements', 'totsales', 'grossmd|majestic', 2, '0000-00-00', '0000-00-00'),
(19, '10 Defenders', 'Sell 10 Defenders to unlock this achievement', 10, '10defenders.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'achievements', 'totsales', 'grossmd|defender', 1, '0000-00-00', '0000-00-00'),
(20, '3 Demos 1 Day', '3 Put On Demos in 1 Day', 3, '3demsday.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'day|3dems', 7, '0000-00-00', '0000-00-00'),
(21, '4 Demos 1 Day', '4 Put On Demos in 1 Day', 4, '4demsday.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'day|4dems', 8, '0000-00-00', '0000-00-00'),
(22, '5 Demos 1 Day', '5 Put On Demos in 1 Day', 5, '5demsday.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'day|5dems', 9, '0000-00-00', '0000-00-00'),
(23, '15 Demos 1 Week', '15 Put On Demos in 1 Week', 15, '15demsweek.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'week|15dems', 10, '0000-00-00', '0000-00-00'),
(24, '20 Demos 1 Week', '20 Put On Demos in 1 Week', 20, '20demsweek.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'week|20dems', 11, '0000-00-00', '0000-00-00'),
(25, '25 Demos 1 Week', '25 Put On Demos in 1 Week', 25, '25demsweek.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'week|25dems', 12, '0000-00-00', '0000-00-00'),
(26, '50 Demos 1 Month', '50 Put On Demos in 1 Month', 50, '50demsmonth.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'month|50dems', 13, '0000-00-00', '0000-00-00'),
(27, '60 Demos 1 Month', '60 Put On Demos in 1 Month', 60, '60demsmonth.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'month|60dems', 14, '0000-00-00', '0000-00-00'),
(28, '75 Demos 1 Month', '75 Put On Demos in 1 Month', 75, '75demsmonth.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'month|75dems', 15, '0000-00-00', '0000-00-00'),
(29, '200 Net Units', '200 Total Unit Sales', 200, '200netunits.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'totsales', 'totnetunits', 29, '0000-00-00', '0000-00-00'),
(30, '100 Net Units', '100 Total Net Units', 100, '100netunits.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'totsales', 'totnetunits', 30, '0000-00-00', '0000-00-00'),
(31, '2 Sold in 1 Day', '2 Sales in 1 Day', 2, '2saleday.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'day|2sold', 31, '0000-00-00', '0000-00-00'),
(32, '3 Sold in 1 Day', '3 Sales in 1 Day', 3, '3saleday.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'day|3sold', 32, '0000-00-00', '0000-00-00'),
(33, '4 Sold in 1 Day', '4 Sales in 1 Day', 4, '4saleday.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'day|4sold', 33, '0000-00-00', '0000-00-00'),
(34, '8 Sales in 1 Week', '8 Sales in 1 Week', 8, '8saleweek.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'week|8sold', 34, '0000-00-00', '0000-00-00'),
(35, '12 Sales in 1 Week', '12 Sales in 1 Week', 12, '12saleweek.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'week|12sold', 35, '0000-00-00', '0000-00-00'),
(36, '15 Sales in 1 Week', '15 Sales in 1 Week', 15, '15saleweek.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'week|15sold', 37, '0000-00-00', '0000-00-00'),
(37, '18 Sales in 1 Month', '18 Sales in 1 Month', 18, '18salemonth.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'month|18sold', 36, '0000-00-00', '0000-00-00'),
(38, '25 Sales in 1 Month', '25 Sales in 1 Month', 25, '25salemonth.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'month|25sold', 37, '0000-00-00', '0000-00-00'),
(39, '30 Sales in 1 Month', '30 Sales in 1 Month', 30, '30salemonth.png', '0000-00-00', '0000-00-00', 'salesrep', 'running', 'trophies', 'apps', 'month|30sold', 38, '0000-00-00', '0000-00-00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
