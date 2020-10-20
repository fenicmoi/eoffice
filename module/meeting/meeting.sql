/*
MySQL Data Transfer
Source Host: localhost
Source Database: meeting
Target Host: localhost
Target Database: meeting
Date: 19/3/2010 11:15:28
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for meeting_admin
-- ----------------------------
CREATE TABLE `meeting_admin` (
  `admin_id` int(11) NOT NULL auto_increment,
  `username` varchar(125) default NULL,
  `passwords` varchar(125) default NULL,
  `name` varchar(125) default NULL,
  PRIMARY KEY  (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_booking
-- ----------------------------
CREATE TABLE `meeting_booking` (
  `book_id` int(11) NOT NULL auto_increment,
  `subject` varchar(125) default NULL,
  `head` varchar(125) default NULL,
  `numpeople` int(11) default NULL,
  `room_id` int(11) default NULL,
  `startdate` date default NULL,
  `enddate` date default NULL,
  `starttime` varchar(20) default NULL,
  `endtime` varchar(20) default NULL,
  `bookname` varchar(125) default NULL,
  `bookingdate` date default NULL,
  `user_id` int(11) default NULL,
  `conf_status` int(11) default '0',
  `want` text,
  `comment` text,
  `update_status` int(11) default '0',
  `tool_id` text,
  `food_id` text,
  PRIMARY KEY  (`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_booking_ori
-- ----------------------------
CREATE TABLE `meeting_booking_ori` (
  `count_id` int(11) NOT NULL auto_increment,
  `book_id` int(11) NOT NULL,
  `subject` varchar(125) default NULL,
  `head` varchar(125) default NULL,
  `numpeople` int(11) default NULL,
  `room_id` int(11) default NULL,
  `startdate` date default NULL,
  `enddate` date default NULL,
  `starttime` varchar(20) default NULL,
  `endtime` varchar(20) default NULL,
  `bookname` varchar(125) default NULL,
  `bookingdate` date default NULL,
  `user_id` int(11) default NULL,
  `conf_status` int(11) default '0',
  `want` text,
  `comment` text,
  `date_edit` date default NULL,
  PRIMARY KEY  (`count_id`)
) ENGINE=MyISAM DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_cancelday
-- ----------------------------
CREATE TABLE `meeting_cancelday` (
  `day_id` int(11) NOT NULL default '0',
  `day` int(11) default NULL,
  PRIMARY KEY  (`day_id`)
) ENGINE=MyISAM DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_day
-- ----------------------------
CREATE TABLE `meeting_day` (
  `day_id` int(11) NOT NULL default '0',
  `day` int(11) default NULL,
  PRIMARY KEY  (`day_id`)
) ENGINE=MyISAM DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_department
-- ----------------------------
CREATE TABLE `meeting_department` (
  `dept_id` int(11) NOT NULL auto_increment,
  `dept_code` varchar(100) NOT NULL,
  `dept_name` varchar(225) default NULL,
  PRIMARY KEY  (`dept_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_endtime
-- ----------------------------
CREATE TABLE `meeting_endtime` (
  `time_id` int(11) NOT NULL auto_increment,
  `time_name` varchar(20) default NULL,
  PRIMARY KEY  (`time_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_foods
-- ----------------------------
CREATE TABLE `meeting_foods` (
  `food_id` int(11) NOT NULL auto_increment,
  `food_name` varchar(125) default NULL,
  PRIMARY KEY  (`food_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_room
-- ----------------------------
CREATE TABLE `meeting_room` (
  `room_id` int(11) NOT NULL auto_increment,
  `roomname` varchar(225) default NULL,
  `roomplace` varchar(225) default NULL,
  `roomcount` int(11) default NULL,
  `roomimg` varchar(125) default NULL,
  `dept` varchar(225) default NULL,
  `tel` varchar(125) default NULL,
  `comment` text,
  `tool_id` text,
  PRIMARY KEY  (`room_id`)
) ENGINE=MyISAM DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_roomtools
-- ----------------------------
CREATE TABLE `meeting_roomtools` (
  `room_id` int(11) default NULL,
  `tools_id` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_starttime
-- ----------------------------
CREATE TABLE `meeting_starttime` (
  `time_id` int(11) NOT NULL auto_increment,
  `time_name` varchar(20) default NULL,
  PRIMARY KEY  (`time_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_tools
-- ----------------------------
CREATE TABLE `meeting_tools` (
  `tool_id` int(11) NOT NULL auto_increment,
  `toolname` varchar(225) default NULL,
  PRIMARY KEY  (`tool_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_usefood
-- ----------------------------
CREATE TABLE `meeting_usefood` (
  `book_id` int(11) NOT NULL default '0',
  `food_id` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_user
-- ----------------------------
CREATE TABLE `meeting_user` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(125) default NULL,
  `passwords` varchar(125) default NULL,
  `name` varchar(125) default NULL,
  `department` int(11) default NULL,
  `phone` varchar(125) default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=tis620;

-- ----------------------------
-- Table structure for meeting_usetool
-- ----------------------------
CREATE TABLE `meeting_usetool` (
  `book_id` int(11) NOT NULL default '0',
  `tool_id` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=tis620;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `meeting_admin` VALUES ('1', 'admin', 'admin', 'Administrator Test');
INSERT INTO `meeting_cancelday` VALUES ('1', '1');
INSERT INTO `meeting_day` VALUES ('1', '3');
INSERT INTO `meeting_department` VALUES ('1', '0001', 'หน่วยงานที่ 1');
INSERT INTO `meeting_endtime` VALUES ('1', '09:00:00');
INSERT INTO `meeting_endtime` VALUES ('2', '10:00:00');
INSERT INTO `meeting_endtime` VALUES ('3', '11:00:00');
INSERT INTO `meeting_endtime` VALUES ('4', '12:00:00');
INSERT INTO `meeting_endtime` VALUES ('5', '14:00:00');
INSERT INTO `meeting_endtime` VALUES ('6', '15:00:00');
INSERT INTO `meeting_endtime` VALUES ('7', '16:00:00');
INSERT INTO `meeting_endtime` VALUES ('11', '17:00:00');
INSERT INTO `meeting_foods` VALUES ('1', 'อาหารว่างเช้า');
INSERT INTO `meeting_foods` VALUES ('2', 'อาหารกลางวัน');
INSERT INTO `meeting_foods` VALUES ('3', 'อาหารว่างบ่าย');
INSERT INTO `meeting_starttime` VALUES ('1', '08:00:00');
INSERT INTO `meeting_starttime` VALUES ('2', '09:01:00');
INSERT INTO `meeting_starttime` VALUES ('3', '10:01:00');
INSERT INTO `meeting_starttime` VALUES ('4', '11:01:00');
INSERT INTO `meeting_starttime` VALUES ('5', '13:00:00');
INSERT INTO `meeting_starttime` VALUES ('6', '14:01:00');
INSERT INTO `meeting_starttime` VALUES ('7', '15:01:00');
INSERT INTO `meeting_starttime` VALUES ('11', '16:01:00');
INSERT INTO `meeting_tools` VALUES ('2', 'โปรเจ็คเตอร์');
INSERT INTO `meeting_tools` VALUES ('3', 'เครื่องขยายเสียง');
INSERT INTO `meeting_tools` VALUES ('4', 'คอมพิวเตอร์โน้ตบุ๊ค');
INSERT INTO `meeting_tools` VALUES ('5', 'Visualizer');
INSERT INTO `meeting_tools` VALUES ('6', 'เครื่องเล่น VCD, DVD');
INSERT INTO `meeting_tools` VALUES ('7', 'Pointer');
INSERT INTO `meeting_user` VALUES ('1', 'user', 'user', 'นายทดสอบ ระบบ', '1', '0869625358');
