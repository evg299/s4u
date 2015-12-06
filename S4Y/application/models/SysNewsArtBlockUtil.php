<?php

require_once 'DBUtil.php';

/**
 * Description of SysNewsArtBlockUtil
 *
 * @author Evgeny
 */
class SysNewsArtBlockUtil {

    public static function getSysNewsArtBlocksByArtId($artId) {
        $query = "SELECT  `id`,  `sys_news_art_id`,  `image_id`,  `image_title`,  `text_content`,  `block_type`,  `order_in_art` FROM `sys_news_art_block` WHERE `sys_news_art_id` = ? ORDER BY `order_in_art` ASC";

        $sysNewsArtBlocks = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $artId);
        return $sysNewsArtBlocks;
    }

    public static function getSysNewsArtBlockById($sysNewsArtId) {
        $query = "SELECT  `id`,  `sys_news_art_id`,  `image_id`,  `image_title`,  `text_content`,  `block_type`,  `order_in_art` FROM `sys_news_art_block` WHERE `id` = ? ";

        $sysNewsArtBlocks = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $sysNewsArtId);
        return $sysNewsArtBlocks[0];
    }

    public static function insertSysNewsArtBlock($sysNewsArtBlock) {
        $query = "INSERT INTO `sys_news_art_block` (`sys_news_art_id`,  `image_id`,  `image_title`,  `text_content`,  `block_type`,  `order_in_art`) VALUES (?, ?, ?, ?, ?, ?)";

        StringHelper::massiveSpecialChars($sysNewsArtBlock, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "iissii", $sysNewsArtBlock['sys_news_art_id'], $sysNewsArtBlock['image_id'], $sysNewsArtBlock['image_title'], $sysNewsArtBlock['text_content'], $sysNewsArtBlock['block_type'], $sysNewsArtBlock['order_in_art']);
    }

    public static function updateSysNewsArtBlock($sysNewsArtBlock) {
        $query = "UPDATE `sys_news_art_block` SET `sys_news_art_id` = ?, `image_id` = ?, `image_title` = ?, `text_content` = ?, `block_type` = ?, `order_in_art` = ? WHERE `id` = ?";

        StringHelper::massiveSpecialChars($sysNewsArtBlock, ENT_QUOTES);
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "iissiii", $sysNewsArtBlock['sys_news_art_id'], $sysNewsArtBlock['image_id'], $sysNewsArtBlock['image_title'], $sysNewsArtBlock['text_content'], $sysNewsArtBlock['block_type'], $sysNewsArtBlock['order_in_art'], $sysNewsArtBlock['id']);
    }

    public static function deleteSysNewsArtBlockById($sysNewsArtBlockId) {
        $query = "DELETE FROM `sys_news_art_block` WHERE  `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $sysNewsArtBlockId);
    }

    public static function deleteSysNewsArtBlocksByNewsArtId($sysNewsArtId) {
        $query = "DELETE FROM `sys_news_art_block` WHERE  `sys_news_art_id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $sysNewsArtId);
    }

}
