<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name']; ?> | Супер Админский блок | Вход</title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />
    </head>
    <body>
        <div id="header">
            <? require_once dirname(__FILE__) . "/../blocks/com_name_logo.php"; ?>
            <? require_once dirname(__FILE__) . "/../blocks/com_main_menu.php"; ?>
        </div>
        <table id="wraper">
            <tr style="vertical-align: top;">
                <td id="left">
                    <? require_once dirname(__FILE__) . "/../blocks/super_navigation.php"; ?>
                </td>
                <td id="center">
                    <div class="sc_block">
                        <div class="sc_block_head">
                            Войти как супер-админ
                        </div>
                        <form name="sys_login_form" method="post">
                            <input type="hidden" name="name_form" value="name_form" />
                            <table class="sc_block_content_table">
                                <tr>
                                    <td class="sc_contact_name">
                                        Логин
                                    </td>
                                    <td>
                                        <input type="text" name="img_admin_login" style="width: 400px;"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        Пароль
                                    </td>
                                    <td>
                                        <input type="password" name="img_admin_password" style="width: 400px;" />
                                    </td>
                                </tr>
                            </table>
                            <div class="button" style="width: 60px; margin: 3px auto;" onclick="document.forms['sys_login_form'].submit();">Вход</div>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
