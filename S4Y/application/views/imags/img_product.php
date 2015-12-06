<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?> | <?= $v_params['img_gds']['ig_name']; ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

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

        <script type="text/javascript">
            function setCookie(name, value, path) {
                var cookie_string = name + "=" + escape(value);
                var expires = new Date();
                expires.setDate(expires.getDate() + 3);
                cookie_string += "; expires=" + expires.toGMTString();
                cookie_string += "; path=" + path;
                document.cookie = cookie_string;
            }
            
            function addToCard(){
                document.getElementById("add_to_card_button").style.display = 'none';
                document.getElementById("added_msg").style.display = 'block';
                setCookie("gds<?php echo $v_params['img_gds']['ig_id']; ?>", "<?php echo $v_params['img_gds']['UUID']; ?>", "/");
                var basket_count = Number(document.getElementById("basket_count").innerHTML);
                basket_count++;
                document.getElementById("basket_count").innerHTML = basket_count;
            }
        </script>


        <!-- Put this script tag to the <head> of your page -->
        <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?52"></script>

        <script type="text/javascript">
            VK.init({
                apiId : <?= VK_APIID ?>,
                onlyWidgets : true
            });
        </script>
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

                    <div class="product_block">
                        <div class="product_block_head">
                            <a href="<?= $v_params['img_root_url']; ?>">Товары</a>
                            <?= $v_params['img_gds_breadcrump_HTML']; ?>
                        </div>
                    </div> 
                    
                    <div class="product_block">
                        <table>
                            <tr>
                                <td>
                                    <!-- Put this div tag to the place, where the Like block will be -->
                                    <div id="vk_like"></div>
                                    <script type="text/javascript">
                                        VK.Widgets.Like("vk_like", {type: "mini", height: 24});
                                    </script>
                                </td>
                                <td>
                                    <a target="_blank" class="mrc__plugin_uber_like_button" href="http://connect.mail.ru/share" data-mrc-config="{'cm' : '1', 'ck' : '1', 'sz' : '20', 'st' : '1', 'tp' : 'combo'}">Нравится</a>
                                    <script src="http://cdn.connect.mail.ru/js/loader.js" type="text/javascript" charset="UTF-8"></script>
                                </td>
                            </tr>
                        </table>                  
                    </div>

                    <div class="product_block">
                        <table class="product_name_table">
                            <tr>
                                <td style="width: 125px; text-align: center;">
                                    <table>
                                        <tr valign="top">
                                            <td>
                                                <? if (!$v_params['mysc']['main']): ?>
                                                    <div id="add_to_card_button" class="button add_to_card <? if (!$v_params['show_add_gds']) { echo "hidden"; } ?>" onclick="addToCard();">Добавить в корзину</div>
                                                    <div id="added_msg" class="info_add <? if ($v_params['show_add_gds']) { echo "hidden"; } ?>">Товар уже в корзине</div> 
                                                <? endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <div class="product_name">
                                        <h2><?= $v_params['img_gds']['ig_name']; ?></h2>
                                        <div class="price">Цена: <?= $v_params['img_gds']['price']; ?> <?= $v_params['img_gds']['ic_name']; ?></div>
                                        <div>Код товара: <i><?= $v_params['img_gds']['UUID']; ?></i></div>
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
                                        <img src="/picture?<?= PICT_PARAM_NAME; ?>=<?= $v_params['img_gds']['main_pict_id']; ?>" data-thumb="/picture?<?= PICT_PARAM_NAME; ?>=<?= $v_params['img_gds']['main_pict_id']; ?>" />
                                    <?php endif; ?>
                                    <?php if (NULL != $v_params['img_gds']['first_pict_id']) : ?>
                                        <img src="/picture?<?= PICT_PARAM_NAME; ?>=<?= $v_params['img_gds']['first_pict_id']; ?>" data-thumb="/picture?<?= PICT_PARAM_NAME; ?>=<?= $v_params['img_gds']['first_pict_id']; ?>" />
                                    <?php endif; ?>
                                    <?php if (NULL != $v_params['img_gds']['second_pict_id']) : ?>
                                        <img src="/picture?<?= PICT_PARAM_NAME; ?>=<?= $v_params['img_gds']['second_pict_id']; ?>" data-thumb="/picture?<?= PICT_PARAM_NAME; ?>=<?= $v_params['img_gds']['second_pict_id']; ?>" />
                                    <?php endif; ?>
                                    <?php if (NULL != $v_params['img_gds']['third_pict_id']) : ?>
                                        <img src="/picture?<?= PICT_PARAM_NAME; ?>=<?= $v_params['img_gds']['third_pict_id']; ?>" data-thumb="/picture?<?= PICT_PARAM_NAME; ?>=<?= $v_params['img_gds']['third_pict_id']; ?>" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <? if (0 < count($v_params['img_gds_props'])): ?>
                        <div class="product_block">
                            <div class="product_block_head">
                                Характеристики:
                            </div>
                            <div class="product_prop_content">
                                <table>
                                    <? foreach ($v_params['img_gds_props'] as $imgGdsProp) : ?>
                                        <tr valign="top">
                                            <td class="prop_name"><?= $imgGdsProp['name']; ?></td>
                                            <td><?= $imgGdsProp['value']; ?></td>
                                        </tr>
                                    <? endforeach; ?>
                                </table>
                            </div>
                        </div> 
                    <? endif; ?>

                    <? if (0 != strcmp("", trim($v_params['img_gds_descr']))): ?>
                        <div class="product_block">
                            <div class="product_block_head">
                                Описание:
                            </div>
                            <div class="product_description">
                                <?= $v_params['img_gds_descr']; ?>               
                            </div>
                        </div>
                    <? endif; ?>

                    <? if (0 < count($v_params['img_gdss_smil'])): ?>
                        <div class="sc_block">
                            <div class="sc_block_head">Товары из той-же категории</div>
                            <table class="goods_table">
                                <tr>
                                    <? foreach ($v_params['img_gdss_smil'] as $img_gds): ?>
                                        <td>
                                            <div class="goods_preview">
                                                <a href="<?= $v_params['img_gds_link'] . $img_gds['id']; ?>"><img src="/picture?<?= PICT_PARAM_NAME; ?>=<?= $img_gds['main_pict_id']; ?>"  /></a>
                                                <div>
                                                    <a href="<?= $v_params['img_gds_link'] . $img_gds['id']; ?>"><?= $img_gds['name']; ?></a>
                                                </div>
                                                <div >
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
                                    <? endforeach; ?>
                                </tr>
                            </table>
                        </div>
                    <? endif; ?>

                    <!-- Put this div tag to the place, where the Comments block will be -->
                    <div id="vk_comments"></div>
                    <script type="text/javascript">
                        VK.Widgets.Comments("vk_comments", {
                            limit : 10,
                            width : "710",
                            attach : "*"
                        });
                    </script>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
