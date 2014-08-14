---离线数据库表----
DROP TABLE `offline`.`tbl_keywords`;
CREATE TABLE IF NOT EXISTS `offline`.`tbl_keywords` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `site` VARCHAR(16) NOT NULL DEFAULT '',
    `keyword` VARCHAR(64) NOT NULL DEFAULT '',
    `create_time` INT NOT NULL DEFAULT '0',
    `update_time` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE `offline`.`tbl_job`;
CREATE TABLE IF NOT EXISTS `offline`.`tbl_job` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `url` VARCHAR(1024) NOT NULL DEFAULT '',
    `content` VARCHAR(2048) NOT NULL DEFAULT '',
    `create_time` INT NOT NULL DEFAULT '0',
    `update_time` INT NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


---CREATE TABLE IF NOT EXISTS `offline`.`tbl_urllist_keyword`