/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 80029
 Source Host           : localhost:3306
 Source Schema         : admin_demo

 Target Server Type    : MySQL
 Target Server Version : 80029
 File Encoding         : 65001

 Date: 24/10/2023 12:32:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `enabled` tinyint(1) NOT NULL DEFAULT 2,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `role` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '',
  `group_id` int NOT NULL DEFAULT 0,
  `created` int NOT NULL DEFAULT 0,
  `updated` int NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 1, 'admin', 'admin', '', '', '$2y$10$LBgeKAZ0.Y/FUPTaRaOGS.of12rJyFrF5MI7.PDfcF8ZcFtPWSz8C', '', '', 0, 0, 1698121919);
INSERT INTO `admin` VALUES (2, 1, '33', '33', '', '', '$2y$10$4N0HVMeEXmw0/VezHd4S8eeGHm8J46SA3V/9czp4JzcWhghSMZAUe', '333', '', 0, 1698118763, 1698121516);

-- ----------------------------
-- Table structure for admin_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `identity` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `describe` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created` int NOT NULL DEFAULT 0,
  `updated` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `identity`(`identity`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role
-- ----------------------------
INSERT INTO `admin_role` VALUES (11, '管理员', 'admin', '管理员', 0, 0);
INSERT INTO `admin_role` VALUES (12, '编辑', 'editor', '编辑', 0, 0);
INSERT INTO `admin_role` VALUES (13, '运营', 'operator', '运营', 0, 0);
INSERT INTO `admin_role` VALUES (14, '投放', 'ad', '广告投放', 0, 0);

-- ----------------------------
-- Table structure for admin_role_relation
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_relation`;
CREATE TABLE `admin_role_relation`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` bigint NOT NULL DEFAULT 0,
  `role_id` bigint NOT NULL DEFAULT 0,
  `created` int NOT NULL DEFAULT 0,
  `updated` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_relation
-- ----------------------------
INSERT INTO `admin_role_relation` VALUES (1, 2, 12, 1698121516, 1698121516);
INSERT INTO `admin_role_relation` VALUES (2, 2, 11, 1698121516, 1698121516);
INSERT INTO `admin_role_relation` VALUES (3, 2, 13, 1698121516, 1698121516);
INSERT INTO `admin_role_relation` VALUES (4, 2, 14, 1698121516, 1698121516);
INSERT INTO `admin_role_relation` VALUES (5, 1, 11, 1698121919, 1698121919);

-- ----------------------------
-- Table structure for admin_routes
-- ----------------------------
DROP TABLE IF EXISTS `admin_routes`;
CREATE TABLE `admin_routes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint NOT NULL DEFAULT 0 COMMENT '是否父级页面',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '路径',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '组件名称',
  `component` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '页面组件路径',
  `redirect` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转路径',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单图标',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否启用',
  `permission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sort` int NOT NULL DEFAULT 0 COMMENT '排序 按升序排',
  `keep_alive` tinyint NOT NULL DEFAULT 0 COMMENT '是否开启缓存',
  `carry_param` tinyint NOT NULL DEFAULT 0 COMMENT '如果该路由会携带参数，且需要在tab页上面显示。则需要设置为 1',
  `show_breadcrumb` tinyint NOT NULL DEFAULT 1 COMMENT '该路由在面包屑上面的显示',
  `show_children_in_menu` tinyint(1) NULL DEFAULT 1 COMMENT '所有子菜单',
  `current_active_menu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '',
  `show_tab` tinyint NOT NULL DEFAULT 1 COMMENT '当前路由在标签页显示',
  `show_menu` tinyint NOT NULL DEFAULT 1 COMMENT '当前路由在菜单显示',
  `updated` int NOT NULL DEFAULT 0,
  `created` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `path`(`path`) USING BTREE COMMENT '路径、名称',
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_routes
-- ----------------------------
INSERT INTO `admin_routes` VALUES (100, 0, '/system', 'System', 'LAYOUT', '/system/config', 'ant-design:setting-filled', '系统管理', 0, 'admin', 100, 0, 1, 1, 1, '', 1, 1, 1655002893, 1654695229);
INSERT INTO `admin_routes` VALUES (201, 100, '/app/system/routes/index', 'AppSystemRoutesIndex', '/app/system/routes/index', '', 'ant-design:bars-outlined', '路由管理', 1, 'admin', 0, 0, 1, 1, 1, '', 1, 1, 1664329119, 1654695229);
INSERT INTO `admin_routes` VALUES (203, 100, '/app/system/role/index', 'AppSystemRoleIndex', '/app/system/role/index', '', 'ant-design:appstore-twotone', '角色列表', 1, '', 0, 1, 1, 1, 1, '', 1, 1, 1698113226, 1660374666);
INSERT INTO `admin_routes` VALUES (204, 100, '/app/system/admin/index', 'AppSystemAdminIndex', '/app/system/admin/index', '', 'ant-design:heat-map-outlined', '管理员', 1, 'admin', 1, 0, 1, 1, 1, '', 1, 1, 1664329134, 1664248453);

SET FOREIGN_KEY_CHECKS = 1;
