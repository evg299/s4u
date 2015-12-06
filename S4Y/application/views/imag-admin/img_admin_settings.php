<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name'] ?> | <?= $v_params['img_name']; ?> | Основные настройки</title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#region_select").change(function(){
                    var curr_reg = $("#region_select").val();
                    if("77" == curr_reg || "78" == curr_reg){
                        $("#city_input").val("");
                        $("#city_input").attr('disabled', '');
                    } else {
                        $("#city_input").removeAttr('disabled');
                    }
                });
            });
        </script>
    </head>
    <body>
        <div id="header">
            <? require_once dirname(__FILE__) . "/../blocks/com_name_logo.php"; ?>
            <? require_once dirname(__FILE__) . "/../blocks/com_main_menu.php"; ?>
        </div>
        <table id="wraper">
            <tr style="vertical-align: top;">
                <td id="left">
                    <? require_once dirname(__FILE__) . "/../blocks/img_admin_panel.php"; ?>
                    <br />
                    <? require_once dirname(__FILE__) . "/../blocks/img_product_categories.php"; ?>
                    <br />
                    <? require_once dirname(__FILE__) . "/../blocks/img_blog_categories.php"; ?>
                </td>
                <td id="center">
                    <div id="messages" style="margin-bottom: 15px; color: red; text-align: center;">
                        <? if (count($v_params['errors'])): ?>
                            <? foreach ($v_params['errors'] as $error): ?>
                                <div>
                                    <?= $error; ?>
                                </div>
                            <? endforeach; ?>
                        <? endif ?>
                    </div>
                    
                    <div id="messages" style="margin-bottom: 15px; color: green; text-align: center;">
                        <?= $v_params['result_text']; ?>
                    </div>

                    <div class="sc_block">
                        <div class="sc_block_head">
                            Название
                        </div>
                        <form name="name_form" method="post">
                            <input type="hidden" name="name_form" value="name_form" />
                            <table class="sc_block_content_table">
                                <tr>
                                    <td class="sc_contact_name">
                                        Имя
                                    </td>
                                    <td>
                                        <input type="text" name="img_name" style="width: 400px;" value="<?= $v_params['img_name']; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        Слоган
                                    </td>
                                    <td>
                                        <input type="text" name="img_slog" style="width: 400px;" value="<?= $v_params['img_slog']; ?>" />
                                    </td>
                                </tr>
                            </table>
                            <div class="button" style="width: 60px; margin: 3px auto;" onclick="document.forms['name_form'].submit();">Сохранить</div>
                        </form>
                    </div>

                    <div class="sc_block">
                        <div class="sc_block_head">
                            Контактная информация
                        </div>
                        <form name="contacts_form" method="post">
                            <input type="hidden" name="contacts_form" value="contacts_form" />
                            <table class="sc_block_content_table">
                                <tr>
                                    <td class="sc_contact_name">
                                        Адрес
                                    </td>
                                    <td>
                                        Регион
                                        <br />
                                        <select id="region_select" name="addr_region" style="width: 400px;">
                                            <? if (isset($v_params['img_region_code'])): ?>
                                                <option value="">Вся Россия</option>
                                            <? else: ?>
                                                <option selected value="">Вся Россия</option>
                                            <? endif; ?>

                                            <? foreach ($v_params['addr_regions'] as $addrRegion): ?>
                                                <? if ($addrRegion['code'] == $v_params['img_region_code']): ?>
                                                    <option selected value="<?= $addrRegion['code']; ?>"><?= $addrRegion['name']; ?></option>
                                                <? else: ?>
                                                    <option value="<?= $addrRegion['code']; ?>"><?= $addrRegion['name']; ?></option>
                                                <? endif; ?>
                                            <? endforeach; ?>
                                        </select>
                                        <br />
                                        Город (Например: Самара, Долгопрудный)
                                        <br />
                                        <input id="city_input" type="text" name="addr_city" style="width: 400px;" value="<? if (!$v_params['img_sity_disabled']) echo $v_params['img_sity']; ?>" <? if ($v_params['img_sity_disabled']) echo "disabled"; ?> />
                                        <br />
                                        Улица (Например: Московское шоссе, проспект Вернадского, Дубровская)
                                        <br />
                                        <input type="text" name="addr_street" style="width: 400px;" value="<?= $v_params['img_street']; ?>" />
                                        <br />
                                        Дом (Например: 3, 5к2)
                                        <br />
                                        <input type="text" name="addr_house" style="width: 400px;" value="<?= $v_params['img_house']; ?>" />
                                    </td>
                                    <td>
                                        <input type="checkbox" <? if ($v_params['img_address_show']) echo "checked"; ?> name="addr_show" title="Отображать пользователю"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        Телефон
                                    </td>
                                    <td>
                                        <input type="tel" name="phone_phone" style="width: 400px;" value="<?= $v_params['img_phone']; ?>" />
                                    </td>
                                    <td>
                                        <input type="checkbox" <? if ($v_params['img_phone_show']) echo "checked"; ?> name="phone_show" title="Отображать пользователю" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        skype
                                    </td>
                                    <td>
                                        <input type="text" name="skype_skype" style="width: 400px;" value="<?= $v_params['img_skype']; ?>" />
                                    </td>
                                    <td>
                                        <input type="checkbox" <? if ($v_params['img_skype_show']) echo "checked"; ?> name="skype_show" title="Отображать пользователю"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        ICQ
                                    </td>
                                    <td>
                                        <input type="text" name="icq_icq" style="width: 400px;" value="<?= $v_params['img_icq']; ?>" />
                                    </td>
                                    <td>
                                        <input type="checkbox" <? if ($v_params['img_icq_show']) echo "checked"; ?> name="icq_show"  title="Отображать пользователю"/>
                                    </td>
                                </tr>
                            </table>
                            <div class="button" style="width: 60px; margin: 3px auto;" onclick="document.forms['contacts_form'].submit();">Сохранить</div>
                        </form>
                    </div>

                    <div class="sc_block">
                        <div class="sc_block_head">
                            Пароль к аккаунту
                        </div>
                        <form name="pass_form" method="post">
                            <input type="hidden" name="pass_form" value="pass_form" />
                            <table class="sc_block_content_table">
                                <tr>
                                    <td class="sc_contact_name">
                                        Текущий пароль
                                    </td>
                                    <td>
                                        <input type="password" name="pass_old" style="width: 400px;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        Новый пароль
                                    </td>
                                    <td>
                                        <input type="password" name="pass_new" style="width: 400px;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="sc_contact_name">
                                        Повторите новый пароль
                                    </td>
                                    <td>
                                        <input type="password" name="pass_new2" style="width: 400px;"  />
                                    </td>
                                </tr>
                            </table>
                            <div class="button" style="width: 60px; margin: 3px auto;" onclick="document.forms['pass_form'].submit();">Сохранить</div>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
