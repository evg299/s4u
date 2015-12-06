<?php

require_once 'DBUtil.php';

/**
 * Description of SysStaticPageBlocksUtil
 *
 * @author Evgeny
 */
class SysStaticPageBlocksUtil {

    public static function getSysStaticPageBlockById($sspId) {
        $query = "SELECT  `id`,  `sys_static_page_id`,  `block_type_id`,  `image_id`,  `image_title`,  `text_content`,  `order_in_page`  FROM  `sys_static_page_blocks` WHERE `id` = ?";

        $sysStaticPageBlocks = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $sspId);
        return $sysStaticPageBlocks[0];
    }

    public static function getSysStaticPageBlocksByPageId($pageId) {
        $query = "SELECT  `id`,  `sys_static_page_id`,  `block_type_id`,  `image_id`,  `image_title`,  `text_content`,  `order_in_page`  FROM  `sys_static_page_blocks` WHERE `sys_static_page_id` = ? ORDER BY `order_in_page` ASC";

        $sysStaticPageBlocks = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $pageId);
        return $sysStaticPageBlocks;
    }

    public static function insertSysStaticPageBlock($sysStaticPageBlock) {
        $query = "INSERT INTO `sys_static_page_blocks` (`sys_static_page_id`,  `block_type_id`,  `image_id`,  `image_title`,  `text_content`,  `order_in_page`) VALUES (?, ?, ?, ?, ?, ?) ";

        // StringHelper::massiveSpecialChars($sysStaticPageBlock, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "iiissi", $sysStaticPageBlock['sys_static_page_id'], $sysStaticPageBlock['block_type_id'], $sysStaticPageBlock['image_id'], $sysStaticPageBlock['image_title'], $sysStaticPageBlock['text_content'], $sysStaticPageBlock['order_in_page']);
    }

    public static function updateSysStaticPageBlock($sysStaticPageBlock) {
        $query = "UPDATE `sys_static_page_blocks` SET `sys_static_page_id` = ?,  `block_type_id` = ?,  `image_id` = ?,  `image_title` = ?,  `text_content` = ?,  `order_in_page` = ? WHERE `id` = ?";

        // StringHelper::massiveSpecialChars($sysStaticPageBlock, ENT_QUOTES);
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "iiissii", $sysStaticPageBlock['sys_static_page_id'], $sysStaticPageBlock['block_type_id'], $sysStaticPageBlock['image_id'], $sysStaticPageBlock['image_title'], $sysStaticPageBlock['text_content'], $sysStaticPageBlock['order_in_page'], $sysStaticPageBlock['id']);
    }

    public static function deleteSysStaticPageBlockById($sysStaticPageBlockId) {
        $query = "DELETE FROM `sys_static_page_blocks` WHERE  `id` = ?";

        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $sysStaticPageBlockId);
    }

}
