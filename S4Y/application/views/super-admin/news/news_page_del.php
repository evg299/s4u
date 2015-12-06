<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name']; ?> | Супер Админский блок | <?= $v_params['act_name']; ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />
        <link rel="stylesheet" href="/assets/local/css/tabs.css" />
        <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
        <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    </head>
    <body>
        <div id="header">
            <? require_once dirname(__FILE__) . "/../../blocks/com_name_logo.php"; ?>
            <? require_once dirname(__FILE__) . "/../../blocks/com_main_menu.php"; ?>
        </div>
        <table id="wraper">
            <tr style="vertical-align: top;">
                <td id="left">
                    <? require_once dirname(__FILE__) . "/../../blocks/super_navigation.php"; ?>
                </td>
                <td id="center">
                    <div class="sc_block" style="text-align: right;">
                        <a href="/superAdmin/logout">Выйти</a>
                    </div>
                    <div class="sc_block">
                        <div class="sc_block_head">
                            Свойства новости
                        </div>
                        <div style="text-align: center; margin: 9px auto;">
                            <div align="center" style="color: red;">
                                <? echo $v_params['error_msg']; ?>
                            </div>

                            <table class="sc_block_content_table" style="width: 100%;">
                                <tr>
                                    <td align="right" style="font-weight: bold; width: 100px;">Название</td>
                                    <td align="left"><? echo $v_params['img_blog_art']['title']; ?></td>
                                </tr>
                                <tr>
                                    <td align="right" style="font-weight: bold; width: 100px;">Категория</td>
                                    <td align="left">
                                        <? foreach ($v_params['img_blog_cats'] as $imgBlogcat): ?>
                                            <? if ($imgBlogcat['id'] == $v_params['img_blog_art']['sys_news_cat_id']) echo $imgBlogcat['name']; ?>
                                        <? endforeach; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="font-weight: bold; width: 100px;">Изображение</td>
                                    <td align="left">
                                        <div align="center">
                                            <img id="selected_img" style="margin: 0 auto; 
                                                 border: solid gray 1px;
                                                 -webkit-border-radius: 4px;
                                                 -moz-border-radius: 4px;
                                                 border-radius: 4px;
                                                 min-height: 100px;
                                                 min-width: 100px;" src="/thumbPicture?pict_id=<? echo $v_params['img_blog_art']['main_pict_id']; ?>" />
                                            <input id="selected_img_id" type="hidden" name="pict_id" value="<? echo $v_params['img_blog_art']['main_pict_id']; ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="font-weight: bold; width: 100px;">Превью</td>
                                    <td align="left"><? echo $v_params['img_blog_art']['preview']; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="sc_block">
                        <div class="sc_block_head">
                            Содержимое новости
                        </div>

                        <?php if (0 != count($v_params['img_blog_art_blocks'])): ?>
                            <?php foreach ($v_params['img_blog_art_blocks'] as $imgBlogArtBlock) : ?>
                                <?php if (0 == $imgBlogArtBlock['block_type']) : ?>
                                    <div class="art_block">
                                        <div style="text-align: center; margin-top: 15px;">
                                            <a href="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $imgBlogArtBlock['image_id']; ?>" target="blank"><img  class="blog_img" src="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $imgBlogArtBlock['image_id']; ?>" /></a>
                                            <div style="font-size: small;"><?php echo $imgBlogArtBlock['image_title']; ?></div>
                                        </div>
                                    </div>
                                <?php elseif (1 == $imgBlogArtBlock['block_type']) : ?>
                                    <div class="art_block">
                                        <p><?php echo $imgBlogArtBlock['text_content']; ?></p>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="text-align: center;">В этой новости еще не добавлено блоков</p>
                        <?php endif; ?>

                        <form name="del_art_form" method="post">
                            <input type="hidden" name="artID" value="<? echo $v_params['img_blog_art']['id']; ?>" />
                            <div class="art_block" style="width: 120px; text-align: center;" onclick="document.forms['del_art_form'].submit();"><a style="cursor: pointer;">Удалить эту новость</a></div>
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
