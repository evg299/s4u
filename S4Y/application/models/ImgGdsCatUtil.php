<?php

require_once 'DBUtil.php';

/**
 * Description of ImgGdsCatUtil
 *
 * @author Evgeny
 */
class ImgGdsCatUtil {

    public static function getImgGdsCatsByAccountId($account_id) {
        $query = "SELECT  `id`, `account_id`, `name`,  `pid` FROM `img_gds_cat` WHERE `account_id` = ? ORDER BY `pid`";
        $imgGdsCats = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $account_id);
        return $imgGdsCats;
    }

    public static function getImgGdsCat($gds_cat_id, $account_id) {
        $query = "SELECT  `id`, `account_id`, `name`,  `pid` FROM `img_gds_cat` WHERE `account_id` = ? AND `id` = ?";
        $imgGdsCats = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $account_id, $gds_cat_id);
        return $imgGdsCats[0];
    }

    public static function moveGDScats($old_pid, $new_pid) {
        if (NULL != $old_pid) {
            $query = "UPDATE `img_gds_cat` SET `pid` = ?  WHERE `pid` = ?";
            DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ii", $new_pid, $old_pid);
        } else {
            $query = "UPDATE `img_gds_cat` SET `pid` = ?  WHERE `pid` is NULL";
            DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $new_pid);
        }
    }

    public static function insertImgGdsCat($imgGdsCat) {
        $query = "INSERT INTO `img_gds_cat` (`account_id`, `name`, `pid`) VALUES (?, ?, ?)";
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "isi", $imgGdsCat['account_id'], $imgGdsCat['name'], $imgGdsCat['pid']);
    }

    public static function updateImgGdsCat($imgGdsCat) {
        $query = "UPDATE `img_gds_cat` SET `account_id` = ?,  `name` = ?,  `pid` = ? WHERE `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "isii", $imgGdsCat['account_id'], $imgGdsCat['name'], $imgGdsCat['pid'], $imgGdsCat['id']);
    }

    public static function deleteImgGdsCatById($imgGdsCatId) {
        $query = "DELETE FROM `img_gds_cat` WHERE  `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $imgGdsCatId);
    }

    public static function createBreadcrumpHTML($account_id, $imgGdsCatId) {
        if (NULL != $imgGdsCatId) {
            $imgGdsCats = self::getImgGdsCatsByAccountId($account_id);
            $currentImgGdsCat = self::findImgGdsCat($imgGdsCats, $imgGdsCatId);
            if (NULL == $currentImgGdsCat)
                return;
            $html = "<a href='/" . IMAG_PREFIX . $account_id . "/?" . PROD_CAT_PARAM_NAME . "=" . $currentImgGdsCat['id'] . "'>" . $currentImgGdsCat['name'] . "</a>";

            while ($parrentImgGdsCat = self::findParentImgGdsCat($imgGdsCats, $imgGdsCatId)) {
                $html = "<a href='/" . IMAG_PREFIX . $account_id . "/?" . PROD_CAT_PARAM_NAME . "=" . $parrentImgGdsCat['id'] . "'>" . $parrentImgGdsCat['name'] . "</a> >> " . $html;
                $imgGdsCatId = $parrentImgGdsCat['id'];
            }

            return ">> " . $html;
        }
    }

    public static function createBreadcrumpHTMLByProductId($account_id, $productId) {
        $imgGdsCatId = self::findImgGdsCatIdByProductId($account_id, $productId);
        return self::createBreadcrumpHTML($account_id, $imgGdsCatId);
    }

    private static function findImgGdsCatIdByProductId($account_id, $productId) {
        $query = "SELECT  igc.id as id FROM img_gds_cat igc JOIN img_gds ig ON igc.id = ig.img_gds_cat_id 
		WHERE igc.account_id = ? AND ig.id = ?";
        $imgGdsCatIds = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $account_id, $productId);
        return $imgGdsCatIds[0]['id'];
    }

    private static function findParentImgGdsCat($imgGdsCats, $imgGdsCatId) {
        $currentImgGdsCat = self::findImgGdsCat($imgGdsCats, $imgGdsCatId);

        if (NULL != $currentImgGdsCat['pid']) {
            return self::findImgGdsCat($imgGdsCats, $currentImgGdsCat['pid']);
        }

        return NULL;
    }

    private static function findImgGdsCat($imgGdsCats, $imgGdsCatId) {
        foreach ($imgGdsCats as $imgGdsCat) {
            if ($imgGdsCatId == $imgGdsCat['id'])
                return $imgGdsCat;
        }

        return NULL;
    }

    public static function createTreeHTML($account_id, $link_href) {
        $imgGdsCats = self::getImgGdsCatsByAccountId($account_id);

        if (NULL == $imgGdsCats)
            return;

        foreach ($imgGdsCats as $imgGdsCat) {
            $cats[$imgGdsCat['pid']][] = $imgGdsCat;
        }

        $result = '<ul>';
        foreach ($cats[$parent_id] as $cat) {
            if (NULL == $cat['parent_id']) {
                if (NULL == $link_href) {
                    $f1 = '<li>';
                    $f2 = '';
                    $f3 = '</li>';
                } else {
                    $f1 = '<li><a href="' . $link_href . $cat['id'] . '">';
                    $f2 = '</a>';
                    $f3 = '</li>';
                }

                $result .= $f1;
                $result .= $cat['name'] . $f2;
                $result .= DBUtil::build_tree($cats, $cat['id'], $link_href);
                $result .= $f3;
            }
        }
        $result .= '</ul>';

        return $result;
    }

}

