<?php

require_once 'DBUtil.php';

/**
 * Description of ImgAlbumUtil
 *
 * @author Evgeny
 */
class ImgAlbumUtil {

    public static function getImgAlbumsByAccountID($account_id) {
        $query = "SELECT  `id`,  `account_id`,  `name`,  `description` FROM `img_album` WHERE `account_id` = ? ORDER BY `name`";

        $imgAlbums = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $account_id);
        return $imgAlbums;
    }

    public static function getImgAlbumByID($album_id, $account_id) {
        $query = "SELECT  `id`,  `account_id`,  `name`,  `description` FROM `img_album` WHERE `id` = ? AND `account_id` = ?";

        $imgAlbums = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $album_id, $account_id);
        return $imgAlbums[0];
    }

    public static function insertImgAlbum($imgAlbum) {
        $query = "INSERT INTO `img_album` (`account_id`, `name`, `description`) VALUES (?, ?, ?)";

        StringHelper::massiveSpecialChars($imgAlbum, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "iss", $imgAlbum['account_id'], $imgAlbum['name'], $imgAlbum['description']);
    }

    public static function updateImgAlbum($imgAlbum) {
        $query = "UPDATE `img_album` SET `account_id` = ?, `name` = ?, `description` = ? WHERE `id` = ?";
        StringHelper::massiveSpecialChars($imgAlbum, ENT_QUOTES);
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "issi", $imgAlbum['account_id'], $imgAlbum['name'], $imgAlbum['description'], $imgAlbum['id']);
    }

    public static function deleteImgAlbumByID($imgAlbumID, $withPictures) {
        $query = "DELETE FROM `img_album` WHERE `id` = ?";
        if ($withPictures) {
            $pict_query = "DELETE FROM `img_picture` WHERE `album_id` = ?";
        } else {
            $pict_query = "UPDATE `img_picture` SET `album_id` = NULL WHERE `album_id` = ?";
        }
        
        DBUtil::getLastInsertedIdOfPrepatedQuery($pict_query, "i", $imgAlbumID);
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $imgAlbumID);
    }

}
