<?php

require_once 'DBUtil.php';

/**
 * Description of OrderUtil
 *
 * @author Evgeny
 */
class OrderUtil {

    public static function getCountOrdersByAccountID($accountId) {
        $query = "select count(DISTINCT o.id) as cnt
                  from `order` as o 
                        join order_account_sended as oaccses on oaccses.order_id = o.id
                        join img_account as iacc on iacc.id = oaccses.img_account_id
                  where iacc.id = ?";

        $countResults = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $accountId);
        return $countResults[0]['cnt'];
    }
    
    public static function getCountOrdersSendedByAccountID($accountId) {
        $query = "select count(DISTINCT o.id) as cnt
                  from `order` as o 
                        join order_account_sended as oaccses on oaccses.order_id = o.id
                        join img_account as iacc on iacc.id = oaccses.img_account_id
                  where iacc.id = ? and not oaccses.sended = 0";

        $countResults = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $accountId);
        return $countResults[0]['cnt'];
    }

    public static function getCountOrdersNotSendedByAccountID($accountId) {
        $query = "select count(DISTINCT o.id) as cnt
                  from `order` as o 
                        join order_account_sended as oaccses on oaccses.order_id = o.id
                        join img_account as iacc on iacc.id = oaccses.img_account_id
                  where iacc.id = ? and oaccses.sended = 0";

        $countResults = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $accountId);
        return $countResults[0]['cnt'];
    }

    public static function getOrdersByLimit($accountId, $start, $lenght) {
        $query = "select DISTINCTROW o.id, o.u_email, o.u_name, o.u_phone, o.u_comment, o.c_date, oaccses.sended
                    from `order` as o 
                        join order_account_sended as oaccses on oaccses.order_id = o.id
                        join img_account as iacc on iacc.id = oaccses.img_account_id
                    where iacc.id = ?
                    order by o.id
                    limit ?, ?";

        $orders = DBUtil::getResultRowsOfPrepatedQuery($query, "iii", $accountId, $start, $lenght);
        return $orders;
    }

    public static function getOrdersNotSendedByLimit($accountId, $start, $lenght) {
        $query = "select DISTINCTROW o.id, o.u_email, o.u_name, o.u_phone, o.u_comment, o.c_date, oaccses.sended
                    from `order` as o 
                        join order_account_sended as oaccses on oaccses.order_id = o.id
                        join img_account as iacc on iacc.id = oaccses.img_account_id
                    where iacc.id = ? and oaccses.sended = 0
                    order by o.id
                    limit ?, ?";

        $orders = DBUtil::getResultRowsOfPrepatedQuery($query, "iii", $accountId, $start, $lenght);
        return $orders;
    }

    public static function getOrdersLastByLimit($accountId, $start, $lenght) {
        $query = "select DISTINCTROW o.id, o.u_email, o.u_name, o.u_phone, o.u_comment, o.c_date, oaccses.sended
                    from `order` as o 
                        join order_account_sended as oaccses on oaccses.order_id = o.id
                        join img_account as iacc on iacc.id = oaccses.img_account_id
                    where iacc.id = ?
                    order by o.c_date desc
                    limit ?, ?";

        $orders = DBUtil::getResultRowsOfPrepatedQuery($query, "iii", $accountId, $start, $lenght);
        return $orders;
    }

    public static function getOrderById($orderID, $accountID) {
        $query = "SELECT  o.id,  o.u_email, o.u_name, o.u_phone, o.u_comment,  o.c_date , oacc.sended
                    FROM `order` as o
                    JOIN order_account_sended as oacc ON oacc.order_id = o.id
                    WHERE o.`id` = ? AND oacc.img_account_id = ?";

        $orders = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $orderID, $accountID);
        return $orders[0];
    }

    public static function insertOrder($order) {
        $query = "INSERT INTO `order` (`u_email`, `u_name`, `u_phone`, `u_comment`) VALUES (?, ?, ?, ?)";

        StringHelper::massiveSpecialChars($order, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ssss", $order['u_email'], $order['u_name'], $order['u_phone'], $order['u_comment']);
    }

    public static function setSendedOrder($order_id) {
        $query = "UPDATE `order` SET `sended`=1  WHERE `id`=?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $order_id);
    }

}
