<?php

require_once 'DBUtil.php';

/**
 * Description of ImgPictureUtil
 *
 * @author Evgeny
 */
class ImgPictureUtil {

    public static function getImgPictureById($pict_id) {
        $query = "SELECT  `id`,  `account_id`,  `album_id`,  `name`,  `path` FROM `img_picture` WHERE `id` = ?";

        $imgPictures = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $pict_id);
        return $imgPictures[0];
    }

    public static function getImgPicturesNoAlbum($account_id) {
        $query = "SELECT  `id`,  `account_id`,  `album_id`,  `name`,  `path` FROM `img_picture` WHERE `account_id` = ? AND `album_id` = 0";

        $imgPictures = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $account_id);
        return $imgPictures;
    }

    public static function getImgPicturesByAlbumId($album_id, $account_id) {
        $query = "SELECT  `id`,  `account_id`,  `album_id`,  `name`,  `path` FROM `img_picture` WHERE `album_id` = ? AND `account_id` = ?";

        $imgPictures = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $album_id, $account_id);
        return $imgPictures;
    }

    public static function countImgPicturesByAlbumId($id) {
        $query = "SELECT  COUNT(*) as cnt FROM `img_picture` WHERE `album_id` = ?";

        $cntResults = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $id);
        return $cntResults[0]['cnt'];
    }

    public static function createImgPicture($imgPicture) {
        $query = "INSERT INTO `img_picture` (`account_id`, `album_id`, `name`, `path`) VALUES (?, ?, ?, ?)";

        StringHelper::massiveSpecialChars($imgPicture, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "iiss", $imgPicture['account_id'], $imgPicture['album_id'], $imgPicture['name'], $imgPicture['path']);
    }

    public static function deleteImgPictureById($imgPictureId) {
        $query = "DELETE FROM `img_picture` WHERE `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $imgPictureId);
    }

}
