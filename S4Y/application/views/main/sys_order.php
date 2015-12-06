<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | Оформление заказа</title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="assets/local/css/alll.css" />

        <script type="text/javascript" src="/assets/local/js/jquery-1.8.0.js"></script>
        <script type="text/javascript">
            var RecaptchaOptions = {
                theme : 'white'
            };
        </script>
    </head>
    <body>
        <div id="header">
            <? require_once dirname(__FILE__) . '/../blocks/com_name_logo.php'; ?>
            <? require_once dirname(__FILE__) . '/../blocks/com_main_menu.php'; ?>
        </div>
        <table id="wraper">
            <tr style="vertical-align: top;">
                <td>
                    <form name="order_form" method="post" action="/order">
                        <div class="sc_card_container">
                            <div class="sc_card_container_head">Содержимое корзины</div>

                            <table class="card_table">
                                <tr>
                                    <td><b>Товар</b></td>
                                    <td><b>Цена за штуку</b></td>
                                    <td><b>Торговый стенд</b></td>
                                    <td><b>Количество</b></td>
                                    <td><b>Цена * Количество</b></td>
                                </tr>
                                <? foreach ($v_params['img_gdss'] as $img_gds) : ?>
                                    <tr>
                                        <td>
                                            <a href="<?= $v_params['img_link_prefix'] . $img_gds['ia_id'] . "/" . PRODUCT_DIR . "?" . PRODUCT_PARAM_NAME . "=" . $img_gds['ig_id']; ?>">
                                                <img class="preview_table_img" src="/thumbPicture?<?= PICT_PARAM_NAME; ?>=<?= $img_gds['ig_main_pict_id']; ?>"  />
                                                <br />
                                                <?= $img_gds['ig_name']; ?>
                                            </a>
                                        </td>
                                        <td><span><?= $img_gds['ig_price']; ?></span> <?= $img_gds['ic_name']; ?></td>
                                        <td><a href="<?= $v_params['img_link_prefix'] . $img_gds['ia_id']; ?>"><?= $img_gds['ia_img_name']; ?></a></td>
                                        <td class="count_product">
                                            <span><?= $img_gds['count_in_basket']; ?></span> <i>шт</i>
                                            <input type="hidden" name="gds<?= $img_gds['ig_id']; ?>" value="<?= $img_gds['count_in_basket']; ?>" class="count_val" />
                                        </td>
                                        <td>
                                            <span><?= $img_gds['price_all']; ?></span> <?= $img_gds['ic_name']; ?>
                                        </td>
                                    </tr>
                                <? endforeach; ?>
                            </table>
                            <div align="right" style="margin: 5px;">
                                <b>
                                    Всего на 
                                    <? if (0 < count($v_params['summ'])): ?>
                                        <? foreach ($v_params['summ'] as $summ_item_key => $summ_item_value): ?>
                                            <? $price_lines[] = $summ_item_value . " " . $summ_item_key; ?>
                                        <? endforeach; ?>
                                    <? endif; ?>
                                    <?= implode(" + ", $price_lines)  ?>
                                </b>
                            </div>
                        </div>

                        <div class="sc_card_container" style="width: 666px;">
                            <div class="sc_card_container_head">Форма заказа</div>
                            <div style="color: red; text-align: center; margin: 9px;">
                                <? if (count($v_params['errors'])): ?>
                                    <? foreach ($v_params['errors'] as $error): ?>
                                        <div><?= $error; ?></div>
                                    <? endforeach; ?>
                                <? endif; ?>
                            </div>
                            <table class="order_table">
                                <tr>
                                    <td> Ваш e-mail <span>(для обратной связи с менеджером)</span> * </td>
                                    <td>
                                        <input name="u_email" type="text" style="width: 310px;" value="<?= $_POST['u_email']; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td> Ваше имя </td>
                                    <td>
                                        <input name="u_name" type="text" style="width: 310px;" value="<?= $_POST['u_name']; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td> Ваш телефон </td>
                                    <td>
                                        <input name="u_phone" type="text" style="width: 310px;" value="<?= $_POST['u_phone']; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td> Примечание к заказу </td>
                                    <td><textarea name="u_comment" style="width: 310px; height: 250px;"><?= $_POST['u_comment']; ?></textarea></td>
                                </tr>
                                <tr>
                                    <td> Защита от роботов * </td>
                                    <td align="center">
                                        <?= recaptcha_get_html(RECAPCHA_PUBLIC_KEY); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="button" style="width: 120px; margin: 3px auto;" onclick="document.forms['order_form'].submit();">Сделать заказ</div>
                    </form>
                </td>
            </tr>
        </table>

        <div id="footer">
            <? require_once dirname(__FILE__) . '/../blocks/com_footer.php'; ?>
        </div>
    </body>
</html>
