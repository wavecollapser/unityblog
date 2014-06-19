-- Default Unityblog 2.4-stable database
-- admin user / pw is admin/admin for logging in on top of blog
-- change yourself in mysql !!

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;

--
-- Dumping data for table `Articles`
--

INSERT INTO `Articles` (`ID`, `Date`, `Title`, `Text`, `LastUpdated`) VALUES
(1, '2014-04-28 00:00:00', 'EU anti terror logging is against human rights', '<b>EU (Danish) Data logging worries</b>\r\nData retention directive* is against EU human rights a judge ruled in <a href="http://curia.europa.eu/jcms/upload/docs/application/pdf/2014-04/cp140054en.pdf">EU court in April 2014</a>.\r\nNow Sweden has stopped all logging at every ISP due to this, so Denmark will hopefully be forced to follow soon.\r\n\r\nOutline of anti-terror logging:\r\n\r\n<span class=grey>Just like the NSA, only in EU this time</span>\r\nEU has been doing what the NSA does for a long time, since early 2007.\r\nIn EU every internet provider is logging all your data years back.\r\nPhone calls, emails, google searches, pictures you send ,...\r\nEverything gets saved, several years back.\r\n\r\n<span class=grey>Behind people''s back since 2006</span>\r\n You don''t know you are being logged. Only people who work at ISPs know that logging is being done. Every email, google search, phone call, every picture you send over the internet are being stored at your ISP, years back.\r\n\r\n<span class=grey>Security authorized personel handle your personal data</span>\r\n But in reality just regular employees with a short background check. Normal system administrators. Sometimes student-systemadministrators (part time employees).\r\n\r\n<span class=grey>Full logging, up to 100mbit and 1gbit lines</span>\r\n All data sent/received, all emails,phone calls,google searches.\r\n\r\n<span class=grey>Logging scripts</span>\r\n Developed by students, I''m sure your google searches are very safe. Scripts to extract your google searches for the last few years in 1 click, by typing your customer number. Internal ISP company joke used to be "let''s see what our new employee''s google searches is" they used to kid about that... The data logging has gone too far.\r\n\r\n Does it stop here? nope..\r\n\r\n<span class=light>Logging servers</span>\r\n Large logging servers / clusters of logging servers save all data you send/receive for the past x years\r\n +all phone calls fully\r\n Usually 5 years back, but sometimes only 1 year they say\r\n Where I worked it was usually over 5 years in practice they could see your data/google searches.\r\n\r\nRichard Stallman has been saying all the time that it is a violation of EU Human rights, but now there has been a court decision!\r\nHopefully this insane law will be removed soon.\r\nParanoid politicans trying to control everything. Name anything you don''t want the public to know ''anti-terror''.\r\n\r\nLogging without a warrant is against human rights, but the politicans don''t care about that it seems.\r\n', '0000-00-00 00:00:00');

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

--
-- Table structure for table `Categories`
--

CREATE TABLE IF NOT EXISTS `Categories` (
  `ID` int(11) NOT NULL,
  `Category` varchar(30) CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `Show_catlist` tinyint(1) NOT NULL DEFAULT '1',
  `Show_sitemap` tinyint(1) NOT NULL DEFAULT '1',
  `Show_hidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'for comments we dont want to show anywhere, but we want the text on our blog anyway'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`ID`, `Category`, `Show_catlist`, `Show_sitemap`, `Show_hidden`) VALUES
(46, 'Pictures', 1, 1, 0),
(41, 'Shamanism', 1, 1, 0),
(54, 'Pictures', 1, 1, 0),
(52, 'Pictures', 1, 1, 0),
(22, 'Pictures', 1, 1, 0),
(73, 'Physics', 1, 1, 0),
(73, 'Quantum Mechanics', 1, 1, 0),
(73, 'Simple', 1, 1, 0),
(73, 'Universe', 1, 1, 0),
(73, 'Balance', 1, 1, 0),
(72, 'Science', 1, 1, 0),
(72, 'Fun', 1, 1, 0),
(72, 'Philosophy', 1, 1, 0),
(72, 'Universe', 1, 1, 0),
(51, 'Pictures', 1, 1, 0),
(6, 'Pictures', 1, 1, 0),
(14, 'Pictures', 1, 1, 0),
(29, 'Buddhism', 1, 1, 0),
(29, 'Meditation', 1, 1, 0),
(29, 'Peace', 1, 1, 0),
(56, 'Peace', 1, 1, 0),
(56, 'Buddhism', 1, 1, 0),
(56, 'Meditation', 1, 1, 0),
(72, 'Quantum Mechanics', 1, 1, 0),
(72, 'Physics', 1, 1, 0),
(2, 'Politics', 1, 1, 0),
(2, 'Stallman', 1, 1, 0),
(3, 'Politics', 1, 1, 0),
(3, 'Stallman', 1, 1, 0),
(3, 'Youtube', 1, 1, 0),
(3, 'Facebook', 1, 1, 0),
(3, 'Surveilance', 1, 1, 0),
(3, 'Nsa', 1, 1, 0),
(4, 'Terence mckenna', 1, 1, 0),
(8, 'Physics', 1, 1, 0),
(9, 'Physics', 1, 1, 0),
(11, 'Quantum mechanics', 1, 1, 0),
(10, 'Lucid dreaming', 1, 1, 0),
(11, 'Physics', 1, 1, 0),
(16, 'Trance', 1, 1, 0),
(16, 'Psytrance', 1, 1, 0),
(17, 'Games', 1, 1, 0),
(82, 'C', 1, 1, 0),
(52, 'Nature', 1, 1, 0),
(54, 'Nature', 1, 1, 0),
(20, 'Debian', 1, 1, 0),
(39, 'Debian', 1, 1, 0),
(39, 'Linux', 1, 1, 0),
(20, 'System administration', 1, 1, 0),
(63, 'Fun', 1, 1, 0),
(17, 'Nostalgia', 1, 1, 0),
(51, 'Nature', 1, 1, 0),
(46, 'Nature', 1, 1, 0),
(34, 'Philosophy', 1, 1, 0),
(34, 'Physics', 1, 1, 0),
(59, 'Projects', 1, 1, 0),
(76, 'Debian', 1, 1, 0),
(76, 'Meditation', 1, 1, 0),
(76, 'Linux', 1, 1, 0),
(76, 'Stallman', 1, 1, 0),
(4, 'Philosophy', 1, 1, 0),
(4, 'Video', 1, 1, 0),
(78, 'Physics', 1, 1, 0),
(31, 'Linux', 1, 1, 0),
(31, 'Projects', 1, 1, 0),
(31, 'Electronics', 1, 1, 0),
(20, 'Sysadm', 1, 1, 0),
(30, 'Nostalgia', 1, 1, 0),
(25, 'Nostalgia', 1, 1, 0),
(81, 'Nostalgia', 1, 1, 0),
(21, 'Games', 1, 1, 0),
(82, 'Programming', 1, 1, 0),
(82, 'Linux', 1, 1, 0),
(83, 'Peace', 1, 1, 0),
(84, 'Nostalgia', 1, 1, 0),
(21, 'Nostalgia', 1, 1, 0),
(76, 'Gnu', 1, 1, 0),
(85, 'Nostalgia', 1, 1, 0),
(85, 'Danish', 1, 1, 0),
(85, 'Amiga', 1, 1, 0),
(24, 'Projects', 1, 1, 0),
(65, 'Projects', 1, 1, 0),
(38, 'Projects', 1, 1, 0),
(80, 'Projects', 1, 1, 0),
(79, 'Projects', 1, 1, 0),
(86, 'Projects', 1, 1, 0),
(87, 'Physics', 1, 1, 0),
(20, 'Linux', 1, 1, 0),
(20, 'Projects', 1, 1, 0),
(84, 'Mortal kombat amiga', 1, 1, 0),
(84, 'Workbench', 1, 1, 0),
(84, 'Amiga', 1, 1, 0),
(84, 'Pictures', 1, 1, 0),
(88, 'Geek stuff', 1, 1, 0),
(89, 'Geek stuff', 1, 1, 0),
(90, 'Geek stuff', 1, 1, 0),
(89, 'Gentoo', 1, 1, 0),
(89, 'Linux', 1, 1, 0),
(88, 'IRC', 1, 1, 0),
(88, 'Quakenet', 1, 1, 0),
(91, 'Art', 1, 1, 0),
(91, 'Nature', 1, 1, 0),
(11, 'Philosophy', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `CategoryID`
--

CREATE TABLE IF NOT EXISTS `CategoryID` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Category` varchar(30) CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `Show` tinyint(1) NOT NULL DEFAULT '1',
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `CategoryID`
--

INSERT INTO `CategoryID` (`ID`, `Category`, `Show`, `Created`) VALUES
(1, 'Nostalgia', 1, '0000-00-00 00:00:00'),
(2, 'Danish', 1, '0000-00-00 00:00:00'),
(3, 'Amiga', 1, '0000-00-00 00:00:00'),
(4, 'Pictures', 1, '0000-00-00 00:00:00'),
(5, 'Shamanism', 1, '0000-00-00 00:00:00'),
(6, 'Physics', 1, '0000-00-00 00:00:00'),
(7, 'Quantum Mechanics', 1, '0000-00-00 00:00:00'),
(8, 'Simple', 1, '0000-00-00 00:00:00'),
(9, 'Universe', 1, '0000-00-00 00:00:00'),
(10, 'Balance', 1, '0000-00-00 00:00:00'),
(11, 'Science', 1, '0000-00-00 00:00:00'),
(12, 'Fun', 1, '0000-00-00 00:00:00'),
(13, 'Philosophy', 1, '0000-00-00 00:00:00'),
(14, 'Buddhism', 1, '0000-00-00 00:00:00'),
(15, 'Meditation', 1, '0000-00-00 00:00:00'),
(16, 'Peace', 1, '0000-00-00 00:00:00'),
(17, 'Politics', 1, '0000-00-00 00:00:00'),
(18, 'Stallman', 1, '0000-00-00 00:00:00'),
(19, 'Youtube', 1, '0000-00-00 00:00:00'),
(20, 'Facebook', 1, '0000-00-00 00:00:00'),
(21, 'Surveilance', 1, '0000-00-00 00:00:00'),
(22, 'Nsa', 1, '0000-00-00 00:00:00'),
(23, 'Terence mckenna', 1, '0000-00-00 00:00:00'),
(24, 'Lucid dreaming', 1, '0000-00-00 00:00:00'),
(25, 'Trance', 1, '0000-00-00 00:00:00'),
(26, 'Psytrance', 1, '0000-00-00 00:00:00'),
(27, 'Games', 1, '0000-00-00 00:00:00'),
(28, 'C', 1, '0000-00-00 00:00:00'),
(29, 'Nature', 1, '0000-00-00 00:00:00'),
(30, 'Linux', 1, '0000-00-00 00:00:00'),
(31, 'Sysadm', 1, '0000-00-00 00:00:00'),
(32, 'System administration', 1, '0000-00-00 00:00:00'),
(33, 'Debian', 1, '0000-00-00 00:00:00'),
(34, 'Movies', 1, '0000-00-00 00:00:00'),
(36, 'Video', 1, '0000-00-00 00:00:00'),
(37, 'Projects', 1, '0000-00-00 00:00:00'),
(38, 'Electronics', 1, '0000-00-00 00:00:00'),
(39, 'Programming', 1, '0000-00-00 00:00:00'),
(41, 'Workbench', 1, '0000-00-00 00:00:00'),
(42, 'Mortal kombat amiga', 1, '0000-00-00 00:00:00'),
(43, 'Gnu', 1, '0000-00-00 00:00:00'),
(45, 'Geek stuff', 1, '2014-06-15 16:52:00'),
(46, 'Gentoo', 1, '2014-06-15 20:00:49'),
(47, 'IRC', 1, '2014-06-15 20:01:08'),
(48, 'Quakenet', 1, '2014-06-15 20:01:08'),
(49, 'Art', 1, '2014-06-15 21:50:09');

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nick` varchar(30) NOT NULL,
  `Date` date NOT NULL,
  `Website` varchar(50) NOT NULL,
  `IP` text NOT NULL,
  `Comment` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`ID`, `Nick`, `Date`, `Website`, `IP`, `Comment`) VALUES
(1, 'mio', '2014-04-24', '', '', 'testing 1 file blog, no mysql etc., vim creation of blog entries\r\nhttp is turned into links, newlines is turned into br''s with php'),
(3, 'Johnc703', '2014-05-30', '', '', 'Outstanding post, I conceive people should acquire a lot from this web blog its rattling user genial. So much superb info on here bdfagedeadge'),
(4, 'Pharme602', '2014-05-31', '', '', 'Very nice site!'),
(22, 'hep', '2014-06-10', '', '81.161.188.225', 'hey'),
(23, 'fixme', '2014-06-14', '', '81.161.190.59', 'Featured links in categories  q2  tutorial'),
(24, 'ageg', '2014-06-16', '', '81.161.188.225', 'heyyy'),
(25, 'hshsh', '2014-06-16', '', '81.161.188.225', 'sdhadh');

-- --------------------------------------------------------

--
-- Table structure for table `Log`
--

CREATE TABLE IF NOT EXISTS `Log` (
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IP` text NOT NULL,
  `URL` varchar(60) NOT NULL,
  `Referer` varchar(60) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Log`
--

INSERT INTO `Log` (`Date`, `IP`, `URL`, `Referer`) VALUES
('2014-06-14 12:57:03', '81.161.188.225', '', 'http://rlogin.dk/blog/?listFiles');

-- --------------------------------------------------------

--
-- Table structure for table `Settings`
--

CREATE TABLE IF NOT EXISTS `Settings` (
  `Log_enable` tinyint(1) NOT NULL DEFAULT '1',
  `CSS_file` tinyint(1) NOT NULL,
  `Rightmenu_enable` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Settings`
--


