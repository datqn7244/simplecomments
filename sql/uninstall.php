<?php
    $sqls=array();
    $sqls[]='DROP TABLE IF EXISTS `'._DB_PREFIX_.'simplecomments`';
    foreach ($sqls as $sql) {
        if (!Db::getInstance()->execute($sql)) {
            return false;
        }
    }
