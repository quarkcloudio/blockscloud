DROP TABLE IF EXISTS `onethink_message_board`;
CREATE TABLE `onethink_message_board` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '标题',
  `content` char(200) NOT NULL COMMENT '内容',
  `name` char(200) DEFAULT NULL,
  `email` char(200) DEFAULT NULL,
  `phone` char(140) NOT NULL DEFAULT '' COMMENT '联系方式',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态（0：禁用，1：正常）',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='留言板';