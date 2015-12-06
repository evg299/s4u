<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name']; ?> | Супер Админский блок | <?= $v_params['act_name']; ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />
        <link rel="stylesheet" href="/assets/local/css/tabs.css" />
        <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
        <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

        <script type="text/javascript">
            $(function() {
                $("#albums_accord" ).accordion({
                    autoHeight: false,
                    active: false,
                    collapsible: true 
                });
                
                $(".album_pict").click(function(){
                    var pictid = this.attributes['pictid']['value'];                    
                    $("#selected_img").attr("src", "/thumbPicture?pict_id=" + pictid);
                    $("#selected_img_id").attr("value", pictid);
                });
            });
        </script>
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
                        <div class="sc_block_head">
                            <? echo $v_params['act_name']; ?>
                        </div>
                        <div style="text-align: center; margin: 9px auto;">
                            <div align="center" style="color: red;">
                                <? echo $v_params['error_msg']; ?>
                            </div>
                            <form name="add_head_form" method="post">
                                <input type="hidden" name="add_head_form" value="true" />
                                <table class="sc_block_content_table" style="width: 100%;">
                                    <tr>
                                        <td align="right" style="font-weight: bold; width: 100px;">Название</td>
                                        <td align="left"><input style="width: 550px;" name="art_name" type="text" value="<? echo $v_params['img_news_art']['title']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td align="right" style="font-weight: bold; width: 100px;">Категория</td>
                                        <td align="left">
                                            <select name="cat_id" style="width: 550px;">
                                                <? foreach ($v_params['img_blog_cats'] as $imgBlogcat): ?>
                                                    <option <? if($v_params['img_news_art']['sys_news_cat_id'] == $imgBlogcat['id']): ?>selected<? endif; ?> value="<? echo $imgBlogcat['id']; ?>"><? echo $imgBlogcat['name']; ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" style="font-weight: bold; width: 100px;">Изображение</td>
                                        <td align="left">
                                            <div align="center">
                                                <img id="selected_img" style="margin: 0 auto; 
                                                     border: solid gray 1px;
                                                     -webkit-border-radius: 4px;
                                                     -moz-border-radius: 4px;
                                                     border-radius: 4px;
                                                     min-height: 100px;
                                                     min-width: 100px;" src="/thumbPicture?pict_id=<? echo $v_params['img_news_art']['main_pict_id']; ?>" />
                                                <input id="selected_img_id" type="hidden" name="pict_id" value="<? echo $v_params['img_news_art']['main_pict_id']; ?>" />
                                            </div>

                                            <div id="albums_accord">
                                                <? foreach ($v_params['img_albums'] as $img_album): ?>
                                                    <h3 class="alb_accord"><? echo $img_album['name']; ?></h3>
                                                    <div>
                                                        <?
                                                        $count = count($img_album['pictures']);
                                                        $subcount = 0;
                                                        ?>
                                                        <? if (0 < $count) : ?>
                                                            <table class="pict_table">
                                                                <tr>
                                                                    <? foreach ($img_album['pictures'] as $img_pict): ?>
                                                                        <td>
                                                                            <a style="cursor: pointer;">
                                                                                <img class="album_pict" pictId="<? echo $img_pict['id']; ?>" src="/thumbPicture?<? echo PICT_PARAM_NAME; ?>=<? echo $img_pict['id']; ?>" />
                                                                            </a>
                                                                        </td>
                                                                        <?
                                                                        if (1 < $subcount++) {
                                                                            $subcount = 0;
                                                                            echo "</tr> <tr>";
                                                                        }
                                                                        ?>
                                                                    <? endforeach; ?>
                                                                </tr>
                                                            </table>
                                                        <? else: ?>
                                                            <div style="text-align: center; margin: 9px auto;">
                                                                Изображений в альбом пока не добавлено
                                                            </div>
                                                        <? endif; ?>
                                                    </div>
                                                <? endforeach; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" style="font-weight: bold; width: 100px;">Превью</td>
                                        <td align="left"><textarea name="preview" style="width: 550px;" rows="8"><? echo $v_params['img_news_art']['preview']; ?></textarea></td>
                                    </tr>
                                </table>

                                <div class="art_block" style="width: 120px; text-align: center; cursor: pointer;" onclick="document.forms['add_head_form'].submit();"><a>Сохранить</a></div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="sc_block">
                        <div class="sc_block_head">
                            Содержимое новости
                        </div>

                        <?php if (0 != count($v_params['ssp_blocks'])): ?>
                            <?php foreach ($v_params['ssp_blocks'] as $sspBlock) : ?>
                                <?php if (0 == $sspBlock['block_type']) : ?>
                                    <div class="art_block">
                                        <div>Порядковый номер: <? echo $sspBlock['order_in_art']; ?></div>
                                        <div style="text-align: center; margin-top: 15px;">
                                            <a href="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $sspBlock['image_id']; ?>" target="blank"><img  class="blog_img" src="/picture?<?php echo PICT_PARAM_NAME; ?>=<?php echo $sspBlock['image_id']; ?>" /></a>
                                            <div style="font-size: small;"><?php echo $sspBlock['image_title']; ?></div>
                                        </div>
                                        <div align="right"><a href="newsBlock?id=<?php echo $sspBlock['id']; ?>&act=upd&corresp=<? echo $v_params['img_news_art']['id']; ?>">Редактировать</a> 
                                            <a href="newsBlock?id=<?php echo $sspBlock['id']; ?>&act=del&corresp=<? echo $v_params['img_news_art']['id']; ?>">Удалить</a></div>
                                    </div>
                                <?php elseif (1 == $sspBlock['block_type']) : ?>
                                    <div class="art_block">
                                        <div>Порядковый номер: <? echo $sspBlock['order_in_art']; ?></div>
                                        <p><?php echo $sspBlock['text_content']; ?></p>
                                        <div align="right"><a href="newsBlock?id=<?php echo $sspBlock['id']; ?>&act=upd&corresp=<? echo $v_params['img_news_art']['id']; ?>">Редактировать</a> 
                                            <a href="newsBlock?id=<?php echo $sspBlock['id']; ?>&act=del&corresp=<? echo $v_params['img_news_art']['id']; ?>">Удалить</a></div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="text-align: center;">В эту страницу еще не добавлено блоков</p>
                        <?php endif; ?>

                        <div class="art_block" style="width: 120px; text-align: center;"><a href="newsBlock?act=add&corresp=<? echo $v_params['img_news_art']['id']; ?>">Добавить блок</a></div>
                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
