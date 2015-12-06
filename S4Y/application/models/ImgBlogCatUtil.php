<?php

require_once 'DBUtil.php';

/**
 * Description of ImgBlogCatUtil
 *
 * @author Evgeny
 */
class ImgBlogCatUtil {

    public static function getImgBlogCat($blog_cat_id, $account_id) {
        $query = "SELECT  `id`, `account_id`, `name`,  `pid` FROM `img_blog_cat` WHERE `id` = ? AND `account_id` = ?";

        $imgBlogCats = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $blog_cat_id, $account_id);
        return $imgBlogCats[0];
    }

    public static function getImgBlogCatsByAccountId($account_id) {
        $query = "SELECT  `id`, `account_id`, `name`,  `pid` FROM `img_blog_cat` WHERE `account_id` = ?";

        $imgBlogCats = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $account_id);
        return $imgBlogCats;
    }

    public static function moveBlogCats($old_pid, $new_pid) {
        if (NULL != $old_pid) {
            $query = "UPDATE `img_blog_cat` SET `pid` = ?  WHERE `pid` = ?";
            DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ii", $new_pid, $old_pid);
        } else {
            $query = "UPDATE `img_blog_cat` SET `pid` = ?  WHERE `pid` is NULL";
            DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $new_pid);
        }
    }

    public static function insertImgBlogCat($imgBlogCat) {
        $query = "INSERT INTO `img_blog_cat` (`account_id`, `name`, `pid`) VALUES (?, ?, ?)";
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "isi", $imgBlogCat['account_id'], $imgBlogCat['name'], $imgBlogCat['pid']);
    }

    public static function updateImgBlogCat($imgBlogCat) {
        $query = "UPDATE `img_blog_cat` SET `account_id` = ?,  `name` = ?,  `pid` = ? WHERE `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "isii", $imgBlogCat['account_id'], $imgBlogCat['name'], $imgBlogCat['pid'], $imgBlogCat['id']);
    }

    public static function deleteImgBlogCatById($imgBlogCatId) {
        $query = "DELETE FROM `img_blog_cat` WHERE  `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $imgBlogCatId);
    }

    public static function createBreadcrumpHTML($account_id, $imgBlogCatId) {
        if (NULL != $imgBlogCatId) {
            $imgBlogCats = self::getImgBlogCatsByAccountId($account_id);
            $currentImgBlogCat = self::findImgBlogCat($imgBlogCats, $imgBlogCatId);
            if (NULL == $currentImgBlogCat)
                return;
            $html = "<a href='/" . IMAG_PREFIX . $account_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=" . $currentImgBlogCat['id'] . "'>" . $currentImgBlogCat['name'] . "</a>";

            while ($parrentImgBlogCat = self::findParentImgBlogCat($imgBlogCats, $imgBlogCatId)) {
                $html = "<a href='/" . IMAG_PREFIX . $account_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=" . $parrentImgBlogCat['id'] . "'>" . $parrentImgBlogCat['name'] . "</a> >> " . $html;
                $imgBlogCatId = $parrentImgBlogCat['id'];
            }

            return ">> " . $html;
        }
    }

    private static function findParentImgBlogCat($imgBlogCats, $imgBlogCatId) {
        $currentImgBlogCat = self::findImgBlogCat($imgBlogCats, $imgBlogCatId);

        if (NULL != $currentImgBlogCat['pid']) {
            return self::findImgBlogCat($imgBlogCats, $currentImgBlogCat['pid']);
        }

        return NULL;
    }

    private static function findImgBlogCat($imgBlogCats, $imgBlogCatId) {
        foreach ($imgBlogCats as $imgBlogCat) {
            if ($imgBlogCatId == $imgBlogCat['id'])
                return $imgBlogCat;
        }

        return NULL;
    }

    public static function createTreeHTML($account_id, $link_href) {
        $imgBlogCats = self::getImgBlogCatsByAccountId($account_id);

        if (NULL == $imgBlogCats)
            return;

        foreach ($imgBlogCats as $imgBlogCat) {
            $cats[$imgBlogCat['pid']][] = $imgBlogCat;
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
