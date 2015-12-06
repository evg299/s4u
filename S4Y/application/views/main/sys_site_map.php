<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | Карта сайта</title>
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
                    <div class="sc_block">
                        <h3 class="blog_text_title">
                            <?= $v_params['title']; ?>
                        </h3>

                        <? if ($v_params['imags']): ?>
                            <? if (count($v_params['accounts'])): ?>
                                <? $line_count = 1; ?>
                                <? foreach ($v_params['accounts'] as $account): ?>
                                    <div style="margin-left: 25px; margin-bottom: 15px;">
                                        <h3><?= $line_count++ ?>. <a href="/<?= IMAG_PREFIX . $account['id'] ?>" target="blank"><?= $account['img_name'] ?></a></h3>
                                        <div style="margin-top: -10px;"><?= $account['img_slog']; ?></div>
                                    </div>
                                <? endforeach; ?>
                            <? else: ?>
                                <div style="text-align: center;">Из данного региона пока нет представленых стендов</div>
                            <? endif; ?>

                        <? else: ?>
                            <div style="height: 700px;">
                                <? if (count($v_params['regions'])): ?>
                                    <? foreach ($v_params['regions'] as $region): ?>
                                        <div style="width: 300px; float: left; margin-left: 40px;">
                                            <a href="?code=<?= $region['code']; ?>"><?= $region['name']; ?></a>
                                        </div>
                                    <? endforeach; ?>
                                <? endif; ?>
                            </div>
                        <? endif; ?>


                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . '/../blocks/com_footer.php'; ?>
        </div>
    </body>
</html>
