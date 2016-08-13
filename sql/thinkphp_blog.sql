/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50619
Source Host           : localhost:3306
Source Database       : thinkphp_blog

Target Server Type    : MYSQL
Target Server Version : 50619
File Encoding         : 65001

Date: 2016-08-13 14:28:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for blog_admin
-- ----------------------------
DROP TABLE IF EXISTS `blog_admin`;
CREATE TABLE `blog_admin` (
  `adminId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '账号',
  `password` char(32) NOT NULL COMMENT '密码',
  `createdAt` int(10) NOT NULL COMMENT '添加时间',
  `loginAt` int(11) NOT NULL DEFAULT '0' COMMENT '最近登录时间',
  `loginIp` varchar(15) NOT NULL DEFAULT '' COMMENT '最近登录IP',
  PRIMARY KEY (`adminId`),
  KEY `createdAt` (`createdAt`),
  KEY `account` (`username`,`password`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of blog_admin
-- ----------------------------
INSERT INTO `blog_admin` VALUES ('1', 'admin', '6f1779da8462d85c012588fb73a2efb7', '0', '0', '');

-- ----------------------------
-- Table structure for blog_article
-- ----------------------------
DROP TABLE IF EXISTS `blog_article`;
CREATE TABLE `blog_article` (
  `articleId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL COMMENT '标题',
  `description` varchar(100) NOT NULL DEFAULT '' COMMENT '简介',
  `image` varchar(128) NOT NULL DEFAULT '' COMMENT '封面图片',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击数',
  `createdAt` int(11) NOT NULL COMMENT '添加时间',
  `updateAt` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `content` text NOT NULL COMMENT '文章内容',
  `categoryId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`articleId`),
  KEY `hit` (`hits`),
  KEY `createdAt` (`createdAt`),
  KEY `status` (`status`),
  KEY `sort` (`sort`),
  KEY `fk_blog_article_blog_category_idx` (`categoryId`),
  CONSTRAINT `fk_blog_article_blog_category` FOREIGN KEY (`categoryId`) REFERENCES `blog_category` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of blog_article
-- ----------------------------

-- ----------------------------
-- Table structure for blog_category
-- ----------------------------
DROP TABLE IF EXISTS `blog_category`;
CREATE TABLE `blog_category` (
  `categoryId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '分类名称',
  `isNav` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示在导航栏',
  `total` int(11) NOT NULL DEFAULT '0' COMMENT '文章总数',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`categoryId`),
  KEY `sort` (`total`),
  KEY `total` (`total`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of blog_category
-- ----------------------------

-- ----------------------------
-- Table structure for blog_comment
-- ----------------------------
DROP TABLE IF EXISTS `blog_comment`;
CREATE TABLE `blog_comment` (
  `commentId` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL COMMENT '昵称',
  `createdAt` int(11) NOT NULL COMMENT '评论时间',
  `createdIp` varchar(15) NOT NULL COMMENT 'ip地址',
  `content` text NOT NULL COMMENT '评论内容',
  `articleId` int(11) NOT NULL,
  PRIMARY KEY (`commentId`),
  KEY `created` (`createdAt`),
  KEY `fk_blog_comment_blog_article1_idx` (`articleId`),
  CONSTRAINT `fk_blog_comment_blog_article1` FOREIGN KEY (`articleId`) REFERENCES `blog_article` (`articleId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of blog_comment
-- ----------------------------

-- ----------------------------
-- Table structure for blog_link
-- ----------------------------
DROP TABLE IF EXISTS `blog_link`;
CREATE TABLE `blog_link` (
  `linkId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '站点名称',
  `link` varchar(100) NOT NULL COMMENT '链接地址',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`linkId`),
  KEY `sort` (`sort`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of blog_link
-- ----------------------------
