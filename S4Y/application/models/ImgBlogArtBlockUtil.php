<?php

require_once 'DBUtil.php';

/**
 * Description of ImgBlogArtBlockUtil
 *
 * @author Evgeny
 */
class ImgBlogArtBlockUtil {

    public static function getImgBlogArtBlocksById($id) {
        $query = "SELECT  `id`,  `img_blog_art_id`,  `block_type`,  `text_content`,  
            `img_picture_id`,  `pict_desc`,  `order_in_art` 
            FROM `img_blog_art_block` WHERE `id` = ?";

        $imgBlogArtBlocks = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $id);
        return $imgBlogArtBlocks[0];
    }

    public static function getImgBlogArtBlocksByArtId($artId) {
        $query = "SELECT  `id`,  `img_blog_art_id`,  `block_type`,  `text_content`,  
            `img_picture_id`,  `pict_desc`,  `order_in_art` 
            FROM `img_blog_art_block`
            WHERE `img_blog_art_id` = ? ORDER BY `order_in_art` ASC";

        $imgBlogArtBlocks = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $artId);
        return $imgBlogArtBlocks;
    }

    public static function insertImgBlogArtBlock($imgBlogArtBlock) {
        $query = "INSERT INTO `img_blog_art_block` 
            (`img_blog_art_id`,  `block_type`,  `text_content`,  `img_picture_id`,  `pict_desc`,  `order_in_art`) 
            VALUES (?, ?, ?, ?, ?, ?)";
        StringHelper::massiveSpecialChars($imgBlogArtBlock, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "iisisi", $imgBlogArtBlock['img_blog_art_id'], $imgBlogArtBlock['block_type'], $imgBlogArtBlock['text_content'], $imgBlogArtBlock['img_picture_id'], $imgBlogArtBlock['pict_desc'], $imgBlogArtBlock['order_in_art']);
    }

    public static function updateImgBlogArtBlock($imgBlogArtBlock) {
        $query = "UPDATE `img_blog_art_block` SET `img_blog_art_id` = ?, `block_type` = ?, `text_content` = ?, `img_picture_id` = ?, `pict_desc` = ?, `order_in_art` = ? WHERE `id` = ?";
        StringHelper::massiveSpecialChars($imgBlogArtBlock, ENT_QUOTES);
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "iisisii", $imgBlogArtBlock['img_blog_art_id'], $imgBlogArtBlock['block_type'], $imgBlogArtBlock['text_content'], $imgBlogArtBlock['img_picture_id'], $imgBlogArtBlock['pict_desc'], $imgBlogArtBlock['order_in_art'], $imgBlogArtBlock['id']);
    }

    public static function deleteImgBlogArtBlockById($imgBlogArtBlockId) {
        $query = "DELETE FROM `img_blog_art_block` WHERE  `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $imgBlogArtBlockId);
    }

}
