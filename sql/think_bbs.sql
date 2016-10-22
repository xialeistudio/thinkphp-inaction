/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50619
Source Host           : localhost:3306
Source Database       : think_bbs

Target Server Type    : MYSQL
Target Server Version : 50619
File Encoding         : 65001

Date: 2016-09-10 15:59:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bbs_admin
-- ----------------------------
DROP TABLE IF EXISTS `bbs_admin`;
CREATE TABLE `bbs_admin` (
  `adminId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `loginAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '上次登录时间',
  `loginIp` int(11) NOT NULL DEFAULT '0' COMMENT '上次登录IP',
  PRIMARY KEY (`adminId`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bbs_admin
-- ----------------------------

-- ----------------------------
-- Table structure for bbs_board
-- ----------------------------
DROP TABLE IF EXISTS `bbs_board`;
CREATE TABLE `bbs_board` (
  `boardId` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '版块ID',
  `name` varchar(10) NOT NULL COMMENT '版块名称',
  `icon` varchar(40) NOT NULL COMMENT '版块图标',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `rules` text NOT NULL COMMENT '版规',
  PRIMARY KEY (`boardId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bbs_board
-- ----------------------------

-- ----------------------------
-- Table structure for bbs_board_admin
-- ----------------------------
DROP TABLE IF EXISTS `bbs_board_admin`;
CREATE TABLE `bbs_board_admin` (
  `adminId` int(11) NOT NULL AUTO_INCREMENT COMMENT '版主ID',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '设置时间',
  `userId` int(10) unsigned NOT NULL,
  `boardId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`adminId`),
  KEY `fk_bbs_board_admin_bbs_user1_idx` (`userId`),
  KEY `fk_bbs_board_admin_bbs_board1_idx` (`boardId`),
  CONSTRAINT `fk_bbs_board_admin_bbs_board1` FOREIGN KEY (`boardId`) REFERENCES `bbs_board` (`boardId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bbs_board_admin_bbs_user1` FOREIGN KEY (`userId`) REFERENCES `bbs_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bbs_board_admin
-- ----------------------------

-- ----------------------------
-- Table structure for bbs_post
-- ----------------------------
DROP TABLE IF EXISTS `bbs_post`;
CREATE TABLE `bbs_post` (
  `postId` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '帖子ID',
  `title` varchar(40) NOT NULL COMMENT '标题',
  `viewCount` int(11) NOT NULL DEFAULT '0' COMMENT '点击数',
  `replyCount` int(11) NOT NULL DEFAULT '0' COMMENT '回复数量',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '发帖时间',
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `content` text NOT NULL COMMENT '帖子内容',
  `boardId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`postId`),
  KEY `updatedAt` (`updatedAt`),
  KEY `hitCount` (`viewCount`),
  KEY `fk_bbs_post_bbs_board_idx` (`boardId`),
  KEY `fk_bbs_post_bbs_user1_idx` (`userId`),
  CONSTRAINT `fk_bbs_post_bbs_user1` FOREIGN KEY (`userId`) REFERENCES `bbs_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bbs_post_bbs_board` FOREIGN KEY (`boardId`) REFERENCES `bbs_board` (`boardId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bbs_post
-- ----------------------------

-- ----------------------------
-- Table structure for bbs_reply
-- ----------------------------
DROP TABLE IF EXISTS `bbs_reply`;
CREATE TABLE `bbs_reply` (
  `replyId` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '回复ID',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '回复时间',
  `content` text NOT NULL COMMENT '回复内容',
  `postId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`replyId`),
  KEY `fk_bbs_reply_bbs_post1_idx` (`postId`),
  KEY `fk_bbs_reply_bbs_user1_idx` (`userId`),
  CONSTRAINT `fk_bbs_reply_bbs_user1` FOREIGN KEY (`userId`) REFERENCES `bbs_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bbs_reply_bbs_post1` FOREIGN KEY (`postId`) REFERENCES `bbs_post` (`postId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bbs_reply
-- ----------------------------

-- ----------------------------
-- Table structure for bbs_user
-- ----------------------------
DROP TABLE IF EXISTS `bbs_user`;
CREATE TABLE `bbs_user` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `nickname` varchar(10) NOT NULL COMMENT '昵称',
  `avatar` varchar(200) NOT NULL COMMENT '头像',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '注册时间',
  `createdIp` int(11) NOT NULL COMMENT '注册IP',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `postCount` int(11) NOT NULL DEFAULT '0' COMMENT '发帖数量',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `nickname_UNIQUE` (`nickname`),
  KEY `score` (`score`),
  KEY `postCount` (`postCount`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bbs_user
-- ----------------------------
DROP TRIGGER IF EXISTS `onPostInsert`;
DELIMITER ;;
CREATE TRIGGER `onPostInsert` AFTER INSERT ON `bbs_post` FOR EACH ROW UPDATE `bbs_user` SET postCount=postCount+1 WHERE userId=new.userId
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `onPostDelete`;
DELIMITER ;;
CREATE TRIGGER `onPostDelete` AFTER DELETE ON `bbs_post` FOR EACH ROW UPDATE `bbs_user` SET postCount=postCount-1 WHERE userId=old.userId
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `onReplyInsert`;
DELIMITER ;;
CREATE TRIGGER `onReplyInsert` AFTER INSERT ON `bbs_reply` FOR EACH ROW UPDATE `bbs_post` SET replyCount=replyCount+1 WHERE postId = new.postId
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `onReplyDelete`;
DELIMITER ;;
CREATE TRIGGER `onReplyDelete` AFTER DELETE ON `bbs_reply` FOR EACH ROW UPDATE `bbs_post` SET replyCount=replyCount-1 WHERE postId = old.postId
;;
DELIMITER ;
