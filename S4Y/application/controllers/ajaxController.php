<?php

require_once dirname(__FILE__) . "/../models/__DBMODEL__.php";

class ajaxController {

    function checkFormAction() {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if ("" == $email) {
                $data['errors'][] = "Email не может быть пустым";
            } else if (!preg_match("/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/", $email)) {
                $data['errors'][] = "Email введен неверно <br/>";
            } else {
                $imgAccount = ImgAccountUtil::getImgAccountByEmail($email);
                if ($imgAccount) {
                    $data['errors'][] = "Такой Email уже зарегистрирован";
                }
            }
        }

        if (isset($_POST['password1'])) {
            $password1 = $_POST['password1'];
            if ("" == $password1) {
                $data['errors'][] = "Пароль не может быть пустым <br/>";
            } else if (9 > strlen($password1)) {
                $data['errors'][] = "Длина пароля должна быть от 9 символов";
            }
        }

        if (0 != strcmp($_POST['password1'], $_POST['password2'])) {
            $data['errors'][] = "Пароль и его подтверждение не совпадают";
        }

        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            if ("" == $name) {
                $data['errors'][] = "Введите название торгового стенда, позднее вы сможете его изменить";
            }
        }

        echo json_encode($data);
    }

}