
CREATE DATABASE  `KS`
CHARACTER SET 'utf8'
COLLATE 'utf8_general_ci';
USE `KS`;
-- ----------------
DROP TABLE IF EXISTS `TBUser`;
CREATE TABLE `TBUser`(
`ID` INT(11) NOT NULL AUTO_INCREMENT,
`Name` VARCHAR(255) NOT NULL COMMENT '用户名称',
`Password` VARCHAR(255) NOT NULL COMMENT '密码',
`Role` VARCHAR(255) NOT NULL COMMENT '扮演的角色', -- --诸如：教师/学生/管理员
`Online` VARCHAR(10) NOT NULL COMMENT '是否在线（yes/no）', -- --online表示在线，限制重复登录。当online=yes ,表示已有人登录该账号，不能再登。
`BlackList` VARCHAR(10) NOT NULL COMMENT '是否在黑名单（yes/no）',-- --在黑名单会有功能限制
`Score` INT(11) NOT NULL COMMENT '个人评分', -- --用来做是否加入黑名单依据  score<0进黑名单（-100-100）
PRIMARY KEY (`ID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- ----------------------------------------------------------------------------------------------------用户



-- ---------------------------------楼层模块
-- --去除占座监督时间，这个实现不了，也看不懂什么意思
-- --去除黑名单禁用时间，莫名其妙
-- --去除节假日开放时间，过于复杂
DROP TABLE IF EXISTS `TBFloor`; 
CREATE TABLE `TBFloor`(         
`ID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '楼层id,唯一且自增，不用管',
`Name` VARCHAR(255) NOT NULL COMMENT '楼层名称',
`OpenDay` VARCHAR(255) NOT NULL COMMENT '开放时间表',-- --诸如："早上7点到晚上9点"
`OrderDay` INT(11) NOT NULL COMMENT '提前预约天数',
`OrderTime` TIME NOT NULL COMMENT '预约开放时间',
`OrderEndTime` TIME NOT NULL COMMENT '预约结束时间',
`LeaveLength` INT(11) NOT NULL COMMENT '暂离时长min',
PRIMARY KEY (`ID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --教室的优先级大于楼层
DROP TABLE IF EXISTS `TBRoom`; -- ---教室模块
CREATE TABLE `TBRoom`(         
`ID` INT(11) NOT NULL AUTO_INCREMENT COMMENT '教室id,唯一且自增，不用管',
`Name` VARCHAR(255) NOT NULL COMMENT '教室名称',
`FloorID` INT(11) NOT NULL COMMENT '所属楼层id',
`OpenDay` VARCHAR(255) NOT NULL COMMENT '开放时间表',-- --诸如："早上7点到晚上9点"
`OrderDay` INT(11) NOT NULL COMMENT '提前预约天数',
`OrderTime` TIME NOT NULL COMMENT '预约开放时间',
`OrderEndTime` TIME NOT NULL COMMENT '预约结束时间',
`LeaveLength` INT(11) NOT NULL COMMENT '暂离时长min',
`Flag` VARCHAR(10) NOT NULL COMMENT '教室规则是否使用(yes/no)', -- --用于执行教室还是楼层规则 的 判断
PRIMARY KEY (`ID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TBDesk`; -- --座位
CREATE TABLE `TBDesk`(
`ID` INT(11) NOT NULL AUTO_INCREMENT,
`RoomID` INT(11) NOT NULL COMMENT'所属教室id',
`State` varchar(11) NOT NULL COMMENT'桌子状态',-- --（using/leaving/emptying/ordering）
`UserID` INT(11) NOT NULL COMMENT '使用者id', 
PRIMARY KEY (`ID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TBAgainstHistory`; -- --违规记录
CREATE TABLE `TBAgainstHistory`(
`ID` INT(11) NOT NULL AUTO_INCREMENT,
`UserID` INT(11) NOT NULL COMMENT '违反者id',
`Time` DATETIME NOT NULL COMMENT '违反时间',
`Detail` varchar(255)  NOT NULL COMMENT '违反细节', -- --诸如："在学习时晒臭脚" "暂离后未在时间内回归"
`DeskID` INT(11) NOT NULL COMMENT '违反者使用桌子id',
`Score` INT(11) NOT NULL COMMENT '扣分',
PRIMARY KEY (`ID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TBOrderHistory`; -- --预约记录历史记录（失效的记录）
CREATE TABLE `TBOrderHistory`(
`ID` INT(11) NOT NULL AUTO_INCREMENT,
`UserID` INT(11) NOT NULL COMMENT '预约者id',
`Time` DATETIME NOT NULL COMMENT '预约时间',
`DeskID` INT(11) NOT NULL COMMENT '预约桌子id',
PRIMARY KEY (`ID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TBOrder`; -- --预约记录（有效的记录）
CREATE TABLE `TBOrderHistory`(
`ID` INT(11) NOT NULL AUTO_INCREMENT,
`UserID` INT(11) NOT NULL COMMENT '预约者id',
`Time` DATETIME NOT NULL COMMENT '预约时间',
`DeskID` INT(11) NOT NULL COMMENT '预约桌子id',
PRIMARY KEY (`ID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;




