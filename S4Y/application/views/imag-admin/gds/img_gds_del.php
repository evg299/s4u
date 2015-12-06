<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?> | <?= $v_params['action']; ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />

        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
        <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

        <link type="text/css" rel="stylesheet" href="/assets/ext/gallery/css/nivo-slider.css">
        <script type="text/javascript" src="/assets/ext/gallery/js/jquery.nivo.slider.js"></script>
        <script type="text/javascript" src="/assets/ext/gallery/js/jquery.nivo.slider.pack.js"></script>
        <script type="text/javascript">
            $(window).load(function() {
                $('#slider').nivoSlider({
                    effect: 'fold',
                    manualAdvance: true
                });
            });
        </script>
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
                            <a href="/<? echo IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/GDSs">Управление товарами</a>
                            >>
                            <? echo $v_params['action']; ?>
                        </div>
                    </div>

                    <div class="product_block">
                        <table class="product_name_table">
                            <tr>
                                <td style="width: 125px; text-align: center;"></td>
                                <td>
                                    <div class="product_name">
                                        <h2><?php echo $v_params['img_gds']['ig_name']; ?></h2>
                                        <div class="price">Цена: <?php echo $v_params['img_gds']['price']; ?> <?php echo $v_params['img_gds']['currency_name']; ?></div>
                                        <div>Код товара: <i><?php echo $v_params['img_gds']['UUID']; ?></i></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="product_block">
                        <div class="product_block_head">
                            Внешний вид:
                        </div>
                        <div id="wrapper">
                            <div class="slider-wrapper theme-default">
                                <div id="slider" class="nivoSlider">
                                    <?php if (NULL != $v_params['img_gds']['main_pict_id']) : ?>
                                        <img src="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $v_params['img_gds']['main_pict_id']; ?>" data-thumb="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $v_params['img_gds']['main_pict_id']; ?>" />
                                    <?php endif; ?>
                                    <?php if (NULL != $v_params['img_gds']['first_pict_id']) : ?>
                                        <img src="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $v_params['img_gds']['first_pict_id']; ?>" data-thumb="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $v_params['img_gds']['first_pict_id']; ?>" />
                                    <?php endif; ?>
                                    <?php if (NULL != $v_params['img_gds']['second_pict_id']) : ?>
                                        <img src="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $v_params['img_gds']['second_pict_id']; ?>" data-thumb="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $v_params['img_gds']['second_pict_id']; ?>" />
                                    <?php endif; ?>
                                    <?php if (NULL != $v_params['img_gds']['third_pict_id']) : ?>
                                        <img src="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $v_params['img_gds']['third_pict_id']; ?>" data-thumb="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $v_params['img_gds']['third_pict_id']; ?>" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <?php if (count($v_params['img_gds_props'])): ?>
                        <div class="product_block">
                            <div class="product_block_head">
                                Характеристики:
                            </div>
                            <div class="product_prop_content">
                                <table>
                                    <?php foreach ($v_params['img_gds_props'] as $imgGdsProp) : ?>
                                        <tr valign="top">
                                            <td class="prop_name"><?php echo $imgGdsProp['name']; ?></td>
                                            <td><?php echo $imgGdsProp['value']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div> 
                    <?php endif; ?>

                    <?php if (0 != strcmp("", trim($v_params['img_gds_descr']))): ?>
                        <div class="product_block">
                            <div class="product_block_head">
                                Описание:
                            </div>
                            <div class="product_description">
                        <?php echo $v_params['img_gds_descr']; ?>               
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <form name="gds_del_form" method="post">
                        <input type="hidden" name="gds_del" value="gds_del" />
                        <div class="art_block" onclick="document.forms['gds_del_form'].submit();" style="width: 120px; text-align: center; cursor: pointer;">
                            <a>Удалить</a>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
