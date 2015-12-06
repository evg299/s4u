<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name']; ?> | Супер Админский блок | <?= $v_params['ssp']['title']; ?></title>
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
                        <form name="name_form" method="post">
                            <input type="hidden" name="name_form" value="name_form" />
                            <table class="sc_block_content_table">
                                <tr>
                                    <td class="sc_contact_name">
                                        Название
                                    </td>
                                    <td>
                                        <input type="text" name="sys_name" style="width: 400px;" value="<? echo $v_params['ssp']['title']; ?>" />
                                    </td>
                                </tr>
                            </table>
                            <div class="button" style="width: 60px; margin: 3px auto;" onclick="document.forms['name_form'].submit();">Сохранить</div>
                        </form>
                    </div>
                    <div class="sc_block">
                        <div class="sc_block_head">
                            Содержимое страницы
                        </div>

                        <?php if (0 != count($v_params['ssp_blocks'])): ?>
                            <?php foreach ($v_params['ssp_blocks'] as $sspBlock) : ?>
                                <?php if (0 == $sspBlock['block_type_id']) : ?>
                                    <div class="art_block">
                                        <div>Порядковый номер: <? echo $sspBlock['order_in_page']; ?></div>
                                        <div style="text-align: center; margin-top: 15px;">
                                            <a href="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $sspBlock['image_id']; ?>" target="blank"><img  class="blog_img" src="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $sspBlock['image_id']; ?>" /></a>
                                            <div style="font-size: small;"><?php echo $sspBlock['image_title']; ?></div>
                                        </div>
                                        <div align="right"><a href="pageBlock?id=<?php echo $sspBlock['id']; ?>&act=upd&corresp=<? echo $v_params['ssp']['id']; ?>">Редактировать</a> 
                                            <a href="pageBlock?id=<?php echo $sspBlock['id']; ?>&act=del&corresp=<? echo $v_params['ssp']['id']; ?>">Удалить</a></div>
                                    </div>
                                <?php elseif (1 == $sspBlock['block_type_id']) : ?>
                                    <div class="art_block">
                                        <div>Порядковый номер: <? echo $sspBlock['order_in_page']; ?></div>
                                        <p><?php echo $sspBlock['text_content']; ?></p>
                                        <div align="right"><a href="pageBlock?id=<?php echo $sspBlock['id']; ?>&act=upd&corresp=<? echo $v_params['ssp']['id']; ?>">Редактировать</a> 
                                            <a href="pageBlock?id=<?php echo $sspBlock['id']; ?>&act=del&corresp=<? echo $v_params['ssp']['id']; ?>">Удалить</a></div>
                                    </div>
                                <?php elseif (2 == $sspBlock['block_type_id']) : ?>
                                    <div class="art_block">
                                        <div>Порядковый номер: <? echo $sspBlock['order_in_page']; ?></div>
                                        <ol><?php echo $sspBlock['text_content']; ?></ol>
                                        <div align="right"><a href="pageBlock?id=<?php echo $sspBlock['id']; ?>&act=upd&corresp=<? echo $v_params['ssp']['id']; ?>">Редактировать</a> 
                                            <a href="pageBlock?id=<?php echo $sspBlock['id']; ?>&act=del&corresp=<? echo $v_params['ssp']['id']; ?>">Удалить</a></div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="text-align: center;">В эту страницу еще не добавлено блоков</p>
                        <?php endif; ?>

                        <div class="art_block" style="width: 120px; text-align: center;"><a href="pageBlock?act=add&corresp=<? echo $v_params['ssp']['id']; ?>">Добавить блок</a></div>
                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
