<div class="main_menu">
    <div class="main_menu_content">
        <a class="first_item <? if($v_params['mm']['main']) {echo 'active'; }?>" href="/">Главная</a>
        <? if ($v_params['logined']): ?>
            <a class="<? if($v_params['mysc']['main']) {echo 'active'; }?>" href="<?= "/" . IMAG_PREFIX . $v_params['logined']; ?>">Мой стенд</a>
        <? endif; ?>
        <a class="<? if($v_params['prez']['main']) {echo 'active'; }?>" href="/presentation">Презентация</a>
        <? if (!$v_params['logined']): ?>
            <a class="<? if($v_params['reg']['main']) {echo 'active'; }?>" href="/registration">Регистрация</a>
        <? endif; ?>
        <? if ($v_params['logined']): ?>
            <a class="<? if($v_params['logout']['main']) {echo 'active'; }?>" href="/logout">Выйти</a>
        <? else: ?>
            <a class="<? if($v_params['login']['main']) {echo 'active'; }?>" href="/login">Войти</a>
        <? endif; ?>
        <a class="<? if($v_params['faq']['main']) {echo 'active'; }?>" href="/faq">FAQ</a>
        <a class="<? if($v_params['smap']['main']) {echo 'active'; }?>" href="/sitemap">Карта сайта</a>
    </div>
</div>