<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name']; ?> | Супер Админский блок | Новости</title>
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
                    <? require_once dirname(__FILE__) . "/../../blocks/super_navigation.php"; ?>
                </td>
                <td id="center">
                    <div class="sc_block" style="text-align: right;">
                        <a href="/superAdmin/logout">Выйти</a>
                    </div>
                    <div class="sc_block">
                        <a href="newsArt?act=add"><div class="button" style="width: 120px;">Написать новость-статью</div></a>
                    </div>
                    <div class="sc_block">
                        <div class="sc_block_head">
                            Поиск новость-статей
                        </div>
                        <div style="text-align: center; margin: 9px auto;">
                            <form name="search_form" method="get">
                                <table class="sc_block_content_table">
                                    <tr>
                                        <td align="right" style="font-weight: bold;">Категория:</td>
                                        <td align="left">
                                            <select name="cat" style="width: 180px;">
                                                <option <? if(!$_REQUEST["cat"]) { echo "selected"; } ?> value="">Все</option>
                                                <? foreach ($v_params['img_blog_cats'] as $imgBlogcat): ?>
                                                    <option <? if($_REQUEST["cat"] == $imgBlogcat['id']) { echo "selected"; } ?> value="<? echo $imgBlogcat['id']; ?>"><? echo $imgBlogcat['name']; ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" style="font-weight: bold;">Часть названия:</td>
                                        <td align="left"><input style="width: 300px;" name="pname" type="text" value="<? echo $_REQUEST["pname"]; ?>" /></td>
                                    </tr>
                                </table>
                                <div class="button" style="width: 120px; margin: 3px auto; margin-top: 8px;" onclick="document.forms['search_form'].submit();">Найти</div>
                            </form>
                        </div>
                    </div>
                    
                    <? include dirname(__FILE__) . "/../../blocks/com_paginator.php"; ?>

                    <div class="sc_block">
                        <div class="sc_block_head">
                            Результаты поиска
                        </div>
                        <?  $cnt = count($v_params['img_blog_arts']);
                            $iter = 0;
                            if (0 < $cnt) : ?>
                            <? foreach ($v_params['img_blog_arts'] as $img_blog_art) : ?>
                                <table class="<? if($cnt == ++$iter) {echo "last_preview_table";} else {echo "preview_table";} ?>">
                                    <tr valign="top">
                                        <td style="width: 255px;">
                                            <a href="newsArt?id=<? echo $img_blog_art['id']; ?>&act=upd"><img class="preview_table_img" src="/thumbPicture?<? echo PICT_PARAM_NAME; ?>=<? echo $img_blog_art['main_pict_id']; ?>"  /></a>
                                        </td>
                                        <td>
                                            <div class="blog_text_preview">
                                                <div class="blog_text_title_preview"><a href="newsArt?id=<? echo $img_blog_art['id']; ?>&act=upd"><? echo $img_blog_art['title']; ?></a></div>
                                                <div class="blog_date_preview">
                                                    Дата создания: <?php echo $img_blog_art['c_date']; ?>
                                                </div>
                                                <div>
                                                    <?php echo $img_blog_art['preview']; ?>
                                                </div>
                                                <div class="blog_read_all">
                                                    <a href="newsArt?id=<? echo $img_blog_art['id']; ?>&act=upd">Редактировать >></a>
                                                    <br />
                                                    <a href="newsArt?id=<? echo $img_blog_art['id']; ?>&act=del">Удалить >></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            <? endforeach; ?>
                        <? else: ?>
                            <div style="text-align: center; margin: 9px auto;">
                                Статей соответствующих запросу не найдено
                            </div>
                        <? endif; ?>
                    </div>

                    <? include dirname(__FILE__) . "/../../blocks/com_paginator.php"; ?>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
