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
                            <a href="/<? echo IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/albums">Альбомы</a>
                        </div>
                    </div>
                    <div class="sc_block">
                        <div class="sc_block_head">
                            <?= $v_params['action_name']; ?>
                            «<?= $v_params['img_album_name']; ?>»
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
                                            <a href="<?= $v_params['pict_control_url']; ?>?<?= PICT_PARAM_NAME; ?>=<?= $img_pict['id']; ?>"><img  src="/thumbPicture?<?= PICT_PARAM_NAME; ?>=<?= $img_pict['id']; ?>" /></a>
                                        </td>
                                        <?
                                        if (1 < $subcount++) {
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
                            Закачать картинки
                        </div>
                        <form name="pict_upl_form" method="post" enctype="multipart/form-data">
                            <br />
                            <input type="file" min="1" max="5" name="file[]" multiple="true" accept="image/jpeg,image/gif,image/x-png" />
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
