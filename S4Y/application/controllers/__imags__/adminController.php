<?php

require_once dirname(__FILE__) . "/../../models/__DBMODEL__.php";
require_once dirname(__FILE__) . "/../../utils/view/AddressUtil.php";
require_once dirname(__FILE__) . "/../../utils/admin/LoginChecker.php";
require_once dirname(__FILE__) . "/../../utils/other/CardCounter.php";
require_once dirname(__FILE__) . "/../../utils/other/Hasher.php";
require_once dirname(__FILE__) . "/../../utils/admin/ImageUtil.php";
require_once dirname(__FILE__) . "/../../utils/external/UUIDGenerator.php";
require_once dirname(__FILE__) . "/../../utils/other/Splitter.php";

/**
 * Description of adminController
 *
 * @author Evgeny
 */
class adminController {

    function settingsAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
                $imgAddress = ImgAddressUtil::getImgAddressById($imgAccount['img_address_id']);

                // Данные аккаунта
                if (isset($_REQUEST['name_form'])) {
                    if (isset($_REQUEST['img_name'])) {
                        $imgAccount['img_name'] = trim($_REQUEST['img_name']);
                    }

                    if (isset($_REQUEST['img_slog'])) {
                        $imgAccount['img_slog'] = trim($_REQUEST['img_slog']);
                    }

                    // Сохраняем изменения
                    ImgAccountUtil::updateImgAccount($imgAccount);
                    $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
                    $v_params['result_text'] = "Название и слоган торгового стенда успешно изменены";
                }


                // Контактная информация
                if (isset($_REQUEST['contacts_form'])) {
                    // Данные адреса
                    if (isset($_REQUEST['addr_region'])) {
                        $addr_region_code = intval($_REQUEST['addr_region']);
                        $addr_region = AddrRegionUtil::getRegionByCode($addr_region_code);
                        $imgAddress['region_id'] = $addr_region['id'];
                    }

                    if (isset($_REQUEST['addr_city'])) {
                        $imgAddress['sity'] = $_REQUEST['addr_city'];
                    }

                    if (isset($_REQUEST['addr_street'])) {
                        $imgAddress['street'] = $_REQUEST['addr_street'];
                    }

                    if (isset($_REQUEST['addr_house'])) {
                        $imgAddress['house'] = $_REQUEST['addr_house'];
                    }

                    if (isset($_REQUEST['contacts_form'])) {
                        if (0 == strcmp("on", $_REQUEST['addr_show']))
                            $imgAccount['show_address'] = 1;
                        else
                            $imgAccount['show_address'] = 0;
                    }

                    // Данные телефона
                    if (isset($_REQUEST['phone_phone'])) {
                        $imgAccount['img_phone'] = $_REQUEST['phone_phone'];
                    }

                    if (isset($_REQUEST['contacts_form'])) {
                        if (0 == strcmp("on", $_REQUEST['phone_show']))
                            $imgAccount['show_phone'] = 1;
                        else
                            $imgAccount['show_phone'] = 0;
                    }

                    // Данные скайпа
                    if (isset($_REQUEST['skype_skype'])) {
                        $imgAccount['img_skype'] = $_REQUEST['skype_skype'];
                    }

                    if (isset($_REQUEST['contacts_form'])) {
                        if (0 == strcmp("on", $_REQUEST['skype_show']))
                            $imgAccount['show_skype'] = 1;
                        else
                            $imgAccount['show_skype'] = 0;
                    }

                    // Данные ICQ
                    if (isset($_REQUEST['icq_icq'])) {
                        $imgAccount['img_icq'] = $_REQUEST['icq_icq'];
                    }

                    if (isset($_REQUEST['contacts_form'])) {
                        if (0 == strcmp("on", $_REQUEST['icq_show']))
                            $imgAccount['show_icq'] = 1;
                        else
                            $imgAccount['show_icq'] = 0;
                    }

                    // Сохраняем изменения
                    ImgAddressUtil::updateImgAddress($imgAddress);
                    ImgAccountUtil::updateImgAccount($imgAccount);
                    $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
                    $imgAddress = ImgAddressUtil::getImgAddressById($imgAccount['img_address_id']);
                    $v_params['result_text'] = "Контактная информация успешно изменена";
                }


                // Форма смены пароля
                if (isset($_REQUEST['pass_form'])) {
                    $old_pass = $_REQUEST['pass_old'];
                    $new_pass = $_REQUEST['pass_new'];
                    $new_pass2 = $_REQUEST['pass_new2'];

                    if (0 == strcmp("", $old_pass)) {
                        $v_params['errors'][] = "Текущий пароль обязателен для ввода";
                    } else if (0 != strcmp($imgAccount['hashpass'], Hasher::getHash($old_pass))) {
                        $v_params['errors'][] = "Текущий пароль введен не верно";
                    }

                    if (0 == strcmp("", $new_pass)) {
                        $v_params['errors'][] = "Новый пароль обязателен для ввода";
                    } else if (9 > strlen($new_pass)) {
                        $v_params['errors'][] = "Новый пароль должен быть длиной от 9 символов";
                    }

                    if (0 == strcmp("", $new_pass2)) {
                        $v_params['errors'][] = "Повторите новый пароль";
                    } else if (0 != strcmp($new_pass, $new_pass2)) {
                        $v_params['errors'][] = "Новый пароль и его повторение не совпадают";
                    }

                    if (!count($v_params['errors'])) {
                        $imgAccount['hashpass'] = Hasher::getHash($new_pass);
                        // Сохраняем изменения
                        ImgAccountUtil::updateImgAccount($imgAccount);
                        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
                        $v_params['result_text'] = "Пароль успешно изменен";
                    }
                }

                // Данные аккаунта
                $v_params['img_name'] = $imgAccount['img_name'];
                $v_params['img_slog'] = $imgAccount['img_slog'];

                // Данные адреса
                $v_params['img_region_code'] = $imgAddress['rcode'];
                $v_params['img_sity'] = $imgAddress['sity'];
                $v_params['img_street'] = $imgAddress['street'];
                $v_params['img_house'] = $imgAddress['house'];
                $v_params['img_address_show'] = $imgAccount['show_address'];

                if (77 == $v_params['img_region_code'] || 78 == $v_params['img_region_code']) {
                    $v_params['img_sity_disabled'] = TRUE;
                }

                // Данные телефона
                $v_params['img_phone'] = $imgAccount['img_phone'];
                $v_params['img_phone_show'] = $imgAccount['show_phone'];

                // Данные скайпа
                $v_params['img_skype'] = $imgAccount['img_skype'];
                $v_params['img_skype_show'] = $imgAccount['show_skype'];

                // Данные ICQ
                $v_params['img_icq'] = $imgAccount['img_icq'];
                $v_params['img_icq_show'] = $imgAccount['show_icq'];



                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");
                $v_params['addr_regions'] = AddrRegionUtil::getRegions();

                Application::fastView('imag-admin/img_admin_settings', $v_params);
                return;
            } else {
                
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function albumsAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['img_name'] = $imgAccount['img_name'];
                $v_params['mysc']['main'] = TRUE;

                $v_params['img_albums'] = ImgAlbumUtil::getImgAlbumsByAccountID($imgAccount['id']);
                $v_params['url_prefix'] = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/";

                $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                Application::fastView('imag-admin/albums/img_admin_albums', $v_params);
                return;
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function albumAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['img_name'] = $imgAccount['img_name'];
                $v_params['mysc']['main'] = TRUE;

                $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                if (isset($_GET['act'])) {
                    $action = $_GET['act'];

                    if (0 == strcmp("add", $action)) {
                        // Создать новый альбом
                        $v_params['action_name'] = "Создать альбом";
                        if (isset($_POST['img_album_name'])) {
                            $img_album_name = trim($_POST['img_album_name']);
                            if (0 == strcmp("", $img_album_name)) {
                                $v_params['messages'][] = "Имя альбома не может быть пустым";
                            } else {
                                $imgAlbum['account_id'] = $imgAccount['id'];
                                $imgAlbum['name'] = $img_album_name;
                                $imgAlbum['description'] = $_POST['img_album_desc'];

                                ImgAlbumUtil::insertImgAlbum($imgAlbum);
                                $albumsURL = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/albums";
                                header("Location: $albumsURL");
                            }
                        }
                        Application::fastView('imag-admin/albums/img_admin_album_au', $v_params);
                        exit;
                    } else if (0 == strcmp("upd", $action)) {
                        // Переименовать альбом
                        $v_params['action_name'] = "Переименовать альбом";
                        if (isset($_GET['alb_id'])) {
                            $imgAlbumId = $_GET['alb_id'];
                            $imgAlbum = ImgAlbumUtil::getImgAlbumByID($imgAlbumId, $imgAccount['id']);
                            if (NULL != $imgAlbum) {
                                $v_params['img_album_name'] = $imgAlbum['name'];
                                $v_params['img_album_desc'] = $imgAlbum['description'];
                            }
                        } else {
                            $albumsURL = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/albums";
                            header("Location: $albumsURL");
                        }

                        if (isset($_POST['img_album_name'])) {
                            $img_album_name = trim($_POST['img_album_name']);
                            if (0 == strcmp("", $img_album_name)) {
                                $v_params['messages'][] = "Имя альбома не может быть пустым";
                            } else {
                                $imgAlbum['id'] = $imgAlbumId;
                                $imgAlbum['account_id'] = $imgAccount['id'];
                                $imgAlbum['name'] = $img_album_name;
                                $imgAlbum['description'] = $_POST['img_album_desc'];

                                ImgAlbumUtil::updateImgAlbum($imgAlbum);
                                $albumsURL = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/albums";
                                header("Location: $albumsURL");
                            }
                        }
                        Application::fastView('imag-admin/albums/img_admin_album_au', $v_params);
                        exit;
                    } else if (0 == strcmp("del", $action)) {
                        // Удалить альбом
                        $v_params['action_name'] = "Удалить альбом";

                        if (isset($_GET['alb_id'])) {
                            $imgAlbumId = $_GET['alb_id'];
                            $imgAlbum = ImgAlbumUtil::getImgAlbumByID($imgAlbumId, $imgAccount['id']);
                            if (NULL != $imgAlbum) {
                                $v_params['img_album_name'] = $imgAlbum['name'];
                                $v_params['img_album_desc'] = $imgAlbum['description'];
                                $v_params['img_album_pict_count'] = ImgPictureUtil::countImgPicturesByAlbumId($imgAlbumId);
                            }
                        } else {
                            $albumsURL = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/albums";
                            header("Location: $albumsURL");
                        }

                        if ($_POST['album_del_form']) {
                            if ($_POST['with_pict']) {
                                $img_pictures = ImgPictureUtil::getImgPicturesByAlbumId($imgAlbumId, $imgAccount['id']);
                                if (count($img_pictures))
                                    foreach ($img_pictures as $img_pucture) {
                                        $file_path = dirname(__FILE__) . "/../../../application_data" . $img_pucture['path'];
                                        unlink($file_path);

                                        $path_blocks = explode("/", $img_pucture['path']);
                                        $last = count($path_blocks) - 1;
                                        $path_blocks[$last] = SMAL_PICT_PREFIX . $path_blocks[$last];
                                        $path_small = implode("/", $path_blocks);

                                        $smal_file_path = dirname(__FILE__) . "/../../../application_data" . $path_small;
                                        unlink($smal_file_path);
                                    }
                                ImgAlbumUtil::deleteImgAlbumByID($imgAlbumId, TRUE);
                            } else {
                                ImgAlbumUtil::deleteImgAlbumByID($imgAlbumId, FALSE);
                            }
                            $albumsURL = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/albums";
                            header("Location: $albumsURL");
                        } else {
                            Application::fastView('imag-admin/albums/img_admin_album_del', $v_params);
                            exit;
                        }
                    } else if (0 == strcmp("show", $action)) {
                        // Показать содержимое
                        $v_params['action_name'] = "Содержимое альбома";
                        $alb_id = $_GET['alb_id'];
                        $v_params['pict_control_url'] = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/picture";
                        $v_params['img_album'] = ImgAlbumUtil::getImgAlbumByID($alb_id, $imgAccount['id']);
                        if (NULL == $v_params['img_album']) {
                            $v_params['img_album_name'] = "Картинки без альбома";
                        } else {
                            $v_params['img_album_name'] = $v_params['img_album']['name'];
                        }

                        // Загрузка файлов
                        if ((NULL != $alb_id && NULL != $v_params['img_album']) || NULL == $alb_id) {
                            if (isset($_FILES) && NULL != $_FILES['file']) {
                                // директория для изображений
                                $images_dir = dirname(__FILE__) . "/../../../application_data/images/";
                                foreach ($_FILES['file']['name'] as $k => $f) {
                                    if (!$_FILES['file']['error'][$k]) {
                                        if (is_uploaded_file($_FILES['file']['tmp_name'][$k])) {
                                            $fn = UUIDGenerator::generate();
                                            $dir_path = $images_dir . "acc" . $imgAccount['id'] . "/";
                                            $file_path = $dir_path . $fn;
                                            $rel_file_path = "/images/acc" . $imgAccount['id'] . "/" . $fn;

                                            @mkdir($dir_path, 0766);

                                            @ImageUtil::create_small($_FILES['file']['tmp_name'][$k], $file_path, SIZE_BIG_PICT, SIZE_BIG_PICT);
                                            @ImageUtil::create_small($file_path, $dir_path . SMAL_PICT_PREFIX . $fn, SIZE_SMAL_PICT, SIZE_SMAL_PICT);
                                            unlink($_FILES['file']['tmp_name'][$k]);

                                            $imgPicture['account_id'] = $imgAccount['id'];
                                            $imgPicture['album_id'] = $alb_id;
                                            $imgPicture['name'] = $_FILES['file']['name'][$k];
                                            $imgPicture['path'] = $rel_file_path;
                                            ImgPictureUtil::createImgPicture($imgPicture);
                                        }
                                    }
                                }
                            }

                            if (NULL == $alb_id) {
                                $v_params['alb_pictures'] = ImgPictureUtil::getImgPicturesNoAlbum($imgAccount['id']);
                            } else {
                                $v_params['alb_pictures'] = ImgPictureUtil::getImgPicturesByAlbumId($alb_id, $imgAccount['id']);
                            }

                            Application::fastView('imag-admin/albums/img_admin_album_show', $v_params);
                            return;
                        }
                    }
                }
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function pictureAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['picture'] = ImgPictureUtil::getImgPictureById($_GET[PICT_PARAM_NAME]);

                $v_params['img_album'] = ImgAlbumUtil::getImgAlbumByID($v_params['picture']['album_id'], $imgAccount['id']);
                if (NULL == $v_params['img_album']) {
                    $v_params['img_album_name'] = "Картинки без альбома";
                } else {
                    $v_params['img_album_name'] = $v_params['img_album']['name'];
                    $v_params['img_album_add_link'] = "&alb_id=" . $v_params['img_album']['id'];
                }
                $albumURL = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/album?act=show";

                if ($v_params['picture'] && $_POST['del_check']) {
                    $file_path = dirname(__FILE__) . "/../../../application_data" . $v_params['picture']['path'];
                    @unlink($file_path);

                    $path_blocks = explode("/", $v_params['picture']['path']);
                    $last = count($path_blocks) - 1;
                    $path_blocks[$last] = SMAL_PICT_PREFIX . $path_blocks[$last];
                    $path_small = implode("/", $path_blocks);

                    $smal_file_path = dirname(__FILE__) . "/../../../application_data" . $path_small;
                    @unlink($smal_file_path);

                    if ($v_params['picture']['album_id']) {
                        $albumURL .= "&alb_id=" . $v_params['picture']['album_id'];
                    }

                    ImgPictureUtil::deleteImgPictureById($v_params['picture']['id']);
                    header("Location: $albumURL");
                }


                $v_params['mysc']['main'] = TRUE;
                $v_params['img_name'] = $imgAccount['img_name'];
                $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");


                Application::fastView('imag-admin/img_admin_picture', $v_params);
                exit;
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function GDScatsAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['actname'] = "Управление категориями товаров";
                $v_params['img_gds_cats'] = ImgGdsCatUtil::getImgGdsCatsByAccountId($imgAccount['id']);


                $v_params['mysc']['main'] = TRUE;
                $v_params['img_name'] = $imgAccount['img_name'];
                $v_params['url_prefix'] = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/";
                $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");


                Application::fastView('imag-admin/gds-cats/img_gds_categories', $v_params);
                return;
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function GDScatAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
                $v_params['img_name'] = $imgAccount['img_name'];
                $v_params['url_prefix'] = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/";

                $action = $_GET['act'];
                if (0 == strcmp("add", $action)) {
                    $v_params['actname'] = "Создать категорию товаров";

                    if (0 != strcmp("", trim($_POST['img_cat_name']))) {
                        $imgGdsCat['account_id'] = $imgAccount['id'];
                        $imgGdsCat['name'] = $_POST['img_cat_name'];
                        if (0 != (int) $_POST['parent_cat'])
                            $imgGdsCat['pid'] = $_POST['parent_cat'];

                        ImgGdsCatUtil::insertImgGdsCat($imgGdsCat);
                    }

                    $v_params['img_gds_cats'] = ImgGdsCatUtil::getImgGdsCatsByAccountId($imgAccount['id']);
                    $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                    $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                    $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                    $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                    Application::fastView('imag-admin/gds-cats/img_gds_category_au', $v_params);
                    exit;
                } else if (0 == strcmp("upd", $action)) {
                    $v_params['actname'] = "Редактировать категорию товаров";
                    if (isset($_GET['GDScat_id'])) {
                        $gds_cat_id = $_GET['GDScat_id'];

                        if (isset($_POST['img_cat_name'])) {
                            $imgGdsCat['id'] = $gds_cat_id;
                            $imgGdsCat['account_id'] = $imgAccount['id'];
                            $imgGdsCat['name'] = $_POST['img_cat_name'];
                            if (0 != (int) $_POST['parent_cat'])
                                $imgGdsCat['pid'] = $_POST['parent_cat'];

                            ImgGdsCatUtil::updateImgGdsCat($imgGdsCat);
                        }

                        $v_params['img_gds_cat'] = ImgGdsCatUtil::getImgGdsCat($gds_cat_id, $imgAccount['id']);
                        $v_params['img_gds_cats'] = ImgGdsCatUtil::getImgGdsCatsByAccountId($imgAccount['id']);
                        foreach ($v_params['img_gds_cats'] as $key => $imgGdsCat) {
                            if ($v_params['img_gds_cat']['id'] == $imgGdsCat['id'])
                                unset($v_params['img_gds_cats'][$key]);
                        }

                        $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                        $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                        $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                        $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                        Application::fastView('imag-admin/gds-cats/img_gds_category_au', $v_params);
                        exit;
                    }
                } else if (0 == strcmp("del", $action)) {
                    $v_params['actname'] = "Удалить категорию товаров";

                    $gds_cat_id = $_GET['GDScat_id'];
                    $v_params['img_gds_cat'] = ImgGdsCatUtil::getImgGdsCat($gds_cat_id, $imgAccount['id']);
                    $v_params['img_gds_parent_cat'] = ImgGdsCatUtil::getImgGdsCat($v_params['img_gds_cat']['pid'], $imgAccount['id']);

                    if (isset($_POST['move_cat'])) {
                        $new_cat = $_POST['move_cat'];
                        ImgGdsCatUtil::moveGDScats($gds_cat_id, $new_cat);
                        ImgGdsUtil::moveGDSs($gds_cat_id, $new_cat);
                        ImgGdsCatUtil::deleteImgGdsCatById($v_params['img_gds_cat']['id']);

                        $GDScatsURL = $v_params['url_prefix'] . "GDScats";
                        header("Location: $GDScatsURL");
                    }

                    $v_params['img_gds_cats'] = ImgGdsCatUtil::getImgGdsCatsByAccountId($imgAccount['id']);
                    foreach ($v_params['img_gds_cats'] as $key => $imgGdsCat) {
                        if ($v_params['img_gds_cat']['id'] == $imgGdsCat['id'])
                            unset($v_params['img_gds_cats'][$key]);
                    }

                    $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                    $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                    $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                    $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                    Application::fastView('imag-admin/gds-cats/img_gds_category_del', $v_params);
                    exit;
                }
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function ARTcatsAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['actname'] = "Управление блоками статей";
                $v_params['img_blog_cats'] = ImgBlogCatUtil::getImgBlogCatsByAccountId($imgAccount['id']);


                $v_params['mysc']['main'] = TRUE;
                $v_params['img_name'] = $imgAccount['img_name'];
                $v_params['url_prefix'] = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/";
                $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");


                Application::fastView('imag-admin/art-cats/img_blog_categories', $v_params);
                return;
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function ARTcatAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
                $v_params['img_name'] = $imgAccount['img_name'];
                $v_params['url_prefix'] = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/";

                $action = $_GET['act'];
                if (0 == strcmp("add", $action)) {
                    $v_params['actname'] = "Создать блок статей";

                    if (isset($_POST['img_cat_name'])) {
                        $imgBlogCat['account_id'] = $imgAccount['id'];
                        $imgBlogCat['name'] = $_POST['img_cat_name'];
                        if (0 != (int) $_POST['parent_cat'])
                            $imgBlogCat['pid'] = $_POST['parent_cat'];

                        ImgBlogCatUtil::insertImgBlogCat($imgBlogCat);
                    }

                    $v_params['img_blog_cat'] = ImgBlogCatUtil::getImgBlogCat($blog_cat_id, $imgAccount['id']);
                    $v_params['img_blog_cats'] = ImgBlogCatUtil::getImgBlogCatsByAccountId($imgAccount['id']);
                    if (count($v_params['img_blog_cats'])) {
                        foreach ($v_params['img_blog_cats'] as $key => $imgBlogCat) {
                            if ($v_params['img_blog_cat']['id'] == $imgBlogCat['id'])
                                unset($v_params['img_blog_cats'][$key]);
                        }
                    }


                    $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                    $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                    $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                    $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                    Application::fastView('imag-admin/art-cats/img_blog_category_au', $v_params);
                    exit;
                } else if (0 == strcmp("upd", $action)) {
                    $v_params['actname'] = "Редактировать блок статей";
                    if (isset($_GET['ARTcat_id'])) {
                        $blog_cat_id = $_GET['ARTcat_id'];

                        if (isset($_POST['img_cat_name'])) {
                            $imgBlogCat['id'] = $blog_cat_id;
                            $imgBlogCat['account_id'] = $imgAccount['id'];
                            $imgBlogCat['name'] = $_POST['img_cat_name'];
                            if (0 != (int) $_POST['parent_cat'])
                                $imgBlogCat['pid'] = $_POST['parent_cat'];

                            ImgBlogCatUtil::updateImgBlogCat($imgBlogCat);
                        }

                        $v_params['img_blog_cat'] = ImgBlogCatUtil::getImgBlogCat($blog_cat_id, $imgAccount['id']);
                        $v_params['img_blog_cats'] = ImgBlogCatUtil::getImgBlogCatsByAccountId($imgAccount['id']);
                        foreach ($v_params['img_blog_cats'] as $key => $imgBlogCat) {
                            if ($v_params['img_blog_cat']['id'] == $imgBlogCat['id'])
                                unset($v_params['img_blog_cats'][$key]);
                        }

                        $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                        $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                        $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                        $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                        Application::fastView('imag-admin/art-cats/img_blog_category_au', $v_params);
                        exit;
                    }
                } else if (0 == strcmp("del", $action)) {
                    $v_params['actname'] = "Удалить блок статей";

                    $blog_cat_id = $_GET['ARTcat_id'];
                    $v_params['img_blog_cat'] = ImgBlogCatUtil::getImgBlogCat($blog_cat_id, $imgAccount['id']);
                    $v_params['img_blog_parent_cat'] = ImgBlogCatUtil::getImgBlogCat($v_params['img_blog_cat']['pid'], $imgAccount['id']);


                    if (isset($_POST['move_cat'])) {
                        $new_cat = $_POST['move_cat'];
                        ImgBlogCatUtil::moveBlogCats($blog_cat_id, $new_cat);
                        ImgBlogArtUtil::moveBlogArtss($blog_cat_id, $new_cat);
                        ImgBlogCatUtil::deleteImgBlogCat($v_params['img_blog_cat']);

                        $ARTcatsURL = $v_params['url_prefix'] . "ARTcats";
                        header("Location: $ARTcatsURL");
                    }

                    $v_params['img_blog_cats'] = ImgBlogCatUtil::getImgBlogCatsByAccountId($imgAccount['id']);
                    foreach ($v_params['img_blog_cats'] as $key => $imgBlogCat) {
                        if ($v_params['img_blog_cat']['id'] == $imgBlogCat['id'])
                            unset($v_params['img_blog_cats'][$key]);
                    }

                    $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                    $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                    $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                    $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                    Application::fastView('imag-admin/art-cats/img_blog_category_del', $v_params);
                    exit;
                }
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function GDSsAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
                $v_params['img_name'] = $imgAccount['img_name'];

                $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                $v_params['img_gds_cats'] = ImgGdsCatUtil::getImgGdsCatsByAccountId($imgAccount['id']);

                $url_pref = "/" . IMAG_PREFIX . $img_id . "/admin/GDSs?";
                if ($_REQUEST['cat']) {
                    $_REQUEST['cat'] = (INT) $_REQUEST['cat'];
                    $url_pref = $url_pref . "cat=" . $_REQUEST['cat'];
                    $filter['cat'] = $_REQUEST['cat'];
                }
                if ($_REQUEST['pname']) {
                    $url_pref = $url_pref . "&pname=" . $_REQUEST['pname'];
                    $filter['pname'] = $_REQUEST['pname'];
                }
                if ($_REQUEST['prfrom']) {
                    $_REQUEST['prfrom'] = (INT) $_REQUEST['prfrom'];
                    $url_pref = $url_pref . "&prfrom=" . $_REQUEST['prfrom'];
                    $filter['prfrom'] = $_REQUEST['prfrom'];
                }
                if ($_REQUEST['prto']) {
                    $_REQUEST['prto'] = (INT) $_REQUEST['prto'];
                    $url_pref = $url_pref . "&prto=" . $_REQUEST['prto'];
                    $filter['prto'] = $_REQUEST['prto'];
                }
                if ($_REQUEST['tosale']) {
                    $url_pref = $url_pref . "&tosale=" . $_REQUEST['tosale'];
                    $filter['tosale'] = $_REQUEST['tosale'];
                }

                $v_params['img_gdss'] = ImgGdsUtil::getImgGdssByFilter($imgAccount['id'], $filter, 18 * $_REQUEST[PAGE_PARAM_NAME], 18);
                $count_img_gdss = ImgGdsUtil::countImgGdssByFilter($imgAccount['id'], $filter);
                for ($i = 0; $i < $count_img_gdss / 18; $i++) {
                    $item['value'] = $i + 1;
                    $item['current'] = ($i == $_REQUEST[PAGE_PARAM_NAME]);
                    $item['url'] = $url_pref . "&" . PAGE_PARAM_NAME . "=" . $i;

                    $v_params['paginator'][] = $item;
                }

                Application::fastView('imag-admin/gds/img_gdss', $v_params);
                exit;
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function GDSAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
                $v_params['img_name'] = $imgAccount['img_name'];

                $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                $v_params['img_gds_cats'] = ImgGdsCatUtil::getImgGdsCatsByAccountId($imgAccount['id']);
                $v_params['img_currencies'] = ImgCurrencyUtil::getImgCurrencies();

                $img_albums = ImgAlbumUtil::getImgAlbumsByAccountID($imgAccount['id']);
                $img_album_pictures = ImgPictureUtil::getImgPicturesNoAlbum($imgAccount['id']);
                $v_params['img_albums'][] = array("name" => "Без альбома", "pictures" => $img_album_pictures);
                if (count($img_albums)) {
                    foreach ($img_albums as $img_album) {
                        $img_album_pictures = ImgPictureUtil::getImgPicturesByAlbumId($img_album['id'], $imgAccount['id']);
                        $v_params['img_albums'][] = array("name" => $img_album['name'], "pictures" => $img_album_pictures);
                    }
                }


                if (0 == strcmp("add", $_GET['act'])) {
                    $v_params['action'] = "Добавить товар";

                    $v_params['gds_opt']['gds_name'] = $_POST['gds_name'];
                    $v_params['gds_opt']['gds_price_val'] = (INT) $_POST['gds_price_val'];
                    $v_params['gds_opt']['gds_price_cur'] = (INT) $_POST['gds_price_cur'];
                    $v_params['gds_opt']['gds_code'] = $_POST['gds_code'];
                    $v_params['gds_opt']['gds_cat'] = (INT) $_POST['gds_cat'];
                    $v_params['gds_opt']['gds_main_img'] = (INT) $_POST['gds_main_img'];
                    $v_params['gds_opt']['gds_first_img'] = (INT) $_POST['gds_first_img'];
                    $v_params['gds_opt']['gds_second_img'] = (INT) $_POST['gds_second_img'];
                    $v_params['gds_opt']['gds_third_img'] = (INT) $_POST['gds_third_img'];
                    $v_params['gds_opt']['gds_char_list'] = $_POST['gds_char_list'];
                    $v_params['gds_opt']['gds_descr'] = $_POST['gds_descr'];
                    $v_params['gds_opt']['gds_new'] = $_POST['gds_new'];
                    $v_params['gds_opt']['gds_rec'] = $_POST['gds_rec'];
                    $v_params['gds_opt']['gds_in_sale'] = $_POST['gds_in_sale'];

                    if ($_POST['form']) {
                        if (NULL == $_POST['gds_name'] || 0 == strcmp("", trim($_POST['gds_name']))) {
                            $v_params['errors'][] = "Имя товара обязательно для ввода";
                        }

                        if (0 >= $v_params['gds_opt']['gds_price_val']) {
                            $v_params['errors'][] = "Цена должна быть положительным числом";
                        }

                        if (NULL == $_POST['gds_code'] || 0 == strcmp("", trim($_POST['gds_code']))) {
                            $v_params['errors'][] = "Введите код товара";
                        }

                        if (0 >= $v_params['gds_opt']['gds_main_img']) {
                            $v_params['errors'][] = "Вы должны назначить главное изображение для товара";
                        }

                        if (count($v_params['errors'])) {
                            Application::fastView('imag-admin/gds/img_gds_au', $v_params);
                            exit;
                        } else {
                            $imgGds['UUID'] = $v_params['gds_opt']['gds_code'];
                            $imgGds['name'] = $v_params['gds_opt']['gds_name'];
                            $imgGds['price'] = $v_params['gds_opt']['gds_price_val'];
                            $imgGds['currency_id'] = $v_params['gds_opt']['gds_price_cur'];
                            $imgGds['main_pict_id'] = $v_params['gds_opt']['gds_main_img'];
                            $imgGds['first_pict_id'] = $v_params['gds_opt']['gds_first_img'];
                            $imgGds['second_pict_id'] = $v_params['gds_opt']['gds_second_img'];
                            $imgGds['third_pict_id'] = $v_params['gds_opt']['gds_third_img'];
                            $imgGds['img_account_id'] = $imgAccount['id'];
                            $imgGds['img_gds_cat_id'] = $v_params['gds_opt']['gds_cat'];
                            $imgGds['descr'] = $_POST['gds_descr'];

                            if ($v_params['gds_opt']['gds_in_sale'])
                                $imgGds['in_stock'] = 1;
                            else
                                $imgGds['in_stock'] = 0;

                            if ($v_params['gds_opt']['gds_new'])
                                $imgGds['is_new'] = 1;
                            else
                                $imgGds['is_new'] = 0;

                            if ($v_params['gds_opt']['gds_rec'])
                                $imgGds['is_recommended'] = 1;
                            else
                                $imgGds['is_recommended'] = 0;

                            $gdsID = ImgGdsUtil::insertGDS($imgGds);
                            $props = Splitter::splitGDSProperties($v_params['gds_opt']['gds_char_list']);
                            ImgGdsPropUtil::insertManyImgGdsProps($gdsID, $props);

                            header("Location: GDSs");
                            return;
                        }
                    } else {
                        Application::fastView('imag-admin/gds/img_gds_au', $v_params);
                        exit;
                    }
                } else if (0 == strcmp("upd", $_GET['act'])) {
                    $v_params['action'] = "Редактировать товар";

                    $img_gds_id = $_GET['id'];
                    $imgGDS = ImgGdsUtil::getImgGdsByIdAndAccountId($img_gds_id, $imgAccount['id']);
                    if ($imgGDS) {
                        if ($_POST['form']) {
                            $v_params['gds_opt']['gds_name'] = $_POST['gds_name'];
                            $v_params['gds_opt']['gds_price_val'] = (INT) $_POST['gds_price_val'];
                            $v_params['gds_opt']['gds_price_cur'] = (INT) $_POST['gds_price_cur'];
                            $v_params['gds_opt']['gds_code'] = $_POST['gds_code'];
                            $v_params['gds_opt']['gds_cat'] = (INT) $_POST['gds_cat'];
                            $v_params['gds_opt']['gds_main_img'] = (INT) $_POST['gds_main_img'];
                            $v_params['gds_opt']['gds_first_img'] = (INT) $_POST['gds_first_img'];
                            $v_params['gds_opt']['gds_second_img'] = (INT) $_POST['gds_second_img'];
                            $v_params['gds_opt']['gds_third_img'] = (INT) $_POST['gds_third_img'];
                            $v_params['gds_opt']['gds_char_list'] = $_POST['gds_char_list'];
                            $v_params['gds_opt']['gds_descr'] = $_POST['gds_descr'];
                            $v_params['gds_opt']['gds_new'] = $_POST['gds_new'];
                            $v_params['gds_opt']['gds_rec'] = $_POST['gds_rec'];
                            $v_params['gds_opt']['gds_in_sale'] = $_POST['gds_in_sale'];

                            if (NULL == $_POST['gds_name'] || 0 == strcmp("", trim($_POST['gds_name']))) {
                                $v_params['errors'][] = "Имя товара обязательно для ввода";
                            }

                            if (0 >= $v_params['gds_opt']['gds_price_val']) {
                                $v_params['errors'][] = "Цена должна быть положительным числом";
                            }

                            if (NULL == $_POST['gds_code'] || 0 == strcmp("", trim($_POST['gds_code']))) {
                                $v_params['errors'][] = "Введите код товара";
                            }

                            if (0 >= $v_params['gds_opt']['gds_main_img']) {
                                $v_params['errors'][] = "Вы должны назначить главное изображение для товара";
                            }

                            if (!count($v_params['errors'])) {
                                $imgGds['id'] = $imgGDS['ig_id'];
                                $imgGds['UUID'] = $v_params['gds_opt']['gds_code'];
                                $imgGds['name'] = $v_params['gds_opt']['gds_name'];
                                $imgGds['price'] = $v_params['gds_opt']['gds_price_val'];
                                $imgGds['currency_id'] = $v_params['gds_opt']['gds_price_cur'];
                                $imgGds['main_pict_id'] = $v_params['gds_opt']['gds_main_img'];
                                $imgGds['first_pict_id'] = $v_params['gds_opt']['gds_first_img'];
                                $imgGds['second_pict_id'] = $v_params['gds_opt']['gds_second_img'];
                                $imgGds['third_pict_id'] = $v_params['gds_opt']['gds_third_img'];
                                $imgGds['img_account_id'] = $imgAccount['id'];
                                $imgGds['img_gds_cat_id'] = $v_params['gds_opt']['gds_cat'];
                                $imgGds['descr'] = $_POST['gds_descr'];

                                if ($v_params['gds_opt']['gds_in_sale'])
                                    $imgGds['in_stock'] = 1;
                                else
                                    $imgGds['in_stock'] = 0;

                                if ($v_params['gds_opt']['gds_new'])
                                    $imgGds['is_new'] = 1;
                                else
                                    $imgGds['is_new'] = 0;

                                if ($v_params['gds_opt']['gds_rec'])
                                    $imgGds['is_recommended'] = 1;
                                else
                                    $imgGds['is_recommended'] = 0;


                                ImgGdsUtil::updateGDS($imgGds);
                                $props = Splitter::splitGDSProperties($v_params['gds_opt']['gds_char_list']);
                                ImgGdsPropUtil::deleteImgGdsPropByImgGdsId($imgGds['id']);
                                ImgGdsPropUtil::insertManyImgGdsProps($imgGds['id'], $props);
                            }
                        } else {
                            $v_params['gds_opt']['gds_name'] = $imgGDS['ig_name'];
                            $v_params['gds_opt']['gds_price_val'] = $imgGDS['price'];
                            $v_params['gds_opt']['gds_price_cur'] = $imgGDS['currency_id'];
                            $v_params['gds_opt']['gds_code'] = $imgGDS['UUID'];
                            $v_params['gds_opt']['gds_cat'] = $imgGDS['img_gds_cat_id'];
                            $v_params['gds_opt']['gds_main_img'] = $imgGDS['main_pict_id'];
                            $v_params['gds_opt']['gds_first_img'] = $imgGDS['first_pict_id'];
                            $v_params['gds_opt']['gds_second_img'] = $imgGDS['second_pict_id'];
                            $v_params['gds_opt']['gds_third_img'] = $imgGDS['third_pict_id'];
                            $imgGdsProps = ImgGdsPropUtil::getImgGdsProps($img_gds_id);
                            $v_params['gds_opt']['gds_char_list'] = Splitter::desplitGDSProperties($imgGdsProps);
                            $v_params['gds_opt']['gds_descr'] = ImgGdsUtil::getDescriptionOfImgGds($img_gds_id);
                            $v_params['gds_opt']['gds_new'] = $imgGDS['is_new'];
                            $v_params['gds_opt']['gds_rec'] = $imgGDS['is_recommended'];
                            $v_params['gds_opt']['gds_in_sale'] = $imgGDS['in_stock'];
                        }

                        Application::fastView('imag-admin/gds/img_gds_au', $v_params);
                        exit;
                    }
                } else if (0 == strcmp("del", $_GET['act'])) {
                    $v_params['action'] = "Удалить товар";

                    $img_gds_id = $_GET['id'];
                    $imgGDS = ImgGdsUtil::getImgGdsByIdAndAccountId($img_gds_id, $imgAccount['id']);

                    if ($imgGDS) {
                        if ($_POST['gds_del']) {
                            ImgGdsPropUtil::deleteImgGdsPropByImgGdsId($img_gds_id);
                            ImgGdsUtil::deleteGDSById($img_gds_id);
                            header("Location: GDSs");
                            return;
                        }

                        $v_params['img_gds']['ig_name'] = $imgGDS['ig_name'];
                        $v_params['img_gds']['price'] = $imgGDS['price'];
                        $v_params['img_gds']['currency_name'] = $imgGDS['ic_name'];
                        $v_params['img_gds']['UUID'] = $imgGDS['UUID'];

                        $v_params['img_gds']['main_pict_id'] = $imgGDS['main_pict_id'];
                        $v_params['img_gds']['first_pict_id'] = $imgGDS['first_pict_id'];
                        $v_params['img_gds']['second_pict_id'] = $imgGDS['second_pict_id'];
                        $v_params['img_gds']['third_pict_id'] = $imgGDS['third_pict_id'];

                        $v_params['img_gds_props'] = ImgGdsPropUtil::getImgGdsProps($img_gds_id);
                        $v_params['img_gds_descr'] = ImgGdsUtil::getDescriptionOfImgGds($img_gds_id);
                    }

                    Application::fastView('imag-admin/gds/img_gds_del', $v_params);
                    exit;
                }
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function ARTsAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
                $v_params['img_name'] = $imgAccount['img_name'];

                $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                $category = $_REQUEST["cat"];
                $pname = $_REQUEST["pname"];

                $v_params['img_blog_cats'] = ImgBlogCatUtil::getImgBlogCatsByAccountId($imgAccount['id']);

                $v_params['img_blog_arts'] = ImgBlogArtUtil::getImgBlogArtsByFilter($imgAccount['id'], $_REQUEST["cat"], trim($_REQUEST["pname"]), ART_ON_PAGE * $_REQUEST[PAGE_PARAM_NAME], ART_ON_PAGE);
                $v_params['img_art_link'] = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/ART?id=";

                $count_img_arts = ImgBlogArtUtil::getCountOfImgBlogArtByFilter($imgAccount['id'], $_REQUEST["cat"], trim($_REQUEST["pname"]));
                for ($i = 0; $i < $count_img_arts / ART_ON_PAGE; $i++) {
                    $item['value'] = $i + 1;
                    $item['current'] = ($i == $_REQUEST[PAGE_PARAM_NAME]);

                    $url = "/" . IMAG_PREFIX . $imgAccount['id'] . "/admin/ARTs?";

                    if ($_REQUEST["cat"])
                        $url = $url . "cat" . "=" . $_REQUEST["cat"] . "&";

                    if ($_REQUEST["pname"])
                        $url = $url . "pname" . "=" . $_REQUEST["pname"] . "&";

                    $item['url'] = $url . PAGE_PARAM_NAME . "=" . $i;

                    $v_params['paginator'][] = $item;
                }

                Application::fastView('imag-admin/art/img_articles', $v_params);
                exit;
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function ARTAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
                $v_params['img_name'] = $imgAccount['img_name'];

                $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                $v_params['img_blog_cats'] = ImgBlogCatUtil::getImgBlogCatsByAccountId($imgAccount['id']);

                $img_albums = ImgAlbumUtil::getImgAlbumsByAccountID($imgAccount['id']);
                $img_album_pictures = ImgPictureUtil::getImgPicturesNoAlbum($imgAccount['id']);
                $v_params['img_albums'][] = array("name" => "Без альбома", "pictures" => $img_album_pictures);
                foreach ($img_albums as $img_album) {
                    $img_album_pictures = ImgPictureUtil::getImgPicturesByAlbumId($img_album['id'], $imgAccount['id']);
                    $v_params['img_albums'][] = array("name" => $img_album['name'], "pictures" => $img_album_pictures);
                }

                if (0 == strcmp("add", $_GET['act'])) {
                    $v_params['act_name'] = "Добавить статью";
                    if (0 == strcmp("savehead", $_GET['subact'])) {
                        if (0 != strcmp("", $_POST['art_name']) && $_POST['cat_id'] && isset($_POST['pict_id']) && 0 != strcmp("", $_POST['preview'])) {
                            $imgBlogArt['img_account_id'] = $imgAccount['id'];
                            $imgBlogArt['img_blog_cat_id'] = $_POST['cat_id'];
                            $imgBlogArt['name'] = $_POST['art_name'];
                            $imgBlogArt['main_pict_id'] = $_POST['pict_id'];
                            $imgBlogArt['preview'] = $_POST['preview'];

                            $artID = ImgBlogArtUtil::insertImgBlogArt($imgBlogArt);
                            $redirectURL = "/imag" . $imgAccount['id'] . "/admin/ART?id=$artID&act=upd";
                            header("Location: $redirectURL");
                        } else {
                            $v_params['error_msg'] = "Введены не все поля";
                        }
                    }

                    Application::fastView('imag-admin/art/img_article_a', $v_params);
                    exit;
                } else if (0 == strcmp("upd", $_GET['act']) && isset($_GET['id'])) {
                    $v_params['act_name'] = "Редактировать статью";
                    $imgBlogArt = ImgBlogArtUtil::getImgBlogArtById($imgAccount['id'], $_GET['id']);

                    if ($_POST['form_send']) {
                        if (0 != strcmp("", $_POST['art_name']) && isset($_POST['cat_id']) && 0 != strcmp("", $_POST['art_name'])) {
                            $imgBlogArt['img_blog_cat_id'] = $_POST['cat_id'];
                            $imgBlogArt['name'] = $_POST['art_name'];
                            $imgBlogArt['main_pict_id'] = $_POST['pict_id'];
                            $imgBlogArt['preview'] = $_POST['preview'];

                            ImgBlogArtUtil::updateImgBlogArt($imgBlogArt);
                            $imgBlogArt = ImgBlogArtUtil::getImgBlogArtById($imgAccount['id'], $imgBlogArt['id']);
                        } else {
                            $v_params['error_msg'] = "Введены не все поля";
                        }
                    }

                    $v_params['img_blog_art_blocks'] = ImgBlogArtBlockUtil::getImgBlogArtBlocksByArtId($_GET['id']);

                    $v_params['img_blog_art'] = $imgBlogArt;

                    Application::fastView('imag-admin/art/img_article_u', $v_params);
                    exit;
                } else if (0 == strcmp("del", $_GET['act']) && isset($_GET['id'])) {
                    $v_params['act_name'] = "Удалить статью";

                    if ($_POST['artID']) {
                        ImgBlogArtUtil::deleteImgBlogArtById($_POST['artID']);
                        header("Location: ARTs");
                    }

                    $v_params['img_blog_art'] = ImgBlogArtUtil::getImgBlogArtById($imgAccount['id'], $_GET['id']);
                    $v_params['img_blog_art_blocks'] = ImgBlogArtBlockUtil::getImgBlogArtBlocksByArtId($_GET['id']);

                    Application::fastView('imag-admin/art/img_article_del', $v_params);
                    exit;
                }
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function ARTBlockAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
                $v_params['img_name'] = $imgAccount['img_name'];

                $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                $img_albums = ImgAlbumUtil::getImgAlbumsByAccountID($imgAccount['id']);
                $img_album_pictures = ImgPictureUtil::getImgPicturesNoAlbum($imgAccount['id']);
                $v_params['img_albums'][] = array("name" => "Без альбома", "pictures" => $img_album_pictures);
                foreach ($img_albums as $img_album) {
                    $img_album_pictures = ImgPictureUtil::getImgPicturesByAlbumId($img_album['id'], $imgAccount['id']);
                    $v_params['img_albums'][] = array("name" => $img_album['name'], "pictures" => $img_album_pictures);
                }

                $artID = $_GET['corresp'];
                $article_url = "ART?id=$artID&act=upd";

                if (0 == strcmp("add", $_GET['act']) && isset($_GET['corresp'])) {
                    $v_params['action'] = "Добавить";
                    $v_params['img_blog_art'] = ImgBlogArtUtil::getImgBlogArtById($imgAccount['id'], $artID);

                    $v_params['num_tab'] = 0;

                    if (isset($_POST['send_block_form'])) {
                        if (0 == $_POST['selected_tab']) {
                            $imgBlogArtBlock['img_blog_art_id'] = $_GET['corresp'];
                            $imgBlogArtBlock['block_type'] = 1;
                            $imgBlogArtBlock['text_content'] = $_POST['text_content'];
                            $imgBlogArtBlock['order_in_art'] = (INT) $_POST['order'];

                            ImgBlogArtBlockUtil::insertImgBlogArtBlock($imgBlogArtBlock);
                            header("Location: $article_url");
                        } else if (1 == $_POST['selected_tab']) {
                            $imgBlogArtBlock['img_blog_art_id'] = $_GET['corresp'];
                            $imgBlogArtBlock['block_type'] = 0;
                            $imgBlogArtBlock['img_picture_id'] = $_POST['pict_id'];
                            $imgBlogArtBlock['pict_desc'] = $_POST['img_desk'];
                            $imgBlogArtBlock['order_in_art'] = (INT) $_POST['order'];

                            ImgBlogArtBlockUtil::insertImgBlogArtBlock($imgBlogArtBlock);
                            header("Location: $article_url");
                        }
                    }

                    Application::fastView('imag-admin/art/img_article_block_au', $v_params);
                    exit;
                } else if (0 == strcmp("upd", $_GET['act']) && isset($_GET['corresp']) && isset($_GET['id'])) {
                    $v_params['action'] = "Редактировать";
                    $v_params['img_blog_art_block'] = ImgBlogArtBlockUtil::getImgBlogArtBlocksById($_GET['id']);
                    $v_params['img_blog_art'] = ImgBlogArtUtil::getImgBlogArtById($imgAccount['id'], $v_params['img_blog_art_block']['img_blog_art_id']);

                    $v_params['num_tab'] = 0;
                    if (0 == $v_params['img_blog_art_block']['block_type'])
                        $v_params['num_tab'] = 1;

                    if (isset($_POST['send_block_form'])) {
                        if (0 == $_POST['selected_tab']) {
                            $v_params['img_blog_art_block']['img_blog_art_id'] = $_GET['corresp'];
                            $v_params['img_blog_art_block']['block_type'] = 1;
                            $v_params['img_blog_art_block']['text_content'] = $_POST['text_content'];
                            $v_params['img_blog_art_block']['order_in_art'] = (INT) $_POST['order'];

                            ImgBlogArtBlockUtil::updateImgBlogArtBlock($v_params['img_blog_art_block']);
                        } else if (1 == $_POST['selected_tab']) {
                            $v_params['img_blog_art_block']['img_blog_art_id'] = $_GET['corresp'];
                            $v_params['img_blog_art_block']['block_type'] = 0;
                            $v_params['img_blog_art_block']['img_picture_id'] = $_POST['pict_id'];
                            $v_params['img_blog_art_block']['pict_desc'] = $_POST['img_desk'];
                            $v_params['img_blog_art_block']['order_in_art'] = (INT) $_POST['order'];

                            ImgBlogArtBlockUtil::updateImgBlogArtBlock($v_params['img_blog_art_block']);
                        }

                        header("Location: $article_url");
                    }

                    Application::fastView('imag-admin/art/img_article_block_au', $v_params);
                    exit;
                } else if (0 == strcmp("del", $_GET['act']) && isset($_GET['corresp']) && isset($_GET['id'])) {
                    $v_params['action'] = "Удалить";
                    $v_params['img_blog_art_block'] = ImgBlogArtBlockUtil::getImgBlogArtBlocksById($_GET['id']);
                    $v_params['img_blog_art'] = ImgBlogArtUtil::getImgBlogArtById($imgAccount['id'], $v_params['img_blog_art_block']['img_blog_art_id']);

                    if (isset($_POST['del_block_form'])) {
                        ImgBlogArtBlockUtil::deleteImgBlogArtBlockById($_GET['id']);
                        header("Location: $article_url");
                    }

                    Application::fastView('imag-admin/art/img_article_block_del', $v_params);
                    exit;
                }
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function ordersAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
                $v_params['img_name'] = $imgAccount['img_name'];

                $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                $orders_on_page = 20;
                $page = $_GET[PAGE_PARAM_NAME];
                if (0 == strcmp("last", $_GET['type'])) {
                    $v_params['orders_type'] = "Последние";

                    $count_orders = OrderUtil::getCountOrdersByAccountID($imgAccount['id']);
                    for ($i = 0; $i < $count_orders / $orders_on_page; $i++) {
                        $item['value'] = $i + 1;
                        $item['current'] = ($i == $_REQUEST[PAGE_PARAM_NAME]);
                        $item['url'] = "orders?type=" . $_GET['type'] . "&" . PAGE_PARAM_NAME . "=" . $i;
                        $v_params['paginator'][] = $item;
                    }

                    $v_params['orders'] = OrderUtil::getOrdersLastByLimit($imgAccount['id'], $page * $orders_on_page, $orders_on_page);
                } else if (0 == strcmp("notprocessed", $_GET['type'])) {
                    $v_params['orders_type'] = "Не завершенные";

                    $count_orders = OrderUtil::getCountOrdersNotSendedByAccountID($imgAccount['id']);
                    for ($i = 0; $i < $count_orders / $orders_on_page; $i++) {
                        $item['value'] = $i + 1;
                        $item['current'] = ($i == $_REQUEST[PAGE_PARAM_NAME]);
                        $item['url'] = "orders?type=" . $_GET['type'] . "&" . PAGE_PARAM_NAME . "=" . $i;
                        $v_params['paginator'][] = $item;
                    }

                    $v_params['orders'] = OrderUtil::getOrdersNotSendedByLimit($imgAccount['id'], $page * $orders_on_page, $orders_on_page);
                } else {
                    $v_params['orders_type'] = "Все";

                    $count_orders = OrderUtil::getCountOrdersByAccountID($imgAccount['id']);
                    for ($i = 0; $i < $count_orders / $orders_on_page; $i++) {
                        $item['value'] = $i + 1;
                        $item['current'] = ($i == $_REQUEST[PAGE_PARAM_NAME]);
                        $item['url'] = "orders?type=" . $_GET['type'] . "&" . PAGE_PARAM_NAME . "=" . $i;
                        $v_params['paginator'][] = $item;
                    }

                    $v_params['orders'] = OrderUtil::getOrdersByLimit($imgAccount['id'], $page * $orders_on_page, $orders_on_page);
                }

                Application::fastView('imag-admin/order/img_admin_orders', $v_params);
                exit;
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

    function orderAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
                $v_params['img_name'] = $imgAccount['img_name'];

                $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
                $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
                $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");
                $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

                if ($_GET['id']) {
                    $order_id = $_GET['id'];

                    $v_params['order'] = OrderUtil::getOrderById($order_id, $imgAccount['id']);
                    $v_params['order_gdss'] = ImgGdsUtil::getImgGdssForOrder($imgAccount['id'], $order_id);

                    if ($_POST['order_ended'] && count($v_params['order_gdss'])) {
                        if (0 == strcmp("not_ended", $_POST['order_ended'])) {
                            OrderAccountSendedUtil::updateOrderAccountRelation($order_id, $imgAccount['id'], 0);
                            $v_params['order']['sended'] = 0;
                        } else if (0 == strcmp("ended", $_POST['order_ended'])) {
                            OrderAccountSendedUtil::updateOrderAccountRelation($order_id, $imgAccount['id'], 1);
                            $v_params['order']['sended'] = 1;
                        }
                    }

                    Application::fastView('imag-admin/order/img_admin_order', $v_params);
                    exit;
                }
            }
        }

        Application::fastView('main/sys_error', $v_params);
    }

}
