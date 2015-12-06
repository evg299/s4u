<?php

require_once 'DBUtil.php';

/**
 * Description of AddrRegionUtil
 *
 * @author Evgeny
 */
class AddrRegionUtil {

    public static function getRegions() {
        $query = "SELECT  `id`,  `name`,  `code` FROM `addr_region` ORDER BY `name`";
        $regions = DBUtil::getResultRowsOfPrepatedQuery($query);
        return $regions;
    }

    public static function getRegionById($id) {
        $query = "SELECT  `id`,  `name`,  `code` FROM `addr_region` WHERE `id` = ?";
        $regions = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $id);
        return $regions[0];
    }

    public static function getRegionByCode($code) {
        $query = "SELECT  `id`,  `name`,  `code` FROM `addr_region` WHERE `code` = ?";
        $regions = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $code);
        return $regions[0];
    }

}
