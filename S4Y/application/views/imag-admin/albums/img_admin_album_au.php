<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?> | <? echo $v_params['action_name']; ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />
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
                            <a href="/<?= IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/albums">Альбомы</a>
                        </div>
                    </div>
                    <div class="sc_block">
                        <div class="sc_block_head">
                            <? echo $v_params['action_name']; ?>
                        </div>
                        <form name="album_form" method="post">
                            <div style="margin-top: 15px; color: red; text-align: center;">
                                <? if (count($v_params['messages'])): ?>
                                    <? foreach ($v_params['messages'] as $message): ?>
                                        <div>
                                            <?= $message; ?>
                                        </div>
                                    <? endforeach; ?>
                                <? endif; ?>
                            </div>
                            <table class="sc_block_content_table">
                                <tr>
                                    <td class="sc_contact_name">
                                        Название
                                    </td>
                                    <td>
                                        <input type="text" name="img_album_name" style="width: 400px;" value="<?= $v_params['img_album_name']; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        Описание
                                    </td>
                                    <td>
                                        <textarea name="img_album_desc" rows="5" style="width: 400px;"><?= $v_params['img_album_desc']; ?></textarea>
                                    </td>
                                </tr>
                            </table>
                            <div class="button" style="width: 120px; margin: 3px auto;" onclick="document.forms['album_form'].submit();"><?= $v_params['action_name']; ?></div>
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
