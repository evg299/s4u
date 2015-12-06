<?php

/**
 *
 */
class AddressUtil {

    public static function makeAddressString($imgAddress) {
        if ($imgAddress['rname'])
            $address_parts[] = $imgAddress['rname'];

        // исключаем Москву или Питер
        if (!(33 == $imgAddress['region_id'] || 27 == $imgAddress['region_id'])) {
            if ($imgAddress['sity'])
                $address_parts[] = $imgAddress['sity'];
        }
        if ($imgAddress['street'])
            $address_parts[] = $imgAddress['street'];

        if ($imgAddress['house'])
            $address_parts[] = $imgAddress['house'];

        if (count($address_parts))
            return implode(", ", $address_parts);
    }

}
