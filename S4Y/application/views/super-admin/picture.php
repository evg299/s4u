<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $v_params['sys_name']; ?> | Супер Админский блок | Просмотр изображения</title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/local/css/alll.css" />
    </head>
    <body>
        <div id="header">
            <? require_once dirname(__FILE__) . "/../blocks/com_name_logo.php"; ?>
            <? require_once dirname(__FILE__) . "/../blocks/com_main_menu.php"; ?>
        </div>
        <table id="wraper">
            <tr style="vertical-align: top;">
                <td id="left">
                    <? require_once dirname(__FILE__) . "/../blocks/super_navigation.php"; ?>
                </td>
                <td id="center">
                    <div class="sc_block" style="text-align: right;">
                        <a href="/superAdmin/logout">Выйти</a>
                    </div>

                    <div class="sc_block">
                        <div class="sc_block_head"> 
                            <a href="/superAdmin/albums">Альбомы</a>
                            >>
                            <a href="/superAdmin/album?act=show<? echo $v_params['img_album_add_link']; ?>"><? echo $v_params['img_album_name']; ?></a>
                        </div>
                    </div>

                    <div class="sc_block">
                        <div class="sc_block_head">
                            Выбраное изображение
                        </div>
                        <div style="padding-top: 10px; margin: 0 13px; text-align: center;">
                            <a href="/picture?<? echo PICT_PARAM_NAME; ?>=<? echo $v_params['picture']['id']; ?>" target="blank">
                                <img style="max-width: 666px;" class="img_default" src="/picture?<? echo PICT_PARAM_NAME; ?>=<? echo $v_params['picture']['id']; ?>" />
                            </a>

                            <form name="pict_del_form" method="post">
                                <table class="sc_block_content_table" style="width: 300px;">
                                    <tr>
                                        <td class="sc_contact_name">
                                            Название
                                        </td>
                                        <td>
                                            <? echo $v_params['picture']['name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sc_contact_name">
                                            Удалить
                                        </td>
                                        <td>
                                            <input id="del_cb" type="checkbox" name="del_check" />
                                        </td>
                                    </tr>
                                </table>

                                <div class="button" style="width: 120px; margin: 3px auto; margin-top: 8px;" onclick="sendDelForm();">Выполнить удаление</div>
                                <script type="text/javascript">
                                    function sendDelForm(){
                                        var checkboxElement = document.getElementById("del_cb");
                                        if(checkboxElement.checked){
                                            document.forms['pict_del_form'].submit();
                                        }
                                    }
                                </script>
                            </form>
                        </div>

                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <? require_once dirname(__FILE__) . "/../blocks/com_footer.php"; ?>
        </div>
    </body>
</html>
