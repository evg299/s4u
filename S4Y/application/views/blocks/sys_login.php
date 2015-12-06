<div class="navigation_block">
    <div class="navigation_block_header">
        Авторизация
    </div>
    <form name="login_form"  method="POST" action="/login">
        <div class="navigation_block_content">
            <div class="label_text">
                Введите email
            </div>
            <div class="input_wraper">
                <input class="login_input" type="text" name="email" />
            </div>
            <div class="label_text">
                Введите пароль
            </div>
            <div class="input_wraper">
                <input class="login_input" type="password" name="password" />
            </div>

            <div style="text-align: center; margin-bottom: 7px;">
                <div class="button" style="width: 60px; margin: 3px auto;" onclick="document.forms['login_form'].submit();">Войти</div>
            </div>

            <div style="text-align: center; margin-bottom: 7px;">
                <a href="/fogot">Забыли пароль?</a>
                <br />
                <a href="/registration">Регистрация</a>
            </div>
        </div>
    </form>
</div>