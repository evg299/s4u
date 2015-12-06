<?php

require_once 'DBUtil.php';

/**
 * Description of ImgCurrencyUtil
 *
 * @author Evgeny
 */
class ImgCurrencyUtil {

    public static function getImgCurrencies() {
        $query = "SELECT  `id`,  `name`,  `weight` FROM  `img_currency`";
        $imgCurrencies = DBUtil::getResultRowsOfPrepatedQuery($query);
        return $imgCurrencies;
    }

}
