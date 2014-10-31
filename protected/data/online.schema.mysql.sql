# /*-------用户信息表-------*/
# /*---普通用户表----*/
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id`          INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
#   `type`        INT NOT NULL DEFAULT '0',
  `username`    VARCHAR(32)  NOT NULL,
  `password`    VARCHAR(64)  NOT NULL,
  `nickname`    VARCHAR(32)  NOT NULL DEFAULT ''
  COMMENT '昵称',
  `head`        VARCHAR(64)  NOT NULL DEFAULT ''
  COMMENT '头像sign,空为系统默认头像',
  `token`       VARCHAR(256) NOT NULL DEFAULT '',
  `last_login`  INT          NOT NULL DEFAULT '0',
  `pro_state`   INT          NOT NULL DEFAULT '0'
  COMMENT '就业状态 0-毕业生/实习生 1-职场精英',
  `reg_from`    INT          NOT NULL DEFAULT '0'
  COMMENT '账号来源, 0-本站注册;1-sina微博账号;3-qq账号;4-百度账号',
  `profile`     VARCHAR(256) NOT NULL DEFAULT ''
  COMMENT '简历信息 tbl_profile表的id list',
#   `cid` INT NOT NULL DEFAULT '0' COMMENT '企业账户关联的企业id',
  `create_time` INT          NOT NULL DEFAULT '0',
  `update_time` INT          NOT NULL DEFAULT '0',
  `status`      INT          NOT NULL DEFAULT '0'
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

# /*---简历表定义---*/
DROP TABLE IF EXISTS `tbl_profile`;
CREATE TABLE IF NOT EXISTS `tbl_profile` (
  `id`          INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uid`         INT          NOT NULL
  COMMENT '用户id',
  `language`    TINYINT      NOT NULL DEFAULT '0',
  `name`        VARCHAR(32)  NOT NULL DEFAULT '我的简历'
  COMMENT '这份简历的标题',
  `first_name`  VARCHAR(32)  NOT NULL DEFAULT '',
  `last_name`   VARCHAR(32)  NOT NULL DEFAULT '',
  `location`    VARCHAR(16)  NOT NULL DEFAULT '',
  `industry`    INT          NOT NULL DEFAULT '0',
  `phone`       VARCHAR(64)  NOT NULL DEFAULT '',
  `email`       VARCHAR(256) NOT NULL DEFAULT '',
  `edu`         VARCHAR(64)  NOT NULL DEFAULT ''
  COMMENT '教育背景,表tbl_education的id list',
  `exp`         VARCHAR(128) NOT NULL DEFAULT ''
  COMMENT '工作经验,表tbl_experience的id list',
  `tags`        VARCHAR(256) NOT NULL DEFAULT ''
  COMMENT '整个简历的关键字',
  `create_time` INT          NOT NULL DEFAULT '0',
  `update_time` INT          NOT NULL DEFAULT '0',
  `status`      INT          NOT NULL DEFAULT '0'
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

/*---用户教育背景信息---*/
DROP TABLE IF EXISTS `tbl_education`;
CREATE TABLE IF NOT EXISTS `tbl_education` (
  `id`          INT           NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uid`         INT           NOT NULL,
  `profile_id`  INT           NOT NULL,
  `college`     VARCHAR(64)   NOT NULL DEFAULT '',
  `major`       VARCHAR(128)  NOT NULL DEFAULT '',
  `degree`      INT           NOT NULL DEFAULT '0',
  `start_time`  INT           NOT NULL DEFAULT '0',
  `end_time`    INT           NOT NULL DEFAULT '0',
  `description` VARCHAR(1024) NOT NULL DEFAULT '',
  `reward`      VARCHAR(256)  NOT NULL DEFAULT '',
  `create_time` INT           NOT NULL DEFAULT '0',
  `update_time` INT           NOT NULL DEFAULT '0',
  `status`      INT           NOT NULL DEFAULT '0'
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

# /*---用户工作经验表---*/
DROP TABLE IF EXISTS `tbl_experience`;
CREATE TABLE IF NOT EXISTS `tbl_experience` (
  `id`          INT           NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uid`         INT           NOT NULL,
  `profile_id`  INT           NOT NULL,
  `start_time`  INT           NOT NULL DEFAULT '0',
  `end_time`    INT           NOT NULL DEFAULT '0',
  `company`     VARCHAR(64)   NOT NULL DEFAULT '',
  `location`    VARCHAR(32)   NOT NULL DEFAULT '',
  `title`       VARCHAR(32)   NOT NULL DEFAULT '',
  `description` VARCHAR(2048) NOT NULL DEFAULT '',
  `tags`        VARCHAR(128)  NOT NULL DEFAULT '',
  `create_time` INT           NOT NULL DEFAULT '0',
  `update_time` INT           NOT NULL DEFAULT '0',
  `status`      INT           NOT NULL DEFAULT '0'
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;


# 企业用户账号表
DROP TABLE IF EXISTS `tbl_company_account`;
CREATE TABLE IF NOT EXISTS `tbl_company_account` (
  `id`          INT         NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cid`         INT         NOT NULL DEFAULT '0',
  `username`    VARCHAR(32) NOT NULL DEFAULT '',
  `password`    VARCHAR(64) NOT NULL DEFAULT '',
  `token`       VARCHAR(64) NOT NULL DEFAULT '',
  `last_login`  INT         NOT NULL DEFAULT '0',
  `nickname`    VARCHAR(32) NOT NULL DEFAULT '',
  `logo`        VARCHAR(64) NOT NULL DEFAULT '',
  `create_time` INT         NOT NULL DEFAULT '0',
  `update_time` INT         NOT NULL DEFAULT '0',
  `status`      INT         NOT NULL DEFAULT '0'
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

# 管理员账号表
DROP TABLE IF EXISTS `tbl_admin_account`;
CREATE TABLE IF NOT EXISTS `tbl_admin_account` (
  `id`          INT         NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username`    VARCHAR(32) NOT NULL DEFAULT '',
  `password`    VARCHAR(64) NOT NULL DEFAULT '',
  `token`       VARCHAR(64) NOT NULL DEFAULT '',
  `last_login`  INT         NOT NULL DEFAULT '0',
  `nickname`    VARCHAR(32) NOT NULL DEFAULT '',
  `head`        VARCHAR(64) NOT NULL DEFAULT '',
  `create_time` INT         NOT NULL DEFAULT '0',
  `update_time` INT         NOT NULL DEFAULT '0',
  `status`      INT         NOT NULL DEFAULT '0'
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

# 猎头用户账号表
DROP TABLE IF EXISTS `tbl_hunter_account`;
CREATE TABLE IF NOT EXISTS `tbl_hunter_account` (
  `id`          INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cids`        VARCHAR(256) NOT NULL DEFAULT '',
  `username`    VARCHAR(32)  NOT NULL DEFAULT '',
  `password`    VARCHAR(64)  NOT NULL DEFAULT '',
  `token`       VARCHAR(64)  NOT NULL DEFAULT '',
  `last_login`  INT          NOT NULL DEFAULT '0',
  `nickname`    VARCHAR(32)  NOT NULL DEFAULT '',
  `head`        VARCHAR(64)  NOT NULL DEFAULT '',
  `create_time` INT          NOT NULL DEFAULT '0',
  `update_time` INT          NOT NULL DEFAULT '0',
  `status`      INT          NOT NULL DEFAULT '0'
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

# /*---职位信息表---*/
DROP TABLE IF EXISTS `tbl_job`;
CREATE TABLE IF NOT EXISTS `tbl_job` (
  `id`             INT           NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title`          VARCHAR(128)  NOT NULL DEFAULT ''
  COMMENT '职位名称',
  `cid`            INT           NOT NULL DEFAULT '0'
  COMMENT '公司id',
  `industry`       INT           NOT NULL DEFAULT '0'
  COMMENT '行业id',
  `functype`       INT           NOT NULL DEFAULT '0'
  COMMENT '职能类别,职能id',
  `profession`     INT           NOT NULL DEFAULT '0'
  COMMENT '职业类别,profession id',
  `department`     VARCHAR(64)   NOT NULL DEFAULT ''
  COMMENT '部门',
  `m_ratio`        TINYINT       NOT NULL DEFAULT '0'
  COMMENT '岗位管理比重:1-15 percents,2-30 percents,3-50 percents',
  `salary`         TINYINT       NOT NULL DEFAULT '0',
  `location`       INT           NOT NULL DEFAULT '0',
  `degree`         TINYINT       NOT NULL DEFAULT '0',
  `hc`             INT           NOT NULL DEFAULT '0'
  COMMENT '招聘人数',
  `age_min`        TINYINT       NOT NULL DEFAULT '0'
  COMMENT '年龄范围',
  `age_max`        TINYINT       NOT NULL DEFAULT '0',
  `requirement`    VARCHAR(1024) NOT NULL DEFAULT '',
  `responsibility` VARCHAR(1024) NOT NULL DEFAULT '',
  `other`          VARCHAR(256)  NOT NULL DEFAULT ''
  COMMENT '补充说明',
  `tags`           VARCHAR(256)  NOT NULL DEFAULT '',
  `filter`         VARCHAR(128)  NOT NULL DEFAULT ''
  COMMENT '筛选条件,6个关键字,以,分割',
  `publish_time`   INT           NOT NULL DEFAULT '0',
  `expire_time`    INT           NOT NULL DEFAULT '0',
  `create_time`    INT           NOT NULL DEFAULT '0',
  `update_time`    INT           NOT NULL DEFAULT '0',
  `status`         INT           NOT NULL DEFAULT '0'
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

# ---企业信息表---
DROP TABLE IF EXISTS `tbl_company`;
CREATE TABLE IF NOT EXISTS `tbl_company` (
  `id`            INT           NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `max_account` INT NOT NULL DEFAULT '1',
  `name`          VARCHAR(64)   NOT NULL
  COMMENT '公司名称,必需',
  `type`          INT           NOT NULL DEFAULT '3'
  COMMENT '性质',
  `industry`      INT           NOT NULL DEFAULT '0'
  COMMENT '行业',
  `scale`         INT           NOT NULL DEFAULT '0'
  COMMENT '规模 0:~100 people;1:100~500 people;2:500~1000 people;3:1000~',
  `homepage`      VARCHAR(128)  NOT NULL DEFAULT ''
  COMMENT '主页',
  `description`          VARCHAR(2048) NOT NULL DEFAULT ''
  COMMENT '简介',
#   以下为扩展信息
  `location` INT NOT NULL DEFAULT '0' COMMENT '地区信息',
  `address`       VARCHAR(256)  NOT NULL DEFAULT ''
  COMMENT '公司地址',
  `contact`       VARCHAR(32)   NOT NULL DEFAULT ''
  COMMENT '联系人',
  `phone`         VARCHAR(20)   NOT NULL DEFAULT ''
  COMMENT '联系电话,座机',
  `mobile`        VARCHAR(20)   NOT NULL DEFAULT ''
  COMMENT '联系人手机',
  `email`         VARCHAR(256)  NOT NULL DEFAULT ''
  COMMENT '简历邮箱',
  `logo`          VARCHAR(64)   NOT NULL DEFAULT ''
  COMMENT '公司logo,contsign',
  `certification` VARCHAR(64)   NOT NULL DEFAULT ''
  COMMENT '认证照片,contsign',
  `tags`          VARCHAR(128)  NOT NULL DEFAULT ''
  COMMENT '检索标签',
  `flag`          INT           NOT NULL DEFAULT '0'
  COMMENT '是否向普通用户显示扩展信息',
  `create_time`   INT           NOT NULL DEFAULT '0',
  `update_time`   INT           NOT NULL DEFAULT '0',
  `status`        INT           NOT NULL DEFAULT '0'
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

# 职业列表,随时变动,管理端编辑
DROP TABLE IF EXISTS `tbl_profession`;
CREATE TABLE IF NOT EXISTS `tbl_profession` (
  `id`     INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name`   VARCHAR(64)  NOT NULL DEFAULT '',
  `e_name` VARCHAR(64)  NOT NULL DEFAULT '',
  `desc`   VARCHAR(512) NOT NULL DEFAULT ''
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

# 按照职业类别订阅,即按profession订阅
DROP TABLE IF EXISTS `tbl_follow_profession`;
CREATE TABLE IF NOT EXISTS `tbl_follow_profession` (
  `uid`            INT           NOT NULL PRIMARY KEY,
  `ocid`           INT           NOT NULL DEFAULT '0',
  `last_view_time` INT           NOT NULL DEFAULT '0',
  `viewed`         VARCHAR(2048) NOT NULL DEFAULT ''
  COMMENT 'job id list',
  `unviewed`       VARCHAR(2048) NOT NULL DEFAULT ''
  COMMENT 'job id list',
  `create_time`    INT           NOT NULL DEFAULT '0',
  `update_time`    INT           NOT NULL DEFAULT '0',
  `status`         INT           NOT NULL DEFAULT '0',
  KEY (ocid)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

DROP TABLE IF EXISTS `tbl_follow_company`;
CREATE TABLE IF NOT EXISTS `tbl_follow_company` (
  `uid`            INT           NOT NULL PRIMARY KEY,
  `cid`            INT           NOT NULL DEFAULT '0',
  `last_view_time` INT           NOT NULL DEFAULT '0',
  `viewed`         VARCHAR(2048) NOT NULL DEFAULT ''
  COMMENT 'job id list',
  `unviewed`       VARCHAR(2048) NOT NULL DEFAULT ''
  COMMENT 'job id list',
  `remain`         INT           NOT NULL DEFAULT '0',
  `create_time`    INT           NOT NULL DEFAULT '0',
  `update_time`    INT           NOT NULL DEFAULT '0',
  `status`         INT           NOT NULL DEFAULT '0',
  KEY (cid),
  KEY (uid, cid)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

DROP TABLE IF EXISTS `tbl_follow_industry`;
CREATE TABLE IF NOT EXISTS `tbl_follow_industry` (
  `uid`            INT           NOT NULL PRIMARY KEY,
  `iid`            INT           NOT NULL DEFAULT '0',
  `last_view_time` INT           NOT NULL DEFAULT '0',
  `viewed`         VARCHAR(2048) NOT NULL DEFAULT '',
  `unviewed`       VARCHAR(2048) NOT NULL DEFAULT '',
  `create_time`    INT           NOT NULL DEFAULT '0',
  `update_time`    INT           NOT NULL DEFAULT '0',
  `status`         INT           NOT NULL DEFAULT '0',
  KEY (iid)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8;

DROP TABLE IF EXISTS `tbl_msg`;
CREATE TABLE IF NOT EXISTS `tbl_msg` (
  `id`          INT           NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `sid`         INT           NOT NULL DEFAULT '0'
  COMMENT '发送者id',
  `stype`       TINYINT       NOT NULL
  COMMENT '发送者类型,1-普通用户,2-企业用户',
  `rid`         INT           NOT NULL DEFAULT '0'
  COMMENT '接收者id',
  `rtype`       TINYINT       NOT NULL
  COMMENT '接受者类型,1-普通用户,2-企业用户',
  `type`        INT           NOT NULL DEFAULT '0'
  COMMENT '类型:0-普通,1-消息/邀请,2-回复',
  `msg`         VARCHAR(1024) NOT NULL DEFAULT '',
  `create_time` INT           NOT NULL DEFAULT '0',
  `update_time` INT           NOT NULL DEFAULT '0',
  `status`      INT           NOT NULL DEFAULT '0'
)
  ENGINE =InnoDB
  DEFAULT CHARSET = utf8
  COMMENT '消息实体';


DROP TABLE IF EXISTS `tbl_relationship`;
CREATE TABLE IF NOT EXISTS `tbl_relationship` (
  `uid`         INT NOT NULL,
  `cid`         INT NOT NULL,
  `create_time` INT NOT NULL,
  `update_time` INT NOT NULL,
  `state`       INT NOT NULL DEFAULT '0'
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `tbl_invite`;
CREATE TABLE IF NOT EXISTS `tbl_invite` (
  `id`          INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `uid`         INT          NOT NULL,
  `cid`         INT          NOT NULL,
  `state`       TINYINT      NOT NULL,
  `msg`         VARCHAR(256) NOT NULL,
  `create_time` INT          NOT NULL,
  `update_time` INT          NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;