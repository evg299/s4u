<?php

require_once 'DBUtil.php';

/**
 * Description of OrderGdsUtil
 *
 * @author Evgeny
 */
class OrderGdsUtil {

    public static function insertOrderGds($order_gds) {
        $query = "INSERT INTO `order_gds` (`order_id`, `img_gds_id`, `count_gds`) VALUES (?, ?, ?)";
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "iii", $order_gds['order_id'], $order_gds['img_gds_id'], $order_gds['count_gds']);
    }

}
