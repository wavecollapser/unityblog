-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5
-- http://www.phpmyadmin.net
--
-- Host: 
-- Generation Time: Jul 18, 2014 at 07:50 AM
-- Server version: 5.1.73
-- PHP Version: 5.3.3-7+squeeze19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `unityblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE IF NOT EXISTS `Admin` (
  `Username` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`Username`, `Password`) VALUES
('admin', 'admin');
-- --------------------------------------------------------

--
-- Table structure for table `Articles`
--

CREATE TABLE IF NOT EXISTS `Articles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Date` datetime NOT NULL,
  `Title` text CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `Text` text CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `LastUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=113 ;

-- --------------------------------------------------------

--
-- Table structure for table `Articles_Old`
--

CREATE TABLE IF NOT EXISTS `Articles_Old` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Date` datetime NOT NULL,
  `Title` text CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `Text` text CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `LastUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3004 ;

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE IF NOT EXISTS `Categories` (
  `ID` int(11) NOT NULL,
  `Category` varchar(30) CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `Show_catlist` tinyint(1) NOT NULL DEFAULT '1',
  `Show_sitemap` tinyint(1) NOT NULL DEFAULT '1',
  `Show_hidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'for comments we dont want to show anywhere, but we want the text on our blog anyway'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CategoryID`
--

CREATE TABLE IF NOT EXISTS `CategoryID` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Category` varchar(30) CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `Description` varchar(150) CHARACTER SET utf8 COLLATE utf8_danish_ci DEFAULT NULL,
  `Show` tinyint(1) NOT NULL DEFAULT '1',
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nick` varchar(30) NOT NULL,
  `Date` datetime NOT NULL,
  `Website` varchar(50) NOT NULL,
  `IP` text NOT NULL,
  `Comment` text NOT NULL,
  `Qrystr_custsiteID` int(11) DEFAULT NULL,
  `Qrystr_articleID` int(11) DEFAULT NULL,
  `Qrystr_catID` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

--
-- Table structure for table `CustomPages`
--

CREATE TABLE IF NOT EXISTS `CustomPages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Date` datetime NOT NULL,
  `Title` varchar(100) CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `Text` mediumtext CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `LastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Hide` tinyint(1) NOT NULL DEFAULT '1',
  `HideDate` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- Table structure for table `Log`
--

CREATE TABLE IF NOT EXISTS `Log` (
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IP` text NOT NULL,
  `URL` varchar(60) NOT NULL,
  `Referer` varchar(60) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Settings`
--

CREATE TABLE IF NOT EXISTS `Settings` (
  `Log_enable` tinyint(1) NOT NULL DEFAULT '1',
  `CSS_file` tinyint(1) NOT NULL,
  `Rightmenu_enable` tinyint(1) NOT NULL DEFAULT '0',
  `Maxnum` int(11) NOT NULL DEFAULT '1' COMMENT 'max number of articles to show at once in main page listing, 1 or 27 is good values... depending on blog use'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

