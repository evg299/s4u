<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name']; ?> | Супер Админский блок | Альбомы</title>
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
                            Список альбомов
                        </div>
                        <div style="padding-top: 10px; margin: 0 13px;">
                            <div style="margin-bottom: 15px; padding-bottom: 5px; border-bottom: dotted 1px gainsboro;">
                                <div><a href="<? echo $v_params['url_prefix'] . "album?act=show"; ?>"><h3>0. Картинки без альбома</h3></a></div>
                                <div>Здесь находятся картинки которым не присвоен альбом</div>
                            </div>

                            <? $count = 1; ?>
                            <? if (count($v_params['img_albums'])): ?>
                                <? foreach ($v_params['img_albums'] as $imgAlbum): ?>
                                    <div style="margin-bottom: 15px; padding-bottom: 5px; border-bottom: dotted 1px gainsboro;">
                                        <div><a href="<? echo $v_params['url_prefix'] . "album?act=show&alb_id=" . $imgAlbum['id']; ?>"><h3><? echo $count++ . ". " . $imgAlbum['name']; ?></h3></a></div>
                                        <div><? echo $imgAlbum['description']; ?></div>
                                        <div style="text-align: right;"><a href="<? echo $v_params['url_prefix'] . "album?act=upd&alb_id=" . $imgAlbum['id']; ?>">Переименовать</a></div>
                                        <div style="text-align: right;"><a href="<? echo $v_params['url_prefix'] . "album?act=del&alb_id=" . $imgAlbum['id']; ?>">Удалить</a></div>
                                    </div>
                                <? endforeach; ?>
                            <? endif; ?>
                            <div class="button" style="width: 130px; margin: 3px auto;"><a class="a_clear" href="<? echo $v_params['url_prefix'] . "album?act=add"; ?>">Создать альбом</a></div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
