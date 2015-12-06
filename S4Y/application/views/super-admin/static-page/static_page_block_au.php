<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name']; ?> | Супер Админский блок | <?= $v_params['act_name']; ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />

        <script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
        <script src="/assets/local/js/ymap2.js" type="text/javascript"></script>

        <link rel="stylesheet" href="/assets/local/css/tabs.css" />
        <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
        <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
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
                
                $("#tabs").tabs({ selected: <? echo $v_params['num_tab']; ?> });
                
                $("#tabs").bind('tabsshow', function(event, ui) {
                    $("#selected_tab").attr("value", ui.index);
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
                    </div>
                    <div class="sc_block">
                        <div class="sc_block_head">
                            Выберите тип блока статьи
                        </div>

                        <form name="send_block_form" method="post">
                            <input type="hidden" name="send_block_form" value="true" />
                            <input type="hidden" id="selected_tab" name="selected_tab" value="<? echo $v_params['num_tab']; ?>" />
                            <div id="tabs" style="margin-top: 9px;">
                                <ul>
                                    <li><a href="#tabs-1">Текст</a></li>
                                    <li><a href="#tabs-2">Изображение</a></li>
                                    <li><a href="#tabs-3">Элемент списка</a></li>
                                </ul>
                                <div id="tabs-1">
                                    <textarea name="text_content_t" style="margin: 3px;  width: 680px; height: 500px;"><? echo $v_params['ssp_block']['text_content']; ?></textarea>
                                </div>
                                <div id="tabs-2">
                                    <div align="center">
                                        <img id="selected_img" style="margin: 0 auto; 
                                             border: solid gray 1px;
                                             -webkit-border-radius: 4px;
                                             -moz-border-radius: 4px;
                                             border-radius: 4px;
                                             min-height: 100px;
                                             min-width: 100px;" src="/thumbPicture?pict_id=<? echo $v_params['ssp_block']['image_id']; ?>" />
                                        <input id="selected_img_id" type="hidden" name="pict_id" value="<? echo $v_params['ssp_block']['image_id']; ?>" />
                                    </div>

                                    <div>Подпись изображения</div>
                                    <input type="text" name="img_desk" style="margin: 3px;  width: 680px;" value="<? echo $v_params['ssp_block']['image_title']; ?>"/>

                                    <br /><br />

                                    <div id="albums_accord" style="width: 680px;">
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
                                                                if (2 < $subcount++) {
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
                                </div>
                                <div id="tabs-3">
                                    <textarea name="text_content" style="margin: 3px;  width: 680px; height: 500px; background-color: gainsboro;"><? echo $v_params['ssp_block']['text_content']; ?></textarea>
                                </div>
                            </div>
                            <table style="margin: 0 auto;">
                                <tr>
                                    <td>Порядковый номер в статье</td>
                                    <td><input style="width: 100px;" type="number" name="order" value="<? echo $v_params['ssp_block']['order_in_page']; ?>"></td>
                                </tr>
                            </table>
                            <div class="art_block" style="width: 120px; text-align: center;"><a style="cursor: pointer;" onclick="document.forms['send_block_form'].submit();">Сохранить</a></div>
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
