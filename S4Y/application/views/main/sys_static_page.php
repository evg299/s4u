<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?php echo $v_params['sys_static_page']['title']; ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="assets/local/css/alll.css" />
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
                        <h3 class="blog_text_title">
                            <?= $v_params['sys_static_page']['title']; ?>
                        </h3>

                        <? if (count($v_params['sys_static_page_blocks'])): ?>
                            <? foreach ($v_params['sys_static_page_blocks'] as $sysStaticPageBlock) : ?>
                                <? if (0 == $sysStaticPageBlock['block_type_id']) : ?>
                                    <div style="text-align: center;">
                                        <a href="/picture?<?= PICT_PARAM_NAME; ?>=<?= $sysStaticPageBlock['image_id']; ?>" target="blank"><img class="blog_img" src="/picture?<?= PICT_PARAM_NAME; ?>=<?= $sysStaticPageBlock['image_id']; ?>" /></a>
                                        <div class="blog_img_text"><?= $sysStaticPageBlock['image_title']; ?></div>
                                    </div>
                                <? elseif (1 == $sysStaticPageBlock['block_type_id']) : ?>
                                    <p><?= $sysStaticPageBlock['text_content']; ?></p>
                                <? elseif (2 == $sysStaticPageBlock['block_type_id']) : ?>
                                    <ol style="margin-right: 25px;"><?= $sysStaticPageBlock['text_content']; ?></ol>
                                <? endif; ?>
                            <? endforeach; ?>
                        <? else: ?>
                            <p style="text-align: center;">Содержимое отсутствует</p>
                        <? endif; ?>
                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . '/../blocks/com_footer.php'; ?>
        </div>
    </body>
</html>
