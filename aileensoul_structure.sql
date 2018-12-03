-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2018 at 06:17 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aileensoul`
--

-- --------------------------------------------------------

--
-- Table structure for table `ailee_admin`
--

CREATE TABLE IF NOT EXISTS `ailee_admin` (
  `admin_id` int(20) UNSIGNED NOT NULL,
  `admin_role` enum('1','2') NOT NULL COMMENT '1: admin 2: subadmin',
  `admin_username` varchar(100) NOT NULL DEFAULT '',
  `admin_password` varchar(100) NOT NULL DEFAULT '' COMMENT 'MD5 Password',
  `admin_email` varchar(100) NOT NULL,
  `admin_name` varchar(100) NOT NULL DEFAULT '',
  `admin_last_login` datetime NOT NULL,
  `admin_modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `admin_ip` varchar(22) NOT NULL,
  `admin_status` enum('1','2','3') NOT NULL COMMENT '1: publish 2:Unpublish 3: delete',
  `admin_image` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Admin Information';

-- --------------------------------------------------------

--
-- Table structure for table `ailee_advertise_with_us`
--

CREATE TABLE IF NOT EXISTS `ailee_advertise_with_us` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_date` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_artistic_post_comment`
--

CREATE TABLE IF NOT EXISTS `ailee_artistic_post_comment` (
  `artistic_post_comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `art_post_id` int(11) NOT NULL,
  `comments` text NOT NULL,
  `artistic_comment_likes_count` int(11) DEFAULT NULL,
  `artistic_comment_like_user` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `is_delete` int(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_art_category`
--

CREATE TABLE IF NOT EXISTS `ailee_art_category` (
  `category_id` int(11) NOT NULL,
  `art_category` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '1.active 0.deactive',
  `type` int(11) NOT NULL COMMENT '1.artistic',
  `category_slug` text NOT NULL,
  `art_category_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_art_comment_image_like`
--

CREATE TABLE IF NOT EXISTS `ailee_art_comment_image_like` (
  `image_comment_like_id` int(11) NOT NULL,
  `post_image_comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_unlike` enum('0','1') NOT NULL COMMENT '0.like,1.unlike'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_art_other_category`
--

CREATE TABLE IF NOT EXISTS `ailee_art_other_category` (
  `other_category_id` int(11) NOT NULL,
  `other_category` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '1.active 0.deactive',
  `is_delete` enum('0','1') NOT NULL COMMENT '0.not delete 1. delete',
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_art_post`
--

CREATE TABLE IF NOT EXISTS `ailee_art_post` (
  `art_post_id` int(11) NOT NULL,
  `art_post` varchar(255) DEFAULT NULL,
  `art_description` text,
  `user_id` int(11) NOT NULL,
  `art_likes_count` int(11) NOT NULL,
  `art_like_user` varchar(255) NOT NULL,
  `status` enum('1','0') NOT NULL,
  `created_date` datetime NOT NULL,
  `modifiled_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` enum('0','1') DEFAULT NULL,
  `delete_post` varchar(255) DEFAULT NULL,
  `posted_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_art_post_image_comment`
--

CREATE TABLE IF NOT EXISTS `ailee_art_post_image_comment` (
  `post_image_comment_id` int(11) NOT NULL,
  `post_image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_date` datetime NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_art_post_image_like`
--

CREATE TABLE IF NOT EXISTS `ailee_art_post_image_like` (
  `post_image_like_id` int(11) NOT NULL,
  `post_image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_unlike` enum('0','1') NOT NULL COMMENT '0: like 1 : dislike'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_art_reg`
--

CREATE TABLE IF NOT EXISTS `ailee_art_reg` (
  `art_id` int(11) NOT NULL,
  `art_name` varchar(50) NOT NULL,
  `art_lastname` varchar(255) NOT NULL,
  `art_email` varchar(60) NOT NULL,
  `art_phnno` varchar(20) NOT NULL,
  `art_country` int(11) NOT NULL,
  `art_state` int(11) NOT NULL,
  `art_city` int(11) DEFAULT NULL,
  `art_pincode` int(11) DEFAULT NULL,
  `art_address` text NOT NULL,
  `art_yourart` varchar(255) NOT NULL,
  `art_skill` varchar(255) NOT NULL COMMENT 'Art Category',
  `art_desc_art` text NOT NULL,
  `art_inspire` varchar(255) NOT NULL,
  `art_bestofmine` varchar(255) NOT NULL,
  `art_portfolio` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('1','0') NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` enum('0','1') NOT NULL,
  `art_step` enum('1','2','3','4') NOT NULL,
  `art_user_image` tinytext,
  `profile_background` text,
  `profile_background_main` text,
  `designation` varchar(255) DEFAULT NULL,
  `other_skill` text,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_art_reg_search_tmp`
--

CREATE TABLE IF NOT EXISTS `ailee_art_reg_search_tmp` (
  `art_id` int(11) NOT NULL,
  `art_name` varchar(50) NOT NULL,
  `art_lastname` varchar(255) NOT NULL,
  `art_email` varchar(60) NOT NULL,
  `art_phnno` varchar(20) NOT NULL,
  `art_country` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `art_state` int(11) NOT NULL,
  `state_name` varchar(255) NOT NULL,
  `art_city` int(11) DEFAULT NULL,
  `city_name` varchar(255) NOT NULL,
  `art_pincode` int(11) DEFAULT NULL,
  `art_address` text NOT NULL,
  `art_yourart` varchar(255) NOT NULL,
  `art_skill` varchar(255) NOT NULL COMMENT 'Art Category',
  `art_skill_txt` text NOT NULL,
  `art_desc_art` text NOT NULL,
  `art_inspire` varchar(255) NOT NULL,
  `art_bestofmine` varchar(255) NOT NULL,
  `art_portfolio` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('1','0') NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` enum('0','1') NOT NULL,
  `art_step` enum('1','2','3','4') NOT NULL,
  `art_user_image` tinytext,
  `profile_background` text,
  `profile_background_main` text,
  `designation` varchar(255) DEFAULT NULL,
  `other_skill` text,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_blog`
--

CREATE TABLE IF NOT EXISTS `ailee_blog` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL COMMENT 'Blog Creator Name',
  `blog_category_id` varchar(11) NOT NULL,
  `blog_related_id` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `tag` text NOT NULL,
  `image` text NOT NULL,
  `meta_description` varchar(160) NOT NULL,
  `description` longtext NOT NULL,
  `blog_slug` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('publish','draft','delete') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_blog_category`
--

CREATE TABLE IF NOT EXISTS `ailee_blog_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `status` enum('publish','draft','delete') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_blog_comment`
--

CREATE TABLE IF NOT EXISTS `ailee_blog_comment` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('approve','pending','reject') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_blog_guest`
--

CREATE TABLE IF NOT EXISTS `ailee_blog_guest` (
  `id_blog_guest` int(11) NOT NULL,
  `guest_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_jobtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_blog_tag`
--

CREATE TABLE IF NOT EXISTS `ailee_blog_tag` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `status` enum('publish','draft','delete') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_blog_visit`
--

CREATE TABLE IF NOT EXISTS `ailee_blog_visit` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `visiter_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_business_profile`
--

CREATE TABLE IF NOT EXISTS `ailee_business_profile` (
  `business_profile_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `country` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `city` int(11) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `address` text NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_mobile` varchar(15) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_website` varchar(255) NOT NULL,
  `business_type` int(5) DEFAULT NULL,
  `industriyal` int(5) DEFAULT NULL,
  `details` text NOT NULL,
  `addmore` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('1','2','0') NOT NULL,
  `is_deleted` enum('1','0') NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `business_step` enum('1','2','3','4','0') NOT NULL,
  `business_user_image` tinytext,
  `profile_background` text,
  `profile_background_main` text,
  `business_slug` text,
  `other_business_type` varchar(255) DEFAULT NULL,
  `other_industrial` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_business_profile_post`
--

CREATE TABLE IF NOT EXISTS `ailee_business_profile_post` (
  `business_profile_post_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_description` text CHARACTER SET utf8,
  `business_likes_count` int(11) NOT NULL,
  `business_like_user` text NOT NULL,
  `created_date` datetime NOT NULL,
  `status` enum('1','0') NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_post` text,
  `posted_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_business_profile_post_comment`
--

CREATE TABLE IF NOT EXISTS `ailee_business_profile_post_comment` (
  `business_profile_post_comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `business_profile_post_id` int(11) NOT NULL,
  `comments` text NOT NULL,
  `business_comment_likes_count` int(11) NOT NULL,
  `business_comment_like_user` text NOT NULL,
  `status` enum('1','0') NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_business_profile_save`
--

CREATE TABLE IF NOT EXISTS `ailee_business_profile_save` (
  `save_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `business_save` int(11) NOT NULL COMMENT '0:Unsave 1:Save',
  `business_delete` int(11) NOT NULL COMMENT '0:Not Delete 1:Delete',
  `is_delete` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_business_profile_search_tmp`
--

CREATE TABLE IF NOT EXISTS `ailee_business_profile_search_tmp` (
  `business_profile_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `country` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL,
  `state_name` varchar(255) NOT NULL,
  `city` int(11) DEFAULT NULL,
  `city_name` varchar(255) NOT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `address` text NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_mobile` varchar(15) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_website` varchar(255) NOT NULL,
  `business_type` int(5) DEFAULT NULL,
  `industriyal` int(5) DEFAULT NULL,
  `industry_name` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `addmore` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('1','2','0') NOT NULL,
  `is_deleted` enum('1','0') NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `business_step` enum('1','2','3','4','0') NOT NULL,
  `business_user_image` tinytext,
  `profile_background` text,
  `profile_background_main` text,
  `business_slug` text,
  `other_business_type` varchar(255) DEFAULT NULL,
  `other_industrial` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_business_type`
--

CREATE TABLE IF NOT EXISTS `ailee_business_type` (
  `type_id` int(11) NOT NULL,
  `business_name` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  `is_delete` int(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_bus_comment_image_like`
--

CREATE TABLE IF NOT EXISTS `ailee_bus_comment_image_like` (
  `image_comment_like_id` int(11) NOT NULL,
  `post_image_comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_unlike` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_bus_image`
--

CREATE TABLE IF NOT EXISTS `ailee_bus_image` (
  `bus_image_id` int(11) NOT NULL,
  `image_name` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `is_delete` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_bus_post_image_comment`
--

CREATE TABLE IF NOT EXISTS `ailee_bus_post_image_comment` (
  `post_image_comment_id` int(11) NOT NULL,
  `post_image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_bus_post_image_like`
--

CREATE TABLE IF NOT EXISTS `ailee_bus_post_image_like` (
  `post_image_like_id` int(11) NOT NULL,
  `post_image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_unlike` enum('0','1') NOT NULL COMMENT 'if click on like for same user and same image : 1-> dislike'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_bus_showvideo`
--

CREATE TABLE IF NOT EXISTS `ailee_bus_showvideo` (
  `id` int(11) NOT NULL,
  `post_files_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_category`
--

CREATE TABLE IF NOT EXISTS `ailee_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','2') NOT NULL COMMENT '"1 for admin and 2 for user addes"',
  `is_delete` enum('0','1') NOT NULL,
  `is_other` enum('0','1','2','') NOT NULL DEFAULT '0' COMMENT '''0 for admin,1 for apply,2 for hire''',
  `user_id` int(11) NOT NULL,
  `category_slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_cities`
--

CREATE TABLE IF NOT EXISTS `ailee_cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(30) NOT NULL,
  `city_image` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `status` enum('1','2','0') NOT NULL DEFAULT '1' COMMENT '0:Blocked, 1:Active, 2:New',
  `group_id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_college`
--

CREATE TABLE IF NOT EXISTS `ailee_college` (
  `college_id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `college_name` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `modify_date` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `is_delete` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_contact_person`
--

CREATE TABLE IF NOT EXISTS `ailee_contact_person` (
  `contact_id` int(11) NOT NULL,
  `contact_from_id` int(11) DEFAULT NULL COMMENT 'user id',
  `contact_to_id` int(11) DEFAULT NULL COMMENT 'user id',
  `contact_type` int(11) DEFAULT NULL COMMENT '1.art,2.business_profile',
  `created_date` datetime DEFAULT NULL,
  `modify_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('confirm','pending','reject','block','cancel','query') DEFAULT NULL,
  `contact_desc` text NOT NULL,
  `not_read` enum('0','1','2') NOT NULL COMMENT '1.read, 2.unraed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_contact_us`
--

CREATE TABLE IF NOT EXISTS `ailee_contact_us` (
  `contact_id` int(11) NOT NULL,
  `contact_name` varchar(50) NOT NULL,
  `contact_email` varchar(200) NOT NULL,
  `contact_subject` text NOT NULL,
  `contact_message` text NOT NULL,
  `contact_lastname` varchar(255) NOT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `is_delete` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_countries`
--

CREATE TABLE IF NOT EXISTS `ailee_countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:Blocked, 1:Active',
  `country_slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_currency`
--

CREATE TABLE IF NOT EXISTS `ailee_currency` (
  `currency_id` int(11) NOT NULL,
  `currency_name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `is_delete` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `currency_icon` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_degree`
--

CREATE TABLE IF NOT EXISTS `ailee_degree` (
  `degree_id` int(11) NOT NULL,
  `degree_name` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','2','0') NOT NULL COMMENT '1:Admin status 2:user_added status',
  `is_delete` enum('0','1') NOT NULL,
  `is_other` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1 for other degree',
  `user_id` int(11) NOT NULL COMMENT 'who is add this other degree',
  `post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_emails`
--

CREATE TABLE IF NOT EXISTS `ailee_emails` (
  `emailid` int(11) NOT NULL,
  `vartitle` text,
  `uniquename` varchar(765) DEFAULT NULL,
  `variables` text,
  `varsubject` varchar(765) DEFAULT NULL,
  `varmailformat` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email_status` enum('1','2','3','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_emails_seo`
--

CREATE TABLE IF NOT EXISTS `ailee_emails_seo` (
  `emailid` int(11) NOT NULL,
  `vartitle` text,
  `uniquename` varchar(765) DEFAULT NULL,
  `variables` text,
  `varsubject` varchar(765) DEFAULT NULL,
  `varmailformat` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email_status` enum('1','2','3','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_email_settings`
--

CREATE TABLE IF NOT EXISTS `ailee_email_settings` (
  `esetting_id` int(11) NOT NULL,
  `host_name` varchar(150) DEFAULT NULL,
  `out_going_port` varchar(765) DEFAULT NULL,
  `user_name` varchar(60) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `receiver_email` varchar(255) DEFAULT NULL,
  `esetting_modify_date` datetime NOT NULL,
  `esetting_ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_feedback`
--

CREATE TABLE IF NOT EXISTS `ailee_feedback` (
  `feedback_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL,
  `is_delete` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_feedback_general`
--

CREATE TABLE IF NOT EXISTS `ailee_feedback_general` (
  `id` int(11) NOT NULL,
  `feedback_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedback_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedback_screenshot` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_follow`
--

CREATE TABLE IF NOT EXISTS `ailee_follow` (
  `follow_id` int(11) NOT NULL,
  `follow_type` enum('1','2') DEFAULT NULL COMMENT '1: artistic 2: business profile',
  `follow_from` int(11) DEFAULT NULL,
  `follow_to` int(11) DEFAULT NULL,
  `follow_status` enum('0','1') DEFAULT NULL COMMENT '0: unfollow 1: follow'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_freelancer_apply`
--

CREATE TABLE IF NOT EXISTS `ailee_freelancer_apply` (
  `app_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('1','0') NOT NULL COMMENT '0:saved 1: not save',
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` enum('0','1') NOT NULL,
  `job_delete` enum('0','1') NOT NULL COMMENT '0:Apply 1:Not Apply',
  `job_save` enum('1','2','3','0') NOT NULL COMMENT '1:Apply 2:Save 3:Not Save'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_freelancer_hire_reg`
--

CREATE TABLE IF NOT EXISTS `ailee_freelancer_hire_reg` (
  `reg_id` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `skyupid` varchar(100) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `country` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `professional_info` text NOT NULL,
  `user_id` int(10) NOT NULL,
  `status` enum('1','0') NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `free_hire_step` enum('1','2','3','0') NOT NULL,
  `freelancer_hire_user_image` tinytext,
  `profile_background` text,
  `profile_background_main` text,
  `designation` varchar(255) DEFAULT NULL,
  `freelancer_hire_slug` text,
  `is_indivdual_company` enum('1','2') NOT NULL COMMENT '1- Individual, 2- Company',
  `comp_name` varchar(255) NOT NULL,
  `comp_number` varchar(20) NOT NULL,
  `comp_email` varchar(255) NOT NULL,
  `comp_website` varchar(255) NOT NULL,
  `company_field` int(11) NOT NULL,
  `company_other_field` varchar(255) NOT NULL,
  `company_country` int(11) NOT NULL,
  `company_state` int(11) NOT NULL,
  `company_city` int(11) NOT NULL,
  `comp_overview` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_freelancer_post`
--

CREATE TABLE IF NOT EXISTS `ailee_freelancer_post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_name` varchar(255) NOT NULL,
  `post_field_req` int(11) NOT NULL COMMENT 'ailee_category',
  `post_est_time` text NOT NULL,
  `post_skill` varchar(255) DEFAULT NULL,
  `post_exp_month` varchar(255) DEFAULT NULL,
  `post_exp_year` varchar(255) DEFAULT NULL,
  `post_other_skill` varchar(255) DEFAULT NULL,
  `post_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_rate` varchar(255) NOT NULL,
  `post_last_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_location` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','0') NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `post_currency` int(11) DEFAULT NULL,
  `post_rating_type` enum('1','2','0','') DEFAULT NULL COMMENT '1. Hourly 2. Fixed',
  `country` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `post_slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_freelancer_post_live`
--

CREATE TABLE IF NOT EXISTS `ailee_freelancer_post_live` (
  `post_id` int(11) NOT NULL,
  `post_name` varchar(255) NOT NULL,
  `post_field_req` varchar(255) NOT NULL,
  `post_est_time` text NOT NULL,
  `post_skill` varchar(255) DEFAULT NULL,
  `post_exp_month` varchar(255) DEFAULT NULL,
  `post_exp_year` varchar(255) DEFAULT NULL,
  `post_other_skill` varchar(255) DEFAULT NULL,
  `post_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_rate` varchar(255) NOT NULL,
  `post_last_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_location` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','0') NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `post_currency` int(11) DEFAULT NULL,
  `post_rating_type` enum('1','2','0','') DEFAULT NULL COMMENT '1. Hourly 2. Fixed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_freelancer_post_reg`
--

CREATE TABLE IF NOT EXISTS `ailee_freelancer_post_reg` (
  `freelancer_post_reg_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `freelancer_post_fullname` varchar(255) NOT NULL,
  `freelancer_post_username` varchar(255) NOT NULL,
  `freelancer_post_skypeid` varchar(255) NOT NULL,
  `freelancer_post_email` varchar(255) NOT NULL,
  `freelancer_post_phoneno` bigint(22) NOT NULL,
  `freelancer_post_country` int(11) NOT NULL,
  `freelancer_post_state` int(11) NOT NULL,
  `freelancer_post_city` int(11) NOT NULL,
  `freelancer_post_pincode` int(11) NOT NULL,
  `freelancer_post_field` int(11) NOT NULL,
  `freelancer_post_area` varchar(255) NOT NULL,
  `freelancer_post_skill_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `freelancer_post_hourly` int(11) NOT NULL,
  `freelancer_post_ratestate` int(11) NOT NULL,
  `freelancer_post_fixed_rate` int(11) DEFAULT '0',
  `freelancer_post_job_type` varchar(255) DEFAULT NULL,
  `freelancer_post_work_hour` int(11) DEFAULT NULL,
  `freelancer_post_degree` int(11) NOT NULL,
  `freelancer_post_stream` int(11) NOT NULL,
  `freelancer_post_univercity` int(11) NOT NULL,
  `freelancer_post_collage` varchar(255) NOT NULL,
  `freelancer_post_percentage` varchar(255) NOT NULL,
  `freelancer_post_passingyear` int(11) NOT NULL,
  `freelancer_post_portfolio_attachment` varchar(255) DEFAULT NULL,
  `freelancer_post_portfolio` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','0','','') NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `free_post_step` enum('1','2','3','4','5','6','7','0') NOT NULL,
  `freelancer_post_user_image` tinytext,
  `profile_background` text,
  `profile_background_main` text,
  `designation` varchar(255) DEFAULT NULL,
  `freelancer_post_otherskill` varchar(255) DEFAULT NULL,
  `freelancer_post_exp_month` varchar(255) DEFAULT NULL,
  `freelancer_post_exp_year` varchar(255) DEFAULT NULL,
  `freelancer_apply_slug` varchar(255) DEFAULT NULL,
  `progressbar` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_freelancer_post_reg_search_tmp`
--

CREATE TABLE IF NOT EXISTS `ailee_freelancer_post_reg_search_tmp` (
  `freelancer_post_reg_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `freelancer_post_fullname` varchar(255) NOT NULL,
  `freelancer_post_username` varchar(255) NOT NULL,
  `freelancer_post_skypeid` varchar(255) NOT NULL,
  `freelancer_post_email` varchar(255) NOT NULL,
  `freelancer_post_phoneno` bigint(22) NOT NULL,
  `freelancer_post_country` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `freelancer_post_state` int(11) NOT NULL,
  `state_name` varchar(255) NOT NULL,
  `freelancer_post_city` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `freelancer_post_pincode` int(11) NOT NULL,
  `freelancer_post_field` int(11) NOT NULL COMMENT 'Category Id',
  `freelancer_post_field_txt` varchar(255) NOT NULL COMMENT 'Category Name',
  `freelancer_post_area` varchar(255) NOT NULL COMMENT 'Skill Id',
  `freelancer_post_area_txt` varchar(255) NOT NULL COMMENT 'Skill Name',
  `freelancer_post_skill_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `freelancer_post_hourly` int(11) NOT NULL,
  `freelancer_post_ratestate` int(11) NOT NULL,
  `freelancer_post_fixed_rate` int(11) DEFAULT '0',
  `freelancer_post_job_type` varchar(255) DEFAULT NULL,
  `freelancer_post_work_hour` int(11) DEFAULT NULL,
  `freelancer_post_degree` int(11) NOT NULL,
  `freelancer_post_stream` int(11) NOT NULL,
  `freelancer_post_univercity` int(11) NOT NULL,
  `freelancer_post_collage` varchar(255) NOT NULL,
  `freelancer_post_percentage` varchar(255) NOT NULL,
  `freelancer_post_passingyear` int(11) NOT NULL,
  `freelancer_post_portfolio_attachment` varchar(255) DEFAULT NULL,
  `freelancer_post_portfolio` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','0','','') NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `free_post_step` enum('1','2','3','4','5','6','7','0') NOT NULL,
  `freelancer_post_user_image` tinytext,
  `profile_background` text,
  `profile_background_main` text,
  `designation` varchar(255) DEFAULT NULL,
  `freelancer_post_otherskill` varchar(255) DEFAULT NULL,
  `freelancer_post_exp_month` varchar(255) DEFAULT NULL,
  `freelancer_post_exp_year` varchar(255) DEFAULT NULL,
  `freelancer_apply_slug` varchar(255) DEFAULT NULL,
  `progressbar` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_freelancer_post_search_tmp`
--

CREATE TABLE IF NOT EXISTS `ailee_freelancer_post_search_tmp` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_name` varchar(255) NOT NULL,
  `post_field_req` int(11) NOT NULL COMMENT 'ailee_category',
  `category_name` varchar(255) NOT NULL,
  `post_est_time` text NOT NULL,
  `post_skill` varchar(255) DEFAULT NULL,
  `post_skill_txt` text NOT NULL,
  `post_exp_month` varchar(255) DEFAULT NULL,
  `post_exp_year` varchar(255) DEFAULT NULL,
  `post_other_skill` varchar(255) DEFAULT NULL,
  `post_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_rate` varchar(255) NOT NULL,
  `post_last_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_location` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','0') NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `post_currency` int(11) DEFAULT NULL,
  `currency_name` varchar(255) NOT NULL,
  `post_rating_type` enum('1','2','0','') DEFAULT NULL COMMENT '1. Hourly 2. Fixed',
  `country` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `post_slug` varchar(255) DEFAULT NULL,
  `country_name` varchar(255) NOT NULL,
  `state_name` varchar(255) NOT NULL,
  `city_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_freelancer_review`
--

CREATE TABLE IF NOT EXISTS `ailee_freelancer_review` (
  `id_review` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL COMMENT 'who rated by other / opposite user',
  `from_user_id` int(11) NOT NULL COMMENT 'who give rating / login user',
  `review_star` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_gov_category`
--

CREATE TABLE IF NOT EXISTS `ailee_gov_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','2') NOT NULL COMMENT '1.publish,2.draft',
  `is_delete` enum('0','1') NOT NULL COMMENT '0.not delete,2.delete'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_gov_post`
--

CREATE TABLE IF NOT EXISTS `ailee_gov_post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL COMMENT 'government category id',
  `post_name` varchar(255) NOT NULL,
  `no_vacancies` varchar(255) NOT NULL,
  `pay_scale` varchar(255) NOT NULL,
  `job_location` varchar(255) NOT NULL,
  `req_exp` varchar(255) NOT NULL,
  `post_image` text NOT NULL,
  `sector` varchar(255) NOT NULL,
  `eligibility` varchar(255) NOT NULL,
  `last_date` datetime NOT NULL,
  `description` text NOT NULL,
  `apply_link` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('1','2') NOT NULL COMMENT '1;publish,2:draft',
  `is_delete` enum('0','1') NOT NULL COMMENT '0:not-delete,1:delete'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_industry_type`
--

CREATE TABLE IF NOT EXISTS `ailee_industry_type` (
  `industry_id` int(10) NOT NULL,
  `type_id` text NOT NULL,
  `industry_name` varchar(200) NOT NULL,
  `status` enum('1','0') NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `industry_slug` text NOT NULL,
  `industry_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_add_edu`
--

CREATE TABLE IF NOT EXISTS `ailee_job_add_edu` (
  `edu_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `board_primary` varchar(255) DEFAULT NULL,
  `school_primary` varchar(255) DEFAULT NULL,
  `percentage_primary` float DEFAULT NULL,
  `pass_year_primary` int(11) DEFAULT NULL,
  `edu_certificate_primary` tinytext,
  `board_secondary` varchar(255) DEFAULT NULL,
  `school_secondary` varchar(255) DEFAULT NULL,
  `percentage_secondary` float DEFAULT NULL,
  `pass_year_secondary` int(11) DEFAULT NULL,
  `edu_certificate_secondary` text,
  `board_higher_secondary` varchar(255) DEFAULT NULL,
  `stream_higher_secondary` varchar(255) DEFAULT NULL,
  `school_higher_secondary` varchar(255) DEFAULT NULL,
  `percentage_higher_secondary` text,
  `pass_year_higher_secondary` int(11) DEFAULT NULL,
  `edu_certificate_higher_secondary` text,
  `degree` int(11) DEFAULT NULL,
  `stream` int(11) DEFAULT NULL,
  `university` int(11) DEFAULT NULL,
  `college` text,
  `grade` text,
  `percentage` float DEFAULT NULL,
  `pass_year` int(11) DEFAULT NULL,
  `edu_certificate` text,
  `degree_sequence` varchar(255) DEFAULT NULL,
  `stream_sequence` varchar(255) DEFAULT NULL,
  `status` enum('1','0') DEFAULT NULL COMMENT '1:Active 0:Deactive',
  `is_delete` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_add_workexp`
--

CREATE TABLE IF NOT EXISTS `ailee_job_add_workexp` (
  `work_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `experience_year` varchar(255) DEFAULT NULL,
  `experience_month` varchar(255) DEFAULT NULL,
  `jobtitle` varchar(255) DEFAULT NULL,
  `companyname` varchar(255) DEFAULT NULL,
  `companyemail` varchar(255) DEFAULT NULL,
  `companyphn` varchar(255) DEFAULT NULL,
  `work_certificate` varchar(255) DEFAULT NULL,
  `status` enum('1','0') DEFAULT NULL COMMENT '1:Active 0:Deactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_apply`
--

CREATE TABLE IF NOT EXISTS `ailee_job_apply` (
  `app_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('1','0') NOT NULL COMMENT '0:saved 1: not save',
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` enum('0','1') NOT NULL,
  `job_delete` enum('0','1') NOT NULL COMMENT '0:Apply 1:Not Apply',
  `job_save` enum('1','2','3') NOT NULL COMMENT '1:Apply 2:Save 3:Not Save'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_graduation`
--

CREATE TABLE IF NOT EXISTS `ailee_job_graduation` (
  `job_graduation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `degree` int(11) NOT NULL,
  `stream` int(11) NOT NULL,
  `university` int(11) NOT NULL,
  `college` text NOT NULL,
  `grade` text NOT NULL,
  `percentage` float NOT NULL,
  `pass_year` int(11) NOT NULL,
  `edu_certificate` text NOT NULL,
  `degree_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_industry`
--

CREATE TABLE IF NOT EXISTS `ailee_job_industry` (
  `industry_id` int(11) NOT NULL,
  `industry_name` varchar(256) NOT NULL,
  `industry_image` varchar(255) NOT NULL,
  `status` enum('1','0','2') NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `is_other` enum('0','1') NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `industry_slug` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_reg`
--

CREATE TABLE IF NOT EXISTS `ailee_job_reg` (
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phnno` varchar(255) NOT NULL,
  `marital_status` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `pincode` int(11) DEFAULT NULL,
  `address` text NOT NULL,
  `country_permenant` int(11) DEFAULT NULL,
  `state_permenant` int(11) DEFAULT NULL,
  `city_permenant` int(11) DEFAULT NULL,
  `pincode_permenant` int(11) DEFAULT NULL,
  `address_permenant` text,
  `project_name` varchar(255) DEFAULT NULL,
  `project_duration` varchar(255) DEFAULT NULL,
  `project_description` text,
  `training_as` varchar(255) DEFAULT NULL,
  `training_duration` varchar(255) DEFAULT NULL,
  `training_organization` varchar(255) DEFAULT NULL,
  `keyskill` varchar(255) NOT NULL,
  `other_skill` text,
  `ApplyFor` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
  `exp_m` text,
  `exp_y` text,
  `curricular` text NOT NULL,
  `interest` text NOT NULL,
  `reference` text NOT NULL,
  `carrier` text NOT NULL,
  `is_delete` int(11) NOT NULL COMMENT '0:not deleted 1:deleted',
  `status` int(11) NOT NULL COMMENT '1:Active 0:Deactive',
  `created_date` timestamp NULL DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `job_step` int(11) NOT NULL,
  `job_user_image` tinytext NOT NULL,
  `profile_background` text,
  `profile_background_main` text,
  `designation` varchar(255) DEFAULT NULL,
  `declaration` varchar(20) NOT NULL,
  `work_job_title` text NOT NULL,
  `work_job_industry` text NOT NULL,
  `work_job_other_industry` text NOT NULL,
  `work_job_city` text NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `progressbar` enum('0','1') NOT NULL COMMENT '0:Not 100%,1:100%',
  `user_skills` text NOT NULL,
  `user_hobbies` text NOT NULL,
  `user_software` text NOT NULL,
  `user_resume` varchar(255) NOT NULL,
  `user_professional_summary` text NOT NULL,
  `user_passion` text NOT NULL,
  `field` int(11) NOT NULL DEFAULT '-1',
  `other_field` varchar(255) NOT NULL,
  `preferred_travel` enum('1','2','3','4') NOT NULL,
  `preferred_cmp_culture` varchar(255) NOT NULL,
  `preferred_work_time` varchar(255) NOT NULL,
  `exp_salary_amt` varchar(255) NOT NULL,
  `exp_salary_currency` int(11) NOT NULL,
  `exp_salary_worktype` enum('0','1','2','3') NOT NULL COMMENT '0-Not Define,1-Per hour,2-Monthly,3-Yearly',
  `job_active_status` enum('0','1','2','3') NOT NULL COMMENT '1-I am Actively looking for Job, 2-I am Passively looking for Job, 3-I am not looking for a job.',
  `preferred_moredetail` text NOT NULL,
  `progress_new` enum('0','1') NOT NULL COMMENT '0:Not 100%,1:100%'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_reg_search_tmp`
--

CREATE TABLE IF NOT EXISTS `ailee_job_reg_search_tmp` (
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phnno` varchar(255) NOT NULL,
  `marital_status` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `state_name` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `pincode` int(11) DEFAULT NULL,
  `address` text NOT NULL,
  `country_permenant` int(11) DEFAULT NULL,
  `state_permenant` int(11) DEFAULT NULL,
  `city_permenant` int(11) DEFAULT NULL,
  `pincode_permenant` int(11) DEFAULT NULL,
  `address_permenant` text,
  `project_name` varchar(255) DEFAULT NULL,
  `project_duration` varchar(255) DEFAULT NULL,
  `project_description` text,
  `training_as` varchar(255) DEFAULT NULL,
  `training_duration` varchar(255) DEFAULT NULL,
  `training_organization` varchar(255) DEFAULT NULL,
  `keyskill` varchar(255) NOT NULL,
  `keyskill_txt` varchar(255) NOT NULL,
  `other_skill` text,
  `ApplyFor` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
  `exp_m` text,
  `exp_y` text,
  `curricular` text NOT NULL,
  `interest` text NOT NULL,
  `reference` text NOT NULL,
  `carrier` text NOT NULL,
  `is_delete` int(11) NOT NULL COMMENT '0:not deleted 1:deleted',
  `status` int(11) NOT NULL COMMENT '1:Active 0:Deactive',
  `created_date` timestamp NULL DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `job_step` int(11) NOT NULL,
  `job_user_image` tinytext NOT NULL,
  `profile_background` text,
  `profile_background_main` text,
  `designation` varchar(255) DEFAULT NULL,
  `declaration` varchar(20) NOT NULL,
  `work_job_title` text NOT NULL,
  `work_job_title_txt` varchar(255) NOT NULL,
  `work_job_industry` text NOT NULL,
  `work_job_industry_txt` varchar(255) NOT NULL,
  `work_job_other_industry` text NOT NULL,
  `work_job_city` text NOT NULL,
  `work_job_city_txt` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `progressbar` enum('0','1') NOT NULL COMMENT '0:Not 100%,1:100%'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_title`
--

CREATE TABLE IF NOT EXISTS `ailee_job_title` (
  `title_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `job_title_img` varchar(255) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('publish','draft','delete') NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_user_addicourse`
--

CREATE TABLE IF NOT EXISTS `ailee_job_user_addicourse` (
  `id_addicourse` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `addicourse_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addicourse_org` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addicourse_start_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addicourse_end_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addicourse_url` varbinary(255) NOT NULL,
  `addicourse_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_user_award`
--

CREATE TABLE IF NOT EXISTS `ailee_job_user_award` (
  `id_award` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `award_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `award_org` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `award_date` date NOT NULL,
  `award_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `award_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_user_education`
--

CREATE TABLE IF NOT EXISTS `ailee_job_user_education` (
  `id_education` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `edu_school_college` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_university` int(11) NOT NULL,
  `edu_other_university` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_degree` int(11) NOT NULL,
  `edu_other_degree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_stream` int(11) NOT NULL,
  `edu_other_stream` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_start_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_end_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_nograduate` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_user_experience`
--

CREATE TABLE IF NOT EXISTS `ailee_job_user_experience` (
  `id_experience` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exp_company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_company_website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_field` int(11) NOT NULL,
  `exp_other_field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_country` int(11) NOT NULL,
  `exp_state` int(11) NOT NULL,
  `exp_city` int(11) NOT NULL,
  `exp_start_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_end_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_isworking` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_user_extra_activity`
--

CREATE TABLE IF NOT EXISTS `ailee_job_user_extra_activity` (
  `id_extra_activity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_participate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_org` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_start_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_end_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_user_languages`
--

CREATE TABLE IF NOT EXISTS `ailee_job_user_languages` (
  `user_id` int(11) NOT NULL,
  `language_txt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proficiency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_user_links`
--

CREATE TABLE IF NOT EXISTS `ailee_job_user_links` (
  `user_id` int(11) NOT NULL,
  `user_links_txt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_links_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Facebook,Google,Instagram,LinkedIn,Pinterest,GitHub,Twitter,Personal',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_user_patent`
--

CREATE TABLE IF NOT EXISTS `ailee_job_user_patent` (
  `id_patent` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `patent_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patent_creator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patent_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patent_date` date NOT NULL,
  `patent_office` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patent_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patent_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `patent_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_user_projects`
--

CREATE TABLE IF NOT EXISTS `ailee_job_user_projects` (
  `id_projects` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_team` int(11) NOT NULL,
  `project_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_skills` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_field` int(11) NOT NULL,
  `project_other_field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_partner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_start_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_end_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_user_publication`
--

CREATE TABLE IF NOT EXISTS `ailee_job_user_publication` (
  `id_publication` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pub_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pub_author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pub_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pub_publisher` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pub_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pub_date` date NOT NULL,
  `pub_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_job_user_research`
--

CREATE TABLE IF NOT EXISTS `ailee_job_user_research` (
  `id_research` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `research_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `research_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `research_field` int(11) NOT NULL,
  `research_other_field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `research_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `research_publish_date` date NOT NULL,
  `research_document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_language`
--

CREATE TABLE IF NOT EXISTS `ailee_language` (
  `language_id` int(11) NOT NULL,
  `language_name` varchar(50) NOT NULL,
  `status` enum('1','0') NOT NULL COMMENT '0:Blocked, 1:Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_messages`
--

CREATE TABLE IF NOT EXISTS `ailee_messages` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `message_file` text NOT NULL,
  `message_file_size` varchar(255) NOT NULL,
  `message_file_type` enum('','image','audio','video','pdf') NOT NULL,
  `timestamp` int(11) NOT NULL,
  `message_from` int(11) NOT NULL,
  `message_to` int(11) NOT NULL,
  `message_from_profile` enum('1','2','3','4','5','6','7') NOT NULL COMMENT '1:job 2:recruiter 3:freelancer hire 4: freelancer apply post 5: business profile 6: artistic',
  `message_from_profile_id` int(11) NOT NULL,
  `message_to_profile` enum('1','2','3','4','5','6','7') NOT NULL COMMENT '1:job 2:recruiter 3:freelancer hire 4: freelancer apply post 5: business profile 6: artistic',
  `message_to_profile_id` int(11) NOT NULL,
  `is_read` enum('0','1') NOT NULL COMMENT '1:read 0: not read',
  `is_message_from_delete` int(1) NOT NULL,
  `is_message_to_delete` int(1) NOT NULL,
  `is_deleted` enum('0','1') NOT NULL COMMENT '1: delete 0:not delete'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_notification`
--

CREATE TABLE IF NOT EXISTS `ailee_notification` (
  `not_id` int(11) NOT NULL,
  `not_type` enum('1','2','3','4','5','6','7','8','9','10','11') NOT NULL COMMENT '1: request, 2:chat message ,3: apply ,4: save ,5: like ,6: comment ,7; contactus ,8: follow ,9: Shortlisted, 10:Artilce accept, 11:Artilce reject',
  `not_from_id` int(11) NOT NULL COMMENT 'sender 1: admin 2:company 3:client 4: Driver',
  `not_to_id` int(11) NOT NULL COMMENT 'receiver 1: admin 2:company 3:client 4: Driver',
  `not_read` int(1) NOT NULL COMMENT '1: read 2: un read',
  `not_status` int(1) NOT NULL COMMENT '1: Approve 3:Reject',
  `not_product_id` int(11) DEFAULT NULL,
  `not_from` int(2) DEFAULT NULL COMMENT '1:Recruiter ,2:Job ,3:Artist ,4:Freelancer Work ,5:Freelancer Hire ,6:Business Profile ,7:Opportunity ,8:Article',
  `not_active` int(1) NOT NULL COMMENT '1. unread 2. active',
  `not_img` int(1) NOT NULL COMMENT '0-postlike, 1-imglike,2-postcommentlike,3-imgcommentlike',
  `not_created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_pages`
--

CREATE TABLE IF NOT EXISTS `ailee_pages` (
  `page_id` int(11) NOT NULL,
  `page_name` varchar(100) NOT NULL,
  `page_title` varchar(200) NOT NULL,
  `short_description` text NOT NULL,
  `page_description` text CHARACTER SET utf8 NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '0',
  `seo_title` text NOT NULL,
  `seo_keywords` varchar(1000) NOT NULL,
  `seo_description` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `page_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_post_article`
--

CREATE TABLE IF NOT EXISTS `ailee_post_article` (
  `id_post_article` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('publish','draft','delete','reject') COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_desc_old` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_featured_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_meta_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_meta_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_main_category` int(11) NOT NULL,
  `article_sub_category` int(11) NOT NULL,
  `article_other_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `article_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_post_article_media`
--

CREATE TABLE IF NOT EXISTS `ailee_post_article_media` (
  `id` int(11) NOT NULL,
  `post_article_id` int(11) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_post_files`
--

CREATE TABLE IF NOT EXISTS `ailee_post_files` (
  `post_files_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `insert_profile` enum('1','2') DEFAULT NULL COMMENT '1.artistic, 2.business_profile',
  `post_format` enum('image','video','audio','pdf') NOT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` enum('0','1') DEFAULT NULL COMMENT '1: deleted image',
  `modify_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_recruiter`
--

CREATE TABLE IF NOT EXISTS `ailee_recruiter` (
  `rec_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rec_firstname` varchar(255) NOT NULL,
  `rec_lastname` varchar(255) NOT NULL,
  `rec_email` text NOT NULL,
  `rec_job_title` int(11) NOT NULL COMMENT 'job title',
  `rec_phone` bigint(22) NOT NULL,
  `re_status` int(11) NOT NULL COMMENT '0: inactive 1: active',
  `is_delete` int(11) NOT NULL COMMENT '0: not deleted 1: deleted',
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `re_comp_name` text,
  `re_comp_email` text NOT NULL,
  `re_comp_phone` bigint(22) NOT NULL,
  `re_comp_site` text NOT NULL,
  `re_comp_size` int(11) NOT NULL,
  `re_comp_field` int(11) NOT NULL DEFAULT '-1',
  `re_comp_other_field` varchar(255) NOT NULL,
  `re_comp_culture` int(11) NOT NULL COMMENT '1- Others,2- Traditional,3- Corporate,4- Start,5- Free Spirit,6- Don\\''t Specify',
  `re_comp_country` int(11) NOT NULL,
  `re_comp_state` int(11) NOT NULL,
  `re_comp_city` int(11) NOT NULL,
  `re_comp_profile` text,
  `re_comp_other_activity` text NOT NULL,
  `comp_logo` text,
  `re_step` int(11) NOT NULL,
  `re_comp_sector` text,
  `re_comp_activities` text NOT NULL,
  `recruiter_user_image` tinytext,
  `profile_background` text,
  `profile_background_main` text,
  `designation` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `rec_field` int(11) DEFAULT '-1',
  `rec_other_field` varchar(255) NOT NULL,
  `rec_skills` varchar(255) NOT NULL,
  `rec_role_res` varchar(255) NOT NULL,
  `rec_hire_level` int(11) DEFAULT NULL,
  `rec_exp_year` int(11) NOT NULL,
  `rec_exp_month` int(11) NOT NULL,
  `progress` enum('0','1') NOT NULL COMMENT '0:Not 100%,1:100%'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_rec_post`
--

CREATE TABLE IF NOT EXISTS `ailee_rec_post` (
  `post_id` int(11) NOT NULL,
  `post_name` varchar(255) NOT NULL,
  `post_description` text NOT NULL,
  `post_skill` text,
  `post_position` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` enum('0','1') NOT NULL,
  `post_last_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `min_year` float DEFAULT NULL,
  `interview_process` text NOT NULL,
  `min_sal` text,
  `max_sal` text,
  `country` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `other_skill` text,
  `max_year` float DEFAULT NULL,
  `fresher` int(11) DEFAULT '0',
  `post_currency` int(11) DEFAULT NULL,
  `degree_name` text,
  `industry_type` text,
  `emp_type` varchar(256) DEFAULT NULL,
  `salary_type` varchar(256) DEFAULT NULL,
  `hiring_level` int(11) NOT NULL COMMENT '1-Intern, 2-Entry-level, 3-Associate, 4-Mid-senior, 5-Director, 6-Executive',
  `comp_name` varchar(255) NOT NULL,
  `comp_url` varchar(255) NOT NULL,
  `comp_schedule` enum('0','1','2','3') NOT NULL COMMENT '0-No,1-Day,2-Night,3-Flexible',
  `comp_profile` text NOT NULL,
  `comp_logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_rec_post_login`
--

CREATE TABLE IF NOT EXISTS `ailee_rec_post_login` (
  `post_id` int(11) NOT NULL,
  `post_name` varchar(255) NOT NULL,
  `post_description` text NOT NULL,
  `post_skill` text,
  `post_position` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` enum('0','1') NOT NULL,
  `post_last_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `min_year` float DEFAULT NULL,
  `interview_process` text NOT NULL,
  `min_sal` text,
  `max_sal` text,
  `country` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `other_skill` text,
  `max_year` float DEFAULT NULL,
  `fresher` int(11) DEFAULT '0',
  `post_currency` int(11) DEFAULT NULL,
  `degree_name` text,
  `industry_type` text,
  `emp_type` varchar(256) DEFAULT NULL,
  `salary_type` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_rec_post_search_tmp`
--

CREATE TABLE IF NOT EXISTS `ailee_rec_post_search_tmp` (
  `post_id` int(11) NOT NULL,
  `post_name` varchar(255) NOT NULL,
  `post_name_txt` varchar(255) NOT NULL,
  `post_description` text NOT NULL,
  `post_skill` text,
  `post_skill_txt` text NOT NULL,
  `post_position` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` enum('0','1') NOT NULL,
  `post_last_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `min_year` float DEFAULT NULL,
  `interview_process` text NOT NULL,
  `min_sal` text,
  `max_sal` text,
  `country` int(11) DEFAULT NULL,
  `country_name` varchar(255) NOT NULL,
  `state` int(11) DEFAULT NULL,
  `state_name` varchar(255) NOT NULL,
  `city` int(11) DEFAULT NULL,
  `city_name` varchar(255) NOT NULL,
  `other_skill` text,
  `max_year` float DEFAULT NULL,
  `fresher` int(11) DEFAULT '0',
  `post_currency` int(11) DEFAULT NULL,
  `degree_name` text,
  `industry_type` text,
  `industry_name` varchar(255) NOT NULL,
  `emp_type` varchar(256) DEFAULT NULL,
  `salary_type` varchar(256) DEFAULT NULL,
  `rec_id` int(11) NOT NULL,
  `rec_firstname` varchar(255) NOT NULL,
  `rec_lastname` varchar(255) NOT NULL,
  `rec_comp_name` varchar(255) NOT NULL,
  `rec_comp_logo` varchar(255) NOT NULL,
  `hiring_level` int(11) NOT NULL COMMENT '1-Intern, 2-Entry-level, 3-Associate, 4-Mid-senior, 5-Director, 6-Executive',
  `comp_name` varchar(255) NOT NULL,
  `comp_url` varchar(255) NOT NULL,
  `comp_schedule` enum('0','1','2','3') NOT NULL COMMENT '0-No,1-Day,2-Night,3-Flexible',
  `comp_profile` text NOT NULL,
  `comp_logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_report`
--

CREATE TABLE IF NOT EXISTS `ailee_report` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `uri` text,
  `detail` text,
  `is_ailee_user` tinyint(4) DEFAULT '0' COMMENT '0: not aileensoul user 1: register ailee',
  `created_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_save`
--

CREATE TABLE IF NOT EXISTS `ailee_save` (
  `save_id` int(11) NOT NULL,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT NULL COMMENT '0:Save 1:Unsave 2:shortlist',
  `save_type` enum('1','2') DEFAULT NULL COMMENT '1:Recruiter 2:Freelancer',
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_search_info`
--

CREATE TABLE IF NOT EXISTS `ailee_search_info` (
  `keyword_id` int(10) NOT NULL,
  `search_keyword` varchar(255) DEFAULT NULL,
  `search_location` varchar(50) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `user_location` varchar(50) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `module` enum('1','2','3','4','5','6') DEFAULT NULL COMMENT '1.job/2.rec/3.hire/4.apply/5.business/6.artistic'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_sem`
--

CREATE TABLE IF NOT EXISTS `ailee_sem` (
  `semid` int(11) NOT NULL,
  `semfieldname` varchar(50) NOT NULL,
  `semfieldvalue` text NOT NULL,
  `status` enum('Enable','Disable') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_seo`
--

CREATE TABLE IF NOT EXISTS `ailee_seo` (
  `seoid` int(11) NOT NULL,
  `seofieldname` varchar(50) NOT NULL,
  `seofieldvalue` text NOT NULL,
  `status` enum('Enable','Disable') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_seo_mail_list`
--

CREATE TABLE IF NOT EXISTS `ailee_seo_mail_list` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_showvideo`
--

CREATE TABLE IF NOT EXISTS `ailee_showvideo` (
  `id` int(11) NOT NULL,
  `post_files_id` int(11) NOT NULL,
  `insert_profile` int(11) NOT NULL COMMENT '1.artistic,2.business_profile',
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_site_settings`
--

CREATE TABLE IF NOT EXISTS `ailee_site_settings` (
  `site_id` int(11) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `site_url` varchar(255) NOT NULL,
  `site_email` varchar(255) NOT NULL,
  `site_mobile` varchar(255) NOT NULL,
  `site_owner` varchar(255) NOT NULL,
  `site_address` text NOT NULL,
  `site_visit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_skill`
--

CREATE TABLE IF NOT EXISTS `ailee_skill` (
  `skill_id` int(11) NOT NULL,
  `skill` varchar(255) DEFAULT NULL,
  `skill_image` varchar(255) NOT NULL,
  `status` enum('1','0') DEFAULT NULL COMMENT '0:Blocked 1:Active',
  `type` enum('1','2','4','5','6','7') DEFAULT NULL COMMENT '1:job/rec/free, 2:artistic, 4:other_skil(rec & job), 5:other_skill for freelancer, 6:other_skill for artistic, 7:other skill for main user info',
  `user_id` int(11) DEFAULT NULL,
  `skill_slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_states`
--

CREATE TABLE IF NOT EXISTS `ailee_states` (
  `state_id` int(11) NOT NULL,
  `state_name` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` enum('1','0') NOT NULL COMMENT '0:Blocked, 1:Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_stream`
--

CREATE TABLE IF NOT EXISTS `ailee_stream` (
  `stream_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  `stream_name` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `status` enum('0','1','2') NOT NULL COMMENT '0: not of admin and user 1:Admin status 2:user_added status',
  `is_delete` enum('0','1') NOT NULL,
  `is_other` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1 for other stream',
  `user_id` int(11) NOT NULL COMMENT 'who is add this other stream'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_subscription`
--

CREATE TABLE IF NOT EXISTS `ailee_subscription` (
  `subscription_id` int(11) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `status` enum('1','0') DEFAULT '1' COMMENT '1-active\n0-not active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_sub_category`
--

CREATE TABLE IF NOT EXISTS `ailee_sub_category` (
  `sub_category_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sub_category_name` varchar(200) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `status` enum('1','0') DEFAULT NULL,
  `is_delete` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_sub_industry_type`
--

CREATE TABLE IF NOT EXISTS `ailee_sub_industry_type` (
  `sub_industry_id` int(11) NOT NULL,
  `industry_id` int(11) NOT NULL,
  `sub_industry_name` varchar(200) NOT NULL,
  `status` enum('1','0') NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_tags`
--

CREATE TABLE IF NOT EXISTS `ailee_tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'If tag add by user then need to add user id',
  `status` enum('publish','draft') NOT NULL,
  `is_delete` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_university`
--

CREATE TABLE IF NOT EXISTS `ailee_university` (
  `university_id` int(11) NOT NULL,
  `university_name` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `status` enum('0','1','2') NOT NULL COMMENT '0: not display 1:Admin status 2:user_added status',
  `is_delete` enum('0','1') NOT NULL COMMENT '0: not delete 1:deleted',
  `is_other` enum('0','1') NOT NULL DEFAULT '0' COMMENT '1 for other university',
  `user_id` int(11) NOT NULL COMMENT 'who is add this other skill university'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_unsubscribe_reason`
--

CREATE TABLE IF NOT EXISTS `ailee_unsubscribe_reason` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user`
--

CREATE TABLE IF NOT EXISTS `ailee_user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_dob` date NOT NULL,
  `user_gender` enum('M','F') NOT NULL,
  `user_agree` enum('0','1') NOT NULL,
  `created_date` datetime NOT NULL,
  `verify_date` datetime NOT NULL,
  `user_verify` enum('0','1','2') NOT NULL,
  `user_slider` enum('0','1') NOT NULL COMMENT '1: first time',
  `term_condi` int(1) NOT NULL COMMENT '1-accept',
  `user_slug` text NOT NULL,
  `is_student` enum('0','1') NOT NULL,
  `is_subscribe` int(1) NOT NULL DEFAULT '1' COMMENT '1-Subscribed, 0- Unsubscribed',
  `encrypt_key` varchar(25) NOT NULL,
  `is_new` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_addicourse`
--

CREATE TABLE IF NOT EXISTS `ailee_user_addicourse` (
  `id_addicourse` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `addicourse_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addicourse_org` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addicourse_start_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addicourse_end_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addicourse_url` varbinary(255) NOT NULL,
  `addicourse_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_article`
--

CREATE TABLE IF NOT EXISTS `ailee_user_article` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL COMMENT 'Table : ailee_user_post',
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_ask_question`
--

CREATE TABLE IF NOT EXISTS `ailee_user_ask_question` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `link` text NOT NULL,
  `description` text NOT NULL,
  `category` text NOT NULL,
  `field` int(11) NOT NULL,
  `others_field` text,
  `is_anonymously` enum('0','1') NOT NULL COMMENT '1 for yes',
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_award`
--

CREATE TABLE IF NOT EXISTS `ailee_user_award` (
  `id_award` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `award_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `award_org` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `award_date` date NOT NULL,
  `award_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `award_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_contact`
--

CREATE TABLE IF NOT EXISTS `ailee_user_contact` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL COMMENT 'sender user id',
  `to_id` int(11) NOT NULL COMMENT 'receiver user id',
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `status` enum('confirm','pending','reject','block','cancel','query') DEFAULT NULL,
  `not_read` enum('0','1','2') NOT NULL COMMENT '1: read, 2:not read'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_education`
--

CREATE TABLE IF NOT EXISTS `ailee_user_education` (
  `id_education` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `edu_school_college` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_university` int(11) NOT NULL,
  `edu_other_university` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_degree` int(11) NOT NULL,
  `edu_other_degree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_stream` int(11) NOT NULL,
  `edu_other_stream` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_start_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_end_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_nograduate` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `edu_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_experience`
--

CREATE TABLE IF NOT EXISTS `ailee_user_experience` (
  `id_experience` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exp_company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_company_website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_field` int(11) NOT NULL,
  `exp_other_field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_country` int(11) NOT NULL,
  `exp_state` int(11) NOT NULL,
  `exp_city` int(11) NOT NULL,
  `exp_start_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_end_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_isworking` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `exp_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_extra_activity`
--

CREATE TABLE IF NOT EXISTS `ailee_user_extra_activity` (
  `id_extra_activity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_participate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_org` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_start_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_end_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_follow`
--

CREATE TABLE IF NOT EXISTS `ailee_user_follow` (
  `id` int(11) NOT NULL,
  `follow_from` int(11) NOT NULL,
  `follow_to` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '1: following 0 : not following'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_idol`
--

CREATE TABLE IF NOT EXISTS `ailee_user_idol` (
  `id_idol` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_idol_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_idol_pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_ignore`
--

CREATE TABLE IF NOT EXISTS `ailee_user_ignore` (
  `id` int(11) NOT NULL,
  `profile` enum('1','2') DEFAULT NULL COMMENT '1: artistic 2: business profile',
  `user_from` int(11) DEFAULT NULL,
  `user_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This table represent ignore list of follow suggest user in business profile and artistic profile';

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_info`
--

CREATE TABLE IF NOT EXISTS `ailee_user_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_image` text NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edit_ip` varchar(22) NOT NULL,
  `profile_background` text,
  `profile_background_main` text,
  `user_bio` text NOT NULL,
  `user_skills` varchar(255) NOT NULL,
  `user_hobbies` varchar(255) NOT NULL,
  `user_fav_quote_headline` text NOT NULL,
  `user_fav_artist` varchar(255) NOT NULL,
  `user_fav_book` varchar(255) NOT NULL,
  `user_fav_sport` varchar(255) NOT NULL,
  `progressbar` int(1) NOT NULL COMMENT '0:Not 100%, 1:100% Done'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_invite`
--

CREATE TABLE IF NOT EXISTS `ailee_user_invite` (
  `invite_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `invite_user_id` int(11) DEFAULT NULL,
  `profile` enum('recruiter','freelancer') DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_languages`
--

CREATE TABLE IF NOT EXISTS `ailee_user_languages` (
  `user_id` int(11) NOT NULL,
  `language_txt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proficiency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_links`
--

CREATE TABLE IF NOT EXISTS `ailee_user_links` (
  `user_id` int(11) NOT NULL,
  `user_links_txt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_links_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Facebook,Google,Instagram,LinkedIn,Pinterest,GitHub,Twitter,Personal',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_login`
--

CREATE TABLE IF NOT EXISTS `ailee_user_login` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `is_delete` enum('0','1') NOT NULL,
  `status` enum('0','1') NOT NULL,
  `password_code` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_opportunity`
--

CREATE TABLE IF NOT EXISTS `ailee_user_opportunity` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL COMMENT 'Table : ailee_user_post',
  `opptitle` varchar(255) NOT NULL,
  `opportunity_for` text NOT NULL COMMENT 'Opportunity for : multiple value seperated with comma',
  `location` text NOT NULL COMMENT 'Location for : multiple value seperated with comma',
  `opportunity` text NOT NULL,
  `field` int(11) NOT NULL,
  `other_field` varchar(255) NOT NULL,
  `oppslug` varchar(255) NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_patent`
--

CREATE TABLE IF NOT EXISTS `ailee_user_patent` (
  `id_patent` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `patent_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patent_creator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patent_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patent_date` date NOT NULL,
  `patent_office` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patent_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patent_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `patent_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_post`
--

CREATE TABLE IF NOT EXISTS `ailee_user_post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Table : ailee_user',
  `post_for` enum('simple','opportunity','article','question','profile_update','cover_update') NOT NULL,
  `post_id` int(11) NOT NULL COMMENT 'Table : ailee_user_simple_post, ailee_user_opportunity, ailee_post_article  : primary id',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('publish','draft','reject') NOT NULL,
  `is_delete` enum('0','1') NOT NULL COMMENT '1 : for delete post'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_post_comment`
--

CREATE TABLE IF NOT EXISTS `ailee_user_post_comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `is_delete` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_post_comment_like`
--

CREATE TABLE IF NOT EXISTS `ailee_user_post_comment_like` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `is_like` enum('1','0') NOT NULL COMMENT '1 for like'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_post_delete`
--

CREATE TABLE IF NOT EXISTS `ailee_user_post_delete` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delete_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_post_file`
--

CREATE TABLE IF NOT EXISTS `ailee_user_post_file` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL COMMENT 'Table: ailee_user_post',
  `file_type` enum('image','video','audio','pdf') NOT NULL,
  `filename` text NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_post_like`
--

CREATE TABLE IF NOT EXISTS `ailee_user_post_like` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `is_like` enum('1','0') NOT NULL COMMENT '1 for like'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_profession`
--

CREATE TABLE IF NOT EXISTS `ailee_user_profession` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `designation` int(11) NOT NULL,
  `field` int(11) NOT NULL,
  `other_field` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_profile_update`
--

CREATE TABLE IF NOT EXISTS `ailee_user_profile_update` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `data_key` enum('profile_picture','cover_picture') NOT NULL,
  `data_value` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_projects`
--

CREATE TABLE IF NOT EXISTS `ailee_user_projects` (
  `id_projects` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_team` int(11) NOT NULL,
  `project_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_skills` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_field` int(11) NOT NULL,
  `project_other_field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_partner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_start_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_end_date` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_publication`
--

CREATE TABLE IF NOT EXISTS `ailee_user_publication` (
  `id_publication` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pub_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pub_author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pub_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pub_publisher` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pub_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pub_date` date NOT NULL,
  `pub_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_readunread_message`
--

CREATE TABLE IF NOT EXISTS `ailee_user_readunread_message` (
  `id` int(11) NOT NULL,
  `from_jid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_jid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_research`
--

CREATE TABLE IF NOT EXISTS `ailee_user_research` (
  `id_research` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `research_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `research_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `research_field` int(11) NOT NULL,
  `research_other_field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `research_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `research_publish_date` date NOT NULL,
  `research_document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_simple_post`
--

CREATE TABLE IF NOT EXISTS `ailee_user_simple_post` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL COMMENT 'Table : ailee_user_post',
  `description` text NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_student`
--

CREATE TABLE IF NOT EXISTS `ailee_user_student` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `current_study` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `university_name` int(11) NOT NULL,
  `interested_fields` int(11) NOT NULL,
  `other_interested_fields` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ailee_user_visit`
--

CREATE TABLE IF NOT EXISTS `ailee_user_visit` (
  `id` int(11) NOT NULL,
  `ip` varchar(22) NOT NULL,
  `insert_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofconparticipant`
--

CREATE TABLE IF NOT EXISTS `ofconparticipant` (
  `conversationID` bigint(20) NOT NULL,
  `joinedDate` bigint(20) NOT NULL,
  `leftDate` bigint(20) DEFAULT NULL,
  `bareJID` varchar(200) NOT NULL,
  `jidResource` varchar(100) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofconversation`
--

CREATE TABLE IF NOT EXISTS `ofconversation` (
  `conversationID` bigint(20) NOT NULL,
  `room` varchar(255) DEFAULT NULL,
  `isExternal` tinyint(4) NOT NULL,
  `startDate` bigint(20) NOT NULL,
  `lastActivity` bigint(20) NOT NULL,
  `messageCount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofextcomponentconf`
--

CREATE TABLE IF NOT EXISTS `ofextcomponentconf` (
  `subdomain` varchar(255) NOT NULL,
  `wildcard` tinyint(4) NOT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `permission` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofgroup`
--

CREATE TABLE IF NOT EXISTS `ofgroup` (
  `groupName` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofgroupprop`
--

CREATE TABLE IF NOT EXISTS `ofgroupprop` (
  `groupName` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `propValue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofgroupuser`
--

CREATE TABLE IF NOT EXISTS `ofgroupuser` (
  `groupName` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `administrator` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofid`
--

CREATE TABLE IF NOT EXISTS `ofid` (
  `idType` int(11) NOT NULL,
  `id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofmessagearchive`
--

CREATE TABLE IF NOT EXISTS `ofmessagearchive` (
  `messageID` bigint(20) DEFAULT NULL,
  `conversationID` bigint(20) NOT NULL,
  `fromJID` varchar(255) CHARACTER SET latin1 NOT NULL,
  `fromJIDResource` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `toJID` varchar(255) CHARACTER SET latin1 NOT NULL,
  `toJIDResource` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `sentDate` bigint(20) NOT NULL,
  `stanza` longtext COLLATE utf8mb4_unicode_ci,
  `body` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ofmucaffiliation`
--

CREATE TABLE IF NOT EXISTS `ofmucaffiliation` (
  `roomID` bigint(20) NOT NULL,
  `jid` text NOT NULL,
  `affiliation` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofmucconversationlog`
--

CREATE TABLE IF NOT EXISTS `ofmucconversationlog` (
  `roomID` bigint(20) NOT NULL,
  `messageID` bigint(20) NOT NULL,
  `sender` text NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `logTime` char(15) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text,
  `stanza` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofmucmember`
--

CREATE TABLE IF NOT EXISTS `ofmucmember` (
  `roomID` bigint(20) NOT NULL,
  `jid` text NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `faqentry` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofmucroom`
--

CREATE TABLE IF NOT EXISTS `ofmucroom` (
  `serviceID` bigint(20) NOT NULL,
  `roomID` bigint(20) NOT NULL,
  `creationDate` char(15) NOT NULL,
  `modificationDate` char(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `naturalName` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `lockedDate` char(15) NOT NULL,
  `emptyDate` char(15) DEFAULT NULL,
  `canChangeSubject` tinyint(4) NOT NULL,
  `maxUsers` int(11) NOT NULL,
  `publicRoom` tinyint(4) NOT NULL,
  `moderated` tinyint(4) NOT NULL,
  `membersOnly` tinyint(4) NOT NULL,
  `canInvite` tinyint(4) NOT NULL,
  `roomPassword` varchar(50) DEFAULT NULL,
  `canDiscoverJID` tinyint(4) NOT NULL,
  `logEnabled` tinyint(4) NOT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `rolesToBroadcast` tinyint(4) NOT NULL,
  `useReservedNick` tinyint(4) NOT NULL,
  `canChangeNick` tinyint(4) NOT NULL,
  `canRegister` tinyint(4) NOT NULL,
  `allowpm` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofmucroomprop`
--

CREATE TABLE IF NOT EXISTS `ofmucroomprop` (
  `roomID` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `propValue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofmucservice`
--

CREATE TABLE IF NOT EXISTS `ofmucservice` (
  `serviceID` bigint(20) NOT NULL,
  `subdomain` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `isHidden` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofmucserviceprop`
--

CREATE TABLE IF NOT EXISTS `ofmucserviceprop` (
  `serviceID` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `propValue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofoffline`
--

CREATE TABLE IF NOT EXISTS `ofoffline` (
  `username` varchar(64) CHARACTER SET latin1 NOT NULL,
  `messageID` bigint(20) NOT NULL,
  `creationDate` char(15) CHARACTER SET latin1 NOT NULL,
  `messageSize` int(11) NOT NULL,
  `stanza` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ofpresence`
--

CREATE TABLE IF NOT EXISTS `ofpresence` (
  `username` varchar(64) NOT NULL,
  `offlinePresence` text,
  `offlineDate` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofprivacylist`
--

CREATE TABLE IF NOT EXISTS `ofprivacylist` (
  `username` varchar(64) NOT NULL,
  `name` varchar(100) NOT NULL,
  `isDefault` tinyint(4) NOT NULL,
  `list` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofprivate`
--

CREATE TABLE IF NOT EXISTS `ofprivate` (
  `username` varchar(64) NOT NULL,
  `name` varchar(100) NOT NULL,
  `namespace` varchar(200) NOT NULL,
  `privateData` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofproperty`
--

CREATE TABLE IF NOT EXISTS `ofproperty` (
  `name` varchar(100) NOT NULL,
  `propValue` text NOT NULL,
  `encrypted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofpubsubaffiliation`
--

CREATE TABLE IF NOT EXISTS `ofpubsubaffiliation` (
  `serviceID` varchar(100) NOT NULL,
  `nodeID` varchar(100) NOT NULL,
  `jid` varchar(255) NOT NULL,
  `affiliation` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofpubsubdefaultconf`
--

CREATE TABLE IF NOT EXISTS `ofpubsubdefaultconf` (
  `serviceID` varchar(100) NOT NULL,
  `leaf` tinyint(4) NOT NULL,
  `deliverPayloads` tinyint(4) NOT NULL,
  `maxPayloadSize` int(11) NOT NULL,
  `persistItems` tinyint(4) NOT NULL,
  `maxItems` int(11) NOT NULL,
  `notifyConfigChanges` tinyint(4) NOT NULL,
  `notifyDelete` tinyint(4) NOT NULL,
  `notifyRetract` tinyint(4) NOT NULL,
  `presenceBased` tinyint(4) NOT NULL,
  `sendItemSubscribe` tinyint(4) NOT NULL,
  `publisherModel` varchar(15) NOT NULL,
  `subscriptionEnabled` tinyint(4) NOT NULL,
  `accessModel` varchar(10) NOT NULL,
  `language` varchar(255) DEFAULT NULL,
  `replyPolicy` varchar(15) DEFAULT NULL,
  `associationPolicy` varchar(15) NOT NULL,
  `maxLeafNodes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofpubsubitem`
--

CREATE TABLE IF NOT EXISTS `ofpubsubitem` (
  `serviceID` varchar(100) NOT NULL,
  `nodeID` varchar(100) NOT NULL,
  `id` varchar(100) NOT NULL,
  `jid` varchar(255) NOT NULL,
  `creationDate` char(15) NOT NULL,
  `payload` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofpubsubnode`
--

CREATE TABLE IF NOT EXISTS `ofpubsubnode` (
  `serviceID` varchar(100) NOT NULL,
  `nodeID` varchar(100) NOT NULL,
  `leaf` tinyint(4) NOT NULL,
  `creationDate` char(15) NOT NULL,
  `modificationDate` char(15) NOT NULL,
  `parent` varchar(100) DEFAULT NULL,
  `deliverPayloads` tinyint(4) NOT NULL,
  `maxPayloadSize` int(11) DEFAULT NULL,
  `persistItems` tinyint(4) DEFAULT NULL,
  `maxItems` int(11) DEFAULT NULL,
  `notifyConfigChanges` tinyint(4) NOT NULL,
  `notifyDelete` tinyint(4) NOT NULL,
  `notifyRetract` tinyint(4) NOT NULL,
  `presenceBased` tinyint(4) NOT NULL,
  `sendItemSubscribe` tinyint(4) NOT NULL,
  `publisherModel` varchar(15) NOT NULL,
  `subscriptionEnabled` tinyint(4) NOT NULL,
  `configSubscription` tinyint(4) NOT NULL,
  `accessModel` varchar(10) NOT NULL,
  `payloadType` varchar(100) DEFAULT NULL,
  `bodyXSLT` varchar(100) DEFAULT NULL,
  `dataformXSLT` varchar(100) DEFAULT NULL,
  `creator` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `replyPolicy` varchar(15) DEFAULT NULL,
  `associationPolicy` varchar(15) DEFAULT NULL,
  `maxLeafNodes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofpubsubnodegroups`
--

CREATE TABLE IF NOT EXISTS `ofpubsubnodegroups` (
  `serviceID` varchar(100) NOT NULL,
  `nodeID` varchar(100) NOT NULL,
  `rosterGroup` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofpubsubnodejids`
--

CREATE TABLE IF NOT EXISTS `ofpubsubnodejids` (
  `serviceID` varchar(100) NOT NULL,
  `nodeID` varchar(100) NOT NULL,
  `jid` varchar(255) NOT NULL,
  `associationType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofpubsubsubscription`
--

CREATE TABLE IF NOT EXISTS `ofpubsubsubscription` (
  `serviceID` varchar(100) NOT NULL,
  `nodeID` varchar(100) NOT NULL,
  `id` varchar(100) NOT NULL,
  `jid` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `state` varchar(15) NOT NULL,
  `deliver` tinyint(4) NOT NULL,
  `digest` tinyint(4) NOT NULL,
  `digest_frequency` int(11) NOT NULL,
  `expire` char(15) DEFAULT NULL,
  `includeBody` tinyint(4) NOT NULL,
  `showValues` varchar(30) DEFAULT NULL,
  `subscriptionType` varchar(10) NOT NULL,
  `subscriptionDepth` tinyint(4) NOT NULL,
  `keyword` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofremoteserverconf`
--

CREATE TABLE IF NOT EXISTS `ofremoteserverconf` (
  `xmppDomain` varchar(255) NOT NULL,
  `remotePort` int(11) DEFAULT NULL,
  `permission` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofroster`
--

CREATE TABLE IF NOT EXISTS `ofroster` (
  `rosterID` bigint(20) NOT NULL,
  `username` varchar(64) NOT NULL,
  `jid` varchar(1024) NOT NULL,
  `sub` tinyint(4) NOT NULL,
  `ask` tinyint(4) NOT NULL,
  `recv` tinyint(4) NOT NULL,
  `nick` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofrostergroups`
--

CREATE TABLE IF NOT EXISTS `ofrostergroups` (
  `rosterID` bigint(20) NOT NULL,
  `rank` tinyint(4) NOT NULL,
  `groupName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofrrds`
--

CREATE TABLE IF NOT EXISTS `ofrrds` (
  `id` varchar(100) NOT NULL,
  `updatedDate` bigint(20) NOT NULL,
  `bytes` mediumblob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofsaslauthorized`
--

CREATE TABLE IF NOT EXISTS `ofsaslauthorized` (
  `username` varchar(64) NOT NULL,
  `principal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofsecurityauditlog`
--

CREATE TABLE IF NOT EXISTS `ofsecurityauditlog` (
  `msgID` bigint(20) NOT NULL,
  `username` varchar(64) NOT NULL,
  `entryStamp` bigint(20) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `node` varchar(255) NOT NULL,
  `details` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofuser`
--

CREATE TABLE IF NOT EXISTS `ofuser` (
  `username` varchar(64) NOT NULL,
  `storedKey` varchar(32) DEFAULT NULL,
  `serverKey` varchar(32) DEFAULT NULL,
  `salt` varchar(32) DEFAULT NULL,
  `iterations` int(11) DEFAULT NULL,
  `plainPassword` varchar(32) DEFAULT NULL,
  `encryptedPassword` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `creationDate` char(15) NOT NULL,
  `modificationDate` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofuserflag`
--

CREATE TABLE IF NOT EXISTS `ofuserflag` (
  `username` varchar(64) NOT NULL,
  `name` varchar(100) NOT NULL,
  `startTime` char(15) DEFAULT NULL,
  `endTime` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofuserprop`
--

CREATE TABLE IF NOT EXISTS `ofuserprop` (
  `username` varchar(64) NOT NULL,
  `name` varchar(100) NOT NULL,
  `propValue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofvcard`
--

CREATE TABLE IF NOT EXISTS `ofvcard` (
  `username` varchar(64) NOT NULL,
  `vcard` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ofversion`
--

CREATE TABLE IF NOT EXISTS `ofversion` (
  `name` varchar(50) NOT NULL,
  `version` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ailee_admin`
--
ALTER TABLE `ailee_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `ailee_advertise_with_us`
--
ALTER TABLE `ailee_advertise_with_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_artistic_post_comment`
--
ALTER TABLE `ailee_artistic_post_comment`
  ADD PRIMARY KEY (`artistic_post_comment_id`);

--
-- Indexes for table `ailee_art_category`
--
ALTER TABLE `ailee_art_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `ailee_art_comment_image_like`
--
ALTER TABLE `ailee_art_comment_image_like`
  ADD PRIMARY KEY (`image_comment_like_id`);

--
-- Indexes for table `ailee_art_other_category`
--
ALTER TABLE `ailee_art_other_category`
  ADD PRIMARY KEY (`other_category_id`);

--
-- Indexes for table `ailee_art_post`
--
ALTER TABLE `ailee_art_post`
  ADD PRIMARY KEY (`art_post_id`);

--
-- Indexes for table `ailee_art_post_image_comment`
--
ALTER TABLE `ailee_art_post_image_comment`
  ADD PRIMARY KEY (`post_image_comment_id`);

--
-- Indexes for table `ailee_art_post_image_like`
--
ALTER TABLE `ailee_art_post_image_like`
  ADD PRIMARY KEY (`post_image_like_id`);

--
-- Indexes for table `ailee_art_reg`
--
ALTER TABLE `ailee_art_reg`
  ADD PRIMARY KEY (`art_id`);

--
-- Indexes for table `ailee_art_reg_search_tmp`
--
ALTER TABLE `ailee_art_reg_search_tmp`
  ADD PRIMARY KEY (`art_id`);

--
-- Indexes for table `ailee_blog`
--
ALTER TABLE `ailee_blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_blog_category`
--
ALTER TABLE `ailee_blog_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_blog_comment`
--
ALTER TABLE `ailee_blog_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_blog_guest`
--
ALTER TABLE `ailee_blog_guest`
  ADD PRIMARY KEY (`id_blog_guest`);

--
-- Indexes for table `ailee_blog_tag`
--
ALTER TABLE `ailee_blog_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_blog_visit`
--
ALTER TABLE `ailee_blog_visit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_business_profile`
--
ALTER TABLE `ailee_business_profile`
  ADD PRIMARY KEY (`business_profile_id`),
  ADD KEY `business_profile_id` (`business_profile_id`),
  ADD KEY `user_id` (`user_id`,`status`,`is_deleted`,`business_step`);

--
-- Indexes for table `ailee_business_profile_post`
--
ALTER TABLE `ailee_business_profile_post`
  ADD PRIMARY KEY (`business_profile_post_id`);

--
-- Indexes for table `ailee_business_profile_post_comment`
--
ALTER TABLE `ailee_business_profile_post_comment`
  ADD PRIMARY KEY (`business_profile_post_comment_id`);

--
-- Indexes for table `ailee_business_profile_save`
--
ALTER TABLE `ailee_business_profile_save`
  ADD PRIMARY KEY (`save_id`);

--
-- Indexes for table `ailee_business_profile_search_tmp`
--
ALTER TABLE `ailee_business_profile_search_tmp`
  ADD PRIMARY KEY (`business_profile_id`),
  ADD KEY `business_profile_id` (`business_profile_id`),
  ADD KEY `user_id` (`user_id`,`status`,`is_deleted`,`business_step`);

--
-- Indexes for table `ailee_business_type`
--
ALTER TABLE `ailee_business_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `ailee_bus_comment_image_like`
--
ALTER TABLE `ailee_bus_comment_image_like`
  ADD PRIMARY KEY (`image_comment_like_id`);

--
-- Indexes for table `ailee_bus_image`
--
ALTER TABLE `ailee_bus_image`
  ADD PRIMARY KEY (`bus_image_id`);

--
-- Indexes for table `ailee_bus_post_image_comment`
--
ALTER TABLE `ailee_bus_post_image_comment`
  ADD PRIMARY KEY (`post_image_comment_id`);

--
-- Indexes for table `ailee_bus_post_image_like`
--
ALTER TABLE `ailee_bus_post_image_like`
  ADD PRIMARY KEY (`post_image_like_id`);

--
-- Indexes for table `ailee_bus_showvideo`
--
ALTER TABLE `ailee_bus_showvideo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_category`
--
ALTER TABLE `ailee_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `ailee_cities`
--
ALTER TABLE `ailee_cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `ailee_college`
--
ALTER TABLE `ailee_college`
  ADD PRIMARY KEY (`college_id`);

--
-- Indexes for table `ailee_contact_person`
--
ALTER TABLE `ailee_contact_person`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `contact_from_id` (`contact_from_id`,`contact_to_id`,`status`,`not_read`);

--
-- Indexes for table `ailee_contact_us`
--
ALTER TABLE `ailee_contact_us`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `ailee_countries`
--
ALTER TABLE `ailee_countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `ailee_currency`
--
ALTER TABLE `ailee_currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `ailee_degree`
--
ALTER TABLE `ailee_degree`
  ADD PRIMARY KEY (`degree_id`);

--
-- Indexes for table `ailee_emails`
--
ALTER TABLE `ailee_emails`
  ADD PRIMARY KEY (`emailid`);

--
-- Indexes for table `ailee_emails_seo`
--
ALTER TABLE `ailee_emails_seo`
  ADD PRIMARY KEY (`emailid`);

--
-- Indexes for table `ailee_email_settings`
--
ALTER TABLE `ailee_email_settings`
  ADD PRIMARY KEY (`esetting_id`);

--
-- Indexes for table `ailee_feedback`
--
ALTER TABLE `ailee_feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `ailee_feedback_general`
--
ALTER TABLE `ailee_feedback_general`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_follow`
--
ALTER TABLE `ailee_follow`
  ADD PRIMARY KEY (`follow_id`);

--
-- Indexes for table `ailee_freelancer_apply`
--
ALTER TABLE `ailee_freelancer_apply`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `ailee_freelancer_hire_reg`
--
ALTER TABLE `ailee_freelancer_hire_reg`
  ADD PRIMARY KEY (`reg_id`);

--
-- Indexes for table `ailee_freelancer_post`
--
ALTER TABLE `ailee_freelancer_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `ailee_freelancer_post_reg`
--
ALTER TABLE `ailee_freelancer_post_reg`
  ADD PRIMARY KEY (`freelancer_post_reg_id`);

--
-- Indexes for table `ailee_freelancer_post_reg_search_tmp`
--
ALTER TABLE `ailee_freelancer_post_reg_search_tmp`
  ADD PRIMARY KEY (`freelancer_post_reg_id`);

--
-- Indexes for table `ailee_freelancer_post_search_tmp`
--
ALTER TABLE `ailee_freelancer_post_search_tmp`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `ailee_freelancer_review`
--
ALTER TABLE `ailee_freelancer_review`
  ADD PRIMARY KEY (`id_review`);

--
-- Indexes for table `ailee_gov_category`
--
ALTER TABLE `ailee_gov_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_gov_post`
--
ALTER TABLE `ailee_gov_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_industry_type`
--
ALTER TABLE `ailee_industry_type`
  ADD PRIMARY KEY (`industry_id`);

--
-- Indexes for table `ailee_job_add_edu`
--
ALTER TABLE `ailee_job_add_edu`
  ADD PRIMARY KEY (`edu_id`);

--
-- Indexes for table `ailee_job_add_workexp`
--
ALTER TABLE `ailee_job_add_workexp`
  ADD PRIMARY KEY (`work_id`);

--
-- Indexes for table `ailee_job_apply`
--
ALTER TABLE `ailee_job_apply`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `ailee_job_graduation`
--
ALTER TABLE `ailee_job_graduation`
  ADD PRIMARY KEY (`job_graduation_id`);

--
-- Indexes for table `ailee_job_industry`
--
ALTER TABLE `ailee_job_industry`
  ADD PRIMARY KEY (`industry_id`),
  ADD KEY `industry_id` (`industry_id`);

--
-- Indexes for table `ailee_job_reg`
--
ALTER TABLE `ailee_job_reg`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `ailee_job_reg_search_tmp`
--
ALTER TABLE `ailee_job_reg_search_tmp`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `ailee_job_title`
--
ALTER TABLE `ailee_job_title`
  ADD PRIMARY KEY (`title_id`),
  ADD KEY `title_id` (`title_id`);

--
-- Indexes for table `ailee_job_user_addicourse`
--
ALTER TABLE `ailee_job_user_addicourse`
  ADD PRIMARY KEY (`id_addicourse`);

--
-- Indexes for table `ailee_job_user_award`
--
ALTER TABLE `ailee_job_user_award`
  ADD PRIMARY KEY (`id_award`);

--
-- Indexes for table `ailee_job_user_education`
--
ALTER TABLE `ailee_job_user_education`
  ADD PRIMARY KEY (`id_education`);

--
-- Indexes for table `ailee_job_user_experience`
--
ALTER TABLE `ailee_job_user_experience`
  ADD PRIMARY KEY (`id_experience`);

--
-- Indexes for table `ailee_job_user_extra_activity`
--
ALTER TABLE `ailee_job_user_extra_activity`
  ADD PRIMARY KEY (`id_extra_activity`);

--
-- Indexes for table `ailee_job_user_patent`
--
ALTER TABLE `ailee_job_user_patent`
  ADD PRIMARY KEY (`id_patent`);

--
-- Indexes for table `ailee_job_user_projects`
--
ALTER TABLE `ailee_job_user_projects`
  ADD PRIMARY KEY (`id_projects`);

--
-- Indexes for table `ailee_job_user_publication`
--
ALTER TABLE `ailee_job_user_publication`
  ADD PRIMARY KEY (`id_publication`);

--
-- Indexes for table `ailee_job_user_research`
--
ALTER TABLE `ailee_job_user_research`
  ADD PRIMARY KEY (`id_research`);

--
-- Indexes for table `ailee_language`
--
ALTER TABLE `ailee_language`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `ailee_messages`
--
ALTER TABLE `ailee_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_notification`
--
ALTER TABLE `ailee_notification`
  ADD PRIMARY KEY (`not_id`),
  ADD KEY `not_type` (`not_type`),
  ADD KEY `not_read` (`not_read`),
  ADD KEY `not_created_date` (`not_created_date`),
  ADD KEY `not_type_2` (`not_type`,`not_to_id`,`not_read`,`not_from`);

--
-- Indexes for table `ailee_pages`
--
ALTER TABLE `ailee_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `ailee_post_article`
--
ALTER TABLE `ailee_post_article`
  ADD PRIMARY KEY (`id_post_article`);

--
-- Indexes for table `ailee_post_article_media`
--
ALTER TABLE `ailee_post_article_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_post_files`
--
ALTER TABLE `ailee_post_files`
  ADD PRIMARY KEY (`post_files_id`);

--
-- Indexes for table `ailee_recruiter`
--
ALTER TABLE `ailee_recruiter`
  ADD PRIMARY KEY (`rec_id`),
  ADD KEY `rec_id` (`rec_id`);

--
-- Indexes for table `ailee_rec_post`
--
ALTER TABLE `ailee_rec_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `ailee_rec_post_login`
--
ALTER TABLE `ailee_rec_post_login`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `ailee_rec_post_search_tmp`
--
ALTER TABLE `ailee_rec_post_search_tmp`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `ailee_report`
--
ALTER TABLE `ailee_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_save`
--
ALTER TABLE `ailee_save`
  ADD PRIMARY KEY (`save_id`);

--
-- Indexes for table `ailee_search_info`
--
ALTER TABLE `ailee_search_info`
  ADD PRIMARY KEY (`keyword_id`);

--
-- Indexes for table `ailee_sem`
--
ALTER TABLE `ailee_sem`
  ADD PRIMARY KEY (`semid`);

--
-- Indexes for table `ailee_seo`
--
ALTER TABLE `ailee_seo`
  ADD PRIMARY KEY (`seoid`);

--
-- Indexes for table `ailee_seo_mail_list`
--
ALTER TABLE `ailee_seo_mail_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_showvideo`
--
ALTER TABLE `ailee_showvideo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_site_settings`
--
ALTER TABLE `ailee_site_settings`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `ailee_skill`
--
ALTER TABLE `ailee_skill`
  ADD PRIMARY KEY (`skill_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Indexes for table `ailee_states`
--
ALTER TABLE `ailee_states`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `ailee_stream`
--
ALTER TABLE `ailee_stream`
  ADD PRIMARY KEY (`stream_id`);

--
-- Indexes for table `ailee_subscription`
--
ALTER TABLE `ailee_subscription`
  ADD PRIMARY KEY (`subscription_id`);

--
-- Indexes for table `ailee_sub_category`
--
ALTER TABLE `ailee_sub_category`
  ADD PRIMARY KEY (`sub_category_id`);

--
-- Indexes for table `ailee_sub_industry_type`
--
ALTER TABLE `ailee_sub_industry_type`
  ADD PRIMARY KEY (`sub_industry_id`);

--
-- Indexes for table `ailee_tags`
--
ALTER TABLE `ailee_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `ailee_university`
--
ALTER TABLE `ailee_university`
  ADD PRIMARY KEY (`university_id`);

--
-- Indexes for table `ailee_unsubscribe_reason`
--
ALTER TABLE `ailee_unsubscribe_reason`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_user`
--
ALTER TABLE `ailee_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ailee_user_addicourse`
--
ALTER TABLE `ailee_user_addicourse`
  ADD PRIMARY KEY (`id_addicourse`);

--
-- Indexes for table `ailee_user_article`
--
ALTER TABLE `ailee_user_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `ailee_user_ask_question`
--
ALTER TABLE `ailee_user_ask_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `ailee_user_award`
--
ALTER TABLE `ailee_user_award`
  ADD PRIMARY KEY (`id_award`);

--
-- Indexes for table `ailee_user_contact`
--
ALTER TABLE `ailee_user_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_user_education`
--
ALTER TABLE `ailee_user_education`
  ADD PRIMARY KEY (`id_education`);

--
-- Indexes for table `ailee_user_experience`
--
ALTER TABLE `ailee_user_experience`
  ADD PRIMARY KEY (`id_experience`);

--
-- Indexes for table `ailee_user_extra_activity`
--
ALTER TABLE `ailee_user_extra_activity`
  ADD PRIMARY KEY (`id_extra_activity`);

--
-- Indexes for table `ailee_user_follow`
--
ALTER TABLE `ailee_user_follow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follow_from` (`follow_from`),
  ADD KEY `follow_to` (`follow_to`);

--
-- Indexes for table `ailee_user_idol`
--
ALTER TABLE `ailee_user_idol`
  ADD PRIMARY KEY (`id_idol`);

--
-- Indexes for table `ailee_user_ignore`
--
ALTER TABLE `ailee_user_ignore`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_user_info`
--
ALTER TABLE `ailee_user_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ailee_user_invite`
--
ALTER TABLE `ailee_user_invite`
  ADD PRIMARY KEY (`invite_id`);

--
-- Indexes for table `ailee_user_login`
--
ALTER TABLE `ailee_user_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ailee_user_opportunity`
--
ALTER TABLE `ailee_user_opportunity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_user_patent`
--
ALTER TABLE `ailee_user_patent`
  ADD PRIMARY KEY (`id_patent`);

--
-- Indexes for table `ailee_user_post`
--
ALTER TABLE `ailee_user_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `ailee_user_post_comment`
--
ALTER TABLE `ailee_user_post_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ailee_user_post_comment_like`
--
ALTER TABLE `ailee_user_post_comment_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `ailee_user_post_delete`
--
ALTER TABLE `ailee_user_post_delete`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ailee_user_post_file`
--
ALTER TABLE `ailee_user_post_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `ailee_user_post_like`
--
ALTER TABLE `ailee_user_post_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `ailee_user_profession`
--
ALTER TABLE `ailee_user_profession`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ailee_user_profile_update`
--
ALTER TABLE `ailee_user_profile_update`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ailee_user_projects`
--
ALTER TABLE `ailee_user_projects`
  ADD PRIMARY KEY (`id_projects`);

--
-- Indexes for table `ailee_user_publication`
--
ALTER TABLE `ailee_user_publication`
  ADD PRIMARY KEY (`id_publication`);

--
-- Indexes for table `ailee_user_readunread_message`
--
ALTER TABLE `ailee_user_readunread_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ailee_user_research`
--
ALTER TABLE `ailee_user_research`
  ADD PRIMARY KEY (`id_research`);

--
-- Indexes for table `ailee_user_simple_post`
--
ALTER TABLE `ailee_user_simple_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `ailee_user_student`
--
ALTER TABLE `ailee_user_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ailee_user_visit`
--
ALTER TABLE `ailee_user_visit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ofconparticipant`
--
ALTER TABLE `ofconparticipant`
  ADD KEY `ofConParticipant_conv_idx` (`conversationID`,`bareJID`,`jidResource`,`joinedDate`),
  ADD KEY `ofConParticipant_jid_idx` (`bareJID`);

--
-- Indexes for table `ofconversation`
--
ALTER TABLE `ofconversation`
  ADD PRIMARY KEY (`conversationID`),
  ADD KEY `ofConversation_ext_idx` (`isExternal`),
  ADD KEY `ofConversation_start_idx` (`startDate`),
  ADD KEY `ofConversation_last_idx` (`lastActivity`);

--
-- Indexes for table `ofextcomponentconf`
--
ALTER TABLE `ofextcomponentconf`
  ADD PRIMARY KEY (`subdomain`);

--
-- Indexes for table `ofgroup`
--
ALTER TABLE `ofgroup`
  ADD PRIMARY KEY (`groupName`);

--
-- Indexes for table `ofgroupprop`
--
ALTER TABLE `ofgroupprop`
  ADD PRIMARY KEY (`groupName`,`name`);

--
-- Indexes for table `ofgroupuser`
--
ALTER TABLE `ofgroupuser`
  ADD PRIMARY KEY (`groupName`,`username`,`administrator`);

--
-- Indexes for table `ofid`
--
ALTER TABLE `ofid`
  ADD PRIMARY KEY (`idType`);

--
-- Indexes for table `ofmessagearchive`
--
ALTER TABLE `ofmessagearchive`
  ADD KEY `ofMessageArchive_con_idx` (`conversationID`),
  ADD KEY `ofMessageArchive_fromjid_idx` (`fromJID`),
  ADD KEY `ofMessageArchive_tojid_idx` (`toJID`);

--
-- Indexes for table `ofmucaffiliation`
--
ALTER TABLE `ofmucaffiliation`
  ADD PRIMARY KEY (`roomID`,`jid`(70));

--
-- Indexes for table `ofmucconversationlog`
--
ALTER TABLE `ofmucconversationlog`
  ADD KEY `ofMucConversationLog_time_idx` (`logTime`),
  ADD KEY `ofMucConversationLog_msg_id` (`messageID`);

--
-- Indexes for table `ofmucmember`
--
ALTER TABLE `ofmucmember`
  ADD PRIMARY KEY (`roomID`,`jid`(70));

--
-- Indexes for table `ofmucroom`
--
ALTER TABLE `ofmucroom`
  ADD PRIMARY KEY (`serviceID`,`name`),
  ADD KEY `ofMucRoom_roomid_idx` (`roomID`),
  ADD KEY `ofMucRoom_serviceid_idx` (`serviceID`);

--
-- Indexes for table `ofmucroomprop`
--
ALTER TABLE `ofmucroomprop`
  ADD PRIMARY KEY (`roomID`,`name`);

--
-- Indexes for table `ofmucservice`
--
ALTER TABLE `ofmucservice`
  ADD PRIMARY KEY (`subdomain`),
  ADD KEY `ofMucService_serviceid_idx` (`serviceID`);

--
-- Indexes for table `ofmucserviceprop`
--
ALTER TABLE `ofmucserviceprop`
  ADD PRIMARY KEY (`serviceID`,`name`);

--
-- Indexes for table `ofoffline`
--
ALTER TABLE `ofoffline`
  ADD PRIMARY KEY (`username`,`messageID`);

--
-- Indexes for table `ofpresence`
--
ALTER TABLE `ofpresence`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `ofprivacylist`
--
ALTER TABLE `ofprivacylist`
  ADD PRIMARY KEY (`username`,`name`),
  ADD KEY `ofPrivacyList_default_idx` (`username`,`isDefault`);

--
-- Indexes for table `ofprivate`
--
ALTER TABLE `ofprivate`
  ADD PRIMARY KEY (`username`,`name`,`namespace`(100));

--
-- Indexes for table `ofproperty`
--
ALTER TABLE `ofproperty`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `ofpubsubaffiliation`
--
ALTER TABLE `ofpubsubaffiliation`
  ADD PRIMARY KEY (`serviceID`,`nodeID`,`jid`(70));

--
-- Indexes for table `ofpubsubdefaultconf`
--
ALTER TABLE `ofpubsubdefaultconf`
  ADD PRIMARY KEY (`serviceID`,`leaf`);

--
-- Indexes for table `ofpubsubitem`
--
ALTER TABLE `ofpubsubitem`
  ADD PRIMARY KEY (`serviceID`,`nodeID`,`id`);

--
-- Indexes for table `ofpubsubnode`
--
ALTER TABLE `ofpubsubnode`
  ADD PRIMARY KEY (`serviceID`,`nodeID`);

--
-- Indexes for table `ofpubsubnodegroups`
--
ALTER TABLE `ofpubsubnodegroups`
  ADD KEY `ofPubsubNodeGroups_idx` (`serviceID`,`nodeID`);

--
-- Indexes for table `ofpubsubnodejids`
--
ALTER TABLE `ofpubsubnodejids`
  ADD PRIMARY KEY (`serviceID`,`nodeID`,`jid`(70));

--
-- Indexes for table `ofpubsubsubscription`
--
ALTER TABLE `ofpubsubsubscription`
  ADD PRIMARY KEY (`serviceID`,`nodeID`,`id`);

--
-- Indexes for table `ofremoteserverconf`
--
ALTER TABLE `ofremoteserverconf`
  ADD PRIMARY KEY (`xmppDomain`);

--
-- Indexes for table `ofroster`
--
ALTER TABLE `ofroster`
  ADD PRIMARY KEY (`rosterID`),
  ADD KEY `ofRoster_unameid_idx` (`username`),
  ADD KEY `ofRoster_jid_idx` (`jid`(255));

--
-- Indexes for table `ofrostergroups`
--
ALTER TABLE `ofrostergroups`
  ADD PRIMARY KEY (`rosterID`,`rank`),
  ADD KEY `ofRosterGroup_rosterid_idx` (`rosterID`);

--
-- Indexes for table `ofrrds`
--
ALTER TABLE `ofrrds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ofsaslauthorized`
--
ALTER TABLE `ofsaslauthorized`
  ADD PRIMARY KEY (`username`,`principal`(200));

--
-- Indexes for table `ofsecurityauditlog`
--
ALTER TABLE `ofsecurityauditlog`
  ADD PRIMARY KEY (`msgID`),
  ADD KEY `ofSecurityAuditLog_tstamp_idx` (`entryStamp`),
  ADD KEY `ofSecurityAuditLog_uname_idx` (`username`);

--
-- Indexes for table `ofuser`
--
ALTER TABLE `ofuser`
  ADD PRIMARY KEY (`username`),
  ADD KEY `ofUser_cDate_idx` (`creationDate`);

--
-- Indexes for table `ofuserflag`
--
ALTER TABLE `ofuserflag`
  ADD PRIMARY KEY (`username`,`name`),
  ADD KEY `ofUserFlag_sTime_idx` (`startTime`),
  ADD KEY `ofUserFlag_eTime_idx` (`endTime`);

--
-- Indexes for table `ofuserprop`
--
ALTER TABLE `ofuserprop`
  ADD PRIMARY KEY (`username`,`name`);

--
-- Indexes for table `ofvcard`
--
ALTER TABLE `ofvcard`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `ofversion`
--
ALTER TABLE `ofversion`
  ADD PRIMARY KEY (`name`);

--
-- AUTO_INCREMENT for dumped tables
--
