<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?> | <? echo $v_params['action']; ?> блок</title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />
        <link rel="stylesheet" href="/assets/local/css/tabs.css" />
    </head>
    <body>
        <div id="header">
            <? require_once dirname(__FILE__) . "/../../blocks/com_name_logo.php"; ?>
            <? require_once dirname(__FILE__) . "/../../blocks/com_main_menu.php"; ?>
        </div>
        <table id="wraper">
            <tr style="vertical-align: top;">
                <td id="left">
                    <? require_once dirname(__FILE__) . "/../../blocks/img_admin_panel.php"; ?>
                    <br />
                    <? require_once dirname(__FILE__) . "/../../blocks/img_product_categories.php"; ?>
                    <br />
                    <? require_once dirname(__FILE__) . "/../../blocks/img_blog_categories.php"; ?>
                </td>
                <td id="center">
                    <div class="sc_block">
                        <div class="sc_block_head"> 
                            <a href="/<? echo IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/ARTs">Управление статьями</a>
                            >>
                            <a href="ART?id=<? echo $v_params['img_blog_art']['id']; ?>&act=upd"><? echo $v_params['img_blog_art']['name']; ?></a>
                            >>
                            <? echo $v_params['action']; ?> блок

                            <? echo $v_params['act_name']; ?>
                        </div>
                    </div>

                    <div class="sc_block">
                        <div class="sc_block_head">
                            Удаляемый блок статьи
                        </div>

                        <form name="del_block_form" method="post">
                            <input type="hidden" name="del_block_form" value="true" />

                            <?php if (0 == $v_params['img_blog_art_block']['block_type']) : ?>
                                <div class="art_block">
                                    <div style="text-align: center; margin-top: 15px;">
                                        <a href="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $v_params['img_blog_art_block']['img_picture_id']; ?>" target="blank"><img  class="blog_img" src="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $v_params['img_blog_art_block']['img_picture_id']; ?>" /></a>
                                        <div style="font-size: small;"><?php echo $v_params['img_blog_art_block']['pict_desc']; ?></div>
                                    </div>
                                </div>
                            <?php elseif (1 == $v_params['img_blog_art_block']['block_type']) : ?>
                                <div class="art_block">
                                    <p><?php echo $v_params['img_blog_art_block']['text_content']; ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="art_block" style="width: 120px; text-align: center;"><a style="cursor: pointer;" onclick="document.forms['del_block_form'].submit();">Удалить</a></div>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
