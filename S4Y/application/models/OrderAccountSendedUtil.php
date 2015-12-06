<?php

require_once 'DBUtil.php';

/**
 * Description of OrderAccountSendedUtil
 *
 * @author Evgeny
 */
class OrderAccountSendedUtil {

    public static function getOrderAccsToMailMessage($orderID) {
        $query = "select DISTINCT o.id as oid, iacc.id as accid, iacc.email as accemail, o.u_email as oemail from img_gds as igds 
                    join img_account iacc on igds.img_account_id = iacc.id
                    join order_gds ogds on ogds.img_gds_id = igds.id
                    join `order` o on ogds.order_id = o.id
                    where o.id = ?";

        $orderAccs = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $orderID);
        return $orderAccs;
    }

    public static function insertOrderAccountRelation($orderID) {
        $query = "INSERT INTO order_account_sended(order_id, img_account_id)
                    select DISTINCT o.id, iacc.id from img_gds as igds 
                        join img_account iacc on igds.img_account_id = iacc.id
                        join order_gds ogds on ogds.img_gds_id = igds.id
                        join `order` o on ogds.order_id = o.id
                    where o.id = ?";

        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $orderID);
    }

    public static function updateOrderAccountRelation($orderID, $accountID, $sended) {
        $query = "UPDATE `order_account_sended` SET `sended`=?  WHERE `order_id`=? AND `img_account_id`=?";

        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "iii", $sended, $orderID, $accountID);
    }

}
