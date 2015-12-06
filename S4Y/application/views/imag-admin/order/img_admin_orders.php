<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?> | Заказы</title>
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
                            Заказы >> <? echo $v_params['orders_type']; ?>
                        </div>
                        <?
                        $count = count($v_params['orders']);
                        $subcount = 0;
                        ?>
                        <? if (0 < $count) : ?>
                            <div style="padding-top: 10px; margin: 0 13px;">
                                <table width="100%" cellspacing="5">
                                    <tr>
                                        <? foreach ($v_params['orders'] as $order): ?>
                                        <td width="50%" style="border: 1px solid <? if($order['sended']): ?> grey <? else: ?> red <? endif; ?>; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; padding: 5px;">
                                                <div style="margin-bottom: 15px; padding-bottom: 5px; border-bottom: dotted 1px gainsboro;">
                                                    <div><a href="order?id=<? echo $order['id']; ?>"><h3>Время заказа: <? echo $order['c_date']; ?></h3></a></div>
                                                    <div><b>Email покупателя:</b> <? echo $order['u_email']; ?></div>
                                                    <div><b>Имя покупателя:</b> <? echo $order['u_name']; ?></div>
                                                    <div><b>Телефон покупателя:</b> <? echo $order['u_phone']; ?></div>
                                                    <div><b>Статус заказа:</b> <? if($order['sended']): ?> Завершен <? else: ?> <i>Не завершен</i> <? endif; ?></div>
                                                    <div style="text-align: right; padding-right: 15px;"><a href="order?id=<? echo $order['id']; ?>">Посмотреть детали >></a></div>
                                                </div>
                                            </td>
                                            <?
                                            if (0 < $subcount++) {
                                                $subcount = 0;
                                                echo "</tr> <tr>";
                                            }
                                            ?>
                                        <? endforeach; ?>
                                    </tr>
                                </table>
                                
                                <? include dirname(__FILE__) . "/../../blocks/com_paginator.php"; ?>
                            </div>
                        <? endif; ?>
                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
