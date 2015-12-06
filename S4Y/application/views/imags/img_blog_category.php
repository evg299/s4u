<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />
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
                            <a href="<?= $_SERVER['REDIRECT_URL']; ?>">Статьи</a>
                            <?= $v_params['img_blog_breadcrump_HTML']; ?>
                        </div>
                    </div>

                    <div class="sc_block">
                        <?  $cnt = count($v_params['img_blog_arts']);
                            $iter = 0;
                            if (0 < $cnt) : ?>
                            <? foreach ($v_params['img_blog_arts'] as $img_blog_art) : ?>
                                <table class="<? if($cnt == ++$iter) {echo "last_preview_table";} else {echo "preview_table";} ?>">
                                    <tr valign="top">
                                        <td style="width: 255px;">
                                            <a href="<?= $v_params['img_art_link'] . $img_blog_art['id']; ?>"><img class="preview_table_img" src="/thumbPicture?<?= PICT_PARAM_NAME; ?>=<?= $img_blog_art['main_pict_id']; ?>"  /></a>
                                        </td>
                                        <td>
                                            <div class="blog_text_preview">
                                                <div class="blog_text_title_preview"><a href="<?= $v_params['img_art_link'] . $img_blog_art['id']; ?>"><?= $img_blog_art['name']; ?></a></div>
                                                <div class="blog_date_preview">
                                                    Дата создания: <?=  date("d.m.Y", strtotime($img_blog_art['creation_date'])); ?>
                                                </div>
                                                <div>
                                                    <?= $img_blog_art['preview']; ?>
                                                </div>
                                                <div class="blog_read_all">
                                                    <a href="<?= $v_params['img_art_link'] . $img_blog_art['id']; ?>">Читать полностью >></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            <? endforeach; ?>
                        <? endif; ?>
                    </div>

                    <? require_once dirname(__FILE__) . "/../blocks/com_paginator.php"; ?>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
