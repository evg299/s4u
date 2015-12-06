<?php

require_once 'DBUtil.php';

/**
 * Description of SysNewsArtUtil
 *
 * @author Evgeny
 */
class SysNewsArtUtil {

    public static function getCountOfSysNewsArtBySysNewsCatId($sysNewsCatId) {
        $query = "SELECT  count(*) as cnt FROM `sys_news_art` ";
        if (NULL != $sysNewsCatId) {
            $query .= " WHERE `sys_news_cat_id` = ? ";
            $countResults = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $sysNewsCatId);
        } else {
            $countResults = DBUtil::getResultRowsOfPrepatedQuery($query);
        }

        return $countResults[0]['cnt'];
    }

    public static function getSysNewsArtsBySysNewsCatId($sysNewsCatId, $start, $lenght) {
        $query = "SELECT  `id`,  `sys_news_cat_id`,  `title`,  `preview`,  `c_date`,  `main_pict_id` FROM `sys_news_art` ";
        if (NULL != $sysNewsCatId) {
            $query .= " WHERE `sys_news_cat_id` = ? ";
        }
        $query .= " ORDER BY `c_date` DESC LIMIT ?, ?";

        if (NULL != $sysNewsCatId) {
            $sysNewsArts = DBUtil::getResultRowsOfPrepatedQuery($query, "iii", $sysNewsCatId, $start, $lenght);
        } else {
            $sysNewsArts = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $start, $lenght);
        }

        return $sysNewsArts;
    }

    public static function getSysNewsArtById($sysNewsArtId) {
        $query = "SELECT  `id`,  `sys_news_cat_id`,  `title`,  `preview`,  `c_date`,  `main_pict_id` 
            FROM `sys_news_art` WHERE `id` = ?";

        $sysNewsArts = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $sysNewsArtId);
        return $sysNewsArts[0];
    }

    public static function getCountOfSysNewsArtsByFilter($sys_news_cat_id, $ptile) {
        $query = "SELECT count(*) as cnt FROM `sys_news_art` WHERE 1 = 1 ";
        $ptile = trim($ptile);

        if (0 != $sys_news_cat_id) {
            $query .= "AND `sys_news_cat_id` = ? ";
        }

        if (0 != strcmp("", $ptile)) {
            $query .= "AND upper(`title`) LIKE upper(?) ";
        }
        
        if (NULL != $sys_news_cat_id && 0 != strcmp("", $ptile)) {
            $ptile = "%" . $ptile . "%";
            $countResults = DBUtil::getResultRowsOfPrepatedQuery($query, "is", $sys_news_cat_id, $ptile);
        } else if (NULL != $sys_news_cat_id) {
            $countResults = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $sys_news_cat_id);
        } else if (0 != strcmp("", $ptile)) {
            $ptile = "%" . $ptile . "%";
            $countResults = DBUtil::getResultRowsOfPrepatedQuery($query, "s", $ptile);
        } else {
            $countResults = DBUtil::getResultRowsOfPrepatedQuery($query);
        }

        return $countResults[0]['cnt'];
    }

    public static function getSysNewsArtsByFilter($sys_news_cat_id, $ptile, $start, $lenght) {
        $query = "SELECT `id`,  `sys_news_cat_id`,  `title`,  `preview`,  `c_date`,  `main_pict_id`
			FROM `sys_news_art` WHERE 1 = 1 ";
        $ptile = trim($ptile);

        if (NULL != $sys_news_cat_id) {
            $query .= "AND `sys_news_cat_id` = ? ";
        }

        if (0 != strcmp("", $ptile)) {
            $query .= "AND upper(`title`) LIKE upper(?) ";
        }
        $query .= "ORDER BY `c_date` DESC LIMIT ?, ?";

        if (NULL != $sys_news_cat_id && 0 != strcmp("", $ptile)) {
            $ptile = "%" . $ptile . "%";
            $sysNewsArts = DBUtil::getResultRowsOfPrepatedQuery($query, "isii", $sys_news_cat_id, $ptile, $start, $lenght);
        } else if (NULL != $sys_news_cat_id) {
            $sysNewsArts = DBUtil::getResultRowsOfPrepatedQuery($query, "iii", $sys_news_cat_id, $start, $lenght);
        } else if (0 != strcmp("", $ptile)) {
            $ptile = "%" . $ptile . "%";
            $sysNewsArts = DBUtil::getResultRowsOfPrepatedQuery($query, "sii", $ptile, $start, $lenght);
        } else {
            $sysNewsArts = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $start, $lenght);
        }

        return $sysNewsArts;
    }

    public static function moveNewsArtss($old_cat, $new_cat) {
        if (NULL != $old_cat)
            $query = "UPDATE `sys_news_art` SET `sys_news_cat_id` = ?  WHERE `sys_news_cat_id` = ?";
        else
            $query = "UPDATE `sys_news_art` SET `sys_news_cat_id` = ?  WHERE `sys_news_cat_id` is NULL";

        if (NULL != $old_cat)
            DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ii", $new_cat, $old_cat);
        else
            DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $new_cat);
    }

    public static function insertSysNewsArt($sysNewsArt) {
        $query = "INSERT INTO `sys_news_art` (`sys_news_cat_id`,  `title`,  `preview`,  `main_pict_id`) VALUES (?, ?, ?, ?) ";

        StringHelper::massiveSpecialChars($sysNewsArt, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "issi", $sysNewsArt['sys_news_cat_id'], $sysNewsArt['title'], $sysNewsArt['preview'], $sysNewsArt['main_pict_id']);
    }

    public static function updateSysNewsArt($sysNewsArt) {
        $query = "UPDATE `sys_news_art` SET `sys_news_cat_id` = ?,  `title` = ?,  `preview` = ?,  `main_pict_id` = ? WHERE `id` = ?";

        StringHelper::massiveSpecialChars($sysNewsArt, ENT_QUOTES);
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "issii", $sysNewsArt['sys_news_cat_id'], $sysNewsArt['title'], $sysNewsArt['preview'], $sysNewsArt['main_pict_id'], $sysNewsArt['id']);
    }

    public static function deleteSysNewsArtById($sysNewsArtId) {
        $query = "DELETE FROM `sys_news_art` WHERE  `id` = ?";

        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $sysNewsArtId);
    }

}
