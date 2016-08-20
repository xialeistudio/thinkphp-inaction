/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50619
Source Host           : localhost:3306
Source Database       : thinkphp_blog

Target Server Type    : MYSQL
Target Server Version : 50619
File Encoding         : 65001

Date: 2016-08-20 09:56:27
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
INSERT INTO `blog_admin` VALUES ('1', 'admin', '9738bfc57f4f9b2cffbf9c59470e5023', '0', '1471510466', '0.0.0.0');

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
  CONSTRAINT `fk_blog_article_blog_category` FOREIGN KEY (`categoryId`) REFERENCES `blog_category` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of blog_article
-- ----------------------------
INSERT INTO `blog_article` VALUES ('6', 'PHP', 'PHP（外文名:PHP: Hypertext Preprocessor，中文名：“超文本预处理器”）是一种通用开源脚本语言。语法吸收了C语言、Java和Perl的特点，利于学习，使用广泛，主要适用于W', 'http://www.baidu.com/img/logo.gif', '0', '1471328781', '1471328846', '1', '0', '&lt;p&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;PHP（外文名:PHP: Hypertext Preprocessor，中文名：“&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/156868.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;超文本&lt;/a&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/499651.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;预处理器&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;”）是一种通用&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/9664.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;开源&lt;/a&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/76320.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;脚本语言&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;。&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/135635.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;语法&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;吸收了&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/1219.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;C语言&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;、&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/29.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;Java&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;和&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/46614.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;Perl&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;的特点，利于学习，使用&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/344354.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;广泛&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;，主要适用于&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/3912.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;Web&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;开发领域。PHP 独特的&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/135635.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;语法&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;混合了&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/10075.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;C&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;、&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/29.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;Java&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;、&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/46614.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;Perl&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;以及&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/99.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;PHP&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;自创的语法。它可以比&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/32614.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;CGI&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;或者&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/46614.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;Perl&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;更快速地执行&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/348756.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;动态网页&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;。用PHP做出的&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/2065821.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;动态页面&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;与其他的&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/552871.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;编程语言&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;相比，&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/subview/99/5828265.htm&quot; data-lemmaid=&quot;9337&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;PHP&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;是将&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/17674.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;程序&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;嵌入到&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/692.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;HTML&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;（&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/5286041.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;标准通用标记语言&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;下的一个应用）文档中去执行，执行效率比完全生成&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/692.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;HTML&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;标记的&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/subview/32614/12037322.htm&quot; data-lemmaid=&quot;607810&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;CGI&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;要高许多；PHP还可以执行&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/69568.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;编译&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;后代码，编译可以达到&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/40927.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;加密&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;和&lt;/span&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://baike.baidu.com/view/548.htm&quot; style=&quot;color: rgb(19, 110, 194); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;优化&lt;/a&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: arial, 宋体, sans-serif; font-size: 14px; line-height: 24px; text-indent: 28px; white-space: normal;&quot;&gt;代码运行，使代码运行更快。&lt;/span&gt;&lt;/p&gt;', '3');
INSERT INTO `blog_article` VALUES ('7', '111222', '　　孟子曾在《孟子·告子下》说：故天将降大任于是人也，必先苦其心志，劳其筋骨，饿其体肤，空伐其身行，行弗乱其所为，所以动心忍性，曾益其所不能。其意思是指接收大任的人，都需要经历过心理和生理的磨难，才能', '', '0', '1471505341', '0', '1', '0', '&lt;p style=&quot;border: 0px; margin-top: 0px; margin-bottom: 0px; padding: 26px 0px 0px; font-size: 14px; color: rgb(51, 51, 51); word-wrap: break-word; font-family: 宋体; line-height: 26px; white-space: normal;&quot;&gt;　　&lt;span style=&quot;border: 0px; margin: 0px; padding: 0px;&quot;&gt;孟子曾在《孟子·告子下》说：故天将降大任于是人也，必先苦其心志，劳其筋骨，饿其体肤，空伐其身行，行弗乱其所为，所以动心忍性，曾益其所不能。其意思是指接收大任的人，都需要经历过心理和生理的磨难，才能成事。&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;border: 0px; margin-top: 0px; margin-bottom: 0px; padding: 26px 0px 0px; font-size: 14px; color: rgb(51, 51, 51); word-wrap: break-word; font-family: 宋体; line-height: 26px; white-space: normal; text-align: center;&quot;&gt;&lt;img src=&quot;http://img.mp.itc.cn/upload/20160818/658d81e54dac499aa40eb5a43c84fed7_th.jpg&quot; style=&quot;margin: 0px; padding: 0px; font-size: 0px; color: transparent; max-width: 650px;&quot;/&gt;&lt;/p&gt;&lt;p style=&quot;border: 0px; margin-top: 0px; margin-bottom: 0px; padding: 26px 0px 0px; font-size: 14px; color: rgb(51, 51, 51); word-wrap: break-word; font-family: 宋体; line-height: 26px; white-space: normal; text-align: center;&quot;&gt;&lt;span style=&quot;border: 0px; margin: 0px; padding: 0px;&quot;&gt;（苏炳添，创造了亚洲100米短跑的历史）&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '3');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of blog_category
-- ----------------------------
INSERT INTO `blog_category` VALUES ('3', 'PHP', '1', '1', '0');

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
  CONSTRAINT `fk_blog_comment_blog_article1` FOREIGN KEY (`articleId`) REFERENCES `blog_article` (`articleId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of blog_comment
-- ----------------------------
INSERT INTO `blog_comment` VALUES ('1', '1', '1471509985', '0.0.0.0', '2', '7');
INSERT INTO `blog_comment` VALUES ('2', '测试评论', '1471510193', '0.0.0.0', '测试评论', '7');
INSERT INTO `blog_comment` VALUES ('3', 'dcqwdw', '1471510349', '0.0.0.0', 'dcqwdw', '7');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of blog_link
-- ----------------------------
INSERT INTO `blog_link` VALUES ('2', 'www123', 'http://www.qq.com', '1', '0');
