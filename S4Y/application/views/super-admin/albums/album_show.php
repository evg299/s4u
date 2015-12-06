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
                            «<? echo $v_params['img_album_name']; ?>»
                        </div>
                        <?
                        $count = count($v_params['alb_pictures']);
                        $subcount = 0;
                        ?>
                        <? if (0 < $count) : ?>
                            <table class="pict_table">
                                <tr>
                                    <? foreach ($v_params['alb_pictures'] as $img_pict): ?>
                                        <td>
                                            <a href="<? echo $v_params['pict_control_url']; ?>?<? echo PICT_PARAM_NAME; ?>=<? echo $img_pict['id']; ?>"><img  src="/thumbPicture?<? echo PICT_PARAM_NAME; ?>=<? echo $img_pict['id']; ?>" /></a>
                                        </td>
                                        <?
                                        if (2 < $subcount++) {
                                            $subcount = 0;
                                            echo "</tr> <tr>";
                                        }
                                        ?>
                                    <? endforeach; ?>
                                </tr>
                            </table>
                        <? else: ?>
                            <div style="text-align: center; margin: 9px auto;">
                                Изображений в альбом пока не добавлено
                            </div>
                        <? endif; ?>
                    </div>

                    <div class="sc_block">
                        <div class="sc_block_head">
                            Добавить картинки
                        </div>
                        <form name="pict_upl_form" method="post" enctype="multipart/form-data">
                            <br />
                            <input type="file" min="1" max="9" name="file[]" multiple="true" accept="image/jpeg,image/gif,image/x-png" />
                            <div class="button" style="width: 120px; margin: 3px auto; margin-top: 8px;" onclick="document.forms['pict_upl_form'].submit();">Закачать картинки</div>
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
