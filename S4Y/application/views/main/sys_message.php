<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['sys_slog'] ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="assets/local/css/alll.css" />
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
                        <div class="sc_card_container_head">Сообщение от системы</div>
                        <div align="center">
                            <table style="width: 666px;">
                                <tr valign="top">
                                    <td style="width: 200px;">
                                        <img src="assets/local/img/info.svg.128.png" />
                                    </td>
                                    <td align="left">
                                        <div style="margin: 15px;">
                                            <h3><? echo $v_params['message']; ?></h3>
                                        </div>
                                        <div style="margin: 15px;">
                                            <? echo $v_params['message_descr']; ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <div id="footer">
            <? require_once dirname(__FILE__) . '/../blocks/com_footer.php'; ?>
        </div>
    </body>
</html>
