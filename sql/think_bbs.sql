/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100108
Source Host           : localhost:3306
Source Database       : think_bbs

Target Server Type    : MYSQL
Target Server Version : 100108
File Encoding         : 65001

Date: 2016-10-28 17:41:04
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bbs_admin
-- ----------------------------
INSERT INTO `bbs_admin` VALUES ('1', 'xialeistudio', '99098ad83b7cbf38d611a6f44438d374', '2016-10-28 17:03:55', '0');

-- ----------------------------
-- Table structure for bbs_board
-- ----------------------------
DROP TABLE IF EXISTS `bbs_board`;
CREATE TABLE `bbs_board` (
  `boardId` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '版块ID',
  `name` varchar(10) NOT NULL COMMENT '版块名称',
  `icon` varchar(200) NOT NULL COMMENT '版块图标',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `rules` text NOT NULL COMMENT '版规',
  PRIMARY KEY (`boardId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bbs_board
-- ----------------------------
INSERT INTO `bbs_board` VALUES ('1', '灌水区', 'http://localhost/thinkphp-inaction/bbs/upload/2016-10-19/58072b8db2699.jpg', '1', '请遵守板块规则');

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
  `content` text NOT NULL COMMENT '帖子内容',
  `boardId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`postId`),
  KEY `updatedAt` (`updatedAt`),
  KEY `hitCount` (`viewCount`),
  KEY `fk_bbs_post_bbs_board_idx` (`boardId`),
  KEY `fk_bbs_post_bbs_user1_idx` (`userId`),
  CONSTRAINT `fk_bbs_post_bbs_board` FOREIGN KEY (`boardId`) REFERENCES `bbs_board` (`boardId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bbs_post_bbs_user1` FOREIGN KEY (`userId`) REFERENCES `bbs_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bbs_post
-- ----------------------------
INSERT INTO `bbs_post` VALUES ('1', '测试帖子', '9', '6', '2016-10-28 17:39:39', '2016-10-28 17:39:39', '测试帖子123222', '1', '1');

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
  CONSTRAINT `fk_bbs_reply_bbs_post1` FOREIGN KEY (`postId`) REFERENCES `bbs_post` (`postId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bbs_reply_bbs_user1` FOREIGN KEY (`userId`) REFERENCES `bbs_user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bbs_reply
-- ----------------------------
INSERT INTO `bbs_reply` VALUES ('4', '2016-10-28 16:29:23', '231', '1', '1');
INSERT INTO `bbs_reply` VALUES ('5', '2016-10-28 16:30:46', '12', '1', '1');
INSERT INTO `bbs_reply` VALUES ('6', '2016-10-28 16:30:48', '1', '1', '1');
INSERT INTO `bbs_reply` VALUES ('7', '2016-10-28 16:30:50', '1', '1', '1');
INSERT INTO `bbs_reply` VALUES ('8', '2016-10-28 16:30:54', '222', '1', '1');
INSERT INTO `bbs_reply` VALUES ('9', '2016-10-28 16:30:58', '2132', '1', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of bbs_user
-- ----------------------------
INSERT INTO `bbs_user` VALUES ('1', 'xialeistudio', '99098ad83b7cbf38d611a6f44438d374', '夏磊', 'http://localhost/thinkphp-inaction/bbs/upload/2016-10-22/580ae49f2d54e.jpg', '2016-10-28 17:36:03', '2130706433', '0', '1');
DROP TRIGGER IF EXISTS `onPostInsert`;
DELIMITER ;;
CREATE TRIGGER `onPostInsert` AFTER INSERT ON `bbs_post` FOR EACH ROW UPDATE `bbs_user` SET postCount=postCount+1 WHERE userId=new.userId
;
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `onPostDelete`;
DELIMITER ;;
CREATE TRIGGER `onPostDelete` AFTER DELETE ON `bbs_post` FOR EACH ROW UPDATE `bbs_user` SET postCount=postCount-1 WHERE userId=old.userId
;
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `onReplyInsert`;
DELIMITER ;;
CREATE TRIGGER `onReplyInsert` AFTER INSERT ON `bbs_reply` FOR EACH ROW UPDATE `bbs_post` SET replyCount=replyCount+1 WHERE postId = new.postId
;
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `onReplyDelete`;
DELIMITER ;;
CREATE TRIGGER `onReplyDelete` AFTER DELETE ON `bbs_reply` FOR EACH ROW UPDATE `bbs_post` SET replyCount=replyCount-1 WHERE postId = old.postId
;;
DELIMITER ;
SET FOREIGN_KEY_CHECKS=1;
