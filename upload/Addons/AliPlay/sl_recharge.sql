/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : directselling

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2015-04-07 09:13:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sl_recharge`
-- ----------------------------
DROP TABLE IF EXISTS `sl_recharge`;
CREATE TABLE `sl_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'uid',
  `order` varchar(255) DEFAULT NULL COMMENT '充值订单号',
  `trade_no` varchar(255) DEFAULT NULL COMMENT '支付宝订单号',
  `money` double DEFAULT '0' COMMENT '充值金额',
  `createtime` int(11) DEFAULT NULL COMMENT '充值时间',
  `recharge_way` varchar(255) DEFAULT NULL COMMENT '充值方式',
  `status` varchar(20) DEFAULT 'WAIT_BUYER_PAY' COMMENT '充值状态 WAIT_BUYER_PAY,TRADE_FINISHED,TRADE_SUCCESS',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
