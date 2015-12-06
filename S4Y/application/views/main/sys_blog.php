<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | Новости проекта</title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />
    </head>
    <body>
        <div id="header">
            <? require_once dirname(__FILE__) . '/../blocks/com_name_logo.php'; ?>
            <? require_once dirname(__FILE__) . '/../blocks/com_main_menu.php'; ?>
        </div>
        <table id="wraper">
            <tr style="vertical-align: top;">
                <td id="left">
                    <? require_once dirname(__FILE__) . '/../blocks/sys_basket.php'; ?>
                    <br />
                    <? if (!$v_params['logined']): ?>
                        <? require_once dirname(__FILE__) . '/../blocks/sys_login.php'; ?>
                        <br />
                    <? endif; ?>
                    <? require_once dirname(__FILE__) . '/../blocks/sys_blog_categories.php'; ?>
                </td>
                <td id="center">
                    <div class="sc_block">
                        <div class="sc_block_head"> 
                            <a href="<?= $_SERVER['REDIRECT_URL']; ?>">Новости проекта</a>
                            <?= $v_params['newsblog_breadcrump_HTML']; ?>
                        </div>
                    </div>

                    <? $cnt = count($v_params['sys_news_arts']);
                        $iter = 0;
                        if (0 < $cnt) : ?>
                        <div class="sc_block">
                            <? foreach ($v_params['sys_news_arts'] as $sys_news_art) : ?>
                                <table class="<? if($cnt == ++$iter) {echo "last_preview_table";} else {echo "preview_table";} ?>">
                                    <tr valign="top">
                                        <td style="width: 255px;">
                                            <a href="<?= $v_params['sys_news_link'] . $sys_news_art['id']; ?>"><img class="preview_table_img" src="/thumbPicture?<?= PICT_PARAM_NAME; ?>=<?= $sys_news_art['main_pict_id']; ?>" /></a>
                                        </td>
                                        <td>
                                            <div class="blog_text_preview">
                                                <div class="blog_text_title_preview"><a href="<?= $v_params['sys_news_link'] . $sys_news_art['id']; ?>"><?= $sys_news_art['title']; ?></a></div>
                                                <div class="blog_date_preview">
                                                    Дата создания: <?=  date("d.m.Y", strtotime($sys_news_art['c_date'])); ?>
                                                </div>
                                                <div>
                                                    <?= $sys_news_art['preview']; ?>
                                                </div>
                                                <div class="blog_read_all">
                                                    <a href="<?= $v_params['sys_news_link'] . $sys_news_art['id']; ?>">Читать полностью >></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            <? endforeach; ?>
                        <? endif; ?>
                    </div>

                    <? require_once dirname(__FILE__) . '/../blocks/com_paginator.php'; ?>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . '/../blocks/com_footer.php'; ?>
        </div>
    </body>
</html>
