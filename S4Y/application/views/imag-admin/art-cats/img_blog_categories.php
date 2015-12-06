<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?> | <? echo $v_params['actname']; ?></title>
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
                            <? echo $v_params['actname']; ?>
                        </div>
                        <div style="padding-top: 10px; margin: 0 13px;">
                            <? $line_number = 1; ?>
                            <? if (count($v_params['img_blog_cats'])): ?>
                                <? foreach ($v_params['img_blog_cats'] as $imgBlogcat): ?>
                                    <div style="margin-bottom: 15px; padding-bottom: 5px; border-bottom: dotted 1px gainsboro;">
                                        <div><a href="<? echo $v_params['url_prefix'] . "ARTs?cat=" . $imgBlogcat['id']; ?>"><h3><? echo $line_number++ . ". " . $imgBlogcat['name']; ?></h3></a></div>
                                        <div style="text-align: right;"><a href="<? echo $v_params['url_prefix'] . "ARTcat?act=upd&ARTcat_id=" . $imgBlogcat['id']; ?>">Изменить</a></div>
                                        <div style="text-align: right;"><a href="<? echo $v_params['url_prefix'] . "ARTcat?act=del&ARTcat_id=" . $imgBlogcat['id']; ?>">Удалить</a></div>
                                    </div>
                                <? endforeach; ?>
                            <? endif; ?>
                        </div>
                        <div class="button" style="width: 70px; margin: 3px auto;"><a class="a_clear" href="<? echo $v_params['url_prefix'] . "ARTcat?act=add"; ?>">Создать</a></div>
                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
