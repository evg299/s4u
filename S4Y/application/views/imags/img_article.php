<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?> | <?= $v_params['img_article']['name']; ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />

        <!-- Put this script tag to the <head> of your page -->
        <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?52"></script>

        <script type="text/javascript">
            VK.init({
                apiId : <?= VK_APIID ?>,
                onlyWidgets : true
            });
        </script>
    </head>
    <body>
        <div id="header">
            <? require_once dirname(__FILE__) . "/../blocks/com_name_logo.php"; ?>
            <? require_once dirname(__FILE__) . "/../blocks/com_main_menu.php"; ?>
        </div>
        <table id="wraper">
            <tr style="vertical-align: top;">
                <td id="left">
                    <? if ($v_params['mysc']['main']): ?>
                        <? require_once dirname(__FILE__) . "/../blocks/img_admin_panel.php"; ?>
                    <? else: ?>
                        <? require_once dirname(__FILE__) . "/../blocks/sys_basket.php"; ?>
                    <? endif; ?>
                    <br />
                    <? require_once dirname(__FILE__) . "/../blocks/img_product_categories.php"; ?>
                    <br />
                    <? require_once dirname(__FILE__) . "/../blocks/img_blog_categories.php"; ?>
                </td>
                <td id="center">
                    <? require_once dirname(__FILE__) . "/../blocks/img_name.php"; ?>

                    <div class="sc_block">
                        <div class="sc_block_head"> 
                            <a href="<?= $v_params['img_blog_url']; ?>">Статьи</a>
                            <?= $v_params['img_blog_breadcrump_HTML']; ?>
                        </div>
                    </div>

                    <div class="sc_block">
                        <h3 class="blog_text_title">
                            <?= $v_params['img_article']['name']; ?>
                        </h3>
                        <div class="blog_date">
                            Дата создания: <?=  date("d.m.Y", strtotime($v_params['img_article']['creation_date'])); ?>
                        </div>

                        <!-- Put this div tag to the place, where the Like block will be -->
                        <div id="vk_like" style="margin-left: 10px;"></div>
                        <script type="text/javascript">
                            VK.Widgets.Like("vk_like", {type: "button", verb: 1});
                        </script>
                        
                        <? if (0 != count($v_params['img_blog_art_blocks'])): ?>
                            <? foreach ($v_params['img_blog_art_blocks'] as $imgBlogArtBlock) : ?>
                                <? if (0 == $imgBlogArtBlock['block_type']) : ?>
                                    <div style="text-align: center; margin-top: 15px;">
                                        <a href="/picture?<?= PICT_PARAM_NAME; ?>=<?= $imgBlogArtBlock['img_picture_id']; ?>" target="blank"><img  class="blog_img" src="/picture?<?= PICT_PARAM_NAME; ?>=<?= $imgBlogArtBlock['img_picture_id']; ?>" /></a>
                                        <div style="font-size: small;"><?= $imgBlogArtBlock['pict_desc']; ?></div>
                                    </div>
                                <? elseif (1 == $imgBlogArtBlock['block_type']) : ?>
                                    <p><?= $imgBlogArtBlock['text_content']; ?></p>
                                <? endif; ?>
                            <? endforeach; ?>
                        <? else: ?>
                            <p style="text-align: center;">Содержимое статьи отсутствует</p>
                        <? endif; ?>
                    </div>

                    <!-- Put this div tag to the place, where the Comments block will be -->
                    <div id="vk_comments"></div>
                    <script type="text/javascript">
                        VK.Widgets.Comments("vk_comments", {
                            limit : 10,
                            width : "710",
                            attach : "*"
                        });
                    </script>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
