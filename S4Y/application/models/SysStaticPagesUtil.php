<?php

require_once 'DBUtil.php';

/**
 * Description of SysStaticPagesUtil
 *
 * @author Evgeny
 */
class SysStaticPagesUtil {

    public static function getSysStaticPageByName($namePage) {
        $query = "SELECT  `id`,  `name`,  `title` FROM `sys_static_pages` WHERE upper(`name`) LIKE upper(?)";

        $sysStaticPages = DBUtil::getResultRowsOfPrepatedQuery($query, "s", $namePage);
        return $sysStaticPages[0];
    }

    public static function insertSysStaticPage($sysStaticPage) {
        $query = "INSERT INTO `sys_static_pages` (`name`,  `title`) VALUES (?, ?) ";

        StringHelper::massiveSpecialChars($sysStaticPage, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ss", $sysStaticPage['name'], $sysStaticPage['title']);
    }

    public static function updateSysStaticPage($sysStaticPage) {
        $query = "UPDATE `sys_static_pages` SET `name` = ?,  `title` = ? WHERE `id` = ?";

        StringHelper::massiveSpecialChars($sysStaticPage, ENT_QUOTES);
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ssi", $sysStaticPage['name'], $sysStaticPage['title'], $sysStaticPage['id']);
    }

    public static function deleteSysStaticPageById($sysStaticPageId) {
        $query = "DELETE FROM `sys_static_pages` WHERE  `id` = ?";

        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $sysStaticPageId);
    }

}
