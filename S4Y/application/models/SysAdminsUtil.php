<?php

require_once 'DBUtil.php';

/**
 * Description of SysAdminsUtil
 *
 * @author Evgeny
 */
class SysAdminsUtil {

    public static function getSysAdminByLoginAndPassword($login, $password) {
        $query = "SELECT  `id`,  `login`,  `password`,  `lastuuid` FROM `sys_admins` WHERE `login` LIKE ? AND `password` LIKE ?";

        $sysAdmins = DBUtil::getResultRowsOfPrepatedQuery($query, "ss", $login, $password);
        return $sysAdmins[0];
    }

    public static function getSysAdminByLastUUID($lastUUID) {
        $query = "SELECT  `id`,  `login`,  `password`,  `lastuuid` FROM `sys_admins` WHERE `lastuuid` LIKE ?";

        $sysAdmins = DBUtil::getResultRowsOfPrepatedQuery($query, "s", $lastUUID);
        return $sysAdmins[0];
    }

    public static function updateSysAdmin($sysAdmin) {
        $query = "UPDATE `sys_admins` SET `login`=?, `password`=?, `lastuuid`=? WHERE  `id`=?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "sssi", $sysAdmin['login'], $sysAdmin['password'], $sysAdmin['lastuuid'], $sysAdmin['id']);
    }

}
