<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?> | Управление товарами</title>
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
                            <a href="/<?= IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/GDSs">Управление товарами</a>
                        </div>
                    </div>
                    <div class="sc_block" align="right">
                        <a href="GDS?act=add"><div class="button" style="width: 120px;">Добавить товар</div></a>
                    </div>
                    <div class="sc_block">
                        <div class="sc_block_head">
                            Поиск товаров
                        </div>
                        <div style="text-align: center; margin: 9px auto;">
                            <form name="search_form" method="get">
                                <table class="sc_block_content_table">
                                    <tr>
                                        <td align="right" style="font-weight: bold;">Категория:</td>
                                        <td align="left">
                                            <select name="cat" style="width: 180px;">
                                                <option <? if (!$_REQUEST["cat"]) { echo "selected"; } ?> value="">Все</option>
                                                <? foreach ($v_params['img_gds_cats'] as $imgGdscat): ?>
                                                    <option <? if ($_REQUEST["cat"] == $imgGdscat['id']) { echo "selected"; } ?> value="<?= $imgGdscat['id']; ?>">
                                                        <?= $imgGdscat['name']; ?>
                                                    </option>
                                                <? endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" style="font-weight: bold;">Часть названия:</td>
                                        <td align="left"><input style="width: 325px;" name="pname" type="text" value="<?= $_REQUEST["pname"]; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right" style="font-weight: bold;">Цена:</td>
                                        <td align="left"> от <input name="prfrom" type="text" value="<?= $_REQUEST["prfrom"]; ?>" /> до <input name="prto" type="text" value="<?= $_REQUEST["prto"]; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right" style="font-weight: bold;">Есть в наличии:</td>
                                        <td align="left"><input name="tosale" type="checkbox" <? if($_REQUEST["tosale"]) echo "checked"; ?> /></td>
                                    </tr>
                                </table>
                                <div class="button" style="width: 120px; margin: 3px auto; margin-top: 8px;" onclick="document.forms['search_form'].submit();">Найти</div>
                            </form>
                        </div>
                    </div>

                    <? include dirname(__FILE__) . "/../../blocks/com_paginator.php"; ?>

                    <div class="sc_block">
                        <div class="sc_block_head"> 
                            <a>Результаты поиска</a>
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
                                                <a href="GDS?id=<?= $img_gds['ig_id']; ?>&act=upd"><img src="/thumbPicture?<?= PICT_PARAM_NAME; ?>=<?= $img_gds['main_pict_id']; ?>" /></a>
                                                <div>
                                                    <a href="GDS?id=<?= $img_gds['ig_id']; ?>&act=upd"><?= $img_gds['ig_name']; ?></a>
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
                                                <div>
                                                    <a href="GDS?id=<?= $img_gds['ig_id']; ?>&act=del">Удалить товар</a>
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
                            <div style="text-align: center; margin: 15px;">Товаров не найдено</div>
                        <? endif; ?>
                    </div>

                    <? include dirname(__FILE__) . "/../../blocks/com_paginator.php"; ?>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
