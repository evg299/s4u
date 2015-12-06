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
                        <form name="add_form" method="POST">
                            <table class="sc_block_content_table">
                                <tr>
                                    <td class="sc_contact_name">
                                        Название
                                    </td>
                                    <td>
                                        <input type="text" name="img_cat_name" style="width: 400px;" value="<? echo $v_params['img_blog_cat']['name']; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        Родительский блок
                                    </td>
                                    <td>
                                        <select name="parent_cat">
                                            <option <? if(!$v_params['img_blog_cat']['pid']) { echo "selected"; } ?> value="">Нет родительской</option>
                                            <? foreach ($v_params['img_blog_cats'] as $imgBlogcat): ?>
                                                <option <? if($v_params['img_blog_cat']['pid'] == $imgBlogcat['id']) { echo "selected"; } ?> value="<? echo $imgBlogcat['id']; ?>"><? echo $imgBlogcat['name']; ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <div class="button" style="width: 70px; margin: 3px auto;"><a class="a_clear" onclick="document.forms['add_form'].submit();">Сохранить</a></div>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
