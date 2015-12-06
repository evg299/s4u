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
                            <? echo $v_params['action_name']; ?>
                        </div>
                        <form name="album_del_form" method="post">
                            <input type="hidden" name="album_del_form" value="album_del_form" />
                            <table class="sc_block_content_table">
                                <tr>
                                    <td class="sc_contact_name">
                                        Название
                                    </td>
                                    <td>
                                        <? echo $v_params['img_album_name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        Описание
                                    </td>
                                    <td>
                                        <? echo $v_params['img_album_desc']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        Количество картинок
                                    </td>
                                    <td>
                                        <? echo $v_params['img_album_pict_count']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        <input type="checkbox" name="with_pict" />
                                    </td>
                                    <td>
                                        Удалить вместе с содержимым
                                    </td>
                                </tr>
                            </table>
                            <div class="button" style="width: 120px; margin: 3px auto;" onclick="document.forms['album_del_form'].submit();"><? echo $v_params['action_name']; ?></div>
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
