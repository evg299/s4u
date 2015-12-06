<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name']; ?> | Супер Админский блок | <?= $v_params['act_name']; ?></title>
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
                            <? echo $v_params['act_name']; ?>
                        </div>
                    </div>
                    <div class="sc_block">
                        <div class="sc_block_head">
                            Содержимое блока статьи
                        </div>

                        <form name="send_block_form" method="post">
                            <input type="hidden" name="del_block_form" value="true" />
                            <?php if (0 == $v_params['ssp_block']['block_type_id']) : ?>
                                <div style="margin: 5px;">Порядковый номер: <? echo $v_params['ssp_block']['order_in_page']; ?></div>
                                <div style="text-align: center; margin-top: 15px;">
                                    <a href="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $v_params['ssp_block']['image_id']; ?>" target="blank"><img  class="blog_img" src="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $v_params['ssp_block']['image_id']; ?>" /></a>
                                    <div style="font-size: small;"><?php echo $v_params['ssp_block']['image_title']; ?></div>
                                </div>
                            <?php elseif (1 == $v_params['ssp_block']['block_type_id']) : ?>
                                <div style="margin: 5px;">Порядковый номер: <? echo $v_params['ssp_block']['order_in_page']; ?></div>
                                <p><?php echo $v_params['ssp_block']['text_content']; ?></p>
                            <?php elseif (2 == $v_params['ssp_block']['block_type_id']) : ?>
                                <div style="margin: 5px;">Порядковый номер: <? echo $v_params['ssp_block']['order_in_page']; ?></div>
                                <ol><?php echo $v_params['ssp_block']['text_content']; ?></ol>
                            <?php endif; ?>
                            <div class="art_block" style="width: 120px; text-align: center;"><a style="cursor: pointer;" onclick="document.forms['send_block_form'].submit();">Удалить</a></div>
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
