<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | Содержимое корзины</title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.count_incr').click(function() {
                    var numb = $(this).siblings('span')[0];
                    var container = $(this).siblings('input.count_val')[0];
                    var cnt = Number(numb.innerHTML);
                    cnt += 1;
                    numb.innerHTML = cnt;
                    container.value = cnt;
                });

                $('.count_decr').click(function() {
                    var numb = $(this).siblings('span')[0];
                    var container = $(this).siblings('input.count_val')[0];
                    var cnt = Number(numb.innerHTML);
                    if (1 < cnt)
                        cnt -= 1;
                    numb.innerHTML = cnt;
                    container.value = cnt;
                });

                $('.dellink').click(function() {
                    if(confirm("Вы настаиваете на удалении товара из корзины?")) {
                        // Удаляем куку
                        var cookie_id = $(this).attr("cookieID");
                        var cookie_date = new Date ( );  // Текущая дата и время
                        cookie_date.setTime ( cookie_date.getTime() - 1 );
                        document.cookie = cookie_id += "=; expires=" + cookie_date.toGMTString();
                        // Удаляем строку
                        $(this).parent().parent().empty();
                    }
                });
            });
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
                    <div class="sc_card_container">
                        <div class="sc_card_container_head">Содержимое корзины</div>
                        <form name="card_form" method="get" action="/order">
                            <table class="card_table">
                                <tr>
                                    <td><b>Товар</b></td>
                                    <td><b>Цена за штуку</b></td>
                                    <td><b>Торговый стенд</b></td>
                                    <td><b>Количество</b></td>
                                    <td><b>Удалить из корзины</b></td>
                                </tr>
                                <? if (count($v_params['img_gdss'])): ?>
                                    <? foreach ($v_params['img_gdss'] as $img_gds) : ?>
                                        <tr>
                                            <td>
                                                <a href="<?= $v_params['img_link_prefix'] . $img_gds['ia_id'] . "/" . PRODUCT_DIR . "?" . PRODUCT_PARAM_NAME . "=" . $img_gds['ig_id']; ?>"><img class="preview_table_img" src="/thumbPicture?<?= PICT_PARAM_NAME; ?>=<?= $img_gds['ig_main_pict_id']; ?>"  />
                                                    <br />
                                                    <?= $img_gds['ig_name']; ?>
                                                </a>
                                            </td>
                                            <td><span><?= $img_gds['ig_price']; ?></span> <?= $img_gds['ic_name']; ?></td>
                                            <td><a href="<?= $v_params['img_link_prefix'] . $img_gds['ia_id']; ?>"><?= $img_gds['ia_img_name']; ?></a></td>
                                            <td class="count_product">
                                                <span>1</span> <i>шт</i>
                                                <img class="count_incr card_btn" src="/assets/local/img/card-inc.png" />
                                                <img class="count_decr card_btn" src="/assets/local/img/card-dec.png" />
                                                <input type="hidden" name="gds<?= $img_gds['ig_id']; ?>" value="1" class="count_val" />
                                            </td>
                                            <td>
                                                <a href="#" class="dellink" cookieID="gds<?= $img_gds['ig_id']; ?>">Удалить</a>
                                            </td>
                                        </tr>
                                    <? endforeach; ?>
                                <? endif; ?>
                            </table>
                        </form>
                    </div>

                    <div class="button" style="width: 120px; margin: 3px auto;" onclick="document.forms['card_form'].submit();">Перейти к заказу</div>
                </td>
            </tr>
        </table>

        <div id="footer">
            <? require_once dirname(__FILE__) . '/../blocks/com_footer.php'; ?>
        </div>
    </body>
</html>
