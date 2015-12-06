<?php

require_once dirname(__FILE__) . "/../config/DB.php";

/**
 *
 */
class DBUtil {

    public static function getMysqlConnection() {
        if (!$link = mysql_connect(DBHOST, DBUSER, DBPASS)) {
            printf("Ошибка подключения: %s\n", mysql_error());
            exit();
        }

        if (!mysql_select_db(DBNAME, $link)) {
            echo "Не удалось выбрать базу данных";
            exit();
        }

        if (mysql_set_charset("utf8")) {
            return $link;
        }
    }

    public static function getMysqliConnection() {
        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if (mysqli_connect_errno()) {
            printf("Ошибка подключения: %s\n", mysqli_connect_error());
            exit();
        }

        if (mysqli_set_charset($mysqli, "utf8")) {
            return $mysqli;
        }
    }

    public static function closeMysqlConnection($link) {
        mysql_close($link);
    }

    public static function closeMysqliConnection($mysqli) {
        $mysqli->close();
    }

    public static function getLastInsertedIdOfPrepatedQuery() {
        $args = func_get_args();
        $sql = array_shift($args);
        $mysqli = self::getMysqliConnection();
        if ($query = $mysqli->prepare($sql)) {
            if (count($args)) {
                foreach ($args as &$v) {
                    $v = &$v;
                }
                call_user_func_array(array($query, 'bind_param'), self::refValues($args));
            }

            $query->execute();
            $LIID = $mysqli->insert_id;
            $query->close();
        }
        DBUtil::closeMysqliConnection($mysqli);
        return $LIID;
    }

    public static function getResultRowsOfPrepatedQuery() {
        $args = func_get_args();
        $sql = array_shift($args);
        $mysqli = self::getMysqliConnection();
        if ($query = $mysqli->prepare($sql)) {
            if (count($args)) {
                foreach ($args as &$v) {
                    $v = &$v;
                }
                call_user_func_array(array($query, 'bind_param'), self::refValues($args));
            }

            $query->execute();

            $meta = $query->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }

            call_user_func_array(array($query, 'bind_result'), self::refValues($params));

            while ($query->fetch()) {
                $temp = array();
                foreach ($row as $key => $val) {
                    $temp[$key] = $val;
                }
                $result[] = $temp;
            }

            $meta->free();
            $query->close();
        }
        DBUtil::closeMysqliConnection($mysqli);
        return $result;
    }

    /*     * ******************** */

    public static function refValues($arr) {
        //Reference is required for PHP 5.3+ 
        if (strnatcmp(phpversion(), '5.3') >= 0) {
            $refs = array();
            foreach ($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }

    public static function build_tree($cats, $parent_id, $link_href_pref) {
        if (is_array($cats) and count($cats[$parent_id]) > 0) {
            $tree = '<ul>';

            foreach ($cats[$parent_id] as $cat) {
                if (NULL == $link_href_pref) {
                    $f1 = '<li>';
                    $f2 = '';
                    $f3 = '</li>';
                } else {
                    $f1 = '<li><a href="' . $link_href_pref . $cat['id'] . '">';
                    $f2 = '</a>';
                    $f3 = '</li>';
                }

                $tree .= $f1 . $cat['name'] . $f2;
                $tree .= self::build_tree($cats, $cat['id'], $link_href_pref);
                $tree .= $f3;
            }

            $tree .= '</ul>';
        } else
            return null;

        return $tree;
    }

}