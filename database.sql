/*
Navicat MySQL Data Transfer

Source Server         : server ovh
Source Server Version : 50568
Source Host           : 141.95.160.199:3306
Source Database       : codetech_discoteca

Target Server Type    : MYSQL
Target Server Version : 50568
File Encoding         : 65001

Date: 2023-04-03 15:44:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for events
-- ----------------------------
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `musical_style` varchar(255) DEFAULT NULL,
  `banner_img` varchar(255) DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_event` datetime DEFAULT NULL,
  `hour_event_a` varchar(255) DEFAULT NULL,
  `hour_event_b` varchar(255) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `date_reg` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of events
-- ----------------------------

-- ----------------------------
-- Table structure for events_tickets
-- ----------------------------
DROP TABLE IF EXISTS `events_tickets`;
CREATE TABLE `events_tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `tickets` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_reg` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of events_tickets
-- ----------------------------

-- ----------------------------
-- Table structure for ranks
-- ----------------------------
DROP TABLE IF EXISTS `ranks`;
CREATE TABLE `ranks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `event_view` enum('1','0') DEFAULT '0',
  `event_edit` enum('1','0') DEFAULT '0',
  `event_delete` enum('1','0') DEFAULT '0',
  `event_create` enum('1','0') DEFAULT '0',
  `guest_view` enum('1','0') DEFAULT '0',
  `guest_edit` enum('1','0') DEFAULT '0',
  `guest_delete` enum('1','0') DEFAULT '0',
  `guest_create` enum('1','0') DEFAULT '0',
  `ticket_view` enum('0','1') DEFAULT '0',
  `ticket_edit` enum('1','0') DEFAULT '0',
  `ticket_delete` enum('1','0') DEFAULT '0',
  `ticket_create` enum('1','0') DEFAULT '0',
  `check_ticket` enum('1','0') DEFAULT '0',
  `users_view` enum('1','0') DEFAULT '0',
  `users_edit` enum('1','0') DEFAULT '0',
  `users_delete` enum('1','0') DEFAULT '0',
  `users_create` enum('1','0') DEFAULT '0',
  `ranks_view` enum('0','1') DEFAULT '0',
  `ranks_edit` enum('0','1') DEFAULT '0',
  `ranks_delete` enum('1','0') DEFAULT '0',
  `ranks_create` enum('1','0') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of ranks
-- ----------------------------
INSERT INTO `ranks` VALUES ('1', 'Administrator', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for tickets
-- ----------------------------
DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `dni` varchar(255) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `event_ticket_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `auth_id` int(11) DEFAULT NULL,
  `checkin` enum('yes','no') DEFAULT 'no',
  `checkin_date` datetime DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_reg` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tickets
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `rank` varchar(255) DEFAULT '1',
  `language` varchar(255) DEFAULT 'es',
  `last_reg` datetime DEFAULT NULL,
  `date_reg` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '$2y$10$MNgJsSRfRSVErDkB1zTMo.bN6XRphv8G3lzycn0t1gRyx60sBhV3K', 'ZeroCrazy', '1', 'es', '2023-04-03 15:12:38', '2023-04-03 15:01:59');
