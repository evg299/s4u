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
                        <form name="add_form" method="POST">
                            <table class="sc_block_content_table">
                                <tr>
                                    <td class="sc_contact_name">
                                        Название
                                    </td>
                                    <td>
                                        <input type="text" name="cat_name" style="width: 400px;" value="<? echo $v_params['sys_news_cat']['name']; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        Родительская категория
                                    </td>
                                    <td>
                                        <select name="parent_cat">
                                            <option <? if($v_params['sys_news_cat']['pid']) { echo "selected"; } ?> value="">Нет родительской</option>
                                            <? foreach ($v_params['sys_news_cats'] as $sysNewsCat): ?>
                                                <option <? if($v_params['sys_news_cat']['pid'] == $sysNewsCat['id']) { echo "selected"; } ?> value="<? echo $sysNewsCat['id']; ?>"><? echo $sysNewsCat['name']; ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <div class="button" style="width: 70px; margin: 3px auto;"><a class="a_clear" onclick="document.forms['add_form'].submit();">Сохранить</a></div>
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
