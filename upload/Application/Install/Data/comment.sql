/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : app

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-04-12 11:59:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cloud_comment
-- ----------------------------
DROP TABLE IF EXISTS `cloud_comment`;
CREATE TABLE `cloud_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户评论',
  `uid` int(11) DEFAULT NULL COMMENT '评论人',
  `app_type` varchar(200) DEFAULT 'article' COMMENT '评论应用类型,例如：article,shop',
  `app_detail_id` int(11) DEFAULT '0' COMMENT '评论应用的详细id',
  `pid` int(11) DEFAULT '0' COMMENT '回复时pid',
  `content` text COMMENT '评论内容',
  `status` tinyint(4) DEFAULT '2' COMMENT '-1：删除，0：禁用，1：正常，2：待审核',
  `likes` int(11) DEFAULT '0' COMMENT '喜欢',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_comment
-- ----------------------------
INSERT INTO `cloud_comment` VALUES ('1', '1', 'article', '0', '0', '你好，先生！', '2', '0', '12005487');
