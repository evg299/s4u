<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name']; ?> | Супер Админский блок | <?= $v_params['action_name']; ?></title>
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
                    <? require_once dirname(__FILE__) . "/../../blocks/super_navigation.php"; ?>
                </td>
                <td id="center">
                    <div class="sc_block" style="text-align: right;">
                        <a href="/superAdmin/logout">Выйти</a>
                    </div>
                    <div class="sc_block">
                        <div class="sc_block_head">
                            <?= $v_params['action_name']; ?>
                        </div>
                        <form name="album_form" method="post">
                            <div style="margin-top: 15px; color: red; text-align: center;">
                                <?php if (count($v_params['messages'])): ?>
                                    <?php foreach ($v_params['messages'] as $message): ?>
                                        <div>
                                            <?php echo $message; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <table class="sc_block_content_table">
                                <tr>
                                    <td class="sc_contact_name">
                                        Название
                                    </td>
                                    <td>
                                        <input type="text" name="img_album_name" style="width: 400px;" value="<? echo $v_params['img_album_name']; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        Описание
                                    </td>
                                    <td>
                                        <textarea name="img_album_desc" rows="5" style="width: 400px;"><? echo $v_params['img_album_desc']; ?></textarea>
                                    </td>
                                </tr>
                            </table>
                            <div class="button" style="width: 120px; margin: 3px auto;" onclick="document.forms['album_form'].submit();"><? echo $v_params['action_name']; ?></div>
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
