/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : db_oneue

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-02-05 15:22:52
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `star_admin`
-- ----------------------------
DROP TABLE IF EXISTS `star_admin`;
CREATE TABLE `star_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(15) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `name` varchar(15) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机',
  `group_id` int(5) NOT NULL DEFAULT '0' COMMENT '管理员组ID',
  `logined_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `logined` int(10) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of star_admin
-- ----------------------------
INSERT INTO star_admin VALUES ('1', 'admin', '$2y$10$K7d6k90BsTHRWTaeYmmkdecHHt6QJ3Dt0Gb6CYPjIG30pKT5kzw9a', '我是管理员', '', '1', '127.0.0.1', '1580529791', '1575352441', '1578403272', '1');

-- ----------------------------
-- Table structure for `star_admin_group`
-- ----------------------------
DROP TABLE IF EXISTS `star_admin_group`;
CREATE TABLE `star_admin_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `permission` text NOT NULL COMMENT '权限',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理组表';

-- ----------------------------
-- Records of star_admin_group
-- ----------------------------
INSERT INTO star_admin_group VALUES ('1', '超级管理员', '[1,2,26,27,28,29,30,31,32,33,3,34,35,36,37,42,38,39,40,41,4,43,44,45,46,47,48,49,50,5,51,52,53,54,55,6,56,57,58,59,60,61,62,63,7,64,65,66,67,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,70]', '1574821794', '1579329240', '1');
INSERT INTO star_admin_group VALUES ('2', '管理员', '[1,68,2,26,27,30,31,3,34,35,38,39,4,43,44,47,48,5,51,6,56,57,60,61,7,64,65,10,11,12,19,20,23,24]', '1574821794', '1578396559', '1');

-- ----------------------------
-- Table structure for `star_admin_log`
-- ----------------------------
DROP TABLE IF EXISTS `star_admin_log`;
CREATE TABLE `star_admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `ip` varchar(255) NOT NULL DEFAULT '' COMMENT 'IP',
  `abstract` varchar(255) NOT NULL DEFAULT '' COMMENT '摘要',
  `admin_id` int(10) NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='日志表';

-- ----------------------------
-- Records of star_admin_log
-- ----------------------------
INSERT INTO star_admin_log VALUES ('1', '127.0.0.1', '新增后台菜单：操作日志，ID：70。', '1', '1579329223');
INSERT INTO star_admin_log VALUES ('2', '127.0.0.1', '修改管理组：超级管理员，ID：1。', '1', '1579329240');
INSERT INTO star_admin_log VALUES ('3', '127.0.0.1', '登录系统。', '1', '1579507117');
INSERT INTO star_admin_log VALUES ('4', '127.0.0.1', '登录系统。', '1', '1579525836');
INSERT INTO star_admin_log VALUES ('5', '127.0.0.1', '登录系统。', '1', '1579525836');
INSERT INTO star_admin_log VALUES ('6', '127.0.0.1', '登录系统。', '1', '1579525844');
INSERT INTO star_admin_log VALUES ('7', '127.0.0.1', '登录系统。', '1', '1579600179');
INSERT INTO star_admin_log VALUES ('8', '127.0.0.1', '修改用户等级：超级会员，ID：3。', '1', '1579600198');
INSERT INTO star_admin_log VALUES ('9', '127.0.0.1', '登录系统。', '1', '1579626155');
INSERT INTO star_admin_log VALUES ('10', '127.0.0.1', '登录系统。', '1', '1579936855');
INSERT INTO star_admin_log VALUES ('11', '127.0.0.1', '修改商品：演示商品-有规格-有图，ID：3。', '1', '1579936869');
INSERT INTO star_admin_log VALUES ('12', '127.0.0.1', '修改商品：演示商品-有规格-有图，ID：3。', '1', '1579938361');
INSERT INTO star_admin_log VALUES ('13', '127.0.0.1', '修改商品：演示商品-无规格，ID：6。', '1', '1579942243');
INSERT INTO star_admin_log VALUES ('14', '127.0.0.1', '登录系统。', '1', '1579957645');
INSERT INTO star_admin_log VALUES ('15', '127.0.0.1', '修改用户：ThankiFu，ID：3。', '1', '1579957657');
INSERT INTO star_admin_log VALUES ('16', '127.0.0.1', '登录系统。', '1', '1580026866');
INSERT INTO star_admin_log VALUES ('17', '127.0.0.1', '修改商品：演示商品-有规格-有图，ID：3。', '1', '1580026877');
INSERT INTO star_admin_log VALUES ('18', '127.0.0.1', '登录系统。', '1', '1580184359');
INSERT INTO star_admin_log VALUES ('19', '127.0.0.1', '登录系统。', '1', '1580292756');
INSERT INTO star_admin_log VALUES ('20', '127.0.0.1', '登录系统。', '1', '1580529792');
INSERT INTO star_admin_log VALUES ('21', '127.0.0.1', '修改文章：，ID：6。', '1', '1580529810');
INSERT INTO star_admin_log VALUES ('22', '127.0.0.1', '修改文章：演示文章6，ID：6。', '1', '1580529821');
INSERT INTO star_admin_log VALUES ('23', '127.0.0.1', '修改文章：演示文章6，ID：6。', '1', '1580529932');
INSERT INTO star_admin_log VALUES ('24', '127.0.0.1', '修改文章：演示文章6，ID：6。', '1', '1580529942');
INSERT INTO star_admin_log VALUES ('25', '127.0.0.1', '修改文章：演示文章6，ID：6。', '1', '1580529950');

-- ----------------------------
-- Table structure for `star_admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `star_admin_menu`;
CREATE TABLE `star_admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '后台菜单ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `controller` varchar(32) NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(32) NOT NULL DEFAULT '' COMMENT '方法',
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '自定义路径',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '图标',
  `parent` int(10) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `position` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `hidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '隐藏（0：否；1：是）',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of star_admin_menu
-- ----------------------------
INSERT INTO star_admin_menu VALUES ('1', '首页', 'Home', 'welcome', '', 'glyphicon-home', '0', '0', '0', '1574854083', '1578233847', '1');
INSERT INTO star_admin_menu VALUES ('2', '文章', '', '', '', 'glyphicon-list-alt', '0', '0', '0', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('3', '商品', '', '', '', 'glyphicon-gift', '0', '0', '0', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('4', '会员', '', '', '', 'glyphicon-user', '0', '0', '0', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('5', '订单', '', '', '', 'glyphicon-shopping-cart', '0', '0', '0', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('6', '帮助', '', '', '', 'glyphicon-question-sign', '0', '0', '0', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('7', '轮播', '', '', '', 'glyphicon-picture', '0', '0', '0', '1574854083', '1578129257', '1');
INSERT INTO star_admin_menu VALUES ('8', '测试', '', '', '', '', '0', '0', '0', '1574854083', '1574854083', '0');
INSERT INTO star_admin_menu VALUES ('9', '测试', '', '', '', '', '0', '0', '0', '1574854083', '1574854083', '0');
INSERT INTO star_admin_menu VALUES ('10', '系统', '', '', '', 'glyphicon-cog', '0', '0', '0', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('11', '管理组', 'Group', 'index', '', '', '10', '0', '0', '1574854083', '1578129218', '1');
INSERT INTO star_admin_menu VALUES ('12', '管理组增改', 'Group', 'show', '', '', '11', '0', '1', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('13', '管理组保存', 'Group', 'store', '', '', '11', '0', '1', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('14', '管理组删除', 'Group', 'delete', '', '', '11', '0', '1', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('15', '管理员', 'Admin', 'index', '', '', '10', '0', '0', '1574854083', '1578129222', '1');
INSERT INTO star_admin_menu VALUES ('16', '管理员增改', 'Admin', 'show', '', '', '15', '0', '1', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('17', '管理员保存', 'Admin', 'store', '', '', '15', '0', '1', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('18', '管理员删除', 'Admin', 'delete', '', '', '15', '0', '1', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('19', '后台菜单', 'Menu', 'index', '', '', '10', '0', '0', '1574854083', '1578129226', '1');
INSERT INTO star_admin_menu VALUES ('20', '后台菜单增改', 'Menu', 'show', '', '', '19', '0', '1', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('21', '后台菜单保存', 'Menu', 'store', '', '', '19', '0', '1', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('22', '后台菜单删除', 'Menu', 'delete', '', '', '19', '0', '1', '1574854083', '1577598155', '1');
INSERT INTO star_admin_menu VALUES ('23', '网站设置', 'Setting', 'index', '', '', '10', '0', '0', '1574854083', '1578129626', '1');
INSERT INTO star_admin_menu VALUES ('24', '附件设置', 'Setting', 'annex', '', '', '10', '0', '0', '1574854083', '1578129236', '1');
INSERT INTO star_admin_menu VALUES ('25', '设置保存', 'Setting', 'store', '', '', '10', '0', '1', '1574854083', '1578129241', '1');
INSERT INTO star_admin_menu VALUES ('26', '文章管理', 'Article', 'index', '', '', '2', '0', '0', '1574854083', '1578242105', '1');
INSERT INTO star_admin_menu VALUES ('27', '文章增改', 'Article', 'show', '', '', '26', '0', '1', '1574854083', '1577967832', '1');
INSERT INTO star_admin_menu VALUES ('28', '文章保存', 'Article', 'store', '', '', '26', '0', '1', '1574854083', '1574854083', '1');
INSERT INTO star_admin_menu VALUES ('29', '文章删除', 'Article', 'delete', '', '', '26', '0', '1', '1574688854', '1575306306', '1');
INSERT INTO star_admin_menu VALUES ('30', '文章分类', 'Article', 'categoryIndex', 'category/index', '', '2', '0', '0', '1574688960', '1578242072', '1');
INSERT INTO star_admin_menu VALUES ('31', '文章分类增改', 'Article', 'categoryShow', 'category/show', '', '30', '0', '1', '1574689376', '0', '1');
INSERT INTO star_admin_menu VALUES ('32', '文章分类保存', 'Article', 'categoryStore', 'category/store', '', '30', '0', '1', '1574689530', '0', '1');
INSERT INTO star_admin_menu VALUES ('33', '文章分类删除', 'Article', 'categoryDelete', 'category/delete', '', '30', '0', '1', '1574689605', '0', '1');
INSERT INTO star_admin_menu VALUES ('34', '商品管理', 'Product', 'index', '', '', '3', '0', '0', '1574689646', '0', '1');
INSERT INTO star_admin_menu VALUES ('35', '商品增改', 'Product', 'show', '', '', '34', '0', '1', '1574689694', '0', '1');
INSERT INTO star_admin_menu VALUES ('36', '商品保存', 'Product', 'store', '', '', '34', '0', '1', '1574689791', '0', '1');
INSERT INTO star_admin_menu VALUES ('37', '商品删除', 'Product', 'delete', '', '', '34', '0', '1', '1574821696', '1574821821', '1');
INSERT INTO star_admin_menu VALUES ('38', '商品分类', 'Product', 'categoryIndex', 'category/index', '', '3', '0', '0', '1577967872', '0', '1');
INSERT INTO star_admin_menu VALUES ('39', '商品分类增改', 'Product', 'categoryShow', 'category/show', '', '38', '0', '1', '1577967919', '0', '1');
INSERT INTO star_admin_menu VALUES ('40', '商品分类保存', 'Product', 'categoryStore', 'category/store', '', '38', '0', '1', '1577967949', '0', '1');
INSERT INTO star_admin_menu VALUES ('41', '商品分类删除', 'Product', 'categoryDelete', 'category/delete', '', '38', '0', '1', '1577967966', '0', '1');
INSERT INTO star_admin_menu VALUES ('42', '商品规格删除', 'Product', 'specificationDelete', '', '', '34', '0', '1', '1577967949', '0', '1');
INSERT INTO star_admin_menu VALUES ('43', '会员管理', 'User', 'index', '', '', '4', '0', '0', '1577971816', '0', '1');
INSERT INTO star_admin_menu VALUES ('44', '会员增改', 'User', 'show', '', '', '43', '0', '1', '1577971864', '0', '1');
INSERT INTO star_admin_menu VALUES ('45', '会员保存', 'User', 'store', '', '', '43', '0', '1', '1577971882', '0', '1');
INSERT INTO star_admin_menu VALUES ('46', '会员删除', 'User', 'delete', '', '', '43', '0', '1', '1577971895', '0', '1');
INSERT INTO star_admin_menu VALUES ('47', '会员等级', 'User', 'levelIndex', 'level/index', '', '4', '0', '0', '1577971929', '1578396313', '1');
INSERT INTO star_admin_menu VALUES ('48', '会员等级增改', 'User', 'levelShow', 'level/show', '', '47', '0', '1', '1577971952', '0', '1');
INSERT INTO star_admin_menu VALUES ('49', '会员等级保存', 'User', 'levelStore', 'level/store', '', '47', '0', '1', '1577971974', '0', '1');
INSERT INTO star_admin_menu VALUES ('50', '会员等级删除', 'User', 'levelDelete', 'level/delete', '', '47', '0', '1', '1577971993', '0', '1');
INSERT INTO star_admin_menu VALUES ('51', '订单管理', 'Order', 'index', '', '', '5', '0', '0', '1577972028', '0', '1');
INSERT INTO star_admin_menu VALUES ('52', '订单增改', 'Order', 'show', '', '', '51', '0', '1', '1577972113', '0', '1');
INSERT INTO star_admin_menu VALUES ('53', '订单保存', 'Order', 'store', '', '', '51', '0', '1', '1577972131', '0', '1');
INSERT INTO star_admin_menu VALUES ('54', '订单删除', 'Order', 'delete', '', '', '51', '0', '1', '1577972147', '0', '1');
INSERT INTO star_admin_menu VALUES ('55', '订单发货增改', 'Order', 'shipmentShow', 'shipment/show', '', '51', '0', '1', '1577972160', '1578726183', '1');
INSERT INTO star_admin_menu VALUES ('56', '帮助管理', 'Help', 'index', '', '', '6', '0', '0', '1577972235', '0', '1');
INSERT INTO star_admin_menu VALUES ('57', '帮助增改', 'Help', 'show', '', '', '56', '0', '1', '1577972252', '0', '1');
INSERT INTO star_admin_menu VALUES ('58', '帮助保存', 'Help', 'store', '', '', '56', '0', '1', '1577972263', '0', '1');
INSERT INTO star_admin_menu VALUES ('59', '帮助删除', 'Help', 'delete', '', '', '56', '0', '1', '1577972275', '0', '1');
INSERT INTO star_admin_menu VALUES ('60', '帮助分类', 'Help', 'categoryIndex', 'category/index', '', '6', '0', '0', '1577972300', '0', '1');
INSERT INTO star_admin_menu VALUES ('61', '帮助分类增改', 'Help', 'categoryShow', 'category/show', '', '60', '0', '1', '1577972333', '0', '1');
INSERT INTO star_admin_menu VALUES ('62', '帮助分类保存', 'Help', 'categoryStore', 'category/store', '', '60', '0', '1', '1577972346', '0', '1');
INSERT INTO star_admin_menu VALUES ('63', '帮助分类删除', 'Help', 'categoryDelete', 'category/delete', '', '60', '0', '1', '1577972359', '0', '1');
INSERT INTO star_admin_menu VALUES ('64', '轮播管理', 'Slide', 'index', '', '', '7', '0', '0', '1578129312', '0', '1');
INSERT INTO star_admin_menu VALUES ('65', '轮播增改', 'Slide', 'show', '', '', '64', '0', '1', '1578129333', '0', '1');
INSERT INTO star_admin_menu VALUES ('66', '轮播保存', 'Slide', 'store', '', '', '64', '0', '1', '1578129348', '0', '1');
INSERT INTO star_admin_menu VALUES ('67', '轮播删除', 'Slide', 'delete', '', '', '64', '0', '1', '1578129362', '0', '1');
INSERT INTO star_admin_menu VALUES ('68', '首页', 'Home', 'index', '', '', '1', '0', '1', '1578233769', '1578233860', '1');
INSERT INTO star_admin_menu VALUES ('69', '订单发货保存', 'Order', 'shipmentStore', 'shipment/store', '', '51', '0', '1', '1578726167', '0', '1');
INSERT INTO star_admin_menu VALUES ('70', '操作日志', 'Log', 'index', '', '', '10', '0', '0', '1579329223', '0', '1');

-- ----------------------------
-- Table structure for `star_admin_setting`
-- ----------------------------
DROP TABLE IF EXISTS `star_admin_setting`;
CREATE TABLE `star_admin_setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `key` varchar(255) NOT NULL DEFAULT '' COMMENT '键',
  `value` text NOT NULL COMMENT '值',
  PRIMARY KEY (`id`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='设置表';

-- ----------------------------
-- Records of star_admin_setting
-- ----------------------------
INSERT INTO star_admin_setting VALUES ('1', 'site', '{\"upload_place\":\"picture_qrcode\",\"name\":\"ONEUE\",\"domain\":\"demo.oneue.com\",\"title\":\"\\u4e00\\u4e2a\\u7b80\\u5355\\u7684\\u7535\\u5546\\u7cfb\\u7edf\",\"seo_title\":null,\"seo_description\":null,\"seo_keywords\":null,\"copyright\":\"\\u00a9 ONEUE 2017 - 2019 ALL RIGHTS RESERVED.\",\"miitbeian\":\"\\u8fd9\\u91cc\\u662f\\u5907\\u6848\\u53f7\",\"phone\":null,\"wechat\":\"1111\",\"picture_qrcode\":\"\\/storage\\/uploads\\/MBYvxcl4srQqlFBZn8leV17RY6vGXYik0UEh7oV1.png\",\"shopping\":\"1\",\"auth_register\":\"1\",\"auth_email\":\"1\",\"auth_phone\":\"0\",\"auth_wechat\":\"0\"}');
INSERT INTO star_admin_setting VALUES ('2', 'annex', '{\"size\":null,\"type\":[\".jpg\",\".gif\",\".png\"]}');

-- ----------------------------
-- Table structure for `star_article`
-- ----------------------------
DROP TABLE IF EXISTS `star_article`;
CREATE TABLE `star_article` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '标题',
  `content` longtext NOT NULL COMMENT '内容',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `picture` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `visit` int(10) NOT NULL DEFAULT '0' COMMENT '访问量',
  `category_id` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `seo_title` varchar(80) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` varchar(200) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of star_article
-- ----------------------------
INSERT INTO star_article VALUES ('1', '演示文章1', '<p>文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容文章内容.</p>\n\n<p><img alt=\"\" src=\"/storage/uploads/article.png\" style=\"width: 600px; height: 320px;\" /></p>', '', '/storage/uploads/article.png', '273', '1', '搜索引擎优化的标题_文章_ONEUE', '搜索引擎优化关键词1,搜索引擎优化关键词2,搜索引擎优化关键词3', '搜索引擎优化的描述', '1578229623', '1578552695', '1');
INSERT INTO star_article VALUES ('2', '演示文章2', '<p>文章内容</p>', '', '/storage/uploads/article.png', '270', '2', '', '', '', '1578229640', '1578229666', '1');
INSERT INTO star_article VALUES ('3', '演示文章3', '<p>文章内容</p>', '', '/storage/uploads/article.png', '262', '1', '', '', '', '1578229660', '1579262122', '1');
INSERT INTO star_article VALUES ('4', '演示文章4', '<p>文章内容</p>', '', '/storage/uploads/article.png', '263', '2', '', '', '', '1578230922', '0', '1');
INSERT INTO star_article VALUES ('5', '演示文章5', '<p>文章内容</p>', '', '/storage/uploads/article.png', '260', '2', '', '', '', '1578230939', '0', '1');
INSERT INTO star_article VALUES ('6', '演示文章6', '<p>文章内容</p>', '', '/storage/uploads/article.png', '271', '2', '', '', '', '1578230952', '1580529950', '1');

-- ----------------------------
-- Table structure for `star_article_category`
-- ----------------------------
DROP TABLE IF EXISTS `star_article_category`;
CREATE TABLE `star_article_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `parent` int(10) NOT NULL DEFAULT '0' COMMENT '父级',
  `position` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `seo_title` varchar(80) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` varchar(200) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='文章分类表';

-- ----------------------------
-- Records of star_article_category
-- ----------------------------
INSERT INTO star_article_category VALUES ('1', '居家', '0', '1', '', '', '', '1558616653', '1579262132', '1');
INSERT INTO star_article_category VALUES ('2', '科技', '0', '2', '', '', '', '1558616659', '1572607157', '1');

-- ----------------------------
-- Table structure for `star_cart`
-- ----------------------------
DROP TABLE IF EXISTS `star_cart`;
CREATE TABLE `star_cart` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `quantity` int(10) NOT NULL DEFAULT '0' COMMENT '数量',
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `specification_id` int(10) NOT NULL DEFAULT '0' COMMENT '规格ID',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='购物车表';

-- ----------------------------
-- Records of star_cart
-- ----------------------------
INSERT INTO star_cart VALUES ('1', '2', '1', '3', '3', '1580008961', '1580008961', '1');
INSERT INTO star_cart VALUES ('3', '3', '3', '3', '3', '1580021213', '1580021213', '1');
INSERT INTO star_cart VALUES ('5', '3', '3', '2', '2', '1580024580', '1580024580', '1');

-- ----------------------------
-- Table structure for `star_checkout`
-- ----------------------------
DROP TABLE IF EXISTS `star_checkout`;
CREATE TABLE `star_checkout` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '总数量',
  `market` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场总价',
  `selling` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售总价',
  `vip_offer` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'VIP优惠总计',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总计（不包括订单优惠券）',
  `freight` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最终金额',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '地址ID',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='结算表';

-- ----------------------------
-- Records of star_checkout
-- ----------------------------

-- ----------------------------
-- Table structure for `star_checkout_product`
-- ----------------------------
DROP TABLE IF EXISTS `star_checkout_product`;
CREATE TABLE `star_checkout_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `picture` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `market` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场单价',
  `selling` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售单价',
  `vip_offer` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'VIP优惠',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最终单价（扣除各项优惠）',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '小计（最终单价x数量）',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `specification_id` int(11) NOT NULL DEFAULT '0' COMMENT '规格ID',
  `checkout_id` int(10) NOT NULL DEFAULT '0' COMMENT '结算ID',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 COMMENT='结算商品表';

-- ----------------------------
-- Records of star_checkout_product
-- ----------------------------

-- ----------------------------
-- Table structure for `star_express`
-- ----------------------------
DROP TABLE IF EXISTS `star_express`;
CREATE TABLE `star_express` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` int(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of star_express
-- ----------------------------
INSERT INTO star_express VALUES ('1', '同城配送', '1578721316', '1578721316', '1');
INSERT INTO star_express VALUES ('2', '顺丰快递', '1578721316', '1578721316', '1');

-- ----------------------------
-- Table structure for `star_help`
-- ----------------------------
DROP TABLE IF EXISTS `star_help`;
CREATE TABLE `star_help` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(64) NOT NULL DEFAULT '0' COMMENT '标题',
  `content` longtext NOT NULL COMMENT '内容',
  `visit` int(10) NOT NULL DEFAULT '0' COMMENT '访问量',
  `position` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `category_id` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `seo_title` varchar(80) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` varchar(200) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='帮助表';

-- ----------------------------
-- Records of star_help
-- ----------------------------
INSERT INTO star_help VALUES ('1', '会员注册', '内容', '24', '0', '1', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('2', '购物流程', '内容', '24', '0', '1', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('3', '支付方式', '内容', '24', '0', '1', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('4', '物流配送', '内容', '24', '0', '1', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('5', '售后政策', '内容', '24', '0', '2', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('6', '退款说明', '内容', '24', '0', '2', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('7', '取消订单', '内容', '24', '0', '2', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('8', '找回密码', '内容', '24', '0', '2', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('9', '官方质检', '内容', '24', '0', '3', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('10', '正品保证', '内容', '24', '0', '3', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('11', '闪电发货', '内容', '24', '0', '3', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('12', '七天退换', '内容', '24', '0', '3', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('13', '关于我们', '内容', '24', '0', '4', '0', '0', '0', '1572239039', '1572239073', '1');
INSERT INTO star_help VALUES ('14', '联系我们', '<p>内容</p>', '24', '0', '4', '0', '0', '0', '1572239039', '1579262153', '1');

-- ----------------------------
-- Table structure for `star_help_category`
-- ----------------------------
DROP TABLE IF EXISTS `star_help_category`;
CREATE TABLE `star_help_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `parent` int(10) NOT NULL DEFAULT '0' COMMENT '父级',
  `position` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `seo_title` varchar(80) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` varchar(200) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='帮助分类表';

-- ----------------------------
-- Records of star_help_category
-- ----------------------------
INSERT INTO star_help_category VALUES ('1', '购物', '0', '0', '', '', '', '1577972832', '1577972832', '1');
INSERT INTO star_help_category VALUES ('2', '服务', '0', '0', '', '', '', '1577972832', '1577972832', '1');
INSERT INTO star_help_category VALUES ('3', '保障', '0', '0', '', '', '', '1577972832', '1577972832', '1');
INSERT INTO star_help_category VALUES ('4', '关于', '0', '0', '', '', '', '1577972832', '1577974815', '1');

-- ----------------------------
-- Table structure for `star_order`
-- ----------------------------
DROP TABLE IF EXISTS `star_order`;
CREATE TABLE `star_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `no` varchar(32) NOT NULL DEFAULT '0' COMMENT '编号',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '数量总计',
  `market` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价总计',
  `selling` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售价总计',
  `vip_offer` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'VIP优惠总计',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最终价总计',
  `freight` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实付金额',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '地址ID',
  `address_name` varchar(255) NOT NULL DEFAULT '' COMMENT '地址名字',
  `address_phone` char(11) NOT NULL DEFAULT '' COMMENT '地址电话',
  `address_content` varchar(300) NOT NULL DEFAULT '' COMMENT '地址详情',
  `express_id` int(11) NOT NULL DEFAULT '0' COMMENT '快递ID',
  `express_no` varchar(32) NOT NULL DEFAULT '' COMMENT '快递单号',
  `express_name` varchar(50) NOT NULL DEFAULT '' COMMENT '快递名称',
  `payment_type` varchar(32) NOT NULL DEFAULT '' COMMENT '支付类型',
  `prepaid` int(10) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `shipped` int(10) NOT NULL DEFAULT '0' COMMENT '发货时间',
  `received` int(10) NOT NULL DEFAULT '0' COMMENT '确认时间',
  `reviewed` int(10) NOT NULL DEFAULT '0' COMMENT '评价时间',
  `refunded` int(10) NOT NULL DEFAULT '0' COMMENT '退款时间',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 1：待支付；2：待发货；3：待收货；4：待评价；5：已完成）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Records of star_order
-- ----------------------------
INSERT INTO star_order VALUES ('1', '2020020557100555', '1', '10.00', '1.00', '0.50', '0.50', '0.00', '0.50', '4', '4', '2', '2', '3', '0', '', '', 'wechat-jsapi', '0', '0', '0', '0', '0', '1580551944', '1580551944', '1');
INSERT INTO star_order VALUES ('2', '2020020151555510', '1', '10.00', '1.00', '0.50', '0.50', '0.00', '0.50', '1', '1', '用户', '111', '', '0', '', '', 'wechat-mweb', '0', '0', '0', '0', '0', '1580552419', '1580552419', '1');

-- ----------------------------
-- Table structure for `star_order_product`
-- ----------------------------
DROP TABLE IF EXISTS `star_order_product`;
CREATE TABLE `star_order_product` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '商品名称',
  `picture` varchar(100) NOT NULL DEFAULT '' COMMENT '商品图片',
  `market` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场单价',
  `selling` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售单价',
  `vip_offer` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'VIP优惠',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最终单价',
  `quantity` int(10) NOT NULL DEFAULT '0' COMMENT '数量',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '小计金额',
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `order_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `specification_id` int(10) NOT NULL DEFAULT '0' COMMENT '规格ID',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='订单商品表';

-- ----------------------------
-- Records of star_order_product
-- ----------------------------
INSERT INTO star_order_product VALUES ('1', '演示商品-无规格', '/storage/uploads/product.png', '10.00', '1.00', '0.50', '0.50', '1', '0.50', '4', '1', '1', '0', '1');
INSERT INTO star_order_product VALUES ('2', '演示商品-无规格', '/storage/uploads/product.png', '10.00', '1.00', '0.50', '0.50', '1', '0.50', '1', '2', '1', '0', '1');

-- ----------------------------
-- Table structure for `star_product`
-- ----------------------------
DROP TABLE IF EXISTS `star_product`;
CREATE TABLE `star_product` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '名称',
  `description` longtext NOT NULL COMMENT '详情',
  `sku` int(10) NOT NULL DEFAULT '0' COMMENT 'SKU',
  `market` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `selling` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售价',
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `picture` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `quantity` int(10) NOT NULL DEFAULT '0' COMMENT '库存数量',
  `volume` int(10) NOT NULL DEFAULT '0' COMMENT '销量',
  `visit` int(10) NOT NULL DEFAULT '0' COMMENT '访问量',
  `category_id` int(10) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `seo_title` varchar(80) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` varchar(200) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='商品表';

-- ----------------------------
-- Records of star_product
-- ----------------------------
INSERT INTO star_product VALUES ('1', '演示商品-无规格', '<p>商品描述</p>', '0', '10.00', '1.00', '0.00', '/storage/uploads/product.png', '98', '2', '366', '1', '', '', '', '1578217354', '1579266244', '1');
INSERT INTO star_product VALUES ('2', '演示商品-有规格-无图', '<p>商品描述</p>', '0', '0.00', '1.00', '0.00', '/storage/uploads/product.png', '100', '0', '358', '2', '', '', '', '1578217436', '1578585386', '1');
INSERT INTO star_product VALUES ('3', '演示商品-有规格-有图', '<p>商品描述</p>', '0', '88.00', '78.00', '0.00', '/storage/uploads/product.png', '10', '0', '486', '3', '', '', '', '1578228998', '1580026876', '1');
INSERT INTO star_product VALUES ('4', '演示商品-无规格', '<p>商品描述</p>', '0', '100.00', '99.99', '0.00', '/storage/uploads/product.png', '0', '0', '311', '1', '', '', '', '1578230207', '1578230623', '1');
INSERT INTO star_product VALUES ('5', '演示商品-无规格', '<p>商品描述</p>', '0', '1000.00', '999.99', '0.00', '/storage/uploads/product.png', '100', '0', '359', '1', '', '', '', '1578230372', '1578585413', '1');
INSERT INTO star_product VALUES ('6', '演示商品-无规格', '<p>商品描述</p>', '0', '10000.00', '9999.99', '0.00', '/storage/uploads/product.png', '0', '0', '416', '1', '', '', '', '1578230495', '1579942243', '1');

-- ----------------------------
-- Table structure for `star_product_category`
-- ----------------------------
DROP TABLE IF EXISTS `star_product_category`;
CREATE TABLE `star_product_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `parent` int(10) NOT NULL DEFAULT '0' COMMENT '父级',
  `position` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `seo_title` varchar(80) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `seo_description` varchar(200) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='商品分类表';

-- ----------------------------
-- Records of star_product_category
-- ----------------------------
INSERT INTO star_product_category VALUES ('1', '女装', '0', '1', '', '', '', '1558616653', '1576068434', '1');
INSERT INTO star_product_category VALUES ('2', '男装', '0', '2', '', '', '', '1558616659', '1572607157', '1');
INSERT INTO star_product_category VALUES ('3', '鞋靴', '0', '3', '', '', '', '1558616663', '1572607161', '1');

-- ----------------------------
-- Table structure for `star_product_picture`
-- ----------------------------
DROP TABLE IF EXISTS `star_product_picture`;
CREATE TABLE `star_product_picture` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `picture` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `position` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='商品图片表';

-- ----------------------------
-- Records of star_product_picture
-- ----------------------------
INSERT INTO star_product_picture VALUES ('1', '/storage/uploads/product.png', '0', '1');
INSERT INTO star_product_picture VALUES ('2', '/storage/uploads/product.png', '1', '1');
INSERT INTO star_product_picture VALUES ('3', '/storage/uploads/product.png', '2', '1');
INSERT INTO star_product_picture VALUES ('4', '/storage/uploads/product.png', '3', '1');
INSERT INTO star_product_picture VALUES ('5', '/storage/uploads/product.png', '0', '2');
INSERT INTO star_product_picture VALUES ('6', '/storage/uploads/product.png', '1', '2');
INSERT INTO star_product_picture VALUES ('7', '/storage/uploads/product.png', '2', '2');
INSERT INTO star_product_picture VALUES ('8', '/storage/uploads/product.png', '3', '2');
INSERT INTO star_product_picture VALUES ('9', '/storage/uploads/product.png', '0', '3');
INSERT INTO star_product_picture VALUES ('10', '/storage/uploads/product.png', '1', '3');
INSERT INTO star_product_picture VALUES ('11', '/storage/uploads/product.png', '2', '3');
INSERT INTO star_product_picture VALUES ('12', '/storage/uploads/product.png', '3', '3');
INSERT INTO star_product_picture VALUES ('13', '/storage/uploads/product.png', '0', '4');
INSERT INTO star_product_picture VALUES ('14', '/storage/uploads/product.png', '1', '4');
INSERT INTO star_product_picture VALUES ('15', '/storage/uploads/product.png', '0', '5');
INSERT INTO star_product_picture VALUES ('16', '/storage/uploads/product.png', '0', '6');

-- ----------------------------
-- Table structure for `star_product_specification`
-- ----------------------------
DROP TABLE IF EXISTS `star_product_specification`;
CREATE TABLE `star_product_specification` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `sku` int(10) NOT NULL DEFAULT '0' COMMENT 'SKU',
  `market` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `selling` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售价',
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `picture` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `quantity` int(10) NOT NULL DEFAULT '0' COMMENT '库存数量',
  `position` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='商品规格表';

-- ----------------------------
-- Records of star_product_specification
-- ----------------------------
INSERT INTO star_product_specification VALUES ('1', '规格1', '0', '10.00', '1.00', '0.00', '', '0', '0', '2');
INSERT INTO star_product_specification VALUES ('2', '规格2', '0', '20.00', '2.00', '0.00', '', '100', '0', '2');
INSERT INTO star_product_specification VALUES ('3', '规格1', '0', '88.00', '78.00', '0.00', '/storage/uploads/specification.png', '10', '0', '3');
INSERT INTO star_product_specification VALUES ('4', '规格2', '0', '20.00', '88.00', '0.00', '/storage/uploads/specification.png', '0', '0', '3');

-- ----------------------------
-- Table structure for `star_slide`
-- ----------------------------
DROP TABLE IF EXISTS `star_slide`;
CREATE TABLE `star_slide` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '标题',
  `subtitle` varchar(64) NOT NULL DEFAULT '' COMMENT '副标题',
  `picture` varchar(100) NOT NULL DEFAULT '' COMMENT '图片地址',
  `url` varchar(300) NOT NULL DEFAULT '' COMMENT '链接地址',
  `position` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='轮播表';

-- ----------------------------
-- Records of star_slide
-- ----------------------------
INSERT INTO star_slide VALUES ('1', '欢迎光临', '这是一个简单电商系统的演示站', '/storage/uploads/slide-1.png', '##', '0', '1558514755', '1578216973', '1');
INSERT INTO star_slide VALUES ('2', '返璞归真', '没有绚丽多彩的页面，只有非黑即白的纯粹', '/storage/uploads/slide-2.png', '##', '0', '1558514751', '1578216680', '1');
INSERT INTO star_slide VALUES ('3', '简单直接', '仅有直降打折的优惠，服务于喜欢简单的人', '/storage/uploads/slide-3.png', '##', '0', '1561970293', '1578232758', '1');

-- ----------------------------
-- Table structure for `star_user`
-- ----------------------------
DROP TABLE IF EXISTS `star_user`;
CREATE TABLE `star_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(15) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机',
  `avatar` varchar(200) NOT NULL DEFAULT '/images/avatar.png' COMMENT '头像',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `age` tinyint(4) NOT NULL DEFAULT '0' COMMENT '年龄',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '等级',
  `wechat_openid` varchar(32) NOT NULL DEFAULT '' COMMENT '微信OPENID',
  `wechat_unionid` varchar(32) NOT NULL DEFAULT '' COMMENT '微信UNIONID',
  `remember_token` varchar(100) NOT NULL DEFAULT '' COMMENT '记住令牌',
  `logined_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `logined` int(10) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of star_user
-- ----------------------------
INSERT INTO star_user VALUES ('1', 'user', '$2y$10$y6qfbrJVnojkCIXYFSCHwe3cO/VasJNEuauLixDR.AzFhdCm.oTi2', 'i@thankifu.com', '', '/images/avatar.png', '0', '0', '3', 'oUqS55V0iBhXXEeWv63EcFhqr9Kw', '', 'xnLgb9e1rih8NNJW16OpDJMTyoNXRYjA6tJ5ju4AykqrP05eOgoE7z4wiNry', '127.0.0.1', '1580874872', '1531538199', '1579247670', '1');

-- ----------------------------
-- Table structure for `star_user_address`
-- ----------------------------
DROP TABLE IF EXISTS `star_user_address`;
CREATE TABLE `star_user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(255) NOT NULL DEFAULT '0' COMMENT '姓名',
  `phone` char(11) NOT NULL DEFAULT '0' COMMENT '电话',
  `content` varchar(300) NOT NULL DEFAULT '0' COMMENT '详情',
  `default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否默认（0：否；1：是；）',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `created` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户地址表';

-- ----------------------------
-- Records of star_user_address
-- ----------------------------
INSERT INTO star_user_address VALUES ('1', '用户', '111', '', '1', '1', '1578400773', '1578673156', '1');
INSERT INTO star_user_address VALUES ('2', '1', '2', '3', '0', '3', '1580126215', '0', '1');
INSERT INTO star_user_address VALUES ('3', '测试', '测试哦', '测试测试', '0', '3', '1580127872', '0', '1');
INSERT INTO star_user_address VALUES ('4', '2', '2', '3', '1', '3', '1580127961', '0', '1');

-- ----------------------------
-- Table structure for `star_user_level`
-- ----------------------------
DROP TABLE IF EXISTS `star_user_level`;
CREATE TABLE `star_user_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(15) NOT NULL DEFAULT '' COMMENT '名称',
  `discount` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '折扣',
  `created` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态（ 0：禁用；1：启用；）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户等级表';

-- ----------------------------
-- Records of star_user_level
-- ----------------------------
INSERT INTO star_user_level VALUES ('1', '普通会员', '9.9', '1575693056', '1578585822', '1');
INSERT INTO star_user_level VALUES ('2', '高级会员', '9.8', '1575693063', '1578585874', '1');
INSERT INTO star_user_level VALUES ('3', '超级会员', '5.0', '1575693183', '1579600198', '1');

-- ----------------------------
-- Table structure for `star_user_like`
-- ----------------------------
DROP TABLE IF EXISTS `star_user_like`;
CREATE TABLE `star_user_like` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `article_id` int(10) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='用户喜欢表';

-- ----------------------------
-- Records of star_user_like
-- ----------------------------
INSERT INTO star_user_like VALUES ('1', '1', '0', '1', '1');
INSERT INTO star_user_like VALUES ('2', '3', '6', '0', '1');
INSERT INTO star_user_like VALUES ('3', '3', '5', '0', '0');
INSERT INTO star_user_like VALUES ('4', '3', '1', '0', '1');
INSERT INTO star_user_like VALUES ('5', '3', '3', '0', '0');
INSERT INTO star_user_like VALUES ('6', '3', '0', '6', '1');
INSERT INTO star_user_like VALUES ('7', '3', '0', '3', '1');
INSERT INTO star_user_like VALUES ('8', '3', '4', '0', '0');
INSERT INTO star_user_like VALUES ('9', '1', '1', '0', '1');
INSERT INTO star_user_like VALUES ('10', '4', '0', '1', '1');
INSERT INTO star_user_like VALUES ('11', '4', '1', '0', '1');
INSERT INTO star_user_like VALUES ('12', '4', '2', '0', '1');
INSERT INTO star_user_like VALUES ('13', '4', '0', '3', '1');
