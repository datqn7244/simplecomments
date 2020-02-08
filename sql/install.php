<?php
    $sqls=array();
    $sqls[]='CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'simplecomments` (
        `id_simcom_comment` INT(11) NOT NULL AUTO_INCREMENT,
    `id_product` INT(11) NOT NULL,
    `firstname` VARCHAR( 255 ) NOT NULL,
    `lastname` VARCHAR( 255 ) NOT NULL,
    `email` VARCHAR( 255 ) NOT NULL,
    `grade` INT(1) NOT NULL,
    `comment` TEXT NOT NULL,
    `date_add` DATETIME NOT NULL,
    PRIMARY KEY (id_simcom_comment))
        ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET = UTF8';
foreach ($sqls as $sql) {
    if (!Db::getInstance()->execute($sql)) {
        return false;
    }
}
