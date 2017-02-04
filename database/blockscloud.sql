/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-01-09 01:27:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `apps`
-- ----------------------------
DROP TABLE IF EXISTS `apps`;
CREATE TABLE `apps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `context` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '1' COMMENT '1:普通程序,2:系统程序',
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of apps
-- ----------------------------
INSERT INTO `apps` VALUES ('1', '我的电脑', 'finder', './images/apps/com.apple.imac-aluminum-24.png', '800', '450', '1', 'computer', '1.0.0', '1', '1');
INSERT INTO `apps` VALUES ('2', '回收站', 'trash', './images/apps/TrashIcon.png', '800', '450', '2', 'recycle', '1.0.0', '1', '1');
INSERT INTO `apps` VALUES ('3', '系统设置', 'setting', './images/apps/PrefApp.png', '800', '450', '3', 'setting', '1.0.0', '1', '1');
INSERT INTO `apps` VALUES ('4', '应用程序', 'appstore', './images/apps/app.png', '800', '450', '4', 'appstore', '1.0.0', '1', '1');
INSERT INTO `apps` VALUES ('5', '控制台', 'terminal', './images/apps/Terminal.png', '800', '450', '5', 'terminal', '1.0.0', '1', '1');
INSERT INTO `apps` VALUES ('6', 'Finder', 'finder', './images/apps/GenericFolderIcon.png', '800', '450', '0', 'finder', '1.0.0', '1', '1');
INSERT INTO `apps` VALUES ('7', '文本编辑器', 'editor', './images/apps/txt.png', '800', '450', '0', 'editor', '1.0.0', '1', '1');

-- ----------------------------
-- Table structure for `default_open`
-- ----------------------------
DROP TABLE IF EXISTS `default_open`;
CREATE TABLE `default_open` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL COMMENT '文件类型',
  `app_id` int(11) DEFAULT NULL COMMENT '默认打开方式',
  `context` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_open
-- ----------------------------
INSERT INTO `default_open` VALUES ('1', '文件夹', 'dir', '6', 'finder');
INSERT INTO `default_open` VALUES ('2', '文本文件', 'txt', '7', 'txt');

-- ----------------------------
-- Table structure for `goods`
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '商品名称',
  `num` int(11) NOT NULL COMMENT '商品库存数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `description` text NOT NULL COMMENT '商品描述',
  `standard` varchar(255) NOT NULL COMMENT '规格型号',
  `cover_path` varchar(255) NOT NULL COMMENT '封面图',
  `photo_path_1` varchar(255) DEFAULT NULL,
  `photo_path_2` varchar(255) DEFAULT NULL,
  `photo_path_3` varchar(255) DEFAULT NULL,
  `content` text NOT NULL COMMENT '商品详情',
  `click_count` int(11) NOT NULL DEFAULT '0' COMMENT '商品点击数',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:上架，2：下架',
  `is_best` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为精品',
  `is_new` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为新品',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为热销',
  `sell_num` int(11) NOT NULL DEFAULT '0' COMMENT '已经出售的数量',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `score_num` tinyint(2) NOT NULL DEFAULT '1' COMMENT '平均评分',
  `score` int(11) DEFAULT '0' COMMENT '赠送积分',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods
-- ----------------------------

-- ----------------------------
-- Table structure for `goods_cates`
-- ----------------------------
DROP TABLE IF EXISTS `goods_cates`;
CREATE TABLE `goods_cates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL COMMENT '分类名',
  `slug` varchar(200) NOT NULL COMMENT '缩略名',
  `cover_path` varchar(200) NOT NULL COMMENT '分类封面图',
  `pid` int(11) NOT NULL DEFAULT '0',
  `page_num` int(11) NOT NULL,
  `lists_tpl` varchar(200) NOT NULL,
  `detail_tpl` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:启用，2：禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods_cates
-- ----------------------------

-- ----------------------------
-- Table structure for `goods_cate_relationships`
-- ----------------------------
DROP TABLE IF EXISTS `goods_cate_relationships`;
CREATE TABLE `goods_cate_relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods_cate_relationships
-- ----------------------------

-- ----------------------------
-- Table structure for `key_values`
-- ----------------------------
DROP TABLE IF EXISTS `key_values`;
CREATE TABLE `key_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collection` varchar(128) NOT NULL COMMENT '命名集合键和值对',
  `uuid` varchar(128) NOT NULL DEFAULT 'default' COMMENT '系统唯一标识',
  `data` longtext NOT NULL COMMENT 'The value.',
  PRIMARY KEY (`id`,`collection`,`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of key_values
-- ----------------------------

-- ----------------------------
-- Table structure for `menus`
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menus
-- ----------------------------

-- ----------------------------
-- Table structure for `messages`
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` char(11) NOT NULL COMMENT '手机号',
  `email` varchar(100) NOT NULL COMMENT '邮箱地址',
  `nickname` varchar(30) NOT NULL COMMENT '姓名',
  `content` varchar(255) NOT NULL COMMENT '留言内容',
  `createtime` int(11) unsigned NOT NULL COMMENT '留言时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态，0正常，-1删除，1已回复',
  `responsetime` int(11) NOT NULL,
  `response` varchar(255) NOT NULL,
  `updatetime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of messages
-- ----------------------------

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2016_12_29_110841_install', '2');

-- ----------------------------
-- Table structure for `orders`
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(128) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `order_no` varchar(20) NOT NULL COMMENT '订单号',
  `print_no` varchar(30) DEFAULT NULL COMMENT '小票打印机单号',
  `express_type` varchar(100) DEFAULT NULL COMMENT '快递方式',
  `express_no` varchar(100) DEFAULT NULL COMMENT '快递编号',
  `pay_type` varchar(10) NOT NULL COMMENT '支付方式',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额',
  `createtime` int(11) NOT NULL,
  `is_pay` int(11) NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL COMMENT '支付状态',
  `memo` varchar(255) DEFAULT NULL COMMENT '订单备注',
  `consignee_name` varchar(100) DEFAULT NULL COMMENT '收货人',
  `address` text COMMENT '收货地址',
  `mobile` varchar(11) DEFAULT NULL COMMENT '收货人电话',
  PRIMARY KEY (`id`,`uuid`,`order_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for `orders_address`
-- ----------------------------
DROP TABLE IF EXISTS `orders_address`;
CREATE TABLE `orders_address` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `consignee_name` varchar(100) NOT NULL COMMENT '收货人',
  `province` varchar(100) NOT NULL COMMENT '省',
  `city` varchar(100) NOT NULL COMMENT '市',
  `county` varchar(100) NOT NULL COMMENT '县/区',
  `address` text NOT NULL COMMENT '详细地址',
  `mobile` varchar(11) NOT NULL COMMENT '联系电话',
  `status` int(10) NOT NULL DEFAULT '1' COMMENT '1-正常 -1-已删除',
  `default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为默认收货地址1-是 0-否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders_address
-- ----------------------------

-- ----------------------------
-- Table structure for `orders_goods`
-- ----------------------------
DROP TABLE IF EXISTS `orders_goods`;
CREATE TABLE `orders_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(11) NOT NULL COMMENT '订单号',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `name` varchar(255) NOT NULL,
  `num` int(10) NOT NULL COMMENT '购买数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `description` text NOT NULL,
  `standard` varchar(255) NOT NULL,
  `cover_path` varchar(255) NOT NULL,
  `is_comment` varchar(10) NOT NULL DEFAULT '-1' COMMENT '商品是否评论 -1-否  1-是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `orders_status`
-- ----------------------------
DROP TABLE IF EXISTS `orders_status`;
CREATE TABLE `orders_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) NOT NULL COMMENT '订单号',
  `approve_uid` int(50) DEFAULT NULL COMMENT '审核人',
  `trade_no` varchar(50) DEFAULT NULL COMMENT '支付接口流水号',
  `trade_status` varchar(50) DEFAULT NULL COMMENT '支付接口状态',
  `status` varchar(30) NOT NULL COMMENT 'nopaid-未支付 paid-已支付,待发货  shipped-已发货  completed-收货已完成',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders_status
-- ----------------------------

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `posts`
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增唯一ID',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '对应作者ID',
  `uuid` varchar(128) NOT NULL,
  `createtime` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `content` longtext NOT NULL COMMENT '正文',
  `title` text NOT NULL COMMENT '标题',
  `description` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'publish' COMMENT '文章状态（publish/draft/inherit等）',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open' COMMENT '评论状态（open/closed）',
  `password` varchar(20) NOT NULL DEFAULT '' COMMENT '文章密码',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '文章缩略名',
  `updatetime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父文章，主要用于PAGE',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `type` varchar(20) NOT NULL DEFAULT 'post' COMMENT '文章类型（post/page等）',
  `comment` bigint(20) NOT NULL DEFAULT '0' COMMENT '评论总数',
  `view` int(11) NOT NULL DEFAULT '0' COMMENT '文章浏览量',
  PRIMARY KEY (`id`),
  KEY `post_name` (`name`(191)),
  KEY `type_status_date` (`type`,`status`,`createtime`,`id`),
  KEY `post_parent` (`pid`),
  KEY `post_author` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of posts
-- ----------------------------

-- ----------------------------
-- Table structure for `posts_cates`
-- ----------------------------
DROP TABLE IF EXISTS `posts_cates`;
CREATE TABLE `posts_cates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `uuid` varchar(128) NOT NULL,
  `pid` bigint(20) DEFAULT NULL,
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '分类名',
  `slug` varchar(200) NOT NULL DEFAULT '' COMMENT '缩略名',
  `taxonomy` varchar(32) DEFAULT NULL COMMENT '分类方法(category)',
  `description` text,
  `count` bigint(20) DEFAULT NULL COMMENT '文章数统计',
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of posts_cates
-- ----------------------------

-- ----------------------------
-- Table structure for `posts_relationships`
-- ----------------------------
DROP TABLE IF EXISTS `posts_relationships`;
CREATE TABLE `posts_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '对应文章ID/链接ID',
  `posts_cate_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '对应分类方法ID',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`posts_cate_id`),
  KEY `term_taxonomy_id` (`posts_cate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of posts_relationships
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'administrator', 'admin@admin.com', '$2y$10$kOYbpQanpAIUdmPTaKH2POB.cQtaYiB9JRyshHU3hEJ/emARWv3/S', null, '2016-12-29 12:58:07', '2016-12-29 12:58:07');
