<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['sys_slog'] ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="assets/local/css/alll.css" />

        <!-- Put this script tag to the <head> of your page -->
        <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?52"></script>

        <script type="text/javascript">
            VK.init({
                apiId : <?= VK_APIID ?>,
                onlyWidgets : true
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
                <td id="left">
                    <? require_once dirname(__FILE__) . '/../blocks/sys_basket.php'; ?>
                    <br />
                    <? if (!$v_params['logined']): ?>
                        <? require_once dirname(__FILE__) . '/../blocks/sys_login.php'; ?>
                        <br />
                    <? endif; ?>
                    <? require_once dirname(__FILE__) . '/../blocks/sys_blog_categories.php'; ?>
                </td>
                <td id="center">
                    <div class="search_results_block" style="width: 690px; margin-top: 15px;">
                        <div class="ya-site-form ya-site-form_inited_no" onclick="return {'bg': 'transparent', 'target': '_self', 'language': 'ru', 'suggest': true, 'tld': 'ru', 'site_suggest': true, 'action': 'http://stand4you.ru/', 'webopt': false, 'fontsize': 12, 'arrow': false, 'fg': '#333333', 'searchid': '2032947', 'logo': 'rb', 'websearch': false, 'type': 2}"><form action="http://yandex.ru/sitesearch" method="get" target="_self"><input type="hidden" name="searchid" value="2032947" /><input type="hidden" name="l10n" value="ru" /><input type="hidden" name="reqenc" value="" /><input type="text" name="text" value="" /><input type="submit" value="Найти" /></form></div><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;(' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1&&(e.className+=' ya-page_js_yes');s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>
                    </div>

                    <!-- Put this div tag to the place, where the Like block will be -->
                    <div style="margin-top: 15px; width: 700px;">
                        <div id="vk_recommended" ></div>
                        <script type="text/javascript">
                            VK.Widgets.Recommended("vk_recommended", {limit: 5});
                        </script>
                    </div>

                    <? if ($_GET['searchid']): ?>
                        <div class="search_results_block" style="width: 690px; margin-top: 10px;" id="ya-site-results" onclick="return {'tld': 'ru', 'language': 'ru', 'encoding': ''}"></div>
                        <script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0];s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Results.init()})})(window,document,'yandex_site_callbacks');</script>
                    <? endif; ?>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . '/../blocks/com_footer.php'; ?>
        </div>
    </body>
</html>
