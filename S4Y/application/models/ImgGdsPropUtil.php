<?php

require_once 'DBUtil.php';

/**
 * Description of ImgGdsPropUtil
 *
 * @author Evgeny
 */
class ImgGdsPropUtil {

    public static function getImgGdsProps($imgGdsId) {
        $query = "SELECT  `id`,  `img_gds_id`,  `name`,  `value` FROM `img_gds_prop` WHERE `img_gds_id` = ?";

        $imgGdsProps = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $imgGdsId);
        return $imgGdsProps;
    }

    public static function insertImgGdsProp($imgGdsProp) {
        $query = "INSERT INTO `img_gds_prop` (`img_gds_id`,  `name`,  `value`) VALUES (?, ?, ?)";
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "iss", $imgGdsProp['img_gds_id'], $imgGdsProp['name'], $imgGdsProp['value']);
    }

    public static function insertManyImgGdsProps($imgGdsId, $props) {
        $query = "INSERT INTO `img_gds_prop` (`img_gds_id`,  `name`,  `value`) VALUES (?, ?, ?)";

        if (count($props)) {
            $mysqli = DBUtil::getMysqliConnection();
            if ($stmt = $mysqli->prepare($query)) {
                foreach ($props as $item) {
                    $stmt->bind_param("iss", $imgGdsId, $item['key'], $item['value']);
                    $stmt->execute();
                }
                $stmt->close();
            }
            DBUtil::closeMysqliConnection($mysqli);
        }
    }

    public static function updateImgGdsProp($imgGdsProp) {
        $query = "UPDATE `img_gds_prop` SET `img_gds_id` = ?,  `name` = ?,  `value` = ? WHERE `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "issi", $imgGdsProp['img_gds_id'], $imgGdsProp['name'], $imgGdsProp['value'], $imgGdsProp['id']);
    }

    public static function deleteImgGdsPropById($imgGdsPropId) {
        $query = "DELETE FROM `img_gds_prop` WHERE  `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $imgGdsPropId);
    }

    public static function deleteImgGdsPropByImgGdsId($img_gds_id) {
        $query = "DELETE FROM `img_gds_prop` WHERE  `img_gds_id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $img_gds_id);
    }

}
