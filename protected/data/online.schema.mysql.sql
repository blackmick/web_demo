# /*-------用户信息表-------*/
# /*---用户表----*/
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(128) NOT NULL,
    `password` VARCHAR(128) NOT NULL,
    `cookie` VARCHAR(256) NOT NULL DEFAULT '',
    `token` VARCHAR(256) NOT NULL DEFAULT '',
    `salt`  VARCHAR(64) NOT NULL DEFAULT '',
    `last_login` INT NOT NULL DEFAULT '',
    `type` INT NOT NULL DEFAULT '0' COMMENT 'user type: 0-normal, 1-enterprise, 2-hunter, 3-admin',
    `reg_from` INT NOT NULL DEFAULT '0' COMMENT 'user registration original, 0-local,1-weixin,2-weibo,3-qq,4-baidu',
    `base_info` INT NOT NULL DEFAULT '0' COMMENT '基本信息 tbl_user_baseinfo表的id',
    
    `profile` VARCHAR(256) NOT NULL DEFAULT '' COMMENT '简历信息 tbl_profile表的id list',
    `create_time` INT NOT NULL DEFAULT '0',
    `update_time` INT NOT NULL DEFAULT '0',
    `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

# /*---基本用户信息表---*/
DROP TABLE IF EXISTS `tbl_user_baseinfo`;
CREATE TABLE IF NOT EXISTS `tbl_user_baseinfo` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `first_name` VARCHAR(32) NOT NULL DEFAULT '',
    `last_name` VARCHAR(32) NOT NULL DEFAULT '',
    `mid_name` VARCHAR(32) NOT NULL DEFAULT '',
    `location` INT NOT NULL DEFAULT '0',
    `industry` INT NOT NULL DEFAULT '0',
    `title` VARCHAR(128) NOT NULL DEFAULT '',
    `head` INT NOT NULL DEFAULT '0' COMMENT 'head icon,0-use random system icons,other value-user defined icon in table tbl_image',
    `phone` VARCHAR(64) NOT NULL DEFAULT '111-1111-1111',
    `address` VARCHAR(256) NOT NULL DEFAULT '',
    `email` VARCHAR(256) NOT NULL DEFAULT '',
    `create_time` INT NOT NULL DEFAULT '0',
    `update_time` INT NOT NULL DEFAULT '0',
    `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

# /*---简历表定义---*/
DROP TABLE IF EXISTS `tbl_profile`;
CREATE TABLE IF NOT EXISTS `tbl_profile` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `language` TINYINT NOT NULL DEFAULT '0',
    `title` VARCHAR(32) NOT NULL DEFAULT 'My Profile' COMMENT '这份简历的标题',
    `edu` VARCHAR(32) NOT NULL DEFAULT '0' COMMENT '教育背景,表tbl_education的id list',
    `exp` VARCHAR(64) NOT NULL COMMENT '工作经验,表tbl_experience的id list',
    `keyword` VARCHAR(256) NOT NULL DEFAULT '' COMMENT '整个简历的关键字',
    `create_time` INT NOT NULL DEFAULT '0',
    `update_time` INT NOT NULL DEFAULT '0',
    `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*---用户教育背景信息---*/
DROP TABLE IF EXISTS `tbl_education`;
CREATE TABLE IF NOT EXISTS `tbl_education` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `profile_id` INT NOT NULL,
    `college` VARCHAR(64) NOT NULL DEFAULT '',
    `major` VARCHAR(128) NOT NULL DEFAULT '',
    `degree` INT NOT NULL DEFAULT '0',
    `start_time` INT NOT NULL DEFAULT '0',
    `end_time` INT NOT NULL DEFAULT '0',
    `reward` VARCHAR(256) NOT NULL DEFAULT '',
    `create_time` INT NOT NULL DEFAULT '0',
    `update_time` INT NOT NULL DEFAULT '0',
    `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

# /*---用户工作经验表---*/
DROP TABLE IF EXISTS `tbl_experience`;
CREATE TABLE IF NOT EXISTS `tbl_experience` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `profile_id` INT NOT NULL,
    `start_time` INT NOT NULL DEFAULT '0',
    `end_time` INT NOT NULL DEFAULT '0',
    `company` VARCHAR(64) NOT NULL DEFAULT '',
    `description` VARCHAR(2048) NOT NULL DEFAULT '',
    `keyword` VARCHAR(128) NOT NULL DEFAULT '',
    `create_time` INT NOT NULL DEFAULT '0',
    `update_time` INT NOT NULL DEFAULT '0', 
    `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

# /*---职位信息表---*/
DROP TABLE IF EXISTS `tbl_job`;
CREATE TABLE IF NOT EXISTS `tbl_job`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` varchar(128) NOT NULL DEFAULT '',
    `company_id` INT NOT NULL DEFAULT '0' COMMENT 'enterprise id',
    `industry` INT NOT NULL DEFAULT '0',
    `publish_time` INT NOT NULL DEFAULT '0',
    `location` INT NOT NULL DEFAULT '0',
    `description` varchar(2048) NOT NULL DEFAULT '',
    `responsibility` VARCHAR(2048) NOT NULL DEFAULT '',
    `keyword` VARCHAR(256) NOT NULL DEFAULT '',
    `create_time` INT NOT NULL DEFAULT '0',
    `update_time` INT NOT NULL DEFAULT '0',
    `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

# ---企业信息表---
DROP TABLE IF EXISTS `tbl_company`;
CREATE TABLE IF NOT EXISTS `tbl_company` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(32) NOT NULL,
#     `password` VARCHAR(64) NOT NULL,
#     `title` VARCHAR(128) NOT NULL,
    `type` INT NOT NULL DEFAULT '3',
    `industry` INT NOT NULL DEFAULT '0',
    `scale` INT NOT NULL DEFAULT '0' COMMENT '0:~100 people;1:100~500 people;2:500~1000 people;3:1000~',
    `summary` VARCHAR(512) NOT NULL DEFAULT '',
    `description` VARCHAR(2048) NOT NULL DEFAULT '',
    `create_time` INT NOT NULL DEFAULT '0',
    `update_time` INT NOT NULL DEFAULT '0',
    `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

# ---附加信息表---
DROP TABLE IF EXISTS `tbl_company_type`;
CREATE TABLE IF NOT EXISTS `tbl_company_type` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(32) NOT NULL DEFAULT '',
    `create_time` INT NOT NULL DEFAULT '0',
    `update_time` INT NOT NULL DEFAULT '0',
    `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `tbl_company_type` (`name`) VALUES ('国企');
INSERT INTO `tbl_company_type` (`name`) VALUES ('央企');
INSERT INTO `tbl_company_type` (`name`) VALUES ('私企');
INSERT INTO `tbl_company_type` (`name`) VALUES ('外企(欧美)');
INSERT INTO `tbl_company_type` (`name`) VALUES ('外企(日韩)');
# ----------------------

DROP TABLE IF EXISTS `tbl_industry`;
CREATE TABLE IF NOT EXISTS `tbl_industry` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(64) NOT NULL DEFAULT ''
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `tbl_industry` (`name`) VALUES ('计算机');
INSERT INTO `tbl_industry` (`name`) VALUES ('通讯');
INSERT INTO `tbl_industry` (`name`) VALUES ('电子');


DROP TABLE IF EXISTS `tbl_location`;
CREATE TABLE IF NOT EXISTS `tbl_location` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(32) NOT NULL DEFAULT ''
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `tbl_location` (`name`) VALUES ('北京');
INSERT INTO `tbl_location` (`name`) VALUES ('上海');
INSERT INTO `tbl_location` (`name`) VALUES ('深圳');

# ---用户浏览过的职位信息----
DROP TABLE IF EXISTS `tbl_user_browser`;
CREATE TABLE IF NOT EXISTS `tbl_user_browser` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `uid` INT NOT NULL,
    `jobs` VARCHAR(256) NOT NULL,
    `create_time` INT NOT NULL,
    `update_time` INT NOT NULL,
    `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_follow_ship`;
CREATE TABLE IF NOT EXISTS `tbl_follow_ship`(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uid` INT NOT NULL,
  `jobs` VARCHAR (256) NOT NULL DEFAULT '',
  `company` VARCHAR (256) NOT NULL DEFAULT '',
  `industry` VARCHAR (256) NOT NULL DEFAULT '',
  `create_time` INT NOT NULL DEFAULT '0',
  `update_time` INT NOT NULL DEFAULT '0',
  `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_follow_job`;
CREATE TABLE IF NOT EXISTS `tbl_follow_job` (
  `uid` INT NOT NULL PRIMARY KEY,
  `list` VARCHAR (255) NOT NULL DEFAULT '',
  `create_time` INT NOT NULL DEFAULT '0',
  `update_time` INT NOT NULL DEFAULT '0',
  `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_follow_company`;
CREATE TABLE IF NOT EXISTS `tbl_follow_company` (
  `uid` INT NOT NULL PRIMARY KEY,
  `list` VARCHAR (255) NOT NULL DEFAULT '',
  `create_time` INT NOT NULL DEFAULT '0',
  `update_time` INT NOT NULL DEFAULT '0',
  `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_follow_industry`;
CREATE TABLE IF NOT EXISTS `tbl_follow_industry` (
  `uid` INT NOT NULL PRIMARY KEY,
  `list` VARCHAR (255) NOT NULL DEFAULT '',
  `create_time` INT NOT NULL DEFAULT '0',
  `update_time` INT NOT NULL DEFAULT '0',
  `status` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

