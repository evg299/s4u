<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?> | Заказ от <? echo $v_params['order']['c_date']; ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />
        <link rel="stylesheet" href="/assets/local/css/tabs.css" />
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
                            <a href="orders">Заказы</a>
                            >>
                            Заказ от <? echo $v_params['order']['c_date']; ?>
                        </div>
                    </div>
                    <div class="sc_block">
                        <div class="sc_block_head">
                            Данные заказа
                        </div>
                        <div style="text-align: center; margin: 9px auto;">
                            <table class="sc_block_content_table" style="width: 100%;">
                                <tr>
                                    <td align="right" style="font-weight: bold; width: 150px;">E-mail покупателя: </td>
                                    <td align="left" style="width: 550px;"><a href="mailto:<? echo $v_params['order']['u_email']; ?>"><? echo $v_params['order']['u_email']; ?></a></td>
                                </tr>
                                <? if (strcmp("", $v_params['order']['u_name'])): ?>
                                    <tr>
                                        <td align="right" style="font-weight: bold; width: 150px;">Имя покупателя: </td>
                                        <td align="left" style="width: 550px;"><? echo $v_params['order']['u_name']; ?></td>
                                    </tr>
                                <? endif; ?>
                                <? if (strcmp("", $v_params['order']['u_phone'])): ?>
                                    <tr>
                                        <td align="right" style="font-weight: bold; width: 150px;">Телефон покупателя: </td>
                                        <td align="left" style="width: 550px;"><? echo $v_params['order']['u_phone']; ?></td>
                                    </tr>
                                <? endif; ?>
                                <? if (strcmp("", $v_params['order']['u_comment'])): ?>
                                    <tr>
                                        <td align="right" style="font-weight: bold; width: 150px;">Примечание к заказу: </td>
                                        <td align="left" style="width: 550px;"><? echo $v_params['order']['u_comment']; ?></td>
                                    </tr>
                                <? endif; ?>
                            </table>
                        </div>
                    </div>

                    <div class="sc_block">
                        <div class="sc_block_head">
                            Содержимое заказа
                        </div>
                        <div style="text-align: center; margin: 9px auto;">
                            <table class="sc_block_content_table" style="width: 100%;">
                                <tr>
                                    <th>Товар</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                </tr>
                                <? foreach ($v_params['order_gdss'] as $order_gds): ?>
                                    <tr>
                                        <td style="width: 300px;">
                                            <div class="goods_preview">
                                                <a href="/imag<? echo $v_params['logined']; ?>/product?prod_id=<? echo $order_gds['id']; ?>" target="blank">
                                                    <img src="/thumbPicture?pict_id=<? echo $order_gds['main_pict_id']; ?>"></img>
                                                    <div><? echo $order_gds['name']; ?></div>
                                                </a>
                                                <div>Код товара: <? echo $order_gds['UUID']; ?></div>
                                            </div>
                                        </td>
                                        <td><? echo $order_gds['price']; ?> <? echo $order_gds['price_name']; ?></td>
                                        <td><? echo $order_gds['count_gds']; ?> шт.</td>
                                    </tr>
                                <? endforeach; ?>
                            </table>
                        </div>
                    </div>

                    <form name="order_u_form" method="post">
                        <div class="sc_block">
                            <div style="text-align: center; margin: 9px auto;">
                                <table class="sc_block_content_table" style="width: 100%;">
                                    <tr>
                                        <td align="right" style="font-weight: bold; width: 150px;">Статус заказа: </td>
                                        <td align="left" style="width: 550px;">
                                            <select name="order_ended" style="margin-left: 25px; width: 180px;">
                                                <option <? if(!$v_params['order']['sended']): ?>selected<? endif; ?> value="not_ended">Не завершен</option>
                                                <option <? if($v_params['order']['sended']): ?>selected<? endif; ?> value="ended">Завершен</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="art_block" style="width: 120px; text-align: center; cursor: pointer;" onclick="document.forms['order_u_form'].submit();">
                                <a>Сохранить</a>
                            </div>
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
