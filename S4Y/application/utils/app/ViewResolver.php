<?php

/**
 *
 */
class ViewResolver {

    public static function resolveView($view_name, $params, $type = 'gen') {
        $path = dirname(__FILE__) . "/views/" . $view_name . ".php";
        if (file_exists($path)) {
            $view['gen'] = $type;
            $view['path'] = $path;
            $view['params'] = $params;
            return $view;
        } else {
            return NULL;
        }
    }

    public static function showView($view) {
        // По идее должны быть как показ страницы так и ajax
        if ('gen' == $view['gen']) {
            $params = $view['params'];
            require_once $view['path'];
        }
    }

}
