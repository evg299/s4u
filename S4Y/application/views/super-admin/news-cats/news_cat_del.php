<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name']; ?> | Супер Админский блок | <? echo $v_params['actname']; ?></title>
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
                            <? echo $v_params['actname']; ?>
                        </div>
                        <form name="del_form" method="POST">
                            <table class="sc_block_content_table">
                                <tr>
                                    <td class="sc_contact_name" style="width: 150px;">
                                        Название
                                    </td>
                                    <td>
                                        <? echo $v_params['sys_news_cat']['name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name" style="width: 150px;">
                                        Родительская категория
                                    </td>
                                    <td>
                                        <? echo $v_params['sys_news_parent_cat']['name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name" style="width: 150px;">
                                        Перенести содержимое в
                                    </td>
                                    <td>
                                        <select name="move_cat">
                                            <? foreach ($v_params['sys_news_cats'] as $sysNewsCat): ?>
                                                <option value="<?= $sysNewsCat['id']; ?>"><?= $sysNewsCat['name']; ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <? if (count($v_params['sys_news_cats'])): ?>
                                <div class="button" style="width: 70px; margin: 3px auto;"><a class="a_clear" onclick="document.forms['del_form'].submit();">Удалить</a></div>
                            <? else: ?>
                                <div align="center" style="margin: 8px;">Удаление не возможно, т.к. это последняя категория</div>
                            <? endif; ?>
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
