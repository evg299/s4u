<?php

require_once dirname(__FILE__) . "/../../models/__DBMODEL__.php";
require_once dirname(__FILE__) . "/../../utils/view/AddressUtil.php";
require_once dirname(__FILE__) . "/../../utils/admin/LoginChecker.php";
require_once dirname(__FILE__) . "/../../utils/other/CardCounter.php";

/**
 *
 */
class indexController {

    function indexAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            $v_params['in_card_count'] = CardCounter::countGDSinCard();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
            }

            $v_params['show_addr'] = $imgAccount['show_address'];
            $imgAddress = ImgAddressUtil::getImgAddressById($imgAccount['img_address_id']);
            $v_params['addr'] = AddressUtil::makeAddressString($imgAddress);

            $v_params['show_phone'] = $imgAccount['show_phone'];
            $v_params['phone'] = $imgAccount['img_phone'];

            $v_params['show_skype'] = $imgAccount['show_skype'];
            $v_params['skype'] = $imgAccount['img_skype'];

            $v_params['show_icq'] = $imgAccount['show_icq'];
            $v_params['icq'] = $imgAccount['img_icq'];

            $v_params['img_name'] = $imgAccount['img_name'];
            $v_params['img_slog'] = $imgAccount['img_slog'];

            $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
            $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");

            $v_params['img_gds_breadcrump_HTML'] = ImgGdsCatUtil::createBreadcrumpHTML($imgAccount['id'], $_REQUEST[PROD_CAT_PARAM_NAME]);

            $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
            $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

            $count_img_gdss = ImgGdsUtil::countImgGdssByAccountId($imgAccount['id'], $_REQUEST[PROD_CAT_PARAM_NAME]);
            for ($i = 0; $i < $count_img_gdss / GDS_ON_PAGE; $i++) {
                $item['value'] = $i + 1;
                $item['current'] = ($i == $_REQUEST[PAGE_PARAM_NAME]);
                if ($_REQUEST[PROD_CAT_PARAM_NAME])
                    $item['url'] = "/" . IMAG_PREFIX . $img_id . "/?" . PROD_CAT_PARAM_NAME . "=" . $_REQUEST[PROD_CAT_PARAM_NAME] . "&" . PAGE_PARAM_NAME . "=" . $i;
                else
                    $item['url'] = "/" . IMAG_PREFIX . $img_id . "/?" . PAGE_PARAM_NAME . "=" . $i;

                $v_params['paginator'][] = $item;
            }

            $v_params['img_gdss'] = ImgGdsUtil::getImgGdssByAccountId($imgAccount['id'], $_REQUEST[PROD_CAT_PARAM_NAME], GDS_ON_PAGE * $_REQUEST[PAGE_PARAM_NAME], GDS_ON_PAGE);
            $v_params['img_gdss_new'] = ImgGdsUtil::getNewImgGdssByAccountId($imgAccount['id'], $_REQUEST[PROD_CAT_PARAM_NAME], GDS_ADDITIONAN_ON_PAGE);
            $v_params['img_gdss_recom'] = ImgGdsUtil::getRecommendedImgGdssByAccountId($imgAccount['id'], $_REQUEST[PROD_CAT_PARAM_NAME], GDS_ADDITIONAN_ON_PAGE);
            $v_params['img_gds_link'] = "/" . IMAG_PREFIX . $img_id . "/" . PRODUCT_DIR . "?" . PRODUCT_PARAM_NAME . "=";

            Application::fastView('imags/img_main', $v_params);
        } else {
            Application::fastView('main/sys_error', $v_params);
        }
    }

    function productAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        $v_params['img_gds'] = ImgGdsUtil::getImgGdsByIdAndAccountId($_REQUEST[PRODUCT_PARAM_NAME], $imgAccount['id']);

        if (NULL != $imgAccount && NULL != $v_params['img_gds']) {
            $v_params['logined'] = LoginChecker::isLogined();
            $v_params['in_card_count'] = CardCounter::countGDSinCard();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
            }

            $v_params['show_add_gds'] = !isset($_COOKIE["gds" . $_REQUEST[PRODUCT_PARAM_NAME]]);

            $v_params['img_name'] = $imgAccount['img_name'];
            $v_params['img_slog'] = $imgAccount['img_slog'];

            $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
            $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");

            $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
            $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

            $v_params['img_root_url'] = "/" . IMAG_PREFIX . $img_id . "/";
            $v_params['img_gds_breadcrump_HTML'] = ImgGdsCatUtil::createBreadcrumpHTMLByProductId($imgAccount['id'], $_REQUEST[PRODUCT_PARAM_NAME]);

            $v_params['img_gds_props'] = ImgGdsPropUtil::getImgGdsProps($_REQUEST[PRODUCT_PARAM_NAME]);
            $v_params['img_gdss_smil'] = ImgGdsUtil::getSmilaryImgGdss($imgAccount['id'], $v_params['img_gds']['img_gds_cat_id'], $_REQUEST[PRODUCT_PARAM_NAME]);
            $v_params['img_gds_link'] = "/" . IMAG_PREFIX . $imgAccount['id'] . "/" . PRODUCT_DIR . "?" . PRODUCT_PARAM_NAME . "=";

            $v_params['img_gds_descr'] = ImgGdsUtil::getDescriptionOfImgGds($_REQUEST[PRODUCT_PARAM_NAME]);

            Application::fastView('imags/img_product', $v_params);
        } else {
            Application::fastView('main/sys_error', NULL);
        }
    }

    function blogAction() {
        $img_id = $_SESSION['imag_id'];
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");

        if (NULL != $imgAccount) {
            $v_params['logined'] = LoginChecker::isLogined();
            $v_params['in_card_count'] = CardCounter::countGDSinCard();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
            }

            $v_params['img_name'] = $imgAccount['img_name'];
            $v_params['img_slog'] = $imgAccount['img_slog'];

            $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
            $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");

            $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
            $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

            $v_params['img_blog_breadcrump_HTML'] = ImgBlogCatUtil::createBreadcrumpHTML($imgAccount['id'], $_REQUEST[ART_CAT_PARAM_NAME]);

            $v_params['img_blog_arts'] = ImgBlogArtUtil::getImgBlogArtsByAccountIdAndImgBlogCatId($imgAccount['id'], $_REQUEST[ART_CAT_PARAM_NAME], ART_ON_PAGE * $_REQUEST[PAGE_PARAM_NAME], ART_ON_PAGE);
            $v_params['img_art_link'] = "/" . IMAG_PREFIX . $imgAccount['id'] . "/" . ARTICLE_DIR . "?" . ART_PARAM_NAME . "=";

            $count_img_arts = ImgBlogArtUtil::getCountOfImgBlogArtByAccountIdAndImgBlogCatId($imgAccount['id'], $_REQUEST[ART_CAT_PARAM_NAME]);
            for ($i = 0; $i < $count_img_arts / ART_ON_PAGE; $i++) {
                $item['value'] = $i + 1;
                $item['current'] = ($i == $_REQUEST[PAGE_PARAM_NAME]);
                if ($_REQUEST[ART_CAT_PARAM_NAME])
                    $item['url'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "/?" . ART_CAT_PARAM_NAME . "=" . $_REQUEST[ART_CAT_PARAM_NAME] . "&" . PAGE_PARAM_NAME . "=" . $i;
                else
                    $item['url'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "/?" . PAGE_PARAM_NAME . "=" . $i;

                $v_params['paginator'][] = $item;
            }

            Application::fastView('imags/img_blog_category', $v_params);
        } else {
            Application::fastView('main/sys_error', NULL);
        }
    }

    function articleAction() {
        $img_id = $_SESSION['imag_id'];
        $v_params['sys_name'] = SysPropertiesUtil::getPropertyValue("sys_name");
        $v_params['sys_slog'] = SysPropertiesUtil::getPropertyValue("sys_slog");
        $imgAccount = ImgAccountUtil::getImgAccountById($img_id, TRUE);
        $imgArticle = ImgBlogArtUtil::getImgBlogArtById($img_id, $_REQUEST[ART_PARAM_NAME]);

        if (NULL != $imgAccount && NULL != $imgArticle) {
            $v_params['logined'] = LoginChecker::isLogined();
            $v_params['in_card_count'] = CardCounter::countGDSinCard();
            if ($v_params['logined'] == $img_id) {
                $v_params['mysc']['main'] = TRUE;
            }

            $v_params['img_name'] = $imgAccount['img_name'];
            $v_params['img_slog'] = $imgAccount['img_slog'];

            $v_params['img_all_gds_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR;
            $v_params['img_gds_cats_HTML'] = ImgGdsCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . IMAG_DIR . "?" . PROD_CAT_PARAM_NAME . "=");

            $v_params['img_all_blog_cats_href'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR;
            $v_params['img_blog_cats_HTML'] = ImgBlogCatUtil::createTreeHTML($imgAccount['id'], "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "?" . ART_CAT_PARAM_NAME . "=");

            $v_params['img_blog_url'] = "/" . IMAG_PREFIX . $img_id . "/" . BLOG_DIR . "/";

            $v_params['img_blog_breadcrump_HTML'] = ImgBlogCatUtil::createBreadcrumpHTML($imgAccount['id'], $imgArticle['img_blog_cat_id']);

            $v_params['img_article'] = $imgArticle;
            $v_params['img_blog_art_blocks'] = ImgBlogArtBlockUtil::getImgBlogArtBlocksByArtId($imgArticle['id']);

            Application::fastView('imags/img_article', $v_params);
        } else {
            Application::fastView('main/sys_error', NULL);
        }
    }

}
