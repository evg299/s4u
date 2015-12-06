<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImgGdsUtil
 *
 * @author Evgeny
 */
class ImgGdsUtil {

    public static function countImgGdssByAccountId($account_id, $img_gds_cat_id) {
        $query = "SELECT  COUNT(*) as cnt FROM img_gds WHERE img_account_id = ? ";
        $subCatIds = self::getImgGdsSubCatIdsByImgGdsCatId($account_id, $img_gds_cat_id);
        $subCatIds = @array_values($subCatIds);
        if (count($subCatIds)) {
            $subCatsStr = implode(", ", $subCatIds);
            $query = $query . "AND img_gds_cat_id IN ($subCatsStr)";
            $imgGdsCnts = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $account_id);
            return $imgGdsCnts[0]['cnt'];
        }
    }

    public static function getImgGdssByAccountId($account_id, $img_gds_cat_id, $start, $lenght) {
        $query = "SELECT  ig.id AS ig_id,  UUID,  ig.name AS ig_name,  price,  currency_id, ic.name AS ic_name,  
		main_pict_id,  img_account_id,  img_gds_cat_id,  add_date,  in_stock,  is_new,  is_recommended 
		FROM img_gds AS ig JOIN img_currency AS ic ON currency_id = ic.id  
		WHERE img_account_id = ? ";
        $subCatIds = self::getImgGdsSubCatIdsByImgGdsCatId($account_id, $img_gds_cat_id);
        $subCatIds = @array_values($subCatIds);
        if (count($subCatIds)) {
            $subCatsStr = implode(", ", $subCatIds);
            $query = $query . "AND img_gds_cat_id IN ($subCatsStr) ORDER BY add_date DESC LIMIT ?, ?";
            $imgGdss = DBUtil::getResultRowsOfPrepatedQuery($query, "iii", $account_id, $start, $lenght);
            return $imgGdss;
        }
    }

    public static function getImgGdsByIdAndAccountId($img_gds_id, $account_id) {
        $query = "SELECT  ig.id AS ig_id,  UUID,  ig.name AS ig_name,  price,  currency_id, ic.name AS ic_name,  
                    main_pict_id, first_pict_id, second_pict_id, third_pict_id, img_account_id,  img_gds_cat_id,  add_date,  in_stock,  is_new,  is_recommended 
                    FROM img_gds AS ig JOIN img_currency AS ic ON currency_id = ic.id
                    WHERE ig.id = ? AND img_account_id = ? ";
        $imgGdss = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $img_gds_id, $account_id);
        return $imgGdss[0];
    }

    public static function getImgGdssByOrderId($order_id) {
        $query = "SELECT ig.id AS ig_id,  UUID,  ig.name AS ig_name,  price,  currency_id, ic.name AS ic_name,  
			main_pict_id, first_pict_id, second_pict_id, third_pict_id, img_account_id,  img_gds_cat_id,  
			add_date,  in_stock,  is_new,  is_recommended, og.count_gds
                    FROM `order_gds` og 
                        JOIN `img_gds` ig ON og.img_gds_id = ig.id
                        JOIN `img_currency` AS ic ON currency_id = ic.id
                    WHERE og.order_id = ?";
        $imgGdss = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $order_id);
        return $imgGdss;
    }

    public static function getNewImgGdssByAccountId($account_id, $img_gds_cat_id, $lenght) {
        $query = "SELECT  ig.id AS ig_id,  UUID,  ig.name AS ig_name,  price,  currency_id, ic.name AS ic_name,  
			main_pict_id,  img_account_id,  img_gds_cat_id,  add_date,  in_stock,  is_new,  is_recommended 
			FROM img_gds AS ig JOIN img_currency AS ic ON currency_id = ic.id  
			WHERE NOT is_new = 0 AND img_account_id = ? ";
        $subCatIds = self::getImgGdsSubCatIdsByImgGdsCatId($account_id, $img_gds_cat_id);
        $subCatIds = @array_values($subCatIds);
        if (count($subCatIds)) {
            $subCatsStr = implode(", ", $subCatIds);
            $query = $query . "AND img_gds_cat_id IN ($subCatsStr) ORDER BY RAND() LIMIT ?";
            $imgGdss = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $account_id, $lenght);
            return $imgGdss;
        }
    }

    public static function getRecommendedImgGdssByAccountId($account_id, $img_gds_cat_id, $lenght) {
        $query = "SELECT  ig.id AS ig_id,  UUID,  ig.name AS ig_name,  price,  currency_id, ic.name AS ic_name,  
			main_pict_id,  img_account_id,  img_gds_cat_id,  add_date,  in_stock,  is_new,  is_recommended 
			FROM img_gds AS ig JOIN img_currency AS ic ON currency_id = ic.id  
			WHERE NOT is_recommended = 0 AND img_account_id = ? ";
        $subCatIds = self::getImgGdsSubCatIdsByImgGdsCatId($account_id, $img_gds_cat_id);
        $subCatIds = @array_values($subCatIds);
        if (count($subCatIds)) {
            $subCatsStr = implode(", ", $subCatIds);
            $query = $query . "AND img_gds_cat_id IN ($subCatsStr) ORDER BY RAND() LIMIT ?";
            $imgGdss = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $account_id, $lenght);
            return $imgGdss;
        }
    }

    public static function getSmilaryImgGdss($account_id, $img_gds_cat_id, $img_gds_id) {
        $query = "SELECT ig.`id` , `UUID` , ig.`name` , `price` , `currency_id` , `main_pict_id` , `img_account_id` , `img_gds_cat_id` ,
						`add_date` , `in_stock` , `is_new` , `is_recommended` , ic.`name` AS ic_name
			FROM `img_gds` AS ig
			JOIN `img_currency` AS ic ON ic.id = ig.`currency_id`
			WHERE `img_account_id` = ? AND `img_gds_cat_id` = ? AND NOT ig.`id` = ?
			ORDER BY RAND() LIMIT 3";
        $imgGdss = DBUtil::getResultRowsOfPrepatedQuery($query, "iii", $account_id, $img_gds_cat_id, $img_gds_id);
        return $imgGdss;
    }

    public static function countImgGdssByFilter($account_id, $filter) {
        $query = "SELECT COUNT(*) as cnt FROM img_gds AS ig JOIN img_currency AS ic ON currency_id = ic.id 
                            WHERE ig.img_account_id = ? ";

        if ($filter['cat']) {
            $query .= " AND ig.img_gds_cat_id = " . intval($filter['cat']);
        }
        $filter['pname'] = trim($filter['pname']);
        if (0 != strcmp("", $filter['pname'])) {
            $filter['pname'] = "%" . $filter['pname'] . "%";
            $query .= " AND ig.name LIKE ? ";
        }
        if ($filter['prfrom']) {
            $query .= " AND ig.price >= " . intval($filter['prfrom']);
        }
        if ($filter['prto']) {
            $query .= " AND ig.price <= " . intval($filter['prto']);
        }
        if ($filter['tosale']) {
            $query .= " AND ig.in_stock = 1 ";
        } else {
            $query .= " AND ig.in_stock = 0 ";
        }

        if (0 != strcmp("", $filter['pname'])) {
            $cntResults = DBUtil::getResultRowsOfPrepatedQuery($query, "is", $account_id, $filter['pname']);
        } else {
            $cntResults = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $account_id);
        }

        return $cntResults[0]['cnt'];
    }

    public static function getImgGdssByFilter($account_id, $filter, $start, $lenght) {
        $query = "SELECT ig.id AS ig_id,  UUID,  ig.name AS ig_name,  price,  currency_id, ic.name AS ic_name,  
                    main_pict_id,  img_account_id,  img_gds_cat_id,  add_date,  in_stock,  is_new,  is_recommended 
                    FROM img_gds AS ig JOIN img_currency AS ic ON currency_id = ic.id 
                    WHERE ig.img_account_id = ? ";

        if ($filter['cat']) {
            $query .= " AND ig.img_gds_cat_id = " . intval($filter['cat']);
        }
        $filter['pname'] = trim($filter['pname']);
        if (0 != strcmp("", $filter['pname'])) {
            $filter['pname'] = "%" . $filter['pname'] . "%";
            $query .= " AND ig.name LIKE ? ";
        }
        if ($filter['prfrom']) {
            $query .= " AND ig.price >= " . intval($filter['prfrom']);
        }
        if ($filter['prto']) {
            $query .= " AND ig.price <= " . intval($filter['prto']);
        }
        if ($filter['tosale']) {
            $query .= " AND ig.in_stock = 1 ";
        } else {
            $query .= " AND ig.in_stock = 0 ";
        }

        $query .= " ORDER BY add_date DESC LIMIT ?, ?";

        if (0 != strcmp("", $filter['pname'])) {
            $imgGdss = DBUtil::getResultRowsOfPrepatedQuery($query, "isii", $account_id, $filter['pname'], $start, $lenght);
        } else {
            $imgGdss = DBUtil::getResultRowsOfPrepatedQuery($query, "iii", $account_id, $start, $lenght);
        }

        return $imgGdss;
    }

    public static function getDescriptionOfImgGds($img_gds_id) {
        $query = "SELECT  `descr` FROM `img_gds` WHERE `id` = ?";
        $descrResults = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $img_gds_id);
        return $descrResults[0]['descr'];
    }

    public static function getBasketImgGds($img_gds_ids) {
        $query = "SELECT ig.id as ig_id, ig.main_pict_id as ig_main_pict_id, ig.name as ig_name, ig.UUID,  ig.price as ig_price, ic.name as ic_name, ia.id as ia_id,  ia.img_name as ia_img_name
                    FROM img_gds ig 
                    JOIN img_account ia ON ig.img_account_id = ia.id
                    JOIN img_currency ic ON ig.currency_id = ic.id ";

        if (NULL != $img_gds_ids) {
            $img_gds_ids_string = implode(", ", $img_gds_ids);
            $query .= " WHERE ig.id IN ($img_gds_ids_string) ";
        } else
            return NULL;

        $imgGdss = DBUtil::getResultRowsOfPrepatedQuery($query);
        return $imgGdss;
    }

    public static function getImgGdssForOrder($accountID, $orderID) {
        $query = "select igds.id, igds.name, igds.UUID, igds.main_pict_id, igds.price, 
                ic.name as price_name, ogds.count_gds from img_gds igds
                    join order_gds ogds on igds.id = ogds.img_gds_id
                    join `order` o on o.id = ogds.order_id
                    join img_currency ic on ic.id = igds.currency_id
                where o.id = ? and igds.img_account_id = ?";

        $imgGdss = DBUtil::getResultRowsOfPrepatedQuery($query, "ii", $orderID, $accountID);
        return $imgGdss;
    }

    public static function moveGDSs($old_cat, $new_cat) {
        if (NULL != $old_cat) {
            $query = "UPDATE `img_gds` SET `img_gds_cat_id` = ?  WHERE `img_gds_cat_id` = ?";
            DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ii", $new_cat, $old_cat);
        } else {
            $query = "UPDATE `img_gds` SET `img_gds_cat_id` = ?  WHERE `img_gds_cat_id` is NULL";
            DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $new_cat);
        }
    }

    public static function insertGDS($imgGds) {
        $query = "INSERT INTO `img_gds` (`UUID`, `name`, `price`, `currency_id`, `main_pict_id`, 
                `first_pict_id`, `second_pict_id`, `third_pict_id`, `img_account_id`, `img_gds_cat_id`, 
                `in_stock`, `is_new`, `is_recommended`, `descr`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        StringHelper::massiveSpecialChars($imgGds, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ssiiiiiiiiiiis", $imgGds['UUID'], $imgGds['name'], $imgGds['price'], $imgGds['currency_id'], $imgGds['main_pict_id'], $imgGds['first_pict_id'], $imgGds['second_pict_id'], $imgGds['third_pict_id'], $imgGds['img_account_id'], $imgGds['img_gds_cat_id'], $imgGds['in_stock'], $imgGds['is_new'], $imgGds['is_recommended'], $imgGds['descr']);
    }

    public static function updateGDS($imgGds) {
        $query = "UPDATE `img_gds` SET `UUID`=?, `name`=?, `price`=?, `currency_id`=?, `main_pict_id`=?, 
                    `first_pict_id`=?, `second_pict_id`=?, `third_pict_id`=?, `img_account_id`=?, `img_gds_cat_id`=?, 
                    `in_stock`=?, `is_new`=?, `is_recommended`=?, `descr`=?  WHERE `id`=?";

        StringHelper::massiveSpecialChars($imgGds, ENT_QUOTES);
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ssiiiiiiiiiiisi", $imgGds['UUID'], $imgGds['name'], $imgGds['price'], $imgGds['currency_id'], $imgGds['main_pict_id'], $imgGds['first_pict_id'], $imgGds['second_pict_id'], $imgGds['third_pict_id'], $imgGds['img_account_id'], $imgGds['img_gds_cat_id'], $imgGds['in_stock'], $imgGds['is_new'], $imgGds['is_recommended'], $imgGds['descr'], $imgGds['id']);
    }

    public static function deleteGDSById($imgGdsId) {
        $query = "DELETE FROM `img_gds` WHERE  `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $imgGdsId);
    }

    public static function getImgGdsSubCatIdsByImgGdsCatId($account_id, $img_gds_cat_id) {
        $imgGdsCats = ImgGdsCatUtil::getImgGdsCatsByAccountId($account_id);

        if (0 == count($imgGdsCats))
            return NULL;

        if (NULL == $img_gds_cat_id) {
            foreach ($imgGdsCats as $imgGdsCat) {
                $subCatIds[$imgGdsCat['id']] = $imgGdsCat['id'];
            }
        } else {
            $subCatIds = array();
            self::fillSubCatsId($img_gds_cat_id, $imgGdsCats, &$subCatIds);
        }

        return $subCatIds;
    }

    private static function fillSubCatsId($start_img_gds_cat_id, $imgGdsCats, $subCatIds) {
        $subCatIds[$start_img_gds_cat_id] = $start_img_gds_cat_id;

        foreach ($imgGdsCats as $imgGdsCat) {
            if ($start_img_gds_cat_id == $imgGdsCat['pid']) {
                self::fillSubCatsId($imgGdsCat['id'], $imgGdsCats, &$subCatIds);
            }
        }
    }

}
