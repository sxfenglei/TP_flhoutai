/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.24-log : Database - fl_houtai
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`fl_houtai` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `fl_houtai`;

/*Table structure for table `fl_admin` */

DROP TABLE IF EXISTS `fl_admin`;

CREATE TABLE `fl_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_name` varchar(30) NOT NULL COMMENT '登录名',
  `tel` varchar(15) NOT NULL COMMENT '电话',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `login_pwd` varchar(64) NOT NULL COMMENT '登录密码 md5',
  `token` varchar(64) NOT NULL COMMENT 'token',
  `nickname` varchar(30) NOT NULL DEFAULT '匿名管理员' COMMENT '昵称',
  `img_url` varchar(100) NOT NULL COMMENT '头像URL',
  `last_login_time` int(11) NOT NULL COMMENT '上次登录时间',
  `last_login_ip` varchar(25) NOT NULL COMMENT '上次登录IP',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态 默认1正常 0禁用 -1删除',
  `updatetime` int(11) NOT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='后台管理员表';

/*Data for the table `fl_admin` */

insert  into `fl_admin`(`id`,`login_name`,`tel`,`email`,`login_pwd`,`token`,`nickname`,`img_url`,`last_login_time`,`last_login_ip`,`login_count`,`status`,`updatetime`,`createtime`) values (1,'admin','','','e10adc3949ba59abbe56e057f20f883e','','超级管理员','',0,'',0,1,0,NULL),(2,'ht','13400000001','442165035@qq.com','e10adc3949ba59abbe56e057f20f883e','','后台管理员','/Public/uploads/1451286708.png',0,'',0,1,1451378314,1451287254),(3,'xm','12344444444','ywzg@test.com','e10adc3949ba59abbe56e057f20f883e','','项目经理','/Public/uploads/1451292116.png',0,'',0,1,1451378302,1451289762),(4,'yh','18000000000','jingjiren001@test.com','e10adc3949ba59abbe56e057f20f883e','','用户管理员','/Public/uploads/1451378290.png',0,'',0,1,0,1451378291);

/*Table structure for table `fl_auth_group` */

DROP TABLE IF EXISTS `fl_auth_group`;

CREATE TABLE `fl_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  `rules_str` text NOT NULL COMMENT '角色拥有的权限名称',
  `desc` varchar(100) NOT NULL COMMENT '角色描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `fl_auth_group` */

insert  into `fl_auth_group`(`id`,`title`,`status`,`rules`,`rules_str`,`desc`) values (1,'后台管理员',1,'1,22,11,10,9,8,7,13,21,2,23,3,4,5,6,17','默认后台首页,权限分类编辑,查看角色拥有的用户,角色分配权限,角色编辑,角色删除,角色添加,权限分类列表,权限分类添加,权限列表,权限分类删除,权限添加,权限编辑,权限删除,角色列表,系统用户列表','网站后台的管理员权限角色'),(2,'项目经理',1,'1','默认后台首页','项目总BOSS'),(3,'用户管理',1,'1,17,18,19,20','默认后台首页,系统用户列表,系统用户添加,系统用户编辑,系统用户删除','管理系统中的普通用户');

/*Table structure for table `fl_auth_group_access` */

DROP TABLE IF EXISTS `fl_auth_group_access`;

CREATE TABLE `fl_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `fl_auth_group_access` */

insert  into `fl_auth_group_access`(`uid`,`group_id`) values (2,1),(3,2),(4,3);

/*Table structure for table `fl_auth_rule` */

DROP TABLE IF EXISTS `fl_auth_rule`;

CREATE TABLE `fl_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则描述',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '附加规则',
  `classify` int(11) NOT NULL COMMENT '权限分类',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `fl_auth_rule` */

insert  into `fl_auth_rule`(`id`,`name`,`title`,`type`,`status`,`condition`,`classify`) values (1,'Admin/Index/index','默认后台首页',1,1,'',1),(2,'Admin/Auth/accessList','权限列表',1,1,'',2),(3,'Admin/Auth/accessAdd','权限添加',1,1,'',2),(4,'Admin/Auth/accessEdit','权限编辑',1,1,'',2),(5,'Admin/Auth/accessDel','权限删除',1,1,'',2),(6,'Admin/Auth/ruleList','角色列表',1,1,'',2),(21,'Admin/Auth/classifyAdd','权限分类添加',1,1,'',2),(13,'Admin/Auth/classifyList','权限分类列表',1,1,'',2),(7,'Admin/Auth/ruleAdd','角色添加',1,1,'',2),(8,'Admin/Auth/ruleDel','角色删除',1,1,'',2),(9,'Admin/Auth/ruleEdit','角色编辑',1,1,'',2),(10,'Admin/Auth/ruleAllot','角色分配权限',1,1,'',2),(11,'Admin/Auth/ruleUser','查看角色拥有的用户',1,1,'',2),(17,'Admin/Admin/adminList','系统用户列表',1,1,'',3),(18,'Admin/Admin/adminAdd','系统用户添加',1,1,'',3),(19,'Admin/Admin/adminEdit','系统用户编辑',1,1,'',3),(20,'Admin/Admin/adminDel','系统用户删除',1,1,'',3),(22,'Admin/Auth/classifyEdit','权限分类编辑',1,1,'',2),(23,'Admin/Auth/classifyDel','权限分类删除',1,1,'',2);

/*Table structure for table `fl_auth_rule_classify` */

DROP TABLE IF EXISTS `fl_auth_rule_classify`;

CREATE TABLE `fl_auth_rule_classify` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='权限大分类';

/*Data for the table `fl_auth_rule_classify` */

insert  into `fl_auth_rule_classify`(`id`,`name`,`pid`,`status`) values (1,'默认基础权限管理',0,1),(2,'权限管理',0,1),(3,'系统用户管理',0,1),(4,'系统设置权限管理',0,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
