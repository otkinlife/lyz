/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : restaurant_ms

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2016-01-24 19:18:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dishes`
-- ----------------------------
DROP TABLE IF EXISTS `dishes`;
CREATE TABLE `dishes` (
  `dish_id` int(11) NOT NULL AUTO_INCREMENT,
  `dish_name` varchar(255) NOT NULL,
  `dish_price` float NOT NULL,
  `dish_remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`dish_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dishes
-- ----------------------------
INSERT INTO `dishes` VALUES ('1', '红烧排骨', '50', null);
INSERT INTO `dishes` VALUES ('2', '糖醋鱼', '80', null);
INSERT INTO `dishes` VALUES ('3', '辣子鸡丁', '48', null);
INSERT INTO `dishes` VALUES ('4', '金玉满堂', '30', null);
INSERT INTO `dishes` VALUES ('5', '爆炒腰花', '58', null);
INSERT INTO `dishes` VALUES ('6', '风味茄子', '32', null);

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_waiter` varchar(255) NOT NULL,
  `sumPrice` float NOT NULL,
  `order_remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('1', '2', '3', '2016-01-12 23:11:27', '小李', '200', null);
INSERT INTO `order` VALUES ('2', '4', '3', '2016-01-11 23:12:29', '小张', '210', null);

-- ----------------------------
-- Table structure for `table`
-- ----------------------------
DROP TABLE IF EXISTS `table`;
CREATE TABLE `table` (
  `table_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_number` int(11) NOT NULL,
  `table_useable` int(11) NOT NULL DEFAULT '1',
  `table_remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`table_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of table
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `user_password` char(255) DEFAULT '',
  `manager` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('001', 'admin', '1');
INSERT INTO `user` VALUES ('002', '001', '0');
