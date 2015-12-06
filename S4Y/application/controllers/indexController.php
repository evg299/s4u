<?php

require_once dirname(__FILE__) . "/../models/__DBMODEL__.php";
require_once dirname(__FILE__) . "/../utils/admin/LoginChecker.php";
require_once dirname(__FILE__) . "/../utils/other/CardCounter.php";
require_once dirname(__FILE__) . "/../utils/other/Hasher.php";
require_once dirname(__FILE__) . "/../utils/external/recaptchalib.php";
require_once dirname(__FILE__) . "/../utils/external/UUIDGenerator.php";
require_once dirname(__FILE__) . "/../utils/mail/MailWork.php";

/**
 * Description of indexController
 *
 * @author Evgeny
 */
class indexController {

    function indexAction() {
        $v_params['logined'] = LoginChecker::isLogined();
        $v_params['in_card_count'] = CardCounter::countGDSinCard();
        $v_params['mm']['main'] = TRUE;

        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        $v_params['addr_regions'] = AddrRegionUtil::getRegions();
        $v_params['sys_news_cats_HTML'] = SysNewsCatUtil::createTreeHTML("/" . SYS_BLOG_DIR . "?" . SYS_ART_CAT_PARAM_NAME . "=");

        Application::fastView('main/sys_main', $v_params);
    }

    function newsAction() {
        $v_params['logined'] = LoginChecker::isLogined();
        $v_params['in_card_count'] = CardCounter::countGDSinCard();

        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        $v_params['sys_news_cats_HTML'] = SysNewsCatUtil::createTreeHTML("/" . SYS_BLOG_DIR . "?" . SYS_ART_CAT_PARAM_NAME . "=");
        $newsCatId = $_REQUEST[SYS_ART_CAT_PARAM_NAME];
        $v_params['newsblog_breadcrump_HTML'] = SysNewsCatUtil::createBreadcrumpHTML($newsCatId);

        $v_params['sys_news_arts'] = SysNewsArtUtil::getSysNewsArtsBySysNewsCatId($newsCatId, ART_ON_PAGE * $_REQUEST[PAGE_PARAM_NAME], ART_ON_PAGE);
        $v_params['sys_news_link'] = "/" . SYS_ARTICLE_DIR . "?" . ART_PARAM_NAME . "=";

        $count_sys_news = SysNewsArtUtil::getCountOfSysNewsArtBySysNewsCatId($newsCatId);
        for ($i = 0; $i < $count_sys_news / ART_ON_PAGE; $i++) {
            $item['value'] = $i + 1;
            $item['current'] = ($i == $_REQUEST[PAGE_PARAM_NAME]);
            if ($newsCatId)
                $item['url'] = "/" . SYS_BLOG_DIR . "/?" . SYS_ART_CAT_PARAM_NAME . "=" . $newsCatId . "&" . PAGE_PARAM_NAME . "=" . $i;
            else
                $item['url'] = "/" . SYS_BLOG_DIR . "/?" . PAGE_PARAM_NAME . "=" . $i;

            $v_params['paginator'][] = $item;
        }

        Application::fastView('main/sys_blog', $v_params);
    }

    function articleAction() {
        $v_params['logined'] = LoginChecker::isLogined();
        $v_params['in_card_count'] = CardCounter::countGDSinCard();

        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        $sysNewsArtId = $_GET[SYS_ART_PARAM_NAME];
        $sysNewsArt = SysNewsArtUtil::getSysNewsArtById($sysNewsArtId);
        if (NULL != $sysNewsArt) {
            $v_params['sys_article'] = $sysNewsArt;
            $v_params['sys_news_cats_HTML'] = SysNewsCatUtil::createTreeHTML("/" . SYS_BLOG_DIR . "?" . SYS_ART_CAT_PARAM_NAME . "=");
            $v_params['newsblog_breadcrump_HTML'] = SysNewsCatUtil::createBreadcrumpHTML($sysNewsArt['sys_news_cat_id']);
            $v_params['sys_news_art_blocks'] = SysNewsArtBlockUtil::getSysNewsArtBlocksByArtId($sysNewsArtId);

            Application::fastView('main/sys_article', $v_params);
        } else {
            Application::fastView('main/sys_error', $v_params);
        }
    }

    function loginAction() {
        $v_params['login']['main'] = TRUE;
        if (!LoginChecker::isLogined()) {
            $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
            $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

            $resp = recaptcha_check_answer(RECAPCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
            if (isset($_POST['lfsp'])) {
                if ($resp->is_valid) {
                    $nch = TRUE;
                } else {
                    $v_params['messages'][] = "Защита от роботов введена не верно";
                }
            } else {
                $nch = TRUE;
            }

            if (isset($_POST['email']) && isset($_POST['password'])) {
                if ($nch && 0 != strcmp(trim($_POST['email']), "") && 0 != strcmp(trim($_POST['password']), "")) {
                    $imgAccount = ImgAccountUtil::getImgAccountByEmailAndHashPass($_POST['email'], Hasher::getHash($_POST['password']));

                    if (NULL != $imgAccount) {
                        $imgURL = "/" . IMAG_PREFIX . $imgAccount['id'];

                        $rndUUID = UUIDGenerator::generate();
                        setcookie("log", $imgAccount['id'] . "_" . $rndUUID);
                        $imgAccount['cookie_code'] = $rndUUID;
                        ImgAccountUtil::updateImgAccount($imgAccount);

                        header("Location: $imgURL");
                    } else {
                        $v_params['messages'][] = "Вы не правильно ввели данные для авторизации";
                    }
                } else {
                    $v_params['messages'][] = "Email и пароль обязательны для ввода";
                }
            }

            Application::fastView('main/sys_login', $v_params);
        } else {
            header("Location: /");
        }
    }

    function logoutAction() {
        $v_params['logout']['main'] = TRUE;
        setcookie("log", null, time() - 1);
        header("Location: /");
    }

    function fogotAction() {
        $v_params['logined'] = LoginChecker::isLogined();
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        $resp = recaptcha_check_answer(RECAPCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
        if (!$resp->is_valid && $_POST['fogot_form']) {
            $v_params['errors'][] = "Защита от роботов введена не верно";
        }

        if (0 == strcmp("", trim($_POST['email'])) && $_POST['fogot_form']) {
            $v_params['errors'][] = "Email обязателен для ввода";
        }

        $is_valid_email = preg_match("/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/", $_POST['email']);
        if (!$is_valid_email && $_POST['fogot_form']) {
            $v_params['errors'][] = "Email введен не верно";
        }

        if ($is_valid_email && $resp->is_valid && 0 != strcmp("", trim($_POST['email']))) {
            $email = $_POST['email'];
            $new_pass = UUIDGenerator::generate();
            // $new_pass = "123123";
            $imgAccount = ImgAccountUtil::getImgAccountByEmail($email);

            if (NULL != $imgAccount) {
                $imgAccount['hashpass'] = Hasher::getHash($new_pass);
                ImgAccountUtil::updateImgAccount($imgAccount);

                $mail_values['__root_url__'] = "http://" . $_SERVER["HTTP_HOST"];
                $mail_values['__stand_url__'] = "http://" . $_SERVER["HTTP_HOST"] . "/imag" . $imgAccount['id'];
                $mail_values['__stand_pwd__'] = $new_pass;
                MailWork::sendMailByTemplate($imgAccount['email'], "Восстановление доступа к аккаунту", "fogot.html", $mail_values);

                $v_params['message'] = "Пароль успешно изменен";
                $v_params['message_descr'] = "Проверьте свой почтовый ящик, там будет письмо с новым паролем к вашему аккаунту";
                Application::fastView('main/sys_message', $v_params);
                exit;
            } else {
                $v_params['errors'][] = "Такого аккаунта нет";
            }
        }

        Application::fastView('main/sys_fogot', $v_params);
    }

    function registrationAction() {
        $v_params['logined'] = LoginChecker::isLogined();
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        $v_params['reg']['main'] = TRUE;

        if (0 < count($_POST)) {
            // Передача формы
            $containErrors = FALSE;
            if (isset($_POST['email'])) {
                $email = $_POST['email'];
                if (0 == strcmp("", $email)) {
                    $v_params['errors'][] = "Email не может быть пустым";
                    $containErrors = TRUE;
                } else if (!preg_match("/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/", $email)) {
                    $v_params['errors'][] = "Скорее всего вы ввели email не правильно";
                    $containErrors = TRUE;
                } else {
                    $imgAccount = ImgAccountUtil::getImgAccountByEmail($email);
                    if ($imgAccount) {
                        $v_params['errors'][] = "Такой Email уже зарегистрирован";
                        $containErrors = TRUE;
                    }
                }
            }

            if (isset($_POST['password1'])) {
                $password1 = $_POST['password1'];
                if ("" == $password1) {
                    $v_params['errors'][] = "Пароль не может быть пустым <br/>";
                    $containErrors = TRUE;
                } else if (9 > strlen($password1)) {
                    $v_params['errors'][] = "Длина пароля должна быть от 9 символов";
                    $containErrors = TRUE;
                }
            }

            if (0 != strcmp($_POST['password1'], $_POST['password2'])) {
                $v_params['errors'][] = "Пароль и его подтверждение не совпадают";
                $containErrors = TRUE;
            }

            if (isset($_POST['name'])) {
                $name = $_POST['name'];
                if ("" == $name) {
                    $v_params['errors'][] = "Введите название торгового стенда (позднее вы сможете его изменить)";
                    $containErrors = TRUE;
                }
            }

            $resp = recaptcha_check_answer(RECAPCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
            if (!$resp->is_valid) {
                $v_params['errors'][] = "Защита от роботов введена не верно";
                $containErrors = TRUE;
            }

            // Обработка
            if ($containErrors) {
                // Есть ошибки
                $v_params['addr_regions'] = AddrRegionUtil::getRegions();
                Application::fastView('main/sys_registration', $v_params);
            } else {
                // Нет ошибок, создаем аккаунт
                $imgAccount['email'] = $_POST['email'];
                $imgAccount['hashpass'] = Hasher::getHash($_POST['password1']);
                $imgAccount['show_email'] = 0;
                $imgAccount['active'] = 0;
                $imgAccount['img_name'] = $_POST['name'];
                $imgAccount['img_slog'] = $_POST['slog'];

                if (isset($_POST['region']) && "" != $_POST['region']) {
                    $addrRegion = AddrRegionUtil::getRegionByCode($_POST['region']);
                    $imgAddress['region_id'] = $addrRegion['id'];
                }
                $imgAddressId = ImgAddressUtil::insertImgAddress($imgAddress);

                $imgAccount['img_address_id'] = $imgAddressId;
                $imgAccount['show_address'] = 1;

                $activation_code = UUIDGenerator::generate();
                $imgAccount['check_code'] = $activation_code;

                $imgAccountId = ImgAccountUtil::createImgAccount($imgAccount);


                $mail_values['__root_url__'] = "http://" . $_SERVER["HTTP_HOST"];
                $mail_values['__act_url__'] = "http://" . $_SERVER["HTTP_HOST"] . "/activation?imgID=" . $imgAccountId . "&acode=" . $activation_code;

                MailWork::sendMailByTemplate($imgAccount['email'], "Завершение регистрации на сайте " . $_SERVER["HTTP_HOST"], "end_reg.html", $mail_values);

                $v_params['message'] = "На указаный email выслано письмо с подтверждением регистрации";
                $v_params['message_descr'] = "Проверьте свой почтовый ящик, там будет письмо с сылкой для активации созданного аккаунта, после чего вы сможете работать со своим торговым стендом";
                Application::fastView('main/sys_message', $v_params);
            }
        } else {
            $v_params['addr_regions'] = AddrRegionUtil::getRegions();
            Application::fastView('main/sys_registration', $v_params);
        }
    }

    function activationAction() {
        $v_params['logined'] = LoginChecker::isLogined();
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (isset($_GET['imgID']) && isset($_GET['acode'])) {
            $imgID = $_GET['imgID'];
            $acode = $_GET['acode'];

            $imgAccount = ImgAccountUtil::getImgAccountById($imgID, FALSE);

            if (NULL != $imgAccount) {
                if ($imgAccount['check_code'] == $acode) {
                    $imgAccount['active'] = 1;
                    $imgAccount['check_code'] = NULL;
                    ImgAccountUtil::updateImgAccount($imgAccount);

                    $v_params['message'] = "Активация прошла успешно";
                    $v_params['message_descr'] = "Теперь вы можете войти в панель управления торговым стендом";
                    Application::fastView('main/sys_message', $v_params);
                    return;
                }
            }
        }
        $v_params['message'] = "Активация не выполнена";
        $v_params['message_descr'] = "Данные запроса не верны";
        Application::fastView('main/sys_message', $v_params);
    }

    function presentationAction() {
        $v_params['logined'] = LoginChecker::isLogined();
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        $v_params['prez']['main'] = TRUE;
        $v_params['in_card_count'] = CardCounter::countGDSinCard();

        $v_params['sys_news_cats_HTML'] = SysNewsCatUtil::createTreeHTML("/" . SYS_BLOG_DIR . "?" . SYS_ART_CAT_PARAM_NAME . "=");

        $v_params['sys_static_page'] = SysStaticPagesUtil::getSysStaticPageByName("presentation");
        $v_params['sys_static_page_blocks'] = SysStaticPageBlocksUtil::getSysStaticPageBlocksByPageId($v_params['sys_static_page']['id']);

        Application::fastView('main/sys_static_page', $v_params);
    }

    function faqAction() {
        $v_params['logined'] = LoginChecker::isLogined();
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        $v_params['faq']['main'] = TRUE;
        $v_params['in_card_count'] = CardCounter::countGDSinCard();

        $v_params['sys_news_cats_HTML'] = SysNewsCatUtil::createTreeHTML("/" . SYS_BLOG_DIR . "?" . SYS_ART_CAT_PARAM_NAME . "=");

        $v_params['sys_static_page'] = SysStaticPagesUtil::getSysStaticPageByName("faq");
        $v_params['sys_static_page_blocks'] = SysStaticPageBlocksUtil::getSysStaticPageBlocksByPageId($v_params['sys_static_page']['id']);

        Application::fastView('main/sys_static_page', $v_params);
    }

    function pictureAction() {
        $pictId = $_REQUEST[PICT_PARAM_NAME];
        $imgPicture = ImgPictureUtil::getImgPictureById($pictId);

        if (NULL != $imgPicture) {
            $name = $imgPicture['name'];
            if (NULL == $name)
                $name = "picture_" . $pictId;

            FilesWork::showImage($imgPicture['path'], $name);
        } else {
            FilesWork::showImage("/images/nophoto.png", "Фото отсутствует");
        }
    }

    function thumbPictureAction() {
        $pictId = $_REQUEST[PICT_PARAM_NAME];
        $imgPicture = ImgPictureUtil::getImgPictureById($pictId);

        if (NULL != $imgPicture) {
            $name = $imgPicture['name'];
            if (NULL == $name)
                $name = "picture_" . $pictId;

            $path_blocks = explode("/", $imgPicture['path']);
            $last = count($path_blocks) - 1;
            $path_blocks[$last] = SMAL_PICT_PREFIX . $path_blocks[$last];
            $path_small = implode("/", $path_blocks);

            FilesWork::showImage($path_small, $name);
        } else {
            FilesWork::showImage("/images/nophoto.png", "Фото отсутствует");
        }
    }

    function basketAction() {
        $v_params['logined'] = LoginChecker::isLogined();
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (0 == CardCounter::countGDSinCard()) {
            $v_params['message'] = "Корзина пуста";
            $v_params['message_descr'] = "У вас нет выбраных товаров в корзине";
            Application::fastView('main/sys_message', $v_params);
            exit;
        }

        foreach ($_COOKIE as $cookie_key => $cookie_value) {
            if (0 == strcmp("gds", substr($cookie_key, 0, 3))) {
                $img_gds_ids[] = intval(substr($cookie_key, 3));
            }
        }
        $v_params['img_gdss'] = ImgGdsUtil::getBasketImgGds($img_gds_ids);
        $v_params['img_link_prefix'] = "/" . IMAG_PREFIX;
        Application::fastView('main/sys_card', $v_params);
    }

    function orderAction() {
        $v_params['logined'] = LoginChecker::isLogined();
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        // Товары переданные в POST запросе
        foreach ($_POST as $req_key => $req_value) {
            if (0 == strcmp("gds", substr($req_key, 0, 3))) {
                $img_gds_id_post = (INT) substr($req_key, 3);
                $img_gds_ids_post[] = $img_gds_id_post;
                $img_gds_id_map_post[$img_gds_id_post] = (INT) $req_value;
            }
        }

        // Товары переданные в GET запросе
        foreach ($_GET as $req_key => $req_value) {
            if (0 == strcmp("gds", substr($req_key, 0, 3))) {
                $img_gds_id_get = (INT) substr($req_key, 3);
                $img_gds_ids_get[] = $img_gds_id_get;
                $img_gds_id_map_get[$img_gds_id_get] = (INT) $req_value;
            }
        }


        if (count($img_gds_id_map_get) && !count($img_gds_id_map_post)) {
            // Если есть только GET, значит переход от формы проверки корзины
            // рисуем просто форму заказа
            $v_params['img_gdss'] = ImgGdsUtil::getBasketImgGds($img_gds_ids_get);
            if (0 != count($v_params['img_gdss'])) {
                foreach ($v_params['img_gdss'] as $img_gds) {
                    $img_gds['count_in_basket'] = $img_gds_id_map_get[$img_gds['ig_id']];
                    $img_gds['price_all'] = $img_gds['count_in_basket'] * $img_gds['ig_price'];
                    $img_gds_temp[] = $img_gds;

                    $v_params['summ'][$img_gds['ic_name']] += $img_gds['price_all'];
                }
            }

            $v_params['img_gdss'] = $img_gds_temp;
            $v_params['img_link_prefix'] = "/" . IMAG_PREFIX;

            Application::fastView('main/sys_order', $v_params);
            exit;
        } else if (!count($img_gds_id_map_get) && count($img_gds_id_map_post)) {
            // если POST - была попытка оформить заказ
            if (!isset($_POST['u_email']) || 0 == strcmp("", trim($_POST['u_email']))) {
                $v_params['errors'][] = "Вы не ввели email, он нужен для того чтоб менеджер связался с вами.";
            }

            if (!preg_match("/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/", $_POST['u_email'])) {
                $v_params['errors'][] = "Скорее всего вы ввели email не правильно, попробуйте снова.";
            }

            $resp = recaptcha_check_answer(RECAPCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
            if ($resp->is_valid) {
                foreach ($img_gds_ids_post as $img_gds_id_post) {
                    setcookie("gds" . $img_gds_id_post, '', time() - 1);
                }

                if (count($img_gds_id_map_post)) {
                    $order['u_email'] = $_POST['u_email'];
                    $order['u_name'] = $_POST['u_name'];
                    $order['u_phone'] = $_POST['u_phone'];
                    $order['u_comment'] = $_POST['u_comment'];
                    $order_id = OrderUtil::insertOrder($order);

                    foreach ($img_gds_id_map_post as $img_gds_id => $img_gds_count) {
                        $order_gds['order_id'] = $order_id;
                        $order_gds['img_gds_id'] = $img_gds_id;
                        $order_gds['count_gds'] = $img_gds_count;
                        OrderGdsUtil::insertOrderGds($order_gds);
                    }

                    OrderAccountSendedUtil::insertOrderAccountRelation($order_id);
                    $orderAccs = OrderAccountSendedUtil::getOrderAccsToMailMessage($order_id);
                    foreach ($orderAccs as $orderAcc) {
                        // Рассылка писем для владельцев стендов
                        $mail_values['__root_url__'] = "http://" . $_SERVER["HTTP_HOST"];
                        $mail_values['__o_email__'] = $orderAcc['oemail'];
                        $mail_values['__o_url__'] = "http://" . $_SERVER["HTTP_HOST"] . "/imag" . $orderAcc['accid'] . "/admin/order?id=" . $orderAcc['oid'];
                        $mail_values['__o_num__'] = $orderAcc['oid'];
                        MailWork::sendMailByTemplate($orderAcc['accemail'], "Новый заказ - №" . $orderAcc['oid'], "new_order.html", $mail_values);
                    }

                    $v_params['order_sended'] = TRUE;
                }
            } else {
                $v_params['errors'][] = "Картинка подтверждения была введена не правильно. Попробуйте еще раз.";
            }

            $v_params['img_gdss'] = ImgGdsUtil::getBasketImgGds($img_gds_ids_post);
            if (0 != count($v_params['img_gdss'])) {
                foreach ($v_params['img_gdss'] as $img_gds) {
                    $img_gds['count_in_basket'] = $img_gds_id_map_post[$img_gds['ig_id']];
                    $img_gds['price_all'] = $img_gds['count_in_basket'] * $img_gds['ig_price'];
                    $img_gds_temp[] = $img_gds;

                    $v_params['summ'][$img_gds['ic_name']] += $img_gds['price_all'];
                }
            }

            $v_params['img_gdss'] = $img_gds_temp;
            $v_params['img_link_prefix'] = "/" . IMAG_PREFIX;

            if ($v_params['order_sended']) {
                $v_params['message'] = "Заказ отправлен";
                $v_params['message_descr'] = "Вскоре менеджеры торговых стендов с вами свяжутся по указанному email";
                Application::fastView('main/sys_message', $v_params);
            } else {
                Application::fastView('main/sys_order', $v_params);
                exit;
            }
        } else {
            $v_params['message'] = "Ошибка обработки заказа";
            $v_params['message_descr'] = "Переданные данные не верны, попробуйте снова";
            Application::fastView('main/sys_message', $v_params);
        }
    }

    function sitemapAction() {
        $v_params['logined'] = LoginChecker::isLogined();
        $v_params['smap']['main'] = TRUE;
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        $v_params['in_card_count'] = CardCounter::countGDSinCard();
        $v_params['sys_news_cats_HTML'] = SysNewsCatUtil::createTreeHTML("/" . SYS_BLOG_DIR . "?" . SYS_ART_CAT_PARAM_NAME . "=");

        if (0 != $_GET['code']) {
            $v_params['imags'] = TRUE;
            $region = AddrRegionUtil::getRegionByCode($_GET['code']);
            $v_params['title'] = "Список стендов для региона «" . $region['name'] . "»";
            $v_params['accounts'] = ImgAccountUtil::getImgAccountsByRegionCode($region['code'], TRUE);
        } else {
            $v_params['imags'] = FALSE;
            $v_params['title'] = "Список регионов";
            $v_params['regions'] = AddrRegionUtil::getRegions();
        }

        Application::fastView('main/sys_site_map', $v_params);
    }

    /*
     function checkMailAction() {
        if ($_POST['email'] && $_POST['content']) {
            $headers = "Content-type: text/html; charset=utf8";

            $ok = mail($_POST['email'], "Тестовое сообщение", trim($_POST['content']), $headers);
            echo "<h3>Отправлено = $ok</h3><br />";
        }


        echo "
            <html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'></head><body>
            <form method='POST'>
            <input type='text' name='email' value='" . $_POST['email'] . "'/>
            <br />
            <textarea name='content'>" . $_POST['content'] . "</textarea>
            <br />
            <input type='submit' />
            </form></body></html>";
    }
    */

}
