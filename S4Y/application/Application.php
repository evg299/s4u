<?php

require_once dirname(__FILE__) . '/utils/main/StringHelper.php';
require_once dirname(__FILE__) . "/models/__DBMODEL__.php";
require_once dirname(__FILE__) . '/utils/app/ResolveURL.php';
require_once dirname(__FILE__) . '/utils/app/FilesWork.php';

require_once dirname(__FILE__) . '/config/__ALLCONFIG__.php';

class Application {

    public function serve($redirect_url) {
        $aci = ResolveURL::resolveControllerIMAG($redirect_url);

        $action_controller = $aci['act_contr'];
        $_SESSION['imag_id'] = $aci['imag_id'];
        $controllerClass = ResolveURL::controllerClassName($action_controller['controller']);
        $controllerFile = ResolveURL::getControllerFile($action_controller['controller']);

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $callController = new $controllerClass;
            $action = $action_controller['action'];
            if (method_exists($callController, $action)) {
                $callController->$action();
            } else {
                $this->handleError();
            }
        } else {
            $this->handleError();
        }
    }

    // запрашиваемого класса или метода нет
    private function handleError() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        self::fastView('main/sys_error', $v_params);
    }

    // Статика
    public static function fastView($view_name, $v_params) {
        $path = dirname(__FILE__) . "/views/" . $view_name . ".php";
        if (file_exists($path)) {
            require_once $path;
        }
    }

}
