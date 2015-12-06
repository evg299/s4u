<?php

require_once 'DBUtil.php';

/**
 * Description of ImgBlogArtUtil
 *
 * @author Evgeny
 */
class ImgBlogArtUtil {

    public static function getCountOfImgBlogArtByAccountIdAndImgBlogCatId($img_account_id, $img_blog_cat_id) {
        $query = "SELECT COUNT(*) as cnt FROM `img_blog_art` WHERE `img_account_id` = ? ";

        if (NULL != $img_blog_cat_id) {
            $query .= "AND `img_blog_cat_id` = ?";
            $countRsults = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $img_account_id, $img_blog_cat_id);
        } else {
            $countRsults = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $img_account_id);
        }

        return $countRsults[0]['cnt'];
    }

    public static function getImgBlogArtsByAccountIdAndImgBlogCatId($img_account_id, $img_blog_cat_id, $start, $lenght) {
        $query = "SELECT `id`,  `img_blog_cat_id`,  `name`,  `creation_date`,  `main_pict_id`,  `preview`
			FROM `img_blog_art` WHERE `img_account_id` = ? ";
        if (NULL != $img_blog_cat_id) {
            $query .= "AND `img_blog_cat_id` = ? ";
        }
        $query .= "ORDER BY `creation_date` DESC LIMIT ?, ?";

        if (NULL != $img_blog_cat_id) {
            $imgBlogArts = DBUtil::getResultRowsOfPrepatedQuery($query, "iiii", $img_account_id, $img_blog_cat_id, $start, $lenght);
        } else {
            $imgBlogArts = DBUtil::getResultRowsOfPrepatedQuery($query, "iii", $img_account_id, $start, $lenght);
        }

        return $imgBlogArts;
    }

    public static function getCountOfImgBlogArtByFilter($img_account_id, $img_blog_cat_id, $ptile) {
        $query = "SELECT COUNT(*)as cnt FROM `img_blog_art` WHERE `img_account_id` = ? ";
        if (NULL != $img_blog_cat_id) {
            $query .= "AND `img_blog_cat_id` = ? ";
        }

        $ptile = trim($ptile);
        if (0 != strcmp("", $ptile)) {
            $query .= "AND upper(`name`) LIKE upper(?) ";
        }

        if (NULL != $img_blog_cat_id && NULL != $ptile) {
            $ptile = "%" . $ptile . "%";
            $countRsults = DBUtil::getResultRowsOfPrepatedQuery($query, "iis", $img_account_id, $img_blog_cat_id, $ptile);
        } else if (NULL != $img_blog_cat_id) {
            $countRsults = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $img_account_id, $img_blog_cat_id);
        } else if (NULL != $ptile) {
            $ptile = "%" . $ptile . "%";
            $countRsults = DBUtil::getResultRowsOfPrepatedQuery($query, "is", $img_account_id, $ptile);
        } else {
            $countRsults = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $img_account_id);
        }

        return $countRsults[0]['cnt'];
    }

    public static function getImgBlogArtsByFilter($img_account_id, $img_blog_cat_id, $ptile, $start, $lenght) {
        $query = "SELECT `id`,  `img_blog_cat_id`,  `name`,  `creation_date`,  `main_pict_id`,  `preview`
			FROM `img_blog_art` WHERE `img_account_id` = ? ";
        if (NULL != $img_blog_cat_id) {
            $query .= "AND `img_blog_cat_id` = ? ";
        }

        $ptile = trim($ptile);
        if (0 != strcmp("", $ptile)) {
            $query .= "AND upper(`name`) LIKE upper(?) ";
        }

        $query .= "ORDER BY `creation_date` DESC LIMIT ?, ?";

        if (NULL != $img_blog_cat_id && NULL != $ptile) {
            $ptile = "%" . $ptile . "%";
            $imgBlogArts = DBUtil::getResultRowsOfPrepatedQuery($query, "iisii", $img_account_id, $img_blog_cat_id, $ptile, $start, $lenght);
        } else if (NULL != $img_blog_cat_id) {
            $imgBlogArts = DBUtil::getResultRowsOfPrepatedQuery($query, "iiii", $img_account_id, $img_blog_cat_id, $start, $lenght);
        } else if (NULL != $ptile) {
            $ptile = "%" . $ptile . "%";
            $imgBlogArts = DBUtil::getResultRowsOfPrepatedQuery($query, "isii", $img_account_id, $ptile, $start, $lenght);
        } else {
            $imgBlogArts = DBUtil::getResultRowsOfPrepatedQuery($query, "iii", $img_account_id, $start, $lenght);
        }

        return $imgBlogArts;
    }

    public static function getImgBlogArtById($img_account_id, $img_blog_art_id) {
        $query = "SELECT `id`,  `img_blog_cat_id`,  `name`,  `creation_date`,  `main_pict_id`,  `preview`
			FROM `img_blog_art` WHERE `img_account_id` = ? AND `id` = ?";
        $imgBlogArts = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $img_account_id, $img_blog_art_id);
        return $imgBlogArts[0];
    }

    public static function moveBlogArtss($old_cat, $new_cat) {
        if (NULL != $old_cat) {
            $query = "UPDATE `img_blog_art` SET `img_blog_cat_id` = ?  WHERE `img_blog_cat_id` = ?";
            DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ii", $new_cat, $old_cat);
        } else {
            $query = "UPDATE `img_blog_art` SET `img_blog_cat_id` = ?  WHERE `img_blog_cat_id` is NULL";
            DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $new_cat);
        }
    }

    public static function insertImgBlogArt($imgBlogArt) {
        $query = "INSERT INTO `img_blog_art` (`img_account_id`, `img_blog_cat_id`, `name`, `main_pict_id`, `preview`) VALUES (?, ?, ?, ?, ?)";

        StringHelper::massiveSpecialChars($imgBlogArt, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "iisis", $imgBlogArt['img_account_id'], $imgBlogArt['img_blog_cat_id'], $imgBlogArt['name'], $imgBlogArt['main_pict_id'], $imgBlogArt['preview']);
    }

    public static function updateImgBlogArt($imgBlogArt) {
        $query = "UPDATE `img_blog_art` SET `img_blog_cat_id` = ?,  `name` = ?,  `creation_date` = NOW(),  `main_pict_id` = ?,  `preview` = ? WHERE `id` = ?";

        StringHelper::massiveSpecialChars($imgBlogArt, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "isisi", $imgBlogArt['img_blog_cat_id'], $imgBlogArt['name'], $imgBlogArt['main_pict_id'], $imgBlogArt['preview'], $imgBlogArt['id']);
    }

    public static function deleteImgBlogArtById($imgBlogArtId) {
        $queryBlock = "DELETE FROM `img_blog_art_block` WHERE  `img_blog_art_id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($queryBlock, "i", $imgBlogArtId);
        $queryArt = "DELETE FROM `img_blog_art` WHERE  `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($queryArt, "i", $imgBlogArtId);
    }

}
