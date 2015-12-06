<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | Создание торгового стенда</title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="assets/local/css/alll.css" />

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script type="text/javascript">
            var RecaptchaOptions = {
                theme : 'white'
            };
            
            var checkFunction = function(){
                var data = $('#regForm').serialize();
                         
                $.ajax({
                    type: "POST",
                    url: "ajax/checkForm",
                    data: data,
                    success: function(msg) {
                        var data = $.parseJSON(msg);

                        $("#messages").empty();
                        if(null != data.errors.length && 0 < data.errors.length) {
                            for (errorKey in data.errors) {
                                $("#messages").append("<div>"+data.errors[errorKey]+"</div>");
                            }
                        }
                    }
                });
            };
        
            $(document).ready(function(){
                $(".reginput").keyup(checkFunction);
                $(".reginput").focusout(checkFunction);
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
                    <form id="regForm" name="reg_form"  method="post">
                        <div class="sc_card_container">
                            <div class="sc_card_container_head">Создание торгового стенда</div>

                            <div id="messages" style="margin-top: 15px; color: red; text-align: center;">
                                <? if (count($v_params['errors'])): ?>
                                    <? foreach ($v_params['errors'] as $error): ?>
                                        <div>
                                            <?= $error; ?>
                                        </div>
                                    <? endforeach; ?>
                                <? endif ?>
                            </div>

                            <table class="reg_table">
                                <tr>
                                    <td class="name_field">Ваш Email (он станет логином в систему) *</td>
                                    <td><input class="reginput" name="email" value="<?= $_POST['email']; ?>" type="text" style="width: 320px;"/></td>
                                </tr>
                                <tr>
                                    <td class="name_field">Пароль *</td>
                                    <td><input class="reginput" name="password1" type="password" style="width: 320px;"/></td>
                                </tr>
                                <tr>
                                    <td class="name_field">Повторите пароль *</td>
                                    <td><input class="reginput" name="password2" type="password" style="width: 320px;"/></td>
                                </tr>
                                <tr>
                                    <td class="name_field">Название торгового стенда *</td>
                                    <td><input class="reginput" name="name" value="<?= $_POST['name']; ?>" type="text" style="width: 320px;"/></td>
                                </tr>
                                <tr>
                                    <td class="name_field">Слоган торгового стенда</td>
                                    <td><input name="slog" value="<?= $_POST['email']; ?>" type="text" style="width: 320px;"/></td>
                                </tr>
                                <tr>
                                    <td class="name_field">Выберите привязаный регион</td>
                                    <td>
                                        <select name="region" style="width: 327px;">
                                            <? foreach ($v_params['addr_regions'] as $addrRegion): ?>
                                                <? if ($addrRegion['code'] == $_POST['region']): ?>
                                                    <option selected value="<?= $addrRegion['code']; ?>"><?= $addrRegion['name']; ?></option>
                                                <? else: ?>
                                                    <option value="<?= $addrRegion['code']; ?>"><?= $addrRegion['name']; ?></option>
                                                <? endif; ?>
                                            <? endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="name_field">Защита от роботов *</td>
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
                        </div>

                        <div class="button" style="width: 98px; margin: 3px auto;" onclick="document.forms['reg_form'].submit();">Зарегистрировать</div>
                    </form>
                </td>
            </tr>
        </table>

        <div id="footer">
            <? require_once dirname(__FILE__) . '/../blocks/com_footer.php'; ?>
        </div>
    </body>
</html>
