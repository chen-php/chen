/*
 Navicat Premium Data Transfer

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 100137
 Source Host           : localhost:3306
 Source Schema         : achie

 Target Server Type    : MySQL
 Target Server Version : 100137
 File Encoding         : 65001

 Date: 15/03/2020 20:33:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ac_admin
-- ----------------------------
DROP TABLE IF EXISTS `ac_admin`;
CREATE TABLE `ac_admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `pwd` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `create_time` int(10) NULL DEFAULT 0 COMMENT '创建时间',
  `category` tinyint(4) NULL DEFAULT 1 COMMENT '1用户2教师3学校领导4管理员',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_admin
-- ----------------------------
INSERT INTO `ac_admin` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0, 4);

-- ----------------------------
-- Table structure for ac_comment
-- ----------------------------
DROP TABLE IF EXISTS `ac_comment`;
CREATE TABLE `ac_comment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '评教题目',
  `create_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '评价表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_comment
-- ----------------------------
INSERT INTO `ac_comment` VALUES (1, '老师工作认真负责，爱岗敬业，教书育人，尊重学生与严格要求相结合，言传身教，师德高尚。', 1578584470);
INSERT INTO `ac_comment` VALUES (2, '教学水平高，能激发学生积极思维，鼓励学生大胆提问，培养探索精神，能照顾到优中低各个阶段的学生。', 1578659240);
INSERT INTO `ac_comment` VALUES (3, '教学案的编写难度适中，题目数量适中，课堂习题和考试题目代表性强，基础性强。', 1578666290);

-- ----------------------------
-- Table structure for ac_department
-- ----------------------------
DROP TABLE IF EXISTS `ac_department`;
CREATE TABLE `ac_department`  (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '部门名',
  `synopsis` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '简介',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_department
-- ----------------------------
INSERT INTO `ac_department` VALUES (1, '教务处', '教务处负责学生学籍的管理、排课表、教学调度等。。。。。。');
INSERT INTO `ac_department` VALUES (2, '年级组', '年级组是分年级负责本年级班主任和任课教师教学工作的部门。');
INSERT INTO `ac_department` VALUES (3, '总务处', '总务处是负责学校物质保障和服务的部门。');
INSERT INTO `ac_department` VALUES (4, '工信部', '22222222222');

-- ----------------------------
-- Table structure for ac_pscore
-- ----------------------------
DROP TABLE IF EXISTS `ac_pscore`;
CREATE TABLE `ac_pscore`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NULL DEFAULT 0 COMMENT '老师id',
  `sid` int(11) NULL DEFAULT NULL COMMENT '学生id',
  `tscore` decimal(3, 1) NULL DEFAULT NULL COMMENT '分数',
  `create_time` int(11) NULL DEFAULT NULL,
  `uid` int(11) NULL DEFAULT NULL COMMENT '用户id',
  `aid` int(11) NULL DEFAULT NULL,
  `category` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `mid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `schoolyear` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `term` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `t1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '题目一得分',
  `t2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '题目二得分',
  `t3` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '题目三得分',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 57 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '评教分数' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_pscore
-- ----------------------------
INSERT INTO `ac_pscore` VALUES (1, 1, 416240101, 29.0, 1580386271, NULL, NULL, '2', '4', '2016-2017', '2', '10', '10', '9');
INSERT INTO `ac_pscore` VALUES (2, 2, 416240105, 27.0, 1580892798, NULL, NULL, '2', '5', '2016-2017', '1', '10', '10', '7');
INSERT INTO `ac_pscore` VALUES (11, 2, NULL, 18.0, 1581327954, NULL, 1, '3', '5', '2016-2017', '1', '10', '4', '4');
INSERT INTO `ac_pscore` VALUES (12, 3, NULL, 27.0, 1581328128, NULL, 1, '3', '7', '2019-2020', '1', '10', '10', '7');
INSERT INTO `ac_pscore` VALUES (13, 1, NULL, 27.0, 1581331994, NULL, 3, '3', '4', '2016-2017', '2', '10', '10', '7');
INSERT INTO `ac_pscore` VALUES (14, 1, NULL, 15.0, 1581353108, NULL, 4, '3', '4', '2016-2017', '2', '10', '2', '3');
INSERT INTO `ac_pscore` VALUES (19, 4, 416240105, 6.0, 1581410875, NULL, NULL, '2', '12', '2016-2017', '1', '2', '2', '2');
INSERT INTO `ac_pscore` VALUES (21, 2, 416240105, 30.0, 1581411513, NULL, NULL, '2', '10', '2017-2018', '2', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (22, 2, 416240105, 30.0, 1581411619, NULL, NULL, '2', '8', '2018-2019', '1', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (23, 4, 416240105, 30.0, 1581495293, NULL, NULL, '2', '11', '2019-2020', '2', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (24, 2, NULL, 29.0, 1581530264, NULL, 1, '3', '8', '2018-2019', '1', '10', '10', '9');
INSERT INTO `ac_pscore` VALUES (25, 4, NULL, 28.0, 1581530504, NULL, 1, '3', '12', '2016-2017', '1', '10', '9', '9');
INSERT INTO `ac_pscore` VALUES (26, 2, NULL, 30.0, 1581573973, 100, NULL, '1', '5', '2016-2017', '1', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (27, 2, NULL, 21.0, 1581574396, 100, NULL, '1', '10', '2017-2018', '2', '10', '10', '1');
INSERT INTO `ac_pscore` VALUES (28, 1, NULL, 30.0, 1581590021, 100, NULL, '1', '4', '2016-2017', '2', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (29, 4, NULL, 27.0, 1581856655, NULL, 1, '3', '11', '2019-2020', '2', '10', '9', '8');
INSERT INTO `ac_pscore` VALUES (30, 1, NULL, 30.0, 1581856726, 100, NULL, '1', '9', '2017-2018', '1', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (31, 4, NULL, 27.0, 1581916036, NULL, 1, '3', '13', '2016-2017', '1', '10', '9', '8');
INSERT INTO `ac_pscore` VALUES (32, 2, 416240102, 30.0, 1582449732, NULL, NULL, '2', '5', '2016-2017', '1', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (36, 4, 416240102, 15.0, 1584093316, NULL, NULL, '2', '12', '2016-2017', '1', '5', '5', '5');
INSERT INTO `ac_pscore` VALUES (37, 4, 416240102, 30.0, 1584093602, NULL, NULL, '2', '13', '2016-2017', '1', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (38, 1, 416240102, 30.0, 1584093672, NULL, NULL, '2', '9', '2017-2018', '1', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (39, 2, 416240102, 21.0, 1584093684, NULL, NULL, '2', '8', '2018-2019', '1', '7', '7', '7');
INSERT INTO `ac_pscore` VALUES (41, 3, NULL, 15.0, 1584163778, NULL, 1, '3', '15', '2016-2017', '1', '5', '5', '5');
INSERT INTO `ac_pscore` VALUES (42, 4, 416240102, 24.0, 1584164360, NULL, NULL, '2', '11', '2019-2020', '2', '8', '8', '8');
INSERT INTO `ac_pscore` VALUES (43, 5, 416240102, 30.0, 1584164496, NULL, NULL, '2', '7', '2019-2020', '1', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (45, 5, NULL, 3.0, 1584164925, NULL, 1, '3', '16', '2016-2017', '1', '1', '1', '1');
INSERT INTO `ac_pscore` VALUES (47, 5, NULL, 24.0, 1584164986, NULL, 1, '3', '7', '2019-2020', '1', '8', '8', '8');
INSERT INTO `ac_pscore` VALUES (48, 4, NULL, 6.0, 1584171838, 100, NULL, '1', '12', '2016-2017', '1', '2', '2', '2');
INSERT INTO `ac_pscore` VALUES (49, 5, 416240102, 30.0, 1584185034, NULL, NULL, '2', '4', '2016-2017', '2', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (53, 4, 416240102, 30.0, 1584273329, NULL, NULL, '2', '14', '2016-2017', '1', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (54, 2, 416240102, 30.0, 1584274088, NULL, NULL, '2', '10', '2017-2018', '2', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (55, 4, NULL, 30.0, 1584274341, NULL, 1, '3', '14', '2016-2017', '1', '10', '10', '10');
INSERT INTO `ac_pscore` VALUES (56, 4, NULL, 30.0, 1584274452, 100, NULL, '1', '14', '2016-2017', '1', '10', '10', '10');

-- ----------------------------
-- Table structure for ac_score
-- ----------------------------
DROP TABLE IF EXISTS `ac_score`;
CREATE TABLE `ac_score`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NULL DEFAULT 0 COMMENT '科目id',
  `xid` int(11) NULL DEFAULT NULL COMMENT '学生id',
  `score` decimal(3, 1) NULL DEFAULT NULL COMMENT '成绩',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  `tid` int(11) NULL DEFAULT NULL,
  `gpa` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `schoolyear` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `term` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '成绩表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_score
-- ----------------------------
INSERT INTO `ac_score` VALUES (10, 4, 416240101, 80.0, 1584161678, 5, '4', '2016-2017', '2');
INSERT INTO `ac_score` VALUES (11, 4, 416240109, 90.0, 1583997410, 5, '4.5', '2016-2017', '2');
INSERT INTO `ac_score` VALUES (12, 9, 416240101, 80.0, 1584162485, 1, '4', '2017-2018', '1');
INSERT INTO `ac_score` VALUES (13, 8, 416240101, 85.0, 1581251391, 2, '4.25', '2018-2019', '1');
INSERT INTO `ac_score` VALUES (14, 10, 416240105, 60.0, 1584161695, 2, '3', '2017-2018', '2');
INSERT INTO `ac_score` VALUES (15, 4, 416240106, 85.0, 1581311217, 5, '4.25', '2016-2017', '2');
INSERT INTO `ac_score` VALUES (16, 5, 416240106, 65.0, 1581311512, 2, '3.25', '2016-2017', '1');
INSERT INTO `ac_score` VALUES (17, 4, 416240102, 80.0, 1581311873, 5, '4', '2016-2017', '2');
INSERT INTO `ac_score` VALUES (18, 4, 416240108, 9.0, 1581682403, 5, '0.45', '2016-2017', '2');
INSERT INTO `ac_score` VALUES (19, 9, 416240104, 65.0, 1581661167, 1, '3.25', '2017-2018', '1');
INSERT INTO `ac_score` VALUES (22, 9, 416240109, 30.0, 1583997452, 1, '1.5', '2017-2018', '1');
INSERT INTO `ac_score` VALUES (23, 5, 416240101, 80.0, 1581656607, 2, '4', '2016-2017', '1');
INSERT INTO `ac_score` VALUES (24, 13, 416240108, 99.0, 1581657664, 4, '4.95', '2016-2017', '1');
INSERT INTO `ac_score` VALUES (25, 9, 416240107, 87.0, 1581657808, 1, '4.35', '2017-2018', '1');
INSERT INTO `ac_score` VALUES (26, 14, 416240101, 90.0, 1581660769, 4, '4.5', '2016-2017', '1');
INSERT INTO `ac_score` VALUES (27, 4, 416240107, 99.9, 1581661140, 5, '5', '2016-2017', '2');
INSERT INTO `ac_score` VALUES (28, 14, 416240104, 80.0, 1581682165, 4, '4', '2016-2017', '1');
INSERT INTO `ac_score` VALUES (29, 8, 416240106, 95.0, 1582523427, 2, '4.75', '2018-2019', '1');
INSERT INTO `ac_score` VALUES (30, 9, 416240102, 88.0, 1582525871, 1, '4.4', '2017-2018', '1');
INSERT INTO `ac_score` VALUES (31, 4, 416240109, 50.0, 1583926791, 5, '2.5', '2016-2017', '2');
INSERT INTO `ac_score` VALUES (34, 8, 416240110, 95.0, 1584275115, 2, '4.75', '2018-2019', '1');

-- ----------------------------
-- Table structure for ac_subject
-- ----------------------------
DROP TABLE IF EXISTS `ac_subject`;
CREATE TABLE `ac_subject`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '科目名',
  `tid` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '教师id',
  `create_time` int(10) NULL DEFAULT 0 COMMENT '创建时间',
  `term` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `schoolyear` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '科目表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_subject
-- ----------------------------
INSERT INTO `ac_subject` VALUES (4, '微积分', 5, 1584010578, '2', '2016-2017');
INSERT INTO `ac_subject` VALUES (5, 'C#', 2, 1580889496, '1', '2016-2017');
INSERT INTO `ac_subject` VALUES (7, 'C++', 5, 1583997491, '1', '2019-2020');
INSERT INTO `ac_subject` VALUES (8, 'java', 2, 1580910652, '1', '2018-2019');
INSERT INTO `ac_subject` VALUES (9, 'html5', 1, 1580989674, '1', '2017-2018');
INSERT INTO `ac_subject` VALUES (10, 'php', 2, 1580989712, '2', '2017-2018');
INSERT INTO `ac_subject` VALUES (11, 'egg', 4, 1581315356, '2', '2019-2020');
INSERT INTO `ac_subject` VALUES (12, '离散数学', 4, 1581407387, '1', '2016-2017');
INSERT INTO `ac_subject` VALUES (13, '计算机英语', 4, 1581407511, '1', '2016-2017');
INSERT INTO `ac_subject` VALUES (14, 'ps', 4, 1581657175, '1', '2016-2017');
INSERT INTO `ac_subject` VALUES (15, '语文', 3, 1582523945, '1', '2016-2017');
INSERT INTO `ac_subject` VALUES (16, 'bookstrap', 5, 1583990741, '1', '2016-2017');

-- ----------------------------
-- Table structure for ac_user
-- ----------------------------
DROP TABLE IF EXISTS `ac_user`;
CREATE TABLE `ac_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '用户名',
  `passwd` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '密码',
  `tel` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '电话号码',
  `sid` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '学号',
  `create_time` int(10) NULL DEFAULT 0 COMMENT '创建时间',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '家庭地址',
  `sex` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '男' COMMENT '性别',
  `category` tinyint(4) NULL DEFAULT 1 COMMENT '1用户2学生3教师',
  `birthday` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '出生日期',
  `hobby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '兴趣爱好',
  `profile` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '个人简介',
  `profession` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '专业',
  `department` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '部门',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ac_user
-- ----------------------------
INSERT INTO `ac_user` VALUES (1, '成大宝', 'dc5c7986daef50c1e02ab09b442ee34f', '101110115', '001', 1584094330, '广东省广州市白云', '男', 3, '1989-12-13', '游泳', '本人开朗乐观，积极向上，哈哈哈哈哈哈哈哈哈哈哈哈哈！！！！！！！！！！', '', NULL);
INSERT INTO `ac_user` VALUES (2, '蔡小影', '984de5f6b4edbbb1b63205ec8bd7d5f3', '10101010101', '416240101', 1581313490, '广东省佛山市使得', '男', 2, NULL, NULL, NULL, '计算机科学与技术', NULL);
INSERT INTO `ac_user` VALUES (3, '陈小俊', '537a1abba1fe545e045f2355ae109b38', '1110101114', '416240102', 1584078642, '广东省汕头市', '男', 2, '1997-12-09', '洗澡', '', '计算机科学与技术', NULL);
INSERT INTO `ac_user` VALUES (4, '赵小红', 'ae6778916b5c11dbd05b19d2b49e36a0', '10111105', '416240103', 1580386148, '广东省广州市增城区', '女', 2, NULL, NULL, NULL, '计算机科学与技术', NULL);
INSERT INTO `ac_user` VALUES (5, '蔡大霞', 'e10adc3949ba59abbe56e057f20f883e', '1110101115', '002', 1580395654, '广东省广州市增城区', '女', 3, NULL, NULL, NULL, '', NULL);
INSERT INTO `ac_user` VALUES (6, '黄小明', 'c4e16c1f0c78941d3a76942afed95dae', '10101010108', '416240104', 1580452053, '广东省汕头市', '男', 2, NULL, NULL, NULL, '计算机科学与技术', NULL);
INSERT INTO `ac_user` VALUES (7, '蔡小红', 'd43b19647d402ff9e1d0f9325b7f63aa', '10101111101', '416240105', 1581672156, '广东省汕头市', '女', 2, '1997-11-11', '画画', '乐观开朗', '计算机科学与技术', NULL);
INSERT INTO `ac_user` VALUES (10, '吕小布', 'b048b8a5e8a50489fc02b10ae27b9373', '10101010102', '416240106', 1584076699, '广东省汕头市', '男', 2, NULL, NULL, NULL, '会计', NULL);
INSERT INTO `ac_user` VALUES (11, '陈大美', 'e88a49bccde359f0cabb40db83ba6080', '10101010101', '003', 1581315140, '广东省', '女', 3, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ac_user` VALUES (12, '李大华', '11364907cf269dd2183b64287156072a', '1110101117', '004', 1581314653, '广东省汕头市444', '男', 3, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ac_user` VALUES (13, '黄晓敏', '0e4b668705f0eb9dd77496562376857d', '1111000101', '416240107', 1584076709, '广东省汕头市', '女', 2, NULL, NULL, NULL, '商务英语', NULL);
INSERT INTO `ac_user` VALUES (14, '赵小黑', '0e4b668705f0eb9dd77496562376857d', '10101010109', '416240108', 1584076723, '4444445', '男', 2, NULL, NULL, NULL, '考古', NULL);
INSERT INTO `ac_user` VALUES (15, '隔壁老樊', 'f899139df5e1059396431415e770c6dd', '10158642792', '100', 1584171016, '广东省广州市', '男', 1, '1987-11-03', '打羽毛球', '哈哈哈哈哈哈哈哈哈哈！', NULL, NULL);
INSERT INTO `ac_user` VALUES (18, 'xiao', '3644a684f98ea8fe223c713b77189a77', '1111000101', '1111000101', 1584010465, '33333333', '男', 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ac_user` VALUES (19, '白大白', 'ce08becc73195df12d99d761bfbba68d', '', '005', 1583907401, '22222', '男', 3, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ac_user` VALUES (20, '黑小黑', '04c28b942231732228b2bae935973c48', '', '416240109', 1583908263, '22222', '男', 2, NULL, NULL, NULL, '计算机科学与技术', NULL);

-- ----------------------------
-- Triggers structure for table ac_subject
-- ----------------------------
DROP TRIGGER IF EXISTS `tr_teacher`;
delimiter ;;
CREATE TRIGGER `tr_teacher` BEFORE UPDATE ON `ac_subject` FOR EACH ROW BEGIN
UPDATE ac_score set tid=new.tid
WHERE sid=new.id;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
