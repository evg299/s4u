<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?> | <?= $v_params['action']; ?></title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />

        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
        <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

        <script type="text/javascript">
            var current_img = null;
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
                
                $( "#popup" ).dialog({
                    autoOpen: false,
                    width: 888,
                    modal: true,
                    resizable: false,
                    position: "center"
                });
            });
            
            function GUUID() {
                var S4 = function () {
                    return Math.floor(
                    Math.random() * 0x10000 /* 65536 */
                ).toString(16);
                };
    
                return (S4() + S4() + "-" + S4() + "-" + S4() + "-" + S4() + "-" + S4() + S4() + S4());
            }
            
            function setUUID(){
                $("#gds_code_id").attr("value", GUUID());
            }
            
            function showImgDialog(imgid){
                window.scrollTo(0, 0);
                current_img = imgid;
                $('#popup').dialog('open');
            }
            
            function okImgDialog(){
                if('main' == current_img) {
                    $("#gds_main_img_v").attr("src", "/thumbPicture?pict_id=" + $("#selected_img_id").attr("value"));
                    $("#gds_main_img_id").attr("value", $("#selected_img_id").attr("value"));
                } else if('first' == current_img) {
                    $("#gds_first_img_v").attr("src", "/thumbPicture?pict_id=" + $("#selected_img_id").attr("value"));
                    $("#gds_first_img_id").attr("value", $("#selected_img_id").attr("value"));
                } else if('second' == current_img) {
                    $("#gds_second_img_v").attr("src", "/thumbPicture?pict_id=" + $("#selected_img_id").attr("value"));
                    $("#gds_second_img_id").attr("value", $("#selected_img_id").attr("value"));
                } else if('third' == current_img) {
                    $("#gds_third_img_v").attr("src", "/thumbPicture?pict_id=" + $("#selected_img_id").attr("value"));
                    $("#gds_third_img_id").attr("value", $("#selected_img_id").attr("value"));
                }
                
                $("#albums_accord").accordion("refresh");
                $('#popup').dialog('close');
            }
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
                    <? require_once dirname(__FILE__) . "/../../blocks/img_admin_panel.php"; ?>
                    <br />
                    <? require_once dirname(__FILE__) . "/../../blocks/img_product_categories.php"; ?>
                    <br />
                    <? require_once dirname(__FILE__) . "/../../blocks/img_blog_categories.php"; ?>
                </td>
                <td id="center">
                    <div class="sc_block">
                        <div class="sc_block_head"> 
                            <a href="/<?= IMAG_PREFIX . $_SESSION['imag_id']; ?>/admin/GDSs">Управление товарами</a>
                            >>
                            <?= $v_params['action']; ?>
                        </div>
                    </div>
                    <div class="sc_block">
                        <div class="sc_block_head">
                            Информация о товаре
                        </div>
                        <div style="color: red; text-align: center;">
                            <? if (count($v_params['errors'])): ?>
                                <? foreach ($v_params['errors'] as $error): ?>
                                    <div><?= $error; ?></div>
                                <? endforeach; ?>
                            <? endif; ?>
                        </div>
                        <form name="gds_au_form" method="post">
                            <input type="hidden" name="form" value="gds_au_form" />
                            <div style="text-align: center; margin: 9px auto;">

                                <table class="sc_block_content_table" style="width: 600px;">
                                    <tr>
                                        <td class="first_td">
                                            Название *
                                        </td>
                                        <td>
                                            <input type="text" style="width: 360px;" name="gds_name" value="<?= $v_params['gds_opt']['gds_name']; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first_td">
                                            Цена *
                                        </td>
                                        <td>
                                            <input type="text" style="width: 280px;" name="gds_price_val" value="<?= $v_params['gds_opt']['gds_price_val']; ?>"/>
                                            <select name="gds_price_cur" style="width: 75px;">
                                                <? foreach ($v_params['img_currencies'] as $imgCurrecy): ?>
                                                    <option value="<?= $imgCurrecy['id']; ?>" <? if ($imgCurrecy['id'] == $v_params['gds_opt']['gds_price_cur']) echo "selected"; ?>><?= $imgCurrecy['name']; ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first_td">
                                            Код товара *
                                        </td>
                                        <td>
                                            <input id="gds_code_id" type="text" style="width: 260px;" name="gds_code" value="<?= $v_params['gds_opt']['gds_code']; ?>" />
                                            <input type="button" value="Случайный" onclick="setUUID();" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first_td">
                                            Категория товара *
                                        </td>
                                        <td>
                                            <select name="gds_cat" style="width: 360px;">
                                                <? foreach ($v_params['img_gds_cats'] as $imgGdsCat): ?>
                                                    <option value="<?= $imgGdsCat['id']; ?>" <? if ($imgGdsCat['id'] == $v_params['gds_opt']['gds_cat']) echo "selected"; ?> ><?= $imgGdsCat['name']; ?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first_td">
                                            Главное изображение *
                                        </td>
                                        <td>
                                            <img id="gds_main_img_v" style="max-width: 200px; max-height: 200px; border: 1px solid gray; border-radius: 4px 4px 4px 4px; cursor: pointer;" src="/thumbPicture?pict_id=<?= $v_params['gds_opt']['gds_main_img']; ?>" />
                                            <input id="gds_main_img_id" name="gds_main_img" type="hidden" value="<?= $v_params['gds_opt']['gds_main_img']; ?>" />
                                            <br/>
                                            <a href="#" onclick="showImgDialog('main');">Выбрать</a>
                                        </td>
                                    </tr>
                                </table>

                                <table>
                                    <tr>
                                        <td>
                                            <div style="padding: 8px;"><b>Первое дополнительное изображение</b></div>
                                            <img id="gds_first_img_v" style="max-width: 150px; max-height: 150px; border: 1px solid gray; border-radius: 4px 4px 4px 4px; cursor: pointer;" src="/thumbPicture?pict_id=<? echo $v_params['gds_opt']['gds_first_img']; ?>" />
                                            <input id="gds_first_img_id" name="gds_first_img" type="hidden" value="<? echo $v_params['gds_opt']['gds_first_img']; ?>" />
                                            <br/>
                                            <a href="#" onclick="showImgDialog('first');">Выбрать</a>
                                        </td>
                                        <td>
                                            <div style="padding: 8px;"><b>Второе дополнительное изображение</b></div>
                                            <img id="gds_second_img_v" style="max-width: 150px; max-height: 150px; border: 1px solid gray; border-radius: 4px 4px 4px 4px; cursor: pointer;" src="/thumbPicture?pict_id=<? echo $v_params['gds_opt']['gds_second_img']; ?>" />
                                            <input id="gds_second_img_id" name="gds_second_img" type="hidden" value="<? echo $v_params['gds_opt']['gds_second_img']; ?>" />
                                            <br/>
                                            <a href="#" onclick="showImgDialog('second');">Выбрать</a>
                                        </td>
                                        <td>
                                            <div style="padding: 8px;"><b>Третье дополнительное изображение</b></div>
                                            <img id="gds_third_img_v" style="max-width: 150px; max-height: 150px; border: 1px solid gray; border-radius: 4px 4px 4px 4px; cursor: pointer;" src="/thumbPicture?pict_id=<? echo $v_params['gds_opt']['gds_third_img']; ?>" />
                                            <input id="gds_third_img_id" name="gds_third_img" type="hidden" value="<? echo $v_params['gds_opt']['gds_third_img']; ?>" />
                                            <br/>
                                            <a href="#" onclick="showImgDialog('third');">Выбрать</a>
                                        </td>
                                    </tr>
                                </table>

                                <table class="sc_block_content_table" style="width: 600px;">
                                    <tr>
                                        <td class="first_td">
                                            Характеристики
                                            <div style="font-weight: normal; color: red;">
                                                <b>Формат ввода:</b>
                                                <br />
                                                ключ1: значение1
                                                <br />
                                                ключ2: значение2
                                            </div>
                                            <div style="font-weight: normal;">
                                                <b>Пример:</b>
                                                <br />
                                                Цвет: красный
                                                <br />
                                                Вес: 150г
                                            </div>
                                        </td>
                                        <td>
                                            <textarea name="gds_char_list" style="width: 350px; height: 200px;"><? echo $v_params['gds_opt']['gds_char_list']; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first_td">
                                            Текстовое описание
                                        </td>
                                        <td>
                                            <textarea name="gds_descr" style="width: 350px; height: 200px;"><? echo $v_params['gds_opt']['gds_descr']; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first_td">
                                            Отметить как новый
                                        </td>
                                        <td>
                                            <input name="gds_new" type="checkbox" <? if ($v_params['gds_opt']['gds_new']) echo 'checked'; ?> />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first_td">
                                            Отметить как рекомендуемый
                                        </td>
                                        <td>
                                            <input name="gds_rec" type="checkbox" <? if ($v_params['gds_opt']['gds_rec']) echo 'checked'; ?> />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first_td">
                                            Есть в наличии
                                        </td>
                                        <td>
                                            <input name="gds_in_sale" type="checkbox" <? if ($_POST['form']) {
                                                    if ($v_params['gds_opt']['gds_in_sale']) echo 'checked';
                                                } else echo 'checked'; ?> />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>

                        <div class="art_block" onclick="document.forms['gds_au_form'].submit();" style="width: 120px; text-align: center; cursor: pointer;">
                            <a>Сохранить</a>
                        </div>
                    </div>

                    <div id="popup" style="text-align: center;" title="Выберите изображение">
                        <div>
                            <img id="selected_img" style="min-width: 200px; min-height: 150px; border: 1px solid gray; border-radius: 4px 4px 4px 4px; cursor: pointer;" src="/picture?pict_id=0" />
                        </div>
                        <input id="selected_img_id" type="hidden" />
                        <div class="art_block" onclick="okImgDialog();" style="width: 80px; text-align: center; cursor: pointer;">
                            <a>OK</a>
                        </div>
                        <div id="albums_accord" style="margin: 5px auto; width: 777px;">
                                <? foreach ($v_params['img_albums'] as $img_album): ?>
                                <h3 class="alb_accord"><? echo $img_album['name']; ?></h3>
                                <div>
                                    <?
                                    $count = count($img_album['pictures']);
                                    $subcount = 0;
                                    ?>
                                    <? if ($count) : ?>
                                        <table class="pict_table">
                                            <tr>
                                                <? foreach ($img_album['pictures'] as $img_pict): ?>
                                                    <td>
                                                        <a style="cursor: pointer;">
                                                            <img class="album_pict" pictId="<?= $img_pict['id']; ?>" src="/thumbPicture?<? echo PICT_PARAM_NAME; ?>=<? echo $img_pict['id']; ?>" />
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
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
