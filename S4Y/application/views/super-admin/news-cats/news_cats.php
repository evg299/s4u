<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name']; ?> | Супер Админский блок | Категории новостей</title>
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
                        <div style="padding-top: 10px; margin: 0 13px;">
                            <? $line_number = 1; ?>
                            <? if (count($v_params['sys_news_cats'])): ?>
                                <? foreach ($v_params['sys_news_cats'] as $sysNewsCat): ?>
                                    <div style="margin-bottom: 15px; padding-bottom: 5px; border-bottom: dotted 1px gainsboro;">
                                        <div><a href="<? echo $v_params['url_prefix'] . "news?cat=" . $sysNewsCat['id']; ?>"><h3><? echo $line_number++ . ". " . $sysNewsCat['name']; ?></h3></a></div>
                                        <div style="text-align: right;"><a href="<? echo "newsCat?act=upd&id=" . $sysNewsCat['id']; ?>">Изменить</a></div>
                                        <div style="text-align: right;"><a href="<? echo "newsCat?act=del&id=" . $sysNewsCat['id']; ?>">Удалить</a></div>
                                    </div>
                                <? endforeach; ?>
                            <? endif; ?>
                        </div>
                        <div class="button" style="width: 70px; margin: 3px auto;"><a class="a_clear" href="<?=  "newsCat?act=add"; ?>">Создать</a></div>
                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
