-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2013 at 09:25 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `interns_corner`
--

-- --------------------------------------------------------

--
-- Table structure for table `allumni`
--

CREATE TABLE IF NOT EXISTS `allumni` (
  `user_name` varchar(10) NOT NULL,
  `current_employee` text NOT NULL,
  `past_internship` text NOT NULL,
  `other_details` text NOT NULL,
  `other_emailid` text NOT NULL,
  PRIMARY KEY (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_area_of_intrest`
--

CREATE TABLE IF NOT EXISTS `alumni_area_of_intrest` (
  `user_name` varchar(10) NOT NULL,
  `area_of-intrest` varchar(25) NOT NULL,
  PRIMARY KEY (`user_name`,`area_of-intrest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_past_companies`
--

CREATE TABLE IF NOT EXISTS `alumni_past_companies` (
  `user_name` varchar(10) NOT NULL,
  `past_companies` varchar(25) NOT NULL,
  PRIMARY KEY (`user_name`,`past_companies`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `user_name` varchar(10) NOT NULL,
  `other_details` text NOT NULL,
  `project_details` text NOT NULL,
  PRIMARY KEY (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_area_of_expertise`
--

CREATE TABLE IF NOT EXISTS `faculty_area_of_expertise` (
  `user_name` varchar(10) NOT NULL,
  `area_of_expertise` varchar(25) NOT NULL,
  PRIMARY KEY (`user_name`,`area_of_expertise`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_area_of_intrest`
--

CREATE TABLE IF NOT EXISTS `faculty_area_of_intrest` (
  `user_name` varchar(10) NOT NULL,
  `area_of_intrest` varchar(25) NOT NULL,
  PRIMARY KEY (`user_name`,`area_of_intrest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `field`
--

CREATE TABLE IF NOT EXISTS `field` (
  `user_name` varchar(10) NOT NULL,
  `it` tinyint(1) NOT NULL,
  `el` tinyint(1) NOT NULL,
  `ct` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `opportunityid` varchar(20) NOT NULL,
  `formid` varchar(20) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  PRIMARY KEY (`formid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_attributes`
--

CREATE TABLE IF NOT EXISTS `form_attributes` (
  `formid` varchar(20) NOT NULL,
  `form_attribute1` text NOT NULL,
  `form_attribute2` text NOT NULL,
  `form_attribute3` text NOT NULL,
  `form_attribute4` text NOT NULL,
  `form_attribute5` text NOT NULL,
  PRIMARY KEY (`formid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_responses`
--

CREATE TABLE IF NOT EXISTS `form_responses` (
  `formid` varchar(20) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `form_attribute1` text NOT NULL,
  `form_attribute2` text NOT NULL,
  `form_attribute3` text NOT NULL,
  `form_attribute4` text NOT NULL,
  `form_attribute5` text NOT NULL,
  PRIMARY KEY (`formid`,`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `industrial_oopportunity`
--

CREATE TABLE IF NOT EXISTS `industrial_oopportunity` (
  `opportunityid` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `deadline_for_application` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `stipend` int(10) NOT NULL,
  `organization` text NOT NULL,
  `location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `opoortunity_votes`
--

CREATE TABLE IF NOT EXISTS `opoortunity_votes` (
  `opoportunityid` varchar(20) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `vote_tupe` int(11) NOT NULL,
  PRIMARY KEY (`opoportunityid`,`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `opportunity_comments`
--

CREATE TABLE IF NOT EXISTS `opportunity_comments` (
  `user_name` varchar(10) NOT NULL,
  `opoortunityid` varchar(20) NOT NULL,
  `commentid` varchar(20) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`commentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `opportunity_subscription`
--

CREATE TABLE IF NOT EXISTS `opportunity_subscription` (
  `user_name` varchar(10) NOT NULL,
  `opoportunityid` varchar(20) NOT NULL,
  PRIMARY KEY (`user_name`,`opoportunityid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `opportunity_tags`
--

CREATE TABLE IF NOT EXISTS `opportunity_tags` (
  `opportunityid` varchar(20) NOT NULL,
  `tagid` varchar(20) NOT NULL,
  PRIMARY KEY (`opportunityid`,`tagid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `postid` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text NOT NULL,
  `closed` tinyint(1) NOT NULL,
  PRIMARY KEY (`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_answer`
--

CREATE TABLE IF NOT EXISTS `post_answer` (
  `answerid` varchar(20) NOT NULL,
  `postid` varchar(20) NOT NULL,
  `answer` text NOT NULL,
  `user_name` varchar(10) NOT NULL,
  PRIMARY KEY (`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_answer_votes`
--

CREATE TABLE IF NOT EXISTS `post_answer_votes` (
  `answerid` varchar(20) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `vote_type` int(2) NOT NULL,
  PRIMARY KEY (`answerid`,`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE IF NOT EXISTS `post_comments` (
  `comment` text NOT NULL,
  `commentid` varchar(20) NOT NULL,
  `postid` varchar(20) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  PRIMARY KEY (`commentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_subscription`
--

CREATE TABLE IF NOT EXISTS `post_subscription` (
  `user_name` varchar(10) NOT NULL,
  `postid` varchar(10) NOT NULL,
  PRIMARY KEY (`user_name`,`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE IF NOT EXISTS `post_tags` (
  `postid` varchar(20) NOT NULL,
  `tagid` varchar(20) NOT NULL,
  PRIMARY KEY (`postid`,`tagid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_votes`
--

CREATE TABLE IF NOT EXISTS `post_votes` (
  `user_name` varchar(10) NOT NULL,
  `postid` varchar(20) NOT NULL,
  `vote_type` int(2) NOT NULL,
  PRIMARY KEY (`user_name`,`postid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `student_user_name` varchar(10) NOT NULL,
  `faculty_user_name` varchar(10) NOT NULL,
  `rating` int(10) NOT NULL,
  PRIMARY KEY (`student_user_name`,`faculty_user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `registration_details`
--

CREATE TABLE IF NOT EXISTS `registration_details` (
  `user_name` varchar(10) NOT NULL,
  `emailid` varchar(25) NOT NULL,
  `activation_code` int(10) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`user_name`),
  UNIQUE KEY `emailid` (`emailid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `research_oopportunity`
--

CREATE TABLE IF NOT EXISTS `research_oopportunity` (
  `opportunityid` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `deadline_for_application` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `stipend` int(10) NOT NULL,
  `organization` text NOT NULL,
  `location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `user_name` varchar(10) NOT NULL,
  `resourceid` varchar(10) NOT NULL,
  `resource` blob NOT NULL,
  PRIMARY KEY (`resourceid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rural_oopportunity`
--

CREATE TABLE IF NOT EXISTS `rural_oopportunity` (
  `opportunityid` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `deadline_for_application` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `stipend` int(10) NOT NULL,
  `organization` text NOT NULL,
  `location` text NOT NULL,
  PRIMARY KEY (`opportunityid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `user_name` varchar(10) NOT NULL,
  `avg_prof_rating` int(5) NOT NULL,
  `cpi` int(5) NOT NULL,
  `branch` varchar(10) NOT NULL,
  `other_emailid` varchar(20) NOT NULL,
  `other_details` varchar(250) NOT NULL,
  `resume` blob NOT NULL,
  `reputation` int(5) NOT NULL,
  PRIMARY KEY (`user_name`),
  UNIQUE KEY `other_emailid` (`other_emailid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_area_of_intrest`
--

CREATE TABLE IF NOT EXISTS `student_area_of_intrest` (
  `user_name` varchar(10) NOT NULL,
  `area_of_intrest` varchar(25) NOT NULL,
  PRIMARY KEY (`user_name`,`area_of_intrest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tag_table`
--

CREATE TABLE IF NOT EXISTS `tag_table` (
  `tagid` varchar(20) NOT NULL,
  `tag_name` varchar(30) NOT NULL,
  PRIMARY KEY (`tagid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_name` varchar(10) NOT NULL,
  `full_name` varchar(20) NOT NULL,
  `password` varchar(10) NOT NULL,
  `emailid` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `contact_details` varchar(250) DEFAULT NULL,
  `digest` tinyint(1) NOT NULL,
  `profile_complete` tinyint(1) NOT NULL,
  `branch` varchar(20) NOT NULL,
  PRIMARY KEY (`user_name`),
  UNIQUE KEY `emailid` (`emailid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_experince`
--

CREATE TABLE IF NOT EXISTS `user_experince` (
  `user_name` varchar(10) NOT NULL,
  `experinceid` int(10) NOT NULL,
  `experince_title` varchar(25) NOT NULL,
  `experince_description` varchar(100) NOT NULL,
  PRIMARY KEY (`experinceid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
