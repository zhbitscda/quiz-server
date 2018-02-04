/*
 Navicat Premium Data Transfer

 Source Server         : sinihi
 Source Server Type    : MySQL
 Source Server Version : 50549
 Source Host           : 120.76.155.35
 Source Database       : sinihi

 Target Server Type    : MySQL
 Target Server Version : 50549
 File Encoding         : utf-8

 Date: 05/30/2016 12:28:16 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `carcards`
-- ----------------------------
DROP TABLE IF EXISTS `carcards`;
CREATE TABLE `carcards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cardNo` varchar(45) NOT NULL,
  `carNo` varchar(45) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `startValidDate` datetime DEFAULT NULL COMMENT '有效期开始时间',
  `endValidDate` datetime DEFAULT NULL COMMENT '有效期结束时间，（月卡，贵宾卡有用）',
  `type` int(11) DEFAULT NULL COMMENT '卡状态：0-正常使用 1 -挂失OK 2-挂失状态 3-解挂状态  4-退卡状态 5-待挂失解挂',
  `balance` decimal(10,0) DEFAULT NULL COMMENT '储值余额，对应储值卡',
  `cardRights` char(128) DEFAULT NULL,
  `remark` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `operators`
-- ----------------------------
DROP TABLE IF EXISTS `operators`;
CREATE TABLE `operators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `roleId` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `operators`
-- ----------------------------
BEGIN;
INSERT INTO `operators` VALUES ('1', 'shanks', '123', '5', '2016-05-26 23:16:54', '2016-05-29 08:58:18'), ('3', 'YC', '123', '4', '2016-05-28 11:00:54', '2016-05-28 11:00:54'), ('4', 'cmb123', '123', '4', '2016-05-28 11:26:43', '2016-05-28 11:26:43'), ('7', 'fff', '321', '8', '2016-05-29 09:03:07', '2016-05-29 09:03:07');
COMMIT;

-- ----------------------------
--  Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `parentId` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Records of `permissions`
-- ----------------------------
BEGIN;
INSERT INTO `permissions` VALUES ('1', '查询页面', null, '0'), ('2', '查询操作', null, '1');
COMMIT;

-- ----------------------------
--  Table structure for `rolepermissions`
-- ----------------------------
DROP TABLE IF EXISTS `rolepermissions`;
CREATE TABLE `rolepermissions` (
  `roleId` int(11) NOT NULL,
  `permissionId` int(11) NOT NULL,
  PRIMARY KEY (`roleId`,`permissionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `rolepermissions`
-- ----------------------------
BEGIN;
INSERT INTO `rolepermissions` VALUES ('4', '1'), ('4', '2'), ('5', '1'), ('5', '2'), ('8', '1');
COMMIT;

-- ----------------------------
--  Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Records of `roles`
-- ----------------------------
BEGIN;
INSERT INTO `roles` VALUES ('4', '一般管理员', '很一般管理员', '2016-05-26 23:11:38', '2016-05-26 23:11:38'), ('5', '超级管理员', '很不一般的管理员', '2016-05-26 23:12:44', '2016-05-26 23:12:44'), ('8', '无敌管理员', '我是无敌的1', '2016-05-28 12:11:12', '2016-05-28 12:12:24');
COMMIT;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id`         int(11)       NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name`       varchar(30)   NOT NULL COMMENT '用户名称',
  `telephone`  varchar(60)   NOT NULL COMMENT '手机号',
  `homephone`  varchar(60)   NULL COMMENT '家庭号码',
  `idCard`     varchar(80)   NULL COMMENT '身份证号',
  `birthday`   int(11)       NULL COMMENT '生日日期',
  `address`    varchar(2048) NULL COMMENT '家庭地址',
  `photoUrl`   varchar(2048) NULL COMMENT '照片Url',
  `isUsed`     int(1)        NOT NULL COMMENT '是否使用,0为不使用,1为使用',
  `created_at` timestamp     NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp     NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `telephone` (`telephone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户';

-- ----------------------------
--  Table structure for `cards`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `cards` (
  `id`            varchar(128)  NOT NULL COMMENT '序列号(物理号)',
  `userId`        int(11)       NOT NULL COMMENT '用户ID,外键',
  `property`      int(1)        NOT NULL COMMENT '类型,0-ID,1-IC,2-纯车牌',
  `deposit`       decimal(9,2)  NOT NULL COMMENT '押金',
  `isUsedPark`    int(1)        NOT NULL COMMENT '车场是否使用,0-未开通,1-开通', 
  `isUsedDoor`    int(1)        NOT NULL COMMENT '门禁是否使用,0-未开通,1-开通',
  `isUsedCharge`  int(1)        NOT NULL COMMENT '收费是否使用,0-未开通,1-开通',
  `status`        int(1)        NOT NULL COMMENT '状态,0-正常,1-挂失,2-停用',
  `created_at`    timestamp     NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at`    timestamp     NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `property` (`property`),
  FOREIGN KEY (`userId`) REFERENCES `users` (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='卡';

-- ----------------------------
--  Table structure for `doorCards`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `doorCards` (
  `cardId`       varchar(128)  NOT NULL COMMENT '外键,cardId',
  `name`         varchar(1024) NOT NULL COMMENT '名称',
  `remark`       text          NULL     COMMENT '标注',
  `created_at`   timestamp     NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at`   timestamp     NULL DEFAULT NULL COMMENT '更新时间',
  FOREIGN KEY (`cardId`) REFERENCES `cards` (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='门禁卡信息';

-- ----------------------------
--  Table structure for `carPhotos`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `carPhotos` (
  `id`       int(11)       NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name`     varchar(10)   NOT NULL UNIQUE COMMENT '名称',
  `url`      varchar(2048) NOT NULL COMMENT '图片Url',
  `created_at`  timestamp     NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at`  timestamp     NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='车归属地';

-- ----------------------------
--  Table structure for `carLocations`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `carLocations` (
  `id`       int(11)       NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name`     varchar(10)   NOT NULL UNIQUE COMMENT '名称',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='车归属地';

-- ----------------------------
--  Table structure for `carTypes`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `carTypes` (
  `id`       int(11)       NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name`     varchar(10)   NOT NULL UNIQUE COMMENT '名称',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='车类型';

-- ----------------------------
--  Table structure for `cars`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `cars` (
  `id`            int(11)       NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `userId`        int(11)       NOT NULL COMMENT '用户ID',
  `locationId`    int(11)       NOT NULL COMMENT '归属地Id',
  `number`        varchar(30)   NOT NULL COMMENT '车牌号码',
  `color`         varchar(128)  NOT NULL COMMENT '颜色',
  `typeId`        int(11)       NOT NULL COMMENT '类型Id',
  `photoId`       int(11)       NOT NULL COMMENT '图片Id',
  `parkingPlace`  varchar(2048) NOT NULL COMMENT '车位',
  `created_at`    timestamp     NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at`    timestamp     NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`userId`)     REFERENCES `users` (`id`),
  FOREIGN KEY (`locationId`) REFERENCES `carLocations` (`id`),
  FOREIGN KEY (`photoId`)    REFERENCES `carPhotos` (`id`),
  FOREIGN KEY (`typeId`)     REFERENCES `carTypes` (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='车';

-- ----------------------------
--  Table structure for `parkCards`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `parkCards` (
  `cardId`        varchar(128)  NOT NULL COMMENT '外键,cardId',
  `carId`         int(11)       NOT NULL COMMENT '外键,carId',
  `printNo`       varchar(1024) NULL     COMMENT '印刷号，通常是指印刷在卡上的信息',
  `typeId`        int(1)        NOT NULL COMMENT '停车卡类型Id',
  `times`         int(11)       NOT NULL DEFAULT 0 COMMENT '次卡的次数',
  `balance`       decimal(9,2)  NOT NULL DEFAULT 0 COMMENT '余额',
  `isNote`        int(1)        NOT NULL COMMENT '短信功能,0-关闭,1-开启',
  `remark`        text          NULL     COMMENT '标注',
  `beginTime`     int(11)       NOT NULL COMMENT '开始使用时间段',
  `endTime`       int(11)       NOT NULL COMMENT '结束使用时间段',
  `beginDate`     int(11)       NOT NULL COMMENT '开始使用日期',
  `endDate`       int(11)       NOT NULL COMMENT '结束使用日期',
  `created_at`    timestamp     NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at`    timestamp     NULL DEFAULT NULL COMMENT '更新时间',
  FOREIGN KEY (`cardId`)  REFERENCES `cards` (`id`),
  FOREIGN KEY (`carId`)   REFERENCES `cars` (`id`),
  FOREIGN KEY (`typeId`)  REFERENCES `parkCardTypes` (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='停车卡系统';

-- ----------------------------
--  Table structure for `boxes`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `boxes` (
  `id`       int(11)       NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name`     varchar(100)  NULL COMMENT '名称',
  `location` varchar(1024) NULL COMMENT '方位',
  `compId`   int(11)       NULL COMMENT '托管主机对应的设备Id',
  `status`   int(1)        NOT  NULL COMMENT '状态,0-正常使用,1-停止使用',
  `created_at` timestamp   NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp   NULL DEFAULT NULL COMMENT '更新时间',
   PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='岗亭';

-- ----------------------------
--  Table structure for `boxDoors`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `boxDoors` (
  `id`       int(11)       NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `boxId`    int(11)       NOT NULL COMMENT '外键,boxId',
  `name`     varchar(100)  NULL COMMENT '名称',
  `isCheck`  int(1)        DEFAULT 0 COMMENT '是否为监测口',
  `isTempIn` int(1)        DEFAULT 0 COMMENT '是否为临时入口',
  `isTempOut`int(1)        DEFAULT 0 COMMENT '是否为临时出口',
  `cardRights` varchar(128)NOT  NULL COMMENT '卡权限，对应卡类型，使用JSON储存',
  `function` int(1)        NOT  NULL COMMENT '作用,0-入,1-出',
  `type`     int(1)        NOT  NULL DEFAULT 0 COMMENT '类型,0-通用,1-仅小车,2-仅大车',
  `status`   int(1)        NOT  NULL COMMENT '状态,0-正常使用,1-停止使用',
  `created_at` timestamp   NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp   NULL DEFAULT NULL COMMENT '更新时间',
   PRIMARY KEY (`id`)
   -- FOREIGN KEY (`boxId`)  REFERENCES `boxes` (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='岗亭口';

-- ----------------------------
--  Table structure for `boxDoors_cards`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `boxDoors_cards` (
  `cardId`    varchar(128)  NOT NULL COMMENT '外键,cardId',
  `boxDoorId` int(11)       NOT NULL COMMENT '外键,boxDoorId',
  FOREIGN KEY (`cardId`) REFERENCES `cards` (`id`),
  FOREIGN KEY (`boxDoorId`) REFERENCES `boxDoors` (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='卡的岗亭口权限';

-- ----------------------------
--  Table structure for `parkCardTypes`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `parkCardTypes` (
  `id`       int(11)       NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name`     varchar(100)  NOT NULL UNIQUE COMMENT '名称',
  `type`     int(1)        NOT NULL COMMENT '类型,0-月租卡、1-储值卡、2-临时卡、3-贵宾卡、4-次卡',
  `status`   int(1)        NOT NULL COMMENT '状态,0-正常使用,1-停止使用',
  `created_at`  timestamp     NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at`  timestamp     NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='车卡的类型';

-- ----------------------------
--  Table structure for `devices`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `devices` (
  `id`         int(11)       NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name`       varchar(128)  NULL COMMENT '设备名称',
  `ip`         varchar(60)   NULL COMMENT 'ip地址',
  `mac`        varchar(128)  NULL COMMENT 'mac地址',
  `boxDoorId`  int(11)       NULL COMMENT '岗亭口Id',
  `type`       int(11)       NULL COMMENT '设备类型, 0-托管主机 1-岗亭总线控制器设备 2-道闸驱动控制器设备 3-LED显示屏设备 4-摄像机设备 5-临时卡计费器设备',
  `status`     int(1)        NULL DEFAULT 0    COMMENT '状态,0-正常使用,1-停止使用',
  `created_at` timestamp  NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp  NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='设备';

-- ----------------------------
--  Table structure for `admission`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `admission` (
  `id`           int(11)       NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `cardId`       varchar(128)  NULL COMMENT '卡Id',
  `carNum`       varchar(32)   NULL COMMENT '车牌号码',
  `carColor`     varchar(32)   NULL COMMENT '车颜色',
  `carType`      varchar(64)   NULL COMMENT '车类型',
  `imagePath`    varchar(2048) NULL COMMENT '截图路径',
  `boxDoorId`    int(11)       NULL COMMENT '岗亭口Id',
  `entranceTime` timestamp     NULL DEFAULT NULL COMMENT '入场时间',
  `exitTime`     timestamp     NULL DEFAULT NULL COMMENT '出场时间',
  `free`         decimal(9,2)  NULL DEFAULT NULL COMMENT '免费的金额',
  `charge`       decimal(9,2)  NULL DEFAULT NULL COMMENT '实际产生的费用',
  `status`       int(1)        NULL DEFAULT 0    COMMENT '状态,0-进场中,1-已进场,2-出场中,3-已出场',
  `entranceOperationType` int(1)  NULL DEFAULT 0    COMMENT '入场开闸类型,0-自动开闸,1-人工开闸,2-非法开闸',
  `entranceOperatorId`    int(1)  NULL DEFAULT NULL COMMENT '入场操作员Id，默认为NULL为非人工干预',
  `exitOperationType`     int(1)  NULL DEFAULT 0    COMMENT '出场开闸类型,0-自动开闸,1-人工开闸,2-非法开闸',
  `exitOperatorId`        int(1)  NULL DEFAULT NULL COMMENT '出场操作员Id，默认为NULL为非人工干预',
  `created_at`   timestamp     NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at`   timestamp     NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='进出场表';
