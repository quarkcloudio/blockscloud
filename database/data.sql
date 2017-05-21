/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-05-22 01:48:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `apps`
-- ----------------------------
DROP TABLE IF EXISTS `apps`;
CREATE TABLE `apps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `context` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of apps
-- ----------------------------
INSERT INTO `apps` VALUES ('1', '我的电脑', 'finder', './images/apps/computer.png', '800', '450', '1', 'computer', '1.0.0', 'tangtanglove', '2', '1');
INSERT INTO `apps` VALUES ('2', '回收站', 'trash', './images/apps/TrashIcon.png', '800', '450', '2', 'recycle', '1.0.0', 'tangtanglove', '2', '1');
INSERT INTO `apps` VALUES ('3', '系统设置', 'setting', './images/apps/PrefApp.png', '800', '450', '3', 'setting', '1.0.0', 'tangtanglove', '2', '1');
INSERT INTO `apps` VALUES ('4', '应用中心', 'appstore', './images/apps/AppStore.png', '800', '560', '4', 'appstore', '1.0.0', 'tangtanglove', '2', '1');
INSERT INTO `apps` VALUES ('5', '控制台', 'terminal', './images/apps/Terminal.png', '800', '450', '5', 'terminal', '1.0.0', 'tangtanglove', '2', '1');
INSERT INTO `apps` VALUES ('6', 'Finder', 'finder', './images/apps/Finder.png', '800', '450', '6', 'finder', '1.0.0', 'tangtanglove', '2', '1');
INSERT INTO `apps` VALUES ('7', '文本编辑器', 'editor', './images/apps/Edit.png', '800', '450', '7', 'editor', '1.0.0', 'tangtanglove', '2', '1');
INSERT INTO `apps` VALUES ('8', '图片查看器', 'picture', './images/apps/NSApplicationIcon.png', '800', '450', '8', 'picture', '1.0.0', 'tangtanglove', '2', '1');
INSERT INTO `apps` VALUES ('9', '未知文件', 'unknown', './images/apps/unknown.png', '800', '450', '9', 'unknown', '1.0.0', 'tangtanglove', '1', '1');
INSERT INTO `apps` VALUES ('10', '音乐播放器', 'audio', './images/apps/iTunes.png', '420', '155', '10', 'audio', '1.0.0', 'tangtanglove', '1', '1');
INSERT INTO `apps` VALUES ('11', 'office', 'office', './images/apps/office.png', '960', '600', '11', 'office', '1.0.0', 'tangtanglove', '1', '1');
INSERT INTO `apps` VALUES ('12', '视频播放器', 'video', './images/apps/iMovie.png', '600', '450', '12', 'video', '1.0.0', 'tangtanglove', '1', '1');
INSERT INTO `apps` VALUES ('13', '游戏中心', 'game', './images/apps/GameCenter.png', '650', '500', '13', 'game', '1.0.0', 'tangtanglove', '1', '1');
INSERT INTO `apps` VALUES ('14', '文章', 'post', './images/apps/word.png', '1280', '620', '14', 'post', '1.0.0', 'tangtanglove', '1', '1');
INSERT INTO `apps` VALUES ('15', 'iCloud', 'icloud', './images/apps/iCloud.png', '1100', '600', '15', 'icloud', '1.0.0', 'tangtanglove', '1', '1');

-- ----------------------------
-- Table structure for `docks`
-- ----------------------------
DROP TABLE IF EXISTS `docks`;
CREATE TABLE `docks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of docks
-- ----------------------------
INSERT INTO `docks` VALUES ('1', '1', '3', '0');
INSERT INTO `docks` VALUES ('2', '1', '4', '1');
INSERT INTO `docks` VALUES ('3', '1', '6', '2');
INSERT INTO `docks` VALUES ('4', '1', '13', '3');
INSERT INTO `docks` VALUES ('5', '1', '14', '4');
INSERT INTO `docks` VALUES ('6', '1', '15', '0');

-- ----------------------------
-- Table structure for `key_values`
-- ----------------------------
DROP TABLE IF EXISTS `key_values`;
CREATE TABLE `key_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collection` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of key_values
-- ----------------------------
INSERT INTO `key_values` VALUES ('1', 'users.wallpaper', 'e5c637ad-827e-31ba-3a6a-153757fb2349', '{\"wallpaper\":1}');
INSERT INTO `key_values` VALUES ('2', 'website.config', 'e5c637ad-827e-31ba-3a6a-153757fb2349', '{\"web_site_title\":\"\\u79ef\\u6728\\u4e91-\\u60a8\\u7684\\u79c1\\u4eba\\u4e91\\u7a7a\\u95f4\",\"web_site_keyword\":\"\\u79ef\\u6728\\u4e91\\uff0c\\u79ef\\u6728\\u4e91\\u5b98\\u7f51\\u7f51\\u7ad9, \\u79ef\\u6728\\u4e91\\u5b98\\u7f51\",\"web_site_description\":\"\\u79ef\\u6728\\u4e91\\u662f\\u4e3a\\u7528\\u6237\\u7cbe\\u5fc3\\u6253\\u9020\\u7684\\u4e00\\u9879\\u667a\\u80fd\\u4e91\\u670d\\u52a1\\uff0c\\u60a8\\u7684\\u79c1\\u4eba\\u7f51\\u4e0a\\u5bb6\\u56ed\\u3002\",\"web_site_close\":1}');
INSERT INTO `key_values` VALUES ('3', 'post_cates.extend', 'ef23a27f-b23c-7507-d739-e4f8e7f3935d', '{\"lists_tpl\":\"lists\",\"detail_tpl\":\"detail\",\"page_num\":\"20\"}');
INSERT INTO `key_values` VALUES ('4', 'post_cates.extend', 'ba619c6f-c75c-645a-ee11-4cfa764b08ce', '{\"lists_tpl\":\"lists\",\"detail_tpl\":\"detail\",\"page_num\":\"8\"}');
INSERT INTO `key_values` VALUES ('5', 'post_cates.extend', 'cfc50b49-0548-bfef-befe-22427d63cec0', '{\"lists_tpl\":\"lists\",\"detail_tpl\":\"detail\",\"page_num\":\"8\"}');
INSERT INTO `key_values` VALUES ('6', 'post_cates.extend', '50ccc7b3-d9bb-fe73-f2fb-24b4a0efc2f8', '{\"lists_tpl\":\"lists\",\"detail_tpl\":\"detail\",\"page_num\":\"8\"}');
INSERT INTO `key_values` VALUES ('7', 'post_cates.extend', '5133771d-6150-79ce-43a2-11547f72b617', '{\"lists_tpl\":\"lists\",\"detail_tpl\":\"detail\",\"page_num\":\"8\"}');
INSERT INTO `key_values` VALUES ('8', 'post_cates.extend', 'bdb949d5-54f9-a99d-6b60-1348fcc87f85', '{\"lists_tpl\":\"lists\",\"detail_tpl\":\"detail\",\"page_num\":\"8\"}');
INSERT INTO `key_values` VALUES ('9', 'post_cates.extend', 'c3c056c9-1abc-8746-c071-cf8654572da0', '{\"lists_tpl\":\"lists\",\"detail_tpl\":\"detail\",\"page_num\":\"8\"}');

-- ----------------------------
-- Table structure for `menus`
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hide` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of menus
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2017_01_09_021806_create_apps_table', '1');
INSERT INTO `migrations` VALUES ('4', '2017_01_09_021846_create_system_file_infos_table', '1');
INSERT INTO `migrations` VALUES ('5', '2017_01_09_021928_create_key_values_table', '1');
INSERT INTO `migrations` VALUES ('6', '2017_01_09_021955_create_menus_table', '1');
INSERT INTO `migrations` VALUES ('7', '2017_01_09_022035_create_posts_table', '1');
INSERT INTO `migrations` VALUES ('8', '2017_01_09_022107_create_post_cates_table', '1');
INSERT INTO `migrations` VALUES ('9', '2017_01_09_022137_create_post_relationships_table', '1');
INSERT INTO `migrations` VALUES ('10', '2017_01_28_124943_create_docks', '1');
INSERT INTO `migrations` VALUES ('11', '2017_01_28_125050_create_wallpapers', '1');
INSERT INTO `migrations` VALUES ('12', '2017_02_05_131441_entrust_setup_tables', '1');
INSERT INTO `migrations` VALUES ('13', '2017_03_20_215213_create_navigations_table', '1');

-- ----------------------------
-- Table structure for `navigations`
-- ----------------------------
DROP TABLE IF EXISTS `navigations`;
CREATE TABLE `navigations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of navigations
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
-- Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'center/index/', '系统首页', '系统首页', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('2', 'center/user/info', '当前用户信息', '获取当前用户信息', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('3', 'center/user/changePassword', '修改密码', '修改密码', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('4', 'center/user/index', '用户列表', '获取用户列表', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('5', 'center/user/setStatus', '设置用户状态', '设置单个用户状态', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('6', 'center/user/setAllStatus', '批量设置用户状态', '批量设置用户状态', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('7', 'center/user/store', '新增用户', '新增用户', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('8', 'center/user/edit', '编辑用户页面', '编辑用户页面', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('9', 'center/user/update', '编辑用户方法', '编辑用户方法', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('10', 'center/user/roles', '用户所属用户组', '用户所属用户组', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('11', 'center/user/assignRole', '分配用户组', '用户分配用户组', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('12', 'center/role/index', '用户组列表', '用户组列表', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('13', 'center/role/setStatus', '设置用户组状态', '设置用户组状态', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('14', 'center/role/setAllStatus', '批量设置用户组状态', '批量设置用户组状态', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('15', 'center/role/store', '新增用户组', '新增用户组', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('16', 'center/role/edit', '编辑用户组页面', '编辑用户组页面', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('17', 'center/role/update', '编辑用户组方法', '编辑用户组方法', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('18', 'center/role/permissions', '权限所属用户组', '权限所属用户组', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('19', 'center/role/assignPermission', '权限分配用户组', '将权限分配用户组', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('20', 'center/permission/index', '权限列表', '权限列表', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('21', 'center/permission/setStatus', '设置权限状态', '设置单个权限状态', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('22', 'center/permission/setAllStatus', '批量设置权限状态', '批量设置权限状态', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('23', 'center/permission/store', '新增权限', '新增权限', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('24', 'center/permission/edit', '权限编辑页面', '权限编辑页面', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('25', 'center/permission/update', '权限编辑方法', '权限编辑方法', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('26', 'center/finder/index', 'Finder首页', 'Finder首页', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('27', 'center/finder/sidebar', '边栏列表', 'Finder边栏列表', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('28', 'center/finder/openPath', '打开路径', 'Finder打开路径', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('29', 'center/finder/deletePath', '删除路径', 'Finder删除路径', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('30', 'center/finder/renamePath', '重命名路径', 'Finder重命名路径', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('31', 'center/finder/makeDir', '创建文件夹', 'Finder创建文件夹', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('32', 'center/finder/makeFile', '创建文件', 'Finder创建文件', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('33', 'center/finder/emptyTrash', '清空回收站', 'Finder清空回收站', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('34', 'center/finder/movePath', '移动路径', 'Finder移动路径', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('35', 'center/finder/copyPath', '复制路径', 'Finder复制路径', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('36', 'center/editor/openFile', '打开文件', 'Editor打开文件', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('37', 'center/editor/saveFile', '保存文件', 'Editor保存文件', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('38', 'center/finder/uploadFile', '上传文件', 'Finder上传文件', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('39', 'center/finder/callbackMovePath', '回调移动路径', 'Finder上传文件后回调移动路径', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('40', 'center/finder/downloadFile', '下载文件', 'Finder下载文件', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('41', 'center/dock/index', 'Dock列表', 'Dock列表', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('42', 'center/wallpaper/info', '当前用户的壁纸', '当前用户设置的壁纸', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('43', 'center/wallpaper/index', '壁纸列表', '壁纸列表', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('44', 'center/wallpaper/setting', '设置壁纸', '设置壁纸', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('45', 'center/appstore/info', '应用的详细信息', '应用的详细信息', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('46', 'center/appstore/index', '应用列表', '应用列表', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('47', 'center/appstore/addToDesktop', '应用添加到桌面', '将应用添加到桌面', '2017-05-11 10:11:25', '2017-05-11 10:11:25');
INSERT INTO `permissions` VALUES ('48', 'center/appstore/addToDock', '应用添加到Dock', '将应用添加到Dock', '2017-05-11 10:11:25', '2017-05-11 10:11:25');

-- ----------------------------
-- Table structure for `permission_role`
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('1', '1');
INSERT INTO `permission_role` VALUES ('2', '1');
INSERT INTO `permission_role` VALUES ('3', '1');
INSERT INTO `permission_role` VALUES ('26', '1');
INSERT INTO `permission_role` VALUES ('27', '1');
INSERT INTO `permission_role` VALUES ('28', '1');
INSERT INTO `permission_role` VALUES ('29', '1');
INSERT INTO `permission_role` VALUES ('30', '1');
INSERT INTO `permission_role` VALUES ('31', '1');
INSERT INTO `permission_role` VALUES ('32', '1');
INSERT INTO `permission_role` VALUES ('33', '1');
INSERT INTO `permission_role` VALUES ('34', '1');
INSERT INTO `permission_role` VALUES ('35', '1');
INSERT INTO `permission_role` VALUES ('36', '1');
INSERT INTO `permission_role` VALUES ('37', '1');
INSERT INTO `permission_role` VALUES ('38', '1');
INSERT INTO `permission_role` VALUES ('39', '1');
INSERT INTO `permission_role` VALUES ('40', '1');
INSERT INTO `permission_role` VALUES ('41', '1');
INSERT INTO `permission_role` VALUES ('42', '1');
INSERT INTO `permission_role` VALUES ('43', '1');
INSERT INTO `permission_role` VALUES ('44', '1');
INSERT INTO `permission_role` VALUES ('45', '1');
INSERT INTO `permission_role` VALUES ('46', '1');
INSERT INTO `permission_role` VALUES ('47', '1');
INSERT INTO `permission_role` VALUES ('48', '1');

-- ----------------------------
-- Table structure for `posts`
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cover_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'post' COMMENT '文章类型（post/page/link等）',
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `comment` int(11) NOT NULL DEFAULT '0' COMMENT '评论数量',
  `view` int(11) NOT NULL DEFAULT '0' COMMENT '浏览数量',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comment_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('3', '1', '14f07f0f-2349-95ee-1e85-615f340d96f9', '你好，世界杯', '', '你好，世界杯', '', 'public/uploads/Xce2jneNbvF1c6uOEcWlfE45Rf2wtAqnuQK8Q0Yu.jpeg', '0', '0', 'article', '<p>你好，世界杯</p>', '0', '0', '2017-05-21 22:15:17', '2017-05-21 22:15:17', 'open', '1');

-- ----------------------------
-- Table structure for `post_cates`
-- ----------------------------
DROP TABLE IF EXISTS `post_cates`;
CREATE TABLE `post_cates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类缩略名',
  `taxonomy` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类方法(category/tags)',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类描述',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '文章数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of post_cates
-- ----------------------------
INSERT INTO `post_cates` VALUES ('1', 'ef23a27f-b23c-7507-d739-e4f8e7f3935d', '0', '文章', 'article', 'category', '', '0');
INSERT INTO `post_cates` VALUES ('2', 'ba619c6f-c75c-645a-ee11-4cfa764b08ce', '0', '视频', 'video', 'category', '', '0');
INSERT INTO `post_cates` VALUES ('3', 'cfc50b49-0548-bfef-befe-22427d63cec0', '0', '图片', 'picture', 'category', '', '0');
INSERT INTO `post_cates` VALUES ('4', '50ccc7b3-d9bb-fe73-f2fb-24b4a0efc2f8', '0', '种子', 'torrent', 'category', '', '0');
INSERT INTO `post_cates` VALUES ('5', '5133771d-6150-79ce-43a2-11547f72b617', '0', '磁链 ', 'magnet', 'category', '', '0');
INSERT INTO `post_cates` VALUES ('6', 'bdb949d5-54f9-a99d-6b60-1348fcc87f85', '0', '云盘', 'pan', 'category', '', '0');
INSERT INTO `post_cates` VALUES ('7', 'c3c056c9-1abc-8746-c071-cf8654572da0', '0', '文档', 'document', 'category', '', '0');

-- ----------------------------
-- Table structure for `post_relationships`
-- ----------------------------
DROP TABLE IF EXISTS `post_relationships`;
CREATE TABLE `post_relationships` (
  `object_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应文章ID/链接ID',
  `post_cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应分类方法ID',
  `sort` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of post_relationships
-- ----------------------------
INSERT INTO `post_relationships` VALUES ('1', '1', '0');
INSERT INTO `post_relationships` VALUES ('2', '0', '0');
INSERT INTO `post_relationships` VALUES ('3', '1', '0');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'base', '初级会员', '初级会员', '2017-05-11 10:11:25', '2017-05-11 10:11:25');

-- ----------------------------
-- Table structure for `role_user`
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of role_user
-- ----------------------------

-- ----------------------------
-- Table structure for `system_file_infos`
-- ----------------------------
DROP TABLE IF EXISTS `system_file_infos`;
CREATE TABLE `system_file_infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `app_id` int(11) NOT NULL,
  `context` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of system_file_infos
-- ----------------------------
INSERT INTO `system_file_infos` VALUES ('1', '文件夹', 'dir', './images/apps/GenericFolderIcon.png', '6', 'finder');
INSERT INTO `system_file_infos` VALUES ('2', '文本文件', 'txt', './images/apps/txt.png', '7', 'file');
INSERT INTO `system_file_infos` VALUES ('3', 'png文件', 'png', './images/apps/jpeg.png', '8', 'file');
INSERT INTO `system_file_infos` VALUES ('4', 'jpg文件', 'jpg', './images/apps/jpeg.png', '8', 'file');
INSERT INTO `system_file_infos` VALUES ('5', '未知文件类型', 'unknown', './images/apps/unknown.png', '9', 'file');
INSERT INTO `system_file_infos` VALUES ('6', 'mp3文件', 'mp3', './images/apps/mp3.png', '10', 'file');
INSERT INTO `system_file_infos` VALUES ('7', 'doc文件', 'doc', './images/apps/doc.png', '11', 'file');
INSERT INTO `system_file_infos` VALUES ('8', 'docx文件', 'docx', './images/apps/doc.png', '11', 'file');
INSERT INTO `system_file_infos` VALUES ('9', 'xls文件', 'xls', './images/apps/xls.png', '11', 'file');
INSERT INTO `system_file_infos` VALUES ('10', 'ppt文件', 'ppt', './images/apps/ppt.png', '11', 'file');
INSERT INTO `system_file_infos` VALUES ('11', 'mp4文件', 'mp4', './images/apps/video.png', '12', 'file');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'e5c637ad-827e-31ba-3a6a-153757fb2349', 'administrator', 'admin@admin.com', '$2y$10$/WYxXWhlP768TELZ/.M/TOLKkrL0Yi4xVJJPgoSHn2cjIRxgWxr8u', '1', null, '2017-05-11 22:11:25', '2017-05-11 22:11:25');

-- ----------------------------
-- Table structure for `wallpapers`
-- ----------------------------
DROP TABLE IF EXISTS `wallpapers`;
CREATE TABLE `wallpapers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cover_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of wallpapers
-- ----------------------------
INSERT INTO `wallpapers` VALUES ('1', 'AndromedaGalaxy', './images/wallpapers/1.jpg');
INSERT INTO `wallpapers` VALUES ('2', 'Beach', './images/wallpapers/2.jpg');
INSERT INTO `wallpapers` VALUES ('3', 'DucksonaMistyPond', './images/wallpapers/3.jpg');
INSERT INTO `wallpapers` VALUES ('4', 'EagleWaterfall', './images/wallpapers/4.jpg');
INSERT INTO `wallpapers` VALUES ('5', 'Flamingos', './images/wallpapers/5.jpg');
INSERT INTO `wallpapers` VALUES ('6', 'ForestinMist', './images/wallpapers/6.jpg');
INSERT INTO `wallpapers` VALUES ('7', 'Isles', './images/wallpapers/7.jpg');
INSERT INTO `wallpapers` VALUES ('8', 'Lake', './images/wallpapers/8.jpg');
INSERT INTO `wallpapers` VALUES ('9', 'MtFuji', './images/wallpapers/9.jpg');
INSERT INTO `wallpapers` VALUES ('10', 'PinForest', './images/wallpapers/10.jpg');
INSERT INTO `wallpapers` VALUES ('11', 'Lion', './images/wallpapers/11.jpg');
INSERT INTO `wallpapers` VALUES ('12', 'Moon', './images/wallpapers/12.jpg');
