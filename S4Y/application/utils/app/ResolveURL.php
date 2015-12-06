<?php

/**
 *
 */
class ResolveURL {

    public static function resolveControllerIMAG($redirect_url) {
        $urlpath = explode('/', $redirect_url);
        $urlpath = ResolveURL::refactorURLPath($urlpath);
        $lenght = count($urlpath);

        if (0 < $lenght) {
            $imag_id = self::checkIMAG($urlpath[0]);
            if (NULL != $imag_id) {
                unset($urlpath[0]);

                $act_contr = self::resolveControllerByURLPath($urlpath);
                $act_contr['controller'] = "__imags__/" . $act_contr['controller'];
            } else {
                $act_contr = self::resolveControllerByURLPath($urlpath);
            }
        } else {
            $action = DEFAULT_ACTION_NAME . ACTION_NAME_SUFFIX;
            $controller = DEFAULT_CONTROLLER_NAME;
            $act_contr = array('action' => $action, 'controller' => $controller);
            return array('act_contr' => $act_contr, 'imag_id' => $imag_id);
        }

        return array('act_contr' => $act_contr, 'imag_id' => $imag_id);
    }

    private static function checkIMAG($imag_id) {
        if (preg_match("/^" . IMAG_PREFIX . "\d+$/i", $imag_id)) {
            return (int) substr($imag_id, strlen(IMAG_PREFIX));
        } else
            return NULL;
    }

    public static function checkControllerExist($controller_name) {
        $controller_file = $this->getControllerFile($controller_name);
        $parts = explode('/', $controller_name);
        $className = $parts[count($parts) - 1] . CONTROLLER_NAME_SUFFIX;
        return file_exists($controller_file);
    }

    public static function getControllerFile($controller_name) {
        return dirname(__FILE__) . '/../../controllers/' . $controller_name . CONTROLLER_NAME_SUFFIX . '.php';
    }

    public static function resolveController($redirect_url) {
        $urlpath = explode('/', $redirect_url);
        $urlpath = ResolveURL::refactorURLPath($urlpath);

        return self::resolveControllerByURLPath($urlpath);
    }

    public static function resolveControllerByURLPath($urlpath) {
        $urlpath = array_values($urlpath);
        $lenght = count($urlpath);
        if ("" == $urlpath[$lenght - 1]) {
            unset($urlpath[$lenght - 1]);
        }
        $lenght = count($urlpath);

        /* echo "<pre>";
          var_dump($urlpath);
          echo "</pre>"; */

        if (1 < $lenght) {
            $action = $urlpath[$lenght - 1];
            if ("" == $action) {
                $action = DEFAULT_ACTION_NAME . ACTION_NAME_SUFFIX;
            } else {
                $action .= ACTION_NAME_SUFFIX;
            }
            unset($urlpath[$lenght - 1]);
            $controller = implode('/', $urlpath);
        } else if (1 == $lenght) {
            $action = $urlpath[0];
            if ("" == $action) {
                $action = DEFAULT_ACTION_NAME . ACTION_NAME_SUFFIX;
            } else {
                $action = $urlpath[0] . ACTION_NAME_SUFFIX;
            }
            $controller = DEFAULT_CONTROLLER_NAME;
        } else {
            $action = DEFAULT_ACTION_NAME . ACTION_NAME_SUFFIX;
            $controller = DEFAULT_CONTROLLER_NAME;
        }

        return array('action' => $action, 'controller' => $controller);
    }

    private static function refactorURLPath($urlpath) {
        foreach ($urlpath as $key => $item) {
            if ("" == $item && 0 == $key) {
                continue;
            }
            $newurlpath[] = $item;
        }
        return $newurlpath;
    }

    public static function controllerClassName($controller_name) {
        $parts = explode('/', $controller_name);
        $lenght = count($parts);
        return $parts[$lenght - 1] . CONTROLLER_NAME_SUFFIX;
    }

}
