<?php

require_once 'DBUtil.php';

/**
 * Description of ImgAddressUtil
 *
 * @author Evgeny
 */
class ImgAddressUtil {

    public static function getImgAddressById($id) {
        $query = "SELECT ia.id, r.id AS region_id, r.code AS rcode, r.name AS rname, ia.sity, ia.street, ia.house 
			FROM img_address AS ia 
			JOIN addr_region AS r on ia.region_id = r.id
			WHERE ia.id = ?";

        $imgAddreses = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $id);
        return $imgAddreses[0];
    }

    public static function insertImgAddress($imgAddress) {
        $query = "INSERT INTO `img_address` (`region_id`,  `sity`,  `street`,  `house`) VALUES (?, ?, ?, ?)";
        StringHelper::massiveSpecialChars($imgAddress, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "isss", $imgAddress['region_id'], $imgAddress['sity'], $imgAddress['street'], $imgAddress['house']);
    }

    public static function updateImgAddress($imgAddress) {
        $query = "UPDATE `img_address` SET `region_id` = ?, `sity` = ?, `street` = ?, `house` = ? WHERE `id` = ?";
        StringHelper::massiveSpecialChars($imgAddress, ENT_QUOTES);
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "isssi", $imgAddress['region_id'], $imgAddress['sity'], $imgAddress['street'], $imgAddress['house'], $imgAddress['id']);
    }

    public static function deleteImgAddressById($imgAddressId) {
        $query = "DELETE FROM `img_address` WHERE  `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $imgAddressId);
    }

}
