/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : sns

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-03-16 22:16:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cloud_action`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_action`;
CREATE TABLE `cloud_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` char(140) NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text COMMENT '行为规则',
  `log` text COMMENT '日志规则',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统行为表';

-- ----------------------------
-- Records of cloud_action
-- ----------------------------
INSERT INTO `cloud_action` VALUES ('1', 'user_login', '用户登录', '积分+10，每天一次', 'table:member|field:score|condition:uid={$self} AND status>-1|rule:score+10|cycle:24|max:1;', '[user|get_nickname]在[time|time_format]登录了后台', '1', '1', '1387181220');
INSERT INTO `cloud_action` VALUES ('2', 'add_article', '发布文章', '积分+5，每天上限5次', 'table:member|field:score|condition:uid={$self}|rule:score+5|cycle:24|max:5', '', '2', '0', '1380173180');
INSERT INTO `cloud_action` VALUES ('3', 'review', '评论', '评论积分+1，无限制', 'table:member|field:score|condition:uid={$self}|rule:score+1', '', '2', '1', '1383285646');
INSERT INTO `cloud_action` VALUES ('4', 'add_document', '发表文档', '积分+10，每天上限5次', 'table:member|field:score|condition:uid={$self}|rule:score+10|cycle:24|max:5', '[user|get_nickname]在[time|time_format]发表了一篇文章。\r\n表[model]，记录编号[record]。', '2', '0', '1386139726');
INSERT INTO `cloud_action` VALUES ('5', 'add_document_topic', '发表讨论', '积分+5，每天上限10次', 'table:member|field:score|condition:uid={$self}|rule:score+5|cycle:24|max:10', '', '2', '0', '1383285551');
INSERT INTO `cloud_action` VALUES ('6', 'update_config', '更新配置', '新增或修改或删除配置', '', '', '1', '1', '1383294988');
INSERT INTO `cloud_action` VALUES ('7', 'update_model', '更新模型', '新增或修改模型', '', '', '1', '1', '1383295057');
INSERT INTO `cloud_action` VALUES ('8', 'update_attribute', '更新属性', '新增或更新或删除属性', '', '', '1', '1', '1383295963');
INSERT INTO `cloud_action` VALUES ('9', 'update_channel', '更新导航', '新增或修改或删除导航', '', '', '1', '1', '1383296301');
INSERT INTO `cloud_action` VALUES ('10', 'update_menu', '更新菜单', '新增或修改或删除菜单', '', '', '1', '1', '1383296392');
INSERT INTO `cloud_action` VALUES ('11', 'update_category', '更新分类', '新增或修改或删除分类', '', '', '1', '1', '1383296765');

-- ----------------------------
-- Table structure for `cloud_action_log`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_action_log`;
CREATE TABLE `cloud_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '触发行为的数据id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  PRIMARY KEY (`id`),
  KEY `action_ip_ix` (`action_ip`),
  KEY `action_id_ix` (`action_id`),
  KEY `user_id_ix` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='行为日志表';

-- ----------------------------
-- Records of cloud_action_log
-- ----------------------------
INSERT INTO `cloud_action_log` VALUES ('1', '1', '1', '0', 'member', '1', 'Administrator在2016-03-14 20:28登录了后台', '1', '1457958489');
INSERT INTO `cloud_action_log` VALUES ('2', '11', '1', '0', 'category', '2', '操作url：/web/blockscloud/sns/trunk/admin.php?s=/Category/edit.html', '1', '1457958564');
INSERT INTO `cloud_action_log` VALUES ('3', '11', '1', '0', 'category', '1', '操作url：/web/blockscloud/sns/trunk/admin.php?s=/Category/edit.html', '1', '1457958574');
INSERT INTO `cloud_action_log` VALUES ('4', '11', '1', '0', 'category', '2', '操作url：/web/blockscloud/sns/trunk/admin.php?s=/Category/edit.html', '1', '1457959800');
INSERT INTO `cloud_action_log` VALUES ('5', '1', '1', '0', 'member', '1', 'Administrator在2016-03-16 22:02登录了后台', '1', '1458136933');

-- ----------------------------
-- Table structure for `cloud_addons`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_addons`;
CREATE TABLE `cloud_addons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `has_adminlist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='插件表';

-- ----------------------------
-- Records of cloud_addons
-- ----------------------------
INSERT INTO `cloud_addons` VALUES ('15', 'EditorForAdmin', '后台编辑器', '用于增强整站长文本的输入和显示', '1', '{\"editor_type\":\"2\",\"editor_wysiwyg\":\"1\",\"editor_height\":\"500px\",\"editor_resize_type\":\"1\"}', 'thinkphp', '0.1', '1383126253', '0');
INSERT INTO `cloud_addons` VALUES ('2', 'SiteStat', '站点统计信息', '统计站点的基础信息', '1', '{\"title\":\"\\u7cfb\\u7edf\\u4fe1\\u606f\",\"width\":\"1\",\"display\":\"1\",\"status\":\"0\"}', 'thinkphp', '0.1', '1379512015', '0');
INSERT INTO `cloud_addons` VALUES ('3', 'DevTeam', '开发团队信息', '开发团队成员信息', '1', '{\"title\":\"Blockscloud\\u5f00\\u53d1\\u56e2\\u961f\",\"width\":\"2\",\"display\":\"1\"}', 'thinkphp', '0.1', '1379512022', '0');
INSERT INTO `cloud_addons` VALUES ('4', 'SystemInfo', '系统环境信息', '用于显示一些服务器的信息', '1', '{\"title\":\"\\u7cfb\\u7edf\\u4fe1\\u606f\",\"width\":\"2\",\"display\":\"1\"}', 'thinkphp', '0.1', '1379512036', '0');
INSERT INTO `cloud_addons` VALUES ('5', 'Editor', '前台编辑器', '用于增强整站长文本的输入和显示', '1', '{\"editor_type\":\"2\",\"editor_wysiwyg\":\"3\",\"editor_height\":\"300px\",\"editor_resize_type\":\"1\"}', 'thinkphp', '0.1', '1379830910', '0');
INSERT INTO `cloud_addons` VALUES ('6', 'Attachment', '附件', '用于文档模型上传附件', '1', 'null', 'thinkphp', '0.1', '1379842319', '1');
INSERT INTO `cloud_addons` VALUES ('9', 'SocialComment', '通用社交化评论', '集成了各种社交化评论插件，轻松集成到系统中。', '1', '{\"comment_type\":\"1\",\"comment_uid_youyan\":\"\",\"comment_short_name_duoshuo\":\"\",\"comment_data_list_duoshuo\":\"\"}', 'thinkphp', '0.1', '1380273962', '0');

-- ----------------------------
-- Table structure for `cloud_apps`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_apps`;
CREATE TABLE `cloud_apps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '模块名',
  `title` varchar(30) NOT NULL COMMENT '中文名',
  `version` varchar(20) NOT NULL COMMENT '版本号',
  `is_com` tinyint(4) NOT NULL COMMENT '是否商业版',
  `description` varchar(200) NOT NULL COMMENT '简介',
  `author` varchar(50) NOT NULL COMMENT '开发者',
  `website` varchar(200) NOT NULL COMMENT '网址',
  `entry` varchar(50) NOT NULL COMMENT '前台入口',
  `shortcut_name` varchar(30) NOT NULL,
  `shortcut_url` varchar(200) NOT NULL,
  `shortcut_img_url` varchar(200) NOT NULL,
  `is_setup` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否已安装',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='模块管理表';

-- ----------------------------
-- Records of cloud_apps
-- ----------------------------
INSERT INTO `cloud_apps` VALUES ('1', 'Home', '系统内置文章模块', '1.0.0', '0', '系统内置文章模块', '上海顶想信息科技有限公司', 'http://www.topthink.net/', 'Home/index/index', '文章管理', './admin.php?s=/category/index', './Application/Forum/icon.png', '0');
INSERT INTO `cloud_apps` VALUES ('2', 'Shop', '积分商城', '1.0.0', '0', '积分商城模块，用户可以使用积分兑换商品', '嘉兴想天信息科技有限公司', 'http://www.ourstu.com', 'Shop/index/index', '商城管理', 'Admin/Shop/shopCategory', './Application/Shop/icon.png', '0');

-- ----------------------------
-- Table structure for `cloud_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_attachment`;
CREATE TABLE `cloud_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '附件显示名',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件类型',
  `source` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '资源ID',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联记录ID',
  `download` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '附件大小',
  `dir` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '上级目录ID',
  `sort` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `idx_record_status` (`record_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件表';

-- ----------------------------
-- Records of cloud_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for `cloud_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_attribute`;
CREATE TABLE `cloud_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段注释',
  `field` varchar(100) NOT NULL DEFAULT '' COMMENT '字段定义',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `value` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  `model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型id',
  `is_must` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否必填',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `validate_rule` varchar(255) NOT NULL DEFAULT '',
  `validate_time` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `error_info` varchar(100) NOT NULL DEFAULT '',
  `validate_type` varchar(25) NOT NULL DEFAULT '',
  `auto_rule` varchar(100) NOT NULL DEFAULT '',
  `auto_time` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `auto_type` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='模型属性表';

-- ----------------------------
-- Records of cloud_attribute
-- ----------------------------
INSERT INTO `cloud_attribute` VALUES ('1', 'uid', '用户ID', 'int(10) unsigned NOT NULL ', 'num', '0', '', '0', '', '1', '0', '1', '1384508362', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('2', 'name', '标识', 'char(40) NOT NULL ', 'string', '', '同一根节点下标识不重复', '1', '', '1', '0', '1', '1383894743', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('3', 'title', '标题', 'char(80) NOT NULL ', 'string', '', '文档标题', '1', '', '1', '0', '1', '1383894778', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('4', 'category_id', '所属分类', 'int(10) unsigned NOT NULL ', 'string', '', '', '0', '', '1', '0', '1', '1384508336', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('5', 'description', '描述', 'char(140) NOT NULL ', 'textarea', '', '', '1', '', '1', '0', '1', '1383894927', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('6', 'root', '根节点', 'int(10) unsigned NOT NULL ', 'num', '0', '该文档的顶级文档编号', '0', '', '1', '0', '1', '1384508323', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('7', 'pid', '所属ID', 'int(10) unsigned NOT NULL ', 'num', '0', '父文档编号', '0', '', '1', '0', '1', '1384508543', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('8', 'model_id', '内容模型ID', 'tinyint(3) unsigned NOT NULL ', 'num', '0', '该文档所对应的模型', '0', '', '1', '0', '1', '1384508350', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('9', 'type', '内容类型', 'tinyint(3) unsigned NOT NULL ', 'select', '2', '', '1', '1:目录\r\n2:主题\r\n3:段落', '1', '0', '1', '1384511157', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('10', 'position', '推荐位', 'smallint(5) unsigned NOT NULL ', 'checkbox', '0', '多个推荐则将其推荐值相加', '1', '[DOCUMENT_POSITION]', '1', '0', '1', '1383895640', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('11', 'link_id', '外链', 'int(10) unsigned NOT NULL ', 'num', '0', '0-非外链，大于0-外链ID,需要函数进行链接与编号的转换', '1', '', '1', '0', '1', '1383895757', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('12', 'cover_id', '封面', 'int(10) unsigned NOT NULL ', 'picture', '0', '0-无封面，大于0-封面图片ID，需要函数处理', '1', '', '1', '0', '1', '1384147827', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('13', 'display', '可见性', 'tinyint(3) unsigned NOT NULL ', 'radio', '1', '', '1', '0:不可见\r\n1:所有人可见', '1', '0', '1', '1386662271', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `cloud_attribute` VALUES ('14', 'deadline', '截至时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '0-永久有效', '1', '', '1', '0', '1', '1387163248', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `cloud_attribute` VALUES ('15', 'attach', '附件数量', 'tinyint(3) unsigned NOT NULL ', 'num', '0', '', '0', '', '1', '0', '1', '1387260355', '1383891233', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `cloud_attribute` VALUES ('16', 'view', '浏览量', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '1', '0', '1', '1383895835', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('17', 'comment', '评论数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '1', '0', '1', '1383895846', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('18', 'extend', '扩展统计字段', 'int(10) unsigned NOT NULL ', 'num', '0', '根据需求自行使用', '0', '', '1', '0', '1', '1384508264', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('19', 'level', '优先级', 'int(10) unsigned NOT NULL ', 'num', '0', '越高排序越靠前', '1', '', '1', '0', '1', '1383895894', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('20', 'create_time', '创建时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '', '1', '', '1', '0', '1', '1383895903', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('21', 'update_time', '更新时间', 'int(10) unsigned NOT NULL ', 'datetime', '0', '', '0', '', '1', '0', '1', '1384508277', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('22', 'status', '数据状态', 'tinyint(4) NOT NULL ', 'radio', '0', '', '0', '-1:删除\r\n0:禁用\r\n1:正常\r\n2:待审核\r\n3:草稿', '1', '0', '1', '1384508496', '1383891233', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('23', 'parse', '内容解析类型', 'tinyint(3) unsigned NOT NULL ', 'select', '0', '', '0', '0:html\r\n1:ubb\r\n2:markdown', '2', '0', '1', '1384511049', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('24', 'content', '文章内容', 'text NOT NULL ', 'editor', '', '', '1', '', '2', '0', '1', '1383896225', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('25', 'template', '详情页显示模板', 'varchar(100) NOT NULL ', 'string', '', '参照display方法参数的定义', '1', '', '2', '0', '1', '1383896190', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('26', 'bookmark', '收藏数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '2', '0', '1', '1383896103', '1383891243', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('27', 'parse', '内容解析类型', 'tinyint(3) unsigned NOT NULL ', 'select', '0', '', '0', '0:html\r\n1:ubb\r\n2:markdown', '3', '0', '1', '1387260461', '1383891252', '', '0', '', 'regex', '', '0', 'function');
INSERT INTO `cloud_attribute` VALUES ('28', 'content', '下载详细描述', 'text NOT NULL ', 'editor', '', '', '1', '', '3', '0', '1', '1383896438', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('29', 'template', '详情页显示模板', 'varchar(100) NOT NULL ', 'string', '', '', '1', '', '3', '0', '1', '1383896429', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('30', 'file_id', '文件ID', 'int(10) unsigned NOT NULL ', 'file', '0', '需要函数处理', '1', '', '3', '0', '1', '1383896415', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('31', 'download', '下载次数', 'int(10) unsigned NOT NULL ', 'num', '0', '', '1', '', '3', '0', '1', '1383896380', '1383891252', '', '0', '', '', '', '0', '');
INSERT INTO `cloud_attribute` VALUES ('32', 'size', '文件大小', 'bigint(20) unsigned NOT NULL ', 'num', '0', '单位bit', '1', '', '3', '0', '1', '1383896371', '1383891252', '', '0', '', '', '', '0', '');

-- ----------------------------
-- Table structure for `cloud_auth_extend`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_auth_extend`;
CREATE TABLE `cloud_auth_extend` (
  `group_id` mediumint(10) unsigned NOT NULL COMMENT '用户id',
  `extend_id` mediumint(8) unsigned NOT NULL COMMENT '扩展表中数据的id',
  `type` tinyint(1) unsigned NOT NULL COMMENT '扩展类型标识 1:栏目分类权限;2:模型权限',
  UNIQUE KEY `group_extend_type` (`group_id`,`extend_id`,`type`),
  KEY `uid` (`group_id`),
  KEY `group_id` (`extend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组与分类的对应关系表';

-- ----------------------------
-- Records of cloud_auth_extend
-- ----------------------------
INSERT INTO `cloud_auth_extend` VALUES ('1', '1', '1');
INSERT INTO `cloud_auth_extend` VALUES ('1', '1', '2');
INSERT INTO `cloud_auth_extend` VALUES ('1', '2', '1');
INSERT INTO `cloud_auth_extend` VALUES ('1', '2', '2');
INSERT INTO `cloud_auth_extend` VALUES ('1', '3', '1');
INSERT INTO `cloud_auth_extend` VALUES ('1', '3', '2');
INSERT INTO `cloud_auth_extend` VALUES ('1', '4', '1');
INSERT INTO `cloud_auth_extend` VALUES ('1', '37', '1');

-- ----------------------------
-- Table structure for `cloud_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_auth_group`;
CREATE TABLE `cloud_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '用户组所属模块',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '组类型',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组状态：为1正常，为0禁用,-1为删除',
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_auth_group
-- ----------------------------
INSERT INTO `cloud_auth_group` VALUES ('1', 'admin', '1', '默认用户组', '', '1', '1,2,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,79,80,81,82,83,84,86,87,88,89,90,91,92,93,94,95,96,97,100,102,103,105,106');
INSERT INTO `cloud_auth_group` VALUES ('2', 'admin', '1', '测试用户', '测试用户', '1', '1,2,5,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,79,80,82,83,84,88,89,90,91,92,93,96,97,100,102,103,195');

-- ----------------------------
-- Table structure for `cloud_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_auth_group_access`;
CREATE TABLE `cloud_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_auth_group_access
-- ----------------------------

-- ----------------------------
-- Table structure for `cloud_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_auth_rule`;
CREATE TABLE `cloud_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '规则所属module',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1-url;2-主菜单',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  KEY `module` (`module`,`status`,`type`)
) ENGINE=MyISAM AUTO_INCREMENT=217 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_auth_rule
-- ----------------------------
INSERT INTO `cloud_auth_rule` VALUES ('1', 'admin', '2', 'Admin/Index/index', '首页', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('2', 'admin', '2', 'Admin/Article/index', '内容', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('3', 'admin', '2', 'Admin/User/index', '用户', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('4', 'admin', '2', 'Admin/Addons/index', '扩展', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('5', 'admin', '2', 'Admin/Config/group', '系统', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('7', 'admin', '1', 'Admin/article/add', '新增', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('8', 'admin', '1', 'Admin/article/edit', '编辑', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('9', 'admin', '1', 'Admin/article/setStatus', '改变状态', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('10', 'admin', '1', 'Admin/article/update', '保存', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('11', 'admin', '1', 'Admin/article/autoSave', '保存草稿', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('12', 'admin', '1', 'Admin/article/move', '移动', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('13', 'admin', '1', 'Admin/article/copy', '复制', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('14', 'admin', '1', 'Admin/article/paste', '粘贴', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('15', 'admin', '1', 'Admin/article/permit', '还原', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('16', 'admin', '1', 'Admin/article/clear', '清空', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('17', 'admin', '1', 'Admin/article/examine', '审核列表', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('18', 'admin', '1', 'Admin/article/recycle', '回收站', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('19', 'admin', '1', 'Admin/User/addaction', '新增用户行为', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('20', 'admin', '1', 'Admin/User/editaction', '编辑用户行为', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('21', 'admin', '1', 'Admin/User/saveAction', '保存用户行为', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('22', 'admin', '1', 'Admin/User/setStatus', '变更行为状态', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('23', 'admin', '1', 'Admin/User/changeStatus?method=forbidUser', '禁用会员', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('24', 'admin', '1', 'Admin/User/changeStatus?method=resumeUser', '启用会员', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('25', 'admin', '1', 'Admin/User/changeStatus?method=deleteUser', '删除会员', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('26', 'admin', '1', 'Admin/User/index', '用户信息', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('27', 'admin', '1', 'Admin/User/action', '用户行为', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('28', 'admin', '1', 'Admin/AuthManager/changeStatus?method=deleteGroup', '删除', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('29', 'admin', '1', 'Admin/AuthManager/changeStatus?method=forbidGroup', '禁用', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('30', 'admin', '1', 'Admin/AuthManager/changeStatus?method=resumeGroup', '恢复', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('31', 'admin', '1', 'Admin/AuthManager/createGroup', '新增', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('32', 'admin', '1', 'Admin/AuthManager/editGroup', '编辑', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('33', 'admin', '1', 'Admin/AuthManager/writeGroup', '保存用户组', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('34', 'admin', '1', 'Admin/AuthManager/group', '授权', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('35', 'admin', '1', 'Admin/AuthManager/access', '访问授权', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('36', 'admin', '1', 'Admin/AuthManager/user', '成员授权', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('37', 'admin', '1', 'Admin/AuthManager/removeFromGroup', '解除授权', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('38', 'admin', '1', 'Admin/AuthManager/addToGroup', '保存成员授权', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('39', 'admin', '1', 'Admin/AuthManager/category', '分类授权', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('40', 'admin', '1', 'Admin/AuthManager/addToCategory', '保存分类授权', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('41', 'admin', '1', 'Admin/AuthManager/index', '权限管理', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('42', 'admin', '1', 'Admin/Addons/create', '创建', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('43', 'admin', '1', 'Admin/Addons/checkForm', '检测创建', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('44', 'admin', '1', 'Admin/Addons/preview', '预览', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('45', 'admin', '1', 'Admin/Addons/build', '快速生成插件', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('46', 'admin', '1', 'Admin/Addons/config', '设置', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('47', 'admin', '1', 'Admin/Addons/disable', '禁用', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('48', 'admin', '1', 'Admin/Addons/enable', '启用', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('49', 'admin', '1', 'Admin/Addons/install', '安装', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('50', 'admin', '1', 'Admin/Addons/uninstall', '卸载', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('51', 'admin', '1', 'Admin/Addons/saveconfig', '更新配置', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('52', 'admin', '1', 'Admin/Addons/adminList', '插件后台列表', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('53', 'admin', '1', 'Admin/Addons/execute', 'URL方式访问插件', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('54', 'admin', '1', 'Admin/Addons/index', '插件管理', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('55', 'admin', '1', 'Admin/Addons/hooks', '钩子管理', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('56', 'admin', '1', 'Admin/model/add', '新增', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('57', 'admin', '1', 'Admin/model/edit', '编辑', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('58', 'admin', '1', 'Admin/model/setStatus', '改变状态', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('59', 'admin', '1', 'Admin/model/update', '保存数据', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('60', 'admin', '1', 'Admin/Model/index', '模型管理', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('61', 'admin', '1', 'Admin/Config/edit', '编辑', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('62', 'admin', '1', 'Admin/Config/del', '删除', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('63', 'admin', '1', 'Admin/Config/add', '新增', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('64', 'admin', '1', 'Admin/Config/save', '保存', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('65', 'admin', '1', 'Admin/Config/group', '网站设置', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('66', 'admin', '1', 'Admin/Config/index', '配置管理', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('67', 'admin', '1', 'Admin/Channel/add', '新增', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('68', 'admin', '1', 'Admin/Channel/edit', '编辑', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('69', 'admin', '1', 'Admin/Channel/del', '删除', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('70', 'admin', '1', 'Admin/Channel/index', '导航管理', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('71', 'admin', '1', 'Admin/Category/edit', '编辑', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('72', 'admin', '1', 'Admin/Category/add', '新增', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('73', 'admin', '1', 'Admin/Category/remove', '删除', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('74', 'admin', '1', 'Admin/Category/index', '分类管理', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('75', 'admin', '1', 'Admin/file/upload', '上传控件', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('76', 'admin', '1', 'Admin/file/uploadPicture', '上传图片', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('77', 'admin', '1', 'Admin/file/download', '下载', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('94', 'admin', '1', 'Admin/AuthManager/modelauth', '模型授权', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('79', 'admin', '1', 'Admin/article/batchOperate', '导入', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('80', 'admin', '1', 'Admin/Database/index?type=export', '备份数据库', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('81', 'admin', '1', 'Admin/Database/index?type=import', '还原数据库', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('82', 'admin', '1', 'Admin/Database/export', '备份', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('83', 'admin', '1', 'Admin/Database/optimize', '优化表', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('84', 'admin', '1', 'Admin/Database/repair', '修复表', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('86', 'admin', '1', 'Admin/Database/import', '恢复', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('87', 'admin', '1', 'Admin/Database/del', '删除', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('88', 'admin', '1', 'Admin/User/add', '新增用户', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('89', 'admin', '1', 'Admin/Attribute/index', '属性管理', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('90', 'admin', '1', 'Admin/Attribute/add', '新增', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('91', 'admin', '1', 'Admin/Attribute/edit', '编辑', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('92', 'admin', '1', 'Admin/Attribute/setStatus', '改变状态', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('93', 'admin', '1', 'Admin/Attribute/update', '保存数据', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('95', 'admin', '1', 'Admin/AuthManager/addToModel', '保存模型授权', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('96', 'admin', '1', 'Admin/Category/move', '移动', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('97', 'admin', '1', 'Admin/Category/merge', '合并', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('98', 'admin', '1', 'Admin/Config/menu', '后台菜单管理', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('99', 'admin', '1', 'Admin/Article/mydocument', '内容', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('100', 'admin', '1', 'Admin/Menu/index', '菜单管理', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('101', 'admin', '1', 'Admin/other', '其他', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('102', 'admin', '1', 'Admin/Menu/add', '新增', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('103', 'admin', '1', 'Admin/Menu/edit', '编辑', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('104', 'admin', '1', 'Admin/Think/lists?model=article', '文章管理', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('105', 'admin', '1', 'Admin/Think/lists?model=download', '下载管理', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('106', 'admin', '1', 'Admin/Think/lists?model=config', '配置管理', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('107', 'admin', '1', 'Admin/Action/actionlog', '行为日志', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('108', 'admin', '1', 'Admin/User/updatePassword', '修改密码', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('109', 'admin', '1', 'Admin/User/updateNickname', '修改昵称', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('110', 'admin', '1', 'Admin/action/edit', '查看行为日志', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('205', 'admin', '1', 'Admin/think/add', '新增数据', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('111', 'admin', '2', 'Admin/article/index', '文档列表', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('112', 'admin', '2', 'Admin/article/add', '新增', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('113', 'admin', '2', 'Admin/article/edit', '编辑', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('114', 'admin', '2', 'Admin/article/setStatus', '改变状态', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('115', 'admin', '2', 'Admin/article/update', '保存', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('116', 'admin', '2', 'Admin/article/autoSave', '保存草稿', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('117', 'admin', '2', 'Admin/article/move', '移动', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('118', 'admin', '2', 'Admin/article/copy', '复制', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('119', 'admin', '2', 'Admin/article/paste', '粘贴', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('120', 'admin', '2', 'Admin/article/batchOperate', '导入', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('121', 'admin', '2', 'Admin/article/recycle', '回收站', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('122', 'admin', '2', 'Admin/article/permit', '还原', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('123', 'admin', '2', 'Admin/article/clear', '清空', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('124', 'admin', '2', 'Admin/User/add', '新增用户', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('125', 'admin', '2', 'Admin/User/action', '用户行为', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('126', 'admin', '2', 'Admin/User/addAction', '新增用户行为', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('127', 'admin', '2', 'Admin/User/editAction', '编辑用户行为', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('128', 'admin', '2', 'Admin/User/saveAction', '保存用户行为', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('129', 'admin', '2', 'Admin/User/setStatus', '变更行为状态', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('130', 'admin', '2', 'Admin/User/changeStatus?method=forbidUser', '禁用会员', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('131', 'admin', '2', 'Admin/User/changeStatus?method=resumeUser', '启用会员', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('132', 'admin', '2', 'Admin/User/changeStatus?method=deleteUser', '删除会员', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('133', 'admin', '2', 'Admin/AuthManager/index', '权限管理', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('134', 'admin', '2', 'Admin/AuthManager/changeStatus?method=deleteGroup', '删除', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('135', 'admin', '2', 'Admin/AuthManager/changeStatus?method=forbidGroup', '禁用', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('136', 'admin', '2', 'Admin/AuthManager/changeStatus?method=resumeGroup', '恢复', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('137', 'admin', '2', 'Admin/AuthManager/createGroup', '新增', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('138', 'admin', '2', 'Admin/AuthManager/editGroup', '编辑', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('139', 'admin', '2', 'Admin/AuthManager/writeGroup', '保存用户组', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('140', 'admin', '2', 'Admin/AuthManager/group', '授权', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('141', 'admin', '2', 'Admin/AuthManager/access', '访问授权', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('142', 'admin', '2', 'Admin/AuthManager/user', '成员授权', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('143', 'admin', '2', 'Admin/AuthManager/removeFromGroup', '解除授权', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('144', 'admin', '2', 'Admin/AuthManager/addToGroup', '保存成员授权', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('145', 'admin', '2', 'Admin/AuthManager/category', '分类授权', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('146', 'admin', '2', 'Admin/AuthManager/addToCategory', '保存分类授权', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('147', 'admin', '2', 'Admin/AuthManager/modelauth', '模型授权', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('148', 'admin', '2', 'Admin/AuthManager/addToModel', '保存模型授权', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('149', 'admin', '2', 'Admin/Addons/create', '创建', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('150', 'admin', '2', 'Admin/Addons/checkForm', '检测创建', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('151', 'admin', '2', 'Admin/Addons/preview', '预览', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('152', 'admin', '2', 'Admin/Addons/build', '快速生成插件', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('153', 'admin', '2', 'Admin/Addons/config', '设置', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('154', 'admin', '2', 'Admin/Addons/disable', '禁用', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('155', 'admin', '2', 'Admin/Addons/enable', '启用', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('156', 'admin', '2', 'Admin/Addons/install', '安装', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('157', 'admin', '2', 'Admin/Addons/uninstall', '卸载', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('158', 'admin', '2', 'Admin/Addons/saveconfig', '更新配置', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('159', 'admin', '2', 'Admin/Addons/adminList', '插件后台列表', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('160', 'admin', '2', 'Admin/Addons/execute', 'URL方式访问插件', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('161', 'admin', '2', 'Admin/Addons/hooks', '钩子管理', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('162', 'admin', '2', 'Admin/Model/index', '模型管理', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('163', 'admin', '2', 'Admin/model/add', '新增', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('164', 'admin', '2', 'Admin/model/edit', '编辑', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('165', 'admin', '2', 'Admin/model/setStatus', '改变状态', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('166', 'admin', '2', 'Admin/model/update', '保存数据', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('167', 'admin', '2', 'Admin/Attribute/index', '属性管理', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('168', 'admin', '2', 'Admin/Attribute/add', '新增', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('169', 'admin', '2', 'Admin/Attribute/edit', '编辑', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('170', 'admin', '2', 'Admin/Attribute/setStatus', '改变状态', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('171', 'admin', '2', 'Admin/Attribute/update', '保存数据', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('172', 'admin', '2', 'Admin/Config/index', '配置管理', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('173', 'admin', '2', 'Admin/Config/edit', '编辑', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('174', 'admin', '2', 'Admin/Config/del', '删除', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('175', 'admin', '2', 'Admin/Config/add', '新增', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('176', 'admin', '2', 'Admin/Config/save', '保存', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('177', 'admin', '2', 'Admin/Menu/index', '菜单管理', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('178', 'admin', '2', 'Admin/Channel/index', '导航管理', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('179', 'admin', '2', 'Admin/Channel/add', '新增', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('180', 'admin', '2', 'Admin/Channel/edit', '编辑', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('181', 'admin', '2', 'Admin/Channel/del', '删除', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('182', 'admin', '2', 'Admin/Category/index', '分类管理', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('183', 'admin', '2', 'Admin/Category/edit', '编辑', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('184', 'admin', '2', 'Admin/Category/add', '新增', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('185', 'admin', '2', 'Admin/Category/remove', '删除', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('186', 'admin', '2', 'Admin/Category/move', '移动', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('187', 'admin', '2', 'Admin/Category/merge', '合并', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('188', 'admin', '2', 'Admin/Database/index?type=export', '备份数据库', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('189', 'admin', '2', 'Admin/Database/export', '备份', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('190', 'admin', '2', 'Admin/Database/optimize', '优化表', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('191', 'admin', '2', 'Admin/Database/repair', '修复表', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('192', 'admin', '2', 'Admin/Database/index?type=import', '还原数据库', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('193', 'admin', '2', 'Admin/Database/import', '恢复', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('194', 'admin', '2', 'Admin/Database/del', '删除', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('195', 'admin', '2', 'Admin/other', '其他', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('196', 'admin', '2', 'Admin/Menu/add', '新增', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('197', 'admin', '2', 'Admin/Menu/edit', '编辑', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('198', 'admin', '2', 'Admin/Think/lists?model=article', '应用', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('199', 'admin', '2', 'Admin/Think/lists?model=download', '下载管理', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('200', 'admin', '2', 'Admin/Think/lists?model=config', '应用', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('201', 'admin', '2', 'Admin/Action/actionlog', '行为日志', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('202', 'admin', '2', 'Admin/User/updatePassword', '修改密码', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('203', 'admin', '2', 'Admin/User/updateNickname', '修改昵称', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('204', 'admin', '2', 'Admin/action/edit', '查看行为日志', '-1', '');
INSERT INTO `cloud_auth_rule` VALUES ('206', 'admin', '1', 'Admin/think/edit', '编辑数据', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('207', 'admin', '1', 'Admin/Menu/import', '导入', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('208', 'admin', '1', 'Admin/Model/generate', '生成', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('209', 'admin', '1', 'Admin/Addons/addHook', '新增钩子', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('210', 'admin', '1', 'Admin/Addons/edithook', '编辑钩子', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('211', 'admin', '1', 'Admin/Article/sort', '文档排序', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('212', 'admin', '1', 'Admin/Config/sort', '排序', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('213', 'admin', '1', 'Admin/Menu/sort', '排序', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('214', 'admin', '1', 'Admin/Channel/sort', '排序', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('215', 'admin', '1', 'Admin/Category/operate/type/move', '移动', '1', '');
INSERT INTO `cloud_auth_rule` VALUES ('216', 'admin', '1', 'Admin/Category/operate/type/merge', '合并', '1', '');

-- ----------------------------
-- Table structure for `cloud_avatar`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_avatar`;
CREATE TABLE `cloud_avatar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_avatar
-- ----------------------------

-- ----------------------------
-- Table structure for `cloud_category`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_category`;
CREATE TABLE `cloud_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(30) NOT NULL COMMENT '标志',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `list_row` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '列表每页行数',
  `meta_title` varchar(50) NOT NULL DEFAULT '' COMMENT 'SEO的网页标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `template_index` varchar(100) NOT NULL DEFAULT '' COMMENT '频道页模板',
  `template_lists` varchar(100) NOT NULL DEFAULT '' COMMENT '列表页模板',
  `template_detail` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页模板',
  `template_edit` varchar(100) NOT NULL DEFAULT '' COMMENT '编辑页模板',
  `model` varchar(100) NOT NULL DEFAULT '' COMMENT '列表绑定模型',
  `model_sub` varchar(100) NOT NULL DEFAULT '' COMMENT '子文档绑定模型',
  `type` varchar(100) NOT NULL DEFAULT '' COMMENT '允许发布的内容类型',
  `link_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外链',
  `allow_publish` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许发布内容',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可见性',
  `reply` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许回复',
  `check` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发布的文章是否需要审核',
  `reply_model` varchar(100) NOT NULL DEFAULT '',
  `extend` text COMMENT '扩展设置',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  `icon` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类图标',
  `groups` varchar(255) NOT NULL DEFAULT '' COMMENT '分组定义',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of cloud_category
-- ----------------------------
INSERT INTO `cloud_category` VALUES ('1', 'wemedia', '自媒体', '0', '0', '9', '', '', '', '', '', '', '', '2,3', '2', '2,1', '0', '0', '1', '0', '0', '1', '', '1379474947', '1457965676', '1', '0', '');
INSERT INTO `cloud_category` VALUES ('2', 'life', '生活', '1', '1', '9', '', '', '', '', '', 'detail', '', '2,3', '2', '2,1,3', '0', '2', '1', '0', '0', '1', '', '1379475028', '1457965650', '1', '0', '');
INSERT INTO `cloud_category` VALUES ('39', 'oversea', '外媒', '1', '2', '9', '', '', '', '', '', 'detail', '', '2', '2', '2,1,3', '0', '2', '1', '0', '0', '', '', '1451186846', '1457965797', '1', '0', '');
INSERT INTO `cloud_category` VALUES ('40', 'blockscloud', '积木', '0', '0', '10', '', '', '', '', '', '', '', '2,3', '2,3', '2,1,3', '0', '0', '1', '0', '0', '', '', '1457968150', '1457968841', '1', '0', '');
INSERT INTO `cloud_category` VALUES ('41', 'download', '下载', '40', '0', '10', '', '', '', '', 'download_list', 'download_detail', '', '3', '3', '2,1,3', '0', '1', '1', '0', '0', '', '', '1457968891', '1458001722', '1', '0', '');

-- ----------------------------
-- Table structure for `cloud_channel`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_channel`;
CREATE TABLE `cloud_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '频道ID',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级频道ID',
  `title` char(30) NOT NULL COMMENT '频道标题',
  `url` char(100) NOT NULL COMMENT '频道连接',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '导航排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `target` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '新窗口打开',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_channel
-- ----------------------------
INSERT INTO `cloud_channel` VALUES ('1', '0', '首页', 'Index/index', '1', '1379475111', '1379923177', '1', '0');
INSERT INTO `cloud_channel` VALUES ('2', '0', '博客', 'Article/index?category=blog', '2', '1379475131', '1379483713', '1', '0');
INSERT INTO `cloud_channel` VALUES ('3', '0', '官网', 'http://www.blockscloud.com', '3', '1379475154', '1387163458', '1', '0');

-- ----------------------------
-- Table structure for `cloud_config`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_config`;
CREATE TABLE `cloud_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `value` text COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_config
-- ----------------------------
INSERT INTO `cloud_config` VALUES ('1', 'WEB_SITE_TITLE', '1', '网站标题', '1', '', '网站标题前台显示标题', '1378898976', '1379235274', '1', 'Blockscloud内容管理框架', '0');
INSERT INTO `cloud_config` VALUES ('2', 'WEB_SITE_DESCRIPTION', '2', '网站描述', '1', '', '网站搜索引擎描述', '1378898976', '1379235841', '1', 'Blockscloud内容管理框架', '1');
INSERT INTO `cloud_config` VALUES ('3', 'WEB_SITE_KEYWORD', '2', '网站关键字', '1', '', '网站搜索引擎关键字', '1378898976', '1381390100', '1', 'ThinkPHP,Blockscloud', '8');
INSERT INTO `cloud_config` VALUES ('4', 'WEB_SITE_CLOSE', '4', '关闭站点', '1', '0:关闭,1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', '1378898976', '1379235296', '1', '1', '1');
INSERT INTO `cloud_config` VALUES ('9', 'CONFIG_TYPE_LIST', '3', '配置类型列表', '4', '', '主要用于数据解析和页面表单的生成', '1378898976', '1379235348', '1', '0:数字\r\n1:字符\r\n2:文本\r\n3:数组\r\n4:枚举', '2');
INSERT INTO `cloud_config` VALUES ('10', 'WEB_SITE_ICP', '1', '网站备案号', '1', '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', '1378900335', '1379235859', '1', '', '9');
INSERT INTO `cloud_config` VALUES ('11', 'DOCUMENT_POSITION', '3', '文档推荐位', '2', '', '文档推荐位，推荐到多个位置KEY值相加即可', '1379053380', '1379235329', '1', '1:列表推荐\r\n2:频道推荐\r\n4:首页推荐', '3');
INSERT INTO `cloud_config` VALUES ('12', 'DOCUMENT_DISPLAY', '3', '文档可见性', '2', '', '文章可见性仅影响前台显示，后台不收影响', '1379056370', '1379235322', '1', '0:所有人可见\r\n1:仅注册会员可见\r\n2:仅管理员可见', '4');
INSERT INTO `cloud_config` VALUES ('13', 'COLOR_STYLE', '4', '后台色系', '1', 'default_color:默认\r\nblue_color:紫罗兰', '后台颜色风格', '1379122533', '1379235904', '1', 'default_color', '10');
INSERT INTO `cloud_config` VALUES ('20', 'CONFIG_GROUP_LIST', '3', '配置分组', '4', '', '配置分组', '1379228036', '1449027841', '1', '1:基本\r\n2:内容\r\n3:用户\r\n4:系统\r\n5:短信', '5');
INSERT INTO `cloud_config` VALUES ('21', 'HOOKS_TYPE', '3', '钩子的类型', '4', '', '类型 1-用于扩展显示内容，2-用于扩展业务处理', '1379313397', '1379313407', '1', '1:视图\r\n2:控制器', '6');
INSERT INTO `cloud_config` VALUES ('22', 'AUTH_CONFIG', '3', 'Auth配置', '4', '', '自定义Auth.class.php类配置', '1379409310', '1379409564', '1', 'AUTH_ON:1\r\nAUTH_TYPE:2', '8');
INSERT INTO `cloud_config` VALUES ('23', 'OPEN_DRAFTBOX', '4', '是否开启草稿功能', '2', '0:关闭草稿功能\r\n1:开启草稿功能\r\n', '新增文章时的草稿功能配置', '1379484332', '1379484591', '1', '1', '1');
INSERT INTO `cloud_config` VALUES ('24', 'DRAFT_AOTOSAVE_INTERVAL', '0', '自动保存草稿时间', '2', '', '自动保存草稿的时间间隔，单位：秒', '1379484574', '1386143323', '1', '60', '2');
INSERT INTO `cloud_config` VALUES ('25', 'LIST_ROWS', '0', '后台每页记录数', '2', '', '后台数据每页显示记录数', '1379503896', '1380427745', '1', '10', '10');
INSERT INTO `cloud_config` VALUES ('26', 'USER_ALLOW_REGISTER', '4', '是否允许用户注册', '3', '0:关闭注册\r\n1:允许注册', '是否开放用户注册', '1379504487', '1379504580', '1', '1', '3');
INSERT INTO `cloud_config` VALUES ('27', 'CODEMIRROR_THEME', '4', '预览插件的CodeMirror主题', '4', '3024-day:3024 day\r\n3024-night:3024 night\r\nambiance:ambiance\r\nbase16-dark:base16 dark\r\nbase16-light:base16 light\r\nblackboard:blackboard\r\ncobalt:cobalt\r\neclipse:eclipse\r\nelegant:elegant\r\nerlang-dark:erlang-dark\r\nlesser-dark:lesser-dark\r\nmidnight:midnight', '详情见CodeMirror官网', '1379814385', '1384740813', '1', 'ambiance', '3');
INSERT INTO `cloud_config` VALUES ('28', 'DATA_BACKUP_PATH', '1', '数据库备份根路径', '4', '', '路径必须以 / 结尾', '1381482411', '1381482411', '1', './Data/', '5');
INSERT INTO `cloud_config` VALUES ('29', 'DATA_BACKUP_PART_SIZE', '0', '数据库备份卷大小', '4', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '1381482488', '1381729564', '1', '20971520', '7');
INSERT INTO `cloud_config` VALUES ('30', 'DATA_BACKUP_COMPRESS', '4', '数据库备份文件是否启用压缩', '4', '0:不压缩\r\n1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '1381713345', '1381729544', '1', '1', '9');
INSERT INTO `cloud_config` VALUES ('31', 'DATA_BACKUP_COMPRESS_LEVEL', '4', '数据库备份文件压缩级别', '4', '1:普通\r\n4:一般\r\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '1381713408', '1381713408', '1', '9', '10');
INSERT INTO `cloud_config` VALUES ('32', 'DEVELOP_MODE', '4', '开启开发者模式', '4', '0:关闭\r\n1:开启', '是否开启开发者模式', '1383105995', '1383291877', '1', '1', '11');
INSERT INTO `cloud_config` VALUES ('33', 'ALLOW_VISIT', '3', '不受限控制器方法', '0', '', '', '1386644047', '1386644741', '1', '0:article/draftbox\r\n1:article/mydocument\r\n2:Category/tree\r\n3:Index/verify\r\n4:file/upload\r\n5:file/download\r\n6:user/updatePassword\r\n7:user/updateNickname\r\n8:user/submitPassword\r\n9:user/submitNickname\r\n10:file/uploadpicture', '0');
INSERT INTO `cloud_config` VALUES ('34', 'DENY_VISIT', '3', '超管专限控制器方法', '0', '', '仅超级管理员可访问的控制器方法', '1386644141', '1386644659', '1', '0:Addons/addhook\r\n1:Addons/edithook\r\n2:Addons/delhook\r\n3:Addons/updateHook\r\n4:Admin/getMenus\r\n5:Admin/recordList\r\n6:AuthManager/updateRules\r\n7:AuthManager/tree', '0');
INSERT INTO `cloud_config` VALUES ('35', 'REPLY_LIST_ROWS', '0', '回复列表每页条数', '2', '', '', '1386645376', '1387178083', '1', '10', '0');
INSERT INTO `cloud_config` VALUES ('36', 'ADMIN_ALLOW_IP', '2', '后台允许访问IP', '4', '', '多个用逗号分隔，如果不配置表示不限制IP访问', '1387165454', '1387165553', '1', '', '12');
INSERT INTO `cloud_config` VALUES ('37', 'SHOW_PAGE_TRACE', '4', '是否显示页面Trace', '4', '0:关闭\r\n1:开启', '是否显示页面Trace信息', '1387165685', '1387165685', '1', '0', '1');
INSERT INTO `cloud_config` VALUES ('38', 'SITE_ADMIN_THEME', '4', '后台模板', '1', 'desktop:桌面版\r\ndefault:普通版', '后台模板风格，默认为桌面版', '1447903752', '1447903752', '1', 'desktop', '11');
INSERT INTO `cloud_config` VALUES ('39', 'SITE_ADMIN_WALLPAPER', '1', '后台桌面壁纸', '0', '', '桌面模式下桌面壁纸', '1447905169', '1447905235', '1', 'default.jpg', '0');
INSERT INTO `cloud_config` VALUES ('40', 'SMSBAO_USERNAME', '1', '短信宝用户名', '5', '', '短信宝用户名，注册地址：http://www.smsbao.com', '1449028498', '1449028498', '1', '', '0');
INSERT INTO `cloud_config` VALUES ('41', 'SMSBAO_PASSWORD', '1', '短信宝密码', '5', '', '短信宝注册密码，接口使用：控制器中使用send_sms(\'手机号\',\'发送内容\')', '1449028548', '1449028548', '1', '', '0');

-- ----------------------------
-- Table structure for `cloud_document`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_document`;
CREATE TABLE `cloud_document` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` char(40) NOT NULL DEFAULT '' COMMENT '标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '标题',
  `category_id` int(10) unsigned NOT NULL COMMENT '所属分类',
  `group_id` smallint(3) unsigned NOT NULL COMMENT '所属分组',
  `description` char(140) NOT NULL DEFAULT '' COMMENT '描述',
  `root` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '根节点',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属ID',
  `model_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容模型ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '内容类型',
  `position` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '推荐位',
  `link_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '外链',
  `cover_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '封面',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '可见性',
  `deadline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '截至时间',
  `attach` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件数量',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `comment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `extend` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扩展统计字段',
  `level` int(10) NOT NULL DEFAULT '0' COMMENT '优先级',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  PRIMARY KEY (`id`),
  KEY `idx_category_status` (`category_id`,`status`),
  KEY `idx_status_type_pid` (`status`,`uid`,`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='文档模型基础表';

-- ----------------------------
-- Records of cloud_document
-- ----------------------------
INSERT INTO `cloud_document` VALUES ('1', '1', '', '中国原油储备采购明年翻番？', '2', '0', '英国路透社12月4日报道，原题：中国明年战略原油采购量将翻番 随着全球石油价格经受有史以来最严重的下跌之一，国际原油市场掀起一股抢购潮，中国明年的战略原油采购量可能将翻一番。', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '175', '0', '0', '0', '1406001360', '1458137622', '1');
INSERT INTO `cloud_document` VALUES ('2', '1', '', '关于积木云这个站', '2', '0', ' 积木云这个站是积木云系统的运营站，一个系统好不好用，只有真正运营时才能看出来；这个站将来会打造成一个社交类型的网站', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '301', '0', '0', '0', '1449491258', '1449491258', '1');
INSERT INTO `cloud_document` VALUES ('4', '9', '', '大家好，欢迎光临本站', '2', '0', '大家好，欢迎光临本站', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '84', '0', '0', '0', '1450974480', '1450974635', '1');
INSERT INTO `cloud_document` VALUES ('5', '9', '', '积木云', '2', '0', '积木云超强CMS系统-beta.0.7.42：基于onethink', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '118', '0', '0', '0', '1450974752', '1450974752', '1');
INSERT INTO `cloud_document` VALUES ('6', '9', '', '梁振英的座位引港媒热议 一国两制不能“走样变形”', '2', '0', '【环球时报综合报道】香港特区行政长官梁振英24日晚结束在北京的述职行程，返回香港，他形容此次述职之行“有成效”。', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '68', '0', '0', '0', '1451022308', '1451022464', '1');
INSERT INTO `cloud_document` VALUES ('7', '1', '', '没啥意思，随点写点什么吧', '2', '0', '没啥意思，随点写点什么吧', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '116', '0', '0', '0', '1451144280', '1458137035', '1');
INSERT INTO `cloud_document` VALUES ('8', '1', '', '行走在路上', '2', '0', '我喜欢读书。捧一杯香茗，读一本好书，听琴音流淌，悟人生真谛。读书于我，是一种来自灵魂的享受，只为求得心灵的宁静，只求让自己在求知的路上走得更远。', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '135', '0', '0', '0', '1451145600', '1458136998', '1');
INSERT INTO `cloud_document` VALUES ('9', '9', '', '外交部驱离一名法国驻华记者：决不容忍记者为恐怖主义张目', '2', '0', '环球网12月26日综合消息，多家外媒于25日报道，法国《新观察家》杂志驻北京记者郭玉(又称“高洁”)被中国驱离。', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '149', '0', '0', '0', '1451185920', '1458136989', '1');
INSERT INTO `cloud_document` VALUES ('10', '9', '', 'BBC:普京的冬日童话', '39', '0', '童话故事结尾都很美好。普京对乌克兰和叙利亚的立场在西方引起普遍批评，但是在国内，他却深受许多人的敬仰爱戴。许多俄国人坚信，他就像童话中的英雄，能让美好结局成为现实。', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '161', '0', '0', '0', '1451187720', '1458137066', '1');
INSERT INTO `cloud_document` VALUES ('11', '1', '', '  外媒：中国为何愿当叙利亚危机的调停者？原因在这！', '39', '0', '路透社12月22日报道，原题：中国愿当叙利亚危机调停者   中国外交部22日表示，叙利亚副总理兼外长本周将访问中国，这是北京在解决中东冲突方面发挥更加积极作用的一次新尝试。', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '182', '0', '0', '0', '1451205720', '1458137058', '1');
INSERT INTO `cloud_document` VALUES ('12', '9', '', '你好，世界！', '39', '0', '你好，世界！', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '104', '0', '0', '0', '1451463814', '1451463814', '1');
INSERT INTO `cloud_document` VALUES ('13', '11', '', '你好，世界', '2', '0', '你好', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '121', '0', '0', '0', '1451463889', '1451463889', '1');
INSERT INTO `cloud_document` VALUES ('15', '1', '', '新年快到了', '2', '0', '新年快到了，祝大家新年快乐', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '157', '0', '0', '0', '1451543400', '1458136979', '1');
INSERT INTO `cloud_document` VALUES ('16', '1', '', '好美意思啊', '2', '0', '好美意思啊', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '228', '0', '0', '0', '1452733571', '1452733571', '1');
INSERT INTO `cloud_document` VALUES ('17', '1', '', '一直没人，一直没人！', '2', '0', '一直没人，一直没人！', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '15', '0', '0', '0', '1457966340', '1458136965', '1');
INSERT INTO `cloud_document` VALUES ('18', '1', '', '积木云1.0尝鲜版', '40', '0', '尝鲜版，不建议部署到生产环境', '0', '0', '3', '2', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '1457968744', '1457968744', '3');
INSERT INTO `cloud_document` VALUES ('19', '1', '', '积木云1.0尝鲜版', '41', '0', '尝鲜版，不建议部署到生产环境中！', '0', '0', '3', '2', '0', '0', '0', '1', '0', '0', '28', '0', '0', '0', '1457970900', '1457975292', '1');
INSERT INTO `cloud_document` VALUES ('20', '1', '', '积木云0.10.29dev版', '41', '0', '积木云0.10.29dev版，此版本集成了opensns的模块。', '0', '0', '3', '2', '0', '0', '0', '1', '0', '0', '35', '0', '0', '0', '1457976159', '1457976159', '1');
INSERT INTO `cloud_document` VALUES ('21', '9', '', '你好啊，欢迎光临！', '2', '0', '你好啊，欢迎光临！', '0', '0', '2', '2', '0', '0', '0', '1', '0', '0', '9', '0', '0', '0', '1458020373', '1458020373', '1');

-- ----------------------------
-- Table structure for `cloud_document_article`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_document_article`;
CREATE TABLE `cloud_document_article` (
  `id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `parse` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容解析类型',
  `content` text NOT NULL COMMENT '文章内容',
  `template` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页显示模板',
  `bookmark` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型文章表';

-- ----------------------------
-- Records of cloud_document_article
-- ----------------------------
INSERT INTO `cloud_document_article` VALUES ('1', '0', '<span style=\"font-size:16px;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 英国路透社12月4日报道，原题：中国明年战略原油采购量将翻番 随着全球石油价格经受有史以来最严重的下跌之一，国际原油市场掀起一股抢购潮，中国明年的战略原油采购量可能将翻一番。</span> <br />\r\n<span style=\"font-size:16px;\"> 　　根据路透社分析师搜集的数据及调查，北京在2016年可能将增加7000万至9000万桶原油到其储备设施中，以打造战略石油储备。中国的原油采购总量也将因此创下新纪录。</span><br />\r\n<br />\r\n<span style=\"font-size:16px;\"> 　　自2014年以来，国际原油价格几乎腰斩，全球原油产量则供大于求。欧佩克为此周五在维也纳举行会议。任何有关中国为增加战略储备而采购石油的迹象都将为原油价格带来不同寻常的支撑。FGE全球能源咨询公司的温迪·杨说：“明年，(中国)石油储备的作用将比今年更明显。”</span><br />\r\n<br />\r\n<span style=\"font-size:16px;\"> 　　作为推动能源独立的努力之一，中国从2006年开始进行石油储备。北京希望能将石油储备提高至经合组织90天进口石油量的标准。周五，中国国家发改委未回应就此发表评论的请求。2015年中国为战略原油储备设施进口的石油为3000万至4000万桶。FGE全球能源咨询公司、安迅思咨询公司及巴克莱银行的研究人员预计，中国明年为增加石油战略储备所进口的原油数量将增加一倍。还有分析师认为进口量会更高。</span><br />\r\n<br />\r\n<span style=\"font-size:16px;\"> 　　中国正在修建6个全新战略石油储备点。专家预计，明年还将建设更多战略石油储备点。但一些高级中国贸易商却保持谨慎。他们说，今年天津港爆炸后，中国对安全的严格管理将推迟新储备点的建设，并影响石油进口量。</span><br />\r\n<br />\r\n<span style=\"font-size:16px;\"> 　　曾参与战略石油储备采购的一家贸易公司高管预测，2016年中国将增加3000万桶石油储备。他说：“随着中国业已建起充裕的缓冲储备，加紧增加储备的压力已减小。尤其是，中国政府愈加确信，石油价格在未来1至2年内仍将保持低点。”</span>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('2', '0', '<span style=\"font-size:16px;\">&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=\"font-size:16px;\">积木云这个站是积木云系统的运营站，一个系统好不好用，只有真正运营时才能看出来；这个站将来会打造成一个社交类型的网站，当然具体是哪个方向我还没有想好，有可能偏细一点比如给开发者用的社交网站，也有可能偏大众化一点，比如像自媒体一样的网站！一切都有可能吧！</span>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('4', '0', '<img src=\"data:image/jpeg;base64,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\" style=\"width: 500px;\"><br>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('5', '0', '<p><img src=\"data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QNxaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjAtYzA2MCA2MS4xMzQ3NzcsIDIwMTAvMDIvMTItMTc6MzI6MDAgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6RTVCMjkxNDUyMjIwNjgxMThDMTRDRkYxQTIxQjgzMjIiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QTdBRkJGNDAxNkQ0MTFFM0E1MDdGNDM5QjQ1MjAxODMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QTdBRkJGM0YxNkQ0MTFFM0E1MDdGNDM5QjQ1MjAxODMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkU1QjI5MTQ1MjIyMDY4MTE4QzE0Q0ZGMUEyMUI4MzIyIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU1QjI5MTQ1MjIyMDY4MTE4QzE0Q0ZGMUEyMUI4MzIyIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwv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AAAAAAAAAAAAAAAAAAAArZUQABoBoBoBoCdAAAAAAAAAAAAAAAAAAAAAAAAAATEIqQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAARIK6KiQAAAAAAASAKaIAAAAACgAIgAAAAAAAAEgaAnRFAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAVVEimiBoBoIaKoAAAgkQAAAAAAAABAooAAAIAGgGgJAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEAAAAQKkQAAFAAAABAAAAAAECgAJAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEABQAAAAAAAAAAAAAQAAFAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAf/Z\" style=\"width: 650px;\"><br></p>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('6', '0', '<p>　　【环球时报综合报道】香港特区行政长官梁振英24日晚结束在北京的述职行程，返回香港，他形容此次述职之行“有成效”。<br><br>　　而香港舆论最关注一个细节：梁振英述职时的座位安排不再与中央领导人“平起平坐”。 梁振英的待遇并不是独特的，澳门特首崔世安也同样在述职时“靠边坐”，但联系到今年香港复杂的形势，座位安排上的变化就被认为大有深意。<br><br>　　“一国两制有主次，一张桌子见端倪”，香港《大公报》24日的社论认为，新安排体现了“一国两制”的主从关系，是庄严、得体而又合情合理的。过去若干年，中央政府并没有刻意强调这种主从关系，但面对“一国两制”在香港的实践碰到的新情况，这一局面正在发生改变。<br><br>　　香港《星岛日报》24日的社评也认为，座位的安排是确保一国两制“不变形”的“微言大义”动作。社评认为，中央坚持一国两制的前提是一国，这是不能动摇的大原则。由于“一国两制”是前所未有的新生事物，中央在回归初期为免激化矛盾，影响特区稳定和各界对港信心，在很多未厘清的灰色地带，都采取比较模糊态度作为缓冲。但政改争议和“占中”行动暴露出来的各种论述，部分已经超越中央容许的底线，中央担心特区会摆脱中央控制，由“高度自治”走向“完全自治”，而且会成为外部势力分裂中国的一枚棋子。部分港人骑劫“本土”一词去搞“港独”，人少却声大，还得到一些青年响应，就更加无助减轻中央对港戒心。 <br></p>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('7', '0', '<p>\r\n	<br />\r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"text-align:left;\">\r\n	一天天的不知道干啥，上班工作上班，无限循环中。。。\r\n</p>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('8', '0', '<p style=\"text-align:center;\">\r\n	<br />\r\n&nbsp;\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; 身体和灵魂，总有一个要在路上。——题记<br />\r\n<br />\r\n　　我喜欢读书。捧一杯香茗，读一本好书，听琴音流淌，悟人生真谛。读书于我，是一种来自灵魂的享受，只为求得心灵的宁静，只求让自己在求知的路上走得更远。<br />\r\n<br />\r\n　　我喜欢旅行。背上行囊，欣然起行，看遍世间雄奇山水，领略异域风土人情。旅行于我，是对心灵的洗礼，就像翻看一本散着芬芳墨香的书，投入其中，进入一个全新的世界。<br />\r\n<br />\r\n　　读书和旅行，是我一生都无法割舍的存在。<br />\r\n<br />\r\n　　在西藏5000米的高原，我仰着头，看着近若触手可及的苍天，领略到与自然浑然天成的霸气，感受着独属于高原人对信仰的虔诚，那是“天苍苍，野茫茫，风吹草低见牛羊”的豪放，那是一种坚强的力量。<br />\r\n<br />\r\n　　在马来西亚郁郁葱葱的热带雨林看夕阳染红天际，在马六甲海峡金黄的沙滩上听海浪涛声轰鸣，耳边回荡着当地人善意而淳朴的笑声，那是“开轩面场圃，把酒话桑麻”的一见如故，让人绽开最真诚的笑颜。<br />\r\n<br />\r\n　　在黑龙江雪乡深及膝盖的雪地里艰难行走，梦想中的银装素裹近在眼前，树枝上挂着晶莹的冰凌，用相机记录下无数令人心神激荡的瞬间。那是“山舞银蛇，原驰蜡象，欲与天公试比高”的雄浑气势，白雪冰凉的触感，更映衬火热的心。<br />\r\n<br />\r\n　　旅行，在我人生的书中泼墨如画的篇章，是我一辈子珍藏的财富。<br />\r\n<br />\r\n　　在旅行时，我总喜欢带一本书。这书，不需要刻意挑选，也许是崭新的，也许已被我翻阅多次，也许只是一本轻松的言情小说，也许是深刻厚重的《文化苦旅》。因为书，总能在我失落时无声的抚慰，在我烦躁时带来心的宁静。平日里，闲来无事时，让自己沉醉于文字的魅力中，也何尝不是一种享受。<br />\r\n<br />\r\n　　有人说，读一本好书，就是与伟人的一次交谈。沉浸于书中，认真思考，你收获的，远远不止你现在所看到的。<br />\r\n<br />\r\n　　没有两片叶子是完全相同的，书亦是。从每一本书里，你都能看到一个全新的世界。<br />\r\n<br />\r\n　　从仓央嘉措的诗词中，感受“不负如来不负卿”的深情与无奈；从白落梅优美的文笔中，感受“你若安好便是晴天”的传奇；从“蒙古草原狼，不可牵”的坚持中，感受那份深藏于血脉中、作为狼的骄傲；从“月光再亮，终究冰凉”的感慨中，感受时间的流逝，祭奠失去的青春。<br />\r\n<br />\r\n　　有的时候我会觉得，每一本书，就像一个封尘许久的宝藏，它一直在等待着，等待一个人去将它的大门推开，走入其中，尽情汲取精华。<br />\r\n<br />\r\n　　读书，在我人生的路上点起一盏盏摇曳的灯，照亮远方。<br />\r\n<br />\r\n　　读万卷书，行万里路。行路便是读书，读书便是行路。“要么旅行，要么读书，身体和灵魂，必须有一个在路上。”这句《罗马假日》的经典台词，已成为我的目标。多少年后，回首今天，旅行和读书，便是用一生写出的，最好的答卷。\r\n</p>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('9', '0', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<h4>\r\n	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 环球网12月26日综合消息，多家外媒于25日报道，法国《新观察家》杂志驻北京记者郭玉(又称“高洁”)被中国驱离。此前，在巴黎遭到恐怖袭击、中国公众对法国给予高度同情的时候，郭玉发表文章，指责中国政府试图在支持法国反恐的同时塞进“私货”，将中国新疆发生的暴力事件也说成是“恐怖主义”。文章竟宣称“新疆暴力更多的是由于受到无情的镇压”。对此，中国外交部于26日表示，郭玉已不适合继续留在中国工作，同时强调，中国一贯依法保障国外常驻新闻机构和外国记者在华采访报道的合法权益，但绝不容忍为恐怖主义张目的自由。<span style=\"font-weight:normal;\"><br />\r\n<br />\r\n　　11月13日，巴黎发生严重暴力恐怖袭击。之后，中国政府公布了新疆一处煤矿在9月18日发生的暴恐事件，几十名矿工被一群暴恐分子杀害。<br />\r\n<br />\r\n　　然而，郭玉在11月18日写文章攻击中国的民族政策。在报道中，她指责中国政府企图把巴黎的袭击，和自己在新疆打击暴力的活动联系在一起，声称新疆发生的事情和巴黎的袭击“没有丝毫共同之处”。此外，她竟然还称“维吾尔人发起的暴力活动是中国自己的少数民族政策造成的。”“可能是因为受到了虐待、遭遇了不公或财产被侵占而进行的报复”。文章丝毫没看出对遇难者的恻隐之情，对中国偏见之深的咬牙切齿样子让人震惊。 <br />\r\n<br />\r\n　　一名新疆维吾尔族学者听说了郭玉的报道后非常气愤，认为这个法国记者是在胡说八道，这些“例子”都是对新疆现实的严重歪曲。 <br />\r\n<br />\r\n　　早在2014年3月，郭玉还在一篇言辞更尖利的文章中批评新疆反恐，称那里发生的是“军人和警察占领区的起义之举”。<br />\r\n<br />\r\n　　据悉，按照常规程序，数以百计外国驻华记者的证件续签通常在每年11月至12月初进行。郭玉称，截至22日，她尚未收到中国外交部允许她留下来的通知。<br />\r\n<br />\r\n　　中国外交部于26日表态称，法国《新观察家》驻京记者郭玉公然为恐怖主义行径、为残忍杀害无辜平民行径张目，引发了中国民众的公愤。郭未能就她为恐怖主义行径张目的错误言论向中国民众作出严肃道歉，已不适合继续留在中国工作。中国一贯依法保障依法保障国外常驻新闻机构和外国记者在华采访报道的合法权益，但绝不容忍为恐怖主义张目的自由。<br />\r\n<br />\r\n　　郭玉的报道也引发了中国网民的强烈愤慨。在她的个人脸谱(Facebook)主页上，有多名中国网民跟帖指责她，并要求她离开中国。</span><br />\r\n</h4>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('10', '0', '<h4 style=\"text-align:center;\">\r\n	<br />\r\n</h4>\r\n<h4>\r\n	童话故事结尾都很美好。普京对乌克兰和叙利亚的立场在西方引起普遍批评，但是在国内，他却深受许多人的敬仰爱戴。许多俄国人坚信，他就像童话中的英雄，能让美好结局成为现实。<br />\r\n<br />\r\n俄罗斯，初冬的瑞雪，好像有种神奇的魔力。泥泞的田野、破旧的农舍，成为美好的童话世界。如同玻璃雪球，就想拿起来，晃一晃，不错眼珠地盯着看啊看，爱不释手。 当然了，童话故事中都会有英雄人物。离开莫斯科以西70英里，这里的童话也一样。<br />\r\n<br />\r\n维克托·克里斯蒂宁（Viktor Krestinin）带我去看他的母牛。同时还给我念了一段他写的两行诗：维克托是沃洛科拉姆斯克（Volokolamsk）的农民诗人。他在一段诗中写道：<br />\r\n<br />\r\n不管你是天才还是要人，毫无疑问<br />\r\n<br />\r\n最后都在地下六尺安息<br />\r\n<br />\r\n听我说，我们都会得到应得的<br />\r\n<br />\r\n只不过，有人上天堂，有人下地狱。<br />\r\n<br />\r\n但是，听听维克托怎样形容他的总统，普京绝对是不会忍受地狱之火煎熬的。<br />\r\n<br />\r\n维克托告诉我说，“我支持普京，支持他这样打击叙利亚的恐怖分子。普京是真正的领袖。就好像我和我的农场。我接管前，农场一团糟。普京接管前，俄国也真的是一团糟。”<br />\r\n<br />\r\n维克托支持俄国在叙利亚的军事行动，但是，他告诉我说，他反对俄国向叙利亚派遣地面部队。<br />\r\n<br />\r\n我问他，“那么，要是普京说有必要呢？”<br />\r\n<br />\r\n“嗯，如果祖国说有必要，那么我们就要听命。不能辩论最高统帅的命令，而是要执行。”<br />\r\n<br />\r\n在沃洛科拉姆斯克第一中学，我上的也是同样一课。<br />\r\n<br />\r\n柳德米拉·威尔比茨卡娅（Verbitskaya）是老师，她说，“我们在电视上听普京讲话，感觉他关心所有的人。他是一位好总统。”<br />\r\n<br />\r\n柳德米拉在这里教英语35年了。她说，儿子出家，成了僧侣。她还说，总统成了一个好的基督徒。<br />\r\n<br />\r\n我问她，“你全心全意相信普京？”<br />\r\n<br />\r\n柳德米拉回答，“全心全意，百分之百。”<br />\r\n<br />\r\n我接着问，“不管普京在叙利亚问题、军事行动上做出什么决定，你都会支持吗？”<br />\r\n<br />\r\n“是，我们一定支持。”<br />\r\n<br />\r\n“你觉得他会犯错误吗？”<br />\r\n<br />\r\n柳德米拉回答，“我们不怕他犯错误。所有的人都可能犯错误。但是，如果他相信上帝，上帝会改正他。”<br />\r\n<br />\r\n走出校门，我在街上和玛丽娜聊了起来。玛丽娜很担心，因为她相信，俄国空袭叙利亚导致俄国客机在西奈遭炸弹袭击。我提醒她，那些空袭可都是普京的主意，那么，你认为空袭是错误的吗？<br />\r\n<br />\r\n玛丽娜回答说，“就算是，我又能干什么呢？”<br />\r\n<br />\r\n我接着问，“那么，这改变了你对普京的态度吗？”<br />\r\n<br />\r\n她回答，“没有，根本没有。我们爱普京，他是人民的总统！”<br />\r\n<br />\r\n很少俄罗斯人要求总统对他所做的决定承担直接责任。部分原因是俄国历史悠久的传统：尊敬最高领导—不管他/她是沙皇、皇帝、还是总书记；部分原因是俄国电视台：从早到晚为普京唱赞歌。<br />\r\nImage caption 爱国者俱乐部的学员<br />\r\n<br />\r\n穿城来到“俄国爱国者”俱乐部，身穿制服的青少年学员正在边唱歌边练队，歌中唱的是从军的快乐，“你和我注定要为俄国效力，为俄国，这个伟大的国家。”<br />\r\n<br />\r\n这正是普京领导下的俄罗斯一直精心培养的的那种爱国热。<br />\r\n<br />\r\n走进俱乐部，看到一名学员拆散、组装一枝卡拉尼什科夫，总计用时不到16秒！<br />\r\n<br />\r\n学员告诉我说，“普京是伟大的统帅。并不仅仅是俄国人这样看，全世界都是。”<br />\r\n<br />\r\n“俄国爱国者”俱乐部让我感觉很受欢迎，最后一站可就不是这样了。我们开车来到“防治工人文化宫”，大厅里挂着的标语写道：“恐怖主义威胁社会”。<br />\r\n<br />\r\n我们原本希望采访当地的“星座”合唱团，没成想，迎接我们的是警察。文化宫主任怀疑我们是密谋攻击的恐怖分子，叫来了警察。警察让我们填表，解释来参观的目的。 我问文化宫主任，“你真以为我们是恐怖分子？”<br />\r\n<br />\r\n她回答说，“眼下，最好还是什么也别信。”<br />\r\n<br />\r\n警察让填的表填完了，我们总算来到了排练室。当时，“星座”正在练唱的一首歌描绘的是，一条大河穿过茂密的白桦林，一只白色的小鸟飞向天堂，给人间带回神的宽恕。<br />\r\n<br />\r\n一位名叫玛丽亚的歌手告诉我说，“音乐给我们很大帮助。现在，电视新闻总是在播攻击、枪杀，到这里，让我们还相信未来。不过，并不仅仅是音乐。俄国人性格中有很特殊的东西，帮助我们坚强起来，战胜麻烦。”<br />\r\n<br />\r\n童话故事尽管情节曲折、跌宕，通常都有大团圆的美好结局。<br />\r\n<br />\r\n俄国人也在期待着大团圆。许多人坚信，普京总统一定会让美满结局成为现实。<br />\r\n</h4>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('11', '0', '<div style=\"text-align:center;\">\r\n	<br />\r\n<br />\r\n</div>\r\n<p>\r\n	　　中国外交部发言人洪磊在一场例行记者会上说，叙利亚副总理兼外长瓦利德·穆阿利姆将在23日至26日访问中国，并将与中国外长王毅举行会谈。<br />\r\n<br />\r\n　　王毅在上周邀请叙利亚政府和反对派代表访华，北京正在寻求帮助推动叙利亚和平进程的方法。<br />\r\n<br />\r\n　　报道称，中国此前曾接待过叙利亚政府与反对派代表，但它在叙利亚危机中仍是一个处于边缘位置的角色。尽管中国在石油供应上依赖中东地区，但它往往将中东外交留给联合国安理会的其他四个常任理事国处理。<br />\r\n<br />\r\n　　另据日本外交学者网站12月22日报道，中国提出邀请叙利亚政府和反对派代表进行会谈，以推进叙利亚和平进程。中国外交部长王毅日前说，中国将邀请叙利亚总统巴沙尔·阿萨德的代表以及与极端主义或恐怖主义活动无关的叙利亚反对派的代表参加会谈。<br />\r\n<br />\r\n　　联合国安理会18日通过了一项关于叙利亚和平进程的决议。第2254号决议呼吁叙利亚政府和反对派在明年1月初开始会谈，此后将在叙利亚全国范围内实现停火。安理会所取得的这次突破被视为在解决叙利亚危机过程中向前迈出了一大步。此前安理会的四份决议草案被中国和俄罗斯否决，两国均反对草案将巴沙尔必须同意下台作为和谈的前提条件。<br />\r\n<br />\r\n　　报道称，中国自一开始就参与了叙利亚问题的国际谈判，但相对美国和俄罗斯一直处于次要地位。中国政府已经明确表示自己不希望出现的结果——西方强行促成的政权更迭、恐怖主义的扩散和人道危机，但就如何通过谈判实现持久和平基本保持沉默。中国如果真的主持叙利亚政府与反对派之间难得的和平谈判，那将是北京在直接参与结束这场棘手冲突的问题上迈出的重大一步。<br />\r\n<br />\r\n　　北京此前曾分别接待过叙利亚政府和反对派的代表，但这是中国政府首次明确提出希望充当调停者。王毅还说，联合国也可能受邀参加中方主持的会谈，以提高此次谈判的合法性。<br />\r\n<br />\r\n　　在中国外交部22日举行的例行记者会上，在被问到关于王毅邀请叙利亚政府和反对派代表来华访问的细节时，发言人洪磊仅表示，中国将邀请叙利亚政府和有关反对派的代表来华访问，这是“中方积极劝和促谈、推动叙利亚问题政治解决努力的一部分”。他还说，外交部将在适当时候发布有关信息。\r\n</p>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('12', '0', '<p>你好，世界！<br></p>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('13', '0', '<p>你好世界</p>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('15', '0', '<p style=\"text-align:center;\">\r\n	<br />\r\n</p>\r\n<p>\r\n	新年快到了，祝大家新年快乐\r\n</p>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('16', '0', '<p>好美意思啊好美意思啊好美意思啊好美意思啊<br></p>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('17', '0', '<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	一直没人，一直没人！\r\n</p>', '', '0');
INSERT INTO `cloud_document_article` VALUES ('21', '0', '<p>你好啊，欢迎光临！<br></p>', '', '0');

-- ----------------------------
-- Table structure for `cloud_document_download`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_document_download`;
CREATE TABLE `cloud_document_download` (
  `id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `parse` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '内容解析类型',
  `content` text NOT NULL COMMENT '下载详细描述',
  `template` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页显示模板',
  `file_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件ID',
  `download` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型下载表';

-- ----------------------------
-- Records of cloud_document_download
-- ----------------------------
INSERT INTO `cloud_document_download` VALUES ('18', '0', '积木云1.0尝鲜版，仅供有能力二次开发的用户使用！<br />', '', '0', '206', '0');
INSERT INTO `cloud_document_download` VALUES ('19', '0', '积木云1.0尝鲜版，仅供有能力二次开发的用户使用！不建议部署到生产环境中！还有很多地方需要完善！关于使用手册请移步到<a target=\"_blank\" href=\"http://www.kancloud.cn/tangtanglove/blockscloud\"><span style=\"color:#E53333;\"><u>看云</u></span></a>，手册现在还不完善请大家见谅！<br />', '', '2', '298', '11721451');
INSERT INTO `cloud_document_download` VALUES ('20', '0', '积木云0.10.29dev版，此版本集成了opensns的模块，但由于opensns代码太过粗糙，维护困难；在1.0版本中将会去除所有opensns模块并会根据重点重写必要模块！', '', '3', '441', '19168482');

-- ----------------------------
-- Table structure for `cloud_file`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_file`;
CREATE TABLE `cloud_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` char(20) NOT NULL DEFAULT '' COMMENT '保存名称',
  `savepath` char(30) NOT NULL DEFAULT '' COMMENT '文件保存路径',
  `ext` char(5) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `location` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文件保存位置',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '远程地址',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_md5` (`md5`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文件表';

-- ----------------------------
-- Records of cloud_file
-- ----------------------------
INSERT INTO `cloud_file` VALUES ('1', '新建文本文档.txt', '56e6db8485dcf.txt', '2016-03-14/', 'txt', 'application/octet-stream', '15', 'a816fe45ffe6b7538b504cd5af70b9b3', '560570c36a1ff93e4c21c03cb6900443499a2397', '0', '', '1457970052');
INSERT INTO `cloud_file` VALUES ('2', 'blockscloud.7z', '56e6ded9e93b1.7z', '2016-03-14/', '7z', 'application/octet-stream', '11721451', '83380bda719b114760c25e619b49889f', 'a76d44447e4a1cda58b7c2496148bce33fbc6e9a', '0', '', '1457970905');
INSERT INTO `cloud_file` VALUES ('3', 'blockscloud_v0.10.29_dev.7z', '56e6f35818ae6.7z', '2016-03-15/', '7z', 'application/octet-stream', '19168482', 'abf762fa7dff97228f6729c06e6fe100', '7beb2f397adf9873a3ec5d6dd9f20082433af796', '0', '', '1457976151');

-- ----------------------------
-- Table structure for `cloud_hacker_lab`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_hacker_lab`;
CREATE TABLE `cloud_hacker_lab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0',
  `url` text,
  `parameter` text,
  `status` tinyint(4) DEFAULT '1',
  `create_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_hacker_lab
-- ----------------------------

-- ----------------------------
-- Table structure for `cloud_hooks`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_hooks`;
CREATE TABLE `cloud_hooks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text COMMENT '描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 ''，''分割',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_hooks
-- ----------------------------
INSERT INTO `cloud_hooks` VALUES ('1', 'pageHeader', '页面header钩子，一般用于加载插件CSS文件和代码', '1', '0', '', '1');
INSERT INTO `cloud_hooks` VALUES ('2', 'pageFooter', '页面footer钩子，一般用于加载插件JS文件和JS代码', '1', '0', 'ReturnTop', '1');
INSERT INTO `cloud_hooks` VALUES ('3', 'documentEditForm', '添加编辑表单的 扩展内容钩子', '1', '0', 'Attachment', '1');
INSERT INTO `cloud_hooks` VALUES ('4', 'documentDetailAfter', '文档末尾显示', '1', '0', 'Attachment,SocialComment', '1');
INSERT INTO `cloud_hooks` VALUES ('5', 'documentDetailBefore', '页面内容前显示用钩子', '1', '0', '', '1');
INSERT INTO `cloud_hooks` VALUES ('6', 'documentSaveComplete', '保存文档数据后的扩展钩子', '2', '0', 'Attachment', '1');
INSERT INTO `cloud_hooks` VALUES ('7', 'documentEditFormContent', '添加编辑表单的内容显示钩子', '1', '0', 'Editor', '1');
INSERT INTO `cloud_hooks` VALUES ('8', 'adminArticleEdit', '后台内容编辑页编辑器', '1', '1378982734', 'EditorForAdmin', '1');
INSERT INTO `cloud_hooks` VALUES ('13', 'AdminIndex', '首页小格子个性化显示', '1', '1382596073', 'SiteStat,SystemInfo,DevTeam', '1');
INSERT INTO `cloud_hooks` VALUES ('14', 'topicComment', '评论提交方式扩展钩子。', '1', '1380163518', 'Editor', '1');
INSERT INTO `cloud_hooks` VALUES ('16', 'app_begin', '应用开始', '2', '1384481614', '', '1');

-- ----------------------------
-- Table structure for `cloud_member`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_member`;
CREATE TABLE `cloud_member` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `nickname` char(16) NOT NULL DEFAULT '' COMMENT '昵称',
  `sex` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '生日',
  `qq` char(10) NOT NULL DEFAULT '' COMMENT 'qq号',
  `score` mediumint(8) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `money` double(10,2) DEFAULT '0.00',
  `sign` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '' COMMENT '用户签名',
  `biography` varchar(255) DEFAULT NULL COMMENT '个人简介',
  `login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员状态',
  PRIMARY KEY (`uid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of cloud_member
-- ----------------------------
INSERT INTO `cloud_member` VALUES ('1', 'Administrator', '0', '0000-00-00', '', '20', '0.00', '', '', '3', '0', '1457958304', '0', '1458136933', '1');

-- ----------------------------
-- Table structure for `cloud_menu`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_menu`;
CREATE TABLE `cloud_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `tip` varchar(255) NOT NULL DEFAULT '' COMMENT '提示',
  `group` varchar(50) DEFAULT '' COMMENT '分组',
  `is_dev` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否仅开发者模式可见',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=164 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_menu
-- ----------------------------
INSERT INTO `cloud_menu` VALUES ('1', '首页', '0', '1', 'Index/index', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('2', '内容', '0', '2', 'Article/index', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('3', '文档列表', '2', '0', 'article/index', '1', '', '内容', '0', '1');
INSERT INTO `cloud_menu` VALUES ('4', '新增', '3', '0', 'article/add', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('5', '编辑', '3', '0', 'article/edit', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('6', '改变状态', '3', '0', 'article/setStatus', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('7', '保存', '3', '0', 'article/update', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('8', '保存草稿', '3', '0', 'article/autoSave', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('9', '移动', '3', '0', 'article/move', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('10', '复制', '3', '0', 'article/copy', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('11', '粘贴', '3', '0', 'article/paste', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('12', '导入', '3', '0', 'article/batchOperate', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('13', '回收站', '2', '0', 'article/recycle', '1', '', '内容', '0', '1');
INSERT INTO `cloud_menu` VALUES ('14', '还原', '13', '0', 'article/permit', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('15', '清空', '13', '0', 'article/clear', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('16', '用户', '0', '3', 'User/index', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('17', '用户信息', '16', '0', 'User/index', '0', '', '用户管理', '0', '1');
INSERT INTO `cloud_menu` VALUES ('18', '新增用户', '17', '0', 'User/add', '0', '添加新用户', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('19', '用户行为', '16', '0', 'User/action', '0', '', '行为管理', '0', '1');
INSERT INTO `cloud_menu` VALUES ('20', '新增用户行为', '19', '0', 'User/addaction', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('21', '编辑用户行为', '19', '0', 'User/editaction', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('22', '保存用户行为', '19', '0', 'User/saveAction', '0', '\"用户->用户行为\"保存编辑和新增的用户行为', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('23', '变更行为状态', '19', '0', 'User/setStatus', '0', '\"用户->用户行为\"中的启用,禁用和删除权限', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('24', '禁用会员', '19', '0', 'User/changeStatus?method=forbidUser', '0', '\"用户->用户信息\"中的禁用', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('25', '启用会员', '19', '0', 'User/changeStatus?method=resumeUser', '0', '\"用户->用户信息\"中的启用', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('26', '删除会员', '19', '0', 'User/changeStatus?method=deleteUser', '0', '\"用户->用户信息\"中的删除', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('27', '权限管理', '16', '0', 'AuthManager/index', '0', '', '用户管理', '0', '1');
INSERT INTO `cloud_menu` VALUES ('28', '删除', '27', '0', 'AuthManager/changeStatus?method=deleteGroup', '0', '删除用户组', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('29', '禁用', '27', '0', 'AuthManager/changeStatus?method=forbidGroup', '0', '禁用用户组', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('30', '恢复', '27', '0', 'AuthManager/changeStatus?method=resumeGroup', '0', '恢复已禁用的用户组', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('31', '新增', '27', '0', 'AuthManager/createGroup', '0', '创建新的用户组', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('32', '编辑', '27', '0', 'AuthManager/editGroup', '0', '编辑用户组名称和描述', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('33', '保存用户组', '27', '0', 'AuthManager/writeGroup', '0', '新增和编辑用户组的\"保存\"按钮', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('34', '授权', '27', '0', 'AuthManager/group', '0', '\"后台 \\ 用户 \\ 用户信息\"列表页的\"授权\"操作按钮,用于设置用户所属用户组', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('35', '访问授权', '27', '0', 'AuthManager/access', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"访问授权\"操作按钮', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('36', '成员授权', '27', '0', 'AuthManager/user', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"成员授权\"操作按钮', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('37', '解除授权', '27', '0', 'AuthManager/removeFromGroup', '0', '\"成员授权\"列表页内的解除授权操作按钮', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('38', '保存成员授权', '27', '0', 'AuthManager/addToGroup', '0', '\"用户信息\"列表页\"授权\"时的\"保存\"按钮和\"成员授权\"里右上角的\"添加\"按钮)', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('39', '分类授权', '27', '0', 'AuthManager/category', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"分类授权\"操作按钮', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('40', '保存分类授权', '27', '0', 'AuthManager/addToCategory', '0', '\"分类授权\"页面的\"保存\"按钮', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('41', '模型授权', '27', '0', 'AuthManager/modelauth', '0', '\"后台 \\ 用户 \\ 权限管理\"列表页的\"模型授权\"操作按钮', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('42', '保存模型授权', '27', '0', 'AuthManager/addToModel', '0', '\"分类授权\"页面的\"保存\"按钮', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('43', '扩展', '0', '7', 'Addons/index', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('44', '插件管理', '43', '1', 'Addons/index', '0', '', '扩展', '0', '1');
INSERT INTO `cloud_menu` VALUES ('45', '创建', '44', '0', 'Addons/create', '0', '服务器上创建插件结构向导', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('46', '检测创建', '44', '0', 'Addons/checkForm', '0', '检测插件是否可以创建', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('47', '预览', '44', '0', 'Addons/preview', '0', '预览插件定义类文件', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('48', '快速生成插件', '44', '0', 'Addons/build', '0', '开始生成插件结构', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('49', '设置', '44', '0', 'Addons/config', '0', '设置插件配置', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('50', '禁用', '44', '0', 'Addons/disable', '0', '禁用插件', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('51', '启用', '44', '0', 'Addons/enable', '0', '启用插件', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('52', '安装', '44', '0', 'Addons/install', '0', '安装插件', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('53', '卸载', '44', '0', 'Addons/uninstall', '0', '卸载插件', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('54', '更新配置', '44', '0', 'Addons/saveconfig', '0', '更新插件配置处理', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('55', '插件后台列表', '44', '0', 'Addons/adminList', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('56', 'URL方式访问插件', '44', '0', 'Addons/execute', '0', '控制是否有权限通过url访问插件控制器方法', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('57', '钩子管理', '43', '2', 'Addons/hooks', '0', '', '扩展', '0', '1');
INSERT INTO `cloud_menu` VALUES ('58', '模型管理', '68', '3', 'Model/index', '0', '', '系统设置', '0', '1');
INSERT INTO `cloud_menu` VALUES ('59', '新增', '58', '0', 'model/add', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('60', '编辑', '58', '0', 'model/edit', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('61', '改变状态', '58', '0', 'model/setStatus', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('62', '保存数据', '58', '0', 'model/update', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('63', '属性管理', '68', '0', 'Attribute/index', '1', '网站属性配置。', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('64', '新增', '63', '0', 'Attribute/add', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('65', '编辑', '63', '0', 'Attribute/edit', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('66', '改变状态', '63', '0', 'Attribute/setStatus', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('67', '保存数据', '63', '0', 'Attribute/update', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('68', '系统', '0', '4', 'Config/group', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('69', '网站设置', '68', '1', 'Config/group', '0', '', '系统设置', '0', '1');
INSERT INTO `cloud_menu` VALUES ('70', '配置管理', '68', '4', 'Config/index', '0', '', '系统设置', '0', '1');
INSERT INTO `cloud_menu` VALUES ('71', '编辑', '70', '0', 'Config/edit', '0', '新增编辑和保存配置', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('72', '删除', '70', '0', 'Config/del', '0', '删除配置', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('73', '新增', '70', '0', 'Config/add', '0', '新增配置', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('74', '保存', '70', '0', 'Config/save', '0', '保存配置', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('75', '菜单管理', '68', '5', 'Menu/index', '0', '', '系统设置', '0', '1');
INSERT INTO `cloud_menu` VALUES ('76', '导航管理', '68', '6', 'Channel/index', '0', '', '系统设置', '0', '1');
INSERT INTO `cloud_menu` VALUES ('77', '新增', '76', '0', 'Channel/add', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('78', '编辑', '76', '0', 'Channel/edit', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('79', '删除', '76', '0', 'Channel/del', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('80', '分类管理', '68', '2', 'Category/index', '0', '', '系统设置', '0', '1');
INSERT INTO `cloud_menu` VALUES ('81', '编辑', '80', '0', 'Category/edit', '0', '编辑和保存栏目分类', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('82', '新增', '80', '0', 'Category/add', '0', '新增栏目分类', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('83', '删除', '80', '0', 'Category/remove', '0', '删除栏目分类', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('84', '移动', '80', '0', 'Category/operate/type/move', '0', '移动栏目分类', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('85', '合并', '80', '0', 'Category/operate/type/merge', '0', '合并栏目分类', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('86', '备份数据库', '68', '0', 'Database/index?type=export', '0', '', '数据备份', '0', '1');
INSERT INTO `cloud_menu` VALUES ('87', '备份', '86', '0', 'Database/export', '0', '备份数据库', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('88', '优化表', '86', '0', 'Database/optimize', '0', '优化数据表', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('89', '修复表', '86', '0', 'Database/repair', '0', '修复数据表', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('90', '还原数据库', '68', '0', 'Database/index?type=import', '0', '', '数据备份', '0', '1');
INSERT INTO `cloud_menu` VALUES ('91', '恢复', '90', '0', 'Database/import', '0', '数据库恢复', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('92', '删除', '90', '0', 'Database/del', '0', '删除备份文件', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('93', '其他', '0', '5', 'other', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('96', '新增', '75', '0', 'Menu/add', '0', '', '系统设置', '0', '1');
INSERT INTO `cloud_menu` VALUES ('98', '编辑', '75', '0', 'Menu/edit', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('106', '行为日志', '16', '0', 'Action/actionlog', '0', '', '行为管理', '0', '1');
INSERT INTO `cloud_menu` VALUES ('108', '修改密码', '16', '0', 'User/updatePassword', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('109', '修改昵称', '16', '0', 'User/updateNickname', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('110', '查看行为日志', '106', '0', 'action/edit', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('112', '新增数据', '58', '0', 'think/add', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('113', '编辑数据', '58', '0', 'think/edit', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('114', '导入', '75', '0', 'Menu/import', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('115', '生成', '58', '0', 'Model/generate', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('116', '新增钩子', '57', '0', 'Addons/addHook', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('117', '编辑钩子', '57', '0', 'Addons/edithook', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('118', '文档排序', '3', '0', 'Article/sort', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('119', '排序', '70', '0', 'Config/sort', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('120', '排序', '75', '0', 'Menu/sort', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('121', '排序', '76', '0', 'Channel/sort', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('122', '数据列表', '58', '0', 'think/lists', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('123', '审核列表', '3', '0', 'Article/examine', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('124', '商店', '0', '8', 'Appstore/app', '0', '应用商店', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('125', '模块', '124', '0', 'Appstore/app', '0', '', '应用商店', '0', '1');
INSERT INTO `cloud_menu` VALUES ('126', '主题', '124', '0', 'Appstore/theme', '0', '', '应用商店', '0', '1');
INSERT INTO `cloud_menu` VALUES ('127', '插件', '124', '0', 'Appstore/addons', '0', '', '应用商店', '0', '1');
INSERT INTO `cloud_menu` VALUES ('129', '桌面', '0', '9', 'Explorer/index', '1', '用于积木云桌面权限控制', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('130', '目录', '129', '0', 'Explorer/index', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('131', '目录信息', '130', '0', 'Explorer/pathInfo', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('132', '目录模式', '130', '0', 'Explorer/pathChmod', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('133', '目录重命名', '130', '0', 'Explorer/pathRname', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('134', '目录列表', '130', '0', 'Explorer/pathList', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('135', '搜索', '130', '0', 'Explorer/search', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('136', '目录树形结构', '130', '0', 'Explorer/treeList', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('137', '后退', '130', '0', 'Explorer/historyBack', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('138', '前进', '130', '0', 'Explorer/historyNext', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('139', '目录删除', '130', '0', 'Explorer/pathDelete', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('140', '创建目录', '130', '0', 'Explorer/mkdir', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('141', '清空回收站', '129', '0', 'Explorer/pathDeleteRecycle', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('142', '文件', '129', '0', 'Explorer/mkfile', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('143', '复制', '142', '0', 'Explorer/pathCopy', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('144', '剪切', '142', '0', 'Explorer/pathCute', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('145', '粘贴剪切', '142', '0', 'Explorer/pathCuteDrag', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('146', '粘贴复制', '142', '0', 'Explorer/pathCopyDrag', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('147', '查看剪切板', '142', '0', 'Explorer/clipboard', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('148', '剪切板记录', '142', '0', 'Explorer/pathPast', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('149', '文件下载', '142', '0', 'Explorer/fileDownload', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('150', '文件下载后删除', '142', '0', 'Explorer/fileDownloadRemove', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('151', '文件压缩并下载', '142', '0', 'Explorer/zipDownload', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('152', '文件压缩', '142', '0', 'Explorer/zip', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('153', '文件解压', '142', '0', 'Explorer/unzip', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('154', '图片生成缩略图', '142', '0', 'Explorer/image', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('155', '远程下载', '142', '0', 'Explorer/serverDownload', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('156', '文件上传', '142', '0', 'Explorer/fileUpload', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('157', '编辑器', '0', '10', 'Editor/index', '1', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('158', '文件编辑', '157', '0', 'Editor/edit', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('159', '获取文件', '158', '0', 'Editor/fileGet', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('160', '文件保存', '158', '0', 'Editor/fileSave', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('161', '配置信息', '157', '0', 'Editor/getConfig', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('162', '保存配置', '161', '0', 'Editor/setConfig', '0', '', '', '0', '1');
INSERT INTO `cloud_menu` VALUES ('163', '创建文件', '142', '0', 'Explorer/mkfile', '0', '', '', '0', '1');

-- ----------------------------
-- Table structure for `cloud_model`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_model`;
CREATE TABLE `cloud_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '模型标识',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `extend` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '继承的模型',
  `relation` varchar(30) NOT NULL DEFAULT '' COMMENT '继承与被继承模型的关联字段',
  `need_pk` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '新建表时是否需要主键字段',
  `field_sort` text COMMENT '表单字段排序',
  `field_group` varchar(255) NOT NULL DEFAULT '1:基础' COMMENT '字段分组',
  `attribute_list` text COMMENT '属性列表（表的字段）',
  `attribute_alias` varchar(255) NOT NULL DEFAULT '' COMMENT '属性别名定义',
  `template_list` varchar(100) NOT NULL DEFAULT '' COMMENT '列表模板',
  `template_add` varchar(100) NOT NULL DEFAULT '' COMMENT '新增模板',
  `template_edit` varchar(100) NOT NULL DEFAULT '' COMMENT '编辑模板',
  `list_grid` text COMMENT '列表定义',
  `list_row` smallint(2) unsigned NOT NULL DEFAULT '10' COMMENT '列表数据长度',
  `search_key` varchar(50) NOT NULL DEFAULT '' COMMENT '默认搜索字段',
  `search_list` varchar(255) NOT NULL DEFAULT '' COMMENT '高级搜索的字段',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `engine_type` varchar(25) NOT NULL DEFAULT 'MyISAM' COMMENT '数据库引擎',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文档模型表';

-- ----------------------------
-- Records of cloud_model
-- ----------------------------
INSERT INTO `cloud_model` VALUES ('1', 'document', '基础文档', '0', '', '1', '{\"1\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\"]}', '1:基础', '', '', '', '', '', 'id:编号\r\ntitle:标题:[EDIT]\r\ntype:类型\r\nupdate_time:最后更新\r\nstatus:状态\r\nview:浏览\r\nid:操作:[EDIT]|编辑,[DELETE]|删除', '0', '', '', '1383891233', '1384507827', '1', 'MyISAM');
INSERT INTO `cloud_model` VALUES ('2', 'article', '文章', '1', '', '1', '{\"1\":[\"3\",\"24\",\"2\",\"5\"],\"2\":[\"9\",\"13\",\"19\",\"10\",\"12\",\"16\",\"17\",\"26\",\"20\",\"14\",\"11\",\"25\"]}', '1:基础,2:扩展', '', '', '', '', '', '', '0', '', '', '1383891243', '1387260622', '1', 'MyISAM');
INSERT INTO `cloud_model` VALUES ('3', 'download', '下载', '1', '', '1', '{\"1\":[\"3\",\"28\",\"30\",\"32\",\"2\",\"5\",\"31\"],\"2\":[\"13\",\"10\",\"27\",\"9\",\"12\",\"16\",\"17\",\"19\",\"11\",\"20\",\"14\",\"29\"]}', '1:基础,2:扩展', '', '', '', '', '', '', '0', '', '', '1383891252', '1387260449', '1', 'MyISAM');

-- ----------------------------
-- Table structure for `cloud_picture`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_picture`;
CREATE TABLE `cloud_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id自增',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_picture
-- ----------------------------

-- ----------------------------
-- Table structure for `cloud_recharge`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_recharge`;
CREATE TABLE `cloud_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'uid',
  `order` varchar(255) DEFAULT NULL COMMENT '充值订单号',
  `trade_no` varchar(255) DEFAULT NULL COMMENT '支付宝订单号',
  `money` double(11,2) DEFAULT '0.00' COMMENT '充值金额',
  `createtime` int(11) DEFAULT NULL COMMENT '充值时间',
  `recharge_way` varchar(255) DEFAULT NULL COMMENT '充值方式',
  `status` varchar(20) DEFAULT 'WAIT_BUYER_PAY' COMMENT '充值状态 WAIT_BUYER_PAY,TRADE_FINISHED,TRADE_SUCCESS',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_recharge
-- ----------------------------

-- ----------------------------
-- Table structure for `cloud_theme`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_theme`;
CREATE TABLE `cloud_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '主题标识',
  `title` varchar(30) NOT NULL COMMENT '主题名称',
  `description` varchar(255) NOT NULL COMMENT '主题描述',
  `author` varchar(50) NOT NULL COMMENT '开发者',
  `website` varchar(255) NOT NULL COMMENT '开发者网站',
  `version` varchar(20) NOT NULL COMMENT '主题版本',
  `is_com` tinyint(4) NOT NULL,
  `is_setup` tinyint(4) NOT NULL DEFAULT '0' COMMENT '主题是否正在使用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_theme
-- ----------------------------
INSERT INTO `cloud_theme` VALUES ('1', 'sns', '社交版', '社交版', '爱小圈', 'http://www.ixiaoquan.com', '1.0.0', '1', '1');

-- ----------------------------
-- Table structure for `cloud_ucenter_admin`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_ucenter_admin`;
CREATE TABLE `cloud_ucenter_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员用户ID',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '管理员状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of cloud_ucenter_admin
-- ----------------------------

-- ----------------------------
-- Table structure for `cloud_ucenter_app`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_ucenter_app`;
CREATE TABLE `cloud_ucenter_app` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '应用ID',
  `title` varchar(30) NOT NULL COMMENT '应用名称',
  `url` varchar(100) NOT NULL COMMENT '应用URL',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '应用IP',
  `auth_key` varchar(100) NOT NULL DEFAULT '' COMMENT '加密KEY',
  `sys_login` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '同步登陆',
  `allow_ip` varchar(255) NOT NULL DEFAULT '' COMMENT '允许访问的IP',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '应用状态',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='应用表';

-- ----------------------------
-- Records of cloud_ucenter_app
-- ----------------------------

-- ----------------------------
-- Table structure for `cloud_ucenter_member`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_ucenter_member`;
CREATE TABLE `cloud_ucenter_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `mobile` char(15) NOT NULL DEFAULT '' COMMENT '用户手机',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) DEFAULT '0' COMMENT '用户状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of cloud_ucenter_member
-- ----------------------------
INSERT INTO `cloud_ucenter_member` VALUES ('1', 'Administrator', '70eac41f1e48b7c4c4e76d4a72a226d1', 'Admin@Admin.com', '', '1457958304', '0', '1458136933', '0', '1457958304', '1');

-- ----------------------------
-- Table structure for `cloud_ucenter_setting`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_ucenter_setting`;
CREATE TABLE `cloud_ucenter_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '设置ID',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型（1-用户配置）',
  `value` text NOT NULL COMMENT '配置数据',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设置表';

-- ----------------------------
-- Records of cloud_ucenter_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `cloud_url`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_url`;
CREATE TABLE `cloud_url` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '链接唯一标识',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `short` char(100) NOT NULL DEFAULT '' COMMENT '短网址',
  `status` tinyint(2) NOT NULL DEFAULT '2' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='链接表';

-- ----------------------------
-- Records of cloud_url
-- ----------------------------

-- ----------------------------
-- Table structure for `cloud_userdata`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_userdata`;
CREATE TABLE `cloud_userdata` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `type` tinyint(3) unsigned NOT NULL COMMENT '类型标识',
  `target_id` int(10) unsigned NOT NULL COMMENT '目标id',
  UNIQUE KEY `uid` (`uid`,`type`,`target_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_userdata
-- ----------------------------

-- ----------------------------
-- Table structure for `cloud_verify_code`
-- ----------------------------
DROP TABLE IF EXISTS `cloud_verify_code`;
CREATE TABLE `cloud_verify_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1：用户注册，2：密码找回',
  `verify_code` varchar(6) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cloud_verify_code
-- ----------------------------
