/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50619
Source Host           : localhost:3306
Source Database       : think_inaction

Target Server Type    : MYSQL
Target Server Version : 50619
File Encoding         : 65001

Date: 2016-08-11 17:07:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mb_message
-- ----------------------------
DROP TABLE IF EXISTS `mb_message`;
CREATE TABLE `mb_message` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(100) NOT NULL,
  `created_at` int(10) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `createdAt` (`created_at`) USING BTREE,
  KEY `userId` (`user_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for mb_user
-- ----------------------------
DROP TABLE IF EXISTS `mb_user`;
CREATE TABLE `mb_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(40) NOT NULL,
  `password` char(32) NOT NULL,
  `created_at` int(10) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `createdAt` (`created_at`) USING BTREE,
  KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
