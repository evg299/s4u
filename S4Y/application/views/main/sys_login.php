<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | Вход в систему</title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="assets/local/css/alll.css" />
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
                    <form name="login_form" method="POST">
                        <input type="hidden" name="lfsp" value="true" />
                        <div class="sc_card_container">
                            <div class="sc_card_container_head">Вход в систему</div>

                            <div style="margin-top: 15px; color: red; text-align: center;">
                                <? if (count($v_params['messages'])): ?>
                                    <? foreach ($v_params['messages'] as $message): ?>
                                        <div>
                                            <?= $message; ?>
                                        </div>
                                    <? endforeach; ?>
                                <? endif; ?>
                            </div>
                            <table class="login_table">
                                <tr>
                                    <td class="name_field">Email</td>
                                    <td><input style="width: 310px;" name="email" type="text" value="<?= $_POST['email']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td class="name_field">Пароль</td>
                                    <td><input style="width: 310px;" name="password" type="password" /></td>
                                </tr>
                                <tr>
                                    <td class="name_field">Защита от роботов</td>
                                    <td align="center">
                                        <script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<?= RECAPCHA_PUBLIC_KEY ?>"></script>

                                        <noscript>
                                            <iframe src="http://www.google.com/recaptcha/api/noscript?k=<?= RECAPCHA_PUBLIC_KEY ?>" height="300" width="500" frameborder="0"></iframe><br/>
                                            <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
                                            <input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
                                        </noscript>
                                    </td>
                                </tr>
                            </table>
                            <div style="padding: 0 8px;">
                                <div class="button" style="width: 60px; margin: 3px auto;" onclick="document.forms['login_form'].submit();">Войти</div>
                            </div>
                            <div style="text-align: center; margin-top: 9px;">
                                <a href="/fogot">Забыли пароль?</a>
                                <br/>
                                <a href="/registration">Регистрация</a>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        </table>

        <div id="footer">
            <? require_once dirname(__FILE__) . '/../blocks/com_footer.php'; ?>
        </div>
    </body>
</html>
