<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />

        <script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
        <script src="/assets/local/js/ymap2.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    </head>
    <body>
        <div id="header">
            <? require_once dirname(__FILE__) . "/../blocks/com_name_logo.php"; ?>
            <? require_once dirname(__FILE__) . "/../blocks/com_main_menu.php"; ?>
        </div>
        <table id="wraper">
            <tr style="vertical-align: top;">
                <td id="left">
                    <? if ($v_params['mysc']['main']): ?>
                        <? require_once dirname(__FILE__) . "/../blocks/img_admin_panel.php"; ?>
                    <? else: ?>
                        <? require_once dirname(__FILE__) . "/../blocks/sys_basket.php"; ?>
                    <? endif; ?>
                    <br />
                    <? require_once dirname(__FILE__) . "/../blocks/img_product_categories.php"; ?>
                    <br />
                    <? require_once dirname(__FILE__) . "/../blocks/img_blog_categories.php"; ?>
                </td>
                <td id="center">
                    <? require_once dirname(__FILE__) . "/../blocks/img_name.php"; ?>

                    <? if (0 != $v_params['show_addr'] || 0 != $v_params['show_phone'] || 0 != $v_params['show_email'] || 0 != $v_params['show_skype'] || 0 != $v_params['show_icq']): ?>
                        <div class="sc_block">
                            <div class="sc_block_head">Контактная информация</div>
                            <table class="sc_block_content_table">
                                <? if (0 != $v_params['show_addr']): ?>
                                    <tr valign="top">
                                        <td class="sc_contact_name">
                                            Адрес
                                        </td>
                                        <td>
                                            <address><?= $v_params['addr']; ?></address>
                                            <div class="button" style="width: 50px; margin-top: 3px;" onclick="createMap();">На карте</div>
                                            <div id="ymap"></div>
                                        </td>
                                    </tr>
                                <? endif; ?>

                                <? if (0 != $v_params['show_phone']): ?>
                                    <tr valign="top">
                                        <td class="sc_contact_name">Телефон</td>
                                        <td><phone><?= $v_params['phone']; ?></phone></td>
                                    </tr>
                                <? endif; ?>

                                <? if (0 != $v_params['show_skype']): ?>
                                    <tr valign="top">
                                        <td class="sc_contact_name">skype</td>
                                        <td><skype><?= $v_params['skype']; ?></skype></td>
                                    </tr>
                                <? endif; ?>

                                <? if (0 != $v_params['show_icq']): ?>
                                    <tr valign="top">
                                        <td class="sc_contact_name">ICQ</td>
                                        <td><icq><?= $v_params['icq']; ?></icq></td>
                                    </tr>
                                <? endif; ?>
                            </table>
                        </div>
                    <? endif; ?>

                    <?
                    $count = count($v_params['img_gdss_recom']);
                    $subcount = 0;
                    ?>
                    <? if (0 < $count) : ?>
                        <div class="sc_block">
                            <div class="sc_block_head">Рекомендуемые товары</div>
                            <table class="goods_table">
                                <tr>
                                    <? foreach ($v_params['img_gdss_recom'] as $img_gds): ?>
                                        <td>
                                            <div class="goods_preview">
                                                <a href="<?= $v_params['img_gds_link'] . $img_gds['ig_id']; ?>"><img src="/thumbPicture?<?= PICT_PARAM_NAME; ?>=<?= $img_gds['main_pict_id']; ?>"  /></a>
                                                <div>
                                                    <a href="<?= $v_params['img_gds_link'] . $img_gds['ig_id']; ?>"><?= $img_gds['ig_name']; ?></a>
                                                </div>
                                                <div>
                                                    Цена <?= $img_gds['price']; ?> <?= $img_gds['ic_name']; ?>				
                                                </div>
                                                <div>
                                                    <?
                                                    if (0 != $img_gds['in_stock'])
                                                        echo "<b>Есть в наличии</b>";
                                                    else
                                                        echo "Временно нет в продаже";
                                                    ?>
                                                </div>
                                            </div>
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
                        </div>
                    <? endif; ?>

                    <?
                    $count = count($v_params['img_gdss_new']);
                    $subcount = 0;
                    ?>
                    <? if (0 < $count) : ?>
                        <div class="sc_block">
                            <div class="sc_block_head">Новые товары</div>
                            <table class="goods_table">
                                <tr>
                                    <? foreach ($v_params['img_gdss_new'] as $img_gds): ?>
                                        <td>
                                            <div class="goods_preview">
                                                <a href="<?= $v_params['img_gds_link'] . $img_gds['ig_id']; ?>"><img src="/thumbPicture?<?= PICT_PARAM_NAME; ?>=<?= $img_gds['main_pict_id']; ?>"  /></a>
                                                <div>
                                                    <a href="<?= $v_params['img_gds_link'] . $img_gds['ig_id']; ?>"><?= $img_gds['ig_name']; ?></a>
                                                </div>
                                                <div>
                                                    Цена <?= $img_gds['price']; ?> <?= $img_gds['ic_name']; ?>				
                                                </div>
                                                <div>
                                                    <?
                                                    if (0 != $img_gds['in_stock'])
                                                        echo "<b>Есть в наличии</b>";
                                                    else
                                                        echo "Временно нет в продаже";
                                                    ?>
                                                </div>
                                            </div>
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
                        </div>
                    <? endif; ?>

                    <div class="sc_block">
                        <div class="sc_block_head"> 
                            <a href="<?= $_SERVER['REDIRECT_URL']; ?>">Товары</a>
                            <?= $v_params['img_gds_breadcrump_HTML']; ?>
                        </div>
                        <?
                        $count = count($v_params['img_gdss']);
                        $subcount = 0;
                        ?>
                        <? if (0 < $count) : ?>
                            <table class="goods_table">
                                <tr>
                                    <? foreach ($v_params['img_gdss'] as $img_gds): ?>
                                        <td>
                                            <div class="goods_preview">
                                                <a href="<?= $v_params['img_gds_link'] . $img_gds['ig_id']; ?>"><img src="/thumbPicture?<?= PICT_PARAM_NAME; ?>=<?= $img_gds['main_pict_id']; ?>" /></a>
                                                <div>
                                                    <a href="<?= $v_params['img_gds_link'] . $img_gds['ig_id']; ?>"><?= $img_gds['ig_name']; ?></a>
                                                </div>
                                                <div>
                                                    Цена <?= $img_gds['price']; ?> <?= $img_gds['ic_name']; ?>
                                                </div>
                                                <div>
                                                    <?
                                                    if (0 != $img_gds['in_stock'])
                                                        echo "<b>Есть в наличии</b>";
                                                    else
                                                        echo "Временно нет в продаже";
                                                    ?>				
                                                </div>
                                            </div>
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
                            <div style="text-align: center; margin: 15px;">Товаров в данной категории пока нет</div>
                        <? endif; ?>
                    </div>

                    <? require_once dirname(__FILE__) . "/../blocks/com_paginator.php"; ?>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
