/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : myblog

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 27/07/2018 18:23:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for le_admin
-- ----------------------------
DROP TABLE IF EXISTS `le_admin`;
CREATE TABLE `le_admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `image_url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '头像',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;



-- ----------------------------
-- Table structure for le_article
-- ----------------------------
DROP TABLE IF EXISTS `le_article`;
CREATE TABLE `le_article`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED NOT NULL COMMENT '栏目ID',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `keywords` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '标签',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '摘要',
  `image_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图片',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `author` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '文章作者',
  `source` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '文章来源',
  `hits` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '点击量',
  `comment_num` int(11) NOT NULL DEFAULT 0 COMMENT '评论数量',
  `is_recommend` tinyint(1) NULL DEFAULT 0 COMMENT '是否推荐',
  `is_top` tinyint(4) NULL DEFAULT 0 COMMENT '是否置顶',
  `is_show` tinyint(1) NULL DEFAULT 1 COMMENT '是否显示  0为不显示 1为显示',
  `url` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '文章链接',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `category_id`(`category_id`) USING BTREE,
  INDEX `hits`(`hits`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of le_article
-- ----------------------------
INSERT INTO `le_article` VALUES (37, 38, 'lecms安装注意事项', 'lecms上线了、lecms、博客、开源、开源系统', 'lecms安装注意事项', '/uploads/images/20180727/1210ac207eaf2795e22646970799f345.png', '&lt;p&gt;lecms终于上线了，一个简单的博客拖了两个月。拖延症是该好好改改了。&lt;/p&gt;&lt;p&gt;接下来主要说明下lecms安装过程中需要注意的事项：&lt;/p&gt;&lt;p&gt;① 版本要求：由于代码中使用了PHP7.0的新特性所以&lt;span style=&quot;white-space: normal;&quot;&gt;PHP版本务必 &amp;gt;= 5.6，强烈推荐PHP7.0&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;② 伪静态设置： 基于ThinkPHP5.0的URL重写功能&amp;nbsp; 详情参考：https://www.kancloud.cn/manual/thinkphp5/177576&lt;/p&gt;&lt;p&gt;③ runtim目录权限问题，针对Linux服务器此目录 最低应给予755权限，Windows服务器无需配置。&lt;/p&gt;', '', '', 0, 0, 1, 0, 1, '/article/37.html', 1532684271, 0, 0);
INSERT INTO `le_article` VALUES (38, 38, 'lecms手动安装教程', 'lecms、博客、开源系统', 'lecms手动安装教程', '/uploads/images/20180727/60f5fe24196764d644a6d6a5f7f25358.png', '&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;①&amp;nbsp; 首先拷贝程序到你服务器项目的&lt;span style=&quot;color:#ff0000&quot;&gt;根目录&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;②&amp;nbsp; 创建一个utf8格式的数据库&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;③&amp;nbsp; 找到&lt;/span&gt;&lt;span style=&quot;font-family: &amp;quot;Microsoft YaHei&amp;quot;; white-space: normal;font-size:18px&quot;&gt;application/install/sql/&lt;/span&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;项目下自动安装的SQL文件，table.sql和data.sql&amp;nbsp; &amp;nbsp;先导入table.sql再导入data.sql&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;img src=&quot;http://www.myblog.cc/uploads/umeditor/20180727/0b4beffe8293ab7bd06d4d2fe5e9a6ce.png&quot; _src=&quot;http://www.myblog.cc/uploads/umeditor/20180727/0b4beffe8293ab7bd06d4d2fe5e9a6ce.png&quot; style=&quot;width: 540px; height: 413px;&quot;/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;br/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;④ 利用数据库管理工具（phpMyAdmin、Navicat）插入后台管理员信息&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;br/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;username：admin&amp;nbsp; &amp;nbsp; &amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;password:&amp;nbsp; &amp;nbsp;51533e6c16c366978f9c79e5ef642384&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;br/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;img src=&quot;http://www.myblog.cc/uploads/umeditor/20180727/556fe0eca45f1a0613fb78577d8108fe.png&quot; _src=&quot;http://www.myblog.cc/uploads/umeditor/20180727/556fe0eca45f1a0613fb78577d8108fe.png&quot; style=&quot;width: 820px; height: 222px;&quot;/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;br/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px; white-space: normal;&quot;&gt;管理员账号：&lt;span style=&quot;color:#ff0000&quot;&gt;admin&lt;/span&gt; 密码：&lt;span style=&quot;color:#ff0000&quot;&gt;123456&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;span style=&quot;font-family: &amp;quot;Microsoft YaHei&amp;quot;; font-size: 14px; white-space: normal;color:#ff0000&quot;&gt;&lt;br/&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: &amp;quot;Microsoft YaHei&amp;quot;; white-space: normal;font-size:18px&quot;&gt;⑤&amp;nbsp; 修改&lt;span style=&quot;font-family: &amp;quot;Microsoft YaHei&amp;quot;; white-space: normal;&quot;&gt;/application/database.php&lt;/span&gt;配置文件&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: &amp;quot;Microsoft YaHei&amp;quot;; white-space: normal;font-size:18px&quot;&gt;&lt;br/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: &amp;quot;Microsoft YaHei&amp;quot;; white-space: normal;font-size:18px&quot;&gt;&lt;img src=&quot;http://www.myblog.cc/uploads/umeditor/20180727/c67bef78bb1bbdcc5051ce0af49e3d0d.png&quot; _src=&quot;http://www.myblog.cc/uploads/umeditor/20180727/c67bef78bb1bbdcc5051ce0af49e3d0d.png&quot; style=&quot;width: 810px; height: 438px;&quot;/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px;color:#ff0000&quot;&gt;⑥&amp;nbsp;&lt;span style=&quot;font-family: &amp;quot;Microsoft YaHei&amp;quot;; white-space: normal;&quot;&gt;在/application/下面新建文件install.lock，文件内容随意填写（如：LeCMS-博客系统:2018-07-27 11:30:26 by v1.0.0 ），这一步不可少&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;br/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;⑦ 登录进后台&amp;nbsp; 访问：域名/admin&amp;nbsp; &amp;nbsp; 登录后&lt;span style=&quot;color:#ff0000&quot;&gt;更新缓存&amp;nbsp; &lt;/span&gt;&amp;nbsp;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;&lt;br/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;⑧ 安装完成&lt;/span&gt;&lt;/p&gt;', '', '', 0, 0, 1, 0, 1, '/article/38.html', 1532685758, 0, 0);

-- ----------------------------
-- Table structure for le_category
-- ----------------------------
DROP TABLE IF EXISTS `le_category`;
CREATE TABLE `le_category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '父级id  顶级为0',
  `model_id` int(11) NOT NULL DEFAULT 0 COMMENT '模型id  对应model表',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '栏目名称',
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '栏目描述',
  `is_menu` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否导航栏显示  1显示0不显示',
  `url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '栏目链接',
  `sort` int(11) NOT NULL DEFAULT 1 COMMENT '排序 asc 升序',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `delete_time` int(11) NOT NULL DEFAULT 0,
  `index_template` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'index' COMMENT '主页模版',
  `list_template` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'list' COMMENT '列表模板',
  `show_template` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'show' COMMENT '详情页模板',
  `image_url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '封面url',
  `is_cover` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否有封面页',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of le_category
-- ----------------------------
INSERT INTO `le_category` VALUES (33, 0, 2, '技术点滴', '记录日常技术使用', 1, '/article-index/33.html', 1, 1532680962, 1532681425, 0, 'index', 'lists', 'show', '', 0);
INSERT INTO `le_category` VALUES (34, 33, 2, 'PHP', '关于PHP技术的文章', 1, '/article-lists/34.html', 1, 1532680990, 1532681425, 0, 'index', 'lists', 'show', '', 0);
INSERT INTO `le_category` VALUES (35, 33, 2, 'Linux', '关于Linux的技术文章', 1, '/article-lists/35.html', 2, 1532681006, 1532681425, 0, 'index', 'lists', 'show', '', 0);
INSERT INTO `le_category` VALUES (36, 33, 2, 'MySQL', '关于MySQL技术的文章', 1, '/article-lists/36.html', 3, 1532681026, 1532681425, 0, 'index', 'lists', 'show', '', 0);
INSERT INTO `le_category` VALUES (37, 33, 2, 'WEB前端', '关于WEB前端的技术文章', 1, '/article-index/37.html', 4, 1532681066, 1532681425, 0, 'index', 'lists', 'show', '', 0);
INSERT INTO `le_category` VALUES (38, 33, 2, '杂谈', '关于其他技术的记录', 1, '/article-index/38.html', 5, 1532681090, 1532681425, 0, 'index', 'lists', 'show', '', 0);
INSERT INTO `le_category` VALUES (39, 0, 5, '分享无价', '开源程序的无偿分享', 1, '/download-index/39.html', 2, 1532681184, 1532681425, 0, 'index', 'lists', 'show', '', 0);
INSERT INTO `le_category` VALUES (40, 39, 5, '源码分享', '', 1, '/download-lists/40.html', 20, 1532681206, 1532681425, 0, 'index', 'lists', 'show', '', 0);
INSERT INTO `le_category` VALUES (41, 0, 1, '关于我', '', 1, '/page/41.html', 3, 1532681226, 1532681425, 0, 'index', 'lists', 'show', '', 0);
INSERT INTO `le_category` VALUES (42, 0, 3, '我的相册', '', 1, '/picture-index/42.html', 4, 1532681379, 1532681425, 0, 'index', 'lists', 'show', '', 0);
INSERT INTO `le_category` VALUES (43, 0, 6, '视频分享', '', 1, '/video-index/43.html', 5, 1532681422, 1532681425, 0, 'index', 'lists', 'show', '', 0);
INSERT INTO `le_category` VALUES (44, 0, 4, '恒哥博客', '', 1, 'http://www.qq123.xin', 20, 1532681447, 1532681447, 0, 'index', 'lists', 'show', '', 0);
INSERT INTO `le_category` VALUES (45, 0, 4, 'lecms下载', 'lecms下载', 1, 'https://gitee.com/henggedaren/lecms', 20, 1532683621, 1532683621, 0, 'index', 'lists', 'show', '', 0);

-- ----------------------------
-- Table structure for le_comment
-- ----------------------------
DROP TABLE IF EXISTS `le_comment`;
CREATE TABLE `le_comment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `a_id` int(11) NOT NULL DEFAULT 0 COMMENT '内容id',
  `c_id` int(11) NOT NULL COMMENT '分类id',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '父级id  如果不等于0  表示楼中楼',
  `content` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '评论内容',
  `send` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '发送者信息 后期增加用户登录时可变成用户id',
  `receive` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '接收者信息 后期增加用户登录时可变成用户id',
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'ip',
  `reply` int(11) NOT NULL DEFAULT 0 COMMENT '回复数量',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `delete_time` int(11) NOT NULL DEFAULT 0,
  `is_status` tinyint (2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 187 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for le_download
-- ----------------------------
DROP TABLE IF EXISTS `le_download`;
CREATE TABLE `le_download`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `image_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '封面图片',
  `file_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '下载文件',
  `demo_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '演示地址',
  `filename` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件名',
  `keywords` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '文件描述',
  `hits` int(11) NULL DEFAULT 0 COMMENT '点击量',
  `download_num` int(11) NULL DEFAULT 0 COMMENT '下载次数',
  `comment_num` int(11) NOT NULL DEFAULT 0 COMMENT '评论数',
  `is_recommend` tinyint(1) NULL DEFAULT 0 COMMENT '是否推荐',
  `is_top` tinyint(4) NULL DEFAULT 0 COMMENT '是否置顶',
  `is_show` tinyint(1) NULL DEFAULT 0 COMMENT '是否显示 0为不显示 1为显示',
  `is_pwd` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '是否需要密码  0为不需要',
  `url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '链接',
  `create_time` int(11) NOT NULL COMMENT '上传时间',
  `update_time` int(11) NOT NULL DEFAULT 0,
  `delete_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `category_id`(`category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for le_models
-- ----------------------------
DROP TABLE IF EXISTS `le_models`;
CREATE TABLE `le_models`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模型名称',
  `tablename` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '表名',
  `index_template` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'index' COMMENT '封面页模板',
  `list_template` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'list' COMMENT '列表模板',
  `show_template` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'show' COMMENT '详情页模板',
  `sort` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'asc 排序',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '模型表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of le_models
-- ----------------------------
INSERT INTO `le_models` VALUES (1, '单页模型', 'page', 'index', 'list', 'show', 2);
INSERT INTO `le_models` VALUES (2, '文章模型', 'article', 'index', 'list', 'show', 1);
INSERT INTO `le_models` VALUES (3, '图集模型', 'picture', 'index', 'list', 'show', 3);
INSERT INTO `le_models` VALUES (4, '链接模型', 'link', 'index', 'list', 'show', 5);
INSERT INTO `le_models` VALUES (5, '下载模型', 'download', 'index', 'list', 'show', 4);
INSERT INTO `le_models` VALUES (6, '视频模型', 'video', 'index', 'list', 'show', 6);

-- ----------------------------
-- Table structure for le_page
-- ----------------------------
DROP TABLE IF EXISTS `le_page`;
CREATE TABLE `le_page`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED NOT NULL COMMENT '分类ID',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `keywords` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '摘要',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `image_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图片',
  `hits` int(11) NOT NULL DEFAULT 0 COMMENT '点击量',
  `is_show` tinyint(1) NULL DEFAULT 1 COMMENT '是否显示  0不显示',
  `comment_num` int(11) NOT NULL DEFAULT 0 COMMENT '评论数',
  `url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `update_time` int(11) NOT NULL DEFAULT 0,
  `delete_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `category_id`(`category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of le_page
-- ----------------------------
INSERT INTO `le_page` VALUES (4, 41, '关于恒哥', '关于', '关于', '&lt;p style=&quot;text-align: left;&quot;&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;大家好，欢迎来到我的个人博客。我是恒哥，90后小生。&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;这里主要记录我的工作和日常点滴。欢迎同行多多沟通，大神多多指点。&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;本人目前主要从事web建站，仿站，公众号开发等工作。如有需要欢迎私聊。&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;如果喜欢，请多多关注并推广。谢谢大家！&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;h2 style=&quot;text-align: center;&quot;&gt;关于lecms&lt;/h2&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; 刚毕业时就想做个博客系统自用，但由于各种原因，加上后来去天朝工作所以一拖再拖。无意间发现了老张博客系统，便一直在用他的。但由于老张博客的bug实在比较多，加之对PHP7.0支持不够友好。所以我才打算重构老张博客。&lt;/p&gt;&lt;p&gt;目前的lecms默认的模板是基于layui2.3的。整体代码已经全部重写。简单明了，特别适合新手入门使用和学习，方便优化和二次开发。另外支持了模板切换和多种存储方法。让程序更加美观和实用。&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;由于技术水平限制，程序难免有未知BUG，如果发现欢迎及时向我反馈。另：本程序长期更新，并提供定制服务。&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;/p&gt;', '', 18, 1, 0, '/page/id/4.html', 1532681595, 1532683591, 0);

-- ----------------------------
-- Table structure for le_picture
-- ----------------------------
DROP TABLE IF EXISTS `le_picture`;
CREATE TABLE `le_picture`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED NOT NULL COMMENT '栏目ID',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图片名称',
  `image_url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '封面图片',
  `images` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '图集地址json',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '详情',
  `keywords` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图片描述',
  `hits` int(11) NULL DEFAULT 0 COMMENT '点击量',
  `is_recommend` tinyint(1) NULL DEFAULT 0 COMMENT '是否推荐',
  `is_top` tinyint(4) NULL DEFAULT 0 COMMENT '是否置顶',
  `is_show` tinyint(1) NULL DEFAULT 0 COMMENT '是否显示 0不显示',
  `is_pwd` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '是否需要密码  0不需要  不为0 就是密码',
  `comment_num` int(11) NOT NULL DEFAULT 0 COMMENT '评论数',
  `url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '地址',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `update_time` int(11) NOT NULL DEFAULT 0,
  `delete_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `category_id`(`category_id`) USING BTREE,
  INDEX `is_recommend`(`is_recommend`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for le_setting
-- ----------------------------
DROP TABLE IF EXISTS `le_setting`;
CREATE TABLE `le_setting`  (
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of le_setting
-- ----------------------------
INSERT INTO `le_setting` VALUES ('search_model', '{\"2\":{\"id\":\"2\",\"name\":\"\\u6587\\u7ae0\\u6a21\\u578b\"}}');
INSERT INTO `le_setting` VALUES ('stationmaster_info', '{\"stationmaster_name\":\"\\u6052\\u54e5\",\"stationmaster_occupation\":\"PHP\\u7a0b\\u5e8f\\u5458\",\"stationmaster_motto\":\"\\u5b66\\u65e0\\u6b62\\u5883\",\"stationmaster_qq\":\"304587661\",\"stationmaster_qqnet\":\"593739481\",\"stationmaster_qqnet_code\":\"<a target=\\\"_blank\\\" href=\\\"\\/\\/shang.qq.com\\/wpa\\/qunwpa?idkey=f79768a1be482c1e32132b71dacaf15b0806c85f848ec719cfb4a4d3581e0027\\\"><img border=\\\"0\\\" src=\\\"\\/\\/pub.idqqimg.com\\/wpa\\/images\\/group.png\\\" alt=\\\"LemonCMS\\\" title=\\\"LemonCMS\\\"><\\/a>\"}');
INSERT INTO `le_setting` VALUES ('file', '');
INSERT INTO `le_setting` VALUES ('logo', '/uploads/images/20180727/60f5fe24196764d644a6d6a5f7f25358.png');
INSERT INTO `le_setting` VALUES ('site_name', 'lecms-恒哥博客');
INSERT INTO `le_setting` VALUES ('qr_code', '/uploads/images/20180727/33ecc1c4528d889ac6b23bc0f14fa0af.png');
INSERT INTO `le_setting` VALUES ('site_url', 'www.qq123.xin');
INSERT INTO `le_setting` VALUES ('icp', '京ICP备17039354号-2 ');
INSERT INTO `le_setting` VALUES ('copy', '恒哥博客 © <a class=\"site_url\" href=\"http://www.qq123.xin\">qq123.xin</a>');
INSERT INTO `le_setting` VALUES ('site_statistice', '<script type=\"text/javascript\">var cnzz_protocol = ((\"https:\" == document.location.protocol) ? \" https://\" : \" http://\");document.write(unescape(\"%3Cspan id=\'cnzz_stat_icon_1274285839\'%3E%3C/span%3E%3Cscript src=\'\" + cnzz_protocol + \"s22.cnzz.com/z_stat.php%3Fid%3D1274285839\' type=\'text/javascript\'%3E%3C/script%3E\"));</script>');
INSERT INTO `le_setting` VALUES ('head_html', '');
INSERT INTO `le_setting` VALUES ('comment_status', '1');
INSERT INTO `le_setting` VALUES ('site_status', '1');
INSERT INTO `le_setting` VALUES ('title_add', '-免费开源的博客系统');
INSERT INTO `le_setting` VALUES ('keywords', '开源、免费、博客、系统、lecms、恒哥博客');
INSERT INTO `le_setting` VALUES ('description', '免费开源的博客系统，记录个人的生活和技术点滴');
INSERT INTO `le_setting` VALUES ('index_banner', '/uploads/images/20180727/44dfe4a0453c8ae24d0bb7695c6ca564.jpg');
INSERT INTO `le_setting` VALUES ('index_banner_bg', '#393D49');
INSERT INTO `le_setting` VALUES ('lemon_banner', '/uploads/images/20180727/e915cf12ca9a872c890753de502d1db8.png');
INSERT INTO `le_setting` VALUES ('lemon_banner_link', 'https://gitee.com/henggedaren/lecms');
INSERT INTO `le_setting` VALUES ('download_info', '/uploads/images/20180727/45b487fef96da825c5579d3c8e78e41b.jpg');
INSERT INTO `le_setting` VALUES ('comment_ban_time', '10');
INSERT INTO `le_setting` VALUES ('upload_type', '1');
INSERT INTO `le_setting` VALUES ('template_name', 'lemon');
INSERT INTO `le_setting` VALUES ('links', '{\"1\":{\"sorts\":{\"1\":\"999\",\"2\":\"1\"},\"sort\":\"999\",\"id\":\"1\",\"name\":\"lecms\",\"link_url\":\"http:\\/\\/www.qq123.xin\"},\"2\":{\"sorts\":{\"1\":\"999\",\"2\":\"1\"},\"sort\":\"1\",\"id\":\"2\",\"name\":\"\\u8001\\u5f20\\u535a\\u5ba2\",\"link_url\":\"http:\\/\\/www.phplaozhang.com\\/\"},\"3\":{\"sorts\":{\"1\":\"999\",\"2\":\"1\"},\"sort\":\"3\",\"id\":\"3\",\"name\":\"lecms\\u591a\\u6a21\\u677f\\u6f14\\u793a\",\"link_url\":\"https:\\/\\/www.usuuu.com\\/\"}}');
INSERT INTO `le_setting` VALUES ('sitemap_model', '2');
INSERT INTO `le_setting` VALUES ('changefreq', 'hourly');
INSERT INTO `le_setting` VALUES ('qiniu_config', '{\"accessKey\":\"i79Pv_HRJ8shDgUWasc3deCnX9ITcmqSNC5WgQ9X\",\"secretKey\":\"SqFj1grVf46e5OAGNF1bumJOFLomWXMjuml4cpVv\",\"bucket\":\"blog\",\"domain\":\"http:\\/\\/blog.usuuu.com\"}');
INSERT INTO `le_setting` VALUES ('edit_type', '2');
INSERT INTO `le_setting` VALUES ('site_name', 'lecms-恒哥博客');
INSERT INTO `le_setting` VALUES ('title_add', '-免费开源的博客系统');
INSERT INTO `le_setting` VALUES ('keywords', '开源、免费、博客、系统、lecms、恒哥博客');
INSERT INTO `le_setting` VALUES ('description', '免费开源的博客系统，记录个人的生活和技术点滴');
INSERT INTO `le_setting` VALUES ('comment_examine','1');

-- ----------------------------
-- Table structure for le_upload
-- ----------------------------
DROP TABLE IF EXISTS `le_upload`;
CREATE TABLE `le_upload`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_size` int(11) NOT NULL DEFAULT 0 COMMENT '文件大小 b',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '上传时间',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '可以 0不可用',
  `filename` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件名',
  `file_path` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件路径 本地的',
  `file_md5` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `file_sha1` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `suffix` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件后缀',
  `up_type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1 本地  2七牛 3oss',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of le_upload
-- ----------------------------
INSERT INTO `le_upload` VALUES (37, 5400, 1532675121, 1, 'logo-header.png.png', '/uploads/images/20180727/34ce10888b0bfd63d243ae68c2feb1d1.png', '337fda13726d512e43724f3f70693ab7', 'a487f025b357ff5ca685d244cba79e635fb81a0d', 'file', 1);
INSERT INTO `le_upload` VALUES (38, 62943, 1532675125, 1, '微信图片_20180727150208.jpg', '/uploads/images/20180727/81324cb9e27cb8c702463a897014ba20.jpg', '3668aeb9e0094ae320ca9ea214119303', 'eff1586500ccc8f85d0534779b7a7151c749116a', 'file', 1);
INSERT INTO `le_upload` VALUES (39, 69115, 1532675215, 1, 'c04aba50dfb275384bafef5075e293dd.jpg', '/uploads/images/20180727/44dfe4a0453c8ae24d0bb7695c6ca564.jpg', 'f2bd4594cd7f6a1bb17673b51699206a', '84471c58053ee0a9558a08c2a450ac451f6f3119', 'file', 1);
INSERT INTO `le_upload` VALUES (40, 36624, 1532675304, 1, '86e58e87f865e64d7f6711c995597925.jpg', '/uploads/images/20180727/45b487fef96da825c5579d3c8e78e41b.jpg', '0350674a7f5f14958faf3008ba3c89ce', '1b354c405d755801a0023f1131a1be7a29e96501', 'file', 1);
INSERT INTO `le_upload` VALUES (41, 387730, 1532676718, 1, 'QQ截图20180727153147.png', '/uploads/images/20180727/33ecc1c4528d889ac6b23bc0f14fa0af.png', 'bceed6892b42d9cc519991eaea6f74d0', '9c9d5dde9feb78b520f564c0e9c25002c92259bd', 'file', 1);
INSERT INTO `le_upload` VALUES (42, 15044, 1532677072, 1, 'lemon_banner.png', '/uploads/images/20180727/e915cf12ca9a872c890753de502d1db8.png', '341c467c61d0631e3419202e59addd2e', 'ec2a420cb931bf97cdaac0ad164e9a3fdbb908ee', 'file', 1);
INSERT INTO `le_upload` VALUES (43, 9358, 1532679645, 1, 'logo_img_sc.png', '/uploads/images/20180727/28f12650f92c77aed3d760d9b2c34d46.png', '19b6505726d9ca22edb43fa70f30ba7a', 'dac21a440e6953f5ed2d803181a1458d839e637e', 'file', 1);
INSERT INTO `le_upload` VALUES (44, 14571, 1532680532, 1, 'logo-top.png', '/uploads/images/20180727/60f5fe24196764d644a6d6a5f7f25358.png', '7738f10a2b39be3f626baa86ea58b7bc', 'e30df27131070dfc7bf805dcfd3e03a1256f21c8', 'file', 1);
INSERT INTO `le_upload` VALUES (45, 29914, 1532685675, 1, 'timg.jpg', '/uploads/images/20180727/716321e748dda3d5fbec611fd009d16e.jpg', '3198aa0dfacb718551fe48e4067379c1', 'a1fbbda23abf24d36023860c4cc06231bce6e757', 'file', 1);
INSERT INTO `le_upload` VALUES (46, 152206, 1532685738, 1, 'QQ截图20180727180204.png', '/uploads/images/20180727/1210ac207eaf2795e22646970799f345.png', 'e29b0f3bf66f04bd341657b119e52ad3', 'da686251029b2762548f171afd8b7769db48308e', 'file', 1);
INSERT INTO `le_upload` VALUES (47, 51193, 1532686234, 1, 'QQ截图20180727180954.png', '/uploads/umeditor/20180727/0b4beffe8293ab7bd06d4d2fe5e9a6ce.png', '66664a679841ea1a0184bf9df13f7df5', 'c35010b8a7ad4bf83a72b4257aa3c99bb3988aac', 'file', 1);
INSERT INTO `le_upload` VALUES (48, 28095, 1532686519, 1, 'QQ截图20180727181501.png', '/uploads/umeditor/20180727/556fe0eca45f1a0613fb78577d8108fe.png', '321ac5790d1399135c09a211f0f78267', '7802cfb733870d5256364a32a16abf3542d1d0d5', 'file', 1);
INSERT INTO `le_upload` VALUES (49, 127174, 1532686740, 1, 'QQ截图20180727181850.png', '/uploads/umeditor/20180727/c67bef78bb1bbdcc5051ce0af49e3d0d.png', 'fd38307d7dc063964ed7f633fac117b5', '4c5e3c6c4caef4deebf72f57a6256d10d03fa818', 'file', 1);

-- ----------------------------
-- Table structure for le_video
-- ----------------------------
DROP TABLE IF EXISTS `le_video`;
CREATE TABLE `le_video`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL DEFAULT 0 COMMENT '栏目id',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `image_url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '封面图',
  `video_url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '视频路径',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '内容  为空的话则直接显示视频播放器',
  `keywords` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `hits` int(11) NOT NULL DEFAULT 0 COMMENT '点击量',
  `is_recommend` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0不推荐',
  `is_top` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否置顶  0不置顶',
  `is_show` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0不显示',
  `comment_num` int(11) NOT NULL DEFAULT 0 COMMENT '评论数',
  `url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `delete_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
