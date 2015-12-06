<?php

/**
 * Description of CardCounter
 *
 * @author Evgeny
 */
class CardCounter {

    public static function countGDSinCard() {
        foreach ($_COOKIE as $req_key => $req_value) {
            if (0 == strcmp("gds", substr($req_key, 0, 3))) {
                $img_gds_ids[] = intval(substr($req_key, 3));
            }
        }

        return count($img_gds_ids);
    }

}
