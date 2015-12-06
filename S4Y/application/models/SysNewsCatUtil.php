<?php

require_once 'DBUtil.php';

/**
 * Description of SysNewsCatUtil
 *
 * @author Evgeny
 */
class SysNewsCatUtil {

    public static function getSysNewsCats() {
        $query = "SELECT  `id`,  `name`,  `pid`  FROM `sys_news_cat`";

        $sysNewsCats = DBUtil::getResultRowsOfPrepatedQuery($query);
        return $sysNewsCats;
    }

    public static function getSysNewsCatByID($sysNewsCatID) {
        $query = "SELECT  `id`,  `name`,  `pid`  FROM `sys_news_cat` WHERE `id` = ?";

        $sysNewsCats = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $sysNewsCatID);
        return $sysNewsCats[0];
    }

    public static function moveNewsCats($old_pid, $new_pid) {
        if (NULL != $old_pid) {
            $query = "UPDATE `sys_news_cat` SET `pid` = ?  WHERE `pid` = ?";
            DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ii", $new_pid, $old_pid);
        } else {
            $query = "UPDATE `sys_news_cat` SET `pid` = ?  WHERE `pid` is NULL";
            DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $new_pid);
        }
    }

    public static function insertSysNewsCat($sysNewsCat) {
        $query = "INSERT INTO `sys_news_cat` (`name`, `pid`) VALUES (?, ?)";
        StringHelper::massiveSpecialChars($sysNewsCat, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "si", $sysNewsCat['name'], $sysNewsCat['pid']);
    }

    public static function updateSysNewsCat($sysNewsCat) {
        $query = "UPDATE `sys_news_cat` SET  `name` = ?,  `pid` = ? WHERE `id` = ?";
        StringHelper::massiveSpecialChars($sysNewsCat, ENT_QUOTES);
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "sii", $sysNewsCat['name'], $sysNewsCat['pid'], $sysNewsCat['id']);
    }

    public static function deleteSysNewsCatById($sysNewsCatId) {
        $query = "DELETE FROM `sys_news_cat` WHERE  `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $sysNewsCatId);
    }

    public static function createBreadcrumpHTML($sysNewsCatId) {
        if (NULL != $sysNewsCatId) {
            $sysNewsCats = self::getSysNewsCats();
            $currentSysNewsCat = self::findSysNewsCat($sysNewsCats, $sysNewsCatId);
            if (NULL == $currentSysNewsCat)
                return;
            $html = "<a href='/" . SYS_BLOG_DIR . "?" . SYS_ART_CAT_PARAM_NAME . "=" . $currentSysNewsCat['id'] . "'>" . $currentSysNewsCat['name'] . "</a>";

            while ($parrentSysNewsCat = self::findParentSysNewsCat($sysNewsCats, $sysNewsCatId)) {
                $html = "<a href='/" . SYS_BLOG_DIR . "?" . SYS_ART_CAT_PARAM_NAME . "=" . $parrentSysNewsCat['id'] . "'>" . $parrentSysNewsCat['name'] . "</a> >> " . $html;
                $sysNewsCatId = $parrentSysNewsCat['id'];
            }

            return ">> " . $html;
        }
    }

    private static function findParentSysNewsCat($sysNewsCats, $sysNewsCatId) {
        $currentSysNewsCat = self::findSysNewsCat($sysNewsCats, $sysNewsCatId);
        if (NULL != $currentSysNewsCat['pid']) {
            return self::findSysNewsCat($sysNewsCats, $currentSysNewsCat['pid']);
        }
        return NULL;
    }

    private static function findSysNewsCat($sysNewsCats, $sysNewsCatId) {
        foreach ($sysNewsCats as $sysNewsCat) {
            if ($sysNewsCatId == $sysNewsCat['id'])
                return $sysNewsCat;
        }
        return NULL;
    }

    public static function createTreeHTML($link_href_pref) {
        $sysNewsCats = self::getSysNewsCats();

        if (NULL == $sysNewsCats)
            return;

        foreach ($sysNewsCats as $sysNewsCat) {
            $cats[$sysNewsCat['pid']][] = $sysNewsCat;
        }

        $result = '<ul>';
        foreach ($cats[$parent_id] as $cat) {
            if (NULL == $cat['parent_id']) {
                if (NULL == $link_href_pref) {
                    $f1 = '<li>';
                    $f2 = '';
                    $f3 = '</li>';
                } else {
                    $f1 = '<li><a href="' . $link_href_pref . $cat['id'] . '">';
                    $f2 = '</a>';
                    $f3 = '</li>';
                }

                $result .= $f1;
                $result .= $cat['name'] . $f2;
                $result .= DBUtil::build_tree($cats, $cat['id'], $link_href_pref);
                $result .= $f3;
            }
        }
        $result .= '</ul>';

        return $result;
    }

}
