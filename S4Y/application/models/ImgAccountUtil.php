<?php

require_once 'DBUtil.php';

/**
 * Description of ImgAccountUtil
 *
 * @author Evgeny
 */
class ImgAccountUtil {

    public static function getImgAccountsByRegionCode($region_code, $onlyActive) {
        $query = "SELECT  iac.`id`, `email`,  `hashpass`,  `show_email`,  `check_code`,  `active`,  `cookie_code`,  
				`img_name`,  `img_slog`,  `img_phone`,  `show_phone`,  `img_skype`,  `show_skype`,  
				`img_icq`,  `show_icq`,  `img_address_id`,  `show_address` 
				FROM `img_account` AS iac 
				JOIN `img_address` AS iad ON iad.id = iac.img_address_id
				JOIN `addr_region` AS ar ON ar.id = iad.region_id
				WHERE ar.code = ? ";
        if ($onlyActive) {
            $query .= " AND NOT `active` = 0";
        }

        $imgAccounts = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $region_code);
        return $imgAccounts;
    }

    public static function getImgAccountsNoRegionCode($onlyActive) {
        $query = "SELECT  iac.`id`, `email`,  `hashpass`,  `show_email`,  `check_code`,  `active`,  `cookie_code`,  
				`img_name`,  `img_slog`,  `img_phone`,  `show_phone`,  `img_skype`,  `show_skype`,  
				`img_icq`,  `show_icq`,  `img_address_id`,  `show_address` 
				FROM `img_account` AS iac 
				JOIN `img_address` AS iad ON iad.id = iac.img_address_id
				WHERE iad.region_id is NULL";
        if ($onlyActive) {
            $query .= " AND NOT `active` = 0";
        }

        $imgAccounts = DBUtil::getResultRowsOfPrepatedQuery($query);
        return $imgAccounts;
    }

    public static function getImgAccountById($id, $onlyActive) {
        $query = "SELECT  `id`, `email`,  `hashpass`,  `show_email`,  `check_code`,  `active`,  `cookie_code`,  
				`img_name`,  `img_slog`,  `img_phone`,  `show_phone`,  `img_skype`,  `show_skype`,  
				`img_icq`,  `show_icq`,  `img_address_id`,  `show_address` 
				FROM `img_account` WHERE `id` = ? ";
        if ($onlyActive) {
            $query .= " AND NOT `active` = 0";
        }

        $imgAccounts = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $id);
        return $imgAccounts[0];
    }

    public static function getRandomNImgAccounts($n) {
        $query = "SELECT `id`, `email`,  `hashpass`,  `show_email`,  `check_code`,  `active`,  `cookie_code`,  
			 `img_name`,  `img_slog`,  `img_phone`,  `show_phone`,  `img_skype`,  `show_skype`,  
			 `img_icq`,  `show_icq`,  `img_address_id`,  `show_address` 
			 FROM `img_account` WHERE NOT `active` = 0 ORDER BY RAND() LIMIT ?";

        $imgAccounts = DBUtil::getResultRowsOfPrepatedQuery($query, "i", $n);
        return $imgAccounts[0];
    }

    public static function getImgAccountByEmail($email) {
        $query = "SELECT  `id`, `email`,  `hashpass`,  `show_email`,  `check_code`,  `active`,  `cookie_code`,  
				`img_name`,  `img_slog`,  `img_phone`,  `show_phone`,  `img_skype`,  `show_skype`,  
				`img_icq`,  `show_icq`,  `img_address_id`,  `show_address` 
				FROM `img_account` WHERE `email` = ?";

        $imgAccounts = DBUtil::getResultRowsOfPrepatedQuery($query, "s", $email);
        return $imgAccounts[0];
    }

    public static function getImgAccountByEmailAndHashPass($email, $hashpass) {
        $query = "SELECT  `id`, `email`,  `hashpass`,  `show_email`,  `check_code`,  `active`,  `cookie_code`,  
				`img_name`,  `img_slog`,  `img_phone`,  `show_phone`,  `img_skype`,  `show_skype`,  
				`img_icq`,  `show_icq`,  `img_address_id`,  `show_address` 
				FROM `img_account` WHERE `email` = ? AND `hashpass` = ? AND NOT `active` = 0";

        $imgAccounts = DBUtil::getResultRowsOfPrepatedQuery($query, "ss", $email, $hashpass);
        return $imgAccounts[0];
    }

    public static function createImgAccount($imgAccount) {
        $query = "INSERT INTO `img_account` (`email`,  `hashpass`,  `show_email`,  `check_code`,  `active`,  `cookie_code`,  
				`img_name`,  `img_slog`,  `img_phone`,  `show_phone`,  `img_skype`,  `show_skype`,  
				`img_icq`,  `show_icq`,  `img_address_id`,  `show_address`) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        StringHelper::massiveSpecialChars($imgAccount, ENT_QUOTES);
        return DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ssisissssisisiii", $imgAccount['email'], $imgAccount['hashpass'], $imgAccount['show_email'], $imgAccount['check_code'], $imgAccount['active'], $imgAccount['cookie_code'], $imgAccount['img_name'], $imgAccount['img_slog'], $imgAccount['img_phone'], $imgAccount['show_phone'], $imgAccount['img_skype'], $imgAccount['show_skype'], $imgAccount['img_icq'], $imgAccount['show_icq'], $imgAccount['img_address_id'], $imgAccount['show_address']);
    }

    public static function updateImgAccount($imgAccount) {
        $query = "UPDATE `img_account` SET `email` = ?,  `hashpass` = ?,  `show_email` = ?,  `check_code` = ?,  `active` = ?,  
            `cookie_code` = ?,  `img_name` = ?,  `img_slog` = ?,  `img_phone` = ?,  `show_phone` = ?,  `img_skype` = ?,  
            `show_skype` = ?,  `img_icq` = ?,  `show_icq` = ?,  `img_address_id` = ?,  `show_address` = ? WHERE `id` = ?";

        StringHelper::massiveSpecialChars($imgAccount, ENT_QUOTES);
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "ssisissssisisiiii", $imgAccount['email'], $imgAccount['hashpass'], $imgAccount['show_email'], $imgAccount['check_code'], $imgAccount['active'], $imgAccount['cookie_code'], $imgAccount['img_name'], $imgAccount['img_slog'], $imgAccount['img_phone'], $imgAccount['show_phone'], $imgAccount['img_skype'], $imgAccount['show_skype'], $imgAccount['img_icq'], $imgAccount['show_icq'], $imgAccount['img_address_id'], $imgAccount['show_address'], $imgAccount['id']);
    }

    public static function deleteImgAccountById($imgAccountId) {
        $query = "DELETE FROM `img_account` WHERE  `id` = ?";
        DBUtil::getLastInsertedIdOfPrepatedQuery($query, "i", $imgAccountId);
    }

}

