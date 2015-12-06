<?php

require_once dirname(__FILE__) . "/../models/__DBMODEL__.php";
require_once dirname(__FILE__) . "/../utils/external/UUIDGenerator.php";
require_once dirname(__FILE__) . "/../utils/admin/LoginChecker.php";
require_once dirname(__FILE__) . "/../utils/admin/ImageUtil.php";

/**
 * Description of superAdminController
 *
 * @author Evgeny
 */
class superAdminController {

    function loginAction() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if ($_POST['img_admin_login'] && $_POST['img_admin_password']) {
            $sysAdmin = SysAdminsUtil::getSysAdminByLoginAndPassword($_POST['img_admin_login'], $_POST['img_admin_password']);
            if ($sysAdmin) {
                $rndUUID = UUIDGenerator::generate();
                $sysAdmin['lastuuid'] = $rndUUID;
                SysAdminsUtil::updateSysAdmin($sysAdmin);
                setcookie("sa", $rndUUID);

                header("Location: /superAdmin/settings");
            }
        }

        Application::fastView('super-admin/login', $v_params);
        exit;
    }

    function logoutAction() {
        setcookie("sa", null, time() - 1);
        header("Location: /");
    }

    function settingsAction() {
        if (LoginChecker::isAdmin()) {
            if ($_POST['sys_name']) {
                SysPropertiesUtil::putProperty("sys_name", $_POST['sys_name']);
            }

            if ($_POST['sys_slog']) {
                SysPropertiesUtil::putProperty("sys_slog", $_POST['sys_slog']);
            }

            $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
            $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

            Application::fastView('super-admin/settings', $v_params);
            exit;
        } else {
            header("Location: /superAdmin/login");
        }
    }

    function albumsAction() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (LoginChecker::isAdmin()) {
            $v_params['img_albums'] = ImgAlbumUtil::getImgAlbumsByAccountID(0);

            Application::fastView('super-admin/albums/albums', $v_params);
            exit;
        } else {
            header("Location: /superAdmin/login");
        }
    }

    function albumAction() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (LoginChecker::isAdmin()) {
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
                            $imgAlbum['account_id'] = 0;
                            $imgAlbum['name'] = $img_album_name;
                            $imgAlbum['description'] = $_POST['img_album_desc'];

                            ImgAlbumUtil::insertImgAlbum($imgAlbum);
                            header("Location: /superAdmin/albums");
                        }
                    }
                    Application::fastView('super-admin/albums/album_au', $v_params);
                    exit;
                } else if (0 == strcmp("upd", $action)) {
                    // Переименовать альбом
                    $v_params['action_name'] = "Переименовать альбом";
                    if (isset($_GET['alb_id'])) {
                        $imgAlbumId = $_GET['alb_id'];
                        $imgAlbum = ImgAlbumUtil::getImgAlbumByID($imgAlbumId, 0);
                        if (NULL != $imgAlbum) {
                            $v_params['img_album_name'] = $imgAlbum['name'];
                            $v_params['img_album_desc'] = $imgAlbum['description'];
                        }
                    } else {
                        header("Location: /superAdmin/albums");
                    }

                    if (isset($_POST['img_album_name'])) {
                        $img_album_name = trim($_POST['img_album_name']);
                        if (0 == strcmp("", $img_album_name)) {
                            $v_params['messages'][] = "Имя альбома не может быть пустым";
                        } else {
                            $imgAlbum['id'] = $imgAlbumId;
                            $imgAlbum['account_id'] = 0;
                            $imgAlbum['name'] = $img_album_name;
                            $imgAlbum['description'] = $_POST['img_album_desc'];

                            ImgAlbumUtil::updateImgAlbum($imgAlbum);
                            header("Location: /superAdmin/albums");
                        }
                    }

                    Application::fastView('super-admin/albums/album_au', $v_params);
                    exit;
                } else if (0 == strcmp("del", $action)) {
                    // Удалить альбом
                    $v_params['action_name'] = "Удалить альбом";

                    if (isset($_GET['alb_id'])) {
                        $imgAlbumId = $_GET['alb_id'];
                        $imgAlbum = ImgAlbumUtil::getImgAlbumByID($imgAlbumId, 0);
                        if (NULL != $imgAlbum) {
                            $v_params['img_album_name'] = $imgAlbum['name'];
                            $v_params['img_album_desc'] = $imgAlbum['description'];
                            $v_params['img_album_pict_count'] = ImgPictureUtil::countImgPicturesByAlbumId($imgAlbumId);
                        }
                    } else {
                        header("Location: /superAdmin/albums");
                    }

                    if ($_POST['album_del_form']) {
                        if ($_POST['with_pict']) {
                            $img_pictures = ImgPictureUtil::getImgPicturesByAlbumId($imgAlbumId, 0);
                            if (count($img_pictures))
                                foreach ($img_pictures as $img_pucture) {
                                    $file_path = dirname(__FILE__) . "/../../application_data" . $img_pucture['path'];
                                    unlink($file_path);

                                    $path_blocks = explode("/", $img_pucture['path']);
                                    $last = count($path_blocks) - 1;
                                    $path_blocks[$last] = SMAL_PICT_PREFIX . $path_blocks[$last];
                                    $path_small = implode("/", $path_blocks);

                                    $smal_file_path = dirname(__FILE__) . "/../../application_data" . $path_small;
                                    unlink($smal_file_path);
                                }
                            ImgAlbumUtil::deleteImgAlbumByID($imgAlbumId, TRUE);
                        } else {
                            ImgAlbumUtil::deleteImgAlbumByID($imgAlbumId, FALSE);
                        }

                        header("Location: /superAdmin/albums");
                    } else {
                        Application::fastView('super-admin/albums/album_del', $v_params);
                        exit;
                    }
                } else if (0 == strcmp("show", $action)) {
                    $v_params['action_name'] = "Содержимое альбома";
                    $alb_id = (INT) $_GET['alb_id'];
                    $v_params['pict_control_url'] = "/superAdmin/picture";
                    $v_params['img_album'] = ImgAlbumUtil::getImgAlbumByID($alb_id, 0);
                    
                    if (NULL == $v_params['img_album']) {
                        $v_params['img_album_name'] = "Картинки без альбома";
                    } else {
                        $v_params['img_album_name'] = $v_params['img_album']['name'];
                    }

                    // Загрузка файлов
                    if ((NULL != $alb_id && NULL != $v_params['img_album']) || NULL == $alb_id) {
                        if (isset($_FILES) && NULL != $_FILES['file']) {
                            // директория для изображений
                            $images_dir = dirname(__FILE__) . "/../../application_data/images/";
                            foreach ($_FILES['file']['name'] as $k => $f) {
                                if (!$_FILES['file']['error'][$k]) {
                                    if (is_uploaded_file($_FILES['file']['tmp_name'][$k])) {
                                        $fn = UUIDGenerator::generate();
                                        $dir_path = $images_dir . "acc0/";
                                        $file_path = $dir_path . $fn;
                                        $rel_file_path = "/images/acc0/" . $fn;

                                        @mkdir($dir_path, 0766);

                                        @ImageUtil::create_small($_FILES['file']['tmp_name'][$k], $file_path, SIZE_BIG_PICT, SIZE_BIG_PICT);
                                        @ImageUtil::create_small($file_path, $dir_path . SMAL_PICT_PREFIX . $fn, SIZE_SMAL_PICT, SIZE_SMAL_PICT);
                                        unlink($_FILES['file']['tmp_name'][$k]);

                                        $imgPicture['account_id'] = 0;
                                        $imgPicture['album_id'] = $alb_id;
                                        $imgPicture['name'] = $_FILES['file']['name'][$k];
                                        $imgPicture['path'] = $rel_file_path;
                                        ImgPictureUtil::createImgPicture($imgPicture);
                                    }
                                }
                            }
                        }

                        if (NULL == $alb_id) {
                            $v_params['alb_pictures'] = ImgPictureUtil::getImgPicturesNoAlbum(0);
                        } else {
                            $v_params['alb_pictures'] = ImgPictureUtil::getImgPicturesByAlbumId($alb_id, 0);
                        }
                        
                        

                        Application::fastView('super-admin/albums/album_show', $v_params);
                        exit;
                    }
                }
            }
        } else {
            header("Location: /superAdmin/login");
        }
    }

    function pictureAction() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (LoginChecker::isAdmin()) {
            $v_params['picture'] = ImgPictureUtil::getImgPictureById($_GET[PICT_PARAM_NAME]);

            $v_params['img_album'] = ImgAlbumUtil::getImgAlbumByID($v_params['picture']['album_id'], 0);
            if (NULL == $v_params['img_album']) {
                $v_params['img_album_name'] = "Картинки без альбома";
            } else {
                $v_params['img_album_name'] = $v_params['img_album']['name'];
                $v_params['img_album_add_link'] = "&alb_id=" . $v_params['img_album']['id'];
            }
            $albumURL = "/superAdmin/album?act=show";

            if ($v_params['picture'] && $_POST['del_check']) {
                $file_path = dirname(__FILE__) . "/../../application_data" . $v_params['picture']['path'];
                @unlink($file_path);

                $path_blocks = explode("/", $v_params['picture']['path']);
                $last = count($path_blocks) - 1;
                $path_blocks[$last] = SMAL_PICT_PREFIX . $path_blocks[$last];
                $path_small = implode("/", $path_blocks);

                $smal_file_path = dirname(__FILE__) . "/../../application_data" . $path_small;
                @unlink($smal_file_path);

                if ($v_params['picture']['album_id']) {
                    $albumURL .= "&alb_id=" . $v_params['picture']['album_id'];
                }

                ImgPictureUtil::deleteImgPictureById($v_params['picture']['id']);
                header("Location: $albumURL");
            }

            Application::fastView('super-admin/picture', $v_params);
            exit;
        } else {
            header("Location: /superAdmin/login");
        }
    }

    function presentationAction() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (LoginChecker::isAdmin()) {
            $v_params['ssp'] = SysStaticPagesUtil::getSysStaticPageByName("presentation");
            if ($_POST['name_form']) {
                if (0 != strcmp("", $_POST['sys_name'])) {
                    $v_params['ssp']['title'] = trim($_POST['sys_name']);
                    SysStaticPagesUtil::updateSysStaticPage($v_params['ssp']);
                }
            }

            $v_params['ssp_blocks'] = SysStaticPageBlocksUtil::getSysStaticPageBlocksByPageId($v_params['ssp']['id']);

            Application::fastView('super-admin/static-page/static_page', $v_params);
            exit;
        } else {
            header("Location: /superAdmin/login");
        }
    }

    function FAQAction() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (LoginChecker::isAdmin()) {
            $v_params['ssp'] = SysStaticPagesUtil::getSysStaticPageByName("faq");
            if ($_POST['name_form']) {
                if (0 != strcmp("", $_POST['sys_name'])) {
                    $v_params['ssp']['title'] = trim($_POST['sys_name']);
                    SysStaticPagesUtil::updateSysStaticPage($v_params['ssp']);
                }
            }

            $v_params['ssp_blocks'] = SysStaticPageBlocksUtil::getSysStaticPageBlocksByPageId($v_params['ssp']['id']);

            Application::fastView('super-admin/static-page/static_page', $v_params);
            exit;
        } else {
            header("Location: /superAdmin/login");
        }
    }

    function pageBlockAction() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (LoginChecker::isAdmin()) {
            $img_albums = ImgAlbumUtil::getImgAlbumsByAccountID(0);
            $img_album_pictures = ImgPictureUtil::getImgPicturesNoAlbum(0);
            $v_params['img_albums'][] = array("name" => "Без альбома", "pictures" => $img_album_pictures);
            foreach ($img_albums as $img_album) {
                $img_album_pictures = ImgPictureUtil::getImgPicturesByAlbumId($img_album['id'], 0);
                $v_params['img_albums'][] = array("name" => $img_album['name'], "pictures" => $img_album_pictures);
            }

            $pageID = (INT) $_GET['corresp'];
            if (0 == strcmp("add", $_GET['act']) && $pageID) {
                $v_params['act_name'] = "Добавить блок";
                $v_params['num_tab'] = 0;

                if ($_POST['send_block_form']) {
                    $sysStaticPageBlock['sys_static_page_id'] = $_GET['corresp'];
                    $sysStaticPageBlock['order_in_page'] = (INT) $_POST['order'];
                    $sysStaticPageBlock['image_id'] = (INT) $_POST['pict_id'];
                    $sysStaticPageBlock['image_title'] = $_POST['img_desk'];

                    if (0 == (INT) $_POST['selected_tab']) {
                        $sysStaticPageBlock['block_type_id'] = 1;
                        $sysStaticPageBlock['text_content'] = $_POST['text_content_t'];
                    } else if (1 == (INT) $_POST['selected_tab']) {
                        $sysStaticPageBlock['block_type_id'] = 0;
                    } else if (2 == (INT) $_POST['selected_tab']) {
                        $sysStaticPageBlock['block_type_id'] = 2;
                        $sysStaticPageBlock['text_content'] = $_POST['text_content'];
                    }

                    $sspID = SysStaticPageBlocksUtil::insertSysStaticPageBlock($sysStaticPageBlock);
                    header("Location: /superAdmin/pageBlock?id=$sspID&act=upd&corresp=" . $_GET['corresp']);
                }
            } else if (0 == strcmp("upd", $_GET['act']) && $pageID && $_GET['id']) {
                $v_params['act_name'] = "Редактировать блок";

                if ($_POST['send_block_form']) {
                    $sysStaticPageBlock['id'] = $_GET['id'];
                    $sysStaticPageBlock['sys_static_page_id'] = $_GET['corresp'];
                    $sysStaticPageBlock['order_in_page'] = (INT) $_POST['order'];
                    $sysStaticPageBlock['image_id'] = (INT) $_POST['pict_id'];
                    $sysStaticPageBlock['image_title'] = $_POST['img_desk'];

                    if (0 == $_POST['selected_tab']) {
                        $sysStaticPageBlock['block_type_id'] = 1;
                        $sysStaticPageBlock['text_content'] = $_POST['text_content_t'];
                    } else if (1 == $_POST['selected_tab']) {
                        $sysStaticPageBlock['block_type_id'] = 0;
                    } else if (2 == $_POST['selected_tab']) {
                        $sysStaticPageBlock['block_type_id'] = 2;
                        $sysStaticPageBlock['text_content'] = $_POST['text_content'];
                    }

                    SysStaticPageBlocksUtil::updateSysStaticPageBlock($sysStaticPageBlock);
                }

                if ($_POST['send_block_form']) {
                    $v_params['ssp_block'] = $sysStaticPageBlock;
                } else {
                    $v_params['ssp_block'] = SysStaticPageBlocksUtil::getSysStaticPageBlockById($_GET['id']);
                }

                $v_params['num_tab'] = 0;
                if (0 == $v_params['ssp_block']['block_type_id'])
                    $v_params['num_tab'] = 1;
                else if (2 == $v_params['ssp_block']['block_type_id'])
                    $v_params['num_tab'] = 2;
            } else if (0 == strcmp("del", $_GET['act']) && $pageID && $_GET['id']) {
                $v_params['act_name'] = "Удалить блок";

                if (isset($_POST['del_block_form'])) {
                    SysStaticPageBlocksUtil::deleteSysStaticPageBlockById($_GET['id']);
                    header("Location: /superAdmin/presentation");
                }

                $v_params['ssp_block'] = SysStaticPageBlocksUtil::getSysStaticPageBlockById($_GET['id']);

                Application::fastView('super-admin/static-page/static_page_block_del', $v_params);
                return;
            }

            Application::fastView('super-admin/static-page/static_page_block_au', $v_params);
            exit;
        } else {
            header("Location: /superAdmin/login");
        }
    }

    function newsCatsAction() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (LoginChecker::isAdmin()) {
            $v_params['actname'] = "Управление категориями новостей";
            $v_params['sys_news_cats'] = SysNewsCatUtil::getSysNewsCats();
            Application::fastView('super-admin/news-cats/news_cats', $v_params);
            exit;
        } else {
            header("Location: /superAdmin/login");
        }
    }

    function newsCatAction() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (LoginChecker::isAdmin()) {
            $action = $_GET['act'];
            if (0 == strcmp("add", $action)) {
                $v_params['actname'] = "Добавить блок новостей";

                if (0 != strcmp("", trim($_POST['cat_name']))) {
                    $sysNewsCat['name'] = $_POST['cat_name'];
                    if (0 != (int) $_POST['parent_cat'])
                        $sysNewsCat['pid'] = $_POST['parent_cat'];

                    SysNewsCatUtil::insertSysNewsCat($sysNewsCat);
                    header("Location: /superAdmin/newsCats");
                }

                $v_params['sys_news_cats'] = SysNewsCatUtil::getSysNewsCats();
                Application::fastView('super-admin/news-cats/news_cat_au', $v_params);
                exit;
            } else if (0 == strcmp("upd", $action)) {
                $v_params['actname'] = "Редактировать блок новостей";
                $sysNewsCat = SysNewsCatUtil::getSysNewsCatByID($_GET['id']);

                if (0 != strcmp("", trim($_POST['cat_name']))) {
                    $sysNewsCat['name'] = $_POST['cat_name'];
                    if (0 != (int) $_POST['parent_cat'])
                        $sysNewsCat['pid'] = $_POST['parent_cat'];

                    SysNewsCatUtil::updateSysNewsCat($sysNewsCat);
                    header("Location: /superAdmin/newsCats");
                }

                $v_params['sys_news_cat'] = $sysNewsCat;
                $v_params['sys_news_cats'] = SysNewsCatUtil::getSysNewsCats();
                foreach ($v_params['sys_news_cats'] as $key => $sysNewsCat) {
                    if ($v_params['sys_news_cat']['id'] == $sysNewsCat['id'])
                        unset($v_params['sys_news_cats'][$key]);
                }

                Application::fastView('super-admin/news-cats/news_cat_au', $v_params);
                exit;
            } else if (0 == strcmp("del", $action)) {
                $v_params['actname'] = "Удалить блок новостей";
                $v_params['sys_news_cat'] = SysNewsCatUtil::getSysNewsCatByID($_GET['id']);

                if (isset($_POST['move_cat'])) {
                    $new_cat = $_POST['move_cat'];
                    SysNewsCatUtil::moveNewsCats($_GET['id'], $new_cat);
                    SysNewsArtUtil::moveNewsArtss($_GET['id'], $new_cat);
                    SysNewsCatUtil::deleteSysNewsCatById($v_params['sys_news_cat']['id']);

                    header("Location: /superAdmin/newsCats");
                }

                $v_params['sys_news_parent_cat'] = SysNewsCatUtil::getSysNewsCatByID($v_params['sys_news_cat']['pid']);

                $v_params['sys_news_cats'] = SysNewsCatUtil::getSysNewsCats();
                foreach ($v_params['sys_news_cats'] as $key => $sysNewsCat) {
                    if ($v_params['sys_news_cat']['id'] == $sysNewsCat['id'])
                        unset($v_params['sys_news_cats'][$key]);
                }

                Application::fastView('super-admin/news-cats/news_cat_del', $v_params);
                exit;
            }
        } else {
            header("Location: /superAdmin/login");
        }
    }

    function newsAction() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (LoginChecker::isAdmin()) {
            $v_params['img_blog_cats'] = SysNewsCatUtil::getSysNewsCats();
            $v_params['img_blog_arts'] = SysNewsArtUtil::getSysNewsArtsByFilter($_REQUEST["cat"], trim($_REQUEST["pname"]), ART_ON_PAGE * $_REQUEST[PAGE_PARAM_NAME], ART_ON_PAGE);
            $count_sys_news_arts = SysNewsArtUtil::getCountOfSysNewsArtsByFilter($_REQUEST["cat"], trim($_REQUEST["pname"]));
            for ($i = 0; $i < $count_sys_news_arts / ART_ON_PAGE; $i++) {
                $item['value'] = $i + 1;
                $item['current'] = ($i == $_REQUEST[PAGE_PARAM_NAME]);

                $url = "/superAdmin/news?";

                if ($_REQUEST["cat"])
                    $url = $url . "cat" . "=" . $_REQUEST["cat"] . "&";

                if ($_REQUEST["pname"])
                    $url = $url . "pname" . "=" . $_REQUEST["pname"] . "&";

                $item['url'] = $url . PAGE_PARAM_NAME . "=" . $i;

                $v_params['paginator'][] = $item;
            }

            Application::fastView('super-admin/news/news', $v_params);
            exit;
        } else {
            header("Location: /superAdmin/login");
        }
    }

    function newsArtAction() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (LoginChecker::isAdmin()) {
            if (0 == strcmp("add", $_GET['act'])) {
                $v_params['act_name'] = "Добавить новость";

                if (0 != strcmp("", $_POST['art_name']) && $_POST['cat_id'] && isset($_POST['pict_id']) && 0 != strcmp("", $_POST['art_name'])) {
                    $sysNewsArt['sys_news_cat_id'] = $_POST['cat_id'];
                    $sysNewsArt['title'] = $_POST['art_name'];
                    $sysNewsArt['preview'] = $_POST['preview'];
                    $sysNewsArt['main_pict_id'] = $_POST['pict_id'];

                    $id = SysNewsArtUtil::insertSysNewsArt($sysNewsArt);
                    $redirectURL = "/superAdmin/newsArt?id=$id&act=upd";
                    header("Location: $redirectURL");
                } else {
                    if ($_POST['add_head_form'])
                        $v_params['error_msg'] = "Введены не все поля";
                }

                $v_params['img_blog_cats'] = SysNewsCatUtil::getSysNewsCats();

                $img_albums = ImgAlbumUtil::getImgAlbumsByAccountID(0);
                $img_album_pictures = ImgPictureUtil::getImgPicturesNoAlbum(0);
                $v_params['img_albums'][] = array("name" => "Без альбома", "pictures" => $img_album_pictures);
                foreach ($img_albums as $img_album) {
                    $img_album_pictures = ImgPictureUtil::getImgPicturesByAlbumId($img_album['id'], 0);
                    $v_params['img_albums'][] = array("name" => $img_album['name'], "pictures" => $img_album_pictures);
                }

                Application::fastView('super-admin/news/news_page_a', $v_params);
                exit;
            } else if (0 == strcmp("upd", $_GET['act'])) {
                $v_params['act_name'] = "Редактировать новость";

                $v_params['img_news_art'] = SysNewsArtUtil::getSysNewsArtById($_GET['id']);

                if (0 != strcmp("", $_POST['art_name']) && $_POST['cat_id'] && isset($_POST['pict_id']) && 0 != strcmp("", $_POST['art_name'])) {
                    $v_params['img_news_art']['sys_news_cat_id'] = $_POST['cat_id'];
                    $v_params['img_news_art']['title'] = $_POST['art_name'];
                    $v_params['img_news_art']['preview'] = $_POST['preview'];
                    $v_params['img_news_art']['main_pict_id'] = $_POST['pict_id'];

                    SysNewsArtUtil::updateSysNewsArt($v_params['img_news_art']);
                } else {
                    if ($_POST['add_head_form'])
                        $v_params['error_msg'] = "Введены не все поля";
                }

                $v_params['ssp_blocks'] = SysNewsArtBlockUtil::getSysNewsArtBlocksByArtId($_GET['id']);

                $v_params['img_blog_cats'] = SysNewsCatUtil::getSysNewsCats();

                $img_albums = ImgAlbumUtil::getImgAlbumsByAccountID(0);
                $img_album_pictures = ImgPictureUtil::getImgPicturesNoAlbum(0);
                $v_params['img_albums'][] = array("name" => "Без альбома", "pictures" => $img_album_pictures);
                foreach ($img_albums as $img_album) {
                    $img_album_pictures = ImgPictureUtil::getImgPicturesByAlbumId($img_album['id'], 0);
                    $v_params['img_albums'][] = array("name" => $img_album['name'], "pictures" => $img_album_pictures);
                }

                Application::fastView('super-admin/news/news_page_u', $v_params);
                exit;
            } else if (0 == strcmp("del", $_GET['act'])) {
                $v_params['act_name'] = "Удалить новость";

                if ($_POST['artID']) {
                    SysNewsArtBlockUtil::deleteSysNewsArtBlocksByNewsArtId($_POST['artID']);
                    SysNewsArtUtil::deleteSysNewsArtById($_POST['artID']);
                    header("Location: /superAdmin/news");
                }

                $v_params['img_blog_cats'] = SysNewsCatUtil::getSysNewsCats();
                $v_params['img_blog_art'] = SysNewsArtUtil::getSysNewsArtById($_GET['id']);
                $v_params['img_blog_art_blocks'] = SysNewsArtBlockUtil::getSysNewsArtBlocksByArtId($_GET['id']);


                Application::fastView('super-admin/news/news_page_del', $v_params);
                exit;
            }
        } else {
            header("Location: /superAdmin/login");
        }
    }

    function newsBlockAction() {
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (LoginChecker::isAdmin()) {
            if (0 == strcmp("add", $_GET['act']) && isset($_GET['corresp'])) {
                $v_params['sys_news_art'] = SysNewsArtUtil::getSysNewsArtById($_GET['corresp']);
                if (isset($_POST['send_block_form'])) {
                    $sysNewsArtBlock['sys_news_art_id'] = $_GET['corresp'];
                    $sysNewsArtBlock['text_content'] = $_POST['text_content'];
                    $sysNewsArtBlock['order_in_art'] = (INT) $_POST['order'];
                    $sysNewsArtBlock['image_id'] = (INT) $_POST['pict_id'];
                    $sysNewsArtBlock['image_title'] = $_POST['img_desk'];

                    if (0 == $_POST['selected_tab']) {
                        $sysNewsArtBlock['block_type'] = 1;
                    } else if (1 == $_POST['selected_tab']) {
                        $sysNewsArtBlock['block_type'] = 0;
                    }

                    SysNewsArtBlockUtil::insertSysNewsArtBlock($sysNewsArtBlock);
                    $snaID = $v_params['sys_news_art']['id'];
                    header("Location: /superAdmin/newsArt?id=$snaID&act=upd");
                }

                $img_albums = ImgAlbumUtil::getImgAlbumsByAccountID(0);
                $img_album_pictures = ImgPictureUtil::getImgPicturesNoAlbum(0);
                $v_params['img_albums'][] = array("name" => "Без альбома", "pictures" => $img_album_pictures);
                foreach ($img_albums as $img_album) {
                    $img_album_pictures = ImgPictureUtil::getImgPicturesByAlbumId($img_album['id'], 0);
                    $v_params['img_albums'][] = array("name" => $img_album['name'], "pictures" => $img_album_pictures);
                }

                $v_params['act_name'] = "Добавить блок";
                $v_params['num_tab'] = 0;

                Application::fastView('super-admin/news/news_page_block_au', $v_params);
                exit;
            } else if (0 == strcmp("upd", $_GET['act']) && isset($_GET['corresp']) && isset($_GET['id'])) {
                $v_params['sys_news_art'] = SysNewsArtUtil::getSysNewsArtById($_GET['corresp']);
                $v_params['ssp_block'] = SysNewsArtBlockUtil::getSysNewsArtBlockById($_GET['id']);
                $v_params['act_name'] = "Редактировать блок";

                $img_albums = ImgAlbumUtil::getImgAlbumsByAccountID(0);
                $img_album_pictures = ImgPictureUtil::getImgPicturesNoAlbum(0);
                $v_params['img_albums'][] = array("name" => "Без альбома", "pictures" => $img_album_pictures);
                foreach ($img_albums as $img_album) {
                    $img_album_pictures = ImgPictureUtil::getImgPicturesByAlbumId($img_album['id'], 0);
                    $v_params['img_albums'][] = array("name" => $img_album['name'], "pictures" => $img_album_pictures);
                }

                $v_params['num_tab'] = 0;
                if (0 == $v_params['ssp_block']['block_type'])
                    $v_params['num_tab'] = 1;

                if (isset($_POST['send_block_form'])) {
                    $v_params['ssp_block']['sys_news_art_id'] = $_GET['corresp'];
                    $v_params['ssp_block']['text_content'] = $_POST['text_content'];
                    $v_params['ssp_block']['order_in_art'] = (INT) $_POST['order'];
                    $v_params['ssp_block']['image_id'] = (INT) $_POST['pict_id'];
                    $v_params['ssp_block']['image_title'] = $_POST['img_desk'];

                    if (0 == $_POST['selected_tab']) {
                        $v_params['ssp_block']['block_type'] = 1;
                    } else if (1 == $_POST['selected_tab']) {
                        $v_params['ssp_block']['block_type'] = 0;
                    }

                    SysNewsArtBlockUtil::updateSysNewsArtBlock($v_params['ssp_block']);
                }

                Application::fastView('super-admin/news/news_page_block_au', $v_params);
                exit;
            } else if (0 == strcmp("del", $_GET['act']) && isset($_GET['corresp']) && isset($_GET['id'])) {
                $v_params['sys_news_art'] = SysNewsArtUtil::getSysNewsArtById($_GET['corresp']);
                if (isset($_POST['send_block_form'])) {
                    SysNewsArtBlockUtil::deleteSysNewsArtBlockById($_GET['id']);
                    $snaID = $v_params['sys_news_art']['id'];
                    header("Location: /superAdmin/newsArt?id=$snaID&act=upd");
                }

                $v_params['ssp_block'] = SysNewsArtBlockUtil::getSysNewsArtBlockById($_GET['id']);
                $v_params['act_name'] = "Удалить блок";

                Application::fastView('super-admin/news/news_page_block_del', $v_params);
                exit;
            }
        } else {
            header("Location: /superAdmin/login");
        }
    }

}
