<?php

require_once 'DBUtil.php';

/**
 * Description of SysPropertiesUtil
 *
 * @author Evgeny
 */
class SysPropertiesUtil {

    public static function getCountPropertyValue($key) {
        $query = "SELECT COUNT(*) as cnt FROM `sys_properties` WHERE `name` = ?";

        $countResults = DBUtil::getResultRowsOfPrepatedQuery($query, "s", $key);
        return $countResults[0]['cnt'];
    }

    public static function getPropertyValue($key) {
        $query = "SELECT `value` FROM `sys_properties` WHERE `name` = ?";

        $props = DBUtil::getResultRowsOfPrepatedQuery($query, "s", $key);
        return $props[0]['value'];
    }

    public static function putProperty($key, $value) {
        $cnt = self::getCountPropertyValue($key);
        if (0 == cnt) {
            $query = "UPDATE `sys_properties` SET `value`=? WHERE `name`=?";
        } else {
            $query = "INSERT INTO `sys_properties` (`value`, `name`) VALUES (?, ?)";
        }

        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ss", $value, $key);
    }

}
