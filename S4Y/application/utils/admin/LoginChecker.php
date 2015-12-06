<?php

require_once dirname(__FILE__) . "/../../models/__DBMODEL__.php";

/**
 * Description of LoginChecker
 *
 * @author Evgeny
 */
class LoginChecker {

    // Проверка на залогиненость
    public static function isLogined() {
        if (isset($_COOKIE['log'])) {
            $parts = explode("_", $_COOKIE['log']);
            $imgID = $parts[0];
            $cookie_code = $parts[1];

            $imgAccount = ImgAccountUtil::getImgAccountById($imgID, TRUE);
            if (NULL != $imgAccount && $cookie_code == $imgAccount['cookie_code']) {
                return $imgAccount['id'];
            }
        }

        return FALSE;
    }

    // Проверка на админа
    public static function isAdmin() {
        if (isset($_COOKIE['sa'])) {
            $adminUUID = $_COOKIE['sa'];
            $sysAdmin = SysAdminsUtil::getSysAdminByLastUUID($adminUUID);
            if ($sysAdmin)
                return TRUE;
        }

        return FALSE;
    }

}
